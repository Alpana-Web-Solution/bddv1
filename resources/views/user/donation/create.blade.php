@extends('layouts.app')

@section('content')
  <div class="container">
  	@include('layouts.message')
    <div class="row justify-content-center">
      <div class="col-sm-10">
      	<div class="card">
      		<div class="card-header">
      			{{trans('Create Blood Donation Entry.')}}
      		</div>
      		<div class="card-body">
      			<form action="{{route('donation.store')}}" method="POST">
              @csrf
              
                  <div class="form-group">    
                    <label for="type">{{trans('Donation Type')}} : </label>
                    <select class="form-control @error('type') is-invalid @enderror" name="type">
                      <option value="1">{{trans('Whole Blood')}}</option>
                    </select>
                    @error('type')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                    @enderror
                  </div>
                  <div class="form-group">
                          <label for="message-text" class="col-form-label">{{trans('Message')}}:</label>
                          <textarea class="form-control @error('comment') is-invalid @enderror" name="comment" id="message-text"></textarea>
                          @error('comment')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                  </div>
                  <div class="form-group">
                          <label for="unit-text" class="col-form-label ">{{trans('Unit')}}:</label>
                          <input type="number" class="form-control @error('unit') is-invalid @enderror" name="unit" id="unit-text"></input>
                          @error('unit')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                  </div>
                  <div class="form-group col-sm-6">
                        <label for="when_wanted">{{trans('Donation Date')}} :</label>
                        <div class="row">
                        <div class="col-sm-6">
                          <input class="form-control @error('date') is-invalid @enderror" id="date" name="date" type="date" value="">
                          @error('date')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                        </div>
                        <div class="col-sm-6">
                          <input class="form-control" id="time" name="time" type="time" value="">
                        </div>
                      </div>
                  </div>
              

              <button type="submit" class="btn btn-success">{{__("Save")}}</button>
            </form>
      		</div>
      		<div class="card-footer">
      			<a class="btn btn-primary" href="{{url()->previous()}}">{{__("Back")}}</a>
      		</div>
      		
      	</div>
      </div>
  </div>
</div>
@endsection