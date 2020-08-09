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
			<h5>@{{automatedLabel}}</h5>
		</div>



	</div>
	<div class="row mt-2">
		<div class="col-md text-left">
			<label>Total Sanitation</label>
			<input type="text" v-model="rowCount">
			<button type="button" @click="startConsole()" class="btn btn-sm btn-success" :disabled="sanitationBtn">
				<i class="fa fa-play"></i> Start
			</button>
		</div>
	</div>

</div>

@endsection

@push('automatedPhases-scripts')
	<script src="{{ url('../resources/js/vue.js') }}"></script>
	<script src="{{ url('../resources/js/axios.min.js') }}"></script>
    <script type="module" src="{{ url('../resources/js/sanitation/automated.js') }}"></script>
@endpush