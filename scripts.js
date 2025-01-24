document.addEventListener("DOMContentLoaded", function () {
  const registrationForm = document.getElementById("registrationForm");
  if (registrationForm) {
    registrationForm.addEventListener("submit", function (e) {
      e.preventDefault();
      const formData = new FormData(this);
      fetch("ajax/register-event.php", {
        method: "POST",
        body: formData,
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            alert("Registration successful.");
            window.location.reload();
          } else {
            alert(data.message || "Registration failed.");
          }
        })
        .catch((error) => alert("An error occurred. Please try again later."));
    });
  }
});
