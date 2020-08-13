$(document).ready(function() {
    $('#unsanitizedTable thead tr').clone(true).appendTo( '#unsanitizedTable thead' );
    $('#unsanitizedTable thead tr:eq(1) th').each( function (i) {
        var title = $(this).text();
        $(this).html( '<input type="text" class="form-control" placeholder="Search '+title+'" />' );
 
        $( 'input', this ).on( 'keyup change', function () {
            if ( table.column(i).search() !== this.value ) {
                table
                    .column(i)
                    .search( this.value )
                    .draw();
            }
        } );
    } );

   var table = $("#unsanitizedTable").DataTable({
        stateSave: true,
        pageLength: 50,
        serverSide: true,
        ordering: false,
        processing: false,
        searching: false,
        ajax: {
            url: 'unclean/unsanitizedData',
        },
        columns: [
            /* {data : 'raw_check', className: 'raw_check' }, */
            {data : 'raw_id', className: 'raw_id' },
            {data : 'raw_doctor', className: 'raw_doctor' }, 
            {data : 'raw_corrected_name', className: 'raw_corrected_name' }, 
            {data : 'raw_status', className: 'raw_status' }, 
            {data : 'raw_license', className: 'raw_license' }, 
            {data : 'raw_amount', className: 'raw_amount' }, 
            {data : 'raw_address', className: 'raw_address' }, 
            {data : 'raw_lbucode', className: 'raw_lbucode' }
        ],
        scrollY:        "500px",
        scrollX:        "50%",
        scrollCollapse: true,
        paging:         true,
        scroller: {
            loadingIndicator: true
        },
    });

    //sanitized all
    $("#sanitizedAll").click(function(){
        alert("Button was clicked!");
      });/* 
      //check all
        $('#example-select-all').on('click', function(){
            // Check/uncheck all checkboxes in the table
            var rows = table.rows({ 'search': 'applied' }).nodes();
            $('input[type="checkbox"]', rows).prop('checked', this.checked);
        });

        
        // Handle click on checkbox to set state of "Select all" control
        $('#unsanitizedTable tbody').on('change', 'input[type="checkbox"]', function(){
            // If checkbox is not checked
            if(!this.checked){
            var el = $('#example-select-all').get(0);
            // If "Select all" control is checked and has 'indeterminate' property
            if(el && el.checked && ('indeterminate' in el)){
                // Set visual state of "Select all" control 
                // as 'indeterminate'
                el.indeterminate = true;
            }
            }
        }); */
    });