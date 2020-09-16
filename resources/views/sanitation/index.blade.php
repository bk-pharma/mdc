@extends('layouts.master')

@section('title', 'Manual Sanitation')

@section('content')
<style>
    .labelText {
        font-size:20px;
    }
</style>
<div class="content-wrapper ml-5" id="sanitation-container">
<div class="col-md-12" style="padding-left:50px;"> 
    <div class="row mt-2">
        <div class="col-md">
            <h3 class="text-center labelText"></h3>
        </div>
    </div>

    <div class="col-md-12">
        <div class="row mt-3">
            <div class="col-md-6">
                <h5 class="labelText" id="sanitationStatus">@{{ sanitationStatus }}</h5>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md text-left">
                <label class="labelText">Raw Data</label>
                <input type="text" id="inititalRowCount" v-model="rowCount" :disabled="rowCountField">

                <button type="button" id="startBtn" @click="sanitationProcess()" class="btn btn-sm btn-success labelText" :disabled="sanitationBtn">
                    <i class="fa fa-play"></i> Start
                </button>

                <h6 class="mt-3 labelText">
                    Total Sanitized:
                    <span id="totalSanitized" class="labelText">
                        @{{ totalSanitizedRow | numberFormat }}
                        <span id="totalSanitizedPercentage" style="color:#0000ff;">
                            @{{ percentageSanitizedRow | decimalFormat }}%
                        </span>
                    </span>
                </h6>
                <h6 class="mt-1 labelText">
                    Total Amount: <span id="totalAmount">₱ @{{ totalSanitizedAmount | numberFormat }}</span>
                </h6>
                <h6 class="mt-1 labelText">
                    Total Unsanitized: <span id="totalUnsanitized">@{{ totalUnsanitizedRow | numberFormat }}</span>
                </h6>
                <h6 class="mt-1 labelText">
                    Run time: <span id="runTime">@{{ runTime }}</span>
                </h6>
                <h6 class="mt-1 labelText">
                    Run: <span id="run">@{{ totalRun }}</span>
                </h6>
            </div>
        </div>
	</div>
    </div>
</div>

@endsection

@push('sanitation-scripts')
	<script src="{{ url('../resources/js/vue.js') }}"></script>
	<script src="{{ url('../resources/js/axios.min.js') }}"></script>
    <script type="module" src="{{ url('../resources/js/sanitation/sanitation.js') }}"></script>
@endpush