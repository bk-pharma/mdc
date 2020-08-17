@extends('main')

@section('uncleanedData')
    
  
<div class="container-fluid">

    <div class="straight-bar mt-2" style="border:2px solid gray;"></div>
        <div class="row">
            <div class="col-md-12">
                <h3>MDC Manual Sanitation</h3>
                    <div>
                        <label style="color:green;">Sanitized Rows : {!! number_format((float)$count[0]->Total,0) !!}</label>
                        <div></div>
                        <label style="color:red;">Remaining Unsanitized Rows : {!! number_format((float)$sanitizedTotalCount[0]->TotalCount,0) !!} </label>
                    </div>
            </div>
            <div class="col-md-12">
                <button class="btn btn-outline-primary mt-3 mb-3" id="sanitizedAll">Sanitize All Selected</button>
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
                       <tr>
                            <th style="white-space: nowrap;">
                                
                            </th>
                            <th style="white-space: nowrap; width:4.5%;">
                                <select name="" id="" class="form-control">
                                    <option value="">ID</option>
                                </select>
                            </th>
                            <th style="white-space: nowrap;" >
                                <select name="" id="" class="form-control">
                                    <option value="">Doctor</option>
                                </select>
                            </th>
                            <th style="white-space: nowrap;" >
                                <select name="" id="" class="form-control">
                                    <option value="">Sanitized Name</option>
                                </select>
                            </th>
                            <th style="white-space: nowrap;">
                                <select name="" id="" class="form-control">
                                    <option value="">Assign to MD</option>
                                </select>
                            </th>
                            <th style="white-space: nowrap;">
                                <select name="" id="" class="form-control">
                                    <option value="">Class</option>
                                </select>
                            </th>
                            <th style="white-space: nowrap;">
                                <select name="" id="" class="form-control">
                                    <option value="">LN</option>
                                </select>
                            </th>
                            <th style="white-space: nowrap;">
                                <select name="" id="" class="form-control">
                                    <option value="">Location</option>
                                </select>
                            </th>
                            <th style="white-space: nowrap;">
                                <select name="" id="" class="form-control">
                                    <option value="">Branch Name</option>
                                </select>
                            </th>
                            <th style="white-space: nowrap;">
                                <select name="" id="" class="form-control">
                                    <option value="">LBA</option>
                                </select>
                            </th>
                            <th style="white-space: nowrap;">
                                <select name="" id="" class="form-control">
                                    <option value="">Amount</option>
                                </select>
                            </th>
                            <th style="white-space: nowrap;">
                                <select name="" id="" class="form-control">
                                    <option value="">Sanitized by</option>
                                </select>
                            </th>
                            <th style="white-space: nowrap;">
                                <select name="" id="" class="form-control">
                                    <option value="">Sanitized Date</option>
                                </select>
                            </th>
                          
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