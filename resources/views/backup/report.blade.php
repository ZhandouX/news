<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistik Berita - Kemenkum</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.2.96/css/materialdesignicons.min.css">
    <style>
        :root {
            --kemenkum-primary: #1a237e; /* Biru tua resmi Kemenkum */
            --kemenkum-secondary: #283593;
            --kemenkum-accent: #3949ab;
            --kemenkum-light: #e8eaf6;
            --text-primary: #212121;
            --text-secondary: #757575;
            --success: #4caf50;
            --warning: #ff9800;
            --card-radius: 16px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            background-color: #f5f7fb;
            font-family: 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', sans-serif;
            padding: 20px;
            color: var(--text-primary);
        }

        .dashboard-header {
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.08);
        }

        .dashboard-title {
            color: var(--kemenkum-primary);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .statistics-container {
            background: white;
            border-radius: var(--card-radius);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            padding: 25px;
            margin-bottom: 30px;
            transition: var(--transition);
        }

        .statistics-container:hover {
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
        }

        .statistics-details {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .stat-card {
            flex: 1;
            min-width: 200px;
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: var(--transition);
            border-left: 4px solid var(--kemenkum-primary);
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(26, 35, 126, 0.15);
            border-left: 4px solid var(--kemenkum-accent);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 80px;
            height: 80px;
            background: var(--kemenkum-light);
            border-radius: 50%;
            transform: translate(30%, -30%);
            opacity: 0.5;
            z-index: 0;
        }

        .stat-header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            position: relative;
            z-index: 1;
        }

        .stat-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: var(--kemenkum-light);
            color: var(--kemenkum-primary);
            margin-right: 12px;
            font-size: 24px;
        }

        .statistics-title {
            font-weight: 600;
            color: var(--text-secondary);
            font-size: 14px;
            margin: 0;
        }

        .stat-value {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--kemenkum-primary);
            margin: 5px 0 0 0;
            position: relative;
            z-index: 1;
        }

        .stat-comparison {
            display: flex;
            align-items: center;
            margin-top: 10px;
            font-size: 13px;
            position: relative;
            z-index: 1;
        }

        .trend-indicator {
            display: inline-flex;
            align-items: center;
            padding: 4px 8px;
            border-radius: 12px;
            font-weight: 500;
            margin-right: 8px;
        }

        .trend-up {
            background: rgba(76, 175, 80, 0.15);
            color: #2e7d32;
        }

        .trend-down {
            background: rgba(244, 67, 54, 0.15);
            color: #d32f2f;
        }

        .trend-neutral {
            background: rgba(33, 150, 243, 0.15);
            color: #1565c0;
        }

        .last-period {
            color: var(--text-secondary);
        }

        .progress-container {
            margin-top: 12px;
            position: relative;
            z-index: 1;
        }

        .progress {
            height: 6px;
            background-color: #e9ecef;
            border-radius: 3px;
            overflow: hidden;
        }

        .progress-bar {
            background-color: var(--kemenkum-accent);
            border-radius: 3px;
        }

        .stat-tooltip {
            position: absolute;
            bottom: 15px;
            right: 15px;
            color: var(--text-secondary);
            cursor: pointer;
            z-index: 2;
        }

        .tooltip-content {
            visibility: hidden;
            position: absolute;
            bottom: 100%;
            right: 0;
            width: 200px;
            background: white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            padding: 12px;
            border-radius: 8px;
            font-size: 12px;
            opacity: 0;
            transition: var(--transition);
            z-index: 10;
        }

        .stat-tooltip:hover .tooltip-content {
            visibility: visible;
            opacity: 1;
            bottom: calc(100% + 10px);
        }

        /* Animasi untuk nilai statistik */
        @keyframes countUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stat-value {
            animation: countUp 0.8s ease-out;
        }

        /* Responsivitas */
        @media (max-width: 1200px) {
            .stat-card {
                min-width: 180px;
            }
        }

        @media (max-width: 992px) {
            .statistics-details {
                gap: 15px;
            }
            
            .stat-card {
                flex: 1 1 calc(50% - 15px);
                min-width: 0;
            }
        }

        @media (max-width: 768px) {
            .statistics-container {
                padding: 20px 15px;
            }
            
            .stat-card {
                flex: 1 1 100%;
            }
            
            .stat-value {
                font-size: 1.8rem;
            }
        }

        /* Tema gelap untuk preferensi sistem */
        @media (prefers-color-scheme: dark) {
            body {
                background-color: #121212;
                color: #e0e0e0;
            }
            
            .statistics-container {
                background: #1e1e1e;
                box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
            }
            
            .stat-card {
                background: #1e1e1e;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            }
            
            .statistics-title {
                color: #b0b0b0;
            }
            
            .progress {
                background-color: #2d2d2d;
            }
            
            .tooltip-content {
                background: #2d2d2d;
                color: #e0e0e0;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-header">
        <h1 class="dashboard-title">
            <i class="mdi mdi-chart-bar"></i>
            Dashboard Statistik Berita
        </h1>
        <p class="text-muted">Monitor perkembangan konten berita secara real-time</p>
    </div>

    <div class="statistics-container">
        <div class="statistics-details">
            <!-- NEWS TOTAL -->
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon">
                        <i class="mdi mdi-newspaper-variant-multiple-outline"></i>
                    </div>
                    <p class="statistics-title">Jumlah Berita</p>
                </div>
                <h3 class="stat-value">1,247</h3>
                
                <div class="progress-container">
                    <div class="progress">
                        <div class="progress-bar" style="width: 85%"></div>
                    </div>
                </div>
                
                <div class="stat-comparison">
                    <span class="trend-indicator trend-up">
                        <i class="mdi mdi-arrow-up"></i> 12.5%
                    </span>
                    <span class="last-period">vs bulan lalu</span>
                </div>
                
                <div class="stat-tooltip">
                    <i class="mdi mdi-information-outline"></i>
                    <div class="tooltip-content">
                        Jumlah total berita yang telah diterbitkan dalam sistem
                    </div>
                </div>
            </div>

            <!-- BERITA MINGGU INI -->
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon">
                        <i class="mdi mdi-calendar-week"></i>
                    </div>
                    <p class="statistics-title">Minggu Ini</p>
                </div>
                <h3 class="stat-value">42</h3>
                
                <div class="progress-container">
                    <div class="progress">
                        <div class="progress-bar" style="width: 70%"></div>
                    </div>
                </div>
                
                <div class="stat-comparison">
                    <span class="trend-indicator trend-up">
                        <i class="mdi mdi-arrow-up"></i> 8.3%
                    </span>
                    <span class="last-period">vs minggu lalu</span>
                </div>
                
                <div class="stat-tooltip">
                    <i class="mdi mdi-information-outline"></i>
                    <div class="tooltip-content">
                        Jumlah berita yang diterbitkan dalam 7 hari terakhir
                    </div>
                </div>
            </div>

            <!-- BERITA BULAN INI -->
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon">
                        <i class="mdi mdi-calendar-month"></i>
                    </div>
                    <p class="statistics-title">Bulan Ini</p>
                </div>
                <h3 class="stat-value">168</h3>
                
                <div class="progress-container">
                    <div class="progress">
                        <div class="progress-bar" style="width: 65%"></div>
                    </div>
                </div>
                
                <div class="stat-comparison">
                    <span class="trend-indicator trend-neutral">
                        <i class="mdi mdi-minus"></i> 0.5%
                    </span>
                    <span class="last-period">vs bulan lalu</span>
                </div>
                
                <div class="stat-tooltip">
                    <i class="mdi mdi-information-outline"></i>
                    <div class="tooltip-content">
                        Jumlah berita yang diterbitkan dalam bulan berjalan
                    </div>
                </div>
            </div>

            <!-- BERITA BULAN LALU -->
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon">
                        <i class="mdi mdi-calendar-arrow-left"></i>
                    </div>
                    <p class="statistics-title">Bulan Lalu</p>
                </div>
                <h3 class="stat-value">172</h3>
                
                <div class="progress-container">
                    <div class="progress">
                        <div class="progress-bar" style="width: 75%"></div>
                    </div>
                </div>
                
                <div class="stat-comparison">
                    <span class="trend-indicator trend-down">
                        <i class="mdi mdi-arrow-down"></i> 5.2%
                    </span>
                    <span class="last-period">vs 2 bulan lalu</span>
                </div>
                
                <div class="stat-tooltip">
                    <i class="mdi mdi-information-outline"></i>
                    <div class="tooltip-content">
                        Jumlah berita yang diterbitkan pada bulan sebelumnya
                    </div>
                </div>
            </div>

            <!-- BERITA TAHUN INI -->
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon">
                        <i class="mdi mdi-calendar-blank"></i>
                    </div>
                    <p class="statistics-title">Tahun Ini</p>
                </div>
                <h3 class="stat-value">1,048</h3>
                
                <div class="progress-container">
                    <div class="progress">
                        <div class="progress-bar" style="width: 60%"></div>
                    </div>
                </div>
                
                <div class="stat-comparison">
                    <span class="trend-indicator trend-up">
                        <i class="mdi mdi-arrow-up"></i> 15.7%
                    </span>
                    <span class="last-period">vs tahun lalu</span>
                </div>
                
                <div class="stat-tooltip">
                    <i class="mdi mdi-information-outline"></i>
                    <div class="tooltip-content">
                        Jumlah berita yang diterbitkan sejak awal tahun
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Animasi untuk counting up (jika diperlukan)
        document.addEventListener('DOMContentLoaded', function() {
            const statValues = document.querySelectorAll('.stat-value');
            
            statValues.forEach(value => {
                const originalText = value.textContent;
                value.textContent = '0';
                
                setTimeout(() => {
                    value.textContent = originalText;
                }, 500);
            });
            
            // Tooltip initialization
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
</body>
</html>