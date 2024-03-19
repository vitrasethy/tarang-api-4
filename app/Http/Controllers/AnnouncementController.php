<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnnouncementRequest;
use App\Http\Resources\AnnouncementResource;
use App\Models\Announcement;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::with(['team', 'reservation'])->get();

        return AnnouncementResource::collection($announcements);
    }

    public function store(AnnouncementRequest $request)
    {
        Announcement::create($request->validated());

        return response()->noContent();
    }

    public function show(Announcement $announcement)
    {
        $announcement->load(['team', 'reservation']);

        return new AnnouncementResource($announcement);
    }

    public function update(AnnouncementRequest $request, Announcement $announcement)
    {
        $announcement->update($request->validated());

        return response()->noContent();
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();

        return response()->noContent();
    }
}
