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
<div class="container">
    <div class="row">
        <div class="panel panel-default summary">
            <div class="panel-body">
                <div class="col-md-12">
                    <?php
                        $status_arr = array(
                            '0'=>'Waiting Aprroval',
                            '1'=>'Approved',
                            '2'=>'Listing All'
                        );
                    ?>
                    @for( $i=0;$i< 3;$i++ )
                        <a href="/listpurchase_managerapprove/{{ $i }}" >
                            @if(isset($status))
                                @if($status==$i)
                                    <?php $active = 'active';?>
                                @else
                                    <?php $active = '';?>
                                @endif
                            @endif
                            <div class="col-md-4 {{ isset($active)?$active:'' }}">
                                <p>{{ $status_arr[$i] }}</p>
                                <h3>{{ $countPurchase[$i] }}</h3>
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
                        <h3>Supervisor Approve</h3>
                    @endif
                    <hr/>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive" style="overflow-x: visible;">
                                <table class="table table-striped table-bordered" id="itable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Purchase Code</th>
                                            <th>Order By</th>
                                            <th>Supplier</th>
                                            <th>Zone</th>
                                            <th>Date Purchase</th>
                                            <th width="220px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $x = 1;?>
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
                                            <td>{{ date('M d, Y', strtotime($purchase->purchase_date)) }}</td>
                                            <td>
                                                <a style="font-size: 13px" href="#" class="label label-info" onclick="viewAction({{ $purchase->id }});" >View</a>
                                                @if($purchase->status==1)
                                                	 <a class="label label-success" onclick="approvAction({{ $purchase->id }});">S.Approved</a>
                                                     <a name="reject" class="label label-danger" onclick="rejectAction({{ $purchase->id }});">Reject</a>
                                                @elseif($purchase->status==2)
                                                     <b style="color:green">M.Approved</b>
                                                @elseif($purchase->status==3)
                                                     <b style="color: blue">In Stock</b>
                                                @elseif($purchase->is_actived==1)
                                                     <b style="color:red">Rejected</b>
                                                @else
                                               	     <a class="label label-success" onclick="approvAction({{ $purchase->id }});">Approve</a>
                                                     <a class="label label-danger" onclick="rejectAction({{ $purchase->id }});">Reject</a>
                                               	@endif
                                            </td>
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
    function viewAction($id){
        var url = "/viewPurchaseDetail/"+$id;
        $('.modal-body').load(url,function(result){
            $('#modalViewItem').modal({
                show:true,
            });
        });
    }
    function approvAction($id){
        // alert($id);
    	var url = "/manageApprovePurchase/"+$id;
	    $.get(url, function(data, status){
	        //alert("Data: " + data + "\nStatus: " + status);
	        if(data=='yes'){
	        	swal({
                    title:"Item purchase has been approved!",
                    text:"Approved Success!",
                    type:"success",  
                    timer: 1000,   
                    showConfirmButton: false
                });
                window.setTimeout(function(){ document.location.reload(true); },1000);
	        }
	        
	    });
    }
    function rejectAction($id){
        url = "/rejectPurchase/"+$id;
        $.get(url,function(data,status){
            if(data=='yes'){
                swal({
                    title:"Item purchase has been rejected!",
                    text:"Reject Success!",
                    type:"success",  
                    timer: 1000,   
                    showConfirmButton: false
                });
                window.setTimeout(function(){ document.location.reload(true); },1000);
            }
        });
    }
</script>
@endsection