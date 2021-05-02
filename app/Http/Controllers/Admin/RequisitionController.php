<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Http\Controllers\Controller;
use App\Models\Requisition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
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
            'status'=>'required',
            'priority'=>'required',
            'file' => 'image|mimes:jpg,jpeg,gif,png|max:2048'
        ]);

    }
    
    private function validateSeo()
    {
        return request()->validate([
            "description" => 'nullable|string',
              "keywords" => 'nullable|string',
              "author" => 'nullable|string',
              "copyright" => 'nullable|string',
              "application_name" => 'nullable|string',
              "og_title" => 'nullable|string',
              "og_type" => 'nullable|string',
              "og_image" => 'nullable|string',
              "og_url" => 'nullable|url',
              "og_description" => 'nullable|string',
              "fb_app_id" => 'nullable|string',
              "og_locale" => 'nullable|string',
              "twitter_card" => 'nullable|string',
              "twitter_title" => 'nullable|string',
              "twitter_description" => 'nullable|string',
              "twitter_image" => 'nullable|string',
        ]);
        
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.requisition.index')->withData(Requisition::latest()->paginate(20));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.requisition.create');
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
        
        // Unset the time data
        unset($data['when_wanted']);
        
        // Add old time data with time
        $data +=['when_wanted'=>\Carbon\Carbon::parse($request->when_wanted . ' ' . $request->when_wanted_time)->toDateTimeString()];
        // Send Image upload to service
        $imageUpload = new ImageUploadService(auth()->user());
        $data += ['img'=>$imageUpload->requisitionUpload()];
        
        // Create data
        $createRequisition = Requisition::create($data);

       return redirect()->route('admin.requisition.index')->with('success','Requisition Stored.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Requisition  $requisition
     * @return \Illuminate\Http\Response
     */
    public function show(Requisition $requisition)
    {
        return view('admin.requisition.show')
        ->withData($requisition->load(['comments','comments.user','userDonations']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Requisition  $requisition
     * @return \Illuminate\Http\Response
     */
    public function edit(Requisition $requisition)
    {
        return view('admin.requisition.edit')->withData($requisition);
    }

    //Only update seo
    public function seoUpdate(Request $request, Requisition $requisition)
    {
        $requisition->seo =$this->validateSeo();
        $requisition->save();
        return back()->with('success','Seo Updated');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Requisition  $requisition
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Requisition $requisition)
    {
        
        $data = $this->validateRequest();
        // Delete the data from validated request
        unset($data['when_wanted']);

        // Add extra data
        $data +=['user_id'=>Auth::id(),'img'=> $this->upoadImage()];
        $data +=['when_wanted'=>\Carbon\Carbon::parse($request->when_wanted . ' ' . $request->when_wanted_time)->toDateTimeString()];
        // Update current requisition
        $requisition->update($data);
        // Return
        return redirect()->route('admin.requisition.index')->with('info','Data Updated.');

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Requisition  $requisition
     * @return \Illuminate\Http\Response
     */
    public function destroy(Requisition $requisition)
    {
        $requisition->load(['userDonations','comments']);

        // Check if user has uploaded images.
        if ($requisition->img) {
            // Explode all the parts from the url
            $getImageURL = explode('/',$requisition->img);
            
            // If server is cloudinary then delete here
            if ($getImageURL[2] == 'res.cloudinary.com') {
            
               $getPublicName = explode('.',$getImageURL[9]);
                // dd($getImageURL,$getPublicName);
                // $test = Cloudinary::destroyAsync($getImageName[8]);
                $publicID = 'abdd/'.$getImageURL[8].'/'.$getPublicName[0];
                // dd($publicID);
                $test = cloudinary()->destroy($publicID);

            }
                // For local storage delete from here.
                $deleteStorageFile = $getImageURL[1].'/'.$getImageURL[2];
                $sdfsdfsadfsd = Storage::delete('public/'.$deleteStorageFile);
                // dd(Storage::files('public'),$sdfsdfsadfsd,$deleteStorageFile,'Delete Local Files.');
            
            
        }

        

        // Remove the donation UID
        foreach ($requisition->userDonations as $userDonation) {
            $userDonation->update(['requisition_id'=> null]);
        };

        // delete the comments from database
        foreach ($requisition->comments as $comment) {
            $comment->delete();
        }
        

        // Now delete the entry.
        $requisition->delete();
        
        return redirect()->route('admin.requisition.index')->with('info','Requisition Deleted.');

    }
}
