<form method="post" id="takeoutstock">
    {{ csrf_field() }}
    <div class="table-responsive" style="overflow-x: visible;">
        <table class="table table-striped table-bordered" id="itable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Item Code</th>
                    <th>Item Name</th>
                    <th>Amount</th>
                    <th>Item measure</th>
                    <th>Unit Price</th>
                </tr>
            </thead>
            <tbody>
                <?php $x = 1;$total = 0;?>
                @foreach($getPurDetails as $inv)
                <?php 
                    $total+=$inv->qty*$inv->unit_price;
                ?>
                <tr>
                    <input type="hidden" name="itemid[]" value="{{$inv->item_id}}">
                    <input type="hidden" name="saleInvid[]" value="{{$inv->purchase_id}}">
                    <input type="hidden" name="qty[]" value="{{$inv->qty}}">
                    <input type="hidden" name="price[]" value="{{$inv->unit_price}}">
                    
                    <td>{{ $x }}</td>
                    <td>{{ $inv->item_code }}</td>
                    <td>{{ $inv->item_name }}</td>
                    <td>{{ $inv->qty }}</td>
                    <td>{{ $inv->item_measure }}</td>
                    <td>$ {{ $inv->unit_price }}</td>
                </tr>
                <?php $x++;?>
                @endforeach
                <tr>
                    <td colspan="5" style="text-align: right;">Total :</td>
                    <td >$ {{ $total }}</td>
                </tr>
                <input type="hidden" name="totalprice" value="{{ $total }}">
            </tbody>
        </table>
    </div>
    @if(isset($views))

    @else
    <div class="form-group row">
        <div class="col-md-5" style="padding-bottom: 10px;">
            <textarea type="text" class="form-control" name="purchasenoted" placeholder="Note" required></textarea>
        </div>
        <div class="col-md-5" style="padding-bottom: 10px;">
            <input type="text" class="form-control show_current_date" name="dateDelever" id="dateDelever" required>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-info" name="submit">Take In</button>
        </div>
    </div>
    @endif
</form>
<script>
$(function(){
		
        $(".show_current_date").datetimepicker({
            value:new Date(),
            /*timepicker:false,*/
            format:'d-M-Y H:i'
        }); 
});
</script>