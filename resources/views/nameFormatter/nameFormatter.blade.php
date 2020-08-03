@extends('main')

@section('nameFormatter')

<div id="rulesContainer" class="container">
	<div class="row mt-2">
		<div class="col-md">
			<h3>Rules</h3>
		</div>
	</div>

	<div class="row mt-3">
		<div class="col-md-5">
			@{{ rulesLabel }}
		</div>
		<div class="col-md">
			@{{ rulesByDoctorNameCount }} / @{{ rulesCount }}
		</div>
	</div>

	<div class="row mt-3">

		<div class="col-md">
			<div class="progress w-100">
			  <div class="progress-bar" role="progressbar" :style="{ width: rulesByDoctorNamePercentage+'%'}" :aria-valuenow="rulesByDoctorNameCount" aria-valuemin="0" :aria-valuemax="rulesCount">
			  	@{{ rulesByDoctorNamePercentage }}%
			  </div>
			</div>
		</div>

		<div class="col-md text-right">
			<button type="button" @click="startRules()" class="btn btn-sm btn-success" :disabled="rulesBtn">Apply Rules <i class="fa fa-robot"></i></button>
		</div>
	</div>

	<div class="row mt-3">
		<div class="col-md">

			<div class="form-group">
			  <!-- <textarea class="form-control" rows="12" id="sanitationLogs" v-model="sanitizedByDoctorNameLogs" spellcheck="false"></textarea> -->

				<div id="ruleLogs" contenteditable="true" v-html="rulesByDoctorNameLogs" style="overflow-x: scroll; max-height: 300px; background-color:white;">
			    </div>

			</div>

		</div>
		<div class="col-md">
			<div id="ruleLogs" contenteditable="true" v-html="ruleByDoctorNameFoundLogs" style="overflow-x: scroll; max-height: 300px; background-color:white;">

		    </div>
		</div>
	</div>
</div>

@endsection

@push('rules-scripts')
	<script src="{{ url('../resources/js/vue.js') }}"></script>
	<script src="{{ url('../resources/js/axios.min.js') }}"></script>
    <script type="module" src="{{ url('../resources/js/rules/rules.js') }}"></script>
@endpush