@extends('layouts.app')

@section('content')
	<style>
		input[type=number]::-webkit-inner-spin-button {
		  -webkit-appearance: none;
		}
		tr td{
			vertical-align: middle !important;
			text-align: center;
		}
		tr th{
			text-align: center;
		}
		.item_head {
			font-size: large;
			
		}
	</style>
	<div class="container">
		<div class="row">
			<div class="panel panel-default summary">
				<div class="panel-body">
				<p>
					<a href="/newInventory" class="btn btn-info" style="float: right">
						<span class="glyphicon glyphicon-chevron-left"></span>Back
					</a>
				</p>
				<div style="clear:both;"></div>
					<div class="col-md-12">
						<hr/>
						<div class="table-responsive" style="overflow-x: visible;">
						<table class="table ">
							<thead>
								<tr></tr>
							</thead>
							<tbody style="border: 2px solid #00aba9;">
								<tr>
									
									<td class="item_head">{{ isset($itemID[0])?$itemID[0]->item_code:'' }}</td>
									<td class="item_head">{{ isset($itemID[0])?$itemID[0]->item_name:'' }}</td>
									<td class="item_head">{{ isset($itemID[0])?$itemID[0]->item_model:'' }}</td>
									<td class="item_head">{{ isset($itemID[0])?$array_category[$itemID[0]->item_category_id]:'' }}</td>
									<td class="item_head">{{ isset($itemID[0])?$itemID[0]->item_measure:'' }}</td>
									<td >
									@if($itemID[0]->photo)
			                            <div style="
			                            	background-image:url(../uploads/{{ $itemID[0]->photo }}); background-size:cover; background-position:center; height:80px; width:100px;background-repeat: no-repeat; border-radius: 8px; border:1px solid #eee; ">
			                            </div>
			                        @else
			                        	<div style="background-image:url(../imgs/noimg.png); background-size:cover; background-position:top; height:50px; width:80px; border-radius: 8px; border:1px solid #eee;"></div>
			                            
			                        @endif</td>
			                  
								</tr>
							</tbody>
						</table>
						</div>
<div class="row">
	<div class="col-md-12">
	<div class="alert alert-info" align="center">
		Total Stock: <strong> <span style="font-size: 24px;"> &nbsp;{{ $totalStock }}</span></strong>
	</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<p><button class="btn btn-info" id="btnNewStock">New Stock</button></p>
		<h3 class="alert alert-success">Stock Enter</h3>
		<div class="table-responsive" style="overflow-x: visible;">
			<table class="table table-striped table-bordered" id="inventTbl">
						        <thead>
						            <tr>
						            	<th>#</th>
						                <th>Date</th>
						                <th>Amount</th>
						                <th>Unit Price</th>
						                <th>Total</th>
						                <th>Action</th>
						            </tr>
						        </thead>
						        <tbody>
						        <?php $total_amount=0; $i = 1;$subtotal = 0;?>
						        @foreach($itemStock as $stock)
						        	@if($stock->status==0)
											<?php 
												$total_amount+=$stock->amount;
												$total_price = $stock->amount*$stock->unit_price;
												$subtotal+=$total_price; 
											?>
									
						        	<tr>
						        		<td>{{ $i }}</td>
						        		<td>{{ date('M d, Y', strtotime($stock->purchase_date)) }}</td>
						        		<td>{{ $stock->amount }}</td>
						        		<td>$ {{ $stock->unit_price }}</td>
						        		<td>$ {{ $total_price }}</td>
						        		<td><a href="#" id="edit_{{ $stock->id }}" class="selectStockEnter">Edit</a> | <a href="#" class="deleteStock" id="delete_{{$stock->id}}">Delete</a></td>
						        	</tr>
						        	<?php $i++; ?>
						        	@endif
						        @endforeach
						        </tbody>
						        <tfoot>
						        	<tr>
						        		<th></th>
						        		<th >Total amount: </th>
						        		<th><?php echo $total_amount?></th>
						        		<th>SubTotal</th>
						        		<th>$ <?php echo $subtotal ?></th>
						        		<th></th>
						        	</tr>
						        </tfoot>
			</table>
		</div>
		
	</div>
	<div class="col-md-6">
		<p align="right"><button class="btn btn-danger" id="btnNewBroken">Broken</button></p>
		<h3 class="alert alert-danger">Broken Stock</h3>
		<div class="table-responsive" style="overflow-x: visible;">
			<table class="table table-striped table-bordered" id="inventTbl">
						        <thead>  
						            <tr>
						            	<th>#</th>
						                <th>Date</th>
						                <th>Amount</th>
						                <th>Action</th>
						            </tr>
						        </thead>
						        <tbody>
						        <?php $total_amount_broken=0; $y = 1;?>
						        @foreach($itemStock as $stock)
						        	@if($stock->status==2)
										<?php $total_amount_broken+=$stock->amount ?>
						        	<tr>
						        		<td>{{ $y }}</td>
						        		<td>{{ date('M d, Y', strtotime($stock->purchase_date)) }}</td>
						        		<td>{{ $stock->amount }}</td>
						        		<td><a href="#" id="edit_{{ $stock->id }}" class="selectStockBroken">Edit</a> | <a href="#" class="deleteStock" id="delete_{{$stock->id}}">Delete</a></td>
						        	</tr>
						        	<?php $y++; ?>
						        	@endif
						        @endforeach
						        </tbody>
						        <tfoot>
						        	<tr>
						        		<th></th>
						        		<th>Total amount: </th>
						        		<th><?php echo $total_amount_broken?></th>
						        		<th></th>
						        	</tr>
						        </tfoot>
			</table>
		</div>
		
	</div>
