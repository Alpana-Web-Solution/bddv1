@extends('layouts.app')

@section('content')
  <div class="container-fluid">
  	@include('layouts.message')
    <div class="row justify-content-center">
      <div class="col-sm-12">
      	<div class="card shadow-sm">
      		<div class="card-header">
      			{{trans('Current Blood Donation Requests')}}
            <a class="btn btn-primary btn-sm" style="float: right;" href="{{route('admin.requisition.create')}}">{{__('Create')}}</a>
      		</div>
      		<div class="card-body " style="padding: 5px;" >
      			<table class="table table-responsive-sm table-hover table-outline mb-0">
              <thead>
                <tr>
                  <th>{{trans('ID')}}</th>
                  <th>{{trans('Group')}}</th>
                  <th>{{trans('Priority')}}</th>
                  <th>{{trans('Date')}}</th>
                  <th>{{trans('Status')}}</th>
                  
                  <th>{{trans('Action')}}</th>
                </tr>
              </thead>
              <tbody>
                @forelse($data as $d)
                <tr>
                  <td>{{$d->id}}</td>
                  <td>{{BloodGroupFunction($d->blood_group)}}</td>
                  <td>{{PriorityFunction($d->priority)}}</td>
                  <td>{{$d->when_wanted}}</td>
                  <td>{{StatusFunction($d->status)}}</td>
                  <td>
                    <form action="{{ route('admin.requisition.destroy',[$d->id]) }}" method="POST">
                      @csrf
                      @method('DELETE') 
                    <a class="btn btn-primary btn-sm" href="{{route('admin.requisition.show',$d->id)}}">{{trans('Show')}}</a>
                    <a class="btn btn-primary btn-sm" href="{{route('admin.requisition.edit',$d->id)}}">{{trans('Edit')}}</a>
                    <button type="submit"  class="btn btn-sm btn-danger" onclick="return confirm('{{__("Are you sure you want to Delete")}}')">{{__('Delete')}}</button>
                  </form>
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
      			<a class="btn btn-primary" href="{{url()->previous()}}">{{__('Back')}}</a>
      		</div>
      		
      	</div>
      </div>
  </div>
</div>
@endsection