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
            url: "/?fetch_all_groups",
            method: "GET",
            data: null,
            map: function (repsonse) {
              var dataset = repsonse.groups;
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
          field: "name",
          title: "Name",
        },
        {
          field: "agent",
          title: "Admin",
        },
        {
          field: "limit",
          title: "Limit",
        },
        {
          field: "members",
          title: "Members",
        },
        {
          field: "Actions",
          title: "Actions",
          sortable: false,
          width: 125,
          overflow: "visible",
          autoHide: false,
          template: function () {
            return '\
							<div class="dropdown dropdown-inline">\
							<a href="javascript:;" id="edit" onClick="javascript:editEventHandler(this);" class="btn btn-sm btn-clean btn-icon mr-2" title="Edit details" data-toggle="modal" data-target="">\
	                            <span class="svg-icon svg-icon-md">\
	                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">\
	                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">\
	                                        <rect x="0" y="0" width="24" height="24"/>\
	                                        <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "/>\
	                                        <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"/>\
	                                    </g>\
	                                </svg>\
	                            </span>\
							</a>\
							<a href="javascript:;" id="delete" onClick="javascript:deleteEventHandler(this);" class="btn btn-sm btn-clean btn-icon" title="Delete" data-toggle="modal" data-target="">\
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

    $("#kt_datatable").on("change", function () {
      console.log("changed!");
    });
  };

  return {
    // Public functions
    init: function (data = null) {
      // init dmeo
      load(data);
    },
  };
})();

const triggerOnLoad = () => {
  KTDatatableDataLocalDemo.init();
};

// Add New User:
const addGroupClick = () => {
  // input
  const name = $("#myModal #name").val();
  const agent = $("#myModal #agents").val();
  const limit = $("#myModal #limit").val();

  var request_ready = true;
  // check
  if (name.length === 0) request_ready = false;

  if (request_ready) {
    // ajax:
    $.ajax({
      url: "/",
      method: "POST",
      data: {
        create_group: "submit",
        name: name,
        agent: agent,
        limit: limit,
      },
      success: (response) => {
        if (response.status === "success") {
          $("#kt_datatable").KTDatatable().reload(); // reload dataset.
        }
        $("#myModal").modal("toggle");
        message(response.status, response.info);
      },
      error: (xhr, msg) => {},
    });
  } else {
    new Sweetalert2(
      "<strong>Are you missing a name?<hr>\n <small>Please fill in required fields.<small></strong>"
    );
  }
};

// Update an Existing User:
const updateGroupClick = () => {
  // input
  const gid = $("#myModal2 #target_id").val();
  const name = $("#myModal2 #new_name").val();
  const agent = $("#myModal2 #new_agent").val();
  const limit = $("#myModal2 #new_limit").val();

  // ajax:
  $.ajax({
    url: "/",
    method: "POST",
    data: {
      update_group: "submit",
      id: gid,
      name: name,
      agent: agent,
      limit: limit,
    },
    success: (response) => {
      if (response.status === "success") {
        $("#kt_datatable").KTDatatable().reload(); // reload dataset.
      }
      $("#myModal2").modal("toggle");
      message(response.status, response.info);
    },
    error: (xhr, msg) => {},
  });
};

const deleteGroupClick = () => {
  const id = $("#myModal3 #target_id").val();
  if (id.length > 0) {
    // send delete request with id
    $.ajax({
      url: "/",
      method: "POST",
      data: {
        delete_group: "submit",
        id: id,
      },
      success: (response) => {
        if (response.status === "success") {
          $("#kt_datatable").KTDatatable().reload(); // reload dataset.
        }
        $("#myModal3").modal("toggle");
        message(response.status, response.info);
      },
      error: (xhr) => {},
    });
  } else {
    new Sweetalert2("Missing and id?");
  }
};

// create event listener:
const createEventListener = (e) => {
  // fetch
  $.ajax({
    url: "/?fetch_available_agents",
    data: null,
    success: (response) => {
      if (response.status === "success") {
        document.querySelector("#myModal #agents").innerHTML = null;
        $("#myModal #agents").append(
          "<option selected disabled>Select an Agent</option>"
        );
        response.agents.forEach((agent) => {
          var newOption = document.createElement("option");
          newOption.value = agent.id;
          newOption.textContent = agent.username;
          document.querySelector("#myModal #agents").appendChild(newOption);
        });
      }
    },
    error: (xhr) => {},
  });
};

// Edit event handler:
const editEventHandler = (e) => {
  const row = $(e).parentsUntil("tr").parent();
  const id = row.children('[data-field="id"]').attr("aria-label");
  const name = row.children('[data-field="name"]').attr("aria-label");
  const agent = row.children('[data-field="agent"]').attr("aria-label");
  const limit = row.children('[data-field="limit"]').attr("aria-label");
  // reload agent list //
  $.ajax({
    url: "/",
    data: { fetch_available_agents: true },
    success: (response) => {
      if (response.status === "success") {
        document.querySelector("#myModal2 #new_agent").innerHTML = null;
        $("#myModal2 #new_agent").append(
          "<option selected disabled>Select an Agent</option>"
        );
        response.agents.forEach((agent) => {
          var newOption = document.createElement("option");
          newOption.value = agent.id;
          newOption.textContent = agent.username;
          document.querySelector("#myModal2 #new_agent").appendChild(newOption);
        });
      }
    },
    error: (xhr) => {
      document
        .querySelector("#myModal2 #new_agent")
        .setAttribute("disabled", "true");
    },
  });
  $("#myModal2 #target_id").val(id);
  $("#myModal2 #new_name").val(name);
  $("#myModal2 #new_agent").val(agent);
  $("#myModal2 #new_limit").val(limit);
  // reveal modal:
  $("#myModal2").modal("toggle");
};

// delete event handler:
const deleteEventHandler = (e) => {
  const parent = $(e).parentsUntil("tr").parent();
  const id = parent.children("td")[0].ariaLabel;
  $("#myModal3 #target_id").val(id);
  $("#myModal3").modal("toggle");
};

// //
jQuery(document).ready(function () {
  // ########################### //
  const InitLocalDB = triggerOnLoad;
  InitLocalDB();
  createEventListener();
});
