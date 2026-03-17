# Arquitectura de Alto Nivel: SIGERD

Este documento presenta la arquitectura de alto nivel del Sistema de Gestión de Reportes y Tareas (SIGERD).

## Diagrama (PlantUML)

```plantuml
@startuml
!theme plain
skinparam componentStyle uml2
skinparam nodesep 60
skinparam ranksep 60

title Arquitectura de Alto Nivel - SIGERD (Stack Monolítico)

' Actores
actor "Administrador" as admin
actor "Instructor" as inst
actor "Trabajador" as trab

' Aplicación Monolítica (Laravel)
package "SIGERD Application (Laravel 12)" {
  
  package "Capa de Presentación (Frontend)" {
    [Vistas Blade + Alpine.js] as views_blade
    [Tailwind CSS (Estilos)] as tailwind_css
    [Vite (Asset Bundling)] as vite_bundler
    
    views_blade .right.> tailwind_css : Estiliza
    vite_bundler .up.> views_blade : Inyecta Assets
  }

  package "Capa de Control y Rutas (Backend PHP 8.2+)" {
    [Enrutador Web (routes/web.php)] as router
    [Controladores de Módulos\n(Auth, Users, Tasks, Incidents)] as controllers
    
    router -down-> controllers : Delega peticiones
  }

  package "Capa de Modelos (Eloquent ORM)" {
    [User Model] as mod_user
    [Incident Model] as mod_incident
    [Task Model] as mod_task
    [Notification Model] as mod_notify
    
    controllers -down-> mod_user
    controllers -down-> mod_incident
    controllers -down-> mod_task
    controllers -down-> mod_notify
  }
}

' Capa de Persistencia
package "Capa de Datos y Almacenamiento" {
  database "Base de Datos MySQL 8.4" as db_mysql
  [Sistema de Archivos Local\n(Storage / Public)] as disk_storage
}

' Interacciones Actores -> Sistema
admin --> router : Gestiona usuarios, tareas y notificaciones
inst --> router : Reporta incidentes
trab --> router : Sube evidencias de tareas

' Lógica de Vistas
controllers -up-> views_blade : Retorna HTML renderizado

' Interacciones ORM -> Persistencia
mod_user -down-> db_mysql
mod_incident -down-> db_mysql
mod_task -down-> db_mysql
mod_notify -down-> db_mysql

' Almacenamiento Estático (Evidencias/Fotos)
controllers -down-> disk_storage : Guarda/Recupera imágenes\n(initial_evidence, final_evidence)

@enduml
```

### Componentes Clave:
1. **Frontend (Capa de Presentación)**: Interfaz de usuario construida con vistas **Blade** (motor de plantillas de Laravel) intercaladas con interactividad ágil de **Alpine.js** y estilos utilitarios de **Tailwind CSS**. Estos activos (CSS/JS) son procesados y empaquetados por **Vite**.
2. **Backend (Control y Rutas)**: Capa central de **Laravel 12 (PHP 8.2+)** que maneja todo el enrutamiento web, la lógica de negocio (mediante Controladores) y las políticas de acceso para las tres figuras de actores.
3. **Capa de Modelos (ORM)**: Integrada al backend, utiliza **Eloquent ORM** para mapear las abstracciones de negocio mediante clases (Models) a tablas concretas en la base de datos (Ej: `User`, `Incident`, `Task`, `Notification`).
4. **Capa de Datos y Almacenamiento**: Compuesta por una base de datos relacional **MySQL 8.4** asegurando la consistencia transaccional, y el propio sistema de archivos locales (discos de almacenamiento de Laravel) para guardar de forma estática las evidencias fotográficas de los reportes e intervenciones. 
