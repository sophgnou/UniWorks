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
});
