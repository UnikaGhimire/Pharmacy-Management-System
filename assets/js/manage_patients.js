const searchFilter = document.getElementById('searchFilter');
const table = document.getElementById('patientsTable');
if(table) {
    const rows = Array.from(table.tBodies[0].rows);

    searchFilter.addEventListener('input', () => {
        const search = searchFilter.value.toLowerCase();

        rows.forEach(row => {
            const name = row.cells[1].textContent.toLowerCase();
            const email = row.cells[2].textContent.toLowerCase();
            const match = name.includes(search) || email.includes(search);
            row.style.display = match ? '' : 'none';
        });
    });
}
