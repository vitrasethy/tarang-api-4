<?php

namespace App\Http\Controllers;

use App\Http\Requests\TempRecruitmentRequest;
use App\Http\Resources\TempRecruitmentCollection;
use App\Http\Resources\TempRecruitmentResource;
use App\Models\TempRecruitment;

class TempRecruitmentController extends Controller
{
    public function index()
    {
        return new TempRecruitmentCollection(TempRecruitment::with(['team', 'user'])->get());
    }

    public function store(TempRecruitmentRequest $request)
    {
        TempRecruitment::create($request->validated());

        return response()->noContent();
    }

    public function show(TempRecruitment $tempRecruitment)
    {
        $tempRecruitment->load(['team', 'user']);

        return new TempRecruitmentResource($tempRecruitment);
    }

    public function update(TempRecruitmentRequest $request, TempRecruitment $tempRecruitment)
    {
        $tempRecruitment->update($request->validated());

        return response()->noContent();
    }

    public function destroy(TempRecruitment $tempRecruitment)
    {
        $tempRecruitment->delete();

        return response()->noContent();
    }
}
