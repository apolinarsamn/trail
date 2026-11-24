<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $members = Member::query()
            ->when($request->search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('membership_number', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($request->category, function ($query, $category) {
                $query->where('membership_category', $category);
            })
            ->when($request->level, function ($query, $level) {
                $query->where('membership_level', $level);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('members.index', compact('members'));
    }

    public function create()
    {
        return view('members.create', [
            'member' => new Member(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:members,email',
            'phone_number' => 'nullable|string|max:30',
            'address' => 'nullable|string|max:500',
            'membership_category' => 'required|in:Student,Regular,Senior Citizen,Corporate',
            'membership_level' => 'required|in:Basic,Silver,Gold,Platinum',
            'birth_date' => 'nullable|date|before:today',
            'status' => 'required|in:Active,Inactive',
        ]);

        Member::create($validated);

        return redirect()
            ->route('members.index')
            ->with('success', 'Member registered successfully.');
    }

    public function show(Member $member)
    {
        return view('members.show', compact('member'));
    }

    public function edit(Member $member)
    {
        return view('members.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('members', 'email')->ignore($member->id),
            ],
            'phone_number' => 'nullable|string|max:30',
            'address' => 'nullable|string|max:500',
            'membership_category' => 'required|in:Student,Regular,Senior Citizen,Corporate',
            'membership_level' => 'required|in:Basic,Silver,Gold,Platinum',
            'birth_date' => 'nullable|date|before:today',
            'status' => 'required|in:Active,Inactive',
        ]);

        $member->update($validated);

        return redirect()
            ->route('members.show', $member)
            ->with('success', 'Member details updated successfully.');
    }

    public function destroy(Member $member)
    {
        $member->update([
            'status' => 'Inactive',
        ]);

        return redirect()
            ->route('members.index')
            ->with('success', 'Member has been deactivated.');
    }

    public function history(Member $member)
    {
        $member->load([
            'transactions' => function ($query) {
                $query->with('payments')->latest();
            },
        ]);

        return view('members.history', compact('member'));
    }
}