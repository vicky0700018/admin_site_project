<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\LeadDocument;

class LeadDocumentController extends Controller
{
    // Show upload form
    public function create($leadId)
    {
        if (auth()->user()->role !== 'subadmin') {
            abort(403, 'Unauthorized');
        }

        $lead = Lead::findOrFail($leadId);
        return view('subadmin.leads.documents.create', compact('lead'));
    }

    // Store documents
    public function store(Request $request, $leadId)
    {
        if (auth()->user()->role !== 'subadmin') {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'aadhaar_front' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'aadhaar_back'  => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'pan_front'     => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'pan_back'      => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'other_docs'    => 'nullable|mimes:jpg,jpeg,png,pdf|max:4096',
        ]);

        $lead = Lead::findOrFail($leadId);

        $data = ['lead_id' => $lead->id];

        if ($request->hasFile('aadhaar_front')) {
            $data['aadhaar_front'] = $request->file('aadhaar_front')->store('documents', 'public');
        }
        if ($request->hasFile('aadhaar_back')) {
            $data['aadhaar_back'] = $request->file('aadhaar_back')->store('documents', 'public');
        }
        if ($request->hasFile('pan_front')) {
            $data['pan_front'] = $request->file('pan_front')->store('documents', 'public');
        }
        if ($request->hasFile('pan_back')) {
            $data['pan_back'] = $request->file('pan_back')->store('documents', 'public');
        }
        if ($request->hasFile('other_docs')) {
            $data['other_docs'] = $request->file('other_docs')->store('documents', 'public');
        }

        LeadDocument::updateOrCreate(
            ['lead_id' => $lead->id],
            $data
        );

        return redirect()->route('subadmin.leads.create')->with('success', 'Documents uploaded successfully.');
    }


    // Show ALL documents for ALL leads
    public function index()
    {
        if (!in_array(auth()->user()->role, ['admin', 'subadmin'])) {
            abort(403, 'Unauthorized');
        }

        // Eager load leads with their documents
        $leads = Lead::with('documents')->latest()->get();

        return view('subadmin.leads.documents.index', compact('leads'));
    }


    public function show($leadId)
    {
        if (auth()->user()->role !== 'subadmin') {
            abort(403, 'Unauthorized');
        }

        $lead = Lead::with('documents')->findOrFail($leadId);

        return view('subadmin.leads.documents.show', compact('lead'));
    }
}
