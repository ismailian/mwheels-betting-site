// disable form //
$("kt_form").on("submit", (e) => {
  e.preventDefault();
});

const UpdatePage = (data) => {
  $.ajax({
    url: "/",
    method: "POST",
    data: data,
    success: (response) => {
      message(response.status, response.info);
    },
    error: (xhr) => {},
  });
};

const editPageOne = () => {
  // extract info //
  const page_id = 1;
  const page_name = $("#page01 #pagename").val();
  const page_odds = $("#page01 #pageodds").val();
  const page_cost = $("#page01 #pageentry").val();
  const page_prize = $("#page01 #pageprize").val();
  const page_status = $("#page01 #pagestatus").val();
  // push request //
  UpdatePage({
    update_page: "submit",
    id: page_id,
    name: page_name,
    odds: page_odds,
    cost: page_cost,
    prize: page_prize,
    status: page_status,
  });
};
const editPageTwo = () => {
  // extract info //
  const page_id = 2;
  const page_name = $("#page02 #pagename").val();
  const page_odds = $("#page02 #pageodds").val();
  const page_cost = $("#page02 #pageentry").val();
  const page_prize = $("#page02 #pageprize").val();
  const page_status = $("#page02 #pagestatus").val();
  // push request //
  UpdatePage({
    update_page: "submit",
    id: page_id,
    name: page_name,
    odds: page_odds,
    cost: page_cost,
    prize: page_prize,
    status: page_status,
  });
};
const editPageThree = () => {
  // extract info //
  const page_id = 3;
  const page_name = $("#page03 #pagename").val();
  const page_odds = $("#page03 #pageodds").val();
  const page_cost = $("#page03 #pageentry").val();
  const page_prize = $("#page03 #pageprize").val();
  const page_status = $("#page03 #pagestatus").val();
  // push request //
  UpdatePage({
    update_page: "submit",
    id: page_id,
    name: page_name,
    odds: page_odds,
    cost: page_cost,
    prize: page_prize,
    status: page_status,
  });
};

// page 04
const editPageFour = () => {
  // extract info //
  const page_id = 4;
  const page_name = $("#page04 #pagename").val();
  const page_odds = $("#page04 #pageodds").val();
  const page_cost = $("#page04 #pageentry").val();
  const page_prize = $("#page04 #pageprize").val();
  const page_status = $("#page04 #pagestatus").val();
  // push request //
  UpdatePage({
    update_page: "submit",
    id: page_id,
    name: page_name,
    odds: page_odds,
    cost: page_cost,
    prize: page_prize,
    status: page_status,
  });
};

const editPageFive = () => {
  // extract info //
  const page_id = 5;
  const page_name = $("#page05 #pagename").val();
  const page_odds = $("#page05 #pageodds").val();
  const page_cost = $("#page05 #pageentry").val();
  const page_prize = $("#page05 #pageprize").val();
  const page_status = $("#page05 #pagestatus").val();
  // push request //
  UpdatePage({
    update_page: "submit",
    id: page_id,
    name: page_name,
    odds: page_odds,
    cost: page_cost,
    prize: page_prize,
    status: page_status,
  });
};

const editPageSix = () => {
  // extract info //
  const page_id = 6;
  const page_name = $("#page06 #pagename").val();
  const page_odds = $("#page06 #pageodds").val();
  const page_cost = $("#page06 #pageentry").val();
  const page_prize = $("#page06 #pageprize").val();
  const page_status = $("#page06 #pagestatus").val();
  // push request //
  UpdatePage({
    update_page: "submit",
    id: page_id,
    name: page_name,
    odds: page_odds,
    cost: page_cost,
    prize: page_prize,
    status: page_status,
  });
};

const autoload = () => {
  // fetch data from server //
  $.ajax({
    url: "/?fetch_pages_info",
    method: "GET",
    data: null,
    success: (response) => {
      if (response.status === "success") {
        response.pages.forEach((page) => {
          $(`#page0${page.id} #pagename`).val(page.name);
          $(`#page0${page.id} #pageodds`).val(page.odds);
          $(`#page0${page.id} #pageentry`).val(page.amount);
          $(`#page0${page.id} #pageprize`).val(page.prize);
          $(`#page0${page.id} #pagestatus`).val(page.allowed);
        });
      }
    },
    error: (xhr) => {},
  });
};

// call autoload method
autoload();
