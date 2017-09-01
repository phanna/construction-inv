<form method="post" id="addNewFloor">
	{{ csrf_field() }}
	<input type="hidden" value="{{ isset($showFloorid[0])?$showFloorid[0]->id:''}}" name="floor_id" id="floor_id">

	<div class="form-group row">
		<label class="col-md-3 col-form-label">Floor name</label>
		<div class="col-md-9">
		    <input class="form-control" type="text" id="floorName" name="floorName" placeholder="Floor Name" value="{{ isset($showFloorid[0])?$showFloorid[0]->floor:''}}">
		</div>
	</div>
	<button type="submit" class="btn btn-info">Save changes</button>
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</form>
<script>
	$(function(){
		$(document).on('submit', "#addNewFloor",function (e) {
		 	e.preventDefault();
			var formData = new FormData(this);
			$.ajax({
				type: "POST",
				processData: false,
				contentType: false,
				url: "/addNewFloors",
				data: formData,
				success: function (response) {
				   $('#modalNewRoom').modal('toggle');
				   window.setTimeout(function(){ document.location.reload(true); }, 100);
				},
				error: function () {
					alert('SYSTEM ERROR, TRY LATER AGAIN');
				}
			});
		});
	});
</script>