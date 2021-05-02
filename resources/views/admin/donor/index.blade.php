@extends('layouts.app')

@section('content')
  <div class="container-fluid">
  	@include('layouts.message')
    <div class="row justify-content-center">
      <div class="col-sm-12">
      	<div class="card " >
      		<div class="card-header">
      			{{trans('Blood Donor List')}}
      		</div>
      		<div class="card-body" style="padding: 0px;">
      			<table class="table table-sm table-bordered table-responsive-sm">
              <thead>
                <tr>
                  <th>{{trans('ID')}}</th>
                  <th>{{trans('Name')}}</th>
                  <td>{{trans('Blood Group')}}</td>
                  <td>{{trans('Last Donated')}}</td>
                  <td>{{trans("Can't Donate")}}</td>
                  <th>{{trans('Action')}}</th>
                </tr>
              </thead>
              <tbody>
                @forelse($data as $d)
                <tr @if($d->last_donated)
                      @if($d->last_donated->diffInDays(\Carbon\Carbon::now()) < 60)
                      class="table-danger"
                      @endif
                    @else
                    class="table-info"
                    @endif
                >
                  <td>{{$d->id}}</td>
                  <td>{{$d->name}}</td>
                  <td>{{BloodGroupFunction($d->blood_group)}}</td>
                  <td>{{$d->last_donated ?$d->last_donated->diffForHumans():"N/A"}}</td>
                  <td>{{$d->can_not_donate_until ? $d->can_not_donate_until->diffForHumans(): trans("Ready to Donate.")}}</td>
                  <td>
                    <a class="btn btn-primary btn-sm" href="{{route('admin.donor.show',$d->id)}}">{{trans('Donation List')}}</a>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="2">{{__("Sorry ! No Data Found.")}}</td>
                  
                </tr>
                
                @endforelse
                
              </tbody>
              
            </table>
            {{$data->links()}}
      		</div>
      		<div class="card-footer">
      			<a class="btn btn-primary" href="{{url()->previous()}}">{{__("Back")}}</a>
      		</div>
      		
      	</div>
      </div>
  </div>
</div>
@endsection