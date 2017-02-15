@section('head')
	<style>
		/* Define el tamaño de los input-group-addon para que sean todos iguales */
		.input-group-addon {
			min-width:100px;
			text-align:left;
		}
	</style>
@parent
@endsection

<div id="filters" class="collapse">
	<div class="form-group col-xs-12 col-md-8">
	<form>
		<div class="input-group has-feedback">
			<div class="input-group-addon control-label">Certificado</div>
			<input type="text"
				class="form-control"
				placeholder="Por certificado..."
				ng-model="searchCertificado.CERT_codigo"
			>
			<span ng-if="searchCertificado.CERT_codigo"
				ng-click="searchCertificado.CERT_codigo = ''"
				class="glyphicon glyphicon-remove-circle form-control-feedback"
				style="cursor: pointer; pointer-events: all;"
				uib-tooltip="Borrar"
			></span>
		</div>

		<div class="input-group has-feedback">
			<div class="input-group-addon control-label">Agencia</div>
			<input type="text"
				class="form-control"
				placeholder="Por código agencia..."
				ng-model="searchCertificado.AGEN_codigo"
			>
			<span ng-if="searchCertificado.AGEN_codigo"
				ng-click="searchCertificado.AGEN_codigo = ''"
				class="glyphicon glyphicon-remove-circle form-control-feedback"
				style="cursor: pointer; pointer-events: all;"
				uib-tooltip="Borrar"
			></span>
			<input type="text"
				class="form-control"
				placeholder="Por nombre agencia..."
				ng-model="searchCertificado.AGEN_nombre"
			>
			<span ng-if="searchCertificado.AGEN_nombre"
				ng-click="searchCertificado.AGEN_nombre = ''"
				class="glyphicon glyphicon-remove-circle form-control-feedback"
				style="cursor: pointer; pointer-events: all;"
				uib-tooltip="Borrar"
			></span>
		</div>

		<div class="input-group has-feedback">
			<div class="input-group-addon control-label">Cuenta WU</div>
			<input
				type="text"
				class="form-control"
				placeholder="Por Cuenta WUPOS..."
				ng-model="searchCertificado.AGEN_cuentawu"
			>
			<span ng-if="searchCertificado.AGEN_cuentawu"
				ng-click="searchCertificado.AGEN_cuentawu = ''"
				class="glyphicon glyphicon-remove-circle form-control-feedback"
				style="cursor: pointer; pointer-events: all;"
				uib-tooltip="Borrar"
			></span>
		</div>

		<div class="input-group">
			<div class="input-group-addon">Regional</div>
			<select type="text" class="form-control" ng-model="searchCertificado.REGI_nombre" >
				<option value="">Todas</option>
				<option ng-repeat="reg in regionales" value="{% reg.REGI_nombre %}">
					{% reg.REGI_nombre %}
				</option>
			</select>
		</div>
		{{ Form::button( '<i class="fa fa-undo" aria-hidden="true"></i> Reset', ['class'=>'btn btn-warning', 'ng-click'=>'searchCertificado = []'] ) }}
	</form>
	</div>
</div>