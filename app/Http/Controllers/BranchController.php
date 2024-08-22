<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Company;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::with('company')->get();
        return view('branches.index', compact('branches'));
    }

    public function create()
    {
        $companies = Company::all();
        return view('branches.create', compact('companies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_id' => 'required',
            'name' => 'required|unique:branches',
            'location' => 'nullable',
        ]);

        Branch::create($request->all());

        return redirect()->route('branches.index')
                         ->with('success', 'Branch created successfully.');
    }

    public function edit(Branch $branch)
    {
        $companies = Company::all();
        return view('branches.edit', compact('branch', 'companies'));
    }

    public function update(Request $request, Branch $branch)
    {
        $request->validate([
            'company_id' => 'required',
            'name' => 'required|unique:branches,name,' . $branch->id,
            'location' => 'nullable',
        ]);

        $branch->update($request->all());

        return redirect()->route('branches.index')
                         ->with('success', 'Branch updated successfully.');
    }

    public function destroy(Branch $branch)
    {
        $branch->delete();

        return redirect()->route('branches.index')
                         ->with('success', 'Branch deleted successfully.');
    }
}
