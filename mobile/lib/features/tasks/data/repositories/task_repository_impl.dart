import 'package:mobile/features/tasks/data/datasources/task_remote_data_source.dart';
import 'package:mobile/features/tasks/domain/entities/task.dart';
import 'package:mobile/features/tasks/domain/repositories/task_repository.dart';

class TaskRepositoryImpl implements TaskRepository {
  final TaskRemoteDataSource _dataSource;

  TaskRepositoryImpl(this._dataSource);

  @override
  Future<List<Task>> getTasks() async {
    return await _dataSource.getTasks();
  }

  @override
  Future<void> updateTaskStatus({
    required int id,
    required String status,
    String? resolutionDescription,
    List<String>? imagePaths,
  }) async {
    await _dataSource.updateTaskStatus(
      id: id,
      status: status,
      resolutionDescription: resolutionDescription,
      imagePaths: imagePaths,
    );
  }
}
