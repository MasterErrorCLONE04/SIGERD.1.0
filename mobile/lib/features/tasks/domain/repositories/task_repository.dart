import 'package:mobile/features/tasks/domain/entities/task.dart';

abstract class TaskRepository {
  Future<List<Task>> getTasks();
  Future<void> updateTaskStatus({
    required int id,
    required String status,
    String? resolutionDescription,
    List<String>? imagePaths,
  });
}
