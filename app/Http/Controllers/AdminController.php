<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    public function show_create_subadmin_form()
    {
        return view('admin.create_subadmin');
    }

    public function createSubAdmin(Request $request)
    {
        // only admin can create subadmin
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'subadmin'
        ]);

        return redirect()->back()->with('success', 'SubAdmin created successfully.');
    }

    // app/Http/Controllers/AdminController.php
    public function listSubAdmins()
    {
        // only admins can see
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $subadmins = User::where('role', 'subadmin')->get();
        return view('admin.subadmins', compact('subadmins'));
    }


    public function editSubAdmin($id)
    {
        $subadmin = User::where('role', 'subadmin')->findOrFail($id);
        return view('admin.edit_subadmin', compact('subadmin'));
    }

    public function updateSubAdmin(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $subadmin = User::where('role', 'subadmin')->findOrFail($id);
        $subadmin->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.subadmins')->with('success', 'SubAdmin updated successfully.');
    }

    public function deleteSubAdmin($id)
    {
        $subadmin = User::where('role', 'subadmin')->findOrFail($id);
        $subadmin->delete(); // soft delete (sets deleted_at)
        return redirect()->route('admin.subadmins')->with('success', 'SubAdmin deleted successfully.');
    }
}
