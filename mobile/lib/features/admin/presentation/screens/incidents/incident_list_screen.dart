import 'package:flutter/material.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';
import 'package:intl/intl.dart';

class AdminIncidentListScreen extends ConsumerStatefulWidget {
  const AdminIncidentListScreen({super.key});

  @override
  ConsumerState<AdminIncidentListScreen> createState() => _AdminIncidentListScreenState();
}

class _AdminIncidentListScreenState extends ConsumerState<AdminIncidentListScreen> {
  String _searchQuery = '';
  String _statusFilter = '';
  String _severityFilter = '';

  @override
  Widget build(BuildContext context) {
    // TODO: Replace with actual provider
    final incidents = <Map<String, dynamic>>[];

    return Scaffold(
      appBar: AppBar(
        title: const Text('Gestión de Incidentes'),
        elevation: 0,
        flexibleSpace: Container(
          decoration: const BoxDecoration(
            gradient: LinearGradient(colors: [Color(0xFF8B5CF6), Color(0xFF7C3AED)]),
          ),
        ),
      ),
      body: Column(
        children: [
          Container(
            padding: const EdgeInsets.all(16),
            decoration: BoxDecoration(
              color: Colors.white,
              boxShadow: [
                BoxShadow(
                  color: Colors.black.withValues(alpha: 0.05),
                  blurRadius: 4,
                  offset: const Offset(0, 2),
                ),
              ],
            ),
            child: Column(
              children: [
                TextField(
                  decoration: InputDecoration(
                    hintText: 'Buscar incidentes...',
                    prefixIcon: const Icon(Icons.search),
                    border: OutlineInputBorder(borderRadius: BorderRadius.circular(12)),
                    filled: true,
                    fillColor: Colors.grey.shade50,
                  ),
                  onChanged: (value) => setState(() => _searchQuery = value.toLowerCase()),
                ),
                const SizedBox(height: 12),
                Row(
                  children: [
                    Expanded(
                      child: DropdownButtonFormField<String>(
                        value: _statusFilter.isEmpty ? null : _statusFilter,
                        decoration: InputDecoration(
                          labelText: 'Estado',
                          border: OutlineInputBorder(borderRadius: BorderRadius.circular(12)),
                          filled: true,
                          fillColor: Colors.grey.shade50,
                        ),
                        items: const [
                          DropdownMenuItem(value: '', child: Text('Todos')),
                          DropdownMenuItem(value: 'pendiente de revisión', child: Text('Pendiente')),
                          DropdownMenuItem(value: 'asignado', child: Text('Asignado')),
                          DropdownMenuItem(value: 'resuelto', child: Text('Resuelto')),
                          DropdownMenuItem(value: 'cerrado', child: Text('Cerrado')),
                        ],
                        onChanged: (value) => setState(() => _statusFilter = value ?? ''),
                      ),
                    ),
                    const SizedBox(width: 12),
                    Expanded(
                      child: DropdownButtonFormField<String>(
                        value: _severityFilter.isEmpty ? null : _severityFilter,
                        decoration: InputDecoration(
                          labelText: 'Severidad',
                          border: OutlineInputBorder(borderRadius: BorderRadius.circular(12)),
                          filled: true,
                          fillColor: Colors.grey.shade50,
                        ),
                        items: const [
                          DropdownMenuItem(value: '', child: Text('Todas')),
                          DropdownMenuItem(value: 'crítica', child: Text('Crítica')),
                          DropdownMenuItem(value: 'alta', child: Text('Alta')),
                          DropdownMenuItem(value: 'media', child: Text('Media')),
                          DropdownMenuItem(value: 'baja', child: Text('Baja')),
                        ],
                        onChanged: (value) => setState(() => _severityFilter = value ?? ''),
                      ),
                    ),
                  ],
                ),
              ],
            ),
          ),
          Expanded(
            child: Center(
              child: Column(
                mainAxisAlignment: MainAxisAlignment.center,
                children: [
                  Icon(Icons.report_problem_outlined, size: 64, color: Colors.grey.shade400),
                  const SizedBox(height: 16),
                  Text('Gestión de incidentes', style: Theme.of(context).textTheme.titleLarge),
                  const SizedBox(height: 8),
                  Text('Funcionalidad en desarrollo', style: TextStyle(color: Colors.grey.shade600)),
                ],
              ),
            ),
          ),
        ],
      ),
    );
  }
}
