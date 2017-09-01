<div class="table-responsive" style="overflow-x: visible;">
<table class="table table-striped table-bordered" id="itable">
    <thead>
        <tr>
            <th>#</th>
            <th>Item Code</th>
            <th>Item Name</th>
            <th>Amount</th>
            <th>Item measure</th>
        </tr>
    </thead>
    <tbody>
        <?php $x = 1;?>
        @foreach($getSaleDetails as $inv)
        <tr>
            <td>{{ $x }}</td>
            <td>{{ $inv->item_code }}</td>
            <td>{{ $inv->item_name }}</td>
            <td>{{ $inv->qty }}</td>
            <td>{{ $inv->item_measure }}</td>
        </tr>
        <?php $x++;?>
        @endforeach
    </tbody>
</table>
</div>