<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Rules\GstNumber;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::all();
        return view('companies.index', compact('companies'));
    }

    public function create()
    {
        return view('companies.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:companies',
            'pan' => 'required|unique:companies',
            'gst' => ['required', new GstNumber($request->input('pan'))],
        ]);

        Company::create($request->all());

        return redirect()->route('companies.index')
                         ->with('success', 'Company created successfully.');
    }

    public function edit(Company $company)
    {
        return view('companies.edit', compact('company'));
    }

    public function update(Request $request, Company $company)
    {
        $request->validate([
            'name' => 'required|unique:companies,name,' . $company->id,
            'pan' => 'required|unique:companies,pan,' . $company->id,
            'gst' => ['required', new GstNumber($request->input('pan'))],
        ]);

        $company->update($request->all());

        return redirect()->route('companies.index')
                         ->with('success', 'Company updated successfully.');
    }

    public function destroy(Company $company)
    {
        $company->delete();

        return redirect()->route('companies.index')
                         ->with('success', 'Company deleted successfully.');
    }
}
