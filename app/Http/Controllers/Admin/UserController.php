<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of users
     */
    public function index()
    {
        $users = User::orderBy('id', 'desc')->get();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user
     */
    public function create()
    {
        return view('admin.users.add');
    }

    /**
     * Store a newly created user in database
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'user_id' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'position_hold' => 'required|in:1,2,3',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        User::create([
            'name' => $request->name,
            'email' => $request->user_id,
            'password' => Hash::make($request->password),
            'position_hold' => $request->position_hold,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully!');
    }

    /**
     * Show the form for editing the specified user
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user in database
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'user_id' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
            'position_hold' => 'required|in:1,2,3',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = [
            'name' => $request->name,
            'email' => $request->user_id,
            'position_hold' => $request->position_hold,
        ];

        // Only update password if provided
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified user from database
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent deleting your own account
        if ($user->id == auth()->id()) {
            return redirect()->back()
                ->with('error', 'You cannot delete your own account!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully!');
    }

    /**
     * Export users to Excel
     */
    public function export()
    {
        $users = User::all();
        
        $filename = "users_" . date('Y-m-d') . ".csv";
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        
        // Add headers
        fputcsv($output, ['Sl.No.', 'User Name', 'User Id', 'Position Hold']);
        
        // Add data
        $count = 1;
        foreach ($users as $user) {
            fputcsv($output, [
                $count++,
                $user->name,
                $user->email,
                $user->position_name
            ]);
        }
        
        fclose($output);
        exit();
    }
}
