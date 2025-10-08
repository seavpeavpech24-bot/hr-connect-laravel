<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\Position;
use Illuminate\Http\Request;

class ApplicantController extends Controller
{
    public function index()
    {
        $applicants = Applicant::with('position')->latest()->get();
        $jobPositions = Position::orderBy('title')->get();

        return view('applicants', compact('applicants', 'jobPositions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:applicants,email',
            'phone' => 'nullable|string|max:20',
            'applied_position_id' => 'nullable|exists:positions,id',
            'status' => 'required|in:pending,reviewed,rejected,approved,interviewed',
            'source' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        Applicant::create($request->all());

        return redirect()->route('applicants.index')->with('success', 'Applicant added successfully.');
    }

    public function show(Applicant $applicant)
    {
        // Load full relations (add files and history once models are created)
        $applicant->load(['position', 'files', 'messageHistory']); // messageHistory: add relationship in model

        return view('applicants.show', compact('applicant'));
    }

    public function edit(Applicant $applicant)
    {
        $jobPositions = Position::orderBy('title')->get();
        $applicant->load('position'); // For pre-selecting

        return view('applicants.edit', compact('applicant', 'jobPositions'));
    }

    public function update(Request $request, Applicant $applicant)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:applicants,email,' . $applicant->id,
            'phone' => 'nullable|string|max:20',
            'applied_position_id' => 'nullable|exists:positions,id',
            'status' => 'required|in:pending,reviewed,rejected,approved,interviewed',
            'source' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $applicant->update($request->all());

        return redirect()->route('applicants.index')->with('success', 'Applicant updated successfully.');
    }

    public function destroy(Applicant $applicant)
    {
        $applicant->delete();

        return redirect()->route('applicants.index')->with('success', 'Applicant deleted successfully.');
    }
}