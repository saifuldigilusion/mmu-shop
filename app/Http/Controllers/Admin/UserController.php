<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\User;   

class UserController extends Controller
{
    //
    public function changePassword(Request $request) {

        if($request->isMethod('post')) {
            
            if (!(Hash::check($request->get('current'), Auth::user()->password))) {
                // The passwords matches
                return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
            }
    
            if(strcmp($request->get('current'), $request->get('new')) == 0){
                //Current password and new password are same
                return redirect()->back()->with("error","New Password cannot be same as your current password. Please choose a different password.");
            }
    
            $validatedData = $request->validate([
                'current' => 'required',
                'new' => 'required|string|min:6',
            ]);
    
            //Change Password
            $userId = Auth::User()->id;
            $user = User::find($userId);
            $user->password = bcrypt($request->get('new'));
            $user->save();
    
            return redirect()->back()->with("success","Password changed successfully !");
    
        }

        return view('admin.user.changepassword');
    }
}
