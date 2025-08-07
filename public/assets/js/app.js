//toast
function showToast(message, type = "info", delay = 3000) {
  const toastCustom = document.getElementById("customToast");
  const toastBody = document.getElementById("toastBody");
  const toastPlacement = document.getElementById("toastPlacement");
  toastPlacement.classList.add(
    "position-fixed",
    "top-0",
    "start-50",
    "translate-middle-x",
    "p-3"
  );
  toastCustom.style.backdropFilter = "blur(5px)";
  // Reset class trước khi thêm class mới (để tránh lớp dính cũ)

  if (type === "error") {
    toastCustom.classList.add("bg-danger", "text-white");
  } else if (type === "success") {
    toastCustom.classList.add("bg-success", "text-white");
  }

  toastBody.textContent = message;
  const toast = new bootstrap.Toast(toastCustom, {
    autohide: true,
    delay: delay,
  });
  toast.show();
}

document.addEventListener("DOMContentLoaded", function () {
  console.log("DOMContentLoaded event fired");
  if (window.toastMessage) {
    console.log("Toast message found:", window.toastMessage);
    showToast(window.toastMessage.message, window.toastMessage.type);

    const url = new URL(window.location);
    ["send", "reset", "success"].forEach((param) =>
      url.searchParams.delete(param)
    );
    window.history.replaceState({}, document.title, url.pathname);
  }
});
