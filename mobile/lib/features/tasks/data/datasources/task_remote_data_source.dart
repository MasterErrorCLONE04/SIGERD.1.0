import 'package:mobile/core/network/api_client.dart';
import 'package:mobile/features/tasks/data/models/task_model.dart';
import 'package:dio/dio.dart';

class TaskRemoteDataSource {
  final ApiClient _apiClient;

  TaskRemoteDataSource(this._apiClient);

  Future<List<TaskModel>> getTasks() async {
    final response = await _apiClient.client.get('/tasks');
    final data = response.data['data'] as List;
    return data.map((e) => TaskModel.fromJson(e)).toList();
  }

  Future<void> updateTaskStatus({
    required int id,
    required String status,
    String? resolutionDescription,
    List<String>? imagePaths,
  }) async {
    final formData = FormData.fromMap({
      'status': status,
      'resolution_description': resolutionDescription,
    });

    if (imagePaths != null) {
      for (var path in imagePaths) {
        formData.files.add(MapEntry(
          'final_evidence_images[]',
          await MultipartFile.fromFile(path),
        ));
      }
    }

    await _apiClient.client.post('/tasks/$id/update', data: formData);
  }
}