</div>
<div class="row">
<div class="col-md-12">
<h3 class="alert alert-warning">Taken</h3>
	<div class="table-responsive" style="overflow-x: visible;">
		<table class="table table-striped table-bordered" id="inventTbl">
						        <thead>  
						            <tr>
						            	<th>#</th>
						                <th>Date</th>
						                <th>Amount</th>
						                <th>Responded By</th>
						            </tr>
						        </thead>
						        <tbody>
						        <?php $total_amount_taken=0; $y = 1;?>
						        @foreach($itemStock as $taken)
						        	@if($taken->status==1)
										<?php $total_amount_taken+=$taken->amount ?>
						        	<tr>
						        		<td>{{ $y }}</td>
						        		<td>{{ date('M d, Y', strtotime($taken->purchase_date)) }}</td>
						        		<td>{{ $taken->amount }}</td>
						        		<td></td>
						        	</tr>
						        	<?php $y++; ?>
						        	@endif
						        @endforeach
						        </tbody>
						        <tfoot>
						        	<tr>
						        		<th></th>
						        		<th>Total amount: </th>
						        		<th><?php echo $total_amount_taken?></th>
						        		<th></th>
						        	</tr>
						        </tfoot>
		</table>
	</div>
	</div>
</div>

					
					
						
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--//////////////////////////////////-->
	<div class="modal fade" id="modelNewStock" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button"  class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel"><span id="showTitle"></span> Inventory Stock</h4>
	      </div>
	      	<div class="modal-body">
			</div>
	   </div>
	 </div>
	</div>
	<!--//////////////////////////////////-->
	<div class="modal fade" id="modelNewBroken" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      	<div class="modal-header">
	        	<button type="button"  class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        	<h4 class="modal-title" id="myModalLabel"><span id="showTitle"></span> Broken Stock </h4>
	      	</div>
	      	<div class="modal-body">
	      	
			</div>
	   </div>
	 </div>
	</div>
@endsection
@section('jquery')
    <script>
        $(function () {

       		$(document).on('click', "#btnNewStock",function () {
				var url = "/newStockModal/{{ isset($itemID[0])?$itemID[0]->id:'' }}/0";
				$('.modal-body').load(url,function(result){
					$('#modelNewStock').modal({show:true});
				});
			});

			//----------------Broken
			$(document).on('click', "#btnNewBroken",function () {
				var url = "/newStockModal/{{ isset($itemID[0])?$itemID[0]->id:'' }}/2";
				$('.modal-body').load(url,function(result){
					$('#modelNewStock').modal({show:true});
				});
			});

			$(document).on('click',".selectStockEnter",function(){
				var get_Id=$(this).attr('id');
				var id=get_Id.substr(5,get_Id.length);
				var url = "/editStock/{{ isset($itemID[0])?$itemID[0]->id:'' }}/"+id+"/0";
				$('.modal-body').load(url,function(result){
					$('#modelNewStock').modal({show:true});
				});
			});
			$(document).on('click',".selectStockBroken",function(){
				var get_Id=$(this).attr('id');
				var id=get_Id.substr(5,get_Id.length);
				var url = "/editStock/{{ isset($itemID[0])?$itemID[0]->id:'' }}/"+id+"/2";
				$('.modal-body').load(url,function(result){
					$('#modelNewStock').modal({show:true});
				});
			});

			$(document).on('click', ".deleteStock",function () {
				var get_Id=$(this).attr('id');
				var idx=get_Id.substr(7,get_Id.length);
				if(confirm("Are you sure want to delete?")==true){
					$.ajax({
						type: "get",
						url: "/deleteStock",
						data: {stock_id:idx},
						success: function (response) {
						   	if(response == 'yes'){
								swal({
									title:"Delete data Success",
									text:"This delete ready!",
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