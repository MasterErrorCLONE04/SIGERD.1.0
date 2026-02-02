import 'package:flutter_riverpod/flutter_riverpod.dart';
import 'package:mobile/core/di/providers.dart';
import 'package:mobile/features/incidents/domain/entities/incident.dart';

final incidentListProvider = AsyncNotifierProvider<IncidentListNotifier, List<Incident>>(IncidentListNotifier.new);

class IncidentListNotifier extends AsyncNotifier<List<Incident>> {
  @override
  Future<List<Incident>> build() async {
    return _getIncidents();
  }

  Future<List<Incident>> _getIncidents() async {
    return ref.read(incidentRepositoryProvider).getIncidents();
  }

  Future<void> createIncident({
    required String title,
    required String description,
    required String severity,
    required String location,
    required List<String> imagePaths,
  }) async {
    state = const AsyncValue.loading();
    state = await AsyncValue.guard(() async {
      await ref.read(incidentRepositoryProvider).createIncident(
            title: title,
            description: description,
            severity: severity,
            location: location,
            imagePaths: imagePaths,
          );
      return _getIncidents();
    });
  }
}
