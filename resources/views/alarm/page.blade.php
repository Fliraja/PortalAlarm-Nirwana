<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Alarm — {{ $unitConfig['label'] }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style id="app-styles">
        :root {
            --primary: #15a362;
            --primary-dark: #0d7a4a;
            --primary-soft: rgba(21, 163, 98, 0.12);
            --secondary: #334155;
            --accent: #facc15;
            --danger: #e11d48;
            --danger-soft: rgba(225, 29, 72, 0.12);
            --warning: #f59e0b;
            --info: #0ea5e9;
            --bg-body: #f1f5f9;
            --card-bg: #ffffff;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border-color: #cbd5e1;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Top Header */
        .navbar {
            background-color: #ffffff;
            border-bottom: 1px solid var(--border-color);
            padding: 12px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: inherit;
        }

        .navbar-brand .unit-tag {
            background-color: var(--primary);
            color: #ffffff;
            font-weight: 700;
            font-size: 0.85rem;
            padding: 4px 10px;
            border-radius: 6px;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .navbar-brand h1 {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--secondary);
        }

        .navbar-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.8rem;
            font-weight: 600;
            padding: 5px 12px;
            border-radius: 9999px;
            background: #e2e8f0;
            color: #475569;
        }

        .status-pill.active {
            background: rgba(21, 163, 98, 0.15);
            color: var(--primary-dark);
        }

        .status-pill .indicator-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: #94a3b8;
        }

        .status-pill.active .indicator-dot {
            background-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(21, 163, 98, 0.3);
            animation: pulse-dot 1.5s infinite;
        }

        @keyframes pulse-dot {
            0% { transform: scale(0.95); opacity: 0.8; }
            50% { transform: scale(1.2); opacity: 1; }
            100% { transform: scale(0.95); opacity: 0.8; }
        }

        /* Content Layout */
        .main-container {
            max-width: 1040px;
            width: 100%;
            margin: 24px auto;
            padding: 0 20px;
            display: flex;
            flex-direction: column;
            gap: 20px;
            flex-grow: 1;
        }

        /* Banner Unsupported Browser */
        .pip-unsupported-banner {
            display: none;
            background-color: #fff1f2;
            border: 1px solid #fecdd3;
            color: var(--danger);
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 0.9rem;
            align-items: center;
            gap: 10px;
        }

        /* Action Toolbar */
        .toolbar-card {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }

        .toolbar-info h2 {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--secondary);
            margin-bottom: 2px;
        }

        .toolbar-info p {
            font-size: 0.82rem;
            color: var(--text-muted);
        }

        .toolbar-buttons {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 9px 16px;
            font-size: 0.875rem;
            font-weight: 600;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: all 0.15s ease-in-out;
            text-decoration: none;
        }

        .btn-primary {
            background-color: var(--primary);
            color: #ffffff;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            transform: translateY(-1px);
        }

        .btn-outline {
            background: #ffffff;
            border: 1px solid var(--border-color);
            color: var(--secondary);
        }

        .btn-outline:hover {
            background-color: #f8fafc;
            border-color: #94a3b8;
        }

        .btn-ack {
            background-color: var(--primary);
            color: #ffffff;
            padding: 6px 14px;
            font-size: 0.82rem;
            border-radius: 6px;
        }

        .btn-ack:hover {
            background-color: var(--primary-dark);
        }

        .btn-pip-active {
            background-color: var(--danger) !important;
            color: #ffffff !important;
        }

        /* Active Alarms Section */
        .section-title {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
        }

        .section-title h3 {
            font-size: 1rem;
            font-weight: 700;
            color: var(--secondary);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .counter-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: var(--danger);
            color: #ffffff;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 9999px;
            min-width: 22px;
        }

        .counter-badge.zero {
            background: #94a3b8;
        }

        /* Alarm Cards Grid / Container */
        .alarm-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .alarm-card {
            background: #ffffff;
            border: 2px solid var(--danger);
            border-radius: 10px;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            box-shadow: 0 4px 12px rgba(225, 29, 72, 0.08);
            animation: slide-in 0.25s ease-out;
            position: relative;
            overflow: hidden;
        }

        @keyframes slide-in {
            from { opacity: 0; transform: translateY(-8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .alarm-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            width: 6px;
            background-color: var(--danger);
        }

        .alarm-card-body {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .alarm-card-header {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alarm-code {
            font-size: 1.15rem;
            font-weight: 800;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            color: var(--danger);
            letter-spacing: 0.04em;
        }

        .alarm-badge-rawat {
            background: var(--bg-body);
            color: var(--secondary);
            font-size: 0.8rem;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 4px;
            border: 1px solid var(--border-color);
        }

        .alarm-time {
            font-size: 0.8rem;
            color: var(--text-muted);
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .alarm-desc {
            font-size: 0.88rem;
            color: #334155;
            font-weight: 500;
        }

        /* Empty State */
        .empty-state {
            background: #ffffff;
            border: 1px dashed var(--border-color);
            border-radius: 12px;
            padding: 40px 24px;
            text-align: center;
            color: var(--text-muted);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
        }

        .empty-state .icon {
            font-size: 2.2rem;
            margin-bottom: 4px;
        }

        .empty-state h4 {
            font-size: 1rem;
            font-weight: 600;
            color: var(--secondary);
        }

        .empty-state p {
            font-size: 0.85rem;
        }

        /* History Table */
        .history-card {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
            margin-top: 10px;
        }

        .history-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.85rem;
            text-align: left;
        }

        .history-table th {
            background: #f8fafc;
            color: var(--text-muted);
            font-weight: 600;
            padding: 10px 16px;
            border-bottom: 1px solid var(--border-color);
        }

        .history-table td {
            padding: 12px 16px;
            border-bottom: 1px solid #f1f5f9;
            color: var(--text-main);
        }

        .history-table tr:last-child td {
            border-bottom: none;
        }

        .badge-ack-done {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--primary-dark);
            background: var(--primary-soft);
            padding: 2px 8px;
            border-radius: 4px;
        }

        /* ================= PIP FLOATING WINDOW STYLES ================= */
        .pip-window-body {
            background-color: #0f172a;
            color: #ffffff;
            padding: 12px;
            margin: 0;
            height: 100vh;
            overflow-y: auto;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .pip-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #334155;
            padding-bottom: 8px;
            position: sticky;
            top: 0;
            background-color: #0f172a;
            z-index: 10;
        }

        .pip-header-title {
            font-size: 0.95rem;
            font-weight: 700;
            color: #f8fafc;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .pip-pulse {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: #22c55e;
        }

        .pip-pulse.active {
            background-color: #ef4444;
            box-shadow: 0 0 10px #ef4444;
            animation: pip-pulse 1s infinite;
        }

        @keyframes pip-pulse {
            0% { transform: scale(0.9); opacity: 0.8; }
            50% { transform: scale(1.3); opacity: 1; }
            100% { transform: scale(0.9); opacity: 0.8; }
        }

        .pip-item {
            background: #1e293b;
            border: 1px solid #dc2626;
            border-radius: 8px;
            padding: 10px 12px;
            display: flex;
            flex-direction: column;
            gap: 6px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.4);
            animation: slide-in 0.2s ease-out;
        }

        .pip-item-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .pip-code {
            font-family: monospace;
            font-size: 1.05rem;
            font-weight: 700;
            color: #f87171;
        }

        .pip-time {
            font-size: 0.72rem;
            color: #94a3b8;
        }

        .pip-desc {
            font-size: 0.8rem;
            color: #cbd5e1;
            word-break: break-word;
        }

        .pip-btn-ack {
            background-color: #16a34a;
            color: #ffffff;
            border: none;
            border-radius: 6px;
            padding: 7px 12px;
            font-size: 0.8rem;
            font-weight: 700;
            cursor: pointer;
            margin-top: 4px;
            text-align: center;
            transition: background 0.15s ease;
        }

        .pip-btn-ack:hover {
            background-color: #15803d;
        }

        .pip-empty {
            text-align: center;
            padding: 24px 10px;
            color: #64748b;
            font-size: 0.85rem;
            margin-top: auto;
            margin-bottom: auto;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <header class="navbar">
        <a href="{{ route('home') }}" class="navbar-brand">
            <span class="unit-tag">{{ $unitConfig['label'] }}</span>
            <h1>Portal Notifikasi Alarm RS Nirwana</h1>
        </a>

        <div class="navbar-actions">
            <div id="polling-status-pill" class="status-pill active">
                <span class="indicator-dot"></span>
                <span id="polling-status-text">Monitoring Aktif ({{ (int)($pollInterval / 1000) }}s)</span>
            </div>
            <span id="clock-display" style="font-size: 0.85rem; font-weight: 600; color: var(--text-muted); font-variant-numeric: tabular-nums;">--:--:--</span>
        </div>
    </header>

    <main class="main-container">
        <!-- Guard banner for unsupported browsers -->
        <div id="pip-unsupported" class="pip-unsupported-banner">
            <span>⚠️</span>
            <span>Browser ini tidak mendukung <strong>Document Picture-in-Picture API</strong>. Untuk mode Always-on-Top mengapung di atas aplikasi Khanza, mohon gunakan <strong>Google Chrome</strong> versi 116 ke atas.</span>
        </div>

        <!-- Toolbar card -->
        <div class="toolbar-card">
            <div class="toolbar-info">
                <h2>Mode Alarm & Always-On-Top</h2>
                <p>Klik tombol untuk membuka window kecil selalu-di-atas (Picture-in-Picture) agar alarm tetap terpantau saat membuka SIMRS.</p>
            </div>
            <div class="toolbar-buttons">
                <button id="btn-test-sound" type="button" class="btn btn-outline" title="Tes audio lonceng notifikasi">
                    🔊 Tes Suara
                </button>
                <button id="btn-toggle-pip" type="button" class="btn btn-primary">
                    🪟 Aktifkan Mode Alarm (PiP)
                </button>
            </div>
        </div>

        <!-- Active alarms container -->
        <section>
            <div class="section-title">
                <h3>
                    <span>Permintaan Memerlukan Perhatian</span>
                    <span id="active-counter" class="counter-badge {{ count($activeAlarms) > 0 ? '' : 'zero' }}">{{ count($activeAlarms) }}</span>
                </h3>
                <span id="last-poll-time" style="font-size: 0.78rem; color: var(--text-muted);">Diperbarui: baru saja</span>
            </div>

            <div id="alarm-list-container" class="alarm-list">
                @forelse($activeAlarms as $alarm)
                    <div class="alarm-card" id="alarm-card-{{ $alarm->id }}" data-alarm-id="{{ $alarm->id }}">
                        <div class="alarm-card-body">
                            <div class="alarm-card-header">
                                <span class="alarm-code">{{ $alarm->kode_permintaan }}</span>
                                <span class="alarm-badge-rawat">No. Rawat: {{ $alarm->no_rawat }}</span>
                            </div>
                            <div class="alarm-time">
                                🕒 Masuk: {{ $alarm->waktu_terdeteksi?->format('H:i:s') }} ({{ $alarm->waktu_terdeteksi?->diffForHumans() }})
                            </div>
                        </div>
                        <div>
                            <button type="button" class="btn btn-ack" onclick="acknowledgeAlarm({{ $alarm->id }})">
                                ✓ Tandai Selesai
                            </button>
                        </div>
                    </div>
                @empty
                    <div id="empty-state-card" class="empty-state">
                        <div class="icon">✨</div>
                        <h4>Tidak ada permintaan baru</h4>
                        <p>Sistem siap. Halaman akan berbunyi dan menampilkan kartu merah saat order masuk.</p>
                    </div>
                @endforelse
            </div>
        </section>

        <!-- Recent History Section -->
        <section style="margin-top: 10px;">
            <div class="section-title">
                <h3 style="font-size: 0.95rem; color: var(--secondary);">
                    Riwayat Permintaan Selesai Hari Ini
                </h3>
                <span style="font-size: 0.78rem; color: var(--text-muted);">Maksimal 50 data terakhir</span>
            </div>

            <div class="history-card">
                <table class="history-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Permintaan</th>
                            <th>No. Rawat</th>
                            <th>Waktu Masuk</th>
                            <th>Waktu Selesai</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="history-tbody">
                        @forelse($todayLogs as $index => $log)
                            <tr id="history-row-{{ $log->id }}">
                                <td>{{ $index + 1 }}</td>
                                <td style="font-family: monospace; font-weight: 600;">{{ $log->kode_permintaan }}</td>
                                <td>{{ $log->no_rawat }}</td>
                                <td>{{ $log->waktu_terdeteksi?->format('H:i:s') ?? '-' }}</td>
                                <td>{{ $log->waktu_ack?->format('H:i:s') ?? '-' }}</td>
                                <td>
                                    @if($log->waktu_ack)
                                        <span class="badge-ack-done">✓ Selesai</span>
                                    @else
                                        <span style="font-size: 0.75rem; font-weight: 600; color: var(--danger); background: var(--danger-soft); padding: 2px 8px; border-radius: 4px;">Menunggu</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr id="history-empty-row">
                                <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 24px;">Belum ada riwayat permintaan hari ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <!-- Hidden audio element as fallback -->
    <audio id="alarm-audio" src="{{ asset('sounds/alarm.wav') }}" preload="auto"></audio>

    <script>
        const UNIT = @json($unit);
        const POLL_INTERVAL = {{ $pollInterval }};
        const POLL_URL = `/api/alarm/${UNIT}/poll`;

        // State tracking
        let seenAlarmIds = new Set();
        let activeAlarmsMap = new Map();
        let pipWindow = null;
        let pollingTimer = null;
        let audioContext = null;

        // Populate initial server-rendered active alarms
        @foreach($activeAlarms as $alarm)
            seenAlarmIds.add({{ $alarm->id }});
            activeAlarmsMap.set({{ $alarm->id }}, {
                id: {{ $alarm->id }},
                kode_permintaan: @json($alarm->kode_permintaan),
                no_rawat: @json($alarm->no_rawat),
                waktu_terdeteksi: @json($alarm->waktu_terdeteksi?->toIso8601String()),
                jam: @json($alarm->waktu_terdeteksi?->format('H:i:s')),
                keterangan: ''
            });
        @endforeach

        // Digital Clock
        function updateClock() {
            const now = new Date();
            document.getElementById('clock-display').textContent = now.toLocaleTimeString('id-ID', { hour12: false });
        }
        setInterval(updateClock, 1000);
        updateClock();

        // Check Picture-in-Picture Browser Support
        const isPipSupported = 'documentPictureInPicture' in window;
        if (!isPipSupported) {
            document.getElementById('pip-unsupported').style.display = 'flex';
            const btnPip = document.getElementById('btn-toggle-pip');
            btnPip.disabled = true;
            btnPip.style.opacity = '0.6';
            btnPip.title = 'Browser tidak mendukung Picture-in-Picture';
        }

        // Web Audio API Chime Synth
        function playChimeSound() {
            try {
                if (!audioContext) {
                    const AudioCtx = window.AudioContext || window.webkitAudioContext;
                    audioContext = new AudioCtx();
                }

                if (audioContext.state === 'suspended') {
                    audioContext.resume();
                }

                const now = audioContext.currentTime;

                // Tone 1: D5 (587.33 Hz)
                const osc1 = audioContext.createOscillator();
                const gain1 = audioContext.createGain();
                osc1.type = 'sine';
                osc1.frequency.setValueAtTime(587.33, now);
                gain1.gain.setValueAtTime(0.35, now);
                gain1.gain.exponentialRampToValueAtTime(0.0001, now + 0.35);
                osc1.connect(gain1);
                gain1.connect(audioContext.destination);
                osc1.start(now);
                osc1.stop(now + 0.35);

                // Tone 2: A5 (880.00 Hz)
                const osc2 = audioContext.createOscillator();
                const gain2 = audioContext.createGain();
                osc2.type = 'sine';
                osc2.frequency.setValueAtTime(880.0, now + 0.22);
                gain2.gain.setValueAtTime(0.35, now + 0.22);
                gain2.gain.exponentialRampToValueAtTime(0.0001, now + 0.75);
                osc2.connect(gain2);
                gain2.connect(audioContext.destination);
                osc2.start(now + 0.22);
                osc2.stop(now + 0.75);
            } catch (e) {
                // Fallback to <audio> tag if Web Audio API fails
                const audio = document.getElementById('alarm-audio');
                if (audio) {
                    audio.currentTime = 0;
                    audio.play().catch(() => {});
                }
            }
        }

        // Test Sound Button
        document.getElementById('btn-test-sound').addEventListener('click', () => {
            playChimeSound();
        });

        // Toggle Picture-in-Picture
        document.getElementById('btn-toggle-pip').addEventListener('click', async () => {
            if (!isPipSupported) return;

            if (pipWindow) {
                pipWindow.close();
                return;
            }

            try {
                // Initialize audio context on user gesture
                if (!audioContext) {
                    const AudioCtx = window.AudioContext || window.webkitAudioContext;
                    audioContext = new AudioCtx();
                }
                if (audioContext.state === 'suspended') {
                    await audioContext.resume();
                }

                pipWindow = await window.documentPictureInPicture.requestWindow({
                    width: 380,
                    height: 520,
                });

                // Copy styles to PiP window
                const styles = document.getElementById('app-styles');
                if (styles) {
                    const styleTag = pipWindow.document.createElement('style');
                    styleTag.textContent = styles.textContent;
                    pipWindow.document.head.appendChild(styleTag);
                }

                // Setup PiP container
                pipWindow.document.body.className = 'pip-window-body';
                renderPipWindow();

                // Button state in main window
                const btnPip = document.getElementById('btn-toggle-pip');
                btnPip.classList.add('btn-pip-active');
                btnPip.innerHTML = '✕ Tutup Mode Always-On-Top';

                // Listen for close event
                pipWindow.addEventListener('pagehide', () => {
                    pipWindow = null;
                    btnPip.classList.remove('btn-pip-active');
                    btnPip.innerHTML = '🪟 Aktifkan Mode Alarm (PiP)';
                });
            } catch (err) {
                console.error('Gagal membuka Picture-in-Picture:', err);
            }
        });

        // Render PiP Window contents
        function renderPipWindow() {
            if (!pipWindow || !pipWindow.document.body) return;

            const activeList = Array.from(activeAlarmsMap.values());
            const hasActive = activeList.length > 0;

            let html = `
                <div class="pip-header">
                    <div class="pip-header-title">
                        <span class="pip-pulse ${hasActive ? 'active' : ''}"></span>
                        <span>ALARM ${UNIT.toUpperCase()} (${activeList.length})</span>
                    </div>
                    <button style="background:transparent;border:none;color:#94a3b8;cursor:pointer;font-size:0.75rem;" onclick="window.close()">✕ Tutup</button>
                </div>
            `;

            if (!hasActive) {
                html += `
                    <div class="pip-empty">
                        <div style="font-size:1.6rem;margin-bottom:6px;">✨</div>
                        <div>Tidak ada order aktif.</div>
                        <div style="font-size:0.75rem;color:#475569;margin-top:4px;">Window ini akan otomatis berbunyi saat ada order baru.</div>
                    </div>
                `;
            } else {
                activeList.forEach((item) => {
                    html += `
                        <div class="pip-item" id="pip-item-${item.id}">
                            <div class="pip-item-head">
                                <span class="pip-code">${escapeHtml(item.kode_permintaan)}</span>
                                <span class="pip-time">${item.jam || 'Hari ini'}</span>
                            </div>
                            <div style="font-size:0.78rem;color:#94a3b8;">No. Rawat: <strong style="color:#f8fafc;">${escapeHtml(item.no_rawat)}</strong></div>
                            ${item.keterangan ? `<div class="pip-desc">${escapeHtml(item.keterangan)}</div>` : ''}
                            <button class="pip-btn-ack" onclick="window.opener.acknowledgeAlarm(${item.id})">
                                ✓ Tandai Selesai
                            </button>
                        </div>
                    `;
                });
            }

            pipWindow.document.body.innerHTML = html;
        }

        // Render Main Page Active Alarms List
        function renderMainActiveList() {
            const container = document.getElementById('alarm-list-container');
            const counter = document.getElementById('active-counter');
            const activeList = Array.from(activeAlarmsMap.values());

            counter.textContent = activeList.length;
            if (activeList.length > 0) {
                counter.classList.remove('zero');
            } else {
                counter.classList.add('zero');
            }

            if (activeList.length === 0) {
                container.innerHTML = `
                    <div id="empty-state-card" class="empty-state">
                        <div class="icon">✨</div>
                        <h4>Tidak ada permintaan baru</h4>
                        <p>Sistem siap. Halaman akan berbunyi dan menampilkan kartu merah saat order masuk.</p>
                    </div>
                `;
                return;
            }

            let html = '';
            activeList.forEach((alarm) => {
                html += `
                    <div class="alarm-card" id="alarm-card-${alarm.id}" data-alarm-id="${alarm.id}">
                        <div class="alarm-card-body">
                            <div class="alarm-card-header">
                                <span class="alarm-code">${escapeHtml(alarm.kode_permintaan)}</span>
                                <span class="alarm-badge-rawat">No. Rawat: ${escapeHtml(alarm.no_rawat)}</span>
                            </div>
                            <div class="alarm-time">
                                🕒 Masuk: ${escapeHtml(alarm.jam || 'Hari ini')}
                            </div>
                            ${alarm.keterangan ? `<div class="alarm-desc">${escapeHtml(alarm.keterangan)}</div>` : ''}
                        </div>
                        <div>
                            <button type="button" class="btn btn-ack" onclick="acknowledgeAlarm(${alarm.id})">
                                ✓ Tandai Selesai
                            </button>
                        </div>
                    </div>
                `;
            });

            container.innerHTML = html;
        }

        // Polling loop
        async function fetchPoll() {
            try {
                const res = await fetch(POLL_URL, {
                    headers: { 'Accept': 'application/json' }
                });

                if (!res.ok) {
                    console.warn('Poll response not ok:', res.status);
                    return;
                }

                const data = await res.json();
                const activeFromApi = data.active || [];
                let hasNewOrder = false;

                // Sync active map
                const currentApiIds = new Set();

                activeFromApi.forEach((item) => {
                    currentApiIds.add(item.id);

                    // Check if this ID is new
                    if (!seenAlarmIds.has(item.id)) {
                        seenAlarmIds.add(item.id);
                        hasNewOrder = true;
                    }

                    activeAlarmsMap.set(item.id, item);
                });

                // Remove alarms that were acknowledged elsewhere
                for (const existingId of activeAlarmsMap.keys()) {
                    if (!currentApiIds.has(existingId)) {
                        activeAlarmsMap.delete(existingId);
                    }
                }

                // If new order detected, trigger chime!
                if (hasNewOrder) {
                    playChimeSound();
                }

                // Update UI in main window & PiP
                renderMainActiveList();
                if (pipWindow) {
                    renderPipWindow();
                }

                document.getElementById('last-poll-time').textContent =
                    'Diperbarui: ' + new Date().toLocaleTimeString('id-ID', { hour12: false });

            } catch (err) {
                console.error('Error saat polling alarm:', err);
            }
        }

        // Acknowledge Alarm (Optimistic Update)
        async function acknowledgeAlarm(id) {
            // Optimistic update: remove immediately from map and UI
            activeAlarmsMap.delete(id);
            renderMainActiveList();
            if (pipWindow) {
                renderPipWindow();
            }

            // Update row in history table if present
            const historyRow = document.getElementById(`history-row-${id}`);
            if (historyRow) {
                const cells = historyRow.getElementsByTagName('td');
                if (cells.length >= 6) {
                    cells[4].textContent = new Date().toLocaleTimeString('id-ID', { hour12: false });
                    cells[5].innerHTML = '<span class="badge-ack-done">✓ Selesai</span>';
                }
            }

            try {
                const res = await fetch(`/api/alarm/${id}/ack`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                });

                if (!res.ok) {
                    console.warn(`Gagal acknowledge ID ${id} di server:`, res.status);
                }
            } catch (err) {
                console.error(`Error saat mengirim ack ID ${id}:`, err);
            }
        }

        // Helper escape HTML
        function escapeHtml(str) {
            if (!str) return '';
            return String(str)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        // Start polling interval
        pollingTimer = setInterval(fetchPoll, POLL_INTERVAL);
    </script>
</body>
</html>
