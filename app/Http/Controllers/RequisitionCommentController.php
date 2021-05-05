<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\RequisitionComment;
use App\Models\Requisition;
use Illuminate\Http\Request;

class RequisitionCommentController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($requisition,Request $request)
    {
        // ddd($request->all(),$requisition);
        $request->validate(['comment'=>'required']);
        $data = [
            'request_type'=>$request->type,
            'comment'=>$request->comment,
            'user_id'=>Auth::id(),
            'requisition_id'=>$requisition
        ];
        RequisitionComment::create($data);
        return redirect()->back()->with('info',__('Comment added successfully.'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RequisitionComment  $requisitionComment
     * @return \Illuminate\Http\Response
     */
    public function destroy($requisition,$requisitionComment)
    {
        RequisitionComment::where(['requisition_id'=>$requisition,'id'=>$requisitionComment,'user_id'=>Auth::id()])->firstOrFail()->delete();
        // dd($requisition,$requisitionComment);
        return back()->with('info',__('Comment Deleted.'));
    }
}
