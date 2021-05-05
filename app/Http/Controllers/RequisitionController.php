<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\RequisitionComment;
use App\Models\Requisition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\ImageUploadService;

class RequisitionController extends Controller
{
    // Validate functions
    protected function validateRequest()
    {
        return request()->validate([
            'pincode'=>'required|digits:6',
            'hospital_name'=>'required',
            'patient_name'=>'required',
            'contact_name'=>'required',
            'donation_type'=>'required',
            'blood_group'=>'required',
            'unit'=>'required',
            'contact'=>'required|digits:10',
            'alternate_contact'=>'nullable|different:contact|digits:10',
            'when_wanted'=>'required',
            'message'=>'string',
            'priority'=>'required',
            'file' => 'image|mimes:jpg,jpeg,gif,png|max:2048'
        ]);
    }

    /** 
     * 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('requisition.index')->withData(Requisition::latest()->paginate(10));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('requisition.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validateRequest();
        unset($data['when_wanted']);
        $data +=['when_wanted'=>\Carbon\Carbon::parse($request->when_wanted . ' ' . $request->when_wanted_time)->toDateTimeString()];

        // User creating requisition?
        if (Auth::user()) {
            $data += ['user_id'=>Auth::id()];
        }
        
        // Send Image upload to service
        $imageUpload = new ImageUploadService();
        $data += ['img'=>$imageUpload->requisitionUpload()];
        
        $createRequisition = Requisition::create($data);

        // Todo: Add mail service and send mail to all admin.
       
       return redirect()->route('requisition.index')->with('success',__('Requisition Created.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Requisition  $requisition
     * @return \Illuminate\Http\Response
     */
    public function show(Requisition $requisition)
    {
        // Hide all info so crawler can not see them
        // dd($requisition->comments,RequisitionComment::where('requisition_id',$requisition->id)->get());
        return view('requisition.show')
        ->withData(
            $requisition->load(['comments','comments.user','userDonations','userDonations.user'])
        );
    }

    public function donation(Requisition $requisition)
    {
        // Store users requisition request
        // dd(request()->all());

        if (!auth()) {
            return abrot(403);
        }

        request()->validate(['unit'=>['required','numeric','max:5'],'type'=>['required','numeric']]);

        $data = [
            'user_id'=>Auth::id(),
            'requisition_id'=>$requisition->id,
            'type'=>request()->type,
            'comment'=>request()->comment,
            'date'=>now()
        ];

        \App\Models\Donation::create($data);

        return back()->with('success',__('Your donation request is successfully registered and pending approval.'));
    }

    
}
