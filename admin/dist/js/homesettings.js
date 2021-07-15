const updateHomepageClick = () => {
  const status = $("#status").val();
  const mode = $("#mode").val();
  const text = $("#text").val();

  // push to server //
  $.ajax({
    url: "/",
    method: "POST",
    data: {
      update_homepage: "submit",
      status: status,
      mode: mode,
      text: text,
    },
    success: (response) => {
      message(response.status, response.info);
    },
    error: (xhr) => {},
  });
};

jQuery(document).ready(() => {
  // set the mode to current //
  $.ajax({
    url: "/?fetch_mode",
    method: "GET",
    data: null,
    success: (response) => {
      if (response.status === "success") {
        $("#status").val(response.condition);
        $("#mode").val(response.mode);
        $("#text").val(response.text);
      }
    },
    error: (xhr) => {},
  });
});
