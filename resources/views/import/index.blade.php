@extends('main')

@section('import')

<div id="importContainer" class="container pl-3">
	<div class="row mt-2">
		<div class="col-md">
			<h3></h3>
		</div>
	</div>

	<div class="row mt-3">
		<form>
		  <div class="custom-file">
		    <input type="file" class="custom-file-input" id="file" ref="file" v-on:change="handleFileUpload()" :disabled="browseBtn" />
		    <!-- <input type="file" id="file" ref="file" v-on:change="handleFileUpload()" /> -->
		    <label class="custom-file-label" for="customFile">Choose file</label>
		    <button type="button" class="btn btn-sm btn-success mt-2" v-on:click="submitFile()" :disabled="uploadBtn">Upload</button>
		  </div>
		</form>
	</div>

	<div class="row mt-5">
		<span id="status" style="font-size: 17px; color: #FF0000;">
			@{{ status }}
		</span>
	</div>
	<div class="row mt-1">
		<span style="font-size: 20px;">
			Total imported: <span id="totalImported"> @{{ totalRaw | numberFormat }} </span>
		</span>
	</div>
	<div class="row mt-1 mb-1">
		<span id="runtime" style="font-size: 20px;">
			Runtime: @{{ runTime }}
		</span>
	</div>
	<div class="row" v-for="error in importErrors" :key="error.id" v-show="!isUploading">
		<span id="importErrors" style="font-size: 14px;">
			<span style="color:#FF0000;">Row#</span>: @{{ error.row_id }} , <span style="color:#FF0000;">Error</span>: @{{ error.error }}
		</span>
	</div>
	<div class="row">
		<span id="totalErrors" style="font-size: 14px;" v-show="totalErrors > 0 && !isImporting">
			<span style="color:#FF0000;">Error</span>: @{{	totalErrors }}
		</span>
	</div>
	<div class="row mt-2">
		<span id="totalErrors" style="font-size: 14px;" v-show="totalErrors > 0 && !isImporting">
			<form method="get" action="{{ url('/import/errors/export') }}">
				<button class="btn btn-sm btn-info"><i class="fas fa-file-download"></i> Export</button>
			</form>
		</span>
	</div>
</div>

@endsection

@push('import-scripts')
	<script src="{{ url('../resources/js/vue.js') }}"></script>
	<script src="{{ url('../resources/js/axios.min.js') }}"></script>
	<script src="{{ url('../resources/js/import/import.js') }}"></script>
@endpush