@extends('layouts.app')
@section('seo')
@include('requisition.parts.seo')
@endsection
@section('content')
@section('styles')
<link href="{{ asset('css/custom.css') }}" rel="stylesheet">
@endsection
  <div class="container-fluid">
  	@include('layouts.message')
    <div class="row justify-content-center">
      <div class="col-sm-12">
      	<div class="card card-accent-danger">
          <img class="bd-placeholder-img card-img-top" src="{{asset('images/requisition_background.jpg')}}" height="250px;">
      		<div class="card-header ">           
      			{{trans('Showing Requisition for ')}} {{$data->patient_name}}.
            <div class="card-header-actions">
              <a class="btn btn-primary btn-sm" href="{{url()->previous()}}">{{__("Back")}}</a>
              <span class="badge badge-danger " style="padding: 12px;">{{PriorityFunction($data->priority)}}</span>
            </div>
      		</div>
      		<div class="card-body">
            <strong >{{__("Priority")}} : {{PriorityFunction($data->priority)}}</strong><br>
            <strong >{{__("Request Status")}} : {{StatusFunction($data->status)}}</strong>
            <hr>
            @auth
            <h5>{{trans('Contact Details')}}:</h5>
            {{__("Name")}}:
            <strong>{{$data->contact_name}}</strong><br>
            {{__("Contact Number")}} :
            <strong>{{$data->contact}}</strong><br>
            {{__("Alternate Contact Number")}} :
            <strong>{{$data->alternate_contact}}</strong>
      			<hr>
            @endauth
            {{__("Hospital Name ")}}: <strong>{{$data->hospital_name}}</strong><br>
            {{__("Pincode ")}} : <strong>{{$data->pincode}}</strong><br>
            {{__("Blood Needed On")}}: <strong>{{$data->when_wanted}}</strong><br>
            {{__('Blood Group')}} : <strong>{{BloodGroupFunction($data->blood_group)}}</strong><br>
            {{__("Unit")}} : <strong>{{$data->unit}}</strong>
            <hr>
            @include('requisition.parts.donation_list')
      		</div>
      		<div class="card-footer ">
            @include('requisition.parts.comments')
      		</div>
      	</div>

      </div>
  </div>

</div>
@endsection