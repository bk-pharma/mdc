@extends('main')

@section('sanitationPhaseOne')

<div id="sanitationPhaseOne-container" class="container">
	<div class="row mt-2">
		<div class="col-md">
			<h3>Phase 1</h3>
		</div>
	</div>

	<div class="row mt-3">
		<div class="col-md-5">
			@{{ sanitationLabel }}
		</div>
		<div class="col-md">
			@{{ sanitizedByDoctorNameCount }} / @{{ sanitationCount }}
		</div>
	</div>

	<div class="row mt-3">

		<div class="col-md">
			<div class="progress w-100">
			  <div class="progress-bar" role="progressbar" :style="{ width: sanitizedByDoctorNamePercentage+'%'}" :aria-valuenow="sanitizedByDoctorNameCount" aria-valuemin="0" :aria-valuemax="sanitationCount">
			  	@{{ sanitizedByDoctorNamePercentage }}%
			  </div>
			</div>
		</div>

		<div class="col-md text-right">
			<button type="button" @click="startSanitize()" class="btn btn-sm btn-success" :disabled="sanitationBtn">Sanitize <i class="fa fa-robot"></i></button>
		</div>
	</div>

	<div class="row mt-3">
		<div class="col-md">

			<div class="form-group">
			  <!-- <textarea class="form-control" rows="12" id="sanitationLogs" v-model="sanitizedByDoctorNameLogs" spellcheck="false"></textarea> -->

				<div id="sanitationLogs" contenteditable="true" v-html="sanitizedByDoctorNameLogs" style="overflow-x: scroll; max-height: 300px; background-color:white;">
			    </div>

			</div>

		</div>
		<div class="col-md">
			<div id="sanitizedLogs" contenteditable="true" v-html="sanitizedByDoctorNameFoundLogs" style="overflow-x: scroll; max-height: 300px; background-color:white;">

		    </div>

			<span style="color: green;">Sanitized:</span> @{{ sanitizedByDoctorNameFoundLogsCount }} / @{{ sanitationCount }}
			<br>
			<span style="color: red;">Duplicates:</span> @{{ sanitizedByDoctorNameDuplicateLogsCount }}
		</div>
	</div>
</div>

@endsection

@push('sanitationPhaseOne-scripts')
	<script src="{{ url('../resources/js/vue.js') }}"></script>
	<script src="{{ url('../resources/js/axios.min.js') }}"></script>
    <script type="module" src="{{ url('../resources/js/sanitation/phaseOne.js') }}"></script>
@endpush