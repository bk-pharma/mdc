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
			<label>Raw Data</label>
			<input type="text" v-model="rowCount" :disabled="rowCountField">
			<button type="button" @click="startConsole()" class="btn btn-sm btn-success" :disabled="sanitationBtn">
				<i class="fa fa-play"></i> Start
			</button>

			<h6 class="mt-3">
				Total Sanitized:
				<span>@{{ totalSanitizedRow | numberFormat }} / @{{ rowCount | numberFormat }}</span>
			</h6>
			<h6 class="mt-3">
				Total Amount: <span>₱ @{{ totalSanitizedAmount | numberFormat }}</span>
			</h6>
			<h6 class="mt-3">
				Progress:
				<span>
					@{{ currentSanitationProcess | numberFormat }} / @{{ totalSanitationProcess | numberFormat }}
					(@{{ percentageSanitationProcess }})
				</span>
			</h6>
			<h6 class="mt-3">
				Total Unsanitized: <span>@{{ totalUnsanitizedRow | numberFormat }}</span>
			</h6>
		</div>
	</div>

</div>

@endsection

@push('automatedPhases-scripts')
	<script src="{{ url('../resources/js/vue.js') }}"></script>
	<script src="{{ url('../resources/js/axios.min.js') }}"></script>
    <script type="module" src="{{ url('../resources/js/sanitation/automated.js') }}"></script>
@endpush