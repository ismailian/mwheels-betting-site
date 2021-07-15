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
            url: "/?fetch_agents",
            method: "GET",
            data: null,
            map: (response) => {
              var dataset = response.agents;
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
          field: "email",
          title: "Email",
        },
        {
          field: "balance",
          title: "Balance",
        },
        {
          field: "credit",
          title: "Credit",
        },
        {
          field: "group",
          title: "Admin Of",
        },
        {
          field: "members",
          title: "Members",
          textAlign: "center",
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
  };

  return {
    // Public functions
    init: function () {
      // init dmeo
      load();
    },
  };
})();

const triggerOnLoad = () => {
  KTDatatableDataLocalDemo.init();
};

// Add New User:
const addAgentClick = () => {
  // input
  const email = $("#myModal #email").val();
  const username = $("#myModal #username").val();
  const password = $("#myModal #password").val();
  const credit = $("#myModal #credit").val();
  const group = $("#myModal #group").val();
  const users = $("#myModal #users").val();

  var request_ready = true;

  // check
  if (email.length === 0) request_ready = false;
  if (username.length === 0) request_ready = false;
  if (password.length === 0) request_ready = false;
  if (group === null) request_ready = false;

  if (request_ready) {
    // ajax:
    $.ajax({
      url: "/",
      method: "POST",
      data: {
        create_agent: "submit",
        email: email,
        username: username,
        password: password,
        credit: credit,
        group: group,
        users: users,
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
      "<strong>Are you missing some arguments?<hr>\n" +
        "<small>Please make sure all fields are filled and a group is selected. " +
        "If there is no group, consider creating one.</small></strong>"
    );
  }
};

// Update an Existing User:
const updateAgentClick = () => {
  // input
  const agent_id = $("#myModal2 #target_id").val();
  const email = $("#myModal2 #new_email").val();
  const password = $("#myModal2 #new_password").val();
  const credit = $("#myModal2 #new_credit").val();

  var request_ready = true;

  // check
  if (agent_id.length === 0) request_ready = false;

  if (request_ready) {
    // ajax:
    $.ajax({
      url: "/",
      method: "POST",
      data: {
        update_agent: "submit",
        id: agent_id,
        email: email,
        password: password,
        credit: credit,
        group: [],
        users: [],
      },
      success: (response) => {
        if (response.status === "success") {
          $("#kt_datatable").KTDatatable().reload(); // reload dataset.
        }
        $("#myModal2").modal("toggle");
        message(response.status, response.info);
      },
      error: (xhr) => {},
    });
  }
};

// delete //
const deleteAgentClick = () => {
  const id = localStorage.getItem("target_id");
  if (id) {
    $.ajax({
      url: "/",
      method: "POST",
      data: {
        delete_agent: "submit",
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
  }
};

// refresh users //
const refreshUsers = () => {
  // fetch available groups //
  $.ajax({
    url: "/?fetch_available_groups",
    data: null,
    success: (response) => {
      if (response.status === "success") {
        $("#myModal #group").append(
          "<option selected disabled>Select a group</option>"
        );
        response.groups.forEach((group) => {
          var option = document.createElement("option");
          option.value = group.id;
          option.textContent = group.name;
          document.querySelector("#myModal #group").appendChild(option);
        });
      }
    },
    error: (xhr) => {
      $("#myModal #group").append(
        "<option selected disabled>No Available Groups.</option>"
      );
    },
  });
};

// add event handler:
const addEventHandler = (e) => {
  $("#myModal #username").val("");
  $("#myModal #password").val("");
  $("#myModal #email").val("");
  $("#myModal #credit").val(0);
};

// Edit event handler:
const editEventHandler = (e) => {
  const row = $(e).parentsUntil("tr").parent();
  const id = row.children('[data-field="id"]').attr("aria-label");
  const name = row.children('[data-field="username"]').attr("aria-label");
  const email = row.children('[data-field="email"]').attr("aria-label");
  const credit = row.children('[data-field="credit"]').attr("aria-label");
  const group = row.children('[data-field="group"]').attr("aria-label");
  $("#myModal2 #target_id").val(id);
  $("#myModal2 #new_username").val(name);
  $("#myModal2 #new_password").val("");
  $("#myModal2 #new_email").val(email);
  $("#myModal2 #new_credit").val(parseInt(credit.replace("$", "")));
  $("#myModal2 #group").val(group);
  document.querySelector("#myModal2 #group").innerHTML = null;
  $("#myModal2").modal("toggle");
};

// delete event handler:
const deleteEventHandler = (e) => {
  const row = $(e).parentsUntil("tr").parent();
  const id = row.children('[data-field="id"]').attr("aria-label");
  localStorage.setItem("target_id", id);
  $("#myModal3").modal("toggle");
};

jQuery(document).ready(function () {
  const InitLocalDB = triggerOnLoad;
  InitLocalDB();
});
