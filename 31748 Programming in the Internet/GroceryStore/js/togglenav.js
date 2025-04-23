/*
//toggling navigation bar
function toggleNav() {
    const dropContent = document.getElementById('contentDown');
    const dropBtn = document.querySelector('[data-toggle-nav]');
    
    dropContent.classList.toggle('show');
    dropBtn.classList.toggle('active');
}

// Close when clicking outside
document.addEventListener('click', function(event) {
    if (!event.target.closest('.dropdown')) {
        const dropContent = document.getElementById('contentDown');
        const dropBtn = document.querySelector('[data-toggle-nav]');
        
        dropContent.classList.remove('show');
        dropBtn.classList.remove('active');
    }
}); */

// Toggle navigation dropdowns
function toggleDropdown(dropdown) {
    const dropContent = dropdown.querySelector('.dropdown-content');
    const dropBtn = dropdown.querySelector('.dropbtn');
    
    // Close all other open dropdowns first
    document.querySelectorAll('.dropdown-content').forEach(content => {
        if (content !== dropContent) {
            content.classList.remove('show');
        }
    });
    
    // Toggle the clicked dropdown
    dropContent.classList.toggle('show');
    dropBtn.classList.toggle('active');
}

// Handle submenu hover (for desktop)
function setupSubmenus() {
    const submenus = document.querySelectorAll('.submenu');
    
    submenus.forEach(submenu => {
        const link = submenu.querySelector('a');
        const subContent = submenu.querySelector('.submenu-content');
        
        link.addEventListener('click', (e) => {
            if (window.innerWidth <= 768) { // Mobile behavior
                e.preventDefault();
                subContent.classList.toggle('show');
            }
            // Desktop behavior is handled by CSS hover
        });
    });
}

// Close dropdowns when clicking outside
document.addEventListener('click', function(event) {
    if (!event.target.closest('.dropdown')) {
        document.querySelectorAll('.dropdown-content').forEach(content => {
            content.classList.remove('show');
        });
        document.querySelectorAll('.dropbtn').forEach(btn => {
            btn.classList.remove('active');
        });
    }
});

// Initialize dropdown functionality
document.addEventListener('DOMContentLoaded', function() {
    // Set up click handlers for dropdown buttons
    document.querySelectorAll('.dropdown').forEach(dropdown => {
        const btn = dropdown.querySelector('.dropbtn');
        btn.addEventListener('click', () => toggleDropdown(dropdown));
    });
    
    // Set up submenu behavior
    setupSubmenus();
    
    // Make dropdowns work on touch devices
    document.querySelectorAll('.dropdown-content a').forEach(link => {
        link.addEventListener('touchend', function(e) {
            if (window.innerWidth > 768) return;
            e.preventDefault();
            window.location.href = this.href;
        });
    });
});

