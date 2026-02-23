document.addEventListener('DOMContentLoaded', function () {
    const filterForm = document.querySelector('.filter-form');

    // Auto-refresh page every 30 seconds
    setInterval(() => {
        filterForm.submit(); // re-apply date filter automatically
    }, 30000);
});
