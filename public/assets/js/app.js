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

console.log("app.js loaded");

document.addEventListener("DOMContentLoaded", function () {
  console.log("DOMContentLoaded event fired");
  if (window.loginError && window.loginError.length > 0) {
    showToast(window.loginError.join(" "), "error");
  } else if (window.registerSuccess) {
    showToast("Đăng ký thành công! Vui lòng đăng nhập.", "success");
    const url = new URL(window.location);
    url.searchParams.delete("success");
    window.history.replaceState({}, document.title, url.pathname);
  } else if (window.registerError && window.registerError.length > 0) {
    showToast(window.registerError.join(" "), "error");
  }
});
