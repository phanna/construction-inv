<form method="post" id="addDeptForm" action="/addDeptForm">
	{{ csrf_field() }}
	<input type="hidden" value="{{ isset($selectEditDept[0])?$selectEditDept[0]->id:'' }}" name="dept_id" id="dept_id">
	<div class="form-group row">
		<label class="col-md-3 col-form-label">Department Name</label>
		  <div class="col-md-9">
		    <input class="form-control" type="text" id="department" name="department" value="{{ isset($selectEditDept[0])?$selectEditDept[0]->department_name:'' }}">
		</div>
	</div>
    <button type="submit" class="btn btn-info">Save changes</button>
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</form>

<script>
	//submit new item
	$(function(){
		$(document).on('submit', "#addDeptForm",function (e) {
		 	e.preventDefault();
			var formData = new FormData(this);
			$.ajax({
				type: "POST",
				processData: false,
				contentType: false,
				url: "/addDeptForm",
				data: formData,
				success: function (response) {
				   window.setTimeout(function(){ document.location.reload(true); }, 100);
				},
				error: function () {
					alert('SYSTEM ERROR, TRY LATER AGAIN');
				}
			});
		});
	});
</script>