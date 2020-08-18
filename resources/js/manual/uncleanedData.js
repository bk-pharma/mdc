$(document).ready(function() {
     $("#unsanitizedTable").DataTable({
        responsive:true,
        processing:true,
        fixedHeader: true,
        pageLength: 200,
        serverSide: true,
        searching: false,
        ordering: true,
        order: [[1, 'desc']], //removing first index to orderable
        ajax: {
            url: 'unclean/unsanitizedData',
        },
        columnDefs: [
            { "orderable": false, "targets": [0,4,11,12] }
          ],
        columns: [
            {data : 'raw_check', className: 'raw_check dt-center' },
            {data : 'raw_id', className: 'raw_id', }, 
            {data : 'raw_doctor', className: 'raw_doctor', },
            {data : 'raw_corrected_name', className: 'raw_corrected_name' }, 
            {data : 'raw_button', className: 'raw_button dt-center', id: 'assignButton'},
            {data : 'raw_status', className: 'raw_status', },
            {data : 'raw_license', className: 'raw_license', },
            {data : 'raw_address', className: 'raw_address', },
            {data : 'raw_branchname', className: 'raw_branchname', },
            {data : 'raw_lbucode', className: 'raw_lbucode', },
            {data : 'raw_amount', className: 'raw_amount', },
            {data : 'sanitized_by', className: 'sanitized_by', },
            {data : 'date_sanitized', className: 'date_sanitized', },

        ],
        scrollY:        "53vh",
        scrollX:        "100%",
        scrollCollapse: true,
        scroller: {
            loadingIndicator: true
        },
       
    });

    //sanitized all
    $("#sanitizedAll").click(function(){
        Swal.fire(' Button was clicked!');
      });
    
      //assign button
      $("#assignButton").click(function(){
        Swal.fire(' Button was clicked!');
      });
    
      //toggle color coding
      $('#unsanitizedTable tbody').on( 'click', 'tr', function () {
        $(this).toggleClass('selected');
        });

    });