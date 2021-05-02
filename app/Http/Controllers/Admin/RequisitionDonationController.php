<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Donation;
use App\Models\RequisitionComment;
use App\Models\Requisition;
use Illuminate\Http\Request;

class RequisitionDonationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Requisition $requisition)
    {
        return view('admin.requisition.donation.index')
        ->withData(
            RequisitionComment::where(['requisition_id'=>$requisition->id,'request_type'=>1,'status'=> null])
            ->with('user')
            ->paginate(20)
            )
        ->withRequisition($requisition)
        ->withDonations($requisition->userDonations);
    }

    // This will create a manual entry for donor
    // Change to select2 and jquery search for User.
    public function create(Requisition $requisition)
    {
        // dd(\App\Models\User::all()->pluck('name','id'));
        return view('admin.requisition.donation.create')
        ->withRequisition($requisition)
        ->withUsers(
            \App\Models\User::all()
            ->pluck('name','id')
        );
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requisition $requisition,Request $request)
    {

        $request->validate(['user'=>'required','type'=>'required','unit'=>'required']);

        $requestDate = \Carbon\Carbon::now();
        
        if ($request->date) {
           $requestDate = \Carbon\Carbon::parse($request->date . ' ' . $request->time ?? '')->toDateTimeString();
        }
        
        

        // Store donation to the database
        $store = Donation::create([
            'user_id'=>$request->user,
            'requisition_id'=>$requisition->id,
            'type'=>$request->type,
            'unit'=>$request->unit,
            'date'=> $requestDate,
            'approver_id'=>Auth::id(),
            'comment'=>$request->message,
        ]);

        // For new requisition, save the requisition comment status as 1 so no over written possible.
        $updateCommand = RequisitionComment::where([
            'requisition_id'=>$requisition->id,
            'id'=>$request->comment_id
            ])->first();
        // If converting from comments
        if (!empty($updateCommand)) {
            if ($updateCommand->status != 1) {
                $updateCommand->update(['status'=>1]);
            }
           
        }

        // Update last donation date for given user.
        $userUpdate = User::where('id',$request->user)->first();
        $userUpdate->update(['last_donated'=>$requestDate]);
        
        
        return redirect()->route('admin.requisition.show',$requisition->id)->with('info','Donation Saved.');

    }

}
