@extends('layouts.dashboard')

@section('title', 'Dashboard - Gimnasio Pro')
@section('page-title', 'Dashboard')

@section('styles')
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        margin-bottom: 28px;
    }

    .stat-card {
        background: #fff;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        padding: 22px;
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .stat-icon svg { width: 24px; height: 24px; }

    .stat-icon.blue   { background: #eff6ff; color: #3b82f6; }
    .stat-icon.green  { background: #f0fdf4; color: #22c55e; }
    .stat-icon.purple { background: #faf5ff; color: #a855f7; }
    .stat-icon.orange { background: #fff7ed; color: #f97316; }

    .stat-info h3 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #111827;
        line-height: 1;
        margin-bottom: 4px;
    }

    .stat-info p {
        font-size: 0.8rem;
        color: #6b7280;
        font-weight: 500;
    }

    .charts-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 20px;
        margin-bottom: 28px;
    }

    .chart-card {
        background: #fff;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        padding: 22px;
    }

    .chart-card h2 {
        font-size: 0.95rem;
        font-weight: 600;
        color: #111827;
        margin-bottom: 4px;
    }

    .chart-card p {
        font-size: 0.78rem;
        color: #9ca3af;
        margin-bottom: 18px;
    }

    .chart-container {
        position: relative;
        width: 100%;
        height: 280px;
    }

    .activity-card {
        background: #fff;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        padding: 22px;
    }

    .activity-card h2 {
        font-size: 0.95rem;
        font-weight: 600;
        color: #111827;
        margin-bottom: 16px;
    }

    .activity-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 0;
        border-bottom: 1px solid #f3f4f6;
    }

    .activity-item:last-child { border-bottom: none; }

    .activity-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .activity-dot.green  { background: #22c55e; }
    .activity-dot.blue   { background: #3b82f6; }
    .activity-dot.orange { background: #f97316; }

    .activity-text {
        flex: 1;
        font-size: 0.82rem;
        color: #374151;
    }

    .activity-time {
        font-size: 0.72rem;
        color: #9ca3af;
        white-space: nowrap;
    }

    .activity-empty {
        text-align: center;
        padding: 20px;
        color: #9ca3af;
        font-size: 0.82rem;
    }

    @media (max-width: 900px) {
        .charts-grid { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
    {{-- Stats --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" /></svg>
            </div>
            <div class="stat-info">
                <h3>{{ $clientesActivos }}</h3>
                <p>Clientes Activos</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon green">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
            </div>
            <div class="stat-info">
                <h3>${{ number_format($ingresosMes, 2) }}</h3>
                <p>Ingresos del Mes</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon purple">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" /></svg>
            </div>
            <div class="stat-info">
                <h3>{{ $totalProductos }}</h3>
                <p>Productos en Stock</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon orange">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" /></svg>
            </div>
            <div class="stat-info">
                <h3>{{ $ventasHoy }}</h3>
                <p>Ventas Hoy</p>
            </div>
        </div>
    </div>

    {{-- Charts --}}
    <div class="charts-grid">
        <div class="chart-card">
            <h2>Ingresos del Mes</h2>
            <p>Ingresos semanales de {{ \Carbon\Carbon::now()->locale('es')->isoFormat('MMMM YYYY') }}</p>
            <div class="chart-container">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        <div class="chart-card">
            <h2>Membresías Activas</h2>
            <p>Distribución por tipo de plan</p>
            <div class="chart-container">
                <canvas id="membershipsChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Actividad reciente --}}
    <div class="activity-card">
        <h2>Actividad Reciente del Mes</h2>

        @if ($ultimosPagos->count() > 0 || $ultimasVentas->count() > 0)
            @foreach ($ultimosPagos as $pago)
                <div class="activity-item">
                    <div class="activity-dot green"></div>
                    <span class="activity-text">Pago registrado: <strong>${{ number_format($pago->monto, 2) }} - {{ $pago->tipo_membresia }}</strong> · {{ $pago->cliente->nombre ?? 'Cliente' }}</span>
                    <span class="activity-time">{{ \Carbon\Carbon::parse($pago->fecha_pago)->locale('es')->diffForHumans() }}</span>
                </div>
            @endforeach

            @foreach ($ultimasVentas as $venta)
                <div class="activity-item">
                    <div class="activity-dot blue"></div>
                    <span class="activity-text">Venta realizada: <strong>${{ number_format($venta->total, 2) }}</strong> · {{ $venta->cliente->nombre ?? 'Cliente' }}</span>
                    <span class="activity-time">{{ \Carbon\Carbon::parse($venta->fecha_venta)->locale('es')->diffForHumans() }}</span>
                </div>
            @endforeach
        @else
            <div class="activity-empty">Sin actividad registrada este mes.</div>
        @endif
    </div>
@endsection

@section('scripts')
{{-- Chart.js CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>

<script>
    // Ingresos semanales - Bar Chart
    new Chart(document.getElementById('revenueChart'), {
        type: 'bar',
        data: {
            labels: @json($ingresosLabels),
            datasets: [{
                label: 'Ingresos ($)',
                data: @json($ingresosData),
                backgroundColor: '#4f46e5',
                borderRadius: 6,
                maxBarThickness: 40
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#f3f4f6' },
                    ticks: {
                        font: { family: 'Inter', size: 11 },
                        color: '#9ca3af',
                        callback: function(v) { return '$' + v.toLocaleString(); }
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: {
                        font: { family: 'Inter', size: 11 },
                        color: '#9ca3af'
                    }
                }
            }
        }
    });

    // Membresías - Doughnut Chart
    var mLabels = @json($membresiaLabels);
    var mData = @json($membresiaData);

    if (mLabels.length > 0) {
        new Chart(document.getElementById('membershipsChart'), {
            type: 'doughnut',
            data: {
                labels: mLabels,
                datasets: [{
                    data: mData,
                    backgroundColor: ['#4f46e5', '#22c55e', '#f97316', '#3b82f6'],
                    borderWidth: 0,
                    spacing: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: { family: 'Inter', size: 11 },
                            color: '#6b7280',
                            padding: 16,
                            usePointStyle: true,
                            pointStyleWidth: 8
                        }
                    }
                }
            }
        });
    }
</script>
@endsection
