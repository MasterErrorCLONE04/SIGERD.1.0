<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Incidente #{{ $incident->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; color: #333; line-height: 1.5; }
        h1 { color: #1a202c; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px; margin-bottom: 20px; }
        h3 { color: #2d3748; margin-top: 25px; margin-bottom: 10px; }
        .details { margin-top: 10px; width: 100%; border-collapse: collapse; }
        .details th { text-align: left; width: 150px; padding: 8px 0; color: #4a5568; }
        .details td { padding: 8px 0; color: #1a202c; font-weight: bold; }
        .status { padding: 4px 8px; border-radius: 4px; color: white; display: inline-block; font-weight: bold; font-size: 12px; text-transform: uppercase; }
        .status.pendiente-de-revision { background-color: #f59e0b; color: #fff;}
        .status.asignado { background-color: #3b82f6; color: #fff;}
        .status.en-progreso { background-color: #6366f1; color: #fff;}
        .status.resuelto { background-color: #10b981; color: #fff;}
        .status.cerrado { background-color: #6b7280; color: #fff;}
        .description-box { background-color: #f7fafc; padding: 15px; border-radius: 8px; border: 1px solid #e2e8f0; }
        .image-container { text-align: center; margin-bottom: 20px; }
        .image-container img { max-width: 100%; max-height: 300px; border-radius: 8px; border: 1px solid #cbd5e0; }
        .page-break { page-break-after: always; }
    </style>
</head>
<body>
    <h1>Reporte de Incidente: {{ $incident->title }}</h1>
    
    <table class="details">
        <tr>
            <th>ID del Reporte:</th>
            <td>#{{ $incident->id }}</td>
        </tr>
        <tr>
            <th>Estado actual:</th>
            <td><span class="status {{ Str::slug($incident->status) }}">{{ ucfirst($incident->status) }}</span></td>
        </tr>
        <tr>
            <th>Reportado por:</th>
            <td>{{ $incident->reportedBy->name ?? 'No especificado' }}</td>
        </tr>
        <tr>
            <th>Fecha de Reporte:</th>
            <td>{{ $incident->created_at->format('d/m/Y h:i A') }}</td>
        </tr>
        <tr>
            <th>Ubicación:</th>
            <td>{{ $incident->location ?? 'No especificada' }}</td>
        </tr>
    </table>

    <div style="margin-top: 25px;">
        <h3>Descripción del Problema:</h3>
        <div class="description-box">
            {!! nl2br(e($incident->description)) !!}
        </div>
    </div>

    @if ($incident->status === 'resuelto' && $incident->resolved_at)
    <div style="margin-top: 25px;">
        <h3>Detalles de la Resolución:</h3>
        <table class="details">
            <tr>
                <th>Fecha Resolución:</th>
                <td>{{ $incident->resolved_at->format('d/m/Y H:i:s') }}</td>
            </tr>
        </table>
        @if ($incident->resolution_description)
            <div class="description-box" style="margin-top: 10px;">
                {!! nl2br(e($incident->resolution_description)) !!}
            </div>
        @endif
    </div>
    @endif

    @php
        $hasInitialImages = $incident->initial_evidence_images && count($incident->initial_evidence_images) > 0;
        $hasFinalImages = $incident->final_evidence_images && count($incident->final_evidence_images) > 0;
    @endphp

    @if ($hasInitialImages || $hasFinalImages)
        <div class="page-break"></div>
        <h1>Evidencias Fotográficas</h1>

        @if ($hasInitialImages)
            <h3>Evidencia Inicial</h3>
            @foreach ($incident->initial_evidence_images as $imagePath)
                <div class="image-container">
                    <img src="{{ public_path('storage/' . $imagePath) }}" alt="Evidencia Inicial">
                </div>
            @endforeach
        @endif

        @if ($hasFinalImages)
            <h3>Evidencia Final (Trabajo Realizado)</h3>
            @foreach ($incident->final_evidence_images as $imagePath)
                <div class="image-container">
                    <img src="{{ public_path('storage/' . $imagePath) }}" alt="Evidencia Final">
                </div>
            @endforeach
        @endif
    @endif

</body>
</html>
