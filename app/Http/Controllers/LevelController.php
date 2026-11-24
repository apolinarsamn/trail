<?php

namespace App\Http\Controllers;

use App\Models\MembershipLevel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LevelController extends Controller
{
    public function index()
    {
        $levels = MembershipLevel::orderBy('fee')->get();

        return view('admin.levels.index', compact('levels'));
    }

    public function create()
    {
        return view('admin.levels.create', [
            'level' => new MembershipLevel(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:membership_levels,name'],
            'fee' => ['required', 'numeric', 'min:0'],
            'validity_months' => ['required', 'integer', 'min:1', 'max:120'],
            'benefits' => ['nullable', 'string', 'max:3000'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        MembershipLevel::create($validated);

        return redirect()
            ->route('admin.levels.index')
            ->with('success', 'Membership level created successfully.');
    }

    public function edit(MembershipLevel $level)
    {
        return view('admin.levels.edit', compact('level'));
    }

    public function update(Request $request, MembershipLevel $level)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('membership_levels', 'name')->ignore($level->id),
            ],
            'fee' => ['required', 'numeric', 'min:0'],
            'validity_months' => ['required', 'integer', 'min:1', 'max:120'],
            'benefits' => ['nullable', 'string', 'max:3000'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $level->update($validated);

        return redirect()
            ->route('admin.levels.index')
            ->with('success', 'Membership level updated successfully.');
    }

    public function destroy(MembershipLevel $level)
    {
        $level->update([
            'is_active' => false,
        ]);

        return redirect()
            ->route('admin.levels.index')
            ->with('success', 'Membership level deactivated successfully.');
    }
}