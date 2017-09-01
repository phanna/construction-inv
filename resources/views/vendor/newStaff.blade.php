<?php 
	$array_gender=array("1"=>"Male","2"=>"Female");
?>
<form method="post" id="addStaffForm" action="/addStaffForm">
	{{ csrf_field() }}
	<input type="hidden" value="{{ isset($getSelectEdit[0])?$getSelectEdit[0]->id:'' }}" name="staff_id" id="staff_id">

	<div class="form-group row">
		<label class="col-md-3 col-form-label">Staff Name</label>
		<div class="col-md-9">
		    <input class="form-control" required type="text" id="fullName" name="fullName" placeholder="Full Name" value="{{ isset($getSelectEdit[0])?$getSelectEdit[0]->staff_name:'' }}">
		</div>
	</div>
	<div class="form-group row">
		<label for="mobile" class="col-md-3 col-form-label">Phone Number</label>
		<div class="col-md-9">
		    <input class="form-control" type="text" id="mobile" name="mobile" placeholder="Phone Number" value="{{ isset($getSelectEdit[0])?$getSelectEdit[0]->phone_number:'' }}" required>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-md-3 col-form-label">Gender</label>
		  	<div class="col-md-9">
		   		<select name="gender" class="form-control" required>
                <option value="">-Select-</option>
                <?php foreach($array_gender as $ks=>$vs){?>
                	<option value="<?=$ks?>" <?php if(isset($getSelectEdit[0])){ if($getSelectEdit[0]->gender==$ks){ echo 'selected'; }}?> ><?=$vs?></option>
                <?php }?>
		   		
		   		</select>
			</div>
	</div>
	<div class="form-group row">
		<label class="col-md-3 col-form-label">Position</label>
		  <div class="col-md-9">
		    <input class="form-control" type="text" id="position" name="position" placeholder="Position" value="{{ isset($getSelectEdit[0])?$getSelectEdit[0]->position:'' }}" required>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-md-3 col-form-label">Staff Type</label>
		  <div class="col-md-9">
		    <input class="form-control" type="text" id="type" name="type" placeholder="Type" value="{{ isset($getSelectEdit[0])?$getSelectEdit[0]->type:'' }}">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-md-3 col-form-label">Group</label>
		  <div class="col-md-9">
		    <input class="form-control" type="text" id="group" name="group" placeholder="Constuction group" value="{{ isset($getSelectEdit[0])?$getSelectEdit[0]->staff_group:'' }}">
		</div>
	</div>
    <button type="submit" class="btn btn-primary">Save changes</button>
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</form>

<script>
	//submit new item
	$(function(){
		$(document).on('submit', "#addStaffForm",function (e) {
		 	e.preventDefault();
			var formData = new FormData(this);
			$.ajax({
				type: "POST",
				processData: false,
				contentType: false,
				url: "/submitNewReceiver",
				data: formData,
				success: function (response) {
				   $('#newStaff').modal('toggle');
				   window.setTimeout(function(){ document.location.reload(true); }, 100);
				},
				error: function () {
					alert('SYSTEM ERROR, TRY LATER AGAIN');
				}
			});
		});
	});
</script>