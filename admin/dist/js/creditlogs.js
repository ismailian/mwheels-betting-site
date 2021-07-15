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
            url: "/?fetch_creditlogs",
            method: "GET",
            data: null,
            map: (response) => {
              var dataset = response.creditlogs;
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
          field: "received",
          title: "Received",
          textAlign: "center",
          width: 90,
          // callback function support for column rendering
          template: function (row) {
            return (
              '<span class="label font-weight-bold label-lg label-success label-inline w-100">' +
              row.received +
              "</span>"
            );
          },
        },
        {
          field: "by",
          title: "From",
          textAlign: "center",
          width: 100,
          // callback function support for column rendering
          template: function (row) {
            return (
              '<span class="label font-weight-bold label-lg label-info label-inline w-100">' +
              row.by +
              "</span>"
            );
          },
        },
        {
          field: "on",
          title: "Date",
          textAlign: "center",
        },
        {
          field: "Actions",
          title: "Actions",
          sortable: false,
          width: 125,
          overflow: "visible",
          autoHide: false,
          textAlign: "center",
          template: function () {
            return '\
							<a href="javascript:;" id="delete" onClick="javascript:deleteEventHandler(this);" class="btn btn-sm btn-clean btn-icon" title="Delete">\
                <span class="svg-icon svg-icon-md">\
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">\
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">\
                            <rect x="0" y="0" width="24" height="24"/>\
                            <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"/>\
                            <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"/>\
                        </g>\
                    </svg>\
                </span>\
							</a>\
						';
          },
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
      delete_creditlog: "submit",
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
