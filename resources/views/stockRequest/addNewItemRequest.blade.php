@extends('layouts.app')

@section('content')
<style>
	#btnAddItem{
		margin-bottom: 10px;
	}
	input[type=number]::-webkit-inner-spin-button {
	  -webkit-appearance: none;
	}
	.select2-dropdown { border-radius: 0px;}
	.select2-container { width:100% !important;} 
	.selete-textbox{ 
		height: 28px;
    	border: 1px solid #999;
	}
	.select2-container--default .select2-selection--single {  border-radius: 0px !important; height: 34px !important;}
	.select2-container--default .select2-selection--single .select2-selection__rendered { line-height: 34px;}
	.btnadd{
		margin-top:22px;
	}
</style>
<div class="container">
    <div class="row">
        <div class="panel panel-default summary">
            <div class="panel-body">
            	
				<div class="col-sm-12 col-md-12 cover_thumbnail_2" id="">
					<h3>Request Item</h3>
                	<hr/>
					<form method="post" id="submitForm">
						{{ csrf_field() }}
						
						<div class="col-sm-3">
							<div class="form-group">
								<p style="margin: 0px;"><label>Item Name</label></p>
								<select name="item_id" id="item_id" class="form-control select_item_id">
									<option value="">-Select Item Name-</option>
									@foreach(App\ItemCategory::all() as $objCate)
									@if($objCate->getItemList->count()>0)
									<optgroup label="{{ $objCate->category_name }}">
										@foreach($objCate->getItemList as $obj)
											@foreach($objCate->getItemNameHasStock($obj->id) as $objItem)
											<option value="{{ $objItem->id }}">
												{{ $objItem->item_name }} - 
												{{ $objItem->item_measure }}
											</option>
											@endforeach
										@endforeach
									</optgroup>
									@endif
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="form-group">
								<label>Quantity</label>
								<input type="number" name="item_qty" id="item_qty" class="form-control" placeholder="0">
								<span id="showMsg_stock_error"></span>
							</div>
						</div>
						
						<div class="col-sm-3">
							<div class="form-group">
					        	<button type="button" name="submit_" class="btn btnadd btn-primary submit_" id="submit_" onclick="buttonClick();">Add Item</button>
					        	<a href="/stockRequest" type="reset" class="btn btnadd btn-default" data-dismiss="modal">Back</a>
					        </div>
				        </div>
						<div class="col-md-12">
							<hr style="clear: both" />
							<div class="table-responsive" style="overflow-x: visible;">
								<table class="table table-striped table-bordered">
									<tr>
										<th>#</th>
										<th>Item Code</th>
										<th>Item Name</th>
										<th>Amount</th>
										<th>Measure</th>
										<th>Action</th>
									</tr>
									<tbody id="showReturnInserted">
										@if(isset($itemID))
											<?php $x = 1; ?>
											<input type="hidden" name="invID" value="{{ $itemID }}">
											@foreach($getSaleDetail as $detail)
												<tr>
												<input type="hidden" name="itemId[]" value="{{$detail->id}}">
												<input type="hidden" name="amount[]" value="{{ $detail->qty }}">
												<input type="hidden" name="price[]" value="{{ $detail->unit_price }}">

													<td>{{ $x }}</td>
													<td>{{ $detail->item_code }}</td>
													<td>{{ $detail->item_name }}</td>
													<td>{{ $detail->qty }}</td>
													<td>{{ $detail->item_measure }}</td>
													<td><button type="button" class="btn btn-danger" onclick="deleteRow(this)">X</button></td>
												</tr>
												<?php $x++; ?>
											@endforeach
										@endif
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-sm-2">
							<div class="form-group">
								<label>Request Name</label>
								<select name="staffname" class="form-control" required>
									<option value="">--Select Name--</option>
									@foreach(App\Tbl_staffs::all() as $staff)
										<option value="{{ $staff->id }}" 
											@if(isset($getSaleDetail[0]))
												@if($getSaleDetail[0]->staff_id == $staff->id)
													selected
												@endif
											@endif
										>
											{{ $staff->staff_name }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-sm-2">
							<div class="form-group">
								<label>Zone</label>
								<select name="zoneID" class="form-control" required>
									<option value="">--Select Zone--</option>
									@foreach(App\Tbl_zones::all() as $zone)
										<option value="{{ $zone->id }}" 
											@if(isset($getSaleDetail[0]))
												@if($getSaleDetail[0]->zone_id == $zone->id)
													selected
												@endif
											@endif
										>
											{{ $zone->zone }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="form-group">
								<label>Date Request</label>
								<input type="text" name="toDate" id="toDate" class="show_current_date form-control" required 
								value="@if(isset($itemID)){{ date('d-M-Y', strtotime(isset($getSaleDetail[0])?$getSaleDetail[0]->toDate:'')) }} @endif" placeholder="Date Request">
							</div>
						</div>
						<div class="col-sm-5">
							<div class="form-group">
								<label>Note</label>
								<textarea name="note" type="text" class="form-control" 
								placeholder="Note">{{isset($getSaleDetail[0])?$getSaleDetail[0]->note:'' }}</textarea>
							</div>
						</div>
						<div class="col-sm-3">
							<button type="submit" class="btn btn-info">Submit Invoice</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@section('jquery')
<script src ="{{ asset('js/select2.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/select2.css')}}">
	<script>
	//=======================start function================
		var count = 1;
		var count = $("#showReturnInserted").children().length;
	    function buttonClick() {
	    	count++;
	    	var item_id = $('select[name="item_id"] :selected').val();
	    	var item_qty = $("#item_qty").val();

	    	$.get("/selectItemName/"+item_id, function(data, status){
	            //alert("Data: " + data + "\nStatus: " + status);
	            var dataArray = jQuery.parseJSON(data);
	            $('#modalAddItem').modal('hide');
				$("#showReturnInserted").append(
					'<tr>'+
						'<input type="hidden" name="itemId[]" value="'+item_id+'">'+
						'<input type="hidden" name="amount[]" value="'+item_qty+'">'+
						'<input type="hidden" name="price[]" value="'+dataArray.price+'">'+
						'<td>'+count+'</td>'+
						'<td>'+dataArray.code+'</td>'+
						'<td>'+dataArray.name+'</td>'+
						'<td>'+item_qty+'</td>'+
						'<td>'+dataArray.measure+'</td>'+
						'<td><button type="button" class="btn btn-danger" onclick="deleteRow(this)">X</button></td>'+
					'</tr>'
				);
				$('#item_qty').val("");
	        });
	    }
	    function deleteRow(btn) {
	       	var row = btn.parentNode.parentNode;
	      	row.parentNode.removeChild(row);
	    }

	    //===================finish function================

		$(function () {
			$(".select_item_id").select2({
			  	placeholder: "Select a Item",
			  	allowClear: true
			});
			$(".show_current_date").datetimepicker({
	            // value:new Date(),
	            timepicker:false,
	            format:'d-M-Y'
	        });
	        $(document).on('submit', "#submitForm",function (e) {
			 	e.preventDefault();
				var formData = new FormData(this);
				$.ajax({
					type: "POST",
					processData: false,
					contentType: false,
					url: "/addItemToInvoid",
					data: formData,
					success: function (response) {
						if(response!='no'){
							swal({
	                            title:"Request Item Success!",
	                            text:"Request Item Success!",
	                            type:"success",  
	                            timer: 2000,   
	                            showConfirmButton: false
	                        });
	                        window.setTimeout(function(){ 
	                        	window.location.href = "/stockRequest"
	                        },1000);
						}
					},
					error: function () {
						alert('Please Add some Item Reques!');
					}
				});
			});

		});
	</script>
@endsection