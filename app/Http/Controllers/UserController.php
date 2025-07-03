<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $user=User::chunk(3,function($users){
        //    foreach($users as $user){
        //        echo $user->name .'<br/>';
        //    }
        //    echo "<br><br><br>";
        // });
        // return "This is the user index";

        $users=User::with('roles')->get();
        return $users;
       
       
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
        $roles=Role::get();
        return view('user-role',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    //    return $request->all();
        $request->validate([
            'name'=>['required'],
            'email'=>['required','unique:users,email'],
            'password'=>['required'],
            'roles'=>['required','array'],
        ]);

       $user= User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
        ]);
        $user->roles()->attach($request->roles);
        return redirect()->back()->with('success', 'User created with roles!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user=User::with('roles')->find(12);
        // $role=collect(['admin','editor']);
        $role=Role::pluck('name');
        $roles=collect($role);

 

    if($user->hasRole2('editor','admin','user') && $user->roles()->count()===3){
        return 'You are all in one';
    }
    if($user->hasRole2('editor')){
        return 'You are Editor';
    }


        
        // $userRoles=$user?->roles?->pluck('name');
        // if($roles->diff($userRoles)->isEmpty()){
        //     return "This is admin, user or editor";
        // }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
