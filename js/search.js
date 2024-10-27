function searchBooks() {
    const input = document.getElementById('searchInput').value.toLowerCase();
    const rows = document.querySelectorAll('#booksTable tr');

    rows.forEach(row => {
        const title = row.cells[1]?.textContent.toLowerCase() || '';
        const author = row.cells[2]?.textContent.toLowerCase() || '';

        if (title.includes(input) || author.includes(input)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}
