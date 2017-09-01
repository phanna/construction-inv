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
	.dateTooltip + .tooltip > .tooltip-inner {
	    background-color: #fff; 
	    color: #000; 
	    border: 1px solid #333;
	    padding: 10px;
	    font-size: 14px;
	}
</style>
	<div class="container">
		<div class="row">
			<div class="panel panel-default summary">
				<div class="panel-body">
					<div class="col-md-12">
						
						
						@include('inventory.inventoryList')
					</div>
				</div>
			</div>
		</div>
	</div>
  <!--Modal new inventory-->
<div class="modal fade" id="modelNewInventory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button"  class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span id="showTitle"></span> Inventory </h4>
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
          	$('#inventTbl').dataTable( {
        		"lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]]
      		});
      		//add search icon
      		$( ".dataTables_filter > label" ).append( "<span class='glyphicon glyphicon-search'></span>" );
        	// $('#modelNewInventory').modal({backdrop: 'static', keyboard: false}) ;
        	$('[data-toggle="tooltip"]').tooltip();
       		$(document).on('click', "#btnNewInventory",function () {
				var url = "/newItemModel";
				$('.modal-body').load(url,function(result){
					$('#modelNewInventory').modal({show:true});
				});
				$('#showTitle').html("New");
			});

			$(document).on('click',".selectItem",function(){
				var get_Id=$(this).attr('id');
				var id=get_Id.substr(8,get_Id.length);
				var url = "/editInventory/"+id;
				$('.modal-body').load(url,function(result){
					$('#modelNewInventory').modal({show:true});
				});
				$('#showTitle').html("Edit");
			});
			$(document).on('click', ".deleteItem",function () {
				var get_Id=$(this).attr('id');
				var idx=get_Id.substr(10,get_Id.length);
				var picture = $("#photo").val();
				if(confirm("Are you sure want to delete?")==true){
					$.ajax({
						type: "get",
						url: "/deleteItem",
						data: {item_id:idx,image:picture},
						success: function (response) {
						   	if(response == 'yes'){
								swal({
									title:"Delete data Success",
									text:"This update ready!",
									type:"success",  
									timer: 3000,   
									showConfirmButton: false
								});
								window.setTimeout(function(){ document.location.reload(true); }, 1000);
							}
						}
					});
				}
			});

		});
	</script>
@endsection