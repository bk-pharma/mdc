@extends('main')

@section('automatedPhases')

<div id="automatedPhases-container" class="container">
	<div class="row mt-2">
		<div class="col-md">
			<h3 class="text-center">Automated Sanitize</h3>
		</div>
	</div>

	
	<div class="row mt-3">

		<div class="col-md-6">
			<h3>@{{automatedLabel}}</h3>
		</div>

		
		
	</div>
	<div class="row mt-2">
		<div class="col-md text-left">
			<button type="button" @click="startConsole()" class="btn btn-sm btn-success" :disabled="sanitationBtn">Automated Sanitize <i class="fa fa-robot"></i></button>

		</div>
	</div>
	
</div>

@endsection

@push('automatedPhases-scripts')
	<script src="{{ url('../resources/js/vue.js') }}"></script>
	<script src="{{ url('../resources/js/axios.min.js') }}"></script>
    <script type="module" src="{{ url('../resources/js/sanitation/automated.js') }}"></script>
@endpush