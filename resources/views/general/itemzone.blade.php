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
	.form-control{
		width: 93%;
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
						  	<div class="col-md-3">
						  		<div class="form-group">
							    	<label>Select Zone</label>
							      	<select name="zone_id" id="zone_id" class="form-control" required>
							      		<option value="">--Select Zone--</option>
							      		@foreach(App\Tbl_zones::all() as $zone)
							      			<option value="{{$zone->id}}">{{$zone->zone}}</option>
							      		@endforeach
							      	</select>
								</div>
							</div>
							<div class="col-md-3">
						  		<div class="form-group">
							    	<label>Select Item</label>
							      	<select name="item_id" id="item_id" class="form-control" required>
							      		<option value="">--Select Item--</option>
							      		@foreach(App\Tbl_item::all() as $item)
							      			<option value="{{$item->id}}">{{$item->item_name}} - {{$item->item_measure}}</option>
							      		@endforeach
							      	</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Quantity</label>
									<input type="number" name="qty" id="qty" class="form-control" placeholder="0" required>
								</div>
							</div>
							<div class="col-md-3" style="margin-top:22px;padding-bottom: 10px;">
								<div class="form-group">
									<button type="submit" class="btn btn-info">Save</button>
								</div>
							</div>
						</form>
					</div>
					<div class="col-md-12">
					<div class="table-responsive" style="overflow-x: visible;">
						<table class="table table-hover table-bordered" id="RoomTbl">
					        <thead>
					            <tr>
					                <th>#</th>
					                <th>Zone</th>
					                <th>Item</th>
					                <th>Limit Amount</th>
					                <th>Action</th>
					            </tr>
					        </thead>
					        <tbody>
					        <?php $i = 1;?>
					        @foreach(App\Tbl_zones_detail::orderBy('id','desc')->get() as $zone)
					        <?php 
					        	$zoneName = $zone->ZoneName();
					        	$itemName = $zone->ItemName();
					        ?>
					        	<tr class="supplierRow{{$zone->id}}">
					        		<td>{{ $i }}</td>
					        		<td>{{ $zoneName[$zone->zone_id] }}</td>
					        		<td>{{ $itemName[$zone->item_id] }}</td>
					        		<td>{{ $zone->qty }}</td>
					        		<td>
					        			<a href="#" id="e_{{$zone->id}}" class="selectEdit">Edit</a> | 
					        			<a href="#" id="d_{{$zone->id}}" class="selectDelete">Delete</a>
					        		</td>
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
					url: "/addItemzone",
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
				var url = "/EditItemZone/"+id;
				$.get(url,function(data){
                    var json = JSON.parse(data);
                    $('#zoneID').val(id);
                    $('#zone_id').val(json[0].zone_id);
                    $('#item_id').val(json[0].item_id);
                    $('#qty').val(json[0].qty);
                    $('#zone_id').css({"border":"2px solid #ccc", "background":"rgb(233, 235, 238)"});
                    $('#item_id').css({"border":"2px solid #ccc", "background":"rgb(233, 235, 238)"});
                    $('#qty').css({"border":"2px solid #ccc", "background":"rgb(233, 235, 238)"});
                    $("#qty").focus();
                });
			});
			$(document).on('click', ".selectDelete",function () {
				var get_Id=$(this).attr('id');
				var id=get_Id.substr(2,get_Id.length);
				if(confirm("Are you sure want to delete")==true){
					$.ajax({
						type: "get",
						url: "/deleteItemZone",
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