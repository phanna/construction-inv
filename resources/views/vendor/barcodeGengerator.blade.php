@extends('layouts.app')

@section('content')
<?php

@include('src/BarcodeGenerator.php');
@include('src/BarcodeGeneratorPNG.php');
@include('src/BarcodeGeneratorSVG.php');
@include('src/BarcodeGeneratorJPG.php');
@include('src/BarcodeGeneratorHTML.php');
$generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
?>

<div class="container">
	<div class="row">
		<div class="panel panel-default summary">
			<div class="panel-body">
            	<div class="row">
                	@foreach(App\Tbl_item::all() as $obj)
                    	<div class="col-md-2 col-xs-2" style="margin-bottom:15px; border-bottom:1px dashed #ccc; min-width:80px; padding-bottom:15px;">
                        	<p style="margin:0px; padding:0px;" align="center">{{ $obj->item_name }}</p>
							<p style="margin:0px; padding:0px;"><img src="data:image/png;base64,<?php echo base64_encode($generator->getBarcode($obj->item_code, $generator::TYPE_CODE_128)) ?>" class="img-responsive" style="height:50px;"></p>
                            <p style="margin:0px; padding:0px;" align="center">{{ $obj->item_code }}</p>
                        </div>
                    @endforeach
                </div>
            	
			</div>
		</div>
   </div>
</div>
@endsection