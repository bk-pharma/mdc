$("#users").DataTable({
    searchable:false,
    ordering:true,
    processing: true,
    responsive:true,
    serverside:true,
    ajax: {
        url: "{{ url('/sanitation/data') }}",
    },
    columns: [
         {data : 'raw_image', className: 'raw_image' },
        {data : 'raw_check', className: 'raw_check' },
        {data : 'raw_button', className: 'raw_button dt-center'},
        {data : 'raw_id', className: 'raw_id' }, 
        {data : 'raw_doctor', className: 'raw_doctor' },
        {data : 'raw_corrected_name', className: 'raw_corrected_name' }, 
        {data : 'raw_status', className: 'raw_status' },
        {data : 'raw_license', className: 'raw_license' },
        {data : 'raw_address', className: 'raw_address' },
        {data : 'raw_branchname', className: 'raw_branchname', },
        {data : 'raw_lbucode', className: 'raw_lbucode' },
        {data : 'raw_row_count', className: 'raw_row_count' },
        {data : 'raw_total_amount', className: 'raw_total_amount' },
        {data : 'sanitized_by', className: 'sanitized_by' },
        {data : 'date_sanitized', className: 'date_sanitized' },
    ], 
    order: [1, 'desc'],
    scrollY:        "500px",
    scrollX:        "100%",
    scrollCollapse: true,
    paging:         true,
    scroller: {
        loadingIndicator: true
    },
    
});