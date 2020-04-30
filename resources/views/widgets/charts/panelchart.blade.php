<div class="col-xs-12 col-sd-5 col-md-5">
	<div class="panel panel-info panel-chart">
		<div class="panel-heading">
			{{$title}}
			<div class="panel-control pull-right">
				<select class="typeChart disabled">
					<option value="bar">Barras</option>
					<option value="pie">Torta</option>
				</select>
				<a class="panelButton"><i class="fas fa-sync-alt"></i></a>
				<a class="panelButton"><i class="fas fa-minus"></i></a>
				<a class="panelButton"><i class="fas fa-times"></i></a>
			</div>
		</div>
		<div class="panel-body">
			<canvas class="canvas-chart" id="{{$idCanvas}}" style="height:350px"></canvas>
		</div>
	</div>
</div>
