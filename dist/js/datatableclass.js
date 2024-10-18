$(function () {
  if (!$.fn.DataTable.isDataTable("#class-table")) {
    $("#class-table")
      .DataTable({
        responsive: true,
        paging: true,
        lengthChange: true,
        searching: true,
        info: false,
        autoWidth: false,
      })
      .buttons()
      .container()
      .appendTo("#class-table_wrapper .col-md-6:eq(0)");
  }
});
