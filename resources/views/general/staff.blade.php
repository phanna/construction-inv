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
						<h3>Staff</h3>
		            	<hr/>
						<button class="btn btn-info" id="btnAddNew">Add Staff</button>
						<a href="/generalSetting" class="btn btn-default">Back</a>
						<hr/>
						<div class="table-responsive" style="overflow-x: visible;">
						<table class="table table-hover table-bordered" id="RoomTbl">
					        <thead>
					            <tr>
					                <th>#</th>
					                <th>Name</th>
					                <th>Telephone Number</th>
					                <th>Gender</th>
					                <th>Position</th>
					                <th>Type</th>
					                <th>Group</th>
					                <th>Action</th>
					            </tr>
					        </thead>
					        <tbody>
					        <?php $i = 1;?>
					        @foreach(App\Tbl_staffs::orderBy('id','desc')->get() as $staff)
					        	<tr class="stafflierRow{{$staff->id}}">
					        		<td>{{ $i }}</td>
					        		<td>{{ $staff->staff_name }}</td>
					        		<td>{{ $staff->phone_number }}</td>
					        		<td>{{ ($staff->gender)==1?'Male':'Famele' }}</td>
					        		<td>{{ $staff->position }}</td>
					        		<td>{{ $staff->type }}</td>
					        		<td>{{ $staff->staff_group }}</td>
					        		<td>
					        			<a href="#" id="e_{{$staff->id}}" class="selectEdit">Edit</a> | 
					        			<a href="#" id="d_{{$staff->id}}" class="selectDelete">Delete</a></td>
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
	<div class="modal fade" id="modalAddform" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  	<div class="modal-dialog" role="document">
	    	<div class="modal-content">
	      		<div class="modal-header">
	        		<button type="button"  class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        		<h4 class="modal-title" id="myModalLabel">
	        			Reciver Profile
	        		</h4>
	      		</div>
	      	<div class="modal-body">

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

       		$(document).on('click', "#btnAddNew",function () {
				var url = "/newstaffForm";
				$('.modal-body').load(url,function(result){
					$('#modalAddform').modal({show:true});
				});
			});

			$(document).on('click',".selectEdit",function(){
				var get_Id=$(this).attr('id');
				var id=get_Id.substr(2,get_Id.length);
				var url = "/getstafflId/"+id;
				$('.modal-body').load(url,function(result){
					$('#modalAddform').modal({show:true});
				});
			});
			$(document).on('click', ".selectDelete",function () {
				var get_Id=$(this).attr('id');
				var id=get_Id.substr(2,get_Id.length);
				if(confirm("Are you sure want to delete")==true){
					$.ajax({
						type: "get",
						url: "/deleteReceiver",
						data: {sup_id:id},
						success: function (response) {
							if(response=='yes')
								$('.stafflierRow'+id).hide(500);
						}
					});
				}
			});
		});

	</script>
@endsection