# Diagrama de Casos de Uso - SIGERD

A continuación se presenta el código fuente en formato **PlantUML** del diagrama general de Casos de Uso del sistema SIGERD. Este diagrama refleja los tres perfiles de usuario (Actores) y todas sus interacciones contempladas en el documento de Requisitos Funcionales.

Puedes copiar este bloque de código y pegarlo en cualquier visualizador de PlantUML (como [PlantText](https://www.planttext.com/) o la extensión de VS Code) para renderizar el gráfico visual.

```plantuml
@startuml SIGERD_CasosDeUso
skinparam packageStyle rectangle
skinparam actorStyle hollow
left to right direction

' Definición de Actores
actor Administrador as Admin
actor Instructor as Inst
actor Trabajador as Trab
actor "Usuario General" as User

' Herencia de Actores (Todos son Usuarios y heredan acceso genérico)
Admin -|> User
Inst -|> User
Trab -|> User

' Subsistema SIGERD
rectangle "Sistema SIGERD" {

    ' Módulo de Autenticación y Perfil (Heredado por todos)
    usecase "Iniciar Sesión" as UC_Login
    usecase "Recuperar Contraseña" as UC_Recover
    usecase "Cerrar Sesión" as UC_Logout
    usecase "Ver y Editar Perfil" as UC_Profile
    usecase "Ver Panel / Dashboard" as UC_Dashboard

    ' Módulo del Administrador
    usecase "Gestionar Trabajadores e Instructores (CRUD)" as UC_ManageUsers
    usecase "Gestionar Tareas (Crear, Editar, Eliminar)" as UC_ManageTasks
    usecase "Asignar Tarea a Trabajador" as UC_AssignTask
    usecase "Cambiar Estado de Tareas" as UC_TaskStatusAdmin
    usecase "Visualizar y Filtrar Tareas" as UC_FilterTasks
    usecase "Ver Reportes de Falla (Incidentes)" as UC_ViewIncidents
    usecase "Convertir Incidente en Tarea" as UC_ConvertIncident
    usecase "Realizar Control de Calidad (Aprobar/Rechazar)" as UC_QualityControl
    usecase "Exportar Reportes Estadísticos (PDF)" as UC_ExportPDF
    usecase "Recibir Notificaciones Administrativas" as UC_AdminNotif

    ' Relaciones de Inclusión y Extensión del Administrador
    UC_ManageTasks <.. UC_AssignTask : <<extend>>
    UC_QualityControl ..> UC_TaskStatusAdmin : <<include>>

    ' Módulo del Instructor
    usecase "Registrar Nuevo Reporte de Falla" as UC_ReportFalla
    usecase "Añadir Evidencia a Reporte (Fotos < 2MB)" as UC_AddEvidenceInst
    usecase "Ver Historial de Reportes Generados" as UC_HistoryInst

    ' Relaciones del Instructor
    UC_ReportFalla ..> UC_AddEvidenceInst : <<include>>

    ' Módulo del Trabajador
    usecase "Ver Lista de Tareas Asignadas" as UC_ViewMyTasks
    usecase "Registrar Inicio de Tarea (Evidencia Inicial)" as UC_StartTask
    usecase "Finalizar Tarea (Evidencia Final)" as UC_FinishTask
    usecase "Recibir Notificaciones de Asignación/Rechazo" as UC_WorkerNotif

}

' --------- Conexiones de Actores a Casos de Uso ---------

' Conexiones de Usuario General (Aplica a los 3)
User --> UC_Login
User --> UC_Recover
User --> UC_Logout
User --> UC_Profile
User --> UC_Dashboard

' Conexiones del Administrador
Admin --> UC_ManageUsers
Admin --> UC_ManageTasks
Admin --> UC_FilterTasks
Admin --> UC_ViewIncidents
Admin --> UC_ConvertIncident
Admin --> UC_QualityControl
Admin --> UC_ExportPDF
Admin --> UC_AdminNotif

' Conexiones del Instructor
Inst --> UC_ReportFalla
Inst --> UC_HistoryInst

' Conexiones del Trabajador
Trab --> UC_ViewMyTasks
Trab --> UC_StartTask
Trab --> UC_FinishTask
Trab --> UC_WorkerNotif

@enduml
```

## Notas del Diagrama

* **Herencia de Actores (`-|>`)**: Se utilizó un actor abstracto llamado "Usuario General" para no repetir las líneas de Iniciar Sesión, Panel, Perfil y Cerrar Sesión hacia los 3 roles, manteniendo el gráfico más limpio. El Administrador, Instructor y Trabajador heredan esas capacidades básicas.
* **Trazabilidad Pura**: Cada `usecase` expuesto aquí se originó directamente a raíz de las iteraciones sobre el archivo `requisitos_funcionales.md` y respeta las restricciones (como que la inserción de imágenes está incluida dentro de registrar reportes o finalizar tareas con `<<include>>`).
