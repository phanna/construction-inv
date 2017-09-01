<form method="post" id="addNewStock">
	{{ csrf_field() }}

	<input type="hidden" value="{{ (isset($status)?$status:0)}}" id="status" name="status" >
	<input type="hidden" value="{{ (isset($itemID[0])?$itemID[0]->id:'')}}" name="itemID">
	<input type="hidden" value="{{ (isset($getStock[0])?$getStock[0]->id:'')}}" name="stockID">

	<h3 class="alert alert-info">{{$itemID[0]->item_code}} - {{$itemID[0]->item_name}}</h3>
	<div class="form-group row">
		<label class="col-md-3 ">Stock Amount</label>
		<div class="col-md-9">
		    <input class="form-control" type="number" id="stock" name="stock" placeholder="Amount" value="{{ (isset($getStock[0])?$getStock[0]->amount:'')}}">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-md-3 ">Unit Price</label>
		<div class="col-md-9">
		    <input class="form-control" type="text" name="price" placeholder="Unit Price" value="{{ (isset($getStock[0])?$getStock[0]->unit_price:'')}}">
		</div>
	</div>
	<div class="form-group row">
	<label class="col-md-3 ">Date Purchase</label>
		<div class="col-md-9">
			<input type="text" class="form-control show_current_date" name="datePurches" id="datePurches" value="{{ (isset($getStock[0])?date('M d, Y', strtotime($getStock[0]->purchase_date)):'')}}" placeholder="00-00-0000">
		</div>
	</div>
  
	<button type="submit" class="btn btn-info">Save changes</button>
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</form>
<script>
	$(function(){
		 $(".show_current_date").datetimepicker({
                // value:new Date(),
                timepicker:false,
                format:'d-M-Y'
            });	
		
		$(document).on('submit', "#addNewStock",function (e) {
		 	e.preventDefault();
			var formData = new FormData(this);
			$.ajax({
				type: "POST",
				processData: false,
				contentType: false,
				url: "/addNewStock",
				data: formData,
				success: function (response) {
				   $('#modelNewStock').modal('toggle');
				   window.setTimeout(function(){ document.location.reload(true); }, 100);
				},
				error: function () {
					alert('SYSTEM ERROR, TRY LATER AGAIN');
				}
			});
		});
	});
</script>