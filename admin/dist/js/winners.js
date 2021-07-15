"use strict";
// Class definition

var KTDatatableDataLocalDemo = (function () {
  // Private functions

  // demo initializer
  var load = function () {
    var datatable = $("#kt_datatable").KTDatatable({
      // datasource definition
      data: {
        type: "remote",
        source: {
          read: {
            url: "/?fetch_winners",
            method: "GET",
            data: null,
            map: (response) => {
              var dataset = response.winners;
              return dataset;
            },
          },
        },
        pageSize: 10,
      },

      // layout definition
      layout: {
        scroll: false, // enable/disable datatable scroll both horizontal and vertical when needed.
        // height: 450, // datatable's body's fixed height
        footer: false, // display/hide footer
      },

      // column sorting
      sortable: true,

      pagination: true,

      search: {
        input: $("#kt_datatable_search_query"),
        key: "generalSearch",
      },

      // columns definition
      columns: [
        {
          field: "id",
          title: "#",
          sortable: false,
          width: 20,
          type: "number",
          selector: {
            class: "",
          },
          textAlign: "center",
        },
        {
          field: "username",
          title: "Username",
          textAlign: "center",
        },
        {
          field: "cid",
          title: "Confirm ID",
        },
        {
          field: "number",
          title: "Wheel Number",
          textAlign: "center",
        },
        {
          field: "spot",
          title: "Wheel Spot",
          textAlign: "center",
        },
        {
          field: "prize",
          title: "Prize",
          textAlign: "center",
        },
        {
          field: "on",
          title: "Date",
          textAlign: "center",
        },
      ],
    });

    $("#kt_datatable_search_status").on("change", function () {
      datatable.search($(this).val().toLowerCase(), "Status");
    });

    $("#kt_datatable_search_type").on("change", function () {
      datatable.search($(this).val().toLowerCase(), "Type");
    });

    $("#kt_datatable_search_status, #kt_datatable_search_type").selectpicker();
  };

  return {
    // Public functions
    init: function () {
      // init dmeo
      load();
    },
  };
})();

// delete event handler:
const deleteEventHandler = (e) => {
  const row = $(e).parentsUntil("tr").parent();
  const id = row.children('[data-field="id"]').attr("aria-label");
  // ajax //
  $.ajax({
    url: "/",
    method: "POST",
    data: {
      delete_winner: "submit",
      id: id,
    },
    success: (response) => {
      if (response.status === "success") {
        $("#kt_datatable").KTDatatable().reload();
      }
      message(response.status, response.info);
    },
    error: (xhr) => {},
  });
};

jQuery(document).ready(function () {
  KTDatatableDataLocalDemo.init();
});
