class Incident {
  final int id;
  final String title;
  final String description;
  final String severity;
  final String location;
  final String status;
  final DateTime reportedAt;
  final List<String> initialEvidenceImages; // URLs

  Incident({
    required this.id,
    required this.title,
    required this.description,
    required this.severity,
    required this.location,
    required this.status,
    required this.reportedAt,
    required this.initialEvidenceImages,
  });
}
