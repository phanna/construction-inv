@extends('layouts.app')

@section('content')
<style>
    .col-md-4{
        margin-right:0px;
        margin-left: 0px;
        background: linear-gradient(#c4c5c6,#f5f7f8);
        border: 1px solid #ccc;
        text-align: center;
        color: #555;
        cursor: pointer;
    }
    div.col-md-4{
        box-shadow: 0 1px 3px rgba(221,221,221,0.5);
        margin-bottom: 20px;
        padding: 15px;
    }
    .col-md-4:hover{
        color:#00aba9;
    }  
    .active{
         color:#00aba9 !important;
    }
</style>

<?php
    $status_arr = array(
        '0'=>'Waiting Delivery',
        '1'=>'In Stock',
        '2'=>'Listing All'
    );
?>
<div class="container">
    <div class="row">
        <div class="panel panel-default summary">
            <div class="panel-body">
                <div class="col-md-12">
                    <div class="row">
                        @for( $i=0;$i< 3;$i++ )
                            <a href="/stockin/{{ $i }}" >
                                @if(isset($status))
                                    @if($status==$i)
                                        <?php $active = 'active';?>
                                    @else
                                        <?php $active = '';?>
                                    @endif
                                @endif
                                <div class="col-md-4 {{ isset($active)?$active:'' }}">
                                    <p>{{ $status_arr[$i] }}</p>
                                    <h3>{{ $countRequest[$i] }}</h3>
                                </div>
                            </a>
                        @endfor
                        @if(isset($status))
                            @for($j=0;$j< 3;$j++)
                                @if($status==$j)
                                    <h3>{{ $status_arr[$j] }}</h3>
                                @endif
                            @endfor
                        @else
                            <h3>Stock In</h3>
                        @endif
                    </div>

                    <div class="row">
                    <hr/>
                    <div class="table-responsive" style="overflow-x: visible;">
                        <table class="table table-striped table-bordered" id="itable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Purchase Code</th>
                                    <th>Order By</th>
                                    <th>Supplier</th>
                                    <th>Zone</th>
                                    <th>Total</th>
                                    <th>Date Purchase</th>
                                    <th>Date Purchase In</th>
                                   <th>Note</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $x = 1; $total=0;?>
                            @foreach($purchases as $purchase)
                                <tr class="hideApprove{{$purchase->id}}">
                                    <td>{{ $x }}</td>
                                    <td>
                                        @if( $purchase->note )
                                            <a data-toggle="tooltip" data-placement="top" title="{{ $purchase->note }}">{{ $purchase->purchase_code }}</a>
                                        @else
                                            {{ $purchase->purchase_code }}
                                        @endif
                                    </td>
                                    <td>{{ $purchase->staff_name }}</td>
                                    <td>{{ $purchase->company_name }}</td>
                                    <td>{{ $purchase->zone }}</td>
                                    <td>$ {{ ($purchase->total_price)?$purchase->total_price:$total }}</td>
                                    <td>{{ date('M d, Y', strtotime($purchase->purchase_date)) }}
                                    </td>
                                    @if($purchase->status==3)
                                        <td>{{ date('M d, Y H:i A', strtotime($purchase->date_in)) }}</td>
                                        <td>{{$purchase->purchase_note}}</td>
                                        <td>
                                            <a href="#" onclick="viewAction('view',{{ $purchase->id }});" class="label label-info">View</a>
                                            <b style="color: blue">In Stock</b>
                                        </td>
                                    @else
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <a href="#" onclick="viewAction('view',{{ $purchase->id }});" class="label label-info">View</a>
                                            <a href="#" onclick="takeInAction({{ $purchase->id }});" class="label label-success">Take In</a>
                                        </td>
                                    @endif
                                </tr>
                                <?php $x++;?>
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
<!-- Modal -->
<div class="modal fade" id="modalViewItem" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Item Purchase</h4>
      </div>
        <div class="modal-body">
            
        </div>
    </div>
  </div>
</div>
@endsection

@section('jquery')
<script>
    function takeInAction($id){
        var url = "/listStocktakeIn/"+$id;
        $('.modal-body').load(url,function(result){
            $('#modalViewItem').modal({
                show:true,
            });
        });
    }
    function viewAction($view,$id){
        var url = "/listStockviewtakeIn/"+$view+"/"+$id;
        $('.modal-body').load(url,function(result){
            $('#modalViewItem').modal({
                show:true,
            });
        });
    }
    $(function(){
	
        $(document).on('submit', "#takeoutstock",function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: "POST",
                processData: false,
                contentType: false,
                url: "/submitStockIn",
                data: formData,
                success: function (response) {
                    $('#modalViewItem').modal('toggle');
                    window.setTimeout(function(){ document.location.reload(true); }, 100);
                },
                error: function () {
                    alert('SYSTEM ERROR, TRY LATER AGAIN');
                }
            });
        });
    });
    
</script>
@endsection

