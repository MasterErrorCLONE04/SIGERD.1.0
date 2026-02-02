import 'package:flutter_riverpod/flutter_riverpod.dart';
import 'package:flutter_secure_storage/flutter_secure_storage.dart';
import 'package:mobile/core/network/api_client.dart';
import 'package:mobile/features/auth/data/datasources/auth_remote_data_source.dart';
import 'package:mobile/features/auth/data/repositories/auth_repository_impl.dart';
import 'package:mobile/features/auth/domain/repositories/auth_repository.dart';
import 'package:mobile/features/incidents/data/datasources/incident_remote_data_source.dart';
import 'package:mobile/features/incidents/data/repositories/incident_repository_impl.dart';
import 'package:mobile/features/incidents/domain/repositories/incident_repository.dart';
import 'package:mobile/features/tasks/data/datasources/task_remote_data_source.dart';
import 'package:mobile/features/tasks/data/repositories/task_repository_impl.dart';
import 'package:mobile/features/tasks/domain/repositories/task_repository.dart';

// Core
final secureStorageProvider = Provider((ref) => const FlutterSecureStorage());

final apiClientProvider = Provider((ref) {
  final storage = ref.watch(secureStorageProvider);
  return ApiClient(storage);
});

// Auth Feature
final authRemoteDataSourceProvider = Provider((ref) {
  final apiClient = ref.watch(apiClientProvider);
  final storage = ref.watch(secureStorageProvider);
  return AuthRemoteDataSource(apiClient, storage);
});

final authRepositoryProvider = Provider<AuthRepository>((ref) {
  final dataSource = ref.watch(authRemoteDataSourceProvider);
  return AuthRepositoryImpl(dataSource);
});

// Incident Feature

final incidentRemoteDataSourceProvider = Provider((ref) {
  final apiClient = ref.watch(apiClientProvider);
  return IncidentRemoteDataSource(apiClient);
});

final incidentRepositoryProvider = Provider<IncidentRepository>((ref) {
  final dataSource = ref.watch(incidentRemoteDataSourceProvider);
  return IncidentRepositoryImpl(dataSource);
});

// Task Feature
final taskRemoteDataSourceProvider = Provider((ref) {
  final apiClient = ref.watch(apiClientProvider);
  return TaskRemoteDataSource(apiClient);
});

final taskRepositoryProvider = Provider<TaskRepository>((ref) {
  final dataSource = ref.watch(taskRemoteDataSourceProvider);
  return TaskRepositoryImpl(dataSource);
});
