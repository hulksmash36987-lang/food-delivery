// Adjust API_BASE if backend is in a different path
const API_BASE = "http://localhost/food%20delivery%20system/backend/auth";

/// After successful login or signup
const redirectUser = (role) => {
  switch(role) {
    case 'customer':
      window.location.href = "customer/customer_dashboard.html";
      break;
    case 'restaurant':
      window.location.href = "restaurant/owner_dashboard.html";
      break;
    case 'admin':
      window.location.href = "admin/admin_dashboard.html";
      break;
    default:
      window.location.href = "index.html";
  }
};

// Signup form
document.getElementById("signupForm")?.addEventListener("submit", async (e) => {
  e.preventDefault();
  
  const submitBtn = e.target.querySelector('button[type="submit"]');
  const btnText = submitBtn.querySelector('.signup-text');
  const loading = submitBtn.querySelector('.loading');
  
  // Show loading state
  btnText.classList.add('hidden');
  loading.classList.remove('hidden');
  submitBtn.disabled = true;
  
  const formData = new FormData(e.target);

  try {
    const response = await fetch(`${API_BASE}/register.php`, {
      method: "POST",
      body: formData
    });
    const result = await response.json();
    alert(result.message);
    if (result.success) redirectUser(formData.get('role'));
  } catch (error) {
    alert("Network error. Please try again.");
  } finally {
    // Reset button state
    btnText.classList.remove('hidden');
    loading.classList.add('hidden');
    submitBtn.disabled = false;
  }
});

// Login form
document.getElementById("loginForm")?.addEventListener("submit", async (e) => {
  e.preventDefault();
  
  const submitBtn = e.target.querySelector('button[type="submit"]');
  const btnText = submitBtn.querySelector('.login-text');
  const loading = submitBtn.querySelector('.loading');
  
  // Show loading state
  btnText.classList.add('hidden');
  loading.classList.remove('hidden');
  submitBtn.disabled = true;
  
  const formData = new FormData(e.target);

  try {
    const response = await fetch(`${API_BASE}/login.php`, {
      method: "POST",
      body: formData
    });
    const result = await response.json();
    if (result.success) {
      localStorage.setItem("user", JSON.stringify(result));
      alert("Login successful!");
      redirectUser(result.role);
    } else {
      alert(result.message);
    }
  } catch (error) {
    alert("Network error. Please try again.");
  } finally {
    // Reset button state
    btnText.classList.remove('hidden');
    loading.classList.add('hidden');
    submitBtn.disabled = false;
  }
});