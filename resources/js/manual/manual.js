$(document).ready(function() {
    // Setup - add a text input to each footer cell
    /* var limitHolder =0; */
    $('#unsanitizedTable thead tr').clone(true).appendTo( '#unsanitizedTable thead' );
    $('#unsanitizedTable thead tr:eq(1) th').each( function (i) {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
 
        $( 'input', this ).on( 'keyup change', function () {
            if ( unsanitizedTable.column(i).search() !== this.value ) {
                unsanitizedTable
                    .column(i)
                    .search( this.value )
                    .draw();
            }
        } );
    } );
     var unsanitizedTable = $('#unsanitizedTable').DataTable({
        orderCellsTop: true,
        fixedHeader: true,
        responsive:true,
    	processing:true,
        serverside:true,
        scrollY: '45vh',
        scrollX: true,
        autoWidth: true,
        filter:false,
       /*  scroller:true, */
        deferRender:true,
        paging:false,
        ajax:{
    		type: 'GET',
    		url: 'manual/unsanitizedData',
    		dataType: 'json',
            dataSrc: '',
              /*   data: {
                    limit: 200,
                    offset: 0,
                }, */
               
        },
        columns : [
            {data : 'raw_id' },
            {data : 'raw_doctor' }, 
            {data : 'raw_corrected_name' }, 
            {data : 'raw_status' }, 
            {data : 'raw_license' }, 
            {data : 'raw_amount' }, 
            {data : 'raw_address' }, 
            {data : 'raw_lbucode' }, 
        ],
        /* success: function(data){
            $('#unsanitizedTable tbody').append(data);
            limitHolder += 500;
        }, */
       
    });

    $('#unsanitizedTable tbody').on( 'click', 'tr', function () {
        $(this).toggleClass('selected');
    });


$("#selectColShowHide").selectpicker('val', [0,1,2,3,4,5,6,7])
  $(function () {
    $("#selectColShowHide").on("changed.bs.select", function(e, clickedIndex, newValue, oldValue) {
      var val = $(this).find('option').eq(clickedIndex).val();
      var table = $('#unsanitizedTable').DataTable();
      var column = table.column( val );
      column.visible( ! column.visible() );
    });
  });

/* 
Doctor list auto complete
*/

  
 $('#unidentifiedDoctorModal').on('hidden.bs.modal', function () {
    $('#unidentifiedTable').dataTable().fnDestroy();
});

$("#unidentifiedBtn").click(function (e){
  e.preventDefault();

  var table = $('#unsanitizedTable').DataTable();
  var table_data = table.rows( '.selected' ).data();

  if(table_data.length > 0){
     $('#unidentifiedDoctorModal').modal('show');
    setTimeout(function(){
      $('#unidentifiedTable').DataTable( {
          data: table_data,
          scrollY: "45vh",
          scrollX: false,
          paging: false,
          info: true,
          ordering: false,
          scrollCollapse: true,
          responsive: true,
          searching: false,
          autoWidth: true,
          processing: true,
      } );
    }, 500);
  }else {
    Swal.fire(
        'No data to be UnIdentified!',
        'Please select data first!'
      )
  }

 })

});

