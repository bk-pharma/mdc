@extends('layouts.master')

@section('title', 'Manual Sanitation')

@section('header_scripts')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<!-- <link rel="stylesheet" href="{{asset('css/dataTables.bootstrap.min.css')}}"> -->
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
<link rel="stylesheet" href="{{asset('css/bootstrap-multiselect.css')}}">
<link rel="stylesheet" href="{{asset('css/bootstrap-theme.css')}}">
<link rel="stylesheet" href="https://cdn.datatables.net/scroller/2.0.2/css/scroller.dataTables.min.css">
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
	
<style>
   .content-wrapper{
        font-size: 13px !important;
        padding-right: 10px !important;
        padding-left: 10px !important;
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
    .dataTables_wrapper .dataTables_filter {
        display: none;
    }
    .multiselect-container{
        height:48vh;
        min-width:100%;            
        overflow-y:scroll;
        overflow-x: hidden;
    }
    .input-group .form-control, .input-group-addon, .input-group-btn {
        display: table-cell;
        min-width: max-content;
    } /* to prevent scrolling and to maximize the size of search to be seen */
    .dataTables_scrollHead{
        overflow: unset !important; /* multifilter to be shown ( to prevent overlapping) */
    }
    table.dataTable td {
        padding: 0, 0, 2px, 0 !important;
        margin: 0 !important;
    }
</style>
@stop

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" id="app">
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-4">
                <h3>MDC Manual Sanitation</h3>
                <label>Sanitized Rows : <span style="color:green;" id="count_realtime_sanit_row">{{ number_format($sanitizeRow) }}</span></label>
                <div></div>
                <label>Remaining Unsanitized Rows : <span style="color:red;" id="count_realtime_unsanit_row"> {{ number_format($unsanitizeRow) }}</span></label>
                <div></div>
                <button class="btn btn-success mt-3 mb-3" id="sanitizedAll">Sanitize all selected</button>
                <button class="btn btn-danger mt-3 mb-3" id="mark_all_as_unidentified"><span id="mark_all_as_unidentified_text">Mark All as Unidentified</span></button>
            </div>
                <span id="sanitize_selected_append"></span>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12"> 
            <span class="loader"></span>
            <table  class="table table-striped table-bordered table-hover cell-border compact" id="users" style="font-size: 10px !important;">
                <thead style="font-size:11px!important; margin:0 !important; padding:0 !important;">
                    <tr>
                        <th></th>
                        <th></th>
                        <th><select id="users-quick-filter-2" multiple class="form-control filter-all get_selected_after_filter" size="5"  data-enable-filtering="true" data-button-class="btn btn-sm btn-default" data-placeholder="ID" style="display:none"></select></th>
                        <th><select id="users-quick-filter-3" multiple class="form-control filter-all get_selected_after_filter" size="5" data-enable-filtering="true" data-button-class="btn btn-sm btn-default" data-placeholder="Raw MD Name" style="display:none"></select></th>
                        <th></th>
                        <th><select id="users-quick-filter-5" multiple class="form-control filter-all get_selected_after_filter" size="5" data-enable-filtering="true" data-button-class="btn btn-sm btn-default" data-placeholder="Class" style="display:none"></select></th>
                        <th><select id="users-quick-filter-6" multiple class="form-control filter-all get_selected_after_filter" size="5" data-enable-filtering="true" data-button-class="btn btn-sm btn-default" data-placeholder="License #" style="display:none"></select></th>
                        <th><select id="users-quick-filter-7" multiple class="form-control filter-all get_selected_after_filter" size="5" data-enable-filtering="true" data-button-class="btn btn-sm btn-default" data-placeholder="Location" style="display:none"></select></th>
                        <th><select id="users-quick-filter-8" multiple class="form-control filter-all get_selected_after_filter" size="5" data-enable-filtering="true" data-button-class="btn btn-sm btn-default" data-placeholder="Branch Name" style="display:none"></select></th>
                        <th><select id="users-quick-filter-9" multiple class="form-control filter-all get_selected_after_filter" size="5" data-enable-filtering="true" data-button-class="btn btn-sm btn-default" data-placeholder="LBA Code" style="display:none"></select></th>
                        <th><select id="users-quick-filter-10" multiple class="form-control filter-all get_selected_after_filter" size="5" data-enable-filtering="true" data-button-class="btn btn-sm btn-default" data-placeholder="Row(s)" style="display:none"></select></th>
                        <th><select id="users-quick-filter-11" multiple class="form-control filter-all get_selected_after_filter" size="5" data-enable-filtering="true" data-button-class="btn btn-sm btn-default" data-placeholder="Total Amount" style="display:none"></select></th>
                        <th><select id="users-quick-filter-12" multiple class="form-control filter-all get_selected_after_filter" size="5" data-enable-filtering="true" data-button-class="btn btn-sm btn-default" data-placeholder="Sanitized by" style="display:none"></select></th>
                        <th><select id="users-quick-filter-13" multiple class="form-control filter-all get_selected_after_filter" size="5" data-enable-filtering="true" data-button-class="btn btn-sm btn-default" data-placeholder="Sanitized Date" style="display:none"></select></th>
                    </tr>
                    <tr>
                        <th>
                        <input type="checkbox" name="checked-all" id="all-checkbox">
                        </th>
                        <th style="border-right: none;"></th>
                        <th>ID</th>
                        <th>Raw MD Name</th>
                        <th>Assigned MD</th>
                        <th>Class</th>
                        <th>License #</th>
                        <th>Location</th>
                        <th>Branch Name</th>
                        <th>LBA Code</th>
                        <th>Row(s)</th>
                        <th>Total Amount</th>
                        <th>Sanitized by</th>
                        <th>Sanitized Date</th>
                    </tr>
                </thead>
            </table>
            <tbody ">

            </tbody>
        </div>
    </div>
@endsection

@section('footer_scripts')
<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="{{asset('js/dataTables.multiselect.js')}}"></script> 
<script src="{{asset('js/bootstrap-multiselect.js')}}"></script>
<script src="https://cdn.datatables.net/scroller/2.0.2/js/dataTables.scroller.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    
    var auth_id = '{{ $user->auth_id }}';
    Pusher.logToConsole = true;
    var pusher = new Pusher('c1d970f3cc7e67cb819c', {
        cluster: 'ap1',
        forceTLS: true
    });
    var channel = pusher.subscribe('sanitation');
    channel.bind('pusher:subscription_succeeded', function() {
        console.log('subscribe')
    });
    //devolepment-jhay
    channel.bind('realtime', function(data) {
        
        if(data.checked == 'MarkUnidentified'){

            var key = parseInt(data.doneToUnidentified.length) - parseInt(1);
            var nf = new Intl.NumberFormat();

            var user_role = '{{ Auth::user()->auth_role }}';

            for(var x = 0; x <= key; x++){
                
                $('#trRow-'+data.doneToUnidentified[x].raw_id).removeAttr("style");
                
                if(data.doneToUnidentified[x].raw_status != ''){

                    if(user_role == "TEAM LEADER" || user_role == "ADMIN"){
                        
                        var disabledCheckbox = false;

                        $('.selected-'+data.doneToUnidentified[x].raw_id).css({
                            'cursor': 'pointer',
                            'pointer-events': 'auto',
                        });

                    }else{

                        var disabledCheckbox = true;

                        $('.selected-'+data.doneToUnidentified[x].raw_id).css({
                            'cursor': 'not-allowed',
                            'pointer-events': 'none',
                        });
                    }

                }

                $('.sanitize-btn-'+data.doneToUnidentified[x].raw_id).prop('disabled', false);

                $('#count_realtime_sanit_row').text(nf.format(data.sanitizeRow));
                $('#count_realtime_unsanit_row').text(nf.format(data.unsanitizeRow));

                $('.checkbox-'+data.doneToUnidentified[x].raw_id).prop('checked', false);

                $('.checkbox-'+data.doneToUnidentified[x].raw_id).prop('disabled', disabledCheckbox);

                $('.checkbox-'+data.doneToUnidentified[x].raw_id).val('');
                $('.checkbox-'+data.doneToUnidentified[x].raw_id).removeClass().addClass(' checkbox-'+data.doneToUnidentified[x].raw_id);
                $('.checkbox-'+data.doneToUnidentified[x].raw_id).addClass(' not-selected');
                $("#row-"+data.doneToUnidentified[x].raw_id+" svg").remove();

                $('.sanitize_assign_md_'+data.doneToUnidentified[x].raw_id).html('<span class="pull-left">'+data.doneToUnidentified[x].raw_corrected_name+'</span><a href="#" class="pull-right" id="editButton"> <i class="nav-icon fas fa-edit"></i></a>');
                $('#trRow-'+data.doneToUnidentified[x].raw_id+' .raw_status').text(data.doneToUnidentified[x].raw_status);
                $('#trRow-'+data.doneToUnidentified[x].raw_id+' .sanitized_by').text(data.doneToUnidentified[x].sanitized_by);
                $('#trRow-'+data.doneToUnidentified[x].raw_id+' .date_sanitized').text(new Date(data.doneToUnidentified[x].date_sanitized).toDateString().split(' ').slice(1).join(' '));

            }
        }

        if(data.checked == 'MarkAsSanitized'){

            var key = parseInt(data.doneToSanitized.length) - parseInt(1);
            var nf = new Intl.NumberFormat();

            var user_role = '{{ Auth::user()->auth_role }}';

            for(var x = 0; x <= key; x++){
                
                $('#trRow-'+data.doneToSanitized[x].raw_id).removeAttr("style");
                
                if(data.doneToSanitized[x].raw_status != ''){

                    if(user_role == "TEAM LEADER" || user_role == "ADMIN"){
                        
                        var disabledCheckbox = false;

                        $('.selected-'+data.doneToSanitized[x].raw_id).css({
                            'cursor': 'pointer',
                            'pointer-events': 'auto',
                        });

                    }else{

                        var disabledCheckbox = true;

                        $('.selected-'+data.doneToSanitized[x].raw_id).css({
                            'cursor': 'not-allowed',
                            'pointer-events': 'none',
                        });
                    }

                }else{

                    $('.selected-'+data.doneToSanitized[x].raw_id).css({
                        'cursor': 'pointer',
                        'pointer-events': 'auto',
                    });
                }

                $('.sanitize-btn-'+data.doneToSanitized[x].raw_id).prop('disabled', false);

                $('#count_realtime_sanit_row').text(nf.format(data.sanitizeRow));
                $('#count_realtime_unsanit_row').text(nf.format(data.unsanitizeRow));

                $('.checkbox-'+data.doneToSanitized[x].raw_id).prop('checked', false);

                $('.checkbox-'+data.doneToSanitized[x].raw_id).prop('disabled', disabledCheckbox);

                $('.checkbox-'+data.doneToSanitized[x].raw_id).val('');
                $('.checkbox-'+data.doneToSanitized[x].raw_id).removeClass().addClass(' checkbox-'+data.doneToSanitized[x].raw_id);
                $('.checkbox-'+data.doneToSanitized[x].raw_id).addClass(' not-selected');
                $("#row-"+data.doneToSanitized[x].raw_id+" svg").remove();


                $('.sanitize_assign_md_'+data.doneToSanitized[x].raw_id).html('<span class="pull-left">'+data.doneToSanitized[x].raw_corrected_name+'</span><a href="#" class="pull-right" id="editButton"> <i class="nav-icon fas fa-edit"></i></a>');
                $('#trRow-'+data.doneToSanitized[x].raw_id+' .raw_status').text(data.doneToSanitized[x].raw_status);
                $('#trRow-'+data.doneToSanitized[x].raw_id+' .sanitized_by').text(data.doneToSanitized[x].sanitized_by);
                $('#trRow-'+data.doneToSanitized[x].raw_id+' .date_sanitized').text(new Date(data.doneToSanitized[x].date_sanitized).toDateString().split(' ').slice(1).join(' '));

            }
            }
        if(data.checked == 'filter'){
            
            var raw_ids = $('input[name="sanitize[]"]').map(function () {
                        return $(this).data('id')
                }).get();
            
            var xkey = parseInt(raw_ids.length) - parseInt(1);

            for(var x = 0; x <= xkey; x++){

                $('#trRow-'+raw_ids[x]).removeAttr("style");
                $('.sanitize-btn-'+raw_ids[x]).prop('disabled', false);

                $('.checkbox-'+raw_ids[x]).prop('checked', false);
                $('.checkbox-'+raw_ids[x]).val('');
                $('.checkbox-'+raw_ids[x]).removeClass().addClass(' checkbox-'+raw_ids[x]);
                $('.checkbox-'+raw_ids[x]).addClass(' not-selected');
                $("#row-"+raw_ids[x]+" svg").remove();

            }

            var user_auth_id = '{{ Auth::user()->auth_id }}';

        
            var key = parseInt(data.selected.length) - parseInt(1);

            if(data.selected.length > 0){

                for(var i = 0; i <= key; i++){

                    if(user_auth_id == data.selected[i].user_id){
                        var opacity = 0.8;
                    }else{
                        var opacity = 0.5;
                    }

                    if(data.selected[i].user_id == user_auth_id){
                        var pointer = 'pointer';
                        var events = 'auto';
                    }else{
                        var pointer = 'not-allowed';
                        var events = 'none';
                    }

                    
                    $('.checkbox-'+data.selected[i].sanitation_id).removeClass(' not-selected');
                    $('.checkbox-'+data.selected[i].sanitation_id).prop('checked', true);
                    $('.checkbox-'+data.selected[i].sanitation_id).val(data.selected[i].sanitation_id);
                    $('#trRow-'+data.selected[i].sanitation_id).css('color', '#000');
                    $('#trRow-'+data.selected[i].sanitation_id).addClass(' selected-'+data.selected[i].sanitation_id);
                    $('.checkbox-'+data.selected[i].sanitation_id).addClass(' selected');
                    $('.checkbox-'+data.selected[i].sanitation_id).addClass(' selected-check-'+data.selected[i].user_id);
                    $("#row-"+data.selected[i].sanitation_id).html(data.avatar[i]);
                    
                    $('.selected-'+data.selected[i].sanitation_id).css({
                        'background-color': data.selected[i].user.tag_color,
                        'opacity': opacity,
                        'cursor': pointer,
                        'pointer-events': events,
                    });
                    
                }
            }

        }

        if(data.checked == 'checkall'){
            
            if(data.raw_ids.length >= 500){

                var  auth_user_id = '{{ Auth::user()->auth_id }}';

                if(auth_user_id == data.user_id){
                    var name = '';
                }else{
                    var name = data.name;
                }
                $('.loader').show();
                $('.loader').html('<span style="font-size: 30px;"><b><center><i class="fa fa-spinner fa-spin"></i> '+name+' Checking a huge amount rows</center><b></span>');
            
            }

            setTimeout(function(){

                if(data.checkrows == 'true'){

                    var  user_auth_id = '{{ Auth::user()->auth_id }}';

                    var raw_ids = data.raw_ids;

                    if(user_auth_id == data.user_id){
                        var opacity = 0.8;
                    }else{
                        var opacity = 0.5;
                    }

                    if(data.user_id == auth_id){
                        var pointer = 'pointer';
                        var events = 'auto';
                    }else{
                        var pointer = 'not-allowed';
                        var events = 'none';
                    }

                    var key = parseInt(data.raw_ids.length) - parseInt(1);

                    // 1ST BATCH
                  
                    for(var i = 0; i <= key; i++){

                        $('.checkbox-'+raw_ids[i]).removeClass(' not-selected');
                        $('.checkbox-'+raw_ids[i]).prop('checked', true);
                        $('.checkbox-'+raw_ids[i]).val(raw_ids[i]);
                        $('#trRow-'+raw_ids[i]).css('color', '#000');
                        $('#trRow-'+raw_ids[i]).addClass(' selected-'+raw_ids[i]);
                        $('.selected-'+raw_ids[i]).css({
                            'background-color': data.color,
                            'opacity': opacity,
                            'cursor': pointer,
                            'pointer-events': events,
                        });
                        $('.checkbox-'+raw_ids[i]).addClass(' selected');
                        $('.checkbox-'+raw_ids[i]).addClass(' selected-check-'+data.user_id);
                        $("#row-"+raw_ids[i]).html(data.avatar);
                    }
                    
                }
                if(data.checkrows == 'false'){
                    
                    var raw_ids = data.raw_ids;

                    var key = parseInt(raw_ids.length) - parseInt(1);

                    for(var i=0; i <= key; i++){

                        $('.sanitize-btn-'+raw_ids[i]).prop('disabled', false);
                        $('.checkbox-'+raw_ids[i]).addClass(' not-selected');
                        $('.checkbox-'+raw_ids[i]).prop('checked', false);
                        $('.checkbox-'+raw_ids[i]).val('');
                        $('.selected-'+raw_ids[i]).css({
                            'cursor': 'pointer',
                            'pointer-events': 'auto',
                        });
                        $('#trRow-'+raw_ids[i]).removeAttr("style");
                        $('.checkbox-'+raw_ids[i]).removeClass(' selected');
                        $('.checkbox-'+raw_ids[i]).removeClass(' selected-check-'+data.user_id);
                        $("#row-"+raw_ids[i]+" svg").remove();
                    }
                }

                $('.loader').hide();

            }, 1000);

                    

        }

        if(data.checked == 'unchecked'){
            $('.sanitize-btn-'+data.raw_id).prop('disabled', false);
            $('.checkbox-'+data.raw_id).addClass(' not-selected');
            $('.checkbox-'+data.raw_id).prop('checked', false);
            $('.checkbox-'+data.raw_id).val('');
            $('.selected-'+data.raw_id).css({
                'cursor': 'pointer',
                'pointer-events': 'auto',
            });
            $('#trRow-'+data.raw_id).removeAttr("style");
            $('.checkbox-'+data.raw_id).removeClass(' selected');
            $('.checkbox-'+data.raw_id).removeClass(' selected-check-'+data.user_id);
            $("#row-"+data.raw_id+" svg").remove();
        }

        if(data.checked == 'checked'){
            var  user_auth_id = '{{ Auth::user()->auth_id }}';

            if(user_auth_id == data.user_id){
                var opacity = 0.8;
            }else{
                var opacity = 0.5;
            }
            
            if(data.user_id == auth_id){
                var pointer = 'pointer';
                var events = 'auto';
            }else{
                var pointer = 'not-allowed';
                var events = 'none';
            }

            $('#trRow-'+data.raw_id).removeAttr("style");
            $('.checkbox-'+data.raw_id).removeClass(' not-selected');
            $('.checkbox-'+data.raw_id).prop('checked', true);
            $('.checkbox-'+data.raw_id).val(data.raw_id);
            $('#trRow-'+data.raw_id).css('color', '#000');
            $('#trRow-'+data.raw_id).addClass(' selected-'+data.raw_id);
            $('.selected-'+data.raw_id).css({
                'background-color': data.color,
                'opacity': opacity,
                'cursor': pointer,
                'pointer-events': events,
            });
            $('.checkbox-'+data.raw_id).addClass(' selected');
            $('.checkbox-'+data.raw_id).addClass(' selected-check-'+data.user_id);
            $("#row-"+data.raw_id).html(data.avatar);
        }
    });
    $(".filter-all").multiselect({
        includeSelectAllOption: true,
        selectAllText: 'Select All / Unselect All',
    });
    $("#users").DataTable({
        searchable:false,
        ordering:true,
        processing: true,
        responsive:true,
        serverside:true,
        fixedHeader:true,
        paging:false,
        info:false,
        /* "dom": '<"top"i>rt', */ //i - Information r-pRocessing t-Table = TOP:Info, processing and Table
        ajax: {
            url: "{{ url('/sanitation/data') }}",
        },
        columns: [
            {data : 'raw_check', className: 'raw_check', },
            {data : 'raw_image', className: 'raw_image',},
            {data : 'raw_id', className: 'raw_id',}, 
            {data : 'raw_doctor', className: 'raw_doctor' },
            {data : 'raw_button', className: 'raw_button dt-center'},
           /*  {data : 'raw_corrected_name', className: 'raw_corrected_name' }, */ 
            {data : 'raw_status', className: 'raw_status' },
            {data : 'raw_license', className: 'raw_license' },
            {data : 'raw_address', className: 'raw_address' },
            {data : 'raw_branchname', className: 'raw_branchname', },
            {data : 'raw_lbucode', className: 'raw_lbucode' },
            {data : 'raw_row_count', className: 'raw_row_count' },
            {data : 'raw_total_amount',  render: $.fn.dataTable.render.number( ',', '.', 0, '₱' ), className: 'raw_total_amount' },
            {data : 'sanitized_by', className: 'sanitized_by' },
            {data : 'date_sanitized', className: 'date_sanitized' },
        ], 
        order: [[10, 'desc']],
        columnDefs: [ { 
            orderable: false,
             targets: [0,1,4],
             },
        ],
        scrollX:false,
        scrollY:"70vh",
        /* scrollCollapse: true,
        scroller: {
            loadingIndicator: true
        }, */
    });
       

    // $("#users").DataTable({
    //     pageLength: 200,
    //     serverSide: true,
    //     ordering: false,
    //     processing: false,
    //     searching: false,
    //     ajax: {
    //         url: "{{ url('/sanitation/data') }}",
    //     },
    //     columns: [
    //         {data : 'raw_image', className: 'raw_image' },
    //         {data : 'raw_check', className: 'raw_check' },
    //         {data : 'raw_id', className: 'raw_id' }, 
    //         {data : 'raw_doctor', className: 'raw_doctor' },
    //         {data : 'raw_corrected_name', className: 'raw_corrected_name' }, 
    //         {data : 'raw_button', className: 'raw_button dt-center'},
    //         {data : 'raw_status', className: 'raw_status' },
    //         {data : 'raw_license', className: 'raw_license' },
    //         {data : 'raw_address', className: 'raw_address' },
    //         {data : 'raw_branchname', className: 'raw_branchname', },
    //         {data : 'raw_lbucode', className: 'raw_lbucode' },
    //         {data : 'raw_row_count', className: 'raw_row_count' },
    //         {data : 'raw_total_amount', className: 'raw_total_amount' },
    //         /* {data : 'raw_amount', className: 'raw_amount', }, */
    //         {data : 'sanitized_by', className: 'sanitized_by' },
    //         {data : 'date_sanitized', className: 'date_sanitized' },

    //     ],
    //     order: [1, 'desc'],
    //     scrollY:        "500px",
    //     scrollX:        "100%",
    //     scrollCollapse: true,
    //     paging:         true,
    //     scroller: {
    //         loadingIndicator: true
    //     },
    // });

    $('#users').on('click', 'tbody tr', function (e) {
        e.preventDefault();

        var is_sanitize = $('.checkbox-'+raw_id).data('id');

       

        // var channel = pusher.subscribe('private-sanitation');
        var $row = jQuery(this).closest("tr");
        var raw_id = $row.find("#select-sanitize").attr('data-id');
        var tr = $(this);
        var user_id = '{{ $user->auth_id }}';
        $('.checkbox-'+raw_id).prop('checked', true);
       
        $.ajax({
            url: '{{ route("manual.sanitation") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                raw_id: raw_id,
                checked: $('.checkbox-'+raw_id).is(":checked")
            },
            success:function(response){
                console.log(response.status);

                if(response.checked == 'exists'){
                    $('.checkbox-'+raw_id).prop('checked', false);

                    iziToast.warning({
                        title: 'Warning',
                        message: 'This row has been selected by DM '+response.dm_name,
                        position: 'topRight',
                    });
                }
        
            },
            error: function (response) {
                console.log(response);
            }
        });
    });

    $('#users').on('click', '#select-sanitize', function (e) {
        e.stopPropagation();
        var raw_id = $(this).attr('data-id');
        var tr = jQuery(this).closest("tr");
        var user_id = '{{ $user->auth_id }}';
       
        $.ajax({
            url: '{{ route("manual.sanitation") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                raw_id: raw_id,
                checked: $('.checkbox-'+raw_id).is(":checked")
            },
            success:function(response){
                console.log(response.status);
                                        
                if(response.checked == 'exists'){
                    $('.checkbox-'+raw_id).prop('checked', false);

                    iziToast.warning({
                        title: 'Warning',
                        message: 'This row has been selected by DM '+response.dm_name,
                        position: 'topRight',
                    });
                }
        
            },
            error: function (response) {
                console.log(response);
            }
        });
    });


    $('#all-checkbox').on('change', function (e) {

        if(this.checked == true){

            var raw_ids = $('.not-selected').map(function () {
                        return $(this).data('id')
                }).get();
        }

        if(this.checked == false){
            var auth_id = '{{ Auth::user()->auth_id }}';

            var raw_ids = $('.selected-check-'+auth_id).map(function(i, e) {
                return $(this).data('id')
            }).get();

        }
        
        if(raw_ids.length > 1000){

            $('#all-checkbox').prop('checked', false);

            iziToast.warning({
                title: 'Warning',
                message: 'Cannot select more than 1000 rows',
                position: 'topRight',
            });

        }else{

            if(raw_ids.length >= 500){
                
                $('.loader').show();
                $('.loader').html('<span style="font-size: 30px;"><b><center><i class="fa fa-spinner fa-spin"></i> Checking a huge amount rows</center><b></span>');
            
            }

            var formData = new FormData();
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('checked', this.checked);
                formData.append('raw_ids', raw_ids);
            
            $.ajax({
                url: '{{ route("check.all.rows") }}',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success:function(response){
                    console.log(response.status);
                },
                error: function (response) {
                    console.log(response);
                }
            });
        }
    });

});

