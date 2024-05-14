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



$(document).ready(function(){
  // Click event handler for edit icon
  $('.edit-icon').click(function(){
      // Get the edit form associated with the clicked edit icon
      var editForm = $(this).closest('form');

      // Toggle visibility of the status input field
      editForm.find('.edit-status').toggle().focus();
  });

  // Click event handler for delete icon
  $('.delete-icon').click(function(){
      // Get the ID of the record to be deleted
      var recordId = $(this).closest('form').find('input[name="recordId"]').val();
      
      // Send an AJAX request to delete the record
      $.ajax({
          url: window.location.href, // URL of the current page
          method: 'POST',
          data: { recordId: recordId }, // Data to be sent to the server
          success: function(response){
              // If deletion is successful, remove the table row from the HTML table
              if(response == 'success'){
                  $('[data-id="' + recordId + '"]').remove();
              } else {
                  // Handle error if deletion fails
                  alert('Error deleting record!');
              }
          }
      });
  });

  // Click event handler for status input field
  $('.edit-status').blur(function(){
      // Get the ID and new status of the record to be updated
      var recordId = $(this).closest('form').find('input[name="recordId"]').val();
      var newStatus = $(this).val();

      // Send an AJAX request to update the record
      $.ajax({
          url: window.location.href, // URL of the current page
          method: 'POST',
          data: { recordId: recordId, status: newStatus }, // Data to be sent to the server
          success: function(response){
              // No need for alert here
          }
      });
  });
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
  // Additional form validation can be added here if necessary
  // Toggle off edit mode upon form submission to reflect changes immediately
  toggleEditMode();
});

// Event listener for the form submission
document.getElementById('editAccountForm').addEventListener('submit', function(event) {
  // Prevent the default form submission behavior
  event.preventDefault();

});


$(document).ready(function() {
  $('#changePasswordForm').submit(function(event) {
      // Prevent default form submission
      event.preventDefault();

      // Get form data
      var formData = $(this).serialize();

      // Reference to the form
      var form = $(this);

      // Send AJAX request to handle password change
      $.ajax({
          type: 'POST',
          url: 'account_details.php', // Update the URL to the PHP file handling password change
          data: formData,
          success: function(response) {
              // Display success or error message
              if (response.includes("Password updated successfully!")) {
                  form.trigger("reset");
                  alert("Your password has been successfully updated.");
              } else if (response.includes("Current password is incorrect.")) {
                  alert("The current password you entered is incorrect. Please try again.");
              } else if (response.includes("New password and confirm password do not match.")) {
                  alert("The new password and confirm password do not match. Please make sure they are the same.");
              } else {
                  alert("An error occurred. Please try again later.");
              }
          }
      });
  });
});



