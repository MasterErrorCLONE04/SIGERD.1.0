import 'package:flutter_riverpod/flutter_riverpod.dart';
import 'package:mobile/core/network/api_client.dart';
import 'package:mobile/core/di/providers.dart';

// Admin Stats Model
class AdminStats {
  final int totalUsers;
  final int totalTasks;
  final int pendingIncidents;
  final int overdueTasks;

  AdminStats({
    required this.totalUsers,
    required this.totalTasks,
    required this.pendingIncidents,
    required this.overdueTasks,
  });

  factory AdminStats.fromJson(Map<String, dynamic> json) {
    return AdminStats(
      totalUsers: json['total_users'] ?? 0,
      totalTasks: json['total_tasks'] ?? 0,
      pendingIncidents: json['pending_incidents'] ?? 0,
      overdueTasks: json['overdue_tasks'] ?? 0,
    );
  }
}

// Admin Stats Provider
final adminStatsProvider = FutureProvider<AdminStats>((ref) async {
  final apiClient = ref.watch(apiClientProvider);
  
  try {
    final response = await apiClient.client.get('/admin/dashboard/stats');
    return AdminStats.fromJson(response.data);
  } catch (e) {
    // Return default stats if error
    return AdminStats(
      totalUsers: 0,
      totalTasks: 0,
      pendingIncidents: 0,
      overdueTasks: 0,
    );
  }
});
