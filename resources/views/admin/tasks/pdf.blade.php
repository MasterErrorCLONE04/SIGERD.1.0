<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Tareas - {{ $month }} {{ $year }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Normas APA - Tipografía y Espaciado */
        body {
            font-family: 'DejaVu Serif', 'Times New Roman', Times, serif;
            font-size: 12pt;
            color: #000000;
            line-height: 2;
            background: #ffffff;
        }

        .page-wrapper {
            padding: 0;
            margin: 0;
        }

        /* Numeración de Página (APA) */
        .page-number {
            position: fixed;
            top: 15mm;
            right: 20mm;
            font-size: 11pt;
            color: #333333;
        }

        /* Portada APA */
        .title-page {
            text-align: center;
            margin-top: 100mm;
            page-break-after: always;
        }

        .title-page h1 {
            font-size: 16pt;
            font-weight: bold;
            margin-bottom: 20pt;
            color: #000000;
        }

        .title-page .subtitle {
            font-size: 14pt;
            margin-bottom: 40pt;
            color: #333333;
        }

        .title-page .institution {
            font-size: 12pt;
            margin-bottom: 10pt;
            color: #000000;
        }

        .title-page .date {
            font-size: 12pt;
            color: #333333;
        }

        /* Header de Contenido (APA) */
        .content-header {
            text-align: center;
            padding: 20mm 0 10mm 0;
            border-bottom: 2px solid #000000;
            margin-bottom: 15mm;
        }

        .content-header h1 {
            font-size: 16pt;
            font-weight: bold;
            margin-bottom: 5pt;
            color: #000000;
        }

        .content-header .period {
            font-size: 12pt;
            color: #333333;
            font-style: italic;
        }

        /* Resumen Ejecutivo (APA) */
        .executive-summary {
            margin: 0 20mm 15mm 20mm;
            text-align: justify;
            text-indent: 12.7mm;
            line-height: 2;
        }

        .executive-summary p {
            margin-bottom: 10pt;
            font-size: 12pt;
            color: #000000;
        }

        .executive-summary strong {
            font-weight: bold;
        }

        /* Sección (APA - Nivel 1) */
        .section-level-1 {
            font-size: 14pt;
            font-weight: bold;
            text-align: center;
            margin: 20pt 0 10pt 0;
            color: #000000;
        }

        /* Sección (APA - Nivel 2) */
        .section-level-2 {
            font-size: 12pt;
            font-weight: bold;
            text-align: left;
            margin: 15pt 0 8pt 0;
            color: #000000;
        }

        /* Contenedor de Gráficos */
        .charts-container {
            margin: 15mm 20mm;
        }

        /* Cuadro de Estadísticas Clave */
        .key-metrics {
            width: calc(100% - 40mm);
            border: 2px solid #000000;
            margin: 10mm 20mm;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .key-metrics tr {
            border: 1px solid #666666;
        }

        .key-metrics td {
            padding: 8pt 12pt;
            border: 1px solid #666666;
        }

        .metric-label {
            background: #f5f5f5;
            font-weight: bold;
            width: 65%;
            font-size: 11pt;
            vertical-align: middle;
        }

        .metric-value {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            width: 35%;
            background: #ffffff;
            vertical-align: middle;
        }

        /* Gráfico de Barras Horizontal */
        .bar-chart {
            margin: 15mm 20mm;
            padding: 10mm;
            border: 1px solid #cccccc;
            background: #fafafa;
            width: calc(100% - 40mm);
            box-sizing: border-box;
        }

        .chart-title {
            font-size: 12pt;
            font-weight: bold;
            text-align: center;
            margin-bottom: 10pt;
            color: #000000;
        }

        .chart-subtitle {
            font-size: 10pt;
            text-align: center;
            margin-bottom: 15pt;
            color: #666666;
            font-style: italic;
        }

        .bar-item {
            margin-bottom: 12pt;
        }

        .bar-label-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            margin-bottom: 4pt;
        }

        .bar-label {
            font-size: 10pt;
            font-weight: bold;
            color: #000000;
            flex: 0 0 auto;
        }

        .bar-value {
            text-align: right;
            font-size: 11pt;
            font-weight: bold;
            flex: 0 0 auto;
        }

        .bar-container {
            width: 100%;
            height: 20pt;
            background: #e0e0e0;
            border: 1px solid #999999;
            position: relative;
        }

        .bar-fill {
            height: 100%;
            background: #2563eb;
            position: relative;
        }

        .bar-fill-alta {
            background: #dc2626;
        }

        .bar-fill-media {
            background: #f59e0b;
        }

        .bar-fill-baja {
            background: #059669;
        }

        .bar-percentage {
            position: absolute;
            right: 5pt;
            top: 50%;
            transform: translateY(-50%);
            color: #ffffff;
            font-size: 9pt;
            font-weight: bold;
        }

        /* Gráfico Circular (Pie Chart) */
        .pie-chart-container {
            text-align: center;
            margin: 15mm 20mm;
            padding: 10mm;
            border: 1px solid #cccccc;
            background: #fafafa;
            width: calc(100% - 40mm);
            box-sizing: border-box;
        }

        .pie-chart {
            display: inline-block;
            width: 150pt;
            height: 150pt;
            border-radius: 50%;
            margin: 10pt auto;
        }

        .pie-legend {
            margin-top: 15pt;
            text-align: left;
            display: inline-block;
        }

        .legend-item {
            margin-bottom: 8pt;
            font-size: 10pt;
        }

        .legend-color {
            display: inline-block;
            width: 12pt;
            height: 12pt;
            margin-right: 6pt;
            border: 1px solid #666666;
            vertical-align: middle;
        }

        .legend-alta {
            background: #dc2626;
        }

        .legend-media {
            background: #f59e0b;
        }

        .legend-baja {
            background: #059669;
        }

        .legend-text {
            vertical-align: middle;
            font-weight: bold;
        }

        .legend-percentage {
            color: #666666;
            font-size: 9pt;
        }

        /* Tabla de Desempeño de Trabajadores (APA) */
        .worker-performance-table {
            margin: 10mm auto;
            width: calc(100% - 40mm);
            border-collapse: collapse;
            border: 2px solid #000000;
            table-layout: fixed;
        }

        .worker-performance-table thead {
            background: #e0e0e0;
        }

        .worker-performance-table th {
            padding: 8pt;
            border: 1px solid #666666;
            font-size: 11pt;
            font-weight: bold;
            text-align: left;
            vertical-align: middle;
        }

        .worker-performance-table td {
            padding: 8pt;
            border: 1px solid #666666;
            font-size: 10pt;
            vertical-align: middle;
        }

        .worker-performance-table .rank-cell {
            text-align: center;
            font-weight: bold;
            background: #f5f5f5;
        }

        .worker-performance-table .count-cell {
            text-align: center;
            font-weight: bold;
        }

        /* Tabla de Tareas Detallada (APA) */
        .table-container {
            margin: 10mm 20mm;
            width: calc(100% - 40mm);
        }

        .tasks-table {
            width: 100%;
            border-collapse: collapse;
            border: 2px solid #000000;
            table-layout: fixed;
        }

        .tasks-table thead {
            background: #d0d0d0;
        }

        .tasks-table th {
            padding: 8pt;
            text-align: left;
            font-size: 10pt;
            font-weight: bold;
            border: 1px solid #666666;
            vertical-align: middle;
        }

        .tasks-table td {
            padding: 6pt 8pt;
            border: 1px solid #666666;
            font-size: 9pt;
            line-height: 1.5;
            vertical-align: middle;
            word-wrap: break-word;
        }

        .tasks-table tbody tr:nth-child(even) {
            background: #f5f5f5;
        }

        .table-caption {
            font-size: 11pt;
            font-style: italic;
            text-align: left;
            margin-bottom: 5pt;
            margin-left: 20mm;
        }

        /* Badges Profesionales */
        .badge {
            display: inline-block;
            padding: 2pt 6pt;
            border: 1px solid #000000;
            font-size: 8pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .badge-alta {
            background: #ffcccc;
            color: #000000;
        }

        .badge-media {
            background: #ffe5cc;
            color: #000000;
        }

        .badge-baja {
            background: #ccffcc;
            color: #000000;
        }

        /* Figura */
        .figure {
            margin: 15mm 20mm;
            text-align: center;
        }

        .figure-caption {
            font-size: 10pt;
            font-style: italic;
            margin-top: 8pt;
            text-align: center;
        }

        /* Referencias y Notas (APA) */
        .references {
            margin: 20mm 20mm 10mm 20mm;
            page-break-before: always;
        }

        .reference-entry {
            margin-bottom: 10pt;
            text-indent: -12.7mm;
            padding-left: 12.7mm;
            line-height: 2;
            font-size: 12pt;
        }

        /* Notas al pie */
        .footnote {
            font-size: 10pt;
            margin-top: 15mm;
            padding-top: 5mm;
            border-top: 1px solid #000000;
        }

        .no-tasks {
            text-align: center;
            padding: 40mm 20mm;
            font-size: 12pt;
            color: #666666;
        }

        .page-break {
            page-break-after: always;
        }

        /* Configuración de Página APA */
        @page {
            margin: 25.4mm;
            margin-top: 25.4mm;
            margin-bottom: 25.4mm;
        }

        /* Párrafos con sangría APA */
        .paragraph {
            text-indent: 12.7mm;
            text-align: justify;
            margin-bottom: 0;
            line-height: 2;
        }

        .paragraph-no-indent {
            text-indent: 0;
            text-align: justify;
            margin-bottom: 0;
            line-height: 2;
        }

        /* Espaciado entre secciones */
        .section-spacing {
            margin-bottom: 15mm;
        }
    </style>
</head>
<body>
    {{-- PORTADA (Página 1) --}}
    <div class="title-page">
        <h1>INFORME DE GESTIÓN DE TAREAS</h1>
        <div class="subtitle">Análisis del Período {{ $month }} {{ $year }}</div>
        <div class="institution">SIGERD</div>
        <div class="institution">Sistema de Gestión de Reportes y Documentación</div>
        <div class="date">{{ $generatedDate }}</div>
    </div>

    {{-- CONTENIDO (Página 2 en adelante) --}}
    <div class="content-header">
        <h1>Informe de Tareas Finalizadas</h1>
        <div class="period">{{ $month }} {{ $year }}</div>
    </div>

    @if($totalTasks > 0)
        {{-- RESUMEN EJECUTIVO --}}
        <h2 class="section-level-1">Resumen Ejecutivo</h2>
        
        <div class="executive-summary">
            <p>El presente informe detalla el análisis de las tareas finalizadas durante el período de {{ $month }} {{ $year }}, en el marco del Sistema de Gestión de Reportes y Documentación (SIGERD). El estudio comprende un total de <strong>{{ $totalTasks }} tareas completadas</strong>, con una participación de <strong>{{ $tasksByWorker->count() }} trabajadores</strong> y un tiempo promedio de ejecución de <strong>{{ $avgCompletionDays }} días</strong>.</p>
            
            <p>Los datos recopilados muestran la distribución por niveles de prioridad, el desempeño individual de los trabajadores y las tendencias operacionales del período. Este documento se estructura siguiendo las normas de presentación profesional y académica, facilitando la comprensión objetiva de los resultados obtenidos.</p>
        </div>

        {{-- MÉTRICAS CLAVE --}}
        <h2 class="section-level-1 section-spacing">Indicadores Clave de Desempeño</h2>

        <table class="key-metrics">
            <tr>
                <td class="metric-label">Total de Tareas Finalizadas</td>
                <td class="metric-value">{{ $totalTasks }}</td>
            </tr>
            <tr>
                <td class="metric-label">Tiempo Promedio de Ejecución (días)</td>
                <td class="metric-value">{{ $avgCompletionDays }}</td>
            </tr>
            <tr>
                <td class="metric-label">Trabajadores Participantes</td>
                <td class="metric-value">{{ $tasksByWorker->count() }}</td>
            </tr>
            <tr>
                <td class="metric-label">Tasa de Cumplimiento</td>
                <td class="metric-value">100%</td>
            </tr>
        </table>

        {{-- ANÁLISIS DE DISTRIBUCIÓN POR PRIORIDAD --}}
        <div class="page-break"></div>
        
        <h2 class="section-level-1">Análisis de Distribución por Prioridad</h2>

        <p class="paragraph-no-indent" style="margin: 10mm 20mm 15mm 20mm;">La clasificación de tareas según su nivel de prioridad permite identificar la distribución de esfuerzos y recursos durante el período analizado. La Figura 1 presenta la distribución porcentual de las tareas finalizadas según tres categorías: alta, media y baja prioridad.</p>

        {{-- Gráfico de Barras Horizontales --}}
        <div class="figure">
            <div class="bar-chart">
                <div class="chart-title">Distribución de Tareas por Nivel de Prioridad</div>
                <div class="chart-subtitle">n = {{ $totalTasks }} tareas</div>
                
                @php
                    $maxTasks = max($tasksByPriority['alta'], $tasksByPriority['media'], $tasksByPriority['baja']);
                    $totalForPercentage = $totalTasks > 0 ? $totalTasks : 1;
                    $percentageAlta = round(($tasksByPriority['alta'] / $totalForPercentage) * 100, 1);
                    $percentageMedia = round(($tasksByPriority['media'] / $totalForPercentage) * 100, 1);
                    $percentageBaja = round(($tasksByPriority['baja'] / $totalForPercentage) * 100, 1);
                @endphp

                <div class="bar-item">
                    <div class="bar-label-row">
                        <div class="bar-label">Alta Prioridad</div>
                        <div class="bar-value" style="color: #dc2626;">{{ $tasksByPriority['alta'] }} tareas ({{ $percentageAlta }}%)</div>
                    </div>
                    <div class="bar-container">
                        <div class="bar-fill bar-fill-alta" style="width: {{ $maxTasks > 0 ? ($tasksByPriority['alta'] / $maxTasks * 100) : 0 }}%;">
                            <span class="bar-percentage">{{ $percentageAlta }}%</span>
                        </div>
                    </div>
                </div>

                <div class="bar-item">
                    <div class="bar-label-row">
                        <div class="bar-label">Media Prioridad</div>
                        <div class="bar-value" style="color: #f59e0b;">{{ $tasksByPriority['media'] }} tareas ({{ $percentageMedia }}%)</div>
                    </div>
                    <div class="bar-container">
                        <div class="bar-fill bar-fill-media" style="width: {{ $maxTasks > 0 ? ($tasksByPriority['media'] / $maxTasks * 100) : 0 }}%;">
                            <span class="bar-percentage">{{ $percentageMedia }}%</span>
                        </div>
                    </div>
                </div>

                <div class="bar-item">
                    <div class="bar-label-row">
                        <div class="bar-label">Baja Prioridad</div>
                        <div class="bar-value" style="color: #059669;">{{ $tasksByPriority['baja'] }} tareas ({{ $percentageBaja }}%)</div>
                    </div>
                    <div class="bar-container">
                        <div class="bar-fill bar-fill-baja" style="width: {{ $maxTasks > 0 ? ($tasksByPriority['baja'] / $maxTasks * 100) : 0 }}%;">
                            <span class="bar-percentage">{{ $percentageBaja }}%</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="figure-caption">Figura 1. Distribución porcentual de tareas finalizadas según nivel de prioridad.</div>
        </div>

        @php
            if($tasksByPriority['alta'] >= $tasksByPriority['media'] && $tasksByPriority['alta'] >= $tasksByPriority['baja']) {
                $priorityText = "la mayoría de las tareas finalizadas corresponden a alta prioridad ({$percentageAlta}%), lo que refleja una gestión enfocada en la atención de asuntos críticos";
            } elseif($tasksByPriority['media'] >= $tasksByPriority['alta'] && $tasksByPriority['media'] >= $tasksByPriority['baja']) {
                $priorityText = "la mayoría de las tareas finalizadas corresponden a media prioridad ({$percentageMedia}%), lo que sugiere un balance operacional";
            } else {
                $priorityText = "la mayoría de las tareas finalizadas corresponden a baja prioridad ({$percentageBaja}%), indicando un enfoque en mantenimiento preventivo";
            }
        @endphp
        <p class="paragraph" style="margin: 10mm 20mm;">Los resultados indican que {{ $priorityText }} durante el período analizado.</p>

        {{-- DESEMPEÑO DE TRABAJADORES --}}
        @if($tasksByWorker->count() > 0)
            <h2 class="section-level-1 section-spacing">Análisis de Desempeño del Personal</h2>

            <p class="paragraph-no-indent" style="margin: 10mm 20mm 15mm 20mm;">La Tabla 1 presenta el ranking de trabajadores según el número de tareas finalizadas durante el período. Este indicador permite identificar los niveles de productividad individual y la contribución de cada miembro del equipo a los objetivos organizacionales.</p>

            <div class="table-caption">Tabla 1</div>
            <div class="table-caption" style="margin-bottom: 8pt;">Desempeño de Trabajadores por Número de Tareas Finalizadas</div>

            <table class="worker-performance-table">
                <thead>
                    <tr>
                        <th style="width: 10%; text-align: center;">Ranking</th>
                        <th style="width: 50%;">Nombre del Trabajador</th>
                        <th style="width: 20%; text-align: center;">Tareas Completadas</th>
                        <th style="width: 20%; text-align: center;">Porcentaje (%)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tasksByWorker as $index => $item)
                        @php
                            $workerPercentage = $totalTasks > 0 ? round(($item['count'] / $totalTasks) * 100, 1) : 0;
                        @endphp
                        <tr>
                            <td class="rank-cell">{{ $index + 1 }}</td>
                            <td>{{ $item['worker']->name ?? 'Sin asignar' }}</td>
                            <td class="count-cell">{{ $item['count'] }}</td>
                            <td class="count-cell">{{ $workerPercentage }}%</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @php
                $workerCountText = $tasksByWorker->count() > 3 ? "un nivel equilibrado de participación" : "un grupo reducido de colaboradores";
            @endphp
            <p class="paragraph" style="margin: 10mm 20mm;">Los datos reflejan que el trabajador con mayor desempeño completó {{ $tasksByWorker->first()['count'] ?? 0 }} tareas durante el período, representando un {{ $totalTasks > 0 ? round(($tasksByWorker->first()['count'] / $totalTasks) * 100, 1) : 0 }}% del total. La distribución del trabajo entre el personal muestra {{ $workerCountText }} en la ejecución de las tareas asignadas.</p>
        @endif

        {{-- REGISTRO DETALLADO DE TAREAS --}}
        <div class="page-break"></div>
        
        <h2 class="section-level-1">Registro Detallado de Tareas</h2>

        <p class="paragraph-no-indent" style="margin: 10mm 20mm 15mm 20mm;">A continuación se presenta el registro completo de las tareas finalizadas durante el período de {{ $month }} {{ $year }}. La Tabla 2 incluye información sobre el título de cada tarea, el personal responsable, la ubicación de ejecución, el nivel de prioridad asignado y las fechas de inicio y finalización.</p>

        <div class="table-caption">Tabla 2</div>
        <div class="table-caption" style="margin-bottom: 8pt;">Registro Completo de Tareas Finalizadas en {{ $month }} {{ $year }}</div>

        <div class="table-container">
            <table class="tasks-table">
                <thead>
                    <tr>
                        <th style="width: 4%; text-align: center;">N°</th>
                        <th style="width: 30%;">Descripción de la Tarea</th>
                        <th style="width: 18%;">Responsable</th>
                        <th style="width: 16%;">Ubicación</th>
                        <th style="width: 10%; text-align: center;">Prioridad</th>
                        <th style="width: 11%; text-align: center;">F. Inicio</th>
                        <th style="width: 11%; text-align: center;">F. Término</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tasks as $index => $task)
                        <tr>
                            <td style="text-align: center;">{{ $index + 1 }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($task->title, 50) }}</td>
                            <td>{{ $task->assignedTo->name ?? 'No asignado' }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($task->location, 25) }}</td>
                            <td style="text-align: center;">
                                <span class="badge badge-{{ $task->priority }}">
                                    {{ strtoupper($task->priority) }}
                                </span>
                            </td>
                            <td style="text-align: center;">{{ $task->created_at->format('d/m/Y') }}</td>
                            <td style="text-align: center;">{{ $task->updated_at->format('d/m/Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <p class="paragraph" style="margin: 10mm 20mm;">El análisis del registro permite observar la cronología de ejecución de las tareas y su distribución temporal durante el mes. Los datos presentados constituyen la base para la evaluación del cumplimiento de objetivos y la planificación de períodos futuros.</p>

        {{-- CONCLUSIONES --}}
        <div class="page-break"></div>
        
        <h2 class="section-level-1">Conclusiones</h2>

        <p class="paragraph-no-indent" style="margin: 10mm 20mm;">El análisis del período de {{ $month }} {{ $year }} permite extraer las siguientes conclusiones:</p>

        @php
            if($tasksByPriority['alta'] >= $tasksByPriority['media'] && $tasksByPriority['alta'] >= $tasksByPriority['baja']) {
                $conclusionPriority = "un enfoque predominante en tareas de alta prioridad";
            } elseif($tasksByPriority['media'] >= $tasksByPriority['alta'] && $tasksByPriority['media'] >= $tasksByPriority['baja']) {
                $conclusionPriority = "un balance operacional centrado en tareas de prioridad media";
            } else {
                $conclusionPriority = "una gestión orientada a tareas de mantenimiento y prioridad baja";
            }
        @endphp
        <p class="paragraph" style="margin: 5mm 20mm;">Se registró un total de {{ $totalTasks }} tareas finalizadas, con un tiempo promedio de ejecución de {{ $avgCompletionDays }} días. La distribución por prioridad muestra {{ $conclusionPriority }}, lo que refleja las demandas operacionales del período.</p>

        @php
            $workerParticipation = $tasksByWorker->count() > 0 
                ? "una participación de {$tasksByWorker->count()} trabajadores en la ejecución de las tareas asignadas"
                : "la ausencia de asignaciones específicas durante el período";
        @endphp
        <p class="paragraph" style="margin: 5mm 20mm;">El desempeño del personal evidencia {{ $workerParticipation }}. Los indicadores presentados proporcionan una base objetiva para la evaluación del rendimiento organizacional y la planificación de acciones futuras.</p>

        <p class="paragraph" style="margin: 5mm 20mm;">Los datos recopilados constituyen un insumo relevante para la toma de decisiones gerenciales y el mejoramiento continuo de los procesos operativos del sistema SIGERD.</p>

        {{-- NOTAS AL PIE --}}
        <div class="footnote" style="margin: 20mm 20mm 10mm 20mm;">
            <p style="font-size: 10pt; margin-bottom: 5pt;"><strong>Notas:</strong></p>
            <p style="font-size: 10pt; line-height: 1.5;">Este informe fue generado automáticamente por el Sistema de Gestión de Reportes y Documentación (SIGERD) el {{ $generatedDate }}. Los datos presentados corresponden exclusivamente al período de {{ $month }} {{ $year }} y están sujetos a las condiciones operacionales vigentes durante dicho período.</p>
            <p style="font-size: 10pt; margin-top: 8pt; text-align: center; color: #666666;">___</p>
            <p style="font-size: 9pt; text-align: center; margin-top: 10pt; color: #666666;">© {{ date('Y') }} SIGERD - Documento de uso interno exclusivo</p>
        </div>
    @else
        {{-- Sin Tareas --}}
        <div class="no-tasks">
            <h2 class="section-level-1">Sin Datos Disponibles</h2>
            <p style="margin: 20mm 20mm; text-align: center;">No se registraron tareas finalizadas durante el período de {{ $month }} {{ $year }}.</p>
            <p style="margin: 10mm 20mm; text-align: center; font-style: italic;">Para generar un informe con datos, seleccione un período que contenga tareas completadas.</p>
        </div>
    @endif
</body>
</html>