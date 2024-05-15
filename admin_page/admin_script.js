// Function to toggle the sidebar
function toggleSidebar() {
  const sidebar = document.querySelector('.sidebar');
  const content = document.querySelector('.content');
  const navbarTitle = document.getElementById('navbarTitle');

  // Disable transition temporarily for both sidebar and content
  sidebar.style.transition = 'none';
  content.style.transition = 'none';
  
  sidebar.classList.toggle('collapsed');
  content.classList.toggle('expanded');

  if (sidebar.classList.contains('collapsed')) {
    navbarTitle.style.display = 'none';
  } else {
    navbarTitle.style.display = 'block';
  }

  // Re-enable transition after a short delay
  setTimeout(() => {
    sidebar.style.transition = '';
    content.style.transition = '';
    
    // Adjust content's margin-left after transition re-enabled
    const contentMargin = sidebar.classList.contains('collapsed') ? '50px' : '250px';
    content.style.marginLeft = contentMargin;
  }, 50);
}

// Call toggleSidebar() when the page loads to collapse the sidebar by default
window.addEventListener('load', function() {
  // Ensure sidebar starts collapsed when the page loads
  const sidebar = document.querySelector('.sidebar');
  if (!sidebar.classList.contains('collapsed')) {
    toggleSidebar();
  }
});

// Function to toggle edit mode
function toggleEditMode() {
  const editBtn = document.getElementById('editButton');
  const saveBtn = document.getElementById('saveBtn');
  const inputs = document.querySelectorAll('.edit-input');

  if (editBtn.style.display !== 'none') {
    // Enable input fields
    inputs.forEach(input => {
      input.removeAttribute('readonly');
    });
    // Hide the edit button and show the save button
    editBtn.style.display = 'none';
    saveBtn.style.display = 'inline-block';
  } else {
    // Disable input fields
    inputs.forEach(input => {
      input.setAttribute('readonly', 'readonly');
    });
    // Hide the save button and show the edit button
    editBtn.style.display = 'inline-block';
    saveBtn.style.display = 'none';
  }
}

// Event listener for the edit button
document.getElementById('editButton').addEventListener('click', function(event) {
  // Call the toggleEditMode function
  toggleEditMode();
});

// Ensure the form is submitted correctly when saving changes
document.getElementById('editAccountForm').addEventListener('submit', function(event) {
  // Prevent the default form submission behavior
  event.preventDefault();

  // Additional form validation can be added here if necessary
  // Toggle off edit mode upon form submission to reflect changes immediately
  toggleEditMode();

  // Get form data
  var formData = $(this).serialize();

  // Reference to the form
  var form = $(this);

  // Send AJAX request to handle form submission
  $.ajax({
    type: 'POST',
    url: 'account_details.php', // Update the URL to the PHP file handling form submission
    data: formData,
    success: function(response) {
      // Display success or error message
      if (response === "success") {
        alert("Changes saved successfully!");
      } else {
        alert("Failed to save changes. Please try again later.");
      }
    },
    error: function(xhr, status, error) {
      // Display error message if AJAX request fails
      console.error('Error:', error);
      alert("An error occurred. Please try again later.");
    }
    
  });
});


