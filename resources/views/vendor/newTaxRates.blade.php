<style type="text/css">
.components-left span.error { position:absolute; width:180px; margin-top:-10px; margin-left:0px;}
.tax_rates span.error { 
	position: absolute;
    width: 163px;
    margin-top: -7px;
    margin-left: -49px;
}

</style>
<form action="/newTaxRateAction" method="post" id="submitNewTaxRate">
    {{ csrf_field() }}
  
    <input type="hidden" value="{{ isset($category)?$category->id:'' }}" name="taxtRate_id" id="taxtRate_id">
    <div class="row">
        <div class="col-md-12">
	        <div class="col-md-12">
	            <div class="form-group">
	                <label for="tax_name">Tax Rate Name</label>
	                <input type="text" class="form-control" id="tax_name" name="tax_name" placeholder="Tax Rate Name" value="{{ isset($category)?$category->tax_name: '' }}">
	            </div>
            </div>
       		<table class="table" >
       			<thead>
       				<tr>
       					<th colspan="4">Tax Components <span class="message"></span></label></th>
       				</tr>
       			</thead>
       			<tbody class="tbodyrate">
                <?php $totalRate=0; $numRow = 0; ?>
                	@if(isset($category))
	       				@if($category->taxComponents->count())
	                    	<?php $x=1; ?>
	                    	<?php $numRow = $category->taxComponents->count(); ?>
	                        <?php $btn =1; ?>
	                    	@foreach($category->taxComponents as $componendObj)
	                    		<?php $totalRate+=$componendObj->tax_rate; ?>
			       				<tr>
			       					<td style="width: 40%;">
			       						<input type="text" class="form-control" id="components1" name="components[{{$x}}]" placeholder="Tax components" value="{{ $componendObj->component}}" required>
			       						<label class="components-left" for="components1"></label>
			       					</td>
			       					<td>
			       						<input type="radio" name="compoundRate[{{$x}}]" id="compoundRate1" {{ ($componendObj->tax_status==1)?'checked':''}} >
			       						<span class="text">Compound (apply to taxed subtotal)</span>
			       					</td>
			       					<td style="width: 80px;">
			       						<input type = "number"
			       								name="taxrate[{{$x}}]" 
			       								id="taxrate1" class="form-control taxtRate" 
			       								placeholder="0"
			       								onkeypress="return isNumeric(event)"
											    oninput="maxLengthCheck(this)"
											    maxlength = "3"
											    min = "0"
											    max = "999"
			       								value="{{ $componendObj->tax_rate}}"
			       							>
			       							<span class="percent" id="percent">%</span>
			       						<label class="tax_rates" for="taxrate1"></label>
			       					</td>
			       					<td><i class="glyphicon glyphicon-remove deleted_component" id="remove{{ $componendObj->id}}"></i></td>
			       				</tr>
	       						<?php $x++; ?>
	                    	@endforeach
	                    @endif
                    @else
	                    <?php $numRow = 1 ?>
	                    <?php $btn =2; ?>
	                    <tr>
	       					<td style="width: 40%;">
	       						<input type="text" class="form-control" id="components1" name="components[1]" placeholder="Tax components" value="" required>
	       						<label class="components-left" for="components1"></label>
	       					</td>
	       					<td >
	       						<input type="radio" name="compoundRate[1]" id="compoundRate1">
	       						<span class="text">Compound (apply to taxed subtotal)</span>
	       					</td>
	       					<td style="width: 80px;">
	       						<input  type = "number"
	       								name="taxrate[1]" 
	       								id="taxrate1" class="form-control taxtRate" 
	       								placeholder="0" value="" 
	       								onkeypress="return isNumeric(event)"
									    oninput="maxLengthCheck(this)"
									    maxlength = "3"
									    min = "0"
									    max = "100">
	       							<span class="percent" id="percent">%</span>
	       						<label class="tax_rates" for="taxrate1"></label>
	       					</td>
	       					<td><i class="glyphicon glyphicon-remove"></i></td>
	       				</tr>

                    @endif
                    
       			</tbody>
                <tbody id="myTable"></tbody>
       			<tbody>
       				<tr class="tableAddnew">
       					<td><button type="button" class="addNewTaxRow" id="addNewTaxRow{{ isset($category)?$category->id:0 }}">Add a Components</button></td>
       					<td style="text-align: right;">

       						<label class="textTotal">Total Tax Rates</label><br/>
       						<label class="textTotal">Effective tax rate</label>
       					</td>
       					<td style="text-align: center;">
       						
       						<input type="text" class="form-control total_rate" name="totalRate" readonly value="<?php echo $totalRate?>" id='lblValue'>
       						<input type="text" class="form-control total_rate" name="effectiveRate" readonly value="00.0%">
       					</td>
       					<td></td>
       				</tr>
       			</tbody>
       		</table>
            <div class="modal-footer">
            	<input type="hidden" name="count_row" id="count_row" value="<?=$numRow?>">
		        <button type="submit" class="btn btn-info">Save </button>
		        <button type="button" class="btn btn-default" id="btn_close" data-dismiss="modal">Close</button>
		    </div>
        </div>
    </div>
