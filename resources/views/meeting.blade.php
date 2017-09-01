@extends('layouts.app')

@section('content')
<style type="text/css">
#chart-1 {
	min-width: 150px;
	max-width: 100%;
	margin: 0 auto;
}
.highcharts-credits{ display:none;}
	
div.bhoechie-tab-container{
  z-index: 10;
  background-color: #ffffff;
  padding: 0 !important;
  border-radius: 0px;
  -moz-border-radius: 0px;
  border:1px solid #ddd;
  margin-top: 0px;
  margin-left: 0px;
  -webkit-box-shadow: 0 6px 12px rgba(0,0,0,.175);
  box-shadow: 0 6px 12px rgba(0,0,0,.175);
  -moz-box-shadow: 0 6px 12px rgba(0,0,0,.175);
  background-clip: padding-box;
  opacity: 0.97;
  filter: alpha(opacity=97);
}


</style>
<div class="container">
   <?php //echo $chart_room[0];?>
    <div class="bhoechie-tab-container">
        <div class="col-md-12">
                <div class="panel-body">
                 	 <p align="right"><button type="button" class="btn btn-info" data-toggle="modal" data-target="#modelAddPost">New Post</button></p>
                  	<div class="col-xs-12">
							@foreach(App\Tbl_Post::orderBy('id','DESC')->get() as $obj)
									<div class="col-xs-4">
										<h4 align="right" style="color: #aaa;">{{$obj->getUser($obj->user_id)}}</h4>
									</div>
									<div class="col-xs-8" style="border-left: 1px solid #ccc;">
										<h4><a href="/meeting/{{$obj->id}}">{{$obj->title}} </a></h4>
										<p style="color: #aaa; font-style: italic; padding: 0px; margin: 0px; font-size: 13px;">{{$obj->created_at}} </p>
									</div>
							 
							 @endforeach
					</div>		
						
                </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modelAddPost" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel" style="color: teal;">Inventory In Room <span id="headingTitle"></span></h4>
      </div>
      <div class="modal-body">
       		<form method="post" id="addPost"	>
       		{{ csrf_field() }}
				  <div class="form-group">
					<label for="title">Title</label>
					<input type="text" class="form-control" id="title" name="title" placeholder="Type Something here..." required>
				  </div>
				  
				  <button type="submit" class="btn btn-default">Submit</button>
				</form>
      </div>
      
    </div>
  </div>
</div>
@endsection

@section('jquery')
 <script type="text/javascript">
$(function () {
	$(document).on('submit', "#addPost",function (e) {
		 	e.preventDefault();
			var formData = new FormData(this);
			$.ajax({
				type: "POST",
				processData: false,
				contentType: false,
				url: "/addpost",
				data: formData,
				success: function (response) {
				   $('#modelAddPost').modal('toggle');
				 //  window.setTimeout(function(){ document.location.reload(true); }, 100);
				},
				error: function () {
					alert('SYSTEM ERROR, TRY LATER AGAIN');
				}
			});
		});
});
	</script>
@endsection
