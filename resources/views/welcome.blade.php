<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Alarm — RS Nirwana</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #15a362;
            --primary-dark: #0d7a4a;
            --primary-soft: rgba(21, 163, 98, 0.1);
            --secondary: #334155;
            --accent: #facc15;
            --danger: #e11d48;
            --warning: #f59e0b;
            --info: #0ea5e9;
            --bg-body: #f8fafc;
            --card-bg: #ffffff;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .container {
            width: 100%;
            max-width: 860px;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        .badge-hospital {
            display: inline-block;
            background-color: var(--primary-soft);
            color: var(--primary-dark);
            font-weight: 600;
            font-size: 0.82rem;
            padding: 6px 14px;
            border-radius: 9999px;
            letter-spacing: 0.05em;
            margin-bottom: 12px;
            border: 1px solid rgba(21, 163, 98, 0.2);
        }

        .header h1 {
            font-size: 2.1rem;
            font-weight: 700;
            color: var(--secondary);
            margin-bottom: 8px;
        }

        .header p {
            color: var(--text-muted);
            font-size: 1rem;
        }

        .units-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .unit-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 28px 24px;
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
            transition: all 0.2s ease-in-out;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
            position: relative;
            overflow: hidden;
        }

        .unit-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
            background: var(--primary);
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .unit-card:hover {
            transform: translateY(-3px);
            border-color: var(--primary);
            box-shadow: 0 10px 20px rgba(21, 163, 98, 0.1);
        }

        .unit-card:hover::before {
            opacity: 1;
        }

        .unit-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: var(--primary-soft);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 16px;
        }

        .unit-card h2 {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--secondary);
            margin-bottom: 6px;
        }

        .unit-card p {
            font-size: 0.88rem;
            color: var(--text-muted);
            line-height: 1.4;
            margin-bottom: 16px;
            flex-grow: 1;
        }

        .unit-card .action-label {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--primary);
        }

        .footer {
            text-align: center;
            font-size: 0.82rem;
            color: var(--text-muted);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <span class="badge-hospital">RS NIRWANA</span>
            <h1>Portal Notifikasi Alarm</h1>
            <p>Pilih unit kerja untuk membuka monitor notifikasi dan mengaktifkan Always-on-Top (PiP)</p>
        </div>

        <div class="units-grid">
            <a href="{{ route('alarm.page', 'lab') }}" class="unit-card">
                <div class="unit-icon">🧪</div>
                <h2>Laboratorium</h2>
                <p>Monitoring pesanan pemeriksaan lab baru dari rawat jalan dan IGD.</p>
                <span class="action-label">Buka Monitor Lab &rarr;</span>
            </a>

            <a href="{{ route('alarm.page', 'radiologi') }}" class="unit-card">
                <div class="unit-icon">🩻</div>
                <h2>Radiologi</h2>
                <p>Monitoring permintaan rontgen, USG, dan radiologi lainnya.</p>
                <span class="action-label">Buka Monitor Radiologi &rarr;</span>
            </a>

            <a href="{{ route('alarm.page', 'apotek') }}" class="unit-card">
                <div class="unit-icon">💊</div>
                <h2>Farmasi / Apotek</h2>
                <p>Monitoring resep obat dokter yang baru masuk ke sistem.</p>
                <span class="action-label">Buka Monitor Apotek &rarr;</span>
            </a>
        </div>

        <div class="footer">
            Portal Notifikasi SIMRS Khanza &bull; Khusus Jaringan Internal Rumah Sakit
        </div>
    </div>
</body>
</html>
