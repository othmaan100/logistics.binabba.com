<?php

namespace App\Http\Controllers;
//namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Auth;

use DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\ActivityLog;



use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function index()
    {
        //
     
        // $users= DB::table('users')
        //             ->join('role','users.role','role.id')
        //             ->select('user.*', 'role.role' as 'user_role')
        //             ->where('status','1')
        //             ->get();
                      //  ->paginate(5)

         $users = DB::table('users')
                      ->join('role', 'users.role', '=', 'role.id')
                      ->select('users.*', 'role.role as user_role')
                      ->where('users.status', '1')
                      ->get();
          
    
       
         $inactive= DB::table('users')
                    ->join('role', 'users.role', '=', 'role.id')
                    ->select('users.*', 'role.role as user_role')
                    ->where('users.status', '0')
                        ->get();
        $roles= DB::table('role')
                        ->get();
        //return $roles;
 
        return view('admin.users', compact('users','inactive','roles'));
   
    }


    public function activate($id)
    {
        # code...
      // return $id;
                $user = User::find($id);
                $user->status = 1;
                $user->save();
                ActivityLog::create([
                    "user_id"=> Auth::user()->id,
                    "activity"=> "User Activated "
                ]);
                return redirect()->route('users')->with('success','User Activated successfully');
    }

    public function deactivate($id)
    {
        # code...
       // return $id;

            
                $user = User::find($id);
                $user->status = 0;
                $user->save();
                ActivityLog::create([
                    "user_id"=> Auth::user()->id,
                    "activity"=> "User Deactivated "
                ]);
                return redirect()->route('users')->with('success','User Deactivated successfully');

           // }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createuser()
    {
        //
        $roles = DB::table('role')
                    ->get();
      // return $roles;

        return view('admin.createuser', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeuser(Request $request)
    {
        //

         $request->validate([

            'fullName' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required', 'string', 'min:11', 'unique:users'],
            'address' => ['required', 'string',  ],
            'role' => ['required', 'string',  ],
            ]);

            $user= new User;
            $user->fullName= $request->input('fullName');
            $user->email= $request->input('email');
            $user->password =Hash::make($request->input('password'));
            $user->phone = $request->input('phone');
            $user->address = $request->input('address');
            $user->role = $request->input('role');
            $user->status = '1';
          
            $user->save();
            /* return redirect('/posts')->with('success', 'Post Created');
            
    
            users::create($request->all()); */
            ActivityLog::create([
                "user_id"=> $request->user()->id,
                "activity"=> "User Added "
            ]);
    
            return redirect()->route('users')
    
                    ->with('success','User Added successfully.');
 





    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    public function role_edit($id)
    {
        # code...
         $selected = "";
        $user= User::find($id);
      //  $roles = User::distinct()->get(['role']);
        $roles= DB::table('role')
                        ->get();
        //return $roles;
        //return $roles;
        return view('admin.role_edit',compact('user','roles'))->with('selected',$selected);
       

        


    }

     public function password_edit($id)
    {
        # code...
         $selected = "";
        $user= User::find($id);
        $roles= DB::table('role')
                        ->get();
        //return $roles;
        return view('admin.password_edit',compact('user','roles'))->with('selected',$selected);
       

    }

   /* public function deactivate($id)
    {
        # code...
    }

     public function activate($id)
    {
        # code...
    }*/
/**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateuser(Request $request, string $user)
    {
        //
            //
        $user = User::find($user);
        
        $request->validate([
            
            'fullName' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'role' => 'required',
            'email' => 'required|email',
            ]);
    
            $user->update($request->all());
             $user->password =Hash::make($request->input('password'));
    
            return redirect()->route('users')->with('success','User information updated successfully');
     

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
            //
        $request->validate([
            
            'fullName' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'role' => 'required',
            'email' => 'required|email',
            ]);
    
            $user->update($request->all());
             $user->password =Hash::make($request->input('password'));
    
            return redirect()->route('users')->with('success','User information updated successfully');
     

    }

    public function password_update(Request $request, $id)
    {
        # code...

        //return $id;
         $request->validate([
         
            'password' => 'required|string|min:8|confirmed',
            ]);
        
            
            
 // if ($request->get('add')=='1') {
                # code...
                $user = User::find($id);
                $user->password =  Hash::make($request->input('password'));
                $user->save();
                return redirect()->route('users')->with('success','User password updated successfully');

           // }



    }

}
