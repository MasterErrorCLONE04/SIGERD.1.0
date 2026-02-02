import 'package:flutter/material.dart';
import 'package:go_router/go_router.dart';
import 'package:mobile/features/auth/presentation/login_screen.dart';
import 'package:mobile/features/home/presentation/home_screen.dart';
import 'package:mobile/features/incidents/domain/entities/incident.dart';
import 'package:mobile/features/instructor/presentation/screens/incidents/create_incident_screen.dart';
import 'package:mobile/features/instructor/presentation/screens/incidents/incident_detail_screen.dart';
import 'package:mobile/features/tasks/domain/entities/task.dart';
import 'package:mobile/features/worker/presentation/screens/tasks/task_detail_screen.dart';

// Placeholder screens for testing routing logic
class PlaceholderScreen extends StatelessWidget {
  final String title;
  const PlaceholderScreen({super.key, required this.title});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text(title)),
      body: Center(child: Text(title)),
    );
  }
}

final appRouter = GoRouter(
  initialLocation: '/login',
  routes: [
    GoRoute(
      path: '/login',
      builder: (context, state) => const LoginScreen(),
    ),
    GoRoute(
      path: '/home',
      builder: (context, state) => const HomeScreen(),
      routes: [
        GoRoute(
          path: 'create-incident',
          builder: (context, state) => const CreateIncidentScreen(),
        ),
        GoRoute(
          path: 'incident-detail',
          builder: (context, state) {
            final incident = state.extra as Incident;
            return IncidentDetailScreen(incident: incident);
          },
        ),
        GoRoute(
          path: 'task-detail',
          builder: (context, state) {
            final task = state.extra as Task;
            return TaskDetailScreen(task: task);
          },
        ),
      ],
    ),
  ],
);
