@extends('main')

@section('unsanitizedData')
    
  
<div class="container-fluid">


    <div class="row">
        <div class="col-md-6">
            <label class="m-3">Count of sanitized data out of Max count</label>
        </div>

        <div class="col-md-6">
            <button class="btn btn-outline-primary float-right m-3" id="sanitizedAll">Sanitized All Selected Column</button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
         <h1 class="text-center">Data Sanitation</h1>
            <table class=" table table-striped table-hover table-bordered display nowrap" id="unsanitizedTable" style="width:100%;" >
                <thead>
                    <tr>
                        <th><input name="select_all" value="1" id="example-select-all" type="checkbox" />Check All</th>
                        <th>ID</th>
                        <th>Doctor</th>
                        <th>Correct Name</th>
                        <th>Status</th>
                        <th>License</th>
                        <th>Amount</th>
                        <th>Address</th>
                        <th>LBU Code</th>
                    </tr>
                </thead>
                
            </table>
        </div>
    </div>
</div>

@push('unsanitizedData-scripts')
	<script src="{{ url('../resources/js/vue.js') }}"></script>
	<script src="{{ url('../resources/js/axios.min.js') }}"></script>
    <script type="module" src="{{ url('../resources/js/manual/unsanitizedData.js') }}"></script>
@endpush


@endsection