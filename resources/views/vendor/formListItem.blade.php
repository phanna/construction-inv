
<style type="text/css">
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
</style>
<?php //print_r($array_condo)?>
<form method="post" id="formAddItemToInvoid">
	{{ csrf_field() }}
	<div class="row">
		<div class="col-xs-6">
			<div class="form-group">
				<p style="margin: 0px;"><label>Item Category</label></p>
				<select name="item_id" id="item_id" class="form-control select_item_id" required>
					<option value="">-Select Item Category-</option>
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
		<div class="col-xs-6">
			<div class="form-group">
				<label>Quantity</label>
				<input type="number" name="item_qty" id="item_qty" class="form-control" required placeholder="0">
				<span id="showMsg_stock_error"></span>
			</div>
		</div>
		<hr>
		<div class="col-xs-4">
	        <button type="reset" class="btn btn-default" data-dismiss="modal">Close</button>
	        <button type="button" name="submit_" class="btn btn-primary submit_" id="submit_" onclick="buttonClick();">Add Item</button>
        </div>
   </div>
	
</form>

<script src ="{{ asset('js/select2.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/select2.css')}}">
<script>
	$(function () {
		$(".select_item_id").select2({
		  placeholder: "Select a Item",
		  allowClear: true
		});

	});
	//================function===================
	var count = 1;
	var count = $("#showReturnInserted").children().length;
    function buttonClick() {
    	count++;
    	var item_id = $('select[name="item_id"] :selected').val();
    	var item_qty = $("#item_qty").val();

    	$.get("/selectItemName/"+item_id, function(data, status){
            // alert("Data: " + data + "\nStatus: " + status);
            var dataArray = jQuery.parseJSON(data);
            $('#modalAddItem').modal('hide');
			$("#showReturnInserted").append(
				'<tr class="allAppend">'+
					'<input type="hidden" name="itemId[]" value="'+item_id+'">'+
					'<input type="hidden" name="amount[]" value="'+item_qty+'">'+
					'<td>'+count+'</td>'+
					'<td>'+dataArray.code+'</td>'+
					'<td>'+dataArray.name+'</td>'+
					'<td>'+item_qty+'</td>'+
					'<td><button type="button" class="btn btn-danger" onclick="deleteRow(this)">X</button></td>'+
				'</tr>'
			);
        });
    }

    function deleteRow(btn) {
       	var row = btn.parentNode.parentNode;
      	row.parentNode.removeChild(row);
    }
    
</script>