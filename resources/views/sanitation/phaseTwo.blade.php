@extends('main')

@section('sanitationPhaseTwo')

<div id="sanitationPhaseTwo-container" class="container">
	<div class="row mt-2">
		<div class="col-md">
			<h3>Phase 2</h3>
		</div>
	</div>

	<div class="row mt-3">
		<div class="col-md-5">
			@{{ sanitationLabel }}
		</div>
		<div class="col-md">
			@{{ getByDoctorNameCount }} / @{{ sanitationCount }}
		</div>
	</div>

	<div class="row mt-3">

		<div class="col-md">
			<div class="progress w-100">
			  <div class="progress-bar" role="progressbar" :style="{ width: getByDoctorNamePercentage+'%'}" :aria-valuenow="getByDoctorNameCount" aria-valuemin="0" :aria-valuemax="sanitationCount">
			  	@{{ getByDoctorNamePercentage }}%
			  </div>
			</div>
		</div>

		<div class="col-md text-right">
			<button type="button" @click="sanitizeNow()" class="btn btn-sm btn-success" :disabled="sanitationBtn">Sanitize <i class="fa fa-robot"></i></button>
		</div>
	</div>

	<div class="row mt-3">
		<div class="col-md">

			<div class="form-group">
			  <!-- <textarea class="form-control" rows="12" id="sanitationLogs" v-model="getByDoctorNameLogs" spellcheck="false"></textarea> -->

				<div id="sanitationLogs" contenteditable="true" v-html="getByDoctorNameLogs" style="overflow-x: scroll; max-height: 300px; background-color:white;">
			    </div>

			</div>

		</div>
		<div class="col-md">
			<div id="sanitizedLogs" contenteditable="true" v-html="getByDoctorNameFoundLogs" style="overflow-x: scroll; max-height: 300px; background-color:white;">

		    </div>

			<span style="color: green;">Sanitized:</span> @{{ getByDoctorNameFoundLogsCount }} / @{{ sanitationCount }}
			<br>
			<span style="color: red;">Duplicates:</span> @{{ getByDoctorNameDuplicateLogsCount }}
		</div>
	</div>
</div>

@endsection

@push('sanitationPhaseTwo-scripts')
	<script src="{{ url('../resources/js/vue.js') }}"></script>
	<script src="{{ url('../resources/js/axios.min.js') }}"></script>
    <script type="module" src="{{ url('../resources/js/sanitation/phaseTwo.js') }}"></script>
@endpush