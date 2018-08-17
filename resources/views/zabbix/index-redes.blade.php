@extends('layout')
@section('title', '/ ZABBIX Redes')

@section('content')
	<table id="tbIndex" class="table table-striped">
		<thead>
			<tr>
				@foreach($columns as $column)
				<th>{{$column}}</th>
				@endforeach
			</tr>
		</thead>

		<tbody>
			@foreach($hosts as $host)
			<tr class="{{$host->snmp_available>1 ? 'danger':''}}">
				@foreach($columns as $column)
				<td>{{$host->$column}}</td>
				@endforeach
			</tr>
			@endforeach
		</tbody>
	</table>

@include('partials/datatable') <!-- Script para tablas -->	
@endsection

