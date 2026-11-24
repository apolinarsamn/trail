<?php

namespace App\Http\Controllers;

use App\Models\MembershipCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = MembershipCategory::orderBy('name')->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create', [
            'category' => new MembershipCategory(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:membership_categories,name'],
            'level' => ['required', 'string', 'max:100'],
            'fee' => ['required', 'numeric', 'min:0'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        MembershipCategory::create($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Membership plan created successfully.');
    }

    public function edit(MembershipCategory $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, MembershipCategory $category)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('membership_categories', 'name')->ignore($category->id),
            ],
            'level' => ['required', 'string', 'max:100'],
            'fee' => ['required', 'numeric', 'min:0'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $category->update($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Membership plan updated successfully.');
    }

    public function destroy(MembershipCategory $category)
    {
        $category->update([
            'is_active' => false,
        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Membership plan deactivated successfully.');
    }
}