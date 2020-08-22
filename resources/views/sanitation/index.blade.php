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
			<h5 id="sanitationStatus">@{{ sanitationStatus }}</h5>
		</div>
	</div>
	<div class="row mt-2">
		<div class="col-md text-left">
			<label>Raw Data</label>
<<<<<<< HEAD
			<input type="text" id="inititalRowCount" v-model="rowCount" :disabled="rowCountField" autocomplete="off">
=======
			<input type="text" id="inititalRowCount" v-model="rowCount" :disabled="rowCountField">

>>>>>>> bf0cde4a4be72bb0a9838547eac1e81d0691adb9
			<button type="button" id="startBtn" @click="startConsole()" class="btn btn-sm btn-success" :disabled="sanitationBtn">
				<i class="fa fa-play"></i> Start
			</button>

			<h6 class="mt-3">
				Total Sanitized:
				<span id="totalSanitized">
					@{{ totalSanitizedRow | numberFormat }}
					<span id="totalSanitizedPercentage" style="color:#0000ff;">
<<<<<<< HEAD
							@{{ percentageSanitizedRow | decimalFormat }}%
=======
						@{{ percentageSanitizedRow | decimalFormat }}%
>>>>>>> bf0cde4a4be72bb0a9838547eac1e81d0691adb9
					</span>
				</span>
			</h6>
			<h6 class="mt-1">
				Total Amount: <span id="totalAmount">₱ @{{ totalSanitizedAmount | numberFormat }}</span>
			</h6>
<<<<<<< HEAD
			<h6 class="mt-3">
				Progress:
				<span id="totalProgress">
					@{{ currentSanitationProcess | numberFormat }} / @{{ totalSanitationProcess }}
						<span id="currentProgress" style="color:#0000ff;">
								@{{ percentageSanitationProcess | decimalFormat }}%
						</span>
				</span>
			</h6>
			<h6 class="mt-1">
				 Previous sanitized:
				<span>
					@{{ previousSanitized | numberFormat }}
					<span id="totalPrevious" style="color:#ff0000;">@{{ previousSanitizedPercentage| decimalFormat }}%</span>
				</span>
			</h6>
			<h6 class="mt-1">
				 Run: <span id="run">@{{ totalRun }}</span> / 3
			</h6>
			<h6 class="mt-3">
				Total Unsanitized: <span id="totalUnsanitized">@{{ totalUnsanitizedRow | numberFormat }}</span>
=======
			<h6 class="mt-1">
				Total Unsanitized: <span id="totalUnsanitized">@{{ totalUnsanitizedRow | numberFormat }}</span>
			</h6>
			<h6 class="mt-1">
				Run time: @{{ runTime }}
>>>>>>> bf0cde4a4be72bb0a9838547eac1e81d0691adb9
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