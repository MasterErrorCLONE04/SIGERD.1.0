<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte Mensual SIGERD - {{ $month }} {{ $year }}</title>
    <style>
        @page {
            margin: 0;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            color: #1a202c;
            line-height: 1.5;
            background-color: #ffffff;
        }

        /* Utilidades */
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-bold { font-weight: bold; }
        .uppercase { text-transform: uppercase; }
        .text-slate-500 { color: #64748b; }
        .text-slate-400 { color: #94a3b8; }
        
        /* Portada */
        .cover-page {
            height: 100%;
            position: relative;
            background-color: #ffffff;
            color: #1a202c;
            padding: 40px;
            text-align: center;
            border: 1px solid #e2e8f0; /* Borde sutil para delimitar la portada en blanco */
        }

        .cover-logo {
            margin-top: 100px;
            margin-bottom: 40px;
        }

        .cover-logo img {
            height: 100px;
            width: auto;
        }

        .cover-title {
            font-size: 32pt;
            font-weight: 800;
            margin-bottom: 10px;
            letter-spacing: -1px;
            color: #1a202c;
        }

        .cover-subtitle {
            font-size: 18pt;
            font-weight: 400;
            color: #64748b;
            margin-bottom: 60px;
        }

        .cover-details {
            margin-top: 100px;
            border-top: 1px solid #e2e8f0;
            padding-top: 40px;
            display: inline-block;
            width: 80%;
        }

        .cover-detail-item {
            margin-bottom: 15px;
            font-size: 12pt;
        }

        .cover-footer {
            position: absolute;
            bottom: 40px;
            left: 0;
            right: 0;
            font-size: 10pt;
            color: #64748b;
        }

        /* Estructura de Páginas Internas */
        .page {
            padding: 2.54cm;
            position: relative;
        }

        .page-break {
            page-break-after: always;
        }

        .header {
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 10px;
            margin-bottom: 30px;
        }

        .header-logo {
            float: left;
            height: 35px;
        }

        .header-text {
            float: right;
            text-align: right;
            font-size: 9pt;
            color: #64748b;
        }

        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }

        .section-title {
            font-size: 16pt;
            font-weight: bold;
            color: #1a202c;
            margin-bottom: 20px;
            border-left: 4px solid #1a202c;
            padding-left: 15px;
        }

        /* Métricas */
        .metrics-grid {
            margin-bottom: 30px;
        }

        .metric-card {
            width: 22%;
            float: left;
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 15px;
            margin-right: 2%;
            text-align: center;
        }

        .metric-card:last-child {
            margin-right: 0;
        }

        .metric-label {
            font-size: 8pt;
            color: #64748b;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .metric-value {
            font-size: 18pt;
            font-weight: 800;
            color: #1e293b;
        }

        /* Gráficos */
        .chart-box {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 25px;
        }

        .chart-header {
            font-size: 11pt;
            font-weight: bold;
            margin-bottom: 15px;
            color: #475569;
        }

        .bar-row {
            margin-bottom: 12px;
        }

        .bar-info {
            font-size: 9pt;
            margin-bottom: 4px;
        }

        .bar-label { float: left; font-weight: 600; }
        .bar-count { float: right; color: #64748b; }

        .bar-outer {
            height: 12px;
            background-color: #f1f5f9;
            border-radius: 6px;
            overflow: hidden;
            width: 100%;
        }

        .bar-inner {
            height: 100%;
            border-radius: 6px;
        }

        .bg-critica { background-color: #991b1b; }
        .bg-alta { background-color: #dc2626; }
        .bg-media { background-color: #d97706; }
        .bg-baja { background-color: #059669; }
        .bg-primary { background-color: #1a202c; }

        /* Tabla de Tareas */
        .tasks-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 9pt;
        }

        .tasks-table th {
            background-color: #ffffff;
            color: #1a202c;
            font-weight: bold;
            text-align: left;
            padding: 10px;
            border-bottom: 2px solid #1a202c;
        }

        .tasks-table td {
            padding: 10px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 7pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .badge-critica { background-color: #fee2e2; color: #991b1b; }
        .badge-alta { background-color: #fee2e2; color: #b91c1c; }
        .badge-media { background-color: #fef3c7; color: #92400e; }
        .badge-baja { background-color: #dcfce7; color: #166534; }

        /* Firmas */
        .signatures {
            margin-top: 60px;
        }

        .signature-box {
            width: 40%;
            float: left;
            text-align: center;
        }

        .signature-line {
            border-top: 1px solid #1a202c;
            margin-top: 40px;
            padding-top: 10px;
        }

        .footer {
            position: absolute;
            bottom: 40px;
            left: 2.54cm;
            right: 2.54cm;
            font-size: 8pt;
            color: #94a3b8;
            border-top: 1px solid #f1f5f9;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <!-- PÁGINA 1: PORTADA -->
    <div class="cover-page page-break">
        <div class="cover-logo">
            <img src="{{ public_path('logo/logo.jpg') }}" alt="SIGERD">
        </div>
        <h1 class="cover-title">INFORME MENSUAL DE GESTIÓN</h1>
        <p class="cover-subtitle">Sistema de Gestión de Reportes y Documentación</p>
        
        <div class="cover-details">
            <div class="cover-detail-item">
                <span class="text-slate-400">PERÍODO:</span> 
                <span class="text-bold">{{ $month }} {{ $year }}</span>
            </div>
            <div class="cover-detail-item">
                <span class="text-slate-400">FECHA DE EMISIÓN:</span> 
                <span class="text-bold">{{ $generatedDate }}</span>
            </div>
            <div class="cover-detail-item">
                <span class="text-slate-400">ESTADO DEL SISTEMA:</span> 
                <span class="text-bold">OPERATIVO</span>
            </div>
        </div>

        <div class="cover-footer">
            SIGERD v2.0 &copy; {{ date('Y') }} - Documento de Uso Administrativo
        </div>
    </div>

    <!-- PÁGINA 2: RESUMEN Y ESTADÍSTICAS -->
    <div class="page page-break">
        <div class="header clearfix">
            <img src="{{ public_path('logo/logo.jpg') }}" class="header-logo">
            <div class="header-text">
                Reporte de Gestión - {{ $month }} {{ $year }}<br>
                SIGERD | Página 2
            </div>
        </div>

        <h2 class="section-title">Resumen de Indicadores Clave (KPIs)</h2>
        
        <div class="metrics-grid clearfix">
            <div class="metric-card">
                <div class="metric-label">Total Tareas</div>
                <div class="metric-value">{{ $totalTasks }}</div>
            </div>
            <div class="metric-card">
                <div class="metric-label">Finalizadas</div>
                <div class="metric-value">{{ $totalFinished }}</div>
            </div>
            <div class="metric-card">
                <div class="metric-label">Cumplimiento</div>
                <div class="metric-value">{{ $completionRate }}%</div>
            </div>
            <div class="metric-card">
                <div class="metric-label">Eficiencia (Días)</div>
                <div class="metric-value">{{ $avgCompletionDays }}</div>
            </div>
        </div>

        <div class="chart-box">
            <div class="chart-header">Desglose por Prioridad del Mes</div>
            @php
                $maxPriority = max((array)$tasksByPriority) ?: 1;
            @endphp
            
            @foreach($tasksByPriority as $priority => $count)
                <div class="bar-row">
                    <div class="bar-info clearfix">
                        <span class="bar-label uppercase">{{ $priority }}</span>
                        <span class="bar-count">{{ $count }} tareas</span>
                    </div>
                    <div class="bar-outer">
                        <div class="bar-inner bg-{{ $priority }}" style="width: {{ ($count / $maxPriority) * 100 }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="chart-box">
            <div class="chart-header">Estado Actual del Flujo de Trabajo</div>
            @php
                $maxStatus = max((array)$tasksByStatus) ?: 1;
            @endphp
            
            @foreach($tasksByStatus as $status => $count)
                @if($count > 0)
                <div class="bar-row">
                    <div class="bar-info clearfix">
                        <span class="bar-label uppercase">{{ $status }}</span>
                        <span class="bar-count">{{ $count }} tareas</span>
                    </div>
                    <div class="bar-outer">
                        <div class="bar-inner bg-primary" style="width: {{ ($count / $maxStatus) * 100 }}%"></div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>

        <div class="footer">
            SIGERD - Documento generado automáticamente por el sistema de gestión.
        </div>
    </div>

    <!-- PÁGINA 3: DESEMPEÑO Y DETALLE -->
    <div class="page">
        <div class="header clearfix">
            <img src="{{ public_path('logo/logo.jpg') }}" class="header-logo">
            <div class="header-text">
                Reporte de Gestión - {{ $month }} {{ $year }}<br>
                SIGERD | Página 3
            </div>
        </div>

        <h2 class="section-title">Análisis de Desempeño Técnico</h2>
        
        @if($tasksByWorker->count() > 0)
            <table class="tasks-table">
                <thead>
                    <tr>
                        <th style="width: 10%">Rank</th>
                        <th style="width: 40%">Técnico Responsable</th>
                        <th style="width: 25%; text-align: center;">T. Asignadas</th>
                        <th style="width: 25%; text-align: center;">T. Finalizadas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tasksByWorker as $index => $item)
                        <tr>
                            <td class="text-bold">#{{ $loop->iteration }}</td>
                            <td>{{ $item['worker']->name ?? 'N/A' }}</td>
                            <td class="text-center">{{ $item['count'] }}</td>
                            <td class="text-center text-bold">{{ $item['finished'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-slate-500">No hay datos de trabajadores registrados para este periodo.</p>
        @endif

        <h2 class="section-title" style="margin-top: 40px;">Registro de Tareas Finalizadas</h2>
        
        <table class="tasks-table">
            <thead>
                <tr>
                    <th style="width: 35%">Descripción</th>
                    <th style="width: 25%">Técnico</th>
                    <th style="width: 20%; text-align: center;">Prioridad</th>
                    <th style="width: 20%; text-align: center;">Finalización</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tasks->take(15) as $task)
                    <tr>
                        <td class="text-bold">{{ Str::limit($task->title, 40) }}</td>
                        <td>{{ $task->assignedTo->name ?? 'N/A' }}</td>
                        <td class="text-center">
                            <span class="badge badge-{{ $task->priority }}">{{ $task->priority }}</span>
                        </td>
                        <td class="text-center">{{ $task->updated_at->format('d/m/Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-slate-400">No hay tareas finalizadas registradas para listar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
        @if($tasks->count() > 15)
            <p style="font-size: 8pt; color: #94a3b8; margin-top: 10px;">* Se muestran solo las últimas 15 tareas finalizadas. Para el registro completo, consulte el panel administrativo.</p>
        @endif

        <div class="signatures clearfix">
            <div class="signature-box" style="margin-right: 20%;">
                <div class="signature-line">
                    <span class="text-bold">Administrador General</span><br>
                    <span style="font-size: 8pt;">Control y Supervisión</span>
                </div>
            </div>
            <div class="signature-box">
                <div class="signature-line">
                    <span class="text-bold">Responsable de Mantenimiento</span><br>
                    <span style="font-size: 8pt;">Validación Técnica</span>
                </div>
            </div>
        </div>

        <div class="footer">
            SIGERD - Documento generado automáticamente por el sistema de gestión.
        </div>
    </div>
</body>
</html>