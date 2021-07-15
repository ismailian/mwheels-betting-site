const publishWinners = () => {
  // disable button //
  $("#publish").attr("disabled", true);

  const n01 = $("#number01").val();
  const n02 = $("#number02").val();
  const n03 = $("#number03").val();
  const n04 = $("#number04").val();
  const n05 = $("#number05").val();
  const n06 = $("#number06").val();
  const n07 = $("#number07").val();

  var complete = true;

  if (typeof n01 !== "string") complete = false;
  if (typeof n02 !== "string") complete = false;
  if (typeof n03 !== "string") complete = false;
  if (typeof n04 !== "string") complete = false;
  if (typeof n05 !== "string") complete = false;
  if (typeof n06 !== "string") complete = false;
  if (typeof n07 !== "string") complete = false;

  // push to server //
  if (complete) {
    $.ajax({
      url: "/",
      method: "POST",
      data: {
        publish: "submit",
        numbers: { n01, n02, n03, n04, n05, n06, n07 },
      },
      success: (response) => {
        message(response.status, response.info);
        document.querySelector("#publish").removeAttribute("disabled");
      },
      error: (xhr) => {},
    });
  } else {
    Swal.fire("Warning", "Make sure you've Selected all numbers!", "warning");
  }
};

const filterAutofill = () => {
  $.ajax({
    url: "/",
    method: "POST",
    data: {
      filter_autofill: "submit",
    },
    success: (response) => {
      if (response.status === "success") {
        // enable all //
        document.querySelector("#number01").removeAttribute("disabled");
        document.querySelector("#number02").removeAttribute("disabled");
        document.querySelector("#number03").removeAttribute("disabled");
        document.querySelector("#number04").removeAttribute("disabled");
        document.querySelector("#number05").removeAttribute("disabled");
        document.querySelector("#number06").removeAttribute("disabled");
        document.querySelector("#number07").removeAttribute("disabled");
        document.querySelector("#publish").removeAttribute("disabled");
        document.querySelector("#randomize").removeAttribute("disabled");
      }
      message(response.status, response.info);
    },
    error: (xhr) => {},
  });
};

const randomize = () => {
  // get random numbers //
  const n01 = Math.floor(Math.random() * 10);
  const n02 = Math.floor(Math.random() * 10);
  const n03 = Math.floor(Math.random() * 10);
  const n04 = Math.floor(Math.random() * 10);
  const n05 = Math.floor(Math.random() * 10);
  const n06 = Math.floor(Math.random() * 10);
  const n07 = Math.floor(Math.random() * 10);

  $("#number01").val(n01);
  $("#number02").val(n02);
  $("#number03").val(n03);
  $("#number04").val(n04);
  $("#number05").val(n05);
  $("#number06").val(n06);
  $("#number07").val(n07);

  message("info", "Random Numbers Have Been Chosen.");
};
