import 'package:flutter_riverpod/flutter_riverpod.dart';
import 'package:mobile/core/di/providers.dart';
import 'package:mobile/features/tasks/domain/entities/task.dart';

final taskListProvider = AsyncNotifierProvider<TaskListNotifier, List<Task>>(TaskListNotifier.new);

class TaskListNotifier extends AsyncNotifier<List<Task>> {
  @override
  Future<List<Task>> build() async {
    return _getTasks();
  }

  Future<List<Task>> _getTasks() async {
    return ref.read(taskRepositoryProvider).getTasks();
  }

  Future<void> updateStatus(
      {required int taskId,
      required String status,
      String? resolutionDescription,
      List<String>? imagePaths}) async {
    // Optimistic update could be done here, but for now simple refresh
    // state = const AsyncValue.loading(); // Optional: show loading
    await ref.read(taskRepositoryProvider).updateTaskStatus(
          id: taskId,
          status: status,
          resolutionDescription: resolutionDescription,
          imagePaths: imagePaths,
        );
    // Refresh
    ref.invalidateSelf();
  }
}
