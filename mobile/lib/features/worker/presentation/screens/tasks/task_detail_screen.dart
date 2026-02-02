import 'dart:io';
import 'package:flutter/material.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';
import 'package:go_router/go_router.dart';
import 'package:image_picker/image_picker.dart';
import 'package:intl/intl.dart';
import 'package:mobile/features/tasks/domain/entities/task.dart';
import 'package:mobile/features/tasks/presentation/providers/task_provider.dart';

class TaskDetailScreen extends ConsumerStatefulWidget {
  final Task task;

  const TaskDetailScreen({super.key, required this.task});

  @override
  ConsumerState<TaskDetailScreen> createState() => _TaskDetailScreenState();
}

class _TaskDetailScreenState extends ConsumerState<TaskDetailScreen> {
  late String _currentStatus;
  bool _isUpdating = false;

  @override
  void initState() {
    super.initState();
    _currentStatus = widget.task.status;
  }

  Future<void> _startTask() async {
    setState(() => _isUpdating = true);
    try {
      await ref.read(taskListProvider.notifier).updateStatus(
            taskId: widget.task.id,
            status: 'en_progreso',
          );
      setState(() => _currentStatus = 'en_progreso');
      if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          const SnackBar(content: Text('Tarea iniciada')),
        );
      }
    } catch (e) {
      if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(content: Text('Error: $e'), backgroundColor: Colors.red),
        );
      }
    } finally {
      if (mounted) setState(() => _isUpdating = false);
    }
  }

  void _showCompleteDialog() {
    showModalBottomSheet(
      context: context,
      isScrollControlled: true,
      builder: (context) => CompleteTaskSheet(taskId: widget.task.id),
      useSafeArea: true,
    );
  }

  @override
  Widget build(BuildContext context) {
    final formattedDeadline = DateFormat('dd/MM/yyyy HH:mm').format(widget.task.deadlineAt);

    return Scaffold(
      appBar: AppBar(title: const Text('Detalle de Tarea')),
      body: SingleChildScrollView(
        padding: const EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // Header
            Row(
              children: [
                Chip(
                  label: Text(_currentStatus.toUpperCase().replaceAll('_', ' ')),
                  backgroundColor: _getStatusColor(_currentStatus),
                  labelStyle: const TextStyle(color: Colors.white),
                ),
                const SizedBox(width: 8),
                Chip(
                  label: Text(widget.task.priority.toUpperCase()),
                  backgroundColor: _getPriorityColor(widget.task.priority),
                  labelStyle: const TextStyle(color: Colors.white),
                ),
              ],
            ),
            const SizedBox(height: 16),
            
            // Title
            Text(widget.task.title, style: Theme.of(context).textTheme.headlineMedium),
            const SizedBox(height: 8),
            
            // Info Rows
            _buildInfoRow(Icons.calendar_today, 'Vence: $formattedDeadline'),
            const SizedBox(height: 8),
            _buildInfoRow(Icons.location_on, widget.task.location),
            
            const Divider(height: 32),
            
            // Description
            Text('Descripción', style: Theme.of(context).textTheme.titleMedium),
            const SizedBox(height: 8),
            Text(widget.task.description, style: Theme.of(context).textTheme.bodyLarge),
            
            const SizedBox(height: 32),
            
            // Actions
            if (_currentStatus == 'pendiente')
              SizedBox(
                width: double.infinity,
                child: ElevatedButton.icon(
                  onPressed: _isUpdating ? null : _startTask,
                  icon: const Icon(Icons.play_arrow),
                  label: _isUpdating ? const CircularProgressIndicator() : const Text('EMPEZAR TAREA'),
                  style: ElevatedButton.styleFrom(backgroundColor: Colors.blue),
                ),
              ),
            
            if (_currentStatus == 'en_progreso')
              SizedBox(
                width: double.infinity,
                child: ElevatedButton.icon(
                  onPressed: _showCompleteDialog,
                  icon: const Icon(Icons.check_circle),
                  label: const Text('COMPLETAR TAREA'),
                  style: ElevatedButton.styleFrom(backgroundColor: Colors.green),
                ),
              ),
          ],
        ),
      ),
    );
  }

  Widget _buildInfoRow(IconData icon, String text) {
    return Row(
      children: [
        Icon(icon, size: 20, color: Colors.grey),
        const SizedBox(width: 8),
        Text(text, style: Theme.of(context).textTheme.bodyMedium),
      ],
    );
  }

  Color _getStatusColor(String status) {
    switch (status) {
      case 'pendiente': return Colors.orange;
      case 'en_progreso': return Colors.blue;
      case 'completada': return Colors.green;
      case 'cancelada': return Colors.red;
      default: return Colors.grey;
    }
  }

  Color _getPriorityColor(String priority) {
    switch (priority) {
      case 'alta': return Colors.red;
      case 'media': return Colors.orange;
      case 'baja': return Colors.green;
      default: return Colors.grey;
    }
  }
}