</form> 
    <script>
    	//==========type number check validation=========
    	function maxLengthCheck(object) {
		    if (object.value.length > object.maxLength){
		      	object.value = object.value.slice(0, object.maxLength)
		    }
		}
		function isNumeric (evt) {
		    var theEvent = evt || window.event;
		    var key = theEvent.keyCode || theEvent.which;
		    key = String.fromCharCode (key);
		    var regex = /[0-9]|\./;
		    if ( !regex.test(key) ) {
		      theEvent.returnValue = false;
		      if(theEvent.preventDefault) theEvent.preventDefault();
		    }
		  }
  		//=============
    	//=========keypu keypress==========

	    //Jquery--------------------------------------------------------------
        $(function () {
        	$("#submitNewTaxRate").validate({ 
					ignore: [],
					framework: 'bootstrap',
					errorPlacement: function(error, element) {
						$( element )
						.closest( "form" )
						.find( "label[for='" + element.attr( "id" ) + "']" )
						.append( error );
					},
					errorElement: "span",
					rules: {
						tax_name: {
							required: true,
							remote:{
								url: "/newTaxRate/existName",
								type: "get",
								data: {
									taxName: function() {
										return $( "#tax_name" ).val();
									},
									taxID: function() {
										return $( "#taxtRate_id" ).val();
									  }
									}
							}
							
						},
						"components[]": {
								required: true
							},
						"taxrate[]": {
								required: true,
							}

					},
					messages: {
						tax_name: {
							required: "(required)",
							remote:" (This Name is exist!)"
						},
						"components[]": "(required)",
						"taxrate[]":{
							required: "(required)",
						}
					},
					
			});
            $(document).on('keyup', ".taxtRate",function (e) {
                // var v = $(this).attr('id');
                // var id = v.substr(7,v.length);
                var total = 0;
                $('input.taxtRate').each(function() {
                	total += parseInt($(this).val())||0;
				});
                $('#lblValue').val(total+"%");
            });
        	//===========add and delete new row tax rate===========

			
        	//=============appen new row============
		
			  var totalZ = 0;
				$('input[name^="components"]').each( function() {
					totalZ += 1;
				});
			var taxtRate_id=parseInt('{{ isset($category)?$category->id:0 }}')||0;
			var count =totalZ;// parseInt($("#count_row").val())||0;
			$(document).on('click', "#addNewTaxRow"+taxtRate_id,function (e) {
				count++;
				var categoryList = $('#myTable');
				 categoryList.append('<tr><td style="width: 40%;"><input type="text" name="components['+count+']" required placeholder="Tax components" value="" class="form-control" id="components'
				+count+'"><label class="components-left" for="components'
				+count+'"></label></td><td><input type="radio" name="compoundRate['+count+']" id="compoundRate'
				+count+'"><span class="text" id="text'
				+count+'">Compound (apply to taxed subtotal)</span></td><td style="width: 80px;"><input name="taxrate['+count+']" onkeypress="return isNumeric(event)" oninput="maxLengthCheck(this)" maxlength = "3" min = "0" max = "999"  id="taxrate'
				+count+'" type="number" class="form-control taxtRate" placeholder="0"><span class="percent" id="percent'
				+count+'">%</span><label class="tax_rates" for="taxrate'
				+count+'"></label></td><td><i class="glyphicon glyphicon-remove deleted_component" ></i></td></tr>');
			});
			
			//==============end add new tax==============

			
			//submit new item
			$(document).on('submit', "#submitNewTaxRate",function (e) {
			 	e.preventDefault();
				
				
    			var formData = new FormData(this);
				$.ajax({
					type: "POST",
					processData: false,
					contentType: false,
					url: "/newTaxRateAction",
					data: formData,
					success: function (response) {
					   $('#addNewTaxRate').modal('toggle');
					   window.setTimeout(function(){ document.location.reload(true); }, 100);
					},
					error: function () {
						alert('SYSTEM ERROR, TRY LATER AGAIN');
					}
				});
			});
			
		
	});
    </script>