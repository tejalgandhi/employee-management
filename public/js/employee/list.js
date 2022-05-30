var dTable = $('.dt-responsive').dataTable({
    processing: true,
    serverSide: true,
    searching: true,
    "bLengthChange": true,
    "bInfo" : false,
    "bSort" : false,
    "dom": "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-6'i><'col-sm-6'p>>"+
        '<"clear">',
    scrollX:true,
    "lengthMenu": [[10, 25, 50,100 ,-1], [10, 25, 50,100,"All"]],
    oLanguage: {
        //sProcessing: showMessage()
    },
    "initComplete": function (settings, json) {
        $(".checkall").closest("th").removeClass("sorting_asc");
    },
    ajax: {
        url: ajax_datatable,
        type: 'post',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: function (d) {
        }
    },
    columns: [
        {data: 'id', name: 'id'},
        {data: 'emp_no', name: 'emp_no'},
        {data: 'name', name: 'name'},
        {data: 'address', name: 'address'},
        {data: 'email', name: 'email'},
        {data: 'phone', name: 'phone'},
        {data: 'dob', name: 'dob'},
        {data: 'image', name: 'image'},
        {data: 'action', name: 'action'},
    ],
    "fnRowCallback" : function(nRow, aData, iDisplayIndex){
        var oSettings = dTable.fnSettings();
        $("td:first", nRow).html(oSettings._iDisplayStart+iDisplayIndex +1);
        return nRow;
    },
});

