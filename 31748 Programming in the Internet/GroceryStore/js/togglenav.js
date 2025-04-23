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
document.addEventListener('DOMContentLoaded', function() {
    // Toggle main dropdown
    const dropBtn = document.querySelector('.dropbtn');
    const dropContent = document.querySelector('.dropcontent');
    
    dropBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        dropContent.classList.toggle('show');
    });
    
    // Handle submenus
    const submenus = document.querySelectorAll('.submenu');
    
    submenus.forEach(submenu => {
        const link = submenu.querySelector('a');
        const subContent = submenu.querySelector('.submenu-content');
        
        link.addEventListener('click', function(e) {
            if (window.innerWidth <= 768) {
                e.preventDefault();
                subContent.classList.toggle('show');
            }
        });
    });
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function() {
        dropContent.classList.remove('show');
        
        document.querySelectorAll('.submenu-content').forEach(subContent => {
            subContent.classList.remove('show');
        });
    });
    
    // Prevent dropdown from closing when clicking inside
    dropContent.addEventListener('click', function(e) {
        e.stopPropagation();
    });
});