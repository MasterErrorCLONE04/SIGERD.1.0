<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detalles de la Tarea') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-6">
                        <p class="text-lg font-semibold">Título:</p>
                        <p>{{ $task->title }}</p>
                    </div>

                    <div class="mb-6">
                        <p class="text-lg font-semibold">Descripción:</p>
                        <p>{{ $task->description }}</p>
                    </div>

                    <div class="mb-6">
                        <p class="text-lg font-semibold">Ubicación:</p>
                        <p>{{ $task->location }}</p>
                    </div>

                    <div class="mb-6">
                        <p class="text-lg font-semibold">Fecha Límite:</p>
                        <p>{{ $task->deadline_at->format('d/m/Y H:i') }}</p>
                    </div>

                    <div class="mb-6">
                        <p class="text-lg font-semibold">Prioridad:</p>
                        <p>{{ ucfirst($task->priority) }}</p>
                    </div>

                    <div class="mb-6">
                        <p class="text-lg font-semibold">Estado:</p>
                        <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-500/20 dark:text-blue-300">{{ ucfirst($task->status) }}</p>
                    </div>

                    <div class="mb-6">
                        <p class="text-lg font-semibold">Asignado a:</p>
                        <p>{{ $task->assignedTo->name ?? 'N/A' }}</p>
                    </div>

                    <div class="mb-6">
                        <p class="text-lg font-semibold">Creado por:</p>
                        <p>{{ $task->createdBy->name ?? 'N/A' }}</p>
                    </div>

                    @if ($task->incident)
                        <div class="mb-6">
                            <p class="text-lg font-semibold">Reporte de Incidente Relacionado:</p>
                            <p><a href="{{ route('admin.incidents.show', $task->incident->id) }}" class="text-indigo-600 hover:text-indigo-900">{{ $task->incident->title }}</a></p>
                        </div>
                    @endif

                    @if ($task->reference_images && count($task->reference_images) > 0)
                        <div class="mb-6">
                            <p class="text-lg font-semibold">Imágenes de Referencia:</p>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-2">
                                @foreach ($task->reference_images as $imagePath)
                                    <img src="{{ asset('storage/' . $imagePath) }}" alt="Imagen de Referencia" class="w-full h-32 object-cover rounded-lg shadow-md">
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if ($task->initial_evidence_images && count($task->initial_evidence_images) > 0)
                        <div class="mb-6">
                            <p class="text-lg font-semibold">Imágenes de Evidencia Inicial:</p>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-2">
                                @foreach ($task->initial_evidence_images as $imagePath)
                                    <img src="{{ asset('storage/' . $imagePath) }}" alt="Evidencia Inicial" class="w-full h-32 object-cover rounded-lg shadow-md">
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if ($task->final_evidence_images && count($task->final_evidence_images) > 0)
                        <div class="mb-6">
                            <p class="text-lg font-semibold">Imágenes de Evidencia Final:</p>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-2">
                                @foreach ($task->final_evidence_images as $imagePath)
                                    <img src="{{ asset('storage/' . $imagePath) }}" alt="Evidencia Final" class="w-full h-32 object-cover rounded-lg shadow-md">
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if ($task->final_description)
                        <div class="mb-6">
                            <p class="text-lg font-semibold">Descripción Final del Trabajo:</p>
                            <p>{{ $task->final_description }}</p>
                        </div>
                    @endif

                    @if ($task->status === 'realizada')
                        <hr class="my-6 border-gray-200 dark:border-gray-700">
                        <h3 class="text-xl font-semibold mb-4">Revisión de Tarea</h3>
                        <form method="POST" action="{{ route('admin.tasks.review', $task->id) }}" class="space-y-4">
                            @csrf
                            @method('PUT')

                            <div class="flex space-x-4">
                                <button type="submit" name="action" value="approve"
                                        class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-700 focus:outline-none focus:border-green-700 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    Aprobar y Finalizar
                                </button>
                                <button type="submit" name="action" value="reject"
                                        class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 active:bg-yellow-600 focus:outline-none focus:border-yellow-600 focus:ring ring-yellow-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    Devolver para Corrección
                                </button>
                                <button type="submit" name="action" value="delay"
                                        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-700 focus:outline-none focus:border-red-700 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    Marcar con Retraso
                                </button>
                            </div>
                        </form>
                    @endif

                    <div class="flex justify-start mt-6">
                        <a href="{{ route('admin.tasks.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Volver a la lista de tareas
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
