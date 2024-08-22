<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Branch;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $branches = Branch::all();
        $companies = Company::all();
        return view('users.create', compact('branches', 'companies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'phone' => 'nullable|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'company_branch_pairs' => 'required|array',
            'company_branch_pairs.*.company_id' => 'required|exists:companies,id',
            'company_branch_pairs.*.branch_id' => 'required|exists:branches,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);
        $user->save();
        //$user->branches()->sync($request->branches);

        foreach ($request->input('company_branch_pairs') as $pair) {
            $user->companies()->attach($pair['company_id']);
            $user->branches()->attach($pair['branch_id']);
        }

        return redirect()->route('users.index')
                         ->with('success', 'User created successfully.');
    }

    public function getBranches($companyId)
    {
        try {
            $branches = Branch::where('company_id', $companyId)->get();
            
            return response()->json($branches);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function edit(User $user)
    {
        $companies = Company::all();
        $branches = Branch::all();
        
        return view('users.edit', compact('user', 'branches','companies'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $user->id,
            'phone' => 'nullable|unique:users,phone,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'company_branch_pairs' => 'array',
            'company_branch_pairs.*.company_id' => 'required|exists:companies,id',
            'company_branch_pairs.*.branch_id' => 'required|exists:branches,id',
        ]);

       // dd($request);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);
        $user->save();


        // $user->branches()->sync($request->branches);
        // $user->companies()->sync($request->companies);

        // Convert the company_branch_pairs input to a collection
        $companyBranchPairs = collect($request->input('company_branch_pairs', []));

        // Extract unique company IDs and branch IDs
        $companyIds = $companyBranchPairs->pluck('company_id')->unique();
        $branchIds = $companyBranchPairs->pluck('branch_id')->unique();

        // Sync company-branch relationships
        $user->companies()->sync($companyIds);
        $user->branches()->sync($branchIds);

        return redirect()->route('users.index')
                         ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')
                         ->with('success', 'User deleted successfully.');
    }

    public function dashboard()
    {
        //$branches = auth()->user()->branches;
       $users = User::where('role', 'user')
            ->with('companies', 'branches') // Eager load companies and branches
            ->get();

        return view('dashboard', compact('users'));
    }
}
