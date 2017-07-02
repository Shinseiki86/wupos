<th class="{{ isset($class) ? $class : '' }}" style="{{ isset($width) ? $width : '' }}">
	<a href="#" ng-click="sortType = '{{ $id }}'; sortReverse = !sortReverse">
		{{ $title }}
		<span ng-show="sortType == '{{ $id }}' && !sortReverse" class="fa fa-caret-down"></span>
		<span ng-show="sortType == '{{ $id }}' && sortReverse" class="fa fa-caret-up"></span>
	</a>
</th>
