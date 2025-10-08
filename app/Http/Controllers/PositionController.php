<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:positions,title',
        ]);

        Position::create($request->only('title')); // UUID auto-generated now

        return redirect()->back()->with('success', 'Position added successfully.');
    }

    public function destroy(Position $position)
    {
        // Soft delete or cascade handled by migration (onDelete('set null') for applicants)
        $position->delete();

        return redirect()->back()->with('success', 'Position deleted successfully.');
    }
}