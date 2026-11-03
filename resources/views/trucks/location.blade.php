@extends($layout)

@section('title', 'Truck Location')

@section('headers')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css">
    <style>
        .loc-head { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; }
        .loc-truck { display: flex; align-items: center; gap: .9rem; }
        .loc-truck .truck-icon { width: 3rem; height: 3rem; border-radius: 12px; display: inline-flex; align-items: center; justify-content: center; background: var(--brand-50); color: var(--brand); font-size: 1.15rem; }
        .loc-truck h2 { font-size: 1.15rem; margin: 0; }
        .loc-truck .meta { color: var(--muted); font-size: .82rem; margin-top: .15rem; }
        .loc-truck .meta span + span::before { content: "·"; margin: 0 .45rem; }
        .loc-actions { display: flex; gap: .5rem; flex-wrap: wrap; }

        .loc-status { display: inline-flex; align-items: center; gap: .45rem; font-size: .78rem; font-weight: 600; padding: .3rem .7rem; border-radius: 999px; }
        .loc-status::before { content: ""; width: .5rem; height: .5rem; border-radius: 50%; background: currentColor; }
        .loc-status.fresh { background: var(--brand-50); color: var(--brand-700); }
        .loc-status.stale { background: #fbf3e2; color: #9a6a0c; }

        #truckMap { flex: 1; min-height: 460px; border-radius: var(--radius-sm); z-index: 0; }
        .map-card .card-body { padding: .75rem; display: flex; flex-direction: column; }

        .gps-list { list-style: none; margin: 0; padding: 0; }
        .gps-list li { display: flex; align-items: center; justify-content: space-between; gap: 1rem; padding: .7rem 0; border-bottom: 1px solid var(--line); }
        .gps-list li:last-child { border-bottom: 0; }
        .gps-list .k { display: flex; align-items: center; gap: .6rem; color: var(--ink-2); font-size: .84rem; }
        .gps-list .k i { width: 1.9rem; height: 1.9rem; border-radius: 8px; background: var(--line-2); color: var(--ink-2); display: inline-flex; align-items: center; justify-content: center; font-size: .78rem; }
        .gps-list .v { color: var(--ink); font-weight: 600; font-size: .88rem; text-align: right; font-variant-numeric: tabular-nums; }
        .gps-list .v small { color: var(--muted); font-weight: 500; }
        .coords { font-family: ui-monospace, SFMono-Regular, Consolas, monospace; font-size: .82rem; }

        .truck-pin { width: 38px; height: 38px; border-radius: 50% 50% 50% 0; background: var(--brand); transform: rotate(-45deg); display: flex; align-items: center; justify-content: center; box-shadow: 0 6px 14px rgba(11, 86, 64, .35); border: 3px solid #fff; }
        .truck-pin i { transform: rotate(45deg); color: #fff; font-size: 14px; }
        .leaflet-popup-content { font-family: var(--font); font-size: .82rem; }

        .empty-state { text-align: center; padding: 3.5rem 1rem; }
        .empty-state .icon { width: 4rem; height: 4rem; border-radius: 50%; background: var(--line-2); color: var(--muted); display: inline-flex; align-items: center; justify-content: center; font-size: 1.4rem; margin-bottom: 1rem; }
        .empty-state h3 { font-size: 1.05rem; }
        .empty-state p { color: var(--muted); max-width: 26rem; margin: 0 auto; }
    </style>
@endsection

@section('content')
@php
    $hdopLabel = function ($h) {
        if ($h === null) return '—';
        if ($h <= 1) return 'Ideal';
        if ($h <= 2) return 'Excellent';
        if ($h <= 5) return 'Good';
        if ($h <= 10) return 'Moderate';
        return 'Poor';
    };
    $isFresh = $latest && $latest->recorded_at->gt(now()->subMinutes(15));
@endphp

<div class="card mb-4">
    <div class="card-body loc-head">
        <div class="loc-truck">
            <span class="truck-icon"><i class="fas fa-truck"></i></span>
            <div>
                <h2>{{ $truck->plate_number }}</h2>
                <div class="meta">
                    <span>{{ $truck->truck_model }}</span>
                    <span>{{ $truck->driver_name ?: 'No driver assigned' }}{{ $truck->driver_id_no ? ' (' . $truck->driver_id_no . ')' : '' }}</span>
                </div>
            </div>
        </div>
        <div class="loc-actions">
            @if ($latest)
                <span class="loc-status {{ $isFresh ? 'fresh' : 'stale' }} align-self-center">
                    {{ $isFresh ? 'Live' : 'Last seen' }} {{ $latest->recorded_at->diffForHumans() }}
                </span>
                <a class="btn btn-secondary" target="_blank" rel="noopener"
                    href="https://www.google.com/maps?q={{ $latest->latitude }},{{ $latest->longitude }}">
                    <i class="fas fa-external-link-alt"></i> Open in Google Maps
                </a>
                <a class="btn btn-secondary" href="{{ url()->current() }}"><i class="fas fa-sync-alt"></i> Refresh</a>
            @endif
            <a class="btn btn-primary" href="{{ $backUrl }}"><i class="fas fa-arrow-left"></i> Back to trucks</a>
        </div>
    </div>
</div>

@if (!$latest)
    <div class="card">
        <div class="card-body empty-state">
            <span class="icon"><i class="fas fa-map-marker-alt"></i></span>
            <h3>No location data yet</h3>
            <p>There are no GPS readings for {{ $truck->plate_number }} in the system. Once the truck's tracker reports in, its position will appear here.</p>
        </div>
    </div>
@else
    <div class="row">
        <div class="col-xl-8 mb-4">
            <div class="card map-card h-100">
                <div class="card-body">
                    <div id="truckMap"></div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 mb-4">
            <div class="card h-100">
                <div class="card-header">Latest position</div>
                <div class="card-body py-2">
                    <ul class="gps-list">
                        <li><span class="k"><i class="fas fa-map-pin"></i> Latitude</span><span class="v coords">{{ number_format($latest->latitude, 7) }}</span></li>
                        <li><span class="k"><i class="fas fa-map-pin"></i> Longitude</span><span class="v coords">{{ number_format($latest->longitude, 7) }}</span></li>
                        <li><span class="k"><i class="fas fa-mountain"></i> Altitude</span><span class="v">{{ $latest->altitude !== null ? number_format($latest->altitude, 1) : '—' }} <small>m</small></span></li>
                        <li><span class="k"><i class="fas fa-tachometer-alt"></i> Speed</span><span class="v">{{ $latest->speed !== null ? number_format($latest->speed, 2) : '—' }} <small>km/h</small></span></li>
                        <li><span class="k"><i class="fas fa-compass"></i> Heading</span><span class="v">{{ $latest->course !== null ? number_format($latest->course, 0) . '°' : '—' }} <small>{{ $latest->direction }}</small></span></li>
                        <li><span class="k"><i class="fas fa-satellite"></i> Satellites</span><span class="v">{{ $latest->satellites ?? '—' }}</span></li>
                        <li><span class="k"><i class="fas fa-bullseye"></i> Accuracy (HDOP)</span><span class="v">{{ $latest->hdop ?? '—' }} <small>{{ $hdopLabel($latest->hdop) }}</small></span></li>
                        <li><span class="k"><i class="far fa-clock"></i> Recorded</span><span class="v">{{ $latest->recorded_at->format('d M Y, H:i:s') }}</span></li>
                        <li><span class="k"><i class="fas fa-cloud-download-alt"></i> Received</span><span class="v">{{ \Illuminate\Support\Carbon::parse($latest->created_at)->format('d M Y, H:i:s') }}</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Recent readings</span>
            <small class="text-muted font-weight-normal">Latest {{ $readings->count() }}</small>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Recorded</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th>Altitude (m)</th>
                            <th>Speed (km/h)</th>
                            <th>Heading</th>
                            <th>Satellites</th>
                            <th>HDOP</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($readings as $r)
                            <tr>
                                <td>{{ $r->recorded_at->format('d M Y, H:i:s') }}</td>
                                <td class="coords">{{ number_format($r->latitude, 7) }}</td>
                                <td class="coords">{{ number_format($r->longitude, 7) }}</td>
                                <td>{{ $r->altitude !== null ? number_format($r->altitude, 1) : '—' }}</td>
                                <td>{{ $r->speed !== null ? number_format($r->speed, 2) : '—' }}</td>
                                <td>{{ $r->course !== null ? number_format($r->course, 0) . '°' : '—' }} {{ $r->direction }}</td>
                                <td>{{ $r->satellites ?? '—' }}</td>
                                <td>{{ $r->hdop ?? '—' }}</td>
                                <td class="text-right">
                                    <button type="button" class="btn btn-primary btn-sm js-focus"
                                        data-lat="{{ $r->latitude }}" data-lng="{{ $r->longitude }}">
                                        Show <i class="fas fa-crosshairs"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif
@endsection

@section('footers')
    @if ($latest)
        <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>
        <script>
            (function () {
                var latest = [{{ $latest->latitude }}, {{ $latest->longitude }}];
                var track = @json($readings->map(fn ($r) => [(float) $r->latitude, (float) $r->longitude])->reverse()->values());

                var map = L.map('truckMap', { scrollWheelZoom: false }).setView(latest, 16);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; OpenStreetMap contributors'
                }).addTo(map);

                if (track.length > 1) {
                    L.polyline(track, { color: '#13795b', weight: 4, opacity: .55 }).addTo(map);
                }

                var icon = L.divIcon({
                    className: '',
                    html: '<div class="truck-pin"><i class="fas fa-truck"></i></div>',
                    iconSize: [38, 38],
                    iconAnchor: [19, 38],
                    popupAnchor: [0, -36]
                });
                L.marker(latest, { icon: icon }).addTo(map)
                    .bindPopup('<strong>{{ e($truck->plate_number) }}</strong><br>{{ $latest->recorded_at->format('d M Y, H:i:s') }}')
                    .openPopup();

                L.circle(latest, {
                    radius: Math.max({{ (float) ($latest->hdop ?? 1) }} * 5, 5),
                    color: '#13795b', weight: 1, fillOpacity: .08
                }).addTo(map);

                var focus = null;
                document.querySelectorAll('.js-focus').forEach(function (btn) {
                    btn.addEventListener('click', function () {
                        var p = [parseFloat(btn.dataset.lat), parseFloat(btn.dataset.lng)];
                        if (focus) map.removeLayer(focus);
                        focus = L.circleMarker(p, { radius: 7, color: '#fff', weight: 2, fillColor: '#2f6fb5', fillOpacity: 1 }).addTo(map);
                        map.setView(p, 18);
                        document.getElementById('truckMap').scrollIntoView({ behavior: 'smooth', block: 'center' });
                    });
                });
            })();
        </script>
    @endif
@endsection
