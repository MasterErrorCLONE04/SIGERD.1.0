import 'package:mobile/features/incidents/domain/entities/incident.dart';

class IncidentModel extends Incident {
  IncidentModel({
    required super.id,
    required super.title,
    required super.description,
    required super.severity,
    required super.location,
    required super.status,
    required super.reportedAt,
    required super.initialEvidenceImages,
  });

  factory IncidentModel.fromJson(Map<String, dynamic> json) {
    return IncidentModel(
      id: json['id'],
      title: json['title'],
      description: json['description'],
      severity: json['severity'],
      location: json['location'],
      status: json['status'],
      reportedAt: DateTime.parse(json['updated_at'] ?? json['created_at']), // Fallback
      initialEvidenceImages: List<String>.from(json['initial_evidence_images'] ?? []),
    );
  }
}
