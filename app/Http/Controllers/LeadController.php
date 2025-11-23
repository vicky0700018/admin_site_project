<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;

class LeadController extends Controller
{
    // Admin: View all leads
    public function index()
{
    if (auth()->user()->role !== 'subadmin') {
        abort(403, 'Unauthorized');
    }

    // Use pagination instead of all()
    $leads = Lead::orderBy('created_at', 'desc')->paginate(10);

    return view('subadmin.leads.index', compact('leads'));
}


    // Subadmin: Show create form
    public function create()
    {
        if (auth()->user()->role !== 'subadmin') {
            abort(403, 'Unauthorized');
        }

        return view('subadmin.leads.create');
    }

    // Subadmin: Store lead
    public function store(Request $request)
    {
        if (auth()->user()->role !== 'subadmin') {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:leads,email',
            'mobile' => 'required|string|max:15|unique:leads,mobile',
            'dob'    => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
        ]);

        Lead::create($request->only(['name', 'email', 'mobile', 'dob', 'gender']));

        return redirect()->back()->with('success', 'Lead created successfully.');
    }


    // Show single lead
    public function show($id)
    {
        $lead = Lead::findOrFail($id);
        return view('subadmin.leads.show', compact('lead'));
    }

    // Edit form
    public function edit($id)
    {
        $lead = Lead::findOrFail($id);
        return view('subadmin.leads.edit', compact('lead'));
    }

    // Update lead
    public function update(Request $request, $id)
    {
        $lead = Lead::findOrFail($id);

        $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:leads,email,' . $lead->id,
            'mobile' => 'required|string|max:15|unique:leads,mobile,' . $lead->id,
            'dob'    => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
        ]);

        $lead->update($request->only(['name', 'email', 'mobile', 'dob', 'gender']));

        return redirect()->route('subadmin.leads.index')->with('success', 'Lead updated successfully.');
    }


    public function destroy($id)
{
    $lead = Lead::findOrFail($id);
    $lead->delete(); // this will only update deleted_at
    return redirect()->route('subadmin.leads.index')->with('success', 'Lead deleted successfully.');
}

}
