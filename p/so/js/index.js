var table = null;
jQuery(document).ready(function(){
    table = jQuery('#tblSo').DataTable({
        'processing': true,
        'serverSide': true,
        'autoWidth': true,
        'responsive': true,
        'lengthChange': true,
        // 'stateSave': true,
        // "stateSave": true,
        // "fnCreatedRow": function( nRow, aData, iDataIndex ) {
        //   $(nRow).attr('id', aData[0]);
        // }, 
        // 
        // "dom": "Blfrtip",
        // "buttons": [
        //     'excelHtml5',
        //     'csvHtml5'
        // ], 
        // "language": {
        //     "info": "Showing _START_ to _END_ of _TOTAL_ orders",
        //     // "infoEmpty": "Showing 0 to 0 of 0 scans"
        //     // "infoFiltered": "(filtered from _MAX_ total entries)",
        //   },
        'ajax': {
            "url": window.location.origin + "/p/so/data.php",
            "type": "POST"
        },
        'columns': [
            {"data": "SO", "title":"Sales Order" },
            {"data": "SortCodeDescription"},
            {"data": "Picker"},
            {"data": "Customer"},
            {"data": "Reference"},
            {"data": "value"},
            {"data": "Shipday"},
            {"data": "ProcessedDate"},
            {"data": "createdby"},
            {"data": "LineId", "orderable": false, "render": function ( data, type, row ) {
                var html  = '<input type="checkbox" name="chkLineId_' + data + '" value="1">';
                return html
            }},
        ],
    });

    jQuery('#btnRefresh').click(function()
    {
        table.ajax.reload();
    });


    setInterval( function () {
        table.ajax.reload();
    }, 900000 ); // 15 mins

});
