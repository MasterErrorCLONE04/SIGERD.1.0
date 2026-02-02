import 'package:dio/dio.dart';
import 'package:mobile/core/network/api_client.dart';
import 'package:mobile/features/incidents/data/models/incident_model.dart';
// import 'package:image_picker/image_picker.dart'; // Add to pubspec if not present

class IncidentRemoteDataSource {
  final ApiClient _apiClient;

  IncidentRemoteDataSource(this._apiClient);

  Future<List<IncidentModel>> getIncidents() async {
    final response = await _apiClient.client.get('/incidents');
    final data = response.data['data'] as List; // Pagination wrapper usually puts items in 'data'
    return data.map((e) => IncidentModel.fromJson(e)).toList();
  }

  Future<void> createIncident({
    required String title,
    required String description,
    required String severity,
    required String location,
    required List<String> imagePaths,
  }) async {
    final formData = FormData.fromMap({
      'title': title,
      'description': description,
      'severity': severity,
      'location': location,
    });

    for (var path in imagePaths) {
      formData.files.add(MapEntry(
        'initial_evidence_images[]',
        await MultipartFile.fromFile(path),
      ));
    }

    await _apiClient.client.post('/incidents', data: formData);
  }
}
