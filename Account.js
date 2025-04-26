
function validateForm(event) {
    event.preventDefault();
  
    const form = event.target;
  
    const fname = document.getElementById("Fname");
    const lname = document.getElementById("Lname");
    const email = document.getElementById("email");
    const phone = document.getElementById("Phone");
    const genderChecked = document.querySelector('input[name="Gender"]:checked');
    const password = document.getElementById("password");
    const cpass = document.getElementById("Cpass");
  
    let isValid = true;
  
    function showError(input, message) {
      input.classList.add("input-error");
      const errorSpan = document.getElementById("error" + input.id);
      if (errorSpan) errorSpan.textContent = message;
      isValid = false;
    }
  
    function clearError(input) {
      input.classList.remove("input-error");
      const errorSpan = document.getElementById("error" + input.id);
      if (errorSpan) errorSpan.textContent = "";
    }
  
    // Validate all fields
    if (fname.value.trim() === "") {
      showError(fname, "First name is required.");
    } else {
      clearError(fname);
    }
  
    if (lname.value.trim() === "") {
      showError(lname, "Last name is required.");
    } else {
      clearError(lname);
    }
  
    if (email.value.trim() === "") {
      showError(email, "Email is required.");
    } else {
      clearError(email);
    }
  
    if (phone.value.trim() === "") {
      showError(phone, "Phone Number is required.");
    } else {
      clearError(phone);
    }
  
    if (!genderChecked) {
      document.getElementById("errorGender").textContent = "Please select your gender.";
      isValid = false;
    } else {
      document.getElementById("errorGender").textContent = "";
    }
  
    if (password.value.trim() === "") {
      showError(password, "Password is required.");
    } else if (!/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[\W_]).{6,}$/.test(password.value)) {
      showError(password, "Password must include letters, numbers, and special characters.");
    } else {
      clearError(password);
    }
  
    if (cpass.value.trim() === "") {
      showError(cpass, "Confirm Password is required.");
    } else if (password.value !== cpass.value) {
      showError(cpass, "Passwords do not match.");
      cpass.classList.add("input-error");
      password.classList.add("input-error");
    } else {
      clearError(cpass);
    }
  
    if (isValid) form.submit();
  }
  
  // Remove red borders and messages as user types
  document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll("input").forEach(input => {
      input.addEventListener("input", () => {
        if (input.value.trim() !== "") {
          input.classList.remove("input-error");
          const errorSpan = document.getElementById("error" + input.id);
          if (errorSpan) errorSpan.textContent = "";
        }
      });
    });
  
    document.querySelectorAll('input[name="Gender"]').forEach(radio => {
      radio.addEventListener("change", () => {
        document.getElementById("errorGender").textContent = "";
      });
    });
  });