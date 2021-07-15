const resetClickHandler = reset();
function reset() {
  return () => {
    // submit a reset //
    $.ajax({
      url: "/",
      method: "POST",
      data: { reset_all: "submit" },
      success: (response) => {
        message(response.status, response.info);
        $("#myModal5").modal("toggle");
      },
      error: (xhr) => {},
    });
  };
}

const resetBalanceClickHandler = resetBalance();
function resetBalance() {
  return () => {
    // submit a reset //
    $.ajax({
      url: "/",
      method: "POST",
      data: { reset_balance: "submit" },
      success: (response) => {
        message(response.status, response.info);
      },
      error: (xhr) => {},
    });

    $("#myModal4").modal("toggle");
  };
}

// SweetAlert Message
const message = (icon, textMessage) => {
  const Toast = Swal.mixin({
    toast: true,
    position: "bottom-end",
    showConfirmButton: false,
    timer: 2000,
    timerProgressBar: true,
    onOpen: (toast) => {
      toast.addEventListener("mouseenter", Swal.stopTimer);
      toast.addEventListener("mouseleave", Swal.resumeTimer);
    },
  });

  Toast.fire({
    icon: icon,
    title: textMessage,
  });
};
