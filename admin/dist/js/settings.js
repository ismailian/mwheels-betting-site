function updateClick() {
  // extract info:
  const username = $("#username").val();
  const email = $("#email").val();
  const password = $("#password").val();
  const credit = $("#credit").val();
  const site_name = $("#site_name").val();

  // push to server:
  $.ajax({
    url: "/",
    method: "POST",
    data: {
      update_admin_account: "submit",
      username: username,
      email: email,
      password: password,
      credit: credit,
      site_name: site_name,
    },
    success: (response) => {
      message(response.status, response.info);
    },
    error: (xhr) => {},
  });
}

// autoload
const autoload = () => {
  // fetch admin info //
  $.ajax({
    url: "/?fetch_admin_info",
    method: "GET",
    data: null,
    success: (response) => {
      if (response.status === "success") {
        $("#username").val(response.admin.username);
        $("#email").val(response.admin.email);
        $("#credit").val(response.admin.balance);
        $("#site_name").val(response.site.sitename);
      }
    },
    error: (xhr) => {},
  });
};

// call autoload
autoload();
