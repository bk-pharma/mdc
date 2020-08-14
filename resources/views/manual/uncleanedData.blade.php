@extends('main')

@section('uncleanedData')
    
  
<div class="container-fluid">

    <div class="straight-bar mt-2" style="border:2px solid gray;"></div>
        <div class="row">
            <div class="col-md-6">
                <h3>MDC Manual Sanitation</h3>
                    <div class="row">
                        <label class="m-3" style="color:green;">Sanitized Rows : "COUNT" </label>
                    </div>
                    <div class="row">
                        <label class="m-3" style="color:red;">Remaining Unsanitized Rows : "COUNT" </label>
                    </div>
            </div>

            <div class="col-md-6 mt-5">
                <button class="btn btn-outline-primary float-right mt-5" id="sanitizedAll">Sanitized All Selected</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class=" table table-striped table-hover display nowrap" id="unsanitizedTable" style="width:100%;" >
                    <thead>
                        <tr>
                            <th style="white-space: nowrap;"></th>
                            <th style="white-space: nowrap;">ID</th>
                            <th style="white-space: nowrap;" >Doctor</th>
                            <th style="white-space: nowrap;" >Sanitized Name</th>
                            <th style="white-space: nowrap;">Assign to MD</th>
                            <th style="white-space: nowrap;">Class</th>
                            <th style="white-space: nowrap;">LN</th>
                            <th style="white-space: nowrap;">Location</th>
                            <th style="white-space: nowrap;">Branch Name</th>
                            <th style="white-space: nowrap;">LBA</th>
                            <th style="white-space: nowrap;">Amount</th>
                            <th style="white-space: nowrap;">Sanitized by</th>
                            <th style="white-space: nowrap;">Sanitized Date</th>
                        </tr>
                    </thead>
                    
                </table>
            </div>
        </div>
</div>

@push('uncleanedData-scripts')
	<script src="{{ url('../resources/js/vue.js') }}"></script>
	<script src="{{ url('../resources/js/axios.min.js') }}"></script>
    <script type="module" src="{{ url('../resources/js/manual/uncleanedData.js') }}"></script>
@endpush


@endsection