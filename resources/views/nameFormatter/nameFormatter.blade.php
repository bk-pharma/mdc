@extends('main')

@section('nameFormatter')

<div id="nfContainer" class="container">
	<div class="row mt-2">
		<div class="col-md">
			<h3>Name Formatter</h3>
		</div>
	</div>

	<div class="row mt-3">
		<div class="col-md-5">
			@{{ nfLabel }}
		</div>
		<div class="col-md">
			@{{ nfByDoctorNameCount }} / @{{ nfCount }}
		</div>
	</div>

	<div class="row mt-3">

		<div class="col-md">
			<div class="progress w-100">
			  <div class="progress-bar" role="progressbar" :style="{ width: nfByDoctorNamePercentage+'%'}" :aria-valuenow="nfByDoctorNameCount" aria-valuemin="0" :aria-valuemax="nfCount">
			  	@{{ nfByDoctorNamePercentage }}%
			  </div>
			</div>
		</div>

		<div class="col-md text-right">
			<button type="button" @click="startFormatter()" class="btn btn-sm btn-success" :disabled="rulesBtn">Format Name <i class="fa fa-robot"></i></button>
		</div>
	</div>

	<div class="row mt-3">
		<div class="col-md">

			<div class="form-group">
			  <!-- <textarea class="form-control" rows="12" id="sanitationLogs" v-model="sanitizedByDoctorNameLogs" spellcheck="false"></textarea> -->

				<div id="nfLogs" contenteditable="true" v-html="nfByDoctorNameLogs" style="overflow-x: scroll; max-height: 300px; background-color:white;">
			    </div>

			</div>

		</div>
		<div class="col-md">
			<div id="nfLogs" contenteditable="true" v-html="nfByDoctorNameFoundLogs" style="overflow-x: scroll; max-height: 300px; background-color:white;">

		    </div>
		</div>
	</div>
</div>

@endsection

@push('nameFormatter-scripts')
	<script src="{{ url('../resources/js/vue.js') }}"></script>
	<script src="{{ url('../resources/js/axios.min.js') }}"></script>
    <script type="module" src="{{ url('../resources/js/nameFormatter/nameFormatter.js') }}"></script>
@endpush