class CompleteTaskSheet extends ConsumerStatefulWidget {
  final int taskId;
  const CompleteTaskSheet({super.key, required this.taskId});

  @override
  ConsumerState<CompleteTaskSheet> createState() => _CompleteTaskSheetState();
}

class _CompleteTaskSheetState extends ConsumerState<CompleteTaskSheet> {
  final _descController = TextEditingController();
  final List<File> _selectedImages = [];
  final _picker = ImagePicker();
  bool _isSubmitting = false;

  Future<void> _pickImage() async {
    final XFile? image = await _picker.pickImage(source: ImageSource.gallery);
    if (image != null) setState(() => _selectedImages.add(File(image.path)));
  }

  Future<void> _takePhoto() async {
    final XFile? photo = await _picker.pickImage(source: ImageSource.camera);
    if (photo != null) setState(() => _selectedImages.add(File(photo.path)));
  }

  Future<void> _submit() async {
    if (_descController.text.isEmpty) {
      ScaffoldMessenger.of(context).showSnackBar(const SnackBar(content: Text('Agrega una descripción')));
      return;
    }

    setState(() => _isSubmitting = true);
    try {
      await ref.read(taskListProvider.notifier).updateStatus(
            taskId: widget.taskId,
            status: 'completada',
            resolutionDescription: _descController.text,
            imagePaths: _selectedImages.map((e) => e.path).toList(),
          );
      if (mounted) {
        context.pop(); // Close sheet
        context.pop(); // Go back to list
        ScaffoldMessenger.of(context).showSnackBar(
            const SnackBar(content: Text('Tarea completada exitosamente')));
      }
    } catch (e) {
      if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(SnackBar(content: Text('Error: $e')));
      }
    } finally {
      if (mounted) setState(() => _isSubmitting = false);
    }
  }

  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: EdgeInsets.only(
        bottom: MediaQuery.of(context).viewInsets.bottom,
        left: 16,
        right: 16,
        top: 16,
      ),
      child: Column(
        mainAxisSize: MainAxisSize.min,
        crossAxisAlignment: CrossAxisAlignment.stretch,
        children: [
          Text('Completar Tarea', style: Theme.of(context).textTheme.titleLarge),
          const SizedBox(height: 16),
          TextField(
            controller: _descController,
            decoration: const InputDecoration(labelText: 'Descripción de resolución'),
            maxLines: 3,
          ),
          const SizedBox(height: 16),
          Text('Evidencia (${_selectedImages.length})'),
          const SizedBox(height: 8),
          Row(
            children: [
              IconButton(onPressed: _takePhoto, icon: const Icon(Icons.camera_alt)),
              IconButton(onPressed: _pickImage, icon: const Icon(Icons.photo_library)),
            ],
          ),
          if (_selectedImages.isNotEmpty)
            SizedBox(
              height: 80,
              child: ListView.builder(
                scrollDirection: Axis.horizontal,
                itemCount: _selectedImages.length,
                itemBuilder: (_, i) => Padding(
                  padding: const EdgeInsets.only(right: 8),
                  child: Image.file(_selectedImages[i], width: 80, height: 80, fit: BoxFit.cover),
                ),
              ),
            ),
          const SizedBox(height: 24),
          ElevatedButton(
            onPressed: _isSubmitting ? null : _submit,
            child: _isSubmitting ? const CircularProgressIndicator() : const Text('CONFIRMAR'),
          ),
          const SizedBox(height: 24),
        ],
      ),
    );
  }
}
