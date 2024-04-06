function handleButtonClick(value) {
    if (value === 'Admin') {
      login('Admin'); // Call the login function for Admin
    } else if (value === 'Student') {
      window.location.href = 'g12signup.html';
    }
  }

  function login(role) {
    if (role === 'user') {
      document.getElementById('choice-container').style.display = 'block';
    } else if (role === 'Admin') {
      var password = prompt("Enter admin password:");
      if (password === "admin1") {
        alert("Admin login successful!");
        window.location.href = './admin/posts.php';
      } else {
        alert("Incorrect password. Try again.");
      }
    }
    hidePopup(); // Assuming you have this function to hide any popups
  }