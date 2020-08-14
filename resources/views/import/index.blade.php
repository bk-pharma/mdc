@extends('main')

@section('import')

<div id="import-container" class="container">
	<div class="row mt-2">
		<div class="col-md">
			<h3></h3>
		</div>
	</div>

	<div class="row mt-3">
		import
	</div>
</div>

@endsection

@push('import-scripts')
	<script src="{{ url('../resources/js/vue.js') }}"></script>
	<script src="{{ url('../resources/js/axios.min.js') }}"></script>
@endpush