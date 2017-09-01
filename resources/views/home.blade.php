@extends('layouts.app')

@section('content')
<style type="text/css">
#chart-1 {
	min-width: 150px;
	max-width: 100%;
	margin: 0 auto;
}
.highcharts-credits{ display:none;}
	
div.bhoechie-tab-container{
  z-index: 10;
  background-color: #ffffff;
  padding: 0 !important;
  border-radius: 0px;
  -moz-border-radius: 0px;
  border:1px solid #ddd;
  margin-top: 0px;
  margin-left: 0px;
  -webkit-box-shadow: 0 6px 12px rgba(0,0,0,.175);
  box-shadow: 0 6px 12px rgba(0,0,0,.175);
  -moz-box-shadow: 0 6px 12px rgba(0,0,0,.175);
  background-clip: padding-box;
  opacity: 0.97;
  filter: alpha(opacity=97);
}
	.highcharts-point { cursor: pointer;}
</style>
<div class="container">
   <?php //echo $chart_room[0];?>
    <div class="bhoechie-tab-container">
        <div class="col-md-12">
              

                <div class="panel-body">
                        <div class="row">
                  		
                        </div>
                        <div class="row">
                        	<div id="chartRoomInv" style="/*min-width: 310px; */height: 400px; margin: 0 auto"></div>
                  		</div>
                  		<div class="row">
                       	<div class="panel panel-default">
							<div class="panel-body">
								<div class="col-md-6">
									<p style="border-bottom: 1px dashed teal;"><strong>Item Request</strong></p>
										@foreach($itemRequest as $objINV)
											{{$objINV->item_code}} - 
											{{$objINV->item_name}} : 
                                            <span style="color:red">{{$objINV->qty}}</span>
                                            <p style="color: #aaa;font-size: 13px">{{$objINV->staff_name}}</p>
										@endforeach
								</div>
								<div class="col-md-6">
									<p style="border-bottom: 1px dashed teal;"><strong>Item Purchase In Stock</strong></p>
										@foreach($itemPurchase as $objINV)
											{{$objINV->item_code}} - 
                                            {{$objINV->item_name}} : 
                                            <span style="color:red">{{$objINV->qty}}</span>
                                            <p style="color: #aaa;font-size: 13px">{{$objINV->staff_name}}</p>

										@endforeach
								</div>
							</div>
							</div>
                  		</div>
                </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modelShowItemInRoom" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel" style="color: teal;">Inventory In Room <span id="headingTitle"></span></h4>
      </div>
      <div class="modal-body">
       
      </div>
      
    </div>
  </div>
</div>
@endsection

@section('jquery')
<script src ="{{ asset('js/highcharts.js') }}"></script>
<script src ="{{ asset('js/drilldown.js') }}"></script>

 <script type="text/javascript">
$(function () {

    // Create the chart
    Highcharts.chart('chartRoomInv', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Summary Report By Zone'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.y}</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                }
            }
        }
    },
    series: [{
            name: 'Total',
            colorByPoint: true,
            data:{!! $chartreplace !!}
        }]
    });
});

	</script>
@endsection
