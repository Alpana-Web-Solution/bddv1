@extends('layouts.app')

@section('content')
  <div class="container-fluid">
  	@include('layouts.message')
    <div class="row justify-content-center">
      <div class="col-sm-12">
      	<div class="card shadow-sm">
      		<div class="card-header">
            {{__('Manage User')}}
      			<div class="card-header-actions">
              <a class="btn btn-primary btn-sm" href="{{route('admin.usermanager.create')}}">{{trans('Create')}}</a>
            </div>
      		</div>
      		<div class="card-body" style="padding: 5px;">
      			<table class="table table-responsive-sm table-hover table-outline mb-0">
              <thead class="dark-thread">
                <tr >
                  <th>{{trans('ID')}}</th>
                  <th>{{trans('Name')}}</th>
                  <th>{{trans('Username')}}</th>
                  <th>{{trans('Action')}}</th>
                </tr>
              </thead>
              <tbody>
                @forelse($data as $d)
                <tr>
                  <td>{{$d->id}}</td>
                  <th>{{$d->name}}</th>
                  <th>{{$d->username}}</th>
                  <td>
                    <form action="{{ route('admin.usermanager.destroy',[$d->id]) }}" method="POST">
                    @csrf
                    @method('DELETE') 
                    <a class="btn btn-primary btn-sm" href="{{route('admin.usermanager.show',$d->id)}}">{{trans('Show')}}</a>
                    <a class="btn btn-primary btn-sm" href="{{route('admin.usermanager.edit',$d->id)}}">{{trans('Edit')}}</a>
                    <button type="submit"  class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to Delete')">{{trans('Delete')}}</button>
                        </form>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="2">Sorry ! No Data Found.</td>
                  
                </tr>
                
                @endforelse
                
              </tbody>
            </table>
            {{$data->links()}}
      		</div>
      		<div class="card-footer">
      			<a class="btn btn-primary" href="{{url()->previous()}}">{{trans('Back')}}</a>
      		</div>
      		
      	</div>
      </div>
  </div>
</div>
@endsection