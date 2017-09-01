@extends('layouts.app')

@section('content')
	<style type="text/css" media="screen">
.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    padding: 0px;
    vertical-align: middle;
}
input{
		background: #e9ebee;
		border: 1px solid #ccc;
		border-radius: 0px !important;
	}
.list-group-item:last-child {
    margin-bottom: 0;
    border-bottom-right-radius: 0px;
    border-bottom-left-radius: 0px;
}
.list-group-item:first-child {
    border-top-left-radius: 0px;
    border-top-right-radius: 0px;
}
	#itemDetail .form-control {
		padding: 6px 6px;
	    border: 0px solid #ccc;
	}
	.orderNo{ width:25px; text-align:center;}
	.table>thead>tr>th{ padding:8px;}
	.list-group-item{ 
			color:#333 ; 
			padding: 5px 10px; 
	}
	.list-group-item:hover{ background-color:#ccc; color:#000; cursor:pointer; }
	
	.staff_code_box{ 
		background-color:#FFFFFF;
		position: absolute;
		z-index: 999;
		width: 100%;
		min-height:50px;
		height:250px;
		overflow:auto;
		border:1px solid #ccc;	
		display:none;
	}
	.staff_code_box li{ cursor:pointer; }
	.form-control:focus{border-color: #A3E4D7;  }

.table-fixed thead {
  width: 97%;
}
.table-fixed tbody {
  height: 230px;
  overflow-y: auto;
  width: 100%;
}
.table-fixed thead, .table-fixed tbody, .table-fixed tr, .table-fixed td, .table-fixed th {
  display: block;
}
.table-fixed tbody td, .table-fixed thead > tr> th {
  float: left;
  border-bottom-width: 0;
}
.itemshow{ padding:8px;}
.itemImg { height:150px; overflow:hidden; margin:0px;  background-size:cover; background-position:center;}
	</style>
    

    <?php 
	
	$queryStaff=App\Tbl_staffs::where('id',$staffid)->get();
	$array_dept=array();
	?>
    @foreach(App\Tbl_department::all() as $objDept)
   		<?php $array_dept[$objDept->id]=$objDept->department_name?>
    @endforeach
	<div class="container">
	<div class="row">
		<div class="panel panel-default summary">
			<div class="panel-body">
				<h3>Request Form <span style="float:right; margin-top:-10px;"><a href="/staffLists" class="btn btn-info"><span class="glyphicon glyphicon-chevron-left"></span>Back</a></span></h3>
				<div class="clear"></div>
                <form method="post" >
                 {{ csrf_field() }} 
                 <div class="panel panel-default">
 					<div class="panel-body summary">
                 		<div class="row">
									<div class="col-md-6 col-md-offset-6"  style="height:55px;">
										<div class="col-md-6 col-xs-6"><input type="hidden" value="{{ $queryStaff[0]->id }}" name="staff_txt_id" id="staff_txt_id" class="form-control" />
								            <label>To</label>
                                            <div class="input-group col-xs-12">
                                                <input type="text" name="staff_txt" id="staff_txt" readonly class="form-control" autocomplete="off" value="{{ $queryStaff[0]->staff_code }} - {{ $queryStaff[0]->staff_name }}" style="color:teal; font-weight:bold;" />
                                               <label id="staff_btn_box" class="input-group-addon  hasArrow" style=" padding: 4px 6px; padding-right:10px; background-color:transparent; position:absolute; z-index:9; border:none !important; right:8px; margin-top:7px; border-left: 1px solid #eee !important; cursor:pointer;">
								                 <span class="glyphicon glyphicon-user" style="font-size:10px;"></span>
								                </label>
                                             </div>
                                             
								        </div>
                                       
								       <div class="col-md-6 col-xs-6">
								            <label>Div/Shop</label>
                                            <div class="input-group col-xs-12">
                                                <input type="text" name="staff_txt" id="staff_txt" readonly class="form-control" autocomplete="off" value="{{ $array_dept[$queryStaff[0]->department_id] }}" style="color:teal; font-weight:bold;" />
                                               	<label id="staff_btn_box" class="input-group-addon hasArrow" style=" padding: 4px 6px; padding-right:10px; background-color:transparent; position:absolute; z-index:9; border:none !important; right:8px; margin-top:7px; border-left: 1px solid #eee !important; cursor:pointer;">
								                 <span class="glyphicon glyphicon glyphicon-home" style="font-size:10px;"></span>
								                </label>
                                             </div>
                                             
								        </div>
							            
									</div>
								</div>
						<div class="row">
                        <div class="col-md-12">
                        <label>Barcode <span style=" color:red; font-style:italic;" id="smg_barcode"></span></label>
                    		<div class="input-group">
                            		
                                    <input type="text" class="form-control" id="txtSearch_barcode" name="txtSearch_barcode" autocomplete="off" style="height:40px; width:300px; border:1px solid #A3E4D7;">
                                    <label id="item_btn_box" class="input-group-addon  hasArrow" style="padding: 4px 6px; padding-right:10px; background-color:transparent; position:absolute; z-index:9; border:none !important; right:15px; margin-top:7px; border-left: 1px solid #eee !important; cursor:pointer;">
                                     <span class="glyphicon glyphicon-barcode" style="font-size:18px;"></span>
                                    </label>
                                </div>
                                <ul id="item_code_box" class="list-group staff_code_box" style="width:300px;">
                                             	<li class="list-group-item" id="#AddNewItem" style="color:#00aba9 !important; font-weight:bold; font-size:16px;">New Item</li>
                                             		@if(!empty(App\Tbl_item::all()))
                                                      	@foreach(App\Tbl_item::all() as $item_obj)

                                                      		@if(!in_array($item_obj->id,$arrayItems))
                                                      			<li class="list-group-item" id="itemlist_id{{ $item_obj->id }}" onClick="selectedItem({{ $item_obj->id }}); ">
                                                                {{ $item_obj->item_code}} - {{ $item_obj->item_name}}
                                                            </li>
                                                      		@endif
                                                      	@endforeach
                                                    @endif
                                             </ul>
                         </div>
                    </div>	
                 </div>
                 </div>	
                <div class="row">
                    <div class="col-md-12 " id="show_item">
                    	@if(isset($queryItem))
                        @foreach($queryItem as $itemObj)
                        	<div class="col-md-2 itemshow" id="showItemID{{ $itemObj->id }}">
                            	<div class="thumbnail" >
                                <p align="right" style="position:absolute; right:0px; margin-right:15px; ">  <button type="button" value="{{ $itemObj->id }}" class="close removed" style="background-color:#fff;  padding:0px;" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></p>
                                @if($itemObj->photo)
                                	<div class="row itemImg" style="background-image:url(/uploads/{{ $itemObj->photo }});">
                                @else
                                	<div class="row itemImg" style="background-image:url(/imgs/noimg.png);">
                                @endif
                                </div>
                                    <div class="caption">
                                    	<h4><a href="#" data-container="body" data-toggle="popover" data-placement="top" data-content="{{ $itemObj->description }}">
                                        		{{ $itemObj->item_name }}
                                            </a>
                                        </h4>
                                        
                                        <?php
                                        //count charector
                                        	$str = $itemObj->item_model;
                                        	$str1 = strlen($str);

                                        	if($str1>20){
                                        		$st = substr($str,0,20)."...";
                                        		echo '<p><a href="#" style="text-decoration: none;color: #666;" data-placement="top" data-toggle="tooltip" title="'.$str.'">
                                        			'.$st.'
                                        	</a></p>';
                                        	}else{
                                        		echo '<p>'.$str.'</p>';
                                        	}
                                        ?>
                                        <p>{{ $itemObj->item_code }}</p>
                                        <div class="input-group">
                                        	<input type="text" class="form-control show_current_date" value="{{ date('M d, Y', strtotime($itemObj->toDate)) }}" id="toDate{{ $itemObj->id }}" readonly>
                                        	<label id="staff_btn_box" class="input-group-addon hasArrow" style=" padding: 4px 6px; padding-right:10px; background-color:transparent; position:absolute; z-index:9; border:none !important; right:8px; margin-top:7px; border-left: 1px solid #eee !important; cursor:pointer;">
								                 <span class="glyphicon glyphicon-calendar" style="font-size:10px;"></span>
								            </label>
                                            <p id="loading" style="display:none;"><img src="/imgs/balls.gif"></p>
                                        </div>
                                    </div>
                               	</div>
                            </div>
                        @endforeach
                        @endif
                    </div>
            	</div>
			</div>
			
			<div class="row">
				<div class="col-md-12">
					<div class="border-bottom">
						<div class="col-md-6">
						
						</div>
						<div class="col-md-6" style="text-align: right;">
							<!--<a href="/home" class="btn btn-default">Close</a>-->
						</div>
					</div>
				</div>
			</div>
            </form>
		</div>
	</div>
</div>

@endsection

@section('jquery')

    <script>
        $(function () {
        	$('[data-toggle="tooltip"]').tooltip();
			$('[data-toggle="popover"]').popover();
			
			$("#txtSearch_barcode").focus();
			$('body').click(function(){
				$('.staff_code_box').hide();
				
				});
			//Modal for new Inventory
       		$(document).on('click', "#btnNewInventory",function () {
				var url = "/newItemModel";
				$('.modal-body').load(url,function(result){
						$('#modelNewInventory').modal({show:true});
					});
				});
			//Item Show in List Box
			$(document).on('click', "#staff_btn_box",function () {
					//if use open this comment
					$('#staff_code_box').show();
				});
			//date 
			$(".show_current_date").datetimepicker({
              //  value:new Date(),
                timepicker:false,
                format:'d-M-Y'
            });		
			//barcode search txtSearch_barcode	
			$(document).on('blur', "#txtSearch_barcode",function () {
					//if use open this comment
					$('#staff_code_box').show();
				});
			//show box item_btn_box
			$(document).on('click', "#item_btn_box",function () {
					//if use open this comment
					$('#item_code_box').show();
				});
			//update date show_current_date
			$(document).on('blur', ".show_current_date",function () {
					var idx=$().attr('id');
					var id=idx.substr(6,idx.length);
					var val=$(this).val();
					$("#loading").show();
					$.ajax({
						type: "get",
						url: "/invoice/update_invoice",
						data:{ item_id:id, q:staffid},
						success: function(response){
								$("#loading").hide();
							}
						
					});
					
				});
			//barcode 
			$('#txtSearch_barcode').on({
					keypress: function() { typed_into = true; },
					change: function() {
						if (typed_into) {
							//alert('type');
							var barcode=$(this).val();
							readBarcode(barcode);
							typed_into = false; //reset type listener
						} else {
							var barcode=$(this).val();
							readBarcode(barcode);
							//alert('not type');
						}
					}
				});
		//remove item seleted
		
		$(document).on('click', ".removed",function () {
			 var id=$(this).val();
			 var staffid='{{ $staffid }}';
			 
			 if(confirm("Are you sure want to delete?")==true){
					$.ajax({
						type: "get",
						url: "/remove/saleinvItem",
						data:{ item_id:id, staff_id:staffid},
						success: function(response){
							//alert(response);
							if(response=='yes'){
								swal({
		                            title:"Delete item success!",
		                            text:"Delete item success!",
		                            type:"success",  
		                            timer: 1000,   
		                            showConfirmButton: false
		                        });
								$('#showItemID'+id).hide(1000);
							}
						},
						error:function(){
							alert("SOMETHING ERROR!");
						}
						
					});
				 }
				
		});
		
});//end document.ready
		//javaxcript
		//select item  from list box
		function selectedStaff(code,id,name) {
			
			if(code!="" ){
				$("#staff_txt_id").val(id);
				$("#staff_txt").val(code+' - '+name);
				$("#staff_txt").css({ "color": "teal"});
				
			}
		}
		//functin for bar code
		function readBarcode(barcode){
			$("#smg_barcode").html("");
			var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
			
			var staffid='{{ $staffid }}';
			
				$.ajax({
						type: "get",
						url: "/invoice/create_invoice_barcode",
						data:{ item_barcode:barcode, q:staffid},
						success: function(response){
							if(response=='no'){
									$("#smg_barcode").html('<span style="color:teal;">'+barcode+ "</span> : invalid barcode!, Try again");
									$("#txtSearch_barcode").focus();
									$("#txtSearch_barcode").val('');
								}else{
									$("#txtSearch_barcode").focus();
									$("#txtSearch_barcode").val('');
									$("#show_item").html('');
											var html='';
						//alert(response[1].item_name);
											$.each(response, function(k,v) {
												var date= new Date(response[k].toDate);
												var valuex=(monthNames[date.getMonth() + 1]) + ' ' + date.getDate() + ', ' +  date.getFullYear();
												///alert(valuex);
												var items='<div class="col-md-2 itemshow" id="showItemID'+response[k].id+'"><p align="right" style="position:absolute; right:0px; margin-right:15px; ">  <button type="button" value="'+response[k].id+'" class="close removed" style="background-color:#fff;  padding:0px;" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></p>'+
													'<div class="thumbnail">'+
														'<div class="row itemImg" style="background-image:url(/uploads/'+response[k].photo+');"></div>'+
														'<div class="caption">'+
															'<h3>'+response[k].item_name+'</h3>'+
															'<p>'+response[k].item_model+'</p>'+
															'<p>'+response[k].item_code+'</p>'+
															'<div class="input-group">'+
																'<input type="text" class="form-control show_current_date" value="'+valuex+'"  id="toDate'+response[k].id+'" readonly>'+
																'<label id="staff_btn_box" class="input-group-addon hasArrow" style=" padding: 4px 6px; padding-right:10px; background-color:transparent; position:absolute; z-index:9; border:none !important; right:8px; margin-top:7px; border-left: 1px solid #eee !important; cursor:pointer;">'+
																	 '<span class="glyphicon glyphicon-calendar" style="font-size:10px;"></span>'+
																'</label>'+
															'</div>'+
															'</div></div></div>';
												 // $.each(this, function(k, v) {
												 //alert(v);
												 // });
												  $("#show_item").append(items);
												});
												//$("#show_item").html('asdfasdf sad fasd');
									}
							}
				});
			}
		
		//select item  from list box
		function selectedItem(id) {
			$("#smg_barcode").html("");
			var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
			$("#show_item").html('');
			var staffid='{{ $staffid }}';
			//alert(id);
			if(id!="" ){
				$.ajax({
						type: "get",
						url: "/invoice/create_invoice",
						data:{ item_id:id, q:staffid},
						success: function(response){
							//window.location.reload();'<a href="#" style="text-decoration: none;color: #666;" data-toggle="tooltip" title="'+str+'">'+st+'</a>'
							var html='';
							$("#itemlist_id"+id).hide();
							
							$.each(response, function(k,v) {
								var img=response[k].photo;
								if(img!=""){
									var newImg='/uploads/'+response[k].photo;
								}else{
									var newImg='/imgs/noimg.png';
								}
								var str = response[k].item_model;
								var str1 = str.length;
								if(str1>20){
                            		var st = str.substring(0, 20)+'...';
                            		var newString = '<a href="#" style="text-decoration: none;color: #666;" data-toggle="tooltip" title="'+str+'">'+st+'<a>';
                            	}else{
                            		var newString = str;
                            	}
								var  date= new Date(response[k].toDate);
							
								var valuex=(monthNames[date.getMonth() + 1]) + ' ' + date.getDate() + ', ' +  date.getFullYear();
								//alert(valuex);
									var items='<div class="col-md-2 itemshow" id="showItemID'+response[k].id+'"><p align="right" style="position:absolute; right:0px; margin-right:15px; ">  <button type="button" value="'+response[k].id+'" class="close removed" style="background-color:#fff;  padding:0px;" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></p>'+
									'<div class="thumbnail">'+
										'<div class="row itemImg" style="background-image:url('+newImg+');"></div>'+
										'<div class="caption">'+
											'<h3>'+response[k].item_name+'</h3>'+
											'<p>'+newString+'</p>'+
											'<p>'+response[k].item_code+'</p>'+
											'<div class="input-group">'+
												'<input type="text" class="form-control show_current_date" value="'+valuex+'"  id="toDate'+id+'" readonly>'+
												'<label id="staff_btn_box" class="input-group-addon hasArrow" style=" padding: 4px 6px; padding-right:10px; background-color:transparent; position:absolute; z-index:9; border:none !important; right:8px; margin-top:7px; border-left: 1px solid #eee !important; cursor:pointer;">'+
													 '<span class="glyphicon glyphicon-calendar" style="font-size:10px;"></span>'+
												'</label>'+
											'</div>'+
											'</div></div></div>';
								 // $.each(this, function(k, v) {
								 //alert(v);
								 // });
								  $("#show_item").append(items);
								});
								//$("#show_item").append('asdfasd as fsa');
							}
				});
			}
		}
	</script>
@endsection