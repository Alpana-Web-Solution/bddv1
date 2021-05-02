<?php
/**
 * This service will handle all file uploads
 */
namespace App\Services;

use Auth;
use App\model\User;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

	/**
	 * This function class uploads to cloud or local storage.
	 */
	class ImageUploadService
	{
	/*
	* Local storage = 1, cloudinary storage = 1
	* Default storage for cloud is abdd, local is null
	*/
	private $defaultStorage = 0;
	private $defaultStoragePath;
	protected $userDetails;

	
	function __construct($userDetails = null)
	{ 
		if (empty($userDetails)) {
			if (auth()->user()) {
				$this->userDetails = auth()->user();
			}
			
			$this->userDetails = null;
			
			
		}
			$this->userDetails = $userDetails;
		
		
	}

	/*
	*	@param $formInputName is the form input field get from request().
	*	@param $subDirectory Subdirectory for the storage, this has a user dir for storing.
	*/

	public function avatarUpload($formInputName='file', $subDirectory='/avatar/')
	{
		// Delete existing file from server

		$usersDir = $subDirectory.$this->userDetails->id.'/';

		if (!empty($this->userDetails->avatar)) {

				$this->delete($this->userDetails->avatar,$usersDir);
			}

		// Upload image files to the server

		if (!empty(request()->file($formInputName))) {
			
				if ($this->defaultStorage == 1) {
                    // Cloudinary
					$uploadedFileUrl = request()->file->storeOnCloudinary('abdd/avatar/'.$this->userDetails->id);  
					return $uploadedFileUrl->getSecurePath();  
				}
                    // Local Storage
					$uploadedFileUrl = request()->file->store('public'.$usersDir);
					
					return url(asset('storage/avatar/'.$this->userDetails->id.str_replace('public'.$usersDir,'',$uploadedFileUrl)));
				
			
		}else{
			return null;
		}
	}


	public function requisitionUpload($formInputName='file', $subDirectory='/requisition/')
	{
		if (!empty(request()->file($formInputName))) {
			
				if ($this->defaultStorage == 1) {
                // Cloudnary
					$uploadedFileUrl = request()->file->storeOnCloudinary('abdd/'.\carbon\carbon::now()->toDateString());  
					return $uploadedFileUrl->getSecurePath();
				}
                // Local Storage
					$date = \carbon\carbon::now()->toDateString();
					$uploadedFileUrl = request()->file->store($subDirectory.$date, 'public');
                	// $request->file('file')->store('public/images');
					return 'storage/'.$uploadedFileUrl; 
				
			
		}
		
		return null;
		
		

	}

	public function certificateUpload($formInputName='file',$subDirectory='/certificate/')
	{
		// If file exists
        if (!empty(request()->file('certificate_template'))) 
        {
            // Get the organisation details
            $getOrgDetails = Setting::first();

            // If storage space is cloud and selected from org details.
            if (!empty($getOrgDetails) AND $getOrgDetails->document_hosting == 1) {

                $uploadedFileUrl = request()->certificate_template->storeOnCloudinary('abdd/certificate/');  
                return $uploadedFileUrl->getSecurePath();
            }              
                // If not uploading in public folder its just throwing 404 error.
                $uploadedFileUrl = request()->certificate_template->store('public/certificate');
                // change to the storage folder 
                return url(asset('storage/certificate/'.str_replace('public/certificate/','',$uploadedFileUrl)));
            
        }
            
        // If no image is passed return null.
        return null;
        
	}



	/*
	*	This will delete files form storage and cloud
	* 	@param $url Url of the file,
	*	@param $subfolder Subfolder for the file.
	*/
	public function delete($url = null,$subFolder = null)
	{

		$getImageURL = explode('/',$url);

		if ($getImageURL[2] == 'res.cloudinary.com') {

               $getPublicName = explode('.',$getImageURL[9]);
                
                $publicID = 'abdd/'.$getImageURL[8].'/'.$getPublicName[0];
                
                $test = cloudinary()->destroy($publicID);

            }

        // For local storage delete from here.
        $deleteStorageFile = basename($url);
        $sdfsdfsadfsd = Storage::delete('public'.$subFolder.'/'.$deleteStorageFile);
            
	}


}