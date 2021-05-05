@extends('layouts.app')

@section('content')
  <div class="container-fluid">
  	@include('layouts.message')
    <div class="row justify-content-center">

      <div class="col-sm-12">
      	<div class="card shadow-sm">
      		<div class="card-header">
            <div class="card-header-actions">
              <a class="btn btn-sm btn-success" href="{{route('admin.requisition.donation.create',$requisition->id)}}">{{__("Manual Donation Entry")}}</a>
            </div>
      			{{trans('List of donors request.')}}
      		</div>
      		<div class="card-body">
      			<table class="table">
              <thead>
                <tr>
                  <th>{{trans('Status')}}</th>
                  <th>{{trans('Type')}}</th>
                  <th>{{trans('Unit')}}</th>
                  <th>{{trans('Name')}}</th>
                  <th>{{trans('Action')}}</th>
                </tr>
              </thead>
              <tbody>
                @forelse($data as $d)
                <tr>
                  <td>@if($d->status == 1)<i  class="fas fa-tint text-danger"></i>@else<i  class="fas fa-tint"> ?</i>@endif</td>
                  <td>{{TypeFunction($d->type ?? 1)}}</td>
                  <td>{{$d->user->name}}</td>
                  <td>{{$d->unit}}</td>
                  <td>
                    <form action="{{ route('admin.requisition.comment.destroy',[$requisition->id,$d->id]) }}" method="POST">
                    @csrf
                    @method('DELETE') 

                    <a class="btn btn-primary btn-sm" href="{{route('admin.requisition.donation.show',[$requisition->id,$d->id])}}">{{trans('Show')}}</a>
                    <button type="submit"  class="btn btn-sm btn-danger" onclick="return confirm('{{__("Are you sure you want to Delete")}}')">{{__("Delete")}}</button>
                        </form>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="5">{{__("Sorry ! No Data Found.")}}</td>
                </tr>
                
                @endforelse
                
              </tbody>
              
            </table>
      		</div>
      		<div class="card-footer">
      			<a class="btn btn-primary" href="{{url()->previous()}}">{{__('Back')}}</a>
      		</div>
      		
      	</div>
      </div>
            <div class="col-sm-12">
        <div class="card  shadow-sm">
          <div class="card-body">
            @include('admin.requisition.parts.comment_donation_list')      
          </div>
          <div class="card-footer">
            <a class="btn btn-primary" href="{{url()->previous()}}">{{__('Back')}}</a>
          </div>
        
        </div>
        
      </div>
  </div>
</div>
@endsection