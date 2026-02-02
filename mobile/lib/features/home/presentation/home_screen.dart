import 'package:flutter/material.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';
import 'package:go_router/go_router.dart';
import 'package:mobile/features/auth/presentation/providers/auth_provider.dart';
import 'package:mobile/features/instructor/presentation/screens/instructor_dashboard_screen.dart';
import 'package:mobile/features/worker/presentation/screens/worker_dashboard_screen.dart';
import 'package:mobile/features/admin/presentation/screens/admin_dashboard_screen.dart';

class HomeScreen extends ConsumerWidget {
  const HomeScreen({super.key});

  @override
  Widget build(BuildContext context, WidgetRef ref) {
    final authState = ref.watch(authProvider);
    final user = authState.user;

    if (user == null) {
      // Should handle this better, but for now redirect
      Future.microtask(() => context.go('/login'));
      return const Scaffold(body: Center(child: CircularProgressIndicator()));
    }

    return Scaffold(
      appBar: AppBar(
        title: Text('Hola, ${user.name}'),
        actions: [
          IconButton(
            icon: const Icon(Icons.logout),
            onPressed: () {
              ref.read(authProvider.notifier).logout();
              context.go('/login');
            },
          ),
        ],
      ),
      body: _buildDashboard(user.role),
    );
  }

  Widget _buildDashboard(String role) {
    switch (role) {
      case 'instructor':
        return const InstructorDashboardScreen();
      case 'trabajador':
        return const WorkerDashboardScreen();
      case 'administrador':
        return const AdminDashboardScreen();
      default:
        return const Center(child: Text("Rol no reconocido"));
    }
  }
}
