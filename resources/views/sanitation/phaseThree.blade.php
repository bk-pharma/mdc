@extends('main')

@section('sanitationPhaseThree')

<div id="sanitationPhaseThree-container" class="container">
	<div class="row mt-2">
		<div class="col-md">
			<h3>Phase 3</h3>
		</div>
	</div>

	<div class="row mt-3">
		<div class="col-md-5">
			@{{ sanitationLabel }}
		</div>
		<div class="col-md">
			@{{ dataToBeSanitizedIndex }} / @{{ sanitationCount }}
		</div>
	</div>

	<div class="row mt-3">

		<div class="col-md">
			<div class="progress w-100">
			  <div class="progress-bar bg-success" role="progressbar" :style="{ width: sanitizedByDoctorNamePercentage+'%'}" :aria-valuenow="dataToBeSanitizedIndex" aria-valuemin="0" :aria-valuemax="sanitationCount">
			  		@{{ sanitizedByDoctorNamePercentage }}%
			  </div>
			</div>
		</div>

		<div class="col-md text-right">
			<button type="button" @click="startSanitize()" class="btn btn-sm btn-success">Sanitize <i class="fa fa-robot"></i></button>
		</div>
	</div>

	<div class="row mt-3">
		<div class="col-md">

			<div class="form-group">
				<div id="leftLogsPhaseThree" contenteditable="true" spellcheck="false" v-html="leftLogs" style="overflow-x: scroll; max-height: 300px; background-color:white;">
			    </div>

			</div>

		</div>
		<div class="col-md">
			<div id="rightLogsPhaseThree" contenteditable="true" spellcheck="false" v-html="rightLogs" style="overflow-x: scroll; max-height: 300px; background-color:white;">

		    </div>

			<span style="color: green;">Sanitized:</span> @{{ totalFound }} / @{{ sanitationCount }}
		</div>
	</div>

</div>

@endsection

@push('sanitationPhaseThree-scripts')
	<script src="{{ url('../resources/js/vue.js') }}"></script>
	<script src="{{ url('../resources/js/axios.min.js') }}"></script>
    <script type="module" src="{{ url('../resources/js/sanitation/phaseThree.js') }}"></script>
@endpush