function fetchNewsYearly() {
    const sumberEl = document.getElementById('sumber');
    const yearEl = document.getElementById('year');
    if (!sumberEl || !yearEl) return;

    let sumber = sumberEl.value;
    let year = yearEl.value;

    fetch("{{ route('super-admin.news.filter-sumber.yearly.list') }}?sumber=" + sumber + "&year=" + year, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
        .then(res => res.json())
        .then(data => {
            let html = '';
            if (data.length > 0) {
                data.forEach(news => {
                    const shortTitle = news.title.length > 70 ? news.title.substring(0, 70) + '...' : news.title;

                    const newsDate = new Date(news.news_date);
                    const formattedDate = newsDate.toLocaleDateString('id-ID', {
                        weekday: 'short',
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric'
                    });

                    html += `
                            <div class="col-12">
                                <div class="modern-news-card" data-id="${news.id}">
                                    <div class="news-content">
                                        <div class="news-image-container">
                                            <img src="/storage/${news.cover_image}" class="news-image" alt="${news.title}">
                                            <div class="news-source-badge">${news.source || 'Kantor'}</div>
                                        </div>
                                        <div class="news-details">
                                            <h5 class="news-title">${shortTitle}</h5>
                                            <p class="news-date">
                                                <i class="fa fa-calendar me-1"></i> ${formattedDate}
                                            </p>
                                            <div class="news-actions">
                                                <button class="btn-action btn-preview" title="Pratinjau">
                                                    <i class="fa fa-info"></i>
                                                </button>
                                                <button class="btn-action btn-share" title="Bagikan">
                                                    <i class="fa fa-share-alt"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                });
            } else {
                html = `
                        <div class="col-12">
                            <div class="no-news-state">
                                <i class="far fa-newspaper"></i>
                                <p>Tidak ada berita untuk kantor & tahun yang dipilih.</p>
                            </div>
                        </div>`;
            }
            document.getElementById('newsListYearly').innerHTML = html;
            attachNewsCardEvents();
        });
}

function attachNewsCardEvents() {
    const newsCards = document.querySelectorAll('.modern-news-card');
    newsCards.forEach(card => {
        card.addEventListener('mouseenter', function () {
            this.style.transform = 'translateY(-5px)';
            this.style.boxShadow = '0 12px 20px rgba(0,0,0,0.15)';
        });
        card.addEventListener('mouseleave', function () {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '0 4px 12px rgba(0,0,0,0.1)';
        });
        card.addEventListener('click', function () {
            const newsId = this.getAttribute('data-id');
            console.log('News ID:', newsId);
        });
    });
}

document.getElementById('sumber').addEventListener('change', fetchNewsYearly);
document.getElementById('year').addEventListener('input', fetchNewsYearly);