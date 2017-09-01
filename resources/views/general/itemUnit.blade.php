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
						  	<div class="form-group">
							    <label class="col-sm-offset-2 col-sm-2 control-label">Unit Name</label>
							    <div class="col-sm-4">
							      <input type="text" name="unitname" class="form-control" placeholder="Unit name">
							    </div>
							    <button type="submit" class="btn btn-info col-sm-1">Save</button>
							</div>
						</form>

						<hr/>
						<div class="table-responsive" style="overflow-x: visible;">
							<table class="table table-hover table-bordered" id="RoomTbl">
						        <thead>
						            <tr>
						                <th>#</th>
						                <th>Unit Name</th>
						                <th>Action</th>
						            </tr>
						        </thead>
						        <tbody>
						        <?php $i = 1;?>
						        @foreach($unit as $u)
						        	<tr class="supplierRow{{$u->id}}">
						        		<td>{{ $i }}</td>
						        		<td>{{ $u->name }}</td>
						        		<td>
						        			<a href="#" id="e_{{$u->id}}" class="selectEdit">Edit</a> | 
						        			<a href="#" id="d_{{$u->id}}" class="selectDelete">Delete</a></td>
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
        	$(document).on('submit', "#unitForm",function (e) {
			 	e.preventDefault();
				var formData = new FormData(this);
				$.ajax({
					type: "POST",
					processData: false,
					contentType: false,
					url: "/addNewUnit",
					data: formData,
					success: function (response) {
					   window.setTimeout(function(){ document.location.reload(true); }, 100);
					},
					error: function () {
						alert('SYSTEM ERROR, TRY LATER AGAIN');
					}
				});
			});
        	$('#RoomTbl').dataTable( {
				"bPaginate": true
			});
			//add search icon
			$( ".dataTables_filter > label" ).append( "<span class='glyphicon glyphicon-search'></span>" );

			$(document).on('click',".selectEdit",function(){
				var get_Id=$(this).attr('id');
				var id=get_Id.substr(2,get_Id.length);
				var url = "/getSupplierid/"+id;
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
						url: "/deleteUnitItem",
						data: {sup_id:id},
						success: function (response) {
							$('.supplierRow'+id).hide(500);
						}
					});
				}
			});
		});

	</script>
@endsection