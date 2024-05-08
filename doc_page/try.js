// admin_script.js

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

// Function to toggle between read-only and editable states
function toggleEdit() {
  const inputs = document.querySelectorAll('.edit-input');
  const editBtn = document.getElementById('editBtn');
  const saveBtn = document.getElementById('saveBtn');

  inputs.forEach(input => {
    input.readOnly = !input.readOnly;
    input.classList.toggle('editable'); // Add or remove 'editable' class
  });

  editBtn.style.display = 'none';
  saveBtn.style.display = 'block';
}

// Call toggleSidebar() when the page loads to collapse the sidebar by default
window.addEventListener('load', function() {
  // Ensure sidebar starts collapsed when the page loads
  const sidebar = document.querySelector('.sidebar');
  if (!sidebar.classList.contains('collapsed')) {
    toggleSidebar();
  }

  // Attach event listener to "Edit Details" button after the page is fully loaded
  document.getElementById('editBtn').addEventListener('click', function() {
    toggleEdit();
  });
});


