@extends('main')

@section('sanitationPhaseThree')

<div id="sanitationPhaseThree-container" class="container">
	<div class="row mt-2">
		<div class="col-md">
			<h3>Phase 3</h3>
		</div>
	</div>
</div>

@endsection

@push('sanitationPhaseThree-scripts')
	<script src="{{ url('../resources/js/vue.js') }}"></script>
	<script src="{{ url('../resources/js/axios.min.js') }}"></script>
    <script type="module" src="{{ url('../resources/js/sanitation/phaseThree.js') }}"></script>
@endpush