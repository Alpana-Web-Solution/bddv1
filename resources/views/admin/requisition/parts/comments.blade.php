<div >
     <div class="card col-sm-12">
      <div class="card-header ">
        <div class="card-header-actions">
          <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#comment">{{__('Donate')}}</button>
      <button style="margin-left: 10px;" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#seo">{{__('SEO')}}</button>
        </div>
      </div>
        <form action="{{route('requisition.comment.store',$data->id)}}" method="POST">
          @csrf
          <input type="hidden" name="type" value="0">
          <div class="form-group">
            <label for="message-text" class="col-form-label">{{__('Message')}}:</label>
            <textarea class="form-control" name="comment" id="message-text"></textarea>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-sm btn-success">{{__('Save')}}</button>
          </div>
        </form>
        
     </div>


            <div  class="modal fade seo" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="seo">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        @include('admin.requisition.parts.seo_form')
                      </div>
                    </div>
                  </div>

            @if($data->img)
            <button style="margin-left: 10px;" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".bd-example-modal-lg">{{__('Requisition Image')}}.</button>
            
            <div  class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <img src="{{ asset($data->img) }}" alt="" title="">
                      </div>
                    </div>
                  </div>
            @endif
              <div class="modal fade" id="comment" tabindex="-1" role="dialog" aria-labelledby="comment" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">{{__("Donate Blood")}}</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <form action="{{route('requisition.donation',$data->id)}}" method="POST">
                        @csrf
                       <div class="form-group">
                          <div class="form-group">    
                              <label for="type">{{__('Comment Type')}} : </label>
                              <select class="form-control" name="type">
                                <option value="1">{{__('Blood Donation')}}</option>
                                <option value="2">{{__('Others')}}</option>
                              </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="message-text" class="col-form-label">{{__('Unit')}}:</label>
                          <input type="number" name="unit" class="form-control">
                        </div>
                        <div class="form-group">
                          <label for="message-text" class="col-form-label">{{__('Message')}}:</label>
                          <textarea class="form-control" name="comment" id="message-text"></textarea>
                        </div>
                      
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__("Close")}}</button>
                      <button type="submit" class="btn btn-primary">{{__('Send message')}}</button>
                    </div>
                    </form>
                  </div>
                </div>
              </div> 
              
            </div>
            
      			   <div class="comment-widgets">
                @forelse($data->comments as $comment)
                                <!-- Comment Row -->
                <div class="d-flex flex-row comment-row m-t-0">
                    <div class="p-2 " style="padding: 0.5rem !important;">
                      <img src="https://res.cloudinary.com/debjit/image/upload/w_50,h_50/149_50_logo_uas3uf.png" alt="user" width="50" height="50" class="rounded-circle border"></div>
                    <div class="comment-text w-100">
                      <div class="card-header-actions">
                        <form action="{{ route('admin.requisition.comment.destroy',[$data->id,$comment->id]) }}" method="POST">
                          @csrf
                          @method('DELETE') 
                        @if($comment->request_type == 1)
                        <a class="btn btn-primary btn-sm" href="{{route('admin.requisition.comment.show',[$data->id,$comment->id])}}"><i class="fas fa-tint"></i>
                        </a>
                        @endif
                        <a class="btn btn-primary btn-sm" href="{{route('admin.requisition.comment.show',[$data->id,$comment->id])}}"><i class="fa fa-eye"></i></a>
                          <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('{{__("Are you sure you want to Delete")}}')"><i class="fa fa-trash"></i></button>
                        </form>
                      </div>
                        <h6 class="font-medium">{{$comment->user->name}}</h6> <span class="m-b-15 d-block">{{$comment->comment}}</span>
                        <div class="comment-footer"> <span class="text-muted float-right">{{$comment->created_at->diffForHumans()}}</span>
                        
                    </div>
                    </div>
                </div> <!-- Comment Row -->
                @empty
                <div class="text-center">
                {{__("Sorry! No comment found.")}}
                </div>
                
                @endforelse
            </div> <!-- Card -->