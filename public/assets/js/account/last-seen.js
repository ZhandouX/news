// Fungsi update status & progress
function refreshOfficerStatus() {
    fetch("{{ route('super-admin.news.officer-status') }}")
        .then(response => response.json())
        .then(data => {
            data.forEach(admin => {
                const row = document.querySelector('tr[data-id="' + admin.id + '"]');
                if (row) {
                    // Update news count
                    const newsCell = row.querySelector('td:nth-child(4)');
                    newsCell.textContent = admin.news_count;

                    // Update status
                    const status = row.querySelector('.status');
                    status.textContent = admin.isOnline ? 'Online' : 'Offline';
                    status.classList.toggle('text-success', admin.isOnline);
                    status.classList.toggle('text-danger', !admin.isOnline);
                }
            });
        });
}

// Refresh setiap 10 detik
setInterval(refreshOfficerStatus, 10000);