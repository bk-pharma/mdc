@extends('main')

@section('uncleanedData')
<style>
    .container-fluid{
        font-size: 13px !important;
    }
    input {
        font-size: 13px !important;
    }
    .table{
        background-color: #fff !important;
    }
    .nopadding{
        padding-top: 10px !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
        margin: 0 !important;
    }
    .nopadding select{
        font-size: 13px !important;
    }
    #sanitizedAll{
        font-weight: bold; 
        border: 2px solid;
        width: 100%;
        margin-bottom: 1 !important;
    }
    #sanitizedAll:hover{ 
        border: 2px solid !important;
    }
</style>
<div class="container-fluid">

    <div class="straight-bar mt-2" style="border:2px solid gray;"></div>
        <div class="row">
            <div class="col-md-4" style="margin-top: 10px;">
                <h3>MDC Manual Sanitation</h3>
                <div>
                    <label>Sanitized Rows : {!! number_format((float)$count[0]->Total,0) !!}</label><br>
                    <label>Remaining Unsanitized Rows : {!! number_format((float)$sanitizedTotalCount[0]->TotalCount,0) !!} </label>
                </div>
                <button class="btn btn-sm btn-outline-sucess mt-3 mb-3" id="sanitizedAll">Sanitize all selected</button>
            </div>
            <div class="col-md-8" style="border: 2px solid #000; background-color: #fff;margin-top: 10px; margin-bottom: 10px; padding: 20px 20px 20px 20px !important;">
                <label>Sanitize Selected Row(s)</label>
                <div class="row" style="margin: 5 10px 5px 10px;">
                    <div class="col-md-4">
                        <label style="font-weight: normal;">Assign to MD</label>
                        <!-- <div class="form-group form-group-sm">
                            <input type="text" name="assign_md" class="form-control" placeholder="Assign to MD">
                        </div> -->
                    </div>
                    <div class="col-md-8">
                        <label style="font-weight: normal;">Set Rule</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 table-responsive">
                <table class="table table-striped table-hover" id="unsanitizedTable">
                    <thead>
                        <tr style="background-color: #fff;">
                            <th colspan="2" class="nopadding">
                                <select name="" id="" class="form-control">
                                    <option value="">ID</option>
                                </select>
                            </th>
                            <th class="nopadding">
                                <select name="" id="" class="form-control">
                                    <option value="">Doctor</option>
                                </select>
                            </th>
                            <th class="nopadding">
                                <select name="" id="" class="form-control">
                                    <option value="">Sanitized Name</option>
                                </select>
                            </th>
                            <th class="nopadding">
                                <select name="" id="" class="form-control">
                                    <option value="">Assign to MD</option>
                                </select>
                            </th>
                            <th class="nopadding">
                                <select name="" id="" class="form-control">
                                    <option value="">Class</option>
                                </select>
                            </th>
                            <th class="nopadding">
                                <select name="" id="" class="form-control">
                                    <option value="">LN</option>
                                </select>
                            </th>
                            <th class="nopadding">
                                <select name="" id="" class="form-control">
                                    <option value="">Location</option>
                                </select>
                            </th>
                            <th class="nopadding">
                                <select name="" id="" class="form-control">
                                    <option value="">Branch Name</option>
                                </select>
                            </th>
                            <th class="nopadding">
                                <select name="" id="" class="form-control">
                                    <option value="">LBA</option>
                                </select>
                            </th>
                            <th class="nopadding">
                                <select name="" id="" class="form-control">
                                    <option value="">Row(s)</option>
                                </select>
                            </th>
                            <th style="white-space: nowrap;">
                                <select name="" id="" class="form-control">
                                    <option value="">Total Amount</option>
                                </select>
                            </th>
                            <th class="nopadding">
                                <select name="" id="" class="form-control">
                                    <option value="">Sanitized by</option>
                                </select>
                            </th>
                            <th class="nopadding">
                                <select name="" id="" class="form-control">
                                    <option value="">Sanitized Date</option>
                                </select>
                            </th>
                        </tr>
                        <tr>
                            <th style="white-space: nowrap;"></th>
                            <th style="white-space: nowrap;">ID</th>
                            <th style="white-space: nowrap;">Doctor</th>
                            <th style="white-space: nowrap;">Sanitized Name</th>
                            <th style="white-space: nowrap;">Assign to MD</th>
                            <th style="white-space: nowrap;">Class</th>
                            <th style="white-space: nowrap;">LN</th>
                            <th style="white-space: nowrap;">Location</th>
                            <th style="white-space: nowrap;">Branch Name</th>
                            <th style="white-space: nowrap;">LBA</th>
                            <th style="white-space: nowrap;">Row(s)</th>
                            <th style="white-space: nowrap;">Total Amount</th>
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