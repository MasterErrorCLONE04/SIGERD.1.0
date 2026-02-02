import 'package:mobile/features/incidents/domain/entities/incident.dart';

abstract class IncidentRepository {
  Future<List<Incident>> getIncidents();
  Future<void> createIncident({
    required String title,
    required String description,
    required String severity,
    required String location,
    required List<String> imagePaths,
  });
}
