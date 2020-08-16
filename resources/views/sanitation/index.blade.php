@extends('main')

@section('sanitation')

<div id="sanitation-container" class="container">
	<div class="row mt-2">
		<div class="col-md">
			<h3 class="text-center"></h3>
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
				<span>
					@{{ totalSanitizedRow | numberFormat }}
					<span style="color:	#0000ff;">@{{ percentageSanitizedRow | decimalFormat }}%</span>
				</span>
			</h6>
			<h6 class="mt-1">
				Total Amount: <span>₱ @{{ totalSanitizedAmount | numberFormat }}</span>
			</h6>

			<h6 class="mt-3">
				Progress:
				<span>
					@{{ currentSanitationProcess | numberFormat }} / @{{ totalSanitationProcess }}
					<span style="color:	#0000ff;">@{{ percentageSanitationProcess | decimalFormat }}%</span>
				</span>
			</h6>
			<h6 class="mt-1">
				 Previous sanitized:
				<span>
					@{{ previousSanitized | numberFormat }}
					<span style="color:#ff0000;">@{{ previousSanitizedPercentage| decimalFormat }}%</span>
				</span>
			</h6>
			<h6 class="mt-1">
				 Run:
				<span>
					@{{ totalRun }} / 3
				</span>
			</h6>
			<h6 class="mt-3">
				Total Unsanitized: <span>@{{ totalUnsanitizedRow | numberFormat }}</span>
			</h6>
		</div>
	</div>

</div>

@endsection

@push('sanitation-scripts')
	<script src="{{ url('../resources/js/vue.js') }}"></script>
	<script src="{{ url('../resources/js/axios.min.js') }}"></script>
    <script type="module" src="{{ url('../resources/js/sanitation/sanitation.js') }}"></script>
@endpush