<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;


class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate();

        return view('users.index', compact('users'));
    }
    public function create()
    {
        return view('users.create');
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            
        ]);
         $user = new User();

         $user->name = $request->input('name');
         $user->email = $request->input('email');
         $user->password = bcrypt($validatedData['password']);
        
         $user->save();

         return redirect()->route('users.index')->with('success','added successfully');
    }
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
    
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);
        $user->update($request->all());
        
        return redirect()->route('users.index')->with('success','updated successfully');
    }

    public function destroy(User $user)
    {
        $user->delete();
        
        return redirect()->route('users.index')->with('success','deleted successfully');
    }
}
