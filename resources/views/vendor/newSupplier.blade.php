<form method="post" id="addSupplierForm" >
	{{ csrf_field() }}
	<input type="hidden" value="{{ isset($getSuppId[0])?$getSuppId[0]->id:'' }}" name="sup_id" id="sup_id">
	<div class="form-group row">
		<label class="col-md-3 col-form-label">Company Name</label>
		  <div class="col-md-9">
		    <input class="form-control" type="text" id="company" name="company" value="{{ isset($getSuppId[0])?$getSuppId[0]->company_name:'' }}">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-md-3 col-form-label">Seller Name</label>
		  <div class="col-md-9">
		    <input class="form-control" type="text" id="seller" name="seller" value="{{ isset($getSuppId[0])?$getSuppId[0]->seller:'' }}">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-md-3 col-form-label">Telephone Number</label>
		  <div class="col-md-9">
		    <input class="form-control" type="text" id="tel" name="tel" value="{{ isset($getSuppId[0])?$getSuppId[0]->phone:'' }}">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-md-3 col-form-label">Address</label>
		  <div class="col-md-9">
		    <textarea class="form-control" type="text" id="address" name="address">{{ isset($getSuppId[0])?$getSuppId[0]->address:'' }}</textarea>
		</div>
	</div>
    <button type="submit" class="btn btn-info">Save changes</button>
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</form>

<script>
	//submit new item
	$(function(){
		$(document).on('submit', "#addSupplierForm",function (e) {
		 	e.preventDefault();
			var formData = new FormData(this);
			$.ajax({
				type: "POST",
				processData: false,
				contentType: false,
				url: "/addNewSupplier",
				data: formData,
				success: function (response) {
				   $('#modalAddform').modal('toggle');
				   window.setTimeout(function(){ document.location.reload(true); }, 100);
				},
				error: function () {
					alert('SYSTEM ERROR, TRY LATER AGAIN');
				}
			});
		});
	});
</script>