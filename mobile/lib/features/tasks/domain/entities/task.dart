class Task {
  final int id;
  final String title;
  final String description;
  final String priority;
  final DateTime deadlineAt;
  final String location;
  final String status;
  // Add other fields as needed

  Task({
    required this.id,
    required this.title,
    required this.description,
    required this.priority,
    required this.deadlineAt,
    required this.location,
    required this.status,
  });
}
