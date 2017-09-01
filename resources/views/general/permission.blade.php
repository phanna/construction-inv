@extends('layouts.app')

@section('content')
<style type="text/css" media="screen">
	.tax_rate, .glyphicon{
		font-size: 16px;
	}
	span p{
		margin-left:22px;
	}
	.general{
		padding-bottom: 20px;
	}
</style>
<div class="container">
	<div class="row">
		<div class="panel panel-default summary">
			<div class="panel-body">
				<div class="col-md-4">
				<form method="get" action="/onChangeUser">
				{{ csrf_field() }}
					<div class="form-group">
						<h3 align="">Choose User</h3>
						<select name="userID" class="form-control" id="userID" required onChange="submit();">
							<option value="0" >-Choose A User-</option>
							@foreach(App\User::all() as $uobj)
							<option value="{{$uobj->id}}" <?php if(isset($userid)){ if($userid==$uobj->id){ echo 'selected'; }}?> >{{$uobj->name}} - {{$uobj->position}}</option>
							@endforeach
						</select>
					</div>
					<br>
					</form>	
				</div>
				<div class="col-md-8" style="border-left: 1px solid #ccc;">
				<h3 align="">Choose Menu</h3>
				<form method="get" action="/insertPermission">
					{{ csrf_field() }}
					<input type="hidden" value="<?php if(isset($userid)){ echo $userid;}?>" name="userid">
					<div class="col-xs-12" style="clear: both">
					<?php if(isset($userData)){
						$userStr=substr($userData[0]->permission,0,-1);
						$arrPermission=(explode(",",$userStr));
						//print_r($arrPermission);
					}?>
					@foreach(App\Tbl_menuses::all() as $obj)
					<div class="clol-xs-12" style="border: solid 1px #eee;">
					<div class="col-xs-12" style="background-color: beige" >
						@if($obj->subMenus->count())
							<h4>
							<div class="checkbox ">
								<label>
								  <input  type="checkbox" checked readonly value="{{ $obj->id}}" name="menuid[]" >{{ $obj->name}}
								</label>
							  </div>
							 </h4>
						@else 
							<h4>
							<div class="checkbox ">
								<label>
								  <input  type="checkbox" value="{{ $obj->id}}"
								  	 <?php if(isset($arrPermission)){ 
											if(in_array($obj->id,$arrPermission)){ 
												echo 'checked'; 
											 } 
											}?> name="menuid[]">
											
											 {{ $obj->name}}
								</label>
							  </div>
							  </h4>
						@endif
						</div>
						
					
						@if($obj->subMenus->count())
						@foreach($obj->subMenus as $obj2)
                        	<div class="col-xs-4" style="padding-left: 35px;">
                        	<div class="checkbox ">
								<label>
								  <input  type="checkbox" value="{{ $obj->id}}{{ $obj2->id}}"
								  	 <?php if(isset($arrPermission)){ 
											$subID=$obj->id.$obj2->id;
											if(in_array($subID,$arrPermission)){ 
												echo 'checked'; 
											 } 
											}?> name="menuid[]">
											
											  {{ $obj2->sub_name}}
								</label>
							  </div>
                       		  </div>
                        @endforeach
						</div>
						
                	@endif
					@endforeach
					</div>
					<div  class="col-xs-12" style="clear: both"><br>
					<?php if(isset($userData)){?>
						<p align="center"><button type="submit" class="btn btn-info">Save Changes</button></p>
					<?php }?>
					</div>
					</form>
				</div>
				
				</form>
			</div>
		</div>
	</div>
</div>
@endsection