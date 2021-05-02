<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Requisition;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;

class UserManagerController extends Controller
{

    // Validation function to eliminate repetitive code
    private function validateUser()
    {
        return request()->validate([
        "email"=>"required",
        "name" => "required",
        "username" => "required|min:6|alpha_dash",
        'password' => "required|string|min:8|confirmed",
        "pincode_id" => "required|digits:6",
        "mobile" => "required|digits:10",
        // "last_donated"=>"nullable", //last_donation is added manually for formatting using carbon
        "other_contact" => "nullable|different:contact|digits:10",
        "blood_group" => "required",
        "is_donor" => "required",
        "can_not_donate_until"=>"nullable"
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.usermanager.index')->withData(User::paginate(20));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.usermanager.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Get validated data and add password and last donated field
        $data = $this->validateUser();
        unset($data['password']);
        
        if (!empty(request()->password)) {
            $data +=['password'=>Hash::make(request()->password)];
        }else{
            // Else needed otherwiese I have to unset
            $data +=['password' => bcrypt(mt_rand())];
        }
        
        if (!empty(request()->last_donated)) {
        $data +=['last_donated'=>\Carbon\Carbon::parse(request()->last_donated)->toDateTimeString()];
        }

        // Create an user using data.
        $user = User::create($data);
        // Send user notifications
        $token = Password::getRepository()->create($user);
        $user->sendPasswordResetNotification($token);

        return back()->with('success','New users email send Successfully');


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($user)
    {
        $data = User::where('id',$user)->firstOrFail();
        return view('admin.usermanager.show')->withData($data);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($user)
    {
        // dd($user);
        $user = User::where('id',$user)->firstOrFail();
        return view('admin.usermanager.edit')->withData($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$user)
    {
        // dd($request->all());
        $data = $this->validateUser();
        unset($data['password']);
        if (!empty(request()->password)) {
            $data +=['password'=>Hash::make(request()->password)];
        }
        if (!empty(request()->last_donated)) {
        $data +=['last_donated'=>\Carbon\Carbon::parse(request()->last_donated)->toDateTimeString()];
        }

        $user = User::where('id',$user)->firstOrFail();

        $user->update($data);

        return redirect()->route('admin.usermanager.index')->with('info','User Updated,');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($user)
    {
        if (Auth::id() == $user) {
            return redirect()->back()->with('error','Can not delete self');
        }

        $data = User::where('id',$user)->first();
        $data->delete();
        return redirect()->back()->with('success','Successfully deleted.');
    }
    /**
     * Reset the password for specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function resetPassword($user)
    {
        $data = User::where('id',$user)->firstOrFail();
        $token = Password::getRepository()->create($data);
        $data->sendPasswordResetNotification($token);
        return redirect()->back()->with('success','Users Password reset email send Successfull.');

    }


    public function sendMail($user,Request $request)
    {
        $userData = User::findOrFail($user);
        $requisitionMail = Requisition::findOrFail($request->requisitionMail);
        $email = $userData->email;
        // dd($request->all());
        // dd($userData);
        // Mail::to($user)->send('User need your blood.');
        $link = '<a href="'.route('requisition.show',$requisitionMail->id).'">'.$requisitionMail->patient_name.'</a>';
        $body = 'We need a donor for '.$link.'. Please let me know if you are available to donate ASAP.';
        
        // dd($subject);
        Mail::send([],[],function ($message) use($email,$requisitionMail,$body)
        {
            $message->to($email)
            ->subject('Donor needed.')->setBody($body, 'text/html');
        });
        return redirect()->back()->with('info','Email sent.');
    }
}
