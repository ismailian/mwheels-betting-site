function addNewPie(number) {
  $(".silicon").append(`<div id="${number}" class="col-lg-3 mb-5"><div>`);
  const lastWheel = $(".silicon")
    .children()
    .eq($(".silicon").children().length - 1);
  $(lastWheel).append(
    `<div id="wheel_${number}" class="piemenu" data-number="${number}" data-wheelnav data-wheelnav-slicepath='DonutSlice' data-wheelnav-navangle='270' data-wheelnav-init></div>`
  );
  for (let ws = 0; ws < 10; ws++) {
    $(`#wheel_${number}`).append(
      `<div data-wheelnav-navitemtext="0${ws}" onmouseup="javascript:toggleModal(this);"></div>`
    );
  }

  var pie = new wheelnav("wheel_" + number);
  pie.multiSelect = true;
  pie.slicePathFunction = slicePath().DonutSlice;
  pie.colors = colorpalette.fractallove;
  pie.wheelRadius = pie.wheelRadius * 0.6;
  pie.selectedNavItemIndex = null;
  pie.titleSelectedAttr = { fill: "#000000" };
  pie.navAngle = 270;
  pie.clickModeRotate = true;
  pie.initWheel();
  pie.createWheel();

  // reorder elements //
  var silicon = document.getElementById("silicon");

  [].map
    .call(silicon.children, Object)
    .sort(function (a, b) {
      return +a.id.match(/\d+/) - +b.id.match(/\d+/);
    })
    .forEach(function (elem) {
      silicon.appendChild(elem);
    });

  return pie;
}

function disableItem(wheel, index) {
  // taregt nav item //
  var navItem = wheel.navItems[index];

  // reset title and disable //
  navItem.title = "sold";
  navItem.titleHover = "sold";
  navItem.titleSelected = "sold";
  navItem.enabled = false;
  navItem.selected = true;

  navItem.titleSelectedAttr = { fill: "#666666" };
  navItem.sliceSelectedAttr = { fill: "#cccccc" };

  navItem.navigateFunction = null;
  navItem.navSlice.mouseup(null);
  navItem.navSlice.mouseout(null);
  navItem.navSlice.mouseover(null);

  navItem.navLine.mouseup(null);
  navItem.navLine.mouseout(null);
  navItem.navLine.mouseover(null);

  navItem.navTitle.mouseup(null);
  navItem.navTitle.mouseout(null);
  navItem.navTitle.mouseover(null);

  // reset cursor:
  navItem.titleAttr = { fill: "#FFF", cursor: "default" };
  navItem.titleHoverAttr = { cursor: "default", fill: "#FFF" };

  // reinitialize wheel //
  wheel.refreshWheel();
}

jQuery(document).ready(() => {
  // request wheels from server //
  $.ajax({
    url: "/?fetch_wheels",
    method: "GET",
    data: { type: localStorage.getItem("type") },
    success: (response) => {
      response.wheels.forEach((wheel) => {
        // current wheel //
        let currentWheel = null;

        // create or render the wheel //
        if (document.getElementById(`wheel_${wheel.wheel_number}`) === null) {
          // create new wheel //
          currentWheel = addNewPie(wheel.wheel_number);
          //
        } else {
          // new instance of wheelnav //
          var pie = new wheelnav(`wheel_${wheel.wheel_number}`);

          // give it a color //
          pie.multiSelect = true;

          // set colors //
          pie.colors = colorpalette.fractallove;

          // set radius //
          pie.wheelRadius = pie.wheelRadius * 0.6;

          // reset select item index //
          pie.selectedNavItemIndex = null;

          // init wheelnav //
          pie.initWheel();

          // set colors //
          pie.titleSelectedAttr = { fill: "#000000" };

          // create wheelnav //
          pie.createWheel();

          // assign wheel //
          currentWheel = pie;
        }

        // disable if full //
        if (wheel.is_full) {
          const pie = document.getElementById(`wheel_${wheel.wheel_number}`);
          pie.classList.add("sold");
        }

        // check if there are any taken spots //
        if (wheel.taken_spots.length > 0) {
          // loop through and disable //
          wheel.taken_spots.forEach((spot) => {
            // disable spot //
            disableItem(currentWheel, spot.wheel_spot);
          });
        }
      });
    },
    error: (xhr) => {},
  });
});
