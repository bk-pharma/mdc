@extends('main')

@section('sanitationPhaseTwo')

<div id="sanitationPhaseTwo-container" class="container">
	<div class="row mt-2">
		<div class="col-md">
			<h3>Phase 2</h3>
		</div>
	</div>
</div>

@endsection

@push('sanitationPhaseTwo-scripts')
	<script src="{{ url('../resources/js/vue.js') }}"></script>
	<script src="{{ url('../resources/js/axios.min.js') }}"></script>
    <script type="module" src="{{ url('../resources/js/sanitation/phaseTwo.js') }}"></script>
@endpush