@extends('layouts.app')

@section('content')
<style type="text/css" media="screen">
	.addbtnContact{
		text-align: right;
	}
	.rightTable{
		height: 780px;
		border-left: 1px solid #ccc;
	}
	.headerTable{
		height: 50px;
		border-bottom: 1px solid #ccc;
		background: #fff;
	}
	/*data table*/
	.glyphicon-search{
		right: 23px;
		top: 3px;
	}
	table.dataTable{
		border-bottom: 1px solid #ccc;
	}
	table.dataTable thead .sorting{
		background:none !important;
	}
	table.dataTable thead .sorting_asc{
		background:none !important;
	}
	tr > th.sorting_asc{
		padding-left: 9px !important;
	}
	thead tr{
		background-color: #ccc;
	}
	#staffTable_wrapper > div:nth-child(3){
		background: #ccc;
   		margin: 0 auto;
	}
	#staffTable_wrapper > div:nth-child(1){
    	padding-top:13px;
    	border-bottom: 1px solid #ccc;
    	margin: 0 auto;
    	padding-bottom: 8px;
	}
	.btn-link{
		border-right: 1px solid #ccc;
		display: none;
	}
	div.dataTables_scrollBody{
		height: 680px !important;
	}
	/*end datable*/
	ul.navbar-nav li a:hover, .nav .open>a:focus{
		background: none;
	}
	ul.option{
		top: 37px;
	}
	.list-group{
		margin-bottom: 0px;
	}
	.list-group-item:first-child{
		border-top: none;
	}
	.list-group-item:first-child, .list-group-item:last-child{
		border-radius:0px;
	}
	.glyphicon-plus{
	    color: #fff;
	}
	.btn-info{
	}
	input[type=checkbox]{
		margin:0 0 0;
	}
	.selectedEditRow, .gotoAdditem{
		cursor: pointer;
	}
	
</style>

<div class="container">
	<div class="row">
		<div class="panel panel-default summary">
			<div class="panel-body">
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-6">
							<h4>Div/Dept</h4>
						</div>
						<div class="col-md-6">
							<div class="row addbtnContact">
								
								<button type="submit" id="addNewStaffs" class="btn btn-info"><i class="glyphicon glyphicon-plus"></i> Add Staff</button>
							</div>
						</div>
					</div>
					<div class="row" style="border: 1px solid #ccc; background-color: #fff;">
						<div class="contact_form">
							<div class="col-md-3">
								<ul class="list-group" style="margin-left:-16px;height: 799px;overflow-x: scroll;">
								@foreach(App\Tbl_department::all() as $dep)
								  	<li class="list-group-item ">
								  		<a href="/staffLists/{{ $dep->id }}">
								  			{{ $dep->department_name }}
								  			({{ $dep->getStaffs->count() }})
								  		</a>
								  	</li> 
								@endforeach    
								</ul>
							</div>
							<div class="col-md-9">
								<form method="post" action="">
									{{ csrf_field() }}
									<div class="row rightTable" style="margin-left: -30px;">

										<table class="table " id="staffTable">
								          	<thead>
								            	<tr>
								              		<th>#</th>
								              		<th>Name</th>
								              		<th>Code</th>
								              		<th>Phone</th>
								              		<th>Gender</th>
								              		<th>Position</th>
								              		<th>Department</th>
                                                    <th>Action</th>
								            	</tr>
								          	</thead>
								          	<tbody>
								          	<?php $x=1;?>
								          	@if(isset($dept_id))

												@foreach($dept_id as $staff)
	           										<?php $arrayobj=$staff->getDepartmentName();?>
										            <tr >
										              	<td>{{ $x }}</td>
										              	<td>{{ $staff->staff_name }}</td>
										              	<td >{{ $staff->staff_code }}</td>
										              	<td>{{ $staff->phone_number }}</td>
										              	<td>{{ ($staff->gender==1)? 'Male':'Famele' }}</td>
										              	<td>{{ $staff->position }}</td>
										              	<td>{{ $arrayobj[$staff->department_id] }}
										              		</td>
                                                        <td>
                                                        	<a href="#" class="gotoAdditem" id="item_{{ $staff->id }}">Inventory</a> | 
                                                        	<a href="#" class="selectedEditRow" id="edit_{{ $staff->id }}">Edit</a></td>
										            </tr>
										            <?php $x++; ?>
									            @endforeach

									            @else
									            <?php $y=1; $queryInv=0;?>
									            @foreach(App\Tbl_staffs::all() as $staff)
	           										<?php $arrayobj=$staff->getDepartmentName();
														//$queryInv=App\tbl_sale_invs::where('staff_id',$staff->id)->get();
														//print_r($queryInv);
													?>
										            <tr >
										              	<td>{{ $y }}</td>
										              	<td>{{ $staff->staff_name }}</td>
										              	<td>{{ $staff->staff_code }}</td>
										              	<td>{{ $staff->phone_number }}</td>
										              	<td>{{ ($staff->gender==1)? 'Male':'Female' }}</td>
										              	<td>{{ $staff->position }}</td>
										              	<td>{{ $arrayobj[$staff->department_id] }}</td>
                                                        <td>
                                                        	<a href="#" class="gotoAdditem" id="item_{{ $staff->id }}"><span style="color:teal;">({{ $staff->getItemCount($staff->id) }}) </span>Inventory</a> | 
                                                        	<a href="#" class="selectedEditRow" id="edit_{{ $staff->id }}">Edit</a></td>
										            </tr>
										            <?php $y++; ?>
									            @endforeach
									        @endif
									        </tbody>
										</table>
									</div>
								</form>
							</div>
							<!-- div col-md-9 -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="newStaff" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  	<div class="modal-dialog" role="document">
	    <div class="modal-content">
	      	<div class="modal-header">
	      		<div class="col-md-6">
	        		<h4 class="modal-title" id="exampleModalLabel">Add New Staff</h4>
	        	</div>
	        	<div class="col-md-6">
	        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          		<span aria-hidden="true">&times;</span>
	        	</button>
	        	</div>
	      	</div>

	      	<div class="modal-body" style="padding-left:30px; padding-right:30px;">

	        	
	      	</div>
	      	
	    </div>
  	</div>
</div>

@endsection

@section('jquery')

	<script src ="{{ asset('js/jquery.dataTables.min.js')}}"></script>
	<script src ="{{ asset('js/dataTables.bootstrap.js')}}"></script>
	<link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap.css')}}">

    <script>
        $(function () {
        	//-----
        	$('#staffTable').dataTable( {
        		"scrollY":"200px",
        		"scrollCollapse": true,
				"bPaginate": false
			});
			//add search icon
			$( ".dataTables_filter > label" ).append( "<span class='glyphicon glyphicon-search'></span>" );

			//Validate form contact
			var validator = $("form#addStaffForm").validate({
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
					contactName: {
						required: true
					},
					mobile:{
						required: true
					},
					deskphone:{
						required: true
					}
				},
				messages: {
					contactName: {
						required: "(Required)"
					},
					mobile: {
						required: "(Required)"
					},
					deskphone: {
						required: "(Required)"
					}
				}
			});

			//show model new item 
			$(document).on('click', "#addNewStaffs",function () {
				var url = "/addNewStaff";
				$('.modal-body').load(url,function(result){
					$('#newStaff').modal({show:true});
				});
			});
			//select edit
			$(document).on('click', ".selectedEditRow",function () {
				var get_Id=$(this).attr('id');
				var id=get_Id.substr(5,get_Id.length);
				var url = "/editStaff/"+id;
				$('.modal-body').load(url,function(result){
						$('#newStaff').modal({show:true});
					});
			});
			//gotoAdditem
			$(document).on('click', ".gotoAdditem",function () {
				var idx=$(this).attr('id');
				var id=idx.substr(5, idx.length)
				window.location.href='/assign/'+id;
				//alert(id);
			});
		});
	</script>

@endsection