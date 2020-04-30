<!-- Pregunta con Items -->
	<div class='well' ng-app="appEva360" ng-controller="ItemsController">
		<div>

			<div class="text-right">
				<button class="btn btn-primary text-right addItem" type="button" data-tooltip="tooltip" title="Sólo puede agregar 10 opciones.">
					<i class="fa fa-plus" aria-hidden="true"></i> Add Opción
				</button>
			</div>
			<ul id="containerItems">
				{{--
					Se debe revisar como mejorar la carga de los items, ya que se repite código.
					Se planea realizar mediante include con paso de variables.
				--}}
				@forelse($itemsPreg as $key => $item)
				{{-- Si hay items, crear input's con los datos --}}
				<li class="input-group itemPreg" id="{{ $key+1 }}">
					<span class="input-group-addon drag-handle">
						&#9776; Opc {{ $key+1 }}
					</span>
					<input class="form-control valueItem"
						type="text"
						name="{{ 'opc_old_'.$item->ITPR_ID }}"
						value="{{ $item->ITPR_TEXTO }}"
						required
					>
					<span class="input-group-btn"><!-- carga botón de borrar ItemPreg-->
						<button class="btn btn-danger deleteItem" type="button" data-tooltip="tooltip" data-placement="right" title="Borrar">
							<i class="fa fa-trash" aria-hidden="true"></i>
						</button>
					</span>
				</li>
				@empty
				{{-- Si no hay items, crear input vacío para nuevo registro --}}
				<li class="input-group itemPreg" id="1">
					<span class="input-group-addon drag-handle">
						&#9776; Opc n
					</span>
					<input class="form-control valueItem"
						type="text"
						name="opc_new_1"
						value=""
						required
					>
					<span class="input-group-btn"><!-- carga botón de borrar ItemPreg-->
						<button class="btn btn-danger deleteItem" type="button" data-tooltip="tooltip" data-placement="right" title="Borrar">
							<i class="fa fa-trash" aria-hidden="true"></i>
						</button>
					</span>
				</li>
				@endforelse
			</ul><!-- containerItems -->
		</div>

		
	</div><!-- well ItemsController-->


@push('scripts')
	{!! Html::script('js/angular/angular.min.js') !!}
	{!! Html::script('js/Sortable/Sortable.js') !!}
	{!! Html::script('js/Sortable/ng-sortable.js') !!}
	<script>
		var appEva360 = angular.module('appEva360', [], function($interpolateProvider) {
			$interpolateProvider.startSymbol('{%');
			$interpolateProvider.endSymbol('%}');
		});
		appEva360.controller('ItemsController', ['$scope', function($scope){
			var containerItems = document.getElementById("containerItems");
			var itemsSortable = Sortable.create(containerItems, {
				'handle'   : '.drag-handle',
				'animation': 300,
				'ghostClass': 'ghost',
				'disabled': false,
				/*onUpdate: function (evt) {
					var itemsPreg = itemsSortable.el.getElementsByClassName('itemPreg');
					angular.forEach(itemsPreg, function (item, index) {
						var posItem = item.getElementsByClassName('posItem')[0];
						posItem.setAttribute('value',index+1);
						posItem.value = index+1;
					});
				},*/
			});

			$('[data-tooltip="tooltip"]').tooltip();
			var cantItems = ($("#containerItems").find('.itemPreg')).length + 1;
			console.log(cantItems);
			if(cantItems >= 10){
				$( '.addItem' ).prop('disabled', true);
			}
		}]);//Fin Angular ItemsController


//*************
		$(document).on("click", ".addItem", function(){
			var containerItems = $("#containerItems")
			var cantItems = (containerItems.find('.itemPreg')).length + 1;
			var newItemPreg = containerItems.find('.itemPreg:last').clone();

			newItemPreg.find('.drag-handle').html('&#9776; Opc n');
			newItemPreg.attr('id', cantItems);

			var input = newItemPreg.find('.valueItem')
				input.val('');
				input.attr('value', '');
				input.attr('name', 'opc_new_'+cantItems);

			newItemPreg.appendTo(containerItems);
			$('[data-tooltip="tooltip"]').tooltip();
			if(cantItems >= 10){
				$( this ).prop('disabled', true);
			}
		});

		$(document).on("click", ".deleteItem", function(){
			var containerItems = $("#containerItems")
			var cantItems = (containerItems.find('.itemPreg')).length;
			if(cantItems>1)
				$( this ).parent().parent().remove();
			if(cantItems<=10)
				$( '.addItem' ).prop('disabled', null);
		});

	</script>
@endpush

@push('head')
	<style>
		/* Define el tamaño de los drag-handle para que sean todos iguales */
		.drag-handle {
			min-width:90px;
			text-align:left;
		}
		/* Define el cursor al mover un item */
		.drag-handle {
			cursor: n-resize;
			cursor: grab;
			cursor: -webkit-grab;
			cursor: -moz-grab
		}
		.drag-handle:active {
			cursor: grabbing;
			cursor: -webkit-grabbing;
			cursor: -moz-grabbing
		}
		/* Define estilo del item al moverlo */
		.ghost {
			opacity: 0.5;
		}
	</style>
@endpush
