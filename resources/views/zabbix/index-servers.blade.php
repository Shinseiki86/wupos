@extends('layout')
@section('title', '/ ZABBIX Servers')

@section('content')
	<table id="tbIndex" class="table table-striped">
		<thead>
			<tr>
				<th>hostid</th>
				<th>Host</th>
				@foreach(range(1,$maxCountColumns) as $column)
				<th>Disco {{$column}}</th>
				@endforeach
			</tr>
		</thead>

		<tbody>
			@foreach($hosts as $host)
			<tr class="{{$host->diskUpEightyPercent ? '':''}}">
				<td>{{$host->hostid}}</td>
				<td>{{$host->host}}</td>

				@foreach($host->infoDisk as $letter=>$disk)
				<td>
					<b>{{$letter}}</b> <span class="label label-{{$disk['pused']>80?'danger':'info'}}">{{ $disk['pused'] }}% Used</span><br>
					<b>Free:</b>  {{ !isset($disk['free'])?'':$disk['free'] }}<br>
					<b>Used:</b>  {{ !isset($disk['used'])?'':$disk['used'] }}<br>
					<b>Total:  {{ !isset($disk['total'])?'':$disk['total'] }}</b><br>
				</td>
				@endforeach

				@if($maxCountColumns-count($host->infoDisk)>0)
				@foreach(range(1,$maxCountColumns-count($host->infoDisk)) as $column)
				<td></td>
				@endforeach
				@endif
			</tr>
			@endforeach
		</tbody>
	</table>

@include('partials/datatable') <!-- Script para tablas -->	
@endsection

