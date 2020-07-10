@extends('layouts.app')

@section('content')

<div id="sanitation-container" class="container">
	<div class="row mt-2">
		<div class="col-md">
			<h3>Removing Prefix</h3>
		</div>
	</div>

	<div class="row mt-3">
		<div class="col-md-5">
			@{{ sanitationLabel }}
		</div>
<!-- 		<div class="col-md">
			@{{ sanitizedByDoctorNameCount }} / @{{ sanitationCount }}
		</div> -->
	</div>

	<div class="row mt-3">
		<div class="col-md">
			<div class="progress w-100">
			  <div class="progress-bar" role="progressbar" :style="{ width: sanitizedByDoctorNameCount+'%'}" :aria-valuenow="sanitizedByDoctorNameCount" aria-valuemin="0" :aria-valuemax="sanitationCount">
			  	@{{ sanitizedByDoctorNameCount }} / @{{ sanitationCount }}
			  </div>
			</div>
		</div>

		<div class="col-md">

		</div>
	</div>

	<div class="row mt-3">
		<div class="col-md">
			<button type="button" @click="startSanitized()" class="btn btn-sm btn-primary">Start sanitize</button>
		</div>
	</div>

</div>

@endsection

@push('sanitation-scripts')
	<script src="{{ url('../resources/js/vue.js') }}"></script>
	<script src="{{ url('../resources/js/axios.min.js') }}"></script>
    <script type="module" src="{{ url('../resources/js/practice.js') }}"></script>
@endpush