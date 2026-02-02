import 'package:flutter/material.dart';
import 'package:intl/intl.dart';

class AdminIncidentDetailScreen extends StatelessWidget {
  final Map<String, dynamic> incident;

  const AdminIncidentDetailScreen({super.key, required this.incident});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Detalle de Incidente'),
        elevation: 0,
        flexibleSpace: Container(
          decoration: const BoxDecoration(
            gradient: LinearGradient(colors: [Color(0xFF8B5CF6), Color(0xFF7C3AED)]),
          ),
        ),
        actions: [
          IconButton(
            icon: const Icon(Icons.assignment),
            onPressed: () {
              // TODO: Assign task
            },
            tooltip: 'Asignar tarea',
          ),
        ],
      ),
      body: SingleChildScrollView(
        padding: const EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.stretch,
          children: [
            Card(
              elevation: 2,
              shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
              child: Padding(
                padding: const EdgeInsets.all(16),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text(
                      incident['title'] ?? 'Sin título',
                      style: const TextStyle(fontSize: 20, fontWeight: FontWeight.bold),
                    ),
                    const SizedBox(height: 12),
                    Text(
                      incident['description'] ?? 'Sin descripción',
                      style: TextStyle(color: Colors.grey.shade700),
                    ),
                  ],
                ),
              ),
            ),
            const SizedBox(height: 16),
            _InfoCard(
              icon: Icons.location_on,
              label: 'Ubicación',
              value: incident['location'] ?? 'N/A',
            ),
            const SizedBox(height: 12),
            _InfoCard(
              icon: Icons.info,
              label: 'Estado',
              value: incident['status'] ?? 'N/A',
              color: _getStatusColor(incident['status']),
            ),
            const SizedBox(height: 12),
            _InfoCard(
              icon: Icons.warning,
              label: 'Severidad',
              value: incident['severity'] ?? 'N/A',
              color: _getSeverityColor(incident['severity']),
            ),
            const SizedBox(height: 12),
            _InfoCard(
              icon: Icons.calendar_today,
              label: 'Fecha de reporte',
              value: incident['reportedAt'] != null 
                  ? DateFormat('dd/MM/yyyy HH:mm').format(incident['reportedAt'])
                  : 'N/A',
            ),
            const SizedBox(height: 12),
            _InfoCard(
              icon: Icons.person,
              label: 'Reportado por',
              value: incident['reportedBy'] ?? 'N/A',
            ),
            if (incident['images'] != null && (incident['images'] as List).isNotEmpty) ...[
              const SizedBox(height: 16),
              const Text(
                'Evidencias',
                style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold),
              ),
              const SizedBox(height: 12),
              SizedBox(
                height: 120,
                child: ListView.builder(
                  scrollDirection: Axis.horizontal,
                  itemCount: (incident['images'] as List).length,
                  itemBuilder: (context, index) {
                    return Container(
                      margin: const EdgeInsets.only(right: 12),
                      width: 120,
                      decoration: BoxDecoration(
                        borderRadius: BorderRadius.circular(12),
                        color: Colors.grey.shade200,
                      ),
                      child: const Icon(Icons.image, size: 48, color: Colors.grey),
                    );
                  },
                ),
              ),
            ],
          ],
        ),
      ),
    );
  }

  Color _getStatusColor(String? status) {
    switch (status?.toLowerCase()) {
      case 'pendiente de revisión': return Colors.orange;
      case 'asignado': return Colors.blue;
      case 'resuelto': return Colors.indigo;
      case 'cerrado': return Colors.green;
      default: return Colors.grey;
    }
  }

  Color _getSeverityColor(String? severity) {
    switch (severity?.toLowerCase()) {
      case 'crítica': return Colors.red;
      case 'alta': return Colors.deepOrange;
      case 'media': return Colors.orange;
      case 'baja': return Colors.green;
      default: return Colors.grey;
    }
  }
}

class _InfoCard extends StatelessWidget {
  final IconData icon;
  final String label;
  final String value;
  final Color? color;

  const _InfoCard({
    required this.icon,
    required this.label,
    required this.value,
    this.color,
  });

  @override
  Widget build(BuildContext context) {
    return Card(
      elevation: 2,
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
      child: Padding(
        padding: const EdgeInsets.all(16),
        child: Row(
          children: [
            Container(
              padding: const EdgeInsets.all(12),
              decoration: BoxDecoration(
                color: (color ?? const Color(0xFF8B5CF6)).withValues(alpha: 0.1),
                borderRadius: BorderRadius.circular(12),
              ),
              child: Icon(icon, color: color ?? const Color(0xFF8B5CF6), size: 24),
            ),
            const SizedBox(width: 16),
            Expanded(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(label, style: TextStyle(color: Colors.grey.shade600, fontSize: 12)),
                  const SizedBox(height: 4),
                  Text(value, style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 16)),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }
}
