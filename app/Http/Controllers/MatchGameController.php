<?php

namespace App\Http\Controllers;

use App\Http\Requests\MatchGameRequest;
use App\Http\Resources\MatchGameResource;
use App\Models\MatchGame;
use App\Models\User;
use App\Notifications\SendRejectMatchNotification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Notification;

class MatchGameController extends Controller
{
    public function index(Request $request)
    {
        $matchGames = MatchGame::with(['reservation.venue', 'reservation.user', 'users']);

        if ($request->has('user')) {
            $matchGames->whereHas('users', function (Builder $query) {
                $query->where('user_id', auth()->id());
            });

            return MatchGameResource::collection($matchGames->paginate(5));
        }

        if ($request->filled('type')) {
            $sport_type_id = $request->type;
            $matchGames->whereHas('reservation.venue', function (Builder $query) use ($sport_type_id) {
                $query->where('sport_type_id', $sport_type_id);
            });

            return MatchGameResource::collection($matchGames->paginate(6));
        }

        if ($request->has('no-opponent')) {
            $matchGames->where('is_requested', 0);

            return MatchGameResource::collection($matchGames->paginate(5)->appends('users'));
        }

        return MatchGameResource::collection($matchGames->paginate(5));
    }

    public function store(MatchGameRequest $request)
    {
        $validated = $request->validated();

        $match_game = MatchGame::create($validated);

        $match_game->users()->attach(auth()->id());

        return response()->noContent();
    }

    public function show(MatchGame $matchGame)
    {
        $matchGame->load(['reservation', 'users']);

        return new MatchGameResource($matchGame);
    }

    public function destroy(MatchGame $matchGame)
    {
        Gate::authorize('delete', $matchGame);

//        if ($matchGame->is_accepted === 1 || $matchGame->is_requested === 1) {
//            $home_team = $matchGame->reservation->user_id;
//            $away_team = $matchGame->users()->whereNot("user_id", $home_team)->first();
//            Notification::send($away_team, new CancelMatchGameNotification());
//        }

        $matchGame->delete();
        $matchGame->reservation()->update(["find_team" => 0]);

        return response()->noContent();
    }

    public function update(MatchGame $matchGame)
    {
        Gate::authorize('update', $matchGame);

        $matchGame->update([
            "is_requested" => 1,
        ]);

        $matchGame->users()->attach(auth()->id());

        return response()->noContent();
    }

    public function accepting(MatchGame $matchGame)
    {
        Gate::authorize('accepting', $matchGame);

        $matchGame->update([
            "is_accepted" => 1,
        ]);

        return response()->noContent();
    }

    public function reject(MatchGame $matchGame, User $user)
    {
        Gate::authorize('delete', $matchGame);

        $matchGame->update([
            "is_requested" => 0,
        ]);

        $matchGame->users()->detach($user);

        Notification::send($user, new SendRejectMatchNotification());

        return response()->noContent();
    }
}
