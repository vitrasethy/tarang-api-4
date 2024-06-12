<?php

namespace App\Http\Controllers;

use App\Http\Requests\FindReservationRequest;
use App\Http\Requests\ReservationReportRequest;
use App\Http\Requests\ReservationRequest;
use App\Http\Resources\ReservationCollection;
use App\Http\Resources\ReservationResource;
use App\Models\Reservation;
use App\Notifications\SendReminderSMS;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Notification;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $query = Reservation::with(["venue.sportType", "user", "matchGame.users"]);

        // Return all data without pagination if 'all' parameter is present
        if ($request->has('all')) {
            return ReservationResource::collection($query->latest()->get());
        }

        // Apply filters based on 'date' and 'type' parameters
        if ($request->filled('date')) {
            $query->where('date', $request->date);
        }

        if ($request->filled('type')) {
            $query->whereHas('venue.sportType', function (Builder $builder) use ($request) {
                $builder->where('id', $request->type);
            });
        }

        // Paginate the results and append query parameters for pagination links
        $reservation = $query->latest()->paginate(5)->appends($request->only('date', 'type'));

        return ReservationResource::collection($reservation);
    }

    public function store(ReservationRequest $request)
    {
        $validated = $request->validated();

        $is_reservation_exist = $this->is_reservation_exist(
            $validated['date'],
            $validated['start_time'],
            $validated['end_time'],
            $validated['venue_id']
        );

        if ($is_reservation_exist) {
            return response()->json([
                "message" => "We couldn't create the item because the data already exists.",
            ], 409);
        }

        $reservation = Reservation::create([
            ...$validated,
            "user_id" => auth()->id(),
        ]);

        $user = auth()->user();
        $delay = now()->addMinute();

        Notification::send($user, (new SendReminderSMS())->delay($delay));

        return new ReservationResource($reservation);
    }

    private function is_reservation_exist($date, $start_time, $end_time, $venue_id, $reservation_id = null)
    {
        $date_str = Carbon::parse($date)->toDateString();
        $start_time_str = Carbon::parse($start_time)->toTimeString();
        $end_time_str = Carbon::parse($end_time)->toTimeString();

        $reservation = Reservation::where([
            ['date', '=', $date_str],
            ['venue_id', '=', $venue_id],
        ]);

        if ($reservation_id !== null) {
            $reservation->where('id', '!=', $reservation_id);
        }

        return $reservation->where(function ($query) use ($start_time_str, $end_time_str) {
            $query->where([
                ['start_time', '<=', $start_time_str],
                ['end_time', '>', $start_time_str],
            ])->orWhere([
                ['start_time', '<', $end_time_str],
                ['end_time', '>=', $end_time_str],
            ])->orWhere([
                ['start_time', '>=', $start_time_str],
                ['end_time', '<=', $end_time_str],
            ]);
        })->exists();
    }

    public function show(Reservation $reservation)
    {
        $reservation->load(["venue", "user"]);

        return new ReservationResource($reservation);
    }

    public function update(ReservationRequest $request, Reservation $reservation)
    {
        Gate::authorize('update', $reservation);

        $validated = $request->validated();

        $is_reservation_exist = $this->is_reservation_exist(
            $validated['date'],
            $validated['start_time'],
            $validated['end_time'],
            $validated['venue_id'],
            $reservation->id,
        );

        if ($is_reservation_exist) {
            return response()->json([
                'message' => 'Time not available for reservation',
            ], 403);
        }

        $reservation->update($validated);

        return response()->noContent();
    }

    public function destroy(Reservation $reservation)
    {
        Gate::authorize('delete', $reservation);

        $reservation_date = Carbon::parse($reservation->date);

        if ($reservation_date->subDay()->lessThan(Carbon::now())) {
            return response()->json([
                "message" => "Can't delete before one day",
            ], 420);
        }

        $reservation->delete();

        return response()->noContent();
    }

    public function show_user(Request $request)
    {
        $query = Reservation::with(["venue.sportType", "user", "matchGame.users"])
            ->where("user_id", auth()->id())->latest();

        $reservations = $request->has('all')
            ? $query->get()
            : $query->paginate(5);

        return new ReservationCollection($reservations);
    }

    public function find_reservation(FindReservationRequest $request)
    {
        $validated = $request->validated();

        $reservation = $this->is_reservation_exist(
            $validated['date'],
            $validated['start_time'],
            $validated['end_time'],
            $validated['venue_id']
        );

        return response()->json([
            'is_founded' => !$reservation,
        ]);
    }

    // get report of reservation base custom date
    public function custom_report(ReservationReportRequest $request)
    {
        Gate::authorize('viewAdmin', Reservation::class);

        $validated = $request->validated();

        return response()->json([
            "count" => Reservation::whereBetween('date', [$validated['start_date'], $validated['end_time']])
                ->count(),
        ]);
    }

    // get report with range one month
    public function report()
    {
        Gate::authorize('viewAdmin', Reservation::class);

        $reservation_one_month = Reservation::whereBetween(
            'date', [now()->subMonth()->format('Y-m-d'), now()->format('Y-m-d')])->count();

        return response()->json([
            "count" => $reservation_one_month,
        ]);
    }

    // get reservation that not play yet
    public function pending()
    {
        Gate::authorize('viewAdmin', Reservation::class);

        return Reservation::where('date', '>', now())->get();
    }

    // get reservation for this month or any month
    public function get_month_reservation(Request $request)
    {
        Gate::authorize('viewAdmin', Reservation::class);

        $year = Carbon::now()->year;
        $query = Reservation::with(["venue.sportType", "user", "matchGame.users"]);

        if ($request->filled('month')) {
            $month = $request->month;
        } else {
            $month = Carbon::now()->month;
        }

        $reservation = $query->whereMonth('date', $month)->whereYear('date', $year)->get();

        return ReservationResource::collection($reservation);
    }
}
