import 'package:mobile/features/incidents/data/datasources/incident_remote_data_source.dart';
import 'package:mobile/features/incidents/domain/entities/incident.dart';
import 'package:mobile/features/incidents/domain/repositories/incident_repository.dart';

class IncidentRepositoryImpl implements IncidentRepository {
  final IncidentRemoteDataSource _dataSource;

  IncidentRepositoryImpl(this._dataSource);

  @override
  Future<List<Incident>> getIncidents() async {
    return await _dataSource.getIncidents();
  }

  @override
  Future<void> createIncident({
    required String title,
    required String description,
    required String severity,
    required String location,
    required List<String> imagePaths,
  }) async {
    await _dataSource.createIncident(
      title: title,
      description: description,
      severity: severity,
      location: location,
      imagePaths: imagePaths,
    );
  }
}
