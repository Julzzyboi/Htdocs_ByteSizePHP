
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

    // for login
    function validateLogin(event) {
      event.preventDefault(); // Stop form from submitting normally
    
      const email = document.getElementById("LogEmail").value.trim();
      const password = document.getElementById("LogPass").value.trim();
      const errorEmail = document.getElementById("errorLogEmail");
      const errorPassword = document.getElementById("errorLogPass");
    
      // Clear previous error messages
      errorEmail.textContent = "";
      errorPassword.textContent = "";
    
      let isValid = true;
    
      if (email === "") {
        errorEmail.textContent = "Email is required.";
        isValid = false;
      }
      if (password === "") {
        errorPassword.textContent = "Password is required.";
        isValid = false;
      }
    
      if (!isValid) {
        return; // Don't proceed if frontend validation failed
      }
    
      // AJAX: send to PHP
      const xhr = new XMLHttpRequest();
      xhr.open("POST", "login_handler.php", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    
      xhr.onload = function() {
        if (xhr.status === 200) {
          const response = JSON.parse(xhr.responseText);
          
          if (response.success) {
            showModal("Login successful! Redirecting...");
            setTimeout(function() {
              if (response.role === "admin") {
                window.location.href = "admin.php";
              } else {
                window.location.href = "customer_home.php";
              }
            }, 1500); // wait 1.5s to show success before redirect
          } else {
            showModal(response.errorMessage);
          }
        }
      };
      
    
      const data = `LogEmail=${encodeURIComponent(email)}&LogPassword=${encodeURIComponent(password)}`;
      xhr.send(data);
    }
    
    function showModal(message) {
      document.getElementById("modalMessage").textContent = message;
      document.getElementById("modal").style.display = "block";
      document.getElementById("overlay").style.display = "block";
    }
    
    function closeModal() {
      document.getElementById("modal").style.display = "none";
      document.getElementById("overlay").style.display = "none";
    }
    
  // For login form validation
// document.querySelector('.Login form').addEventListener('submit', function(event) {
//   const email = document.getElementById('LogEmail').value.trim();
//   const password = document.getElementById('LogPass').value.trim();

//   if (email === '' || password === '') {
//     event.preventDefault(); // Prevent the form from submitting
//     if (email === '') {
//       document.getElementById('errorLogEmail').textContent = "Email is required.";
//     }
//     if (password === '') {
//       document.getElementById('errorLogPass').textContent = "Password is required.";
//     }
//   }
// });

// For signup form (since you already use onsubmit="validateForm(event)" there)
// make sure validateForm(event) also calls event.preventDefault() if fields are empty.
