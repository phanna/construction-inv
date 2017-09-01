@extends('layouts.app')

@section('content')
<style>
   .glyphicon-plus{
        left: 13px;
        color: #fff;
        top: -2px;
    }
    #addBtn{
        padding-left:27px;
        margin-left: -13px;
        margin-bottom: 10px;
    }
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
    .label{
        font-size: 13px;
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
                @for($i=0;$i< 3;$i++)
                    <a href="/stockRequest/{{ $i }}">
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
                    <h3>Stock Request</h3>
                @endif
                    <hr/>
                    <div class="row">
                        <div class="col-md-12">
                            <i class="glyphicon glyphicon-plus"></i>
                            <a href="/addNewItemRequest" class="btn btn-info" id="addBtn">
                                New Request</a>
                            <div class="table-responsive" style="overflow-x: visible;">
                                <table class="table table-striped table-bordered" id="itable">
                                    <thead>
                                        <tr>
                                            <th >#</th>
                                            <th>Invoid Code</th>
                                            <th>Staff Request</th>
                                            <th>Zone</th>
                                            <th>Date Request</th>
                                            <th width="150px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $x = 1;?>
                                    @foreach($getSaleInv as $invoice)
                                    <?php 
                                        $staffNames = $invoice->getStaffName();
                                        $zoneNames = $invoice->getZoneName();
                                    ?>
                                        <tr>
                                            <td>{{ $x }}</td>
                                            <td>
                                                @if( $invoice->note )
                                                    <a data-toggle="tooltip" data-placement="top" title="{{ $invoice->note }}">{{ $invoice->invoid_code }}</a>
                                                @else
                                                    {{ $invoice->invoid_code }}
                                                @endif
                                            </td>
                                            <td>{{ $staffNames[$invoice->staff_id] }}</td>
                                            <td>{{ $zoneNames[$invoice->zone_id] }}</td>
                                            <td>{{ date('M d, Y', strtotime($invoice->toDate)) }}</td>
                                            <td>
                                                <a class="label label-info" onclick="viewAction({{ $invoice->id }});">View</a>
                                                @if($invoice->status==1)
                                                    <b style="color:green">S.Approved</b>
                                                @elseif($invoice->status==2)
                                                    <b style="color:green">M.Approved</b>
                                                @elseif($invoice->is_actived==1)
                                                    <b style="color:red">Rejected</b>
                                                @else
                                                    <a style="font-size: 13px" href="/editSaleDetail/{{ $invoice->id }}" class="label label-primary">Edit</a>
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
        <h4 class="modal-title" id="myModalLabel">Item Requested</h4>
      </div>
        <div class="modal-body">
            
        </div>
    </div>
  </div>
</div>
@endsection

@section('jquery')
<script>
    function statusAction($id){
        var url= '/stockRequest/'+$id;
        $.get(url,function(data,status){
            alert(data);
        });
    }
    function viewAction($id){
        var url = "/getSaleDetailview/"+$id;
        $('.modal-body').load(url,function(result){
            $('#modalViewItem').modal({
                show:true,
            });
        });
    }
</script>
@endsection

