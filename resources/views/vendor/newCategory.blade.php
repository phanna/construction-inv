<form method="post" id="addCateForm" action="/addCateForm">
	{{ csrf_field() }}
	<input type="hidden" value="{{ isset($selectEditCate[0])?$selectEditCate[0]->id:'' }}" name="cate_id" id="cate_id">
	<div class="form-group row">
		<label class="col-md-3 col-form-label">Category Name</label>
		  <div class="col-md-9">
		    <input class="form-control" type="text" id="category" name="category" value="{{ isset($selectEditCate[0])?$selectEditCate[0]->category_name:'' }}">
		</div>
	</div>
    <button type="submit" class="btn btn-info">Save changes</button>
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</form>

<script>
	//submit new item
	$(function(){
		$(document).on('submit', "#addCateForm",function (e) {
		 	e.preventDefault();
			var formData = new FormData(this);
			$.ajax({
				type: "POST",
				processData: false,
				contentType: false,
				url: "/addCateForm",
				data: formData,
				success: function (response) {
				   $('#addNewCategory').modal('toggle');
				   window.setTimeout(function(){ document.location.reload(true); }, 100);
				},
				error: function () {
					alert('SYSTEM ERROR, TRY LATER AGAIN');
				}
			});
		});
	});
</script>