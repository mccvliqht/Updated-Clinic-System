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


