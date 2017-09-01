<form action="/newAccountAction" method="post" id="submitNewAccount">
    {{ csrf_field() }}
    <input type="hidden" value="{{ isset($getAccountingTbl[0])?$getAccountingTbl[0]->id:'' }}" name="id_account" id="id_account">
        <div class="row">
            <div class="col-md-6">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="accountType">Account Type</label>
                        <select name="accountType" class="form-control" id="accountType">

                        <option value=""> -Select- </option>
                      	@foreach(App\TblAccountCategory::all() as $parents)
							<optgroup label="{{ $parents->category_name }}">
							@if($parents->getAccountType->count())
            					@foreach($parents->getAccountType as $child)
								    <option value="{{ $child->id }}" 
								   @if(isset($getAccountingTbl[0]))
								   		@if($getAccountingTbl[0]->account_type_id==$child->id) 
								   			selected
								   		@endif
								   @endif
								   >
								    	{{ $child->account_type_name }}
								    </option>
								@endforeach
							@endif
							</optgroup>
						@endforeach
						</select>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="code">Code</label>
                        <input type="text" class="form-control" id="code" name="code" placeholder="Account Code" value="{{ isset($getAccountingTbl[0])?$getAccountingTbl[0]->account_code:'' }}">
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Account Name" value="{{ isset($getAccountingTbl[0])?$getAccountingTbl[0]->account_name:'' }}">
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" type="text" class="form-control" placeholder="Description">{{ isset($getAccountingTbl[0])?$getAccountingTbl[0]->account_description:'' }}</textarea>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="tax">Tax</label>
                        <select name="tax" class="form-control" id="tax">
                        	<option style="display: none;" >--Select--</option>
                        	@foreach(App\TblTaxRate::all() as $tax_obj)
                                <option value="{{ $tax_obj->id}}" 
                                @if(isset($getAccountingTbl[0]))
							   		@if($getAccountingTbl[0]->tax_id==$tax_obj->id) 
							   			selected
							   		@endif
							   @endif>
							   {{ $tax_obj->tax_name}} ({{ $tax_obj->total_tax_rate}}%)</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-12">
                    <button type="submit" id="submitNewAccount" class="btn btn-info">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

            <div class="col-md-6">

            </div>
        </div>
</form> 
    <script>
	//Jquery--------------------------------------------------------------
        $(function () {
			var aCode=$('#code').val();
			//Validate form new item
			var validator = $("form#submitNewAccount").validate({
					ignore: [],
					framework: 'bootstrap',
					errorPlacement: function(error, element) {
						// Append error within linked label
						$( element )
						.closest( "form" )
						.find( "label[for='" + element.attr( "id" ) + "']" )
						.append( error );
					},
					errorElement: "span",
					rules: {
						accountType:{
							required:true,
						},
						code: {
							required: true,
							remote: {
								url: "/account/existCode",
								type: "get",
								data: {
									  code: function() {
										return $( "#code" ).val();
									  },
									  accountId: function() {
										return $( "#id_account" ).val();
									  }
									}
								
							}
						},
						name:{
							required: true,
						},
						tax:{
							required:true
						}
					},
					messages: {
						accountType:{
							required:"(required)",
						},
						code: {
							required: "(required)",
							remote:" (This code is exist!)"
							
						},
						name: {
							required: "(required)",
							
						},
						tax:{
							required: "(required)"
						}

					}
				});
			//submit new item
			$(document).on('submit', "#submitNewAccount",function (e) {
			 	e.preventDefault();
    			var formData = new FormData(this);
				$.ajax({
					type: "POST",
					processData: false,
					contentType: false,
					url: "/newAccountAction",
					data: formData,
					success: function (response) {
					   $('#addNewAccounting').modal('toggle');
					   window.setTimeout(function(){ document.location.reload(true); }, 100);
					},
					error: function () {
						alert('SYSTEM ERROR, TRY LATER AGAIN');
					}
				});
			});
			
		
	});
    </script>