$("#sanitizedAll").click(function(e){
    e.preventDefault();

    var auth_id = '{{ Auth::user()->auth_id }}';
    var arrayRawIds = $('.selected-check-'+auth_id).map(function(i, e) {return e.value});

    if (typeof arrayRawIds != "undefined"  && arrayRawIds != null && arrayRawIds.length != null && arrayRawIds.length > 0){

        $('#sanitize_selected_append').html('<br/><br/><br/><br/><span style="font-size: 20px;"><center><b><i class="fa fa-spinner fa-spin"></i> Loading...<b></center></span>');

        var formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('raw_ids', arrayRawIds.toArray());

        $.ajax({
            url: '{{ route("set.rules.sanitize") }}',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false, 
            success:function(response){

                setTimeout(function(){ 
                    $('#sanitize_selected_append').html(response.responseHtml);
                }, 3000);
            },
            error: function (response) {
                console.log(response);
            }
        });

    }else{ 
        
        iziToast.warning({
            title: 'Warning',
            message: 'No selected row(s)',
            position: 'topRight',
        });
    }

});

$("#mark_all_as_unidentified").click(function(e){
    e.preventDefault();

    var auth_id = '{{ Auth::user()->auth_id }}';
    var arrayRawIds = $('.selected-check-'+auth_id).map(function(i, e) {return e.value});

    if (typeof arrayRawIds != "undefined"  && arrayRawIds != null && arrayRawIds.length != null && arrayRawIds.length > 0){

    $('#mark_all_as_unidentified_text').html('Mark All as Unidentified <i class="fa fa-spinner fa-spin"></i>');

        var formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('raw_ids', arrayRawIds.toArray());

        $.ajax({
            url: '{{ url("/mark/all/as/unidentifed") }}',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false, 
            success:function(response){

                $('#mark_all_as_unidentified_text').html('Mark All as Unidentified');

            },
            error: function (response) {
                console.log(response);
            }
        });

    }else{ 

        iziToast.warning({
            title: 'Warning',
            message: 'No selected row(s)',
            position: 'topRight',
        });
    }
});

$('.get_selected_after_filter').change(function(e){
    
    

    $.ajax({
        url: '{{ url("get/selected") }}',
        type: 'GET',
        success:function(response){
            
            

        },
        error: function (response) {
            console.log(response);
        }
    });
});

function sanitizeOne(raw_id){
  
    $('.sanitize-btn-'+raw_id).prop('disabled', true);
    $('#sanitize_selected_append').html('<br/><br/><br/><br/><span style="font-size: 20px;"><center><b><i class="fa fa-spinner fa-spin"></i> Loading...<b></center></span>')

    $.ajax({
        url: '{{ route("set.rules.sanitize.one") }}',
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            raw_id: raw_id
        },
        success:function(response){
            setTimeout(function(){ 
                $('#sanitize_selected_append').html(response.responseHtml);
            }, 3000);
        },
        error: function (response) {
            console.log(response);
        }
    });
}
</script>
@stop