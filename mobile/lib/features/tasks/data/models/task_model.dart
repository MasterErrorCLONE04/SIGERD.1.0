import 'package:mobile/features/tasks/domain/entities/task.dart';

class TaskModel extends Task {
  TaskModel({
    required super.id,
    required super.title,
    required super.description,
    required super.priority,
    required super.deadlineAt,
    required super.location,
    required super.status,
  });

  factory TaskModel.fromJson(Map<String, dynamic> json) {
    return TaskModel(
      id: json['id'],
      title: json['title'],
      description: json['description'],
      priority: json['priority'],
      deadlineAt: DateTime.parse(json['deadline_at']),
      location: json['location'],
      status: json['status'],
    );
  }
}
