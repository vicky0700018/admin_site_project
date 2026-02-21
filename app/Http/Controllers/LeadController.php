<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\User;
use App\Services\ActivityLogService;

class LeadController extends Controller
{
    // Admin: View all leads with search and filter
    public function index(Request $request)
    {
        $query = Lead::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('mobile', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by assigned user
        if ($request->filled('assigned_to')) {
            $query->where('assigned_to', $request->assigned_to);
        }

        $leads = $query->orderBy('created_at', 'desc')->paginate(15);
        $statuses = Lead::statuses();
        $subadmins = User::where('role', 'subadmin')->get();

        return view('subadmin.leads.index', compact('leads', 'statuses', 'subadmins'));
    }

    // Subadmin: Show create form
    public function create()
    {
        return view('subadmin.leads.create');
    }

    // Subadmin: Store lead
    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:leads,email',
            'mobile' => 'required|string|max:15|unique:leads,mobile',
            'dob'    => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
        ]);

        $lead = Lead::create($request->only(['name', 'email', 'mobile', 'dob', 'gender']));

        // Log activity
        ActivityLogService::logLeadCreated($lead->id, $request->only(['name', 'email', 'mobile', 'dob', 'gender']));

        return redirect()->back()->with('success', 'Lead created successfully.');
    }

    // Show single lead
    public function show($id)
    {
        $lead = Lead::with('assignedTo')->findOrFail($id);
        $statuses = Lead::statuses();
        $subadmins = User::where('role', 'subadmin')->get();
        
        return view('subadmin.leads.show', compact('lead', 'statuses', 'subadmins'));
    }

    // Edit form
    public function edit($id)
    {
        $lead = Lead::findOrFail($id);
        $statuses = Lead::statuses();
        $subadmins = User::where('role', 'subadmin')->get();
        
        return view('subadmin.leads.edit', compact('lead', 'statuses', 'subadmins'));
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
            'status' => 'nullable|in:new,in_progress,completed,rejected',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $oldData = $lead->only(['name', 'email', 'mobile', 'dob', 'gender', 'status', 'assigned_to']);

        // Check if status changed
        if ($request->filled('status') && $request->status !== $lead->status) {
            ActivityLogService::logLeadStatusChanged($lead->id, $lead->status, $request->status);
        }

        // Check if assignment changed
        if ($request->filled('assigned_to') && $request->assigned_to != $lead->assigned_to) {
            ActivityLogService::logLeadAssigned($lead->id, $lead->assigned_to, $request->assigned_to);
        }

        $lead->update($request->only(['name', 'email', 'mobile', 'dob', 'gender', 'status', 'assigned_to']));

        // Log full update
        ActivityLogService::logLeadUpdated($lead->id, $oldData, $request->only(['name', 'email', 'mobile', 'dob', 'gender', 'status', 'assigned_to']));

        return redirect()->route('subadmin.leads.index')->with('success', 'Lead updated successfully.');
    }

    // Delete lead
    public function destroy($id)
    {
        $lead = Lead::findOrFail($id);
        ActivityLogService::logLeadDeleted($lead->id);
        $lead->delete();
        
        return redirect()->route('subadmin.leads.index')->with('success', 'Lead deleted successfully.');
    }

    // Update lead status
    public function updateStatus(Request $request, $id)
    {
        $lead = Lead::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:new,in_progress,completed,rejected',
        ]);

        $oldStatus = $lead->status;
        $lead->update(['status' => $request->status]);

        ActivityLogService::logLeadStatusChanged($lead->id, $oldStatus, $request->status);

        return redirect()->back()->with('success', 'Lead status updated successfully.');
    }

    // Assign lead to subadmin
    public function assign(Request $request, $id)
    {
        $lead = Lead::findOrFail($id);
        
        $request->validate([
            'assigned_to' => 'required|exists:users,id',
        ]);

        $oldUserId = $lead->assigned_to;
        $lead->update(['assigned_to' => $request->assigned_to]);

        ActivityLogService::logLeadAssigned($lead->id, $oldUserId, $request->assigned_to);

        return redirect()->back()->with('success', 'Lead assigned successfully.');
    }
}
