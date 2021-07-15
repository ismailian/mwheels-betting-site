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
            url: "/?fetch_auditlogs",
            method: "GET",
            data: null,
            map: (response) => {
              var dataset = response.auditlogs;
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
        },
        {
          field: "cid",
          title: "Confirm ID",
        },
        {
          field: "wheel_type",
          title: "Wheels Type",
          textAlign: "center",
        },
        {
          field: "wheel_number",
          title: "Wheel Number",
          textAlign: "center",
        },
        {
          field: "wheel_spot",
          title: "Spot Taken",
          textAlign: "center",
        },
        {
          field: "choice",
          title: "Status",
          // callback function support for column rendering
          template: function (row) {
            return (
              '<span class="label font-weight-bold label-lg label-light-success label-inline">' +
              row.choice +
              "</span>"
            );
          },
        },
        {
          field: "paid",
          title: "Paid",
          // callback function support for column rendering
          template: function (row) {
            return (
              '<span class="label font-weight-bold label-lg label-light-danger label-inline">' +
              row.paid +
              "</span>"
            );
          },
        },
        {
          field: "date",
          title: "Date",
          sortable: true,
          width: 125,
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
      delete_bet: "submit",
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

const auditlogsUpdater = () => {
  setInterval(() => {
    $("#kt_datatable").KTDatatable().reload();
  }, 100 * 100);
};

jQuery(document).ready(function () {
  KTDatatableDataLocalDemo.init();
  setTimeout(() => {
    auditlogsUpdater(); // updates frequently.
  }, 2000);
});
