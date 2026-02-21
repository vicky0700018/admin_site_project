<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\LeadDocument;
use App\Services\ActivityLogService;

class LeadDocumentController extends Controller
{
    // Show upload form
    public function create($leadId)
    {
        $lead = Lead::findOrFail($leadId);
        return view('subadmin.leads.documents.create', compact('lead'));
    }

    // Store documents with enhanced validation
    public function store(Request $request, $leadId)
    {
        $request->validate([
            'aadhaar_front' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048|dimensions:min_width=100,min_height=100',
            'aadhaar_back'  => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048|dimensions:min_width=100,min_height=100',
            'pan_front'     => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048|dimensions:min_width=100,min_height=100',
            'pan_back'      => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048|dimensions:min_width=100,min_height=100',
            'other_docs'    => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096',
        ]);

        $lead = Lead::findOrFail($leadId);
        $data = ['lead_id' => $lead->id];
        $uploadedFiles = [];

        try {
            if ($request->hasFile('aadhaar_front')) {
                $data['aadhaar_front'] = $request->file('aadhaar_front')->store('documents', 'public');
                $uploadedFiles[] = 'aadhaar_front';
            }
            if ($request->hasFile('aadhaar_back')) {
                $data['aadhaar_back'] = $request->file('aadhaar_back')->store('documents', 'public');
                $uploadedFiles[] = 'aadhaar_back';
            }
            if ($request->hasFile('pan_front')) {
                $data['pan_front'] = $request->file('pan_front')->store('documents', 'public');
                $uploadedFiles[] = 'pan_front';
            }
            if ($request->hasFile('pan_back')) {
                $data['pan_back'] = $request->file('pan_back')->store('documents', 'public');
                $uploadedFiles[] = 'pan_back';
            }
            if ($request->hasFile('other_docs')) {
                $data['other_docs'] = $request->file('other_docs')->store('documents', 'public');
                $uploadedFiles[] = 'other_docs';
            }

            $document = LeadDocument::updateOrCreate(
                ['lead_id' => $lead->id],
                $data
            );

            // Log activity
            ActivityLogService::log(
                'document_uploaded',
                'LeadDocument',
                $document->id,
                null,
                ['files_uploaded' => $uploadedFiles],
                'Documents uploaded for lead: ' . implode(', ', $uploadedFiles)
            );

            return redirect()->route('subadmin.leads.create')->with('success', 'Documents uploaded successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to upload documents: ' . $e->getMessage());
        }
    }

    // Show ALL documents for ALL leads
    public function index()
    {
        if (!in_array(auth()->user()->role, ['admin', 'subadmin'])) {
            abort(403, 'Unauthorized');
        }

        // Eager load leads with their documents
        $leads = Lead::with('documents')->latest()->paginate(15);

        return view('subadmin.leads.documents.index', compact('leads'));
    }

    public function show($leadId)
    {
        $lead = Lead::with('documents')->findOrFail($leadId);

        return view('subadmin.leads.documents.show', compact('lead'));
    }
}
