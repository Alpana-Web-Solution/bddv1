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
        $data = Donation::where('requisition_id',$requisition->id)->with('user')->get();

        return view('admin.requisition.donation.index')
        ->withData($data->where('status',0))
        ->withRequisition($requisition)
        ->withDonations($data->where('status',1));
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

    public function show(Requisition $requisition, $donation)
    {
        return view('admin.requisition.donation.show')
        ->withData(Donation::where(['requisition_id'=>$requisition->id,'id'=>$donation])->first())
        ->withRequisition($requisition);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requisition $requisition,Request $request)
    {

        $request->validate([
            'user'=>'required',
            'type'=>'required',
            'unit'=>'required',
            'status'=>['required','numeric']
        ]);

        $requestDate = \Carbon\Carbon::now();
        
        if ($request->date) {
           $requestDate = \Carbon\Carbon::parse($request->date . ' ' . $request->time ?? '')->toDateTimeString();
        }
        // Update current 
        
        

        // Store donation to the database
        $store = Donation::create([
            'user_id'=>$request->user,
            'requisition_id'=>$requisition->id,
            'type'=>$request->type,
            'unit'=>$request->unit,
            'date'=> $requestDate,
            'approver_id'=>Auth::id(),
            'status'=>$request->status,
            'comment'=>$request->message,
        ]);

        // For new requisition, save the requisition comment status as 1 so no over written possible.
        // $updateCommand = RequisitionComment::where([
        //     'requisition_id'=>$requisition->id,
        //     'id'=>$request->comment_id
        //     ])->first();
        // If converting from comments
        // if (!empty($updateCommand)) {
        //     if ($updateCommand->status != 1) {
        //         $updateCommand->update(['status'=>1]);
        //     }
           
        // }

        // Update last donation date for given user.
        $userUpdate = User::where('id',$request->user)->first();
        $userUpdate->update(['last_donated'=>$requestDate]);
        
        
        return redirect()->route('admin.requisition.show',$requisition->id)->with('info','Donation Saved.');

    }

    public function update(Requisition $requisition, $donation, Request $request)
    {
        $data = $request->validate([
            'user'=>'required',
            'type'=>'required',
            'unit'=>'required',
            'status'=>['required','numeric']
        ]);

        
        
        if ($request->date) {
           $data['date'] = \Carbon\Carbon::parse($request->date . ' ' . $request->time ?? '')->toDateTimeString();
        }else{
            $data['date'] = \Carbon\Carbon::now();
        }
        $data['approver_id'] = Auth::id();

        $update = Donation::where(['requisition_id'=>$requisition->id,'id'=>$donation])->first();
        $update->update($data);

        // Update users last donation
        $userUpdate = User::where('id',$request->user)->first();
        $userUpdate->update(['last_donated'=>$data['date']]);

        return redirect()->route('admin.requisition.donation.index',$requisition->id)->with('info','Donation Updated.');

    }

}
