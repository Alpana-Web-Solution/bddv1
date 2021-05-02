<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Setting::firstOrCreate([],[]);
        return view('admin.settings.edit')->withData($data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->document_hosting == 1) {
            if (empty(env('CLOUDINARY_URL'))) {
                return redirect()->back()->with('error',__('Please define the Cloudinary setting first.'));
            }
        }
        $data = $request->validate([
            'details'=>'nullable|string',
            'logo'=>'nullable|url',
            'registration_number'=>'nullable|string',
            'document_hosting'=>'nullable|boolean'
        ]);
        // dd($data);

        $dataUpdated = Setting::firstOrCreate([],[]);
        $dataUpdated->update($data);

        return back()->with('success',__('Site successfully updated.'));
    }

}
