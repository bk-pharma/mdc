@extends('main')

@section('sanitationPhaseFour')

<div id="sanitationPhaseFour-container" class="container">
	<div class="row mt-2">
		<div class="col-md">
			<h3>Phase 4</h3>
		</div>
	</div>
</div>

@endsection

@push('sanitationPhaseFour-scripts')
	<script src="{{ url('../resources/js/vue.js') }}"></script>
	<script src="{{ url('../resources/js/axios.min.js') }}"></script>
    <script type="module" src="{{ url('../resources/js/sanitation/phaseFour.js') }}"></script>
@endpush