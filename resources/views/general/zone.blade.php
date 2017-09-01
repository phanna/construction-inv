@extends('layouts.app')

@section('content')
<style type="text/css" media="screen">
	.glyphicon-search{
		right: 23px;
		top: 3px;
	}
	table.dataTable{
		border-bottom: 1px solid #ccc;
	}
	table.dataTable thead .sorting{
		background:none !important;
	}
	table.dataTable thead .sorting_asc{
		background:none !important;
	}
	tr th, tr td{
		text-align: center;
	}	
</style>
	<div class="container">
		<div class="row">
			<div class="panel panel-default summary">
				<div class="panel-body">
					<div class="col-md-12">
						<form class="form-horizontal" id="unitForm">
						  	{{ csrf_field() }}
						  	<input type="hidden" name="zoneID" value="" id="zoneID">
						  	<div class="form-group">
							    <label class="col-sm-offset-2 col-sm-2 control-label">Add Zone</label>
							    <div class="col-sm-4" style="padding-bottom: 10px;">
							      <input type="text" name="zonename" id="zonename" class="form-control" placeholder="Zone" required>
							    </div>
							    <div class="col-sm-2">
							    <button type="submit" class="btn btn-info col-sm-12">Save</button>
							    </div>
							</div>
						</form>

						<hr/>
						<div class="table-responsive" style="overflow-x: visible;">
						<table class="table table-hover table-bordered" id="RoomTbl">
					        <thead>
					            <tr>
					                <th>#</th>
					                <th>Zone Name</th>
					                <th>Action</th>
					            </tr>
					        </thead>
					        <tbody>
					        <?php $i = 1;?>
					        @foreach(App\Tbl_zones::orderBy('id','desc')->get() as $zone)
					        	<tr class="supplierRow{{$zone->id}}">
					        		<td>{{ $i }}</td>
					        		<td>{{ $zone->zone }}</td>
					        		<td>
					        			<a href="#" id="e_{{$zone->id}}" class="selectEdit">Edit</a> | 
					        			<a href="#" id="d_{{$zone->id}}" class="selectDelete">Delete</a></td>
					        	</tr>
					        	<?php $i++; ?>
					        @endforeach
					        </tbody>
					    </table>
					    </div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('jquery')
	<script src ="{{ asset('js/jquery.dataTables.min.js')}}"></script>
	<script src ="{{ asset('js/dataTables.bootstrap.js')}}"></script>
	<link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap.css')}}">
    <script>
	
        $(function () {
        	
        	$('#RoomTbl').dataTable( {
				"bPaginate": true
			});
			//add search icon
			$( ".dataTables_filter > label" ).append( "<span class='glyphicon glyphicon-search'></span>" );

			$(document).on('submit', "#unitForm",function (e) {
			 	e.preventDefault();
				var formData = new FormData(this);
				$.ajax({
					type: "POST",
					processData: false,
					contentType: false,
					url: "/addNewZone",
					data: formData,
					success: function (response) {
					   window.setTimeout(function(){ document.location.reload(true); }, 100);
					},
					error: function () {
						alert('SYSTEM ERROR, TRY LATER AGAIN');
					}
				});
			});
			$(document).on('click',".selectEdit",function(){
				var get_Id=$(this).attr('id');
				var id=get_Id.substr(2,get_Id.length);
				var url = "/EditZone/"+id;
				$.get(url,function(data){
                    var json = JSON.parse(data);
                    $('#zoneID').val(id);
                    $('#zonename').val(json[0].zone);
                    $('#zonename').css({"border":"2px solid #ccc", "background":"rgb(233, 235, 238)"});
                    $("#zonename").focus();
                });
			});
			$(document).on('click', ".selectDelete",function () {
				var get_Id=$(this).attr('id');
				var id=get_Id.substr(2,get_Id.length);
				if(confirm("Are you sure want to delete")==true){
					$.ajax({
						type: "get",
						url: "/deleteZone",
						data: {zone_id:id},
						success: function (response) {
							$('.supplierRow'+id).hide(500);
						}
					});
				}
			});
		});

	</script>
@endsection