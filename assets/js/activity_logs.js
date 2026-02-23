document.addEventListener('DOMContentLoaded', function () {
    const dateFilter = document.getElementById('filter_date');
    const userFilter = document.getElementById('filter_user');
    const actionFilter = document.getElementById('filter_action');
    const tableBody = document.getElementById('logs_body');
    const rows = tableBody.querySelectorAll('tr');
    const emptyState = document.getElementById('empty_state');

    function filterTable() {
        const dateText = dateFilter.value;
        const userText = userFilter.value.toLowerCase();
        const actionText = actionFilter.value.toLowerCase();
        let visibleCount = 0;

        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            const date = cells[0]?.textContent || '';
            const user = cells[2]?.textContent.toLowerCase() || '';
            const action = cells[3]?.textContent.toLowerCase() || '';

            const matchesDate = !dateText || date === dateText;
            const matchesUser = user.includes(userText);
            const matchesAction = action.includes(actionText);

            if (matchesDate && matchesUser && matchesAction) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        emptyState.style.display = visibleCount ? 'none' : 'block';
    }

    // Listen to all filters
    dateFilter.addEventListener('input', filterTable);
    userFilter.addEventListener('input', filterTable);
    actionFilter.addEventListener('input', filterTable);

    // Auto-refresh every 30 seconds
    setInterval(() => location.reload(), 30000);
});
