import 'package:flutter_secure_storage/flutter_secure_storage.dart';
import 'package:mobile/core/network/api_client.dart';
import 'package:mobile/features/auth/data/models/user_model.dart';

class AuthRemoteDataSource {
  final ApiClient _apiClient;
  final FlutterSecureStorage _storage;

  AuthRemoteDataSource(this._apiClient, this._storage);

  Future<UserModel> login(String email, String password) async {
    try {
      final response = await _apiClient.client.post('/login', data: {
        'email': email,
        'password': password,
        'device_name': 'mobile_app',
      });

      final token = response.data['token'];
      await _storage.write(key: 'auth_token', value: token);

      return UserModel.fromJson(response.data['user']);
    } catch (e) {
      rethrow; // Use a custom exception class in a real app
    }
  }

  Future<void> logout() async {
    try {
      await _apiClient.client.post('/logout');
    } catch (e) {
      // Ignore logout errors
    } finally {
      await _storage.delete(key: 'auth_token');
    }
  }

  Future<UserModel?> getCurrentUser() async {
    try {
      final token = await _storage.read(key: 'auth_token');
      if (token == null) return null;

      final response = await _apiClient.client.get('/me');
      return UserModel.fromJson(response.data['user']);
    } catch (e) {
      return null;
    }
  }
}
