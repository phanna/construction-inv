<form method="post" id="frmAddItemToRoom{{$array_condo[0]}}{{$array_condo[1]}}">
									  		{{ csrf_field() }} 
									  		<input type="hidden" name="floor_id" value="{{$array_condo[0]}}">
											<input type="hidden" name="room_id" value="{{$array_condo[1]}}">
									  		<div class="row alert alert-info" style="border-radius: 0px;">
									  		<div class="col-xs-4">
												<div class="input-group">
													<p style="margin: 0px;"><label>Select Item</label></p>
													<select name="item_id" id="item_id{{$array_condo[0]}}{{$array_condo[1]}}" class="form-control select2_Item" required >
														<option value="">-Select Item-</option>
														@foreach(App\ItemCategory::all() as $objCate)
														@if($objCate->getItemList->count()>0)
														<optgroup label="{{ $objCate->category_name }}">
															@foreach($objCate->getItemList as $objItem)
															<option value="{{ $objItem->id }}">{{ $objItem->item_name }}</option>
															@endforeach
														</optgroup>
														@endif
														@endforeach
													</select>
												</div>
												
											</div>
						  					<div class="col-xs-2">
						  						<div class="form-group">
													<label>Quantity</label>
													<input type="number" class="form-control selete-textbox" name="item_qty" id="item_qty{{$array_condo[0]}}{{$array_condo[1]}}" placeholder="Qty">
												  </div>
											</div>
						  					<div class="col-xs-3">
						  						<div class="form-group">
													<label>Date</label>
													<input type="text" class="form-control selete-textbox show_current_date" name="toDate" id="toDate{{$array_condo[0]}}{{$array_condo[1]}}" placeholder="Date">
												  </div>
											</div>
											<div class="col-xs-3">
													<div class="form-group">
																<label>Staff</label>
																<select name="staff_id" id="staff_id{{$array_condo[0]}}{{$array_condo[1]}}" class="form-control select2_Item" required>
																	<option value="">-Select-</option>
																	@foreach(App\Tbl_staffs::all() as $objStaff)
																	<option value="{{ $objStaff->id }}">{{ $objStaff->staff_name }}</option>
																	@endforeach
																</select>
															</div>
											</div>
						  					<p align="right"><button type="button" name="submit_" class="btn btn-warning submit_" value="{{$array_condo[0]}}{{$array_condo[1]}}">Add Item</button></p>
						  				
							  				</div>
							  				</form>
<script src ="{{ asset('js/select2.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/select2.css')}}">
<script>
$(function () {
			//date
			$(".show_current_date").datetimepicker({
               value:new Date(),
                timepicker:false,
                format:'d-M-Y'
            });
			//select option
			$(".select2_Item").select2({
				  placeholder: "Select a Item",
				  allowClear: true
				});
});
</script>