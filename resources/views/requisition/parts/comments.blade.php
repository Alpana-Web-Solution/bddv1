<div class="content-center">
              @if(Auth::id())
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#comment" data-whatever="@mdo">{{__('Comment')}}</button>
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
                      <h5 class="modal-title" id="exampleModalLabel">{{__('Create Message')}}</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <form action="{{route('requisition.comment.store',$data->id)}}" method="POST">
                        @csrf
                       <div class="form-group">
                          <div class="form-group">    
                              <label for="type">{{__('Comment Type')}} : </label>
                              <select class="form-control" name="type">
                                <option value="0">{{__('Comment')}}</option>
                                <option value="1">{{__('Blood Donation')}}</option>
                                <option value="2">{{__('Others')}}</option>
                              </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="message-text" class="col-form-label">{{__('Message')}}:</label>
                          <textarea class="form-control" name="comment" id="message-text"></textarea>
                        </div>
                      
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                      <button type="submit" class="btn btn-primary">{{__("Send message")}}</button>
                    </div>
                    </form>
                  </div>
                </div>
              </div> 
              @endif 
            </div>
            
      			   <div class="comment-widgets">
                @forelse($data->comments as $comment)
                                <!-- Comment Row -->
                <div class="d-flex flex-row comment-row m-t-0">
                    <div class="p-2" style="padding: 0.5rem !important;"><img src="https://res.cloudinary.com/debjit/image/upload/v1598972041/149_50_logo_uas3uf.png" alt="user" width="50" class="rounded-circle">
                    </div>
                    <div class="comment-text w-100">
                        <h6 class="font-medium">{{$comment->user->name}}</h6> <span class="m-b-15 d-block">{{$comment->comment}}</span>
                        <div class="comment-footer"> <span class="text-muted float-right">{{$comment->created_at->diffForHumans()}}</span>
                        @if(Auth::id() == $comment->user_id)
                        <button type="button" class="btn btn-info btn-sm">{{__('Edit')}}</button>
                        <button type="button" class="btn btn-success btn-sm">{{__("Publish")}}</button>
                        <button type="button" class="btn btn-danger btn-sm">{{__("Delete")}}</button>
                        @endif
                    </div>
                    </div>
                </div> <!-- Comment Row -->
                @empty
                <div class="text-center " style="margin-top: 10px;">
                <p>{{__('Sorry! No comment found.')}}</p>
                </div>
                
                @endforelse
            </div> <!-- Card -->