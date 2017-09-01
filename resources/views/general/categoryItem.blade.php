@extends('layouts.app')

@section('content')
<style type="text/css" media="screen">
	.glyphicon-plus{
		left: 6px;
	    color: #fff;
	    top: -2px;
	}
	table#itable thead tr{
		background: #e9ebee;
	}
	.glyphicon-search{
		right: 23px;
		top: 3px;
	}

	table.dataTable thead .sorting{
		background:none !important;
	}
	table.dataTable thead .sorting_asc{
		background:none !important;
	}
</style>
<div class="container">
	<div class="row">
		<div class="panel panel-default summary">
			<div class="panel-body">
				<div class="col-md-12">
					<h3>Item Category</h3>
					<hr/>
					<div class="row">
				    	<div class="col-md-12">
				    	<button type="button" class="btn btn-info " id="addNewCate">Add Category</button>
				    	<a href="/generalSetting" class="btn btn-default">Back</a>
				    	<hr/>
				    	<div class="table-responsive" style="overflow-x: visible;">
				    		<table class="table table-hover table-bordered" id="itable">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">#</th>
                                        <th style="text-align: center;">Category Name</th>
                                        <th style="text-align: center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $x = 1;?>
                                @foreach($getCate as $cate)
                                	<tr>
                                		<td style="text-align: center;">{{ $x }}</td>
                                		<td style="text-align: center;">{{ $cate->category_name }}</td>
                                		<td style="text-align: center;">
                                			<button class="btn btn-info editCate" 
                                					id="edit_{{$cate->id}}">Edit</button>
                                			<button class="btn btn-danger deleteCate" 
                                					id="delete_{{$cate->id}}">Delete</button>
                                		</td>
                                	</tr>
                                	<?php $x++; ?>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
				    	</div>
				    </div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- add new tax rates model -->
	<div class="modal fade" id="addNewCategory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  	<div class="modal-dialog " role="document">
	    	<div class="modal-content ">
	      		<div class="modal-header">
	        		<button type="button"  class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        		<h4 class="modal-title" id="myModalLabel">Add new Category</h4>
	      		</div>
		      	<div class="modal-body">

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
        	$('.table-hover').dataTable( {
				"bPaginate": true
			});

			//add search icon
			$( ".dataTables_filter > label" ).append( "<span class='glyphicon glyphicon-search'></span>" );

			//show model new item 
			$(document).on('click', "#addNewCate",function () {
				var url = "/addCategory";
				$('.modal-body').load(url,function(result){
					$('#addNewCategory').modal({show:true});
				});
			});

			//edit category item 
			$(document).on('click', ".editCate",function () {
				var get_Id=$(this).attr('id');
				var id=get_Id.substr(5,get_Id.length);
				var url = "/editCate/"+id;
				$('.modal-body').load(url,function(result){
					$('#addNewCategory').modal({show:true});
				});
			});

			//delete category item  
			$(document).on('click', ".deleteCate",function () {
				var get_Id=$(this).attr('id');
				var id=get_Id.substr(7,get_Id.length);
				if(confirm("Are you sure want to delete")==true){
					$.ajax({
						type: "get",
						url: "/deleteCate",
						data: {cate_id:id},
						success: function (response) {
						   if(response == 'yes'){
								swal({
									title:"Delete data Success",
									text:"This update ready!",
									type:"success",  
									timer: 1000,   
									showConfirmButton: false
								});
								window.setTimeout(function(){ document.location.reload(true); }, 100);
							}
						}
					});
				}
			});

		});
	</script>
@endsection