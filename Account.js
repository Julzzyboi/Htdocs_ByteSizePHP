
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

  // COUNTER

  const inputFirstName = document.getElementById("Fname") 
    const remainingFirstName = document.getElementById("remainingFN")
    const inputLastName = document.getElementById("Lname") 
    const remainingLastName = document.getElementById("remainingLN")

    const FN = () => {
        updateCounterFN()
    }

    inputFirstName.addEventListener("keyup", FN)
    updateCounterFN()

    function updateCounterFN(){
        remainingFirstName.innerText = inputFirstName.getAttribute("maxlength") - inputFirstName.value.length
    }

    const LN = () => {
        updateCounterLN()
    }

    inputLastName.addEventListener("keyup", LN)
    updateCounterLN()

    function updateCounterLN(){
        remainingLastName.innerText = inputLastName.getAttribute("maxlength") - inputLastName.value.length
    }


    //LOGIN
    function validateLogin(event) {
      event.preventDefault();
  
      const email = document.getElementById('LogEmail').value.trim();
      const password = document.getElementById('LogPass').value.trim();
  
      if (!email || !password) {
          showModal("Please fill in all fields.");
          return;
      }
  
      fetch('Account.php', {
          method: 'POST',
          headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: `action=login&LogEmail=${encodeURIComponent(email)}&LogPassword=${encodeURIComponent(password)}`
      })
      .then(response => {
          if (!response.ok) {
              throw new Error("Server error");
          }
          return response.json();
      })
      .then(data => {
          if (data.success) {
              // Successful login
              window.location.href = data.role === 'admin' ? 'admin_home.php' : 'customer_home.php';
          } else {
              // Show error message
              showModal(data.message || "Login failed.");
          }
      })
      .catch(error => {
          console.error('Login error:', error);
          showModal("An unexpected error occurred. Try again.");
      });
  }
  
  function showModal(message) {
      document.getElementById('modalMessage').textContent = message;
      document.getElementById('overlay').style.display = 'block';
      document.getElementById('modal').style.display = 'block';
  }
  
  function closeModal() {
      document.getElementById('modal').style.display = 'none';
      document.getElementById('overlay').style.display = 'none';
  }
  
  
