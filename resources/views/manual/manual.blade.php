@extends('main')

@section('manualSanitation')
    




@push('manualSanitation-scripts')
	<script src="{{ url('../resources/js/vue.js') }}"></script>
	<script src="{{ url('../resources/js/axios.min.js') }}"></script>
    <script type="module" src="{{ url('../resources/js/manual/manual.js') }}"></script>
@endpush

@endsection