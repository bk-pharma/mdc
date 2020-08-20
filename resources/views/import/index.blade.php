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
		    <input type="file" class="custom-file-input" id="file" ref="file" v-on:change="handleFileUpload()"/>
		    <!-- <input type="file" id="file" ref="file" v-on:change="handleFileUpload()" /> -->
		    <label class="custom-file-label" for="customFile">Choose file</label>
		    <button type="button" class="btn btn-sm btn-success mt-2" v-on:click="submitFile()">Upload</button>
		  </div>
		</form>
	</div>
</div>

@endsection

@push('import-scripts')
	<script src="{{ url('../resources/js/vue.js') }}"></script>
	<script src="{{ url('../resources/js/axios.min.js') }}"></script>
	<script src="{{ url('../resources/js/import/import.js') }}"></script>
@endpush