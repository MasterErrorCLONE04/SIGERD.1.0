# Diagrama de Componentes - SIGERD

A continuación se presenta el código fuente en formato **PlantUML** de los diagramas de componentes estructurales del sistema SIGERD, divididos por el rol del usuario.

---

## 1. Diagrama de Componentes: Rol Administrador

Este diagrama representa el flujo directo desde las interfaces visuales (Vistas Blade) a las que tiene acceso el Administrador, pasando por sus verdaderos Controladores lógicos, hasta impactar en las Tablas estrictas de la base de datos MySQL.

```plantuml
@startuml SIGERD_Componentes_Admin
left to right direction
skinparam componentStyle rectangle

package "Interfaz Administrador" {
    component "Dashboard Principal\n(Resumen y Métricas)" as ViewDash
    component "Gestión de Trabajadores\n(Crear, Editar, Lista)" as ViewWorkers
    component "Gestión de Instructores\n(Crear, Editar, Lista)" as ViewInstructors
    component "Gestión de Tareas\n(Crear, Ver, Cambiar Estado)" as ViewTasks
    component "Gestión de Incidentes\n(Lista, Convertir a Tarea)" as ViewIncidents
    component "Generación de Reportes\n(Exportar a PDF)" as ViewReports
    component "Perfil Personal\n(Configuración)" as ViewProfile
}

package "Controladores (App\\Http\\Controllers\\Admin)" {
    component "DashboardController" as CtrlDash
    component "UserController" as CtrlUser
    component "TaskController" as CtrlTask
    component "IncidentController" as CtrlIncident
    component "ReportController" as CtrlReport
    component "ProfileController" as CtrlProfile
}

package "Base de Datos (Tablas)" {
    component "users" as TabUsers
    component "tasks" as TabTasks
    component "incidents" as TabIncidents
    component "notifications" as TabNotif
}

' Relaciones Interfaz -> Controlador
ViewDash --> CtrlDash
ViewWorkers --> CtrlUser
ViewInstructors --> CtrlUser
ViewTasks --> CtrlTask
ViewIncidents --> CtrlIncident
ViewReports --> CtrlReport
ViewProfile --> CtrlProfile

' Relaciones Controlador -> Tabla
CtrlDash --> TabUsers : Lee contadores
CtrlDash --> TabTasks : Lee métricas

CtrlUser --> TabUsers : CRUD (Crea/Edita/Elimina)

CtrlTask --> TabTasks : CRUD (Crea, Edita, Cambia Estado)
CtrlTask --> TabUsers : Lee Instructores/Trabajadores (Asignación)
CtrlTask --> TabNotif : Inserta alertas

CtrlIncident --> TabIncidents : Lee listados
CtrlIncident --> TabTasks : Inserta (Al convertir de incidente)

CtrlReport --> TabTasks : Consulta datos históricos para Exportar
CtrlReport --> TabIncidents : Consulta datos históricos para Exportar

CtrlProfile --> TabUsers : Edita perfil propio del Admin

@enduml
```

---

## 2. Diagrama de Componentes: Rol Instructor

Este diagrama representa el flujo directo desde las interfaces visuales (Vistas Blade) a las que tiene acceso el Instructor, pasando por sus Controladores lógicos, hasta impactar en las Tablas de la base de datos MySQL.

```plantuml
@startuml SIGERD_Componentes_Instructor
left to right direction
skinparam componentStyle rectangle

package "Interfaz Instructor" {
    component "Dashboard Principal\n(Resumen y Métricas)" as ViewDash
    component "Reporte de Incidentes\n(Formulario de Creación)" as ViewCreateIncident
    component "Mi Historial de Incidentes\n(Lista y Detalles)" as ViewIncidents
    component "Panel de Notificaciones" as ViewNotif
    component "Perfil Personal\n(Configuración)" as ViewProfile
}

package "Controladores (App\\Http\\Controllers\\Instructor)" {
    component "DashboardController" as CtrlDash
    component "IncidentController" as CtrlIncident
    component "ProfileController" as CtrlProfile
    component "NotificationController" as CtrlNotif
}

package "Base de Datos (Tablas)" {
    component "users" as TabUsers
    component "incidents" as TabIncidents
    component "notifications" as TabNotif
}

' Relaciones Interfaz -> Controlador
ViewDash --> CtrlDash
ViewCreateIncident --> CtrlIncident
ViewIncidents --> CtrlIncident
ViewNotif --> CtrlNotif
ViewProfile --> CtrlProfile

' Relaciones Controlador -> Tabla
CtrlDash --> TabIncidents : Lee contadores y métricas
CtrlDash --> TabNotif : Lee listado

CtrlIncident --> TabIncidents : CRUD (Crea, Lee propio historial)
CtrlIncident --> TabUsers : Lee datos del remitente
CtrlIncident --> TabNotif : Dispara creación de alerta

CtrlNotif --> TabNotif : Lee y actualiza a leídas

CtrlProfile --> TabUsers : Edita perfil o contraseña propia

@enduml
```

---

## 3. Diagrama de Componentes: Rol Trabajador

Este diagrama despliega la arquitectura de componentes exclusiva para el entorno del Trabajador de campo. Resalta cómo sus acciones en las Vistas Blade impactan sus Controladores lógicos y modifican de forma directa las Tablas de tareas asigandas.

```plantuml
@startuml SIGERD_Componentes_Trabajador
left to right direction
skinparam componentStyle rectangle

package "Interfaz Trabajador" {
    component "Dashboard Principal\n(Resumen y Métricas)" as ViewDash
    component "Mis Tareas Asignadas\n(Lista y Filtros)" as ViewMyTasks
    component "Detalle y Ejecución\n(Cambio de Estado y Evidencias)" as ViewTaskDetail
    component "Panel de Notificaciones" as ViewNotif
    component "Perfil Personal\n(Configuración)" as ViewProfile
}

package "Controladores (App\\Http\\Controllers\\Worker)" {
    component "DashboardController" as CtrlDash
    component "TaskController" as CtrlTask
    component "NotificationController" as CtrlNotif
    component "ProfileController" as CtrlProfile
}

package "Base de Datos (Tablas)" {
    component "users" as TabUsers
    component "tasks" as TabTasks
    component "notifications" as TabNotif
}

' Relaciones Interfaz -> Controlador
ViewDash --> CtrlDash
ViewMyTasks --> CtrlTask
ViewTaskDetail --> CtrlTask
ViewNotif --> CtrlNotif
ViewProfile --> CtrlProfile

' Relaciones Controlador -> Tabla
CtrlDash --> TabTasks : Lee estadísticas personales
CtrlDash --> TabNotif : Lee notificaciones recientes

CtrlTask --> TabTasks : CRUD (Lee lista, Actualiza estado final)
CtrlTask --> TabNotif : Escribe alerta de revisión terminada

CtrlNotif --> TabNotif : Lee y actualiza estado a leída

CtrlProfile --> TabUsers : Actualiza datos y contraseña propia

@enduml
```
