
document.getElementById("productForm").addEventListener("submit", function(e) {
  e.preventDefault();
  console.log("submitting...");

  const formData = new FormData(this);

  fetch("add_Product.php", {
    method: "POST",
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    if (data.status === "error") {
      // Show validation errors
      Object.keys(data.errors).forEach(field => {
        const errorSpan = document.querySelector(`#${field}Error`);
        if (errorSpan) {
          errorSpan.textContent = data.errors[field];
        }
      });
    } else if (data.status === "success") {
      // Clear errors
      document.querySelectorAll(".error-msg").forEach(el => el.textContent = "");

      // Show success modal
      document.getElementById("successMessage").textContent = data.message;
      document.getElementById("successModal").style.display = "block";

      // Optionally reset form
      this.reset();
    }
  })
  .catch(err => console.error("Request failed", err));
});

s
function showModal(message) {
      document.getElementById('modalMessage').textContent = message;
      document.getElementById('overlay').style.display = 'block';
      document.getElementById('modal').style.display = 'block';
  }
  
  function closeModal() {
      document.getElementById('modal').style.display = 'none';
      document.getElementById('overlay').style.display = 'none';
  }
  



  