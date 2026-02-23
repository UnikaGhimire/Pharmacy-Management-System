const statusFilter = document.getElementById('statusFilter');
const searchFilter = document.getElementById('searchFilter');
const table = document.getElementById('billsTable');
const rows = Array.from(table.tBodies[0].rows);

function applyFilters() {
    const status = statusFilter.value.toLowerCase();
    const search = searchFilter.value.toLowerCase();

    rows.forEach(row => {
        const payment = row.cells[5].textContent.trim().toLowerCase();
        const customer = row.cells[2].textContent.trim().toLowerCase();

        const statusMatch = (status === 'all') || (payment === status);
        const searchMatch = customer.includes(search);

        row.style.display = (statusMatch && searchMatch) ? '' : 'none';
    });
}

statusFilter.addEventListener('change', applyFilters);
searchFilter.addEventListener('input', applyFilters);