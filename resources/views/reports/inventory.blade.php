@extends('layouts.app')

@section('content')
	<style type="text/css" media="screen">
	
		
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
	tr th, tr td{
		text-align: center;
	}
	.dateTooltip + .tooltip > .tooltip-inner {
	    background-color: #fff; 
	    color: #000; 
	    border: 1px solid #333;
	    padding: 10px;
	    font-size: 14px;
	}
	.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
			 vertical-align:middle;
			 padding: 6px;
		}
	.dt-buttons {
			position: absolute;
			float: right;
			right: 30px;
			top: -47px;
			border: 1px solid teal;
			padding: 5px 15px;
			background-color:teal;
				
				}
		a.buttons-print{color: #fff; }
		table.dataTable thead > tr > th {
			padding-left: 4px !important;
			padding-right: 4px !important;
		}
	</style>
	<style type="text/css" media="print">
		table.dataTable thead > tr > th {
			padding-left: 4px !important;
			padding-right: 4px !important;
		}
		.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
			 vertical-align:middle;
			 padding: 4px !important;
		}
		table.dataTable td {
			padding: 4px !important;
		}

	</style>
<div class="container">
		<div class="row">
			<div class="panel panel-default summary">
				<div class="panel-body">
					<!-- <div class="col-md-12"> -->
						<div class="col-md-3" style="margin-top: 10px;">
							<!-- <h4></h4> -->
							<p>
								<a href="/reports" class="btn btn-info">
									<span class="glyphicon glyphicon-chevron-left"></span>Back
								</a>
							</p>
						</div>
						<div class="col-md-8" style="margin-top: 10px;">
						<form method="get" action="/inventory" class="form-horizontal">
							{{ csrf_field() }}
							<div class="form-group">
							    <label for="inputEmail3" class="col-md-3 control-label">Inventory Category</label>
							    <div class="col-sm-6">
							      <select name="category" class="form-control" onChange="submit()">
										<option value="">All</option>
										@foreach(App\ItemCategory::all() as $cateObj)
											<option value="{{ $cateObj->id }}"
											@if(isset($category_id))
												@if($category_id==$cateObj->id)
													selected
												@endif
											@endif
											>
												{{ $cateObj->category_name }}
											</option>
										@endforeach
									</select>
							    </div>
							</div>
						</form>
						</div>
					<!-- </div> -->
					<p style="clear: both"></p>
					<div class="col-md-12">
					<div class="table-responsive" style="overflow-x: visible;">
						<table class="table table-hover table-bordered display nowrap" id="inventTbl1" cellspacing="0" width="100%">
					        <thead>
					            <tr>
					                <th>#</th>
					                <th>Item Code</th>
					                <th>Item Category</th>
					                <th>Item Name</th>
					                <th>Stock</th>
					                <th>Picture</th>
					                
					               
					            </tr>
					        </thead>
					        <tbody>
					          <?php $array_inv=array();?>
								@foreach(App\tbl_sale_invs::all() as $objInv)
									<?php $array_inv[$objInv->item_id]=$objInv->staff_id?>
								@endforeach
					            
					            
					          <?php  $i = 1;  ?>
					        	@foreach($getListInv as $item)
					            <?php $arrayobj=$item->getItemCateogry();?>
					              	<tr>
					                  <td>{{ $i }}</td>
					              		<td>{{ $item->item_code }}</td>
					              		<td>{{ $arrayobj[$item->item_category_id] }}</td>
					              		<td>{{ $item->item_name }}</td>
					              		<td>{{ $item->getCountItemStock($item->id) }}</td>
					              		<td style="width: 100px;">
					                        @if($item->photo)
					                            <input type="hidden" value="{{ $item->photo }}" id="photo" name="deletePhoto">
					                            <div style="background-image:url(uploads/{{ $item->photo }}); background-size:cover; background-position:center; height:50px; width:100px;">
					                            
					                            </div>
					                          
					                        @else
					                        	<div style="background-image:url(imgs/noimg.png); background-size:cover; background-position:top; height:50px; width:80px; margin-left:10px;">
					                            
					                        @endif
					                    </td>
					                </tr>
					              <?php $i++ ?>
					       		@endforeach
					        </tbody>
					    </table>
					   </div>
   					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('jquery')

  

  	
  	<script src ="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
  	<script src ="{{ asset('js/dataTables.bootstrap.js')}}"></script>
  	<script src ="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
  	<script src ="//cdn.datatables.net/buttons/1.3.1/js/buttons.print.min.js"></script>
  	

  	
  	<link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap.css')}}">
    <script>
  
        $(function () {
          	$('#inventTbl1').dataTable( {
        		 
				"lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
				dom: 'Bfrtip',
				buttons: [
						'copy', 'csv', 'excel', 'pdf', 'print'
					]
      		});
      		//add search icon
      		$( ".dataTables_filter > label" ).append( "<span class='glyphicon glyphicon-search'></span>" );
        	// $('#modelNewInventory').modal({backdrop: 'static', keyboard: false}) ;
        	$('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endsection
    