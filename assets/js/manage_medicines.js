document.addEventListener('DOMContentLoaded', () => {
    const statusFilter = document.getElementById('statusFilter');
    const categoryFilter = document.getElementById('categoryFilter');
    const searchFilter = document.getElementById('searchFilter');
    const table = document.querySelector('.data-table');
    if (!table) return;

    const rows = Array.from(table.tBodies[0].rows);

    function applyFilters() {
        const status = statusFilter.value.toLowerCase();
        const category = categoryFilter.value.toLowerCase();
        const search = searchFilter.value.toLowerCase();

        rows.forEach(row => {
            const rowStatus = row.dataset.status.toLowerCase();
            const rowCategory = row.dataset.category.toLowerCase();
            const name = row.cells[1].textContent.toLowerCase();

            const statusMatch = (status === 'all') || (rowStatus === status);
            const categoryMatch = (category === 'all') || (rowCategory === category);
            const searchMatch = name.includes(search);

            row.style.display = (statusMatch && categoryMatch && searchMatch) ? '' : 'none';
        });
    }

    statusFilter.addEventListener('change', applyFilters);
    categoryFilter.addEventListener('change', applyFilters);
    searchFilter.addEventListener('input', applyFilters);
});
