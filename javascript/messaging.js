// Function to toggle the visibility of the contacts section
function toggleContacts() {
    var contactsSection = document.getElementById('view-contacts-table');
    var headingSection = document.getElementById('view-contacts-heading');

    console.log('Toggling contacts visibility'); // Debugging line
    
    // Toggle both the table and heading visibility
    if (contactsSection.style.display === 'none' || contactsSection.style.display === '') {
        contactsSection.style.display = 'block';
        headingSection.style.display = 'block';
    } else {
        contactsSection.style.display = 'none';
        headingSection.style.display = 'none';
    }
}


// Function to show the modal with contacts
function showContactsModal() {
    const modal = document.getElementById('contactsModal');
    modal.style.display = 'block'; // Show modal
}

// Function to close the modal
function closeContactsModal() {
    const modal = document.getElementById('contactsModal');
    modal.style.display = 'none'; // Hide modal
}

// Close the modal when the user clicks outside the modal content
window.onclick = function(event) {
    const modal = document.getElementById('contactsModal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
}

// Toggle the sidebar
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    if (sidebar.style.width === '250px') {
        sidebar.style.width = '0';
    } else {
        sidebar.style.width = '250px';
    }
}


