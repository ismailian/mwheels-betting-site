var currentTarget;

// ajax request pusher //
const pusher = (data) => {
  // compose and send ajax request:
  $.ajax({
    url: "/",
    method: "POST",
    data: data,
    success: (response) => {
      const piemenu = currentTarget.wheelnav;
      const index = currentTarget.itemIndex;
      if (response.status === "success") {
        $("#my_balance").text(response.balance);
        // reset title and disable //
        disableItem(piemenu, index);
        // reset title and disable //
        if (response.is_full === true && response.wheel !== null) {
          // conciel currenT wheel //
          document.getElementById(piemenu.holderId).classList.add("sold");
          // append new wheel //
          addNewPie(response.wheel);
        }
      }
      Swal.fire(response.status, response.info, response.status);
    },
    error: (xhr, msg) => {},
  });
};

$("#myModal .btn-primary, #myModal .btn-success").on("click", (e) => {
  // parse info:
  const type = localStorage.getItem("type");
  const number = localStorage.getItem("number");
  const spot = localStorage.getItem("spot");
  const choice = e.currentTarget.id;

  // unset all items:
  localStorage.removeItem("number");
  localStorage.removeItem("spot");

  // compose
  pusher({
    push_betting: "submit",
    type: type,
    number: number,
    spot: spot,
    choice: choice,
    date: new Date().toLocaleString(),
  });
  // compose
});

const toggleModal = (e) => {
  // extract data //
  const number = e.wheelnav.holderId.split("wheel_")[1];
  const spot = e.itemIndex;
  // set numbers in storage //
  localStorage.setItem("type", localStorage.getItem("type"));
  localStorage.setItem("number", number);
  localStorage.setItem("spot", spot);
  // update item //
  $("#spot").text(spot);
  $("#myModal").modal("show");
  currentTarget = e;
};
