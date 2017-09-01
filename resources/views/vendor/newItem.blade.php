<?php 
	$array_gender=array("1"=>"Male","2"=>"Female");
?>
<style type="text/css">
select option { padding: 6px;}
.alert { margin:0px; padding:15px 15px 0px;}
.dateWarrenty{ display:none;}
.optional{ color:#ccc; font-weight:normal;}
#newStaff{ padding-left: 0px !important; }
</style>

	<div class="panel panel-default" style="border:none; padding:0px 0px;">
		<div class="panel-body" style="padding-top:0px; padding-bottom:0px;" >
       
			<form method="post" id="formNewitemsubmit">
				{{ csrf_field() }}
				<input type="hidden" name="itemID" id="itemID" value="{{isset($getItemEdit[0])?$getItemEdit[0]->id:''}}">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="itemname">Item Name</label>
                            <input type="text" class="form-control" name="itemname" id="itemname" placeholder="Item Name" value="{{isset($getItemEdit[0])?$getItemEdit[0]->item_name:''}}">
                        </div>
                    </div>
                    
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="barcode">Barcode</label>
                            <input type="text" class="form-control" style="color:teal; font-weight:bold;" name="barcode" readonly id="barcode" value="{{ isset($barcode)?'Req'.date('Ym').$barcode:$getItemEdit[0]->item_code}}">
                         </div>
                    </div>
               	</div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Item Category</label>
                            <select name="categoryID" class="form-control">
                                <option value="" >--Select Category--</option>
                                @foreach(App\ItemCategory::all() as $cateObj)
                                <option value="{{ $cateObj->id }}" 
                                @if(isset($getItemEdit[0]))
                                    @if($getItemEdit[0]->item_category_id==$cateObj->id){ 
                                        selected
                                    @endif
                                @endif 
                                    >{{ $cateObj->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                          <label>Measurement</label>
                          <input class="form-control" type="text" name="measur" placeholder="Measurement" value="{{ (isset($getItemEdit[0])?$getItemEdit[0]->item_measure:'')}}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                            <label for="image">Photos  <span class="optional">[Optional]</span>
                                <span class="optional">(allow *.jpg, *.png)</span>
                            </label>
                            <input type="hidden" id="img" name="photo" value="{{isset($getItemEdit[0])?$getItemEdit[0]->photo:''}}">
                            <input type="file" id="image" name="image">
                        </div>
                   </div>
                 </div>
              	<div class="row">
                  	<div class="col-xs-12">
                      	<div class="form-group">
                        	<label for="itemmodel">Description</label>
                        	<textarea type="text" class="form-control" name="description" id="description" placeholder="Item Description">{{isset($getItemEdit[0])?$getItemEdit[0]->description:''}}</textarea>
                      	</div>
                  	</div>
               	</div>
                
              	<button type="submit" class="btn btn-info">Submit</button>
              	<button type="reset" class="btn btn-default" class="btn btn-default" data-dismiss="modal">Close</button>
        	</form>
  		</div>      
  	</div> 
    <script>

	//Jquery--------------------------------------------------------------
        $(function () {

			$(document).on('submit', "#formNewitemsubmit",function (e) {
			 	e.preventDefault();
    			var formData = new FormData(this);
				$.ajax({
					type: "POST",
					processData: false,
					contentType: false,
					url: "/item/saveNewItem",
					data: formData,
					success: function (response) {
					   $('#modelNewItem').modal('toggle');
                        window.setTimeout(function(){ document.location.reload(true); }, 100);

					},
					error: function () {
						alert('SYSTEM ERROR, TRY LATER AGAIN');
					}
				});
			});
	});
	
</script>