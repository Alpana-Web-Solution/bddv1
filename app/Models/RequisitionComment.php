<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequisitionComment extends Model
{
    use HasFactory;
    
    protected $fillable = ['request_type','comment','user_id','requisition_id','status'];

	public function user()
    {
    	return $this->hasOne('\App\Models\User','id','user_id');
    }
}
