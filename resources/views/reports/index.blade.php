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
				<div class="col-md-6">
					<h3>Reports</h3>
					<hr/>
					<div class="general">
						<span class="glyphicon glyphicon-star-empty"></span>
						<span>
							<a href="/inventory" class="tax_rate">Inventory</a>
							<p>Manage all users in Company.</p>
						</span>
					</div>
					
					
				</div>

				<div class="col-md-6">
					
				</div>
			</div>
		</div>
	</div>
</div>
@endsection