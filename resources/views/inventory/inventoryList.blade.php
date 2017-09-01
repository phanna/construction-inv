	<style type="text/css" media="screen">
		.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
			 vertical-align:middle;
			 padding: 4px;
		}
		
	</style>
	
	<div class="row">
		<div class="col-md-4">
			<button class="btn btn-info" id="btnNewInventory">New Inventroy</button>
		</div>
		<div class="col-md-6">
			<form method="get" action="/newInventory">
				{{ csrf_field() }}
				<div class="form-group">
					<label>Inventory Category</label>
					<select name="categoryID" class="form-control" onChange="submit()">
						<option value="" >All</option>
						@foreach(App\ItemCategory::all() as $cateObj)
						<option value="{{ $cateObj->id }}" <?php if(isset($cateID)){ if($cateID==$cateObj->id){ echo 'selected';}}?> >{{ $cateObj->category_name }}</option>
						@endforeach
					</select>
				</div>
			</form>
		</div>
	</div>
    <div class="table-responsive" style="overflow-x: visible;">
	<table class="table table-hover table-bordered" id="inventTbl">
        <thead>
            <tr>
                <th>#</th>
                <th>Item Code</th>
                <th>Item Category</th>
                <th>Item Name</th>
                <th>Item Measure</th>
                <th>Description</th>
                <th>Picture</th>
                <th>Stocks</th>
                <th style="width: 60px;">Action</th>
            </tr>
        </thead>
        <tbody>
          <?php $array_inv=array();?>
    			@foreach(App\tbl_sale_invs::all() as $objInv)
    				<?php $array_inv[$objInv->item_id]=$objInv->staff_id?>
    			@endforeach
            
          <?php  $i = 1;  ?>
        	@foreach($queryItem as $item)
            <?php $arrayobj=$item->getItemCateogry();?>
              	<tr>
                  <td>{{ $i }}</td>
              		<td>{{ $item->item_code }}</td>
              		<td style="text-align: left !important;">{{ $arrayobj[$item->item_category_id] }}</td>
                  <td>{{ $item->item_name }}</td>
              		<td>{{ $item->item_measure }}</td>
              		<td>{{ $item->description }}</td>
              		<td style="width: 100px;">
                        @if($item->photo)
                            <input type="hidden" value="{{ $item->photo }}" id="photo" name="deletePhoto">
                            <div style="background-image:url(uploads/{{ $item->photo }}); background-size:cover; background-position:center; height:50px; width:100px;">
                            
                            </div>
                          
                        @else
                        	<div style="background-image:url(imgs/noimg.png); background-size:cover; background-position:top; height:50px; width:80px; margin-left:10px;">
                            
                        @endif
                    </td>
              		<td>{{ $item->getCountItemStock($item->id) }}</td>
                    
                    <td>
                        <a href="#" class="selectItem" id="editInv_{{$item->id}}">Edit</a> | 
                      
                        	<a href="/showStock/{{$item->id}}" >Stocks</a>
                      
                    </td>
                </tr>
              <?php $i++ ?>
       		@endforeach
        </tbody>
    </table>
    </div>
    