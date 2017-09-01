@extends('layouts.app')

@section('content')
<style type="text/css" media="screen">
	.title, .glyphicon{
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
				<div class="col-md-12">
					<h3>Organize</h3>
					<hr/>
					 <?php  $dataPermission=Auth::user()->permission; 
								$dataStr=substr($dataPermission,0,-1);
								$arrDataPermission=(explode(",",$dataStr));
							  // print_r($arrDataPermission);
							?>
					@foreach(App\Tbl_menuses::where('id','6')->get() as $parents)
					@if($parents->subMenus->count())
						@foreach($parents->subMenus as $obj)
						<?php 
							 $subID=$parents->id.$obj->id;	
							if(in_array($subID,$arrDataPermission)){?>
							<div class="general col-xs-6">
								<span class="glyphicon glyphicon-star-empty"></span>
								<span>
									<a href="{{ $obj->url }}" class="title"> {{ $obj->sub_name }}</a>
									<p>Add/Edit/Delete.</p>
								</span>
							</div>
							<?php  }?>
						@endforeach
					@endif
					
					@endforeach
					
				</div>
			</div>
		</div>
	</div>
</div>
@endsection