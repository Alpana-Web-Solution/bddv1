<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\Request;
use App\Models\Donation;
use App\Models\Setting;
use App\Services\ImageUploadService;
use Illuminate\Support\Facades\Storage;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class CertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function certificateDownload(Donation $donation)
    {
        $data = $donation->load('user');

        $getCertificateDetails = Certificate::first();

        if (!empty($getCertificateDetails)) {
            $data->certificate_template = $getCertificateDetails->certificate_template;
            // $data->signature_img = $getCertificateDetails->signature_img;

        }else{
            $data->certificate_template = asset('/images/certificate/template.png');            
        }
        
        // view()->share('data',$data);
        // return view('admin.donation.certificate');
        // If setings set to cloudinary transformation
        if ($getCertificateDetails->cloudinary_transform == 1) {

            $getImageURL = explode('/',$getCertificateDetails->certificate_template);
            if (!empty($getImageURL[2]) AND $getImageURL[2] == 'res.cloudinary.com'){

                $userData = 'l_text:Arial_45_bold:'.$data->user->name.',g_north_west,x_400,y_330/l_text:Arial_25_bold:'.$data->date->isoFormat('DD MMM YYYY').',g_north_west,x_200,y_550';
                $certificateData = $getImageURL[0].'//'.$getImageURL[2].'/'.$getImageURL[3].'/'.$getImageURL[4].'/'.$getImageURL[5].'/'.$userData.'/'.$getImageURL[6].'/'.$getImageURL[7].'/'.$getImageURL[8].'/'.$getImageURL[9];
                return redirect()->away($certificateData);
                // dd(url($certificateData),$data);
            }else{
                return back()->with('error',__('Please upload template to cloudinary first.'));
            }
            
        }else{
            // No pdf writer is installed.
            return back()->with('error',__('error_only_cloud_provider_available'));
        }
        
    }

    public function edit()
    {
        $certificate = Certificate::firstOrCreate([],['certificate_template'=>'','cloudinary_transform'=>0]);
        return view('admin.certificate.edit')->withCertificate($certificate);
    }


    // Update the certificate
    public function update()
    {

        request()->validate([
            'certificate_template' => 'image|mimes:jpg,jpeg,gif,png|max:2048',
            'cloudinary_transform'=>'nullable'
        ]);

        $data = Certificate::firstOrCreate(
            [],
            [
                'certificate_template'=>'',
                'cloudinary_transform'=>request()->cloudinary_transform
            ]);

        if (!empty($data)) {

            // Delete the image from server before upload
            if (!empty($data->certificate_template)) {
                $this->deleteImage($data->certificate_template);
            }

            if (empty(request()->cloudinary_transform)) {
                $cloudinary_transform = 0;
            }else{
                $cloudinary_transform = request()->cloudinary_transform;
            }
            
            $uploadImageToStorage = new ImageUploadService(auth()->user());
            
            $data->certificate_template = $uploadImageToStorage->certificateUpload();

            $data->cloudinary_transform = $cloudinary_transform;
            $data->save();

            // Return success or null
            return back()->with('success',__('Template Updated'));

        }else{
            $uploadImageToStorage = new ImageUploadService(auth()->user());
            
            Certificate::create([
                'certificate_template'=>URL::asset($uploadImageToStorage->certificateUpload())
            ]);
            
            return back()->with('success',__('Template Updated'));
        }
        
        
    }

    // Preview current 
    public function preview()
    {
        // Preview starts
        $data = Certificate::first();
        
        if (empty($data)) {
            $data = collect();
        }

        $data->user = auth()->user();
        $data->date=\Carbon\Carbon::now();

        if (empty($data->certificate_template)) {
            $data->certificate_template= asset('/images/certificate/template.png');
        }
        
        
        view()->share('data',$data);
        return view('admin.donation.certificate');
    }

    // export to service.
    private function deleteImage($image)
    {
        $getImageURL = explode('/',$image);

        if ($getImageURL[2] == 'res.cloudinary.com') {
         $getPublicName = explode('.',$getImageURL[9]);
         $publicID = 'abdd/certificate/'.$getPublicName[0];
         $test = cloudinary()->destroy($publicID);
     }else{
        $deleteStorageFile = $getImageURL[1].'/'.$getImageURL[2];
        if (file_exists($deleteStorageFile)) {
            $sdfsdfsadfsd = Storage::delete('public/'.$deleteStorageFile);
        }else{
            return null;
        }
        
    }
}
}