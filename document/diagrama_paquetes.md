# Diagrama de Paquetes - SIGERD

A continuación se presenta el código fuente en formato **PlantUML** del diagrama de paquetes del sistema SIGERD. Este diagrama muestra la estructura modular lógica del sistema, organizada por las capas arquitectónicas principales (Presentación, Lógica de Negocio / Controladores, y Acceso a Datos / Modelos) y las dependencias entre estos paquetes.

---

## Código PlantUML

```plantuml
@startuml SIGERD_DiagramaPaquetes
skinparam packageStyle folder
skinparam monochrome false
skinparam linetype ortho
skinparam package {
    BackgroundColor White
    BorderColor #5B4EFF
}

package "SIGERD Application" {

    package "Capa de Presentación (Frontend / UI)" as UI {
        package "Módulo Autenticación UI" as UI_Auth
        package "Módulo Vistas Admin" as UI_Admin
        package "Módulo Vistas Instructor" as UI_Instructor
        package "Módulo Vistas Trabajador" as UI_Trabajador
    }

    package "Capa de Control (Lógica de Negocio / Controllers)" as Controllers {
        package "Gestión de Seguridad y Auth" as Ctrl_Auth
        package "Gestión de Usuarios" as Ctrl_Usuarios
        package "Gestión de Tareas" as Ctrl_Tareas
        package "Gestión de Incidentes" as Ctrl_Incidentes
        package "Gestión de Notificaciones" as Ctrl_Notificaciones
        package "Gestión de Reportes y Tablero" as Ctrl_Reportes
    }

    package "Capa de Entidades (Modelos de Dominio)" as Models {
        package "Entidad Usuario" as Mod_Usuario
        package "Entidad Tarea" as Mod_Tarea
        package "Entidad Incidente" as Mod_Incidente
        package "Entidad Notificación" as Mod_Notificacion
    }

    package "Capa de Persistencia (Base de Datos)" as Database {
        database "MySQL SIGERD DB" as DB
    }
}

' Relaciones de dependencia (Presentación -> Control)
UI_Auth .down.> Ctrl_Auth : "Usa"
UI_Admin .down.> Ctrl_Usuarios : "Usa"
UI_Admin .down.> Ctrl_Tareas : "Usa"
UI_Admin .down.> Ctrl_Reportes : "Usa"
UI_Instructor .down.> Ctrl_Incidentes : "Usa"
UI_Trabajador .down.> Ctrl_Tareas : "Usa"

' Relaciones transversales comunes
UI_Instructor .down.> Ctrl_Usuarios : "Perfil"
UI_Trabajador .down.> Ctrl_Usuarios : "Perfil"

' Dependencias a Notificaciones
UI_Admin .down.> Ctrl_Notificaciones : "Recibe"
UI_Instructor .down.> Ctrl_Notificaciones : "Recibe"
UI_Trabajador .down.> Ctrl_Notificaciones : "Recibe"

' Relaciones de dependencia (Control -> Entidades)
Ctrl_Auth .down.> Mod_Usuario : "Gestiona"
Ctrl_Usuarios .down.> Mod_Usuario : "Gestiona"
Ctrl_Tareas .down.> Mod_Tarea : "Gestiona"
Ctrl_Incidentes .down.> Mod_Incidente : "Gestiona"
Ctrl_Incidentes .down.> Mod_Tarea : "Convierte en"
Ctrl_Notificaciones .down.> Mod_Notificacion : "Gestiona"
Ctrl_Reportes .down.> Mod_Tarea : "Analiza"
Ctrl_Reportes .down.> Mod_Incidente : "Analiza"

' Relaciones de dependencia (Entidades -> Persistencia)
Mod_Usuario -down-> DB : "Persiste"
Mod_Tarea -down-> DB : "Persiste"
Mod_Incidente -down-> DB : "Persiste"
Mod_Notificacion -down-> DB : "Persiste"

@enduml
```

### Notas sobre el diagrama
- **Capa de Presentación:** Incluye todos los componentes visuales e interfaces con las que el usuario interactúa, separados por perfil de usuario o módulo lógico (`Vistas Admin`, `Trabajador`, `Instructor`, y el `Módulo de Autenticación`).
- **Capa de Control:** Agrupa la lógica de negocio y los controladores responsables de procesar las solicitudes HTTP y coordinar las acciones (`Gestión de Usuarios`, `Tareas`, `Incidentes`, `Notificaciones` y `Reportes`).
- **Capa de Entidades:** Contiene las representaciones de los datos del sistema (`Modelos/Clases` de Eloquent), incluyendo las reglas fundamentales del dominio de la aplicación (`Usuario`, `Tarea`, `Incidente`, `Notificación`).
- **Capa de Persistencia:** Representa el gestor de base de datos relacional en este caso la base de datos MySQL, asegurando el almacenamiento estructurado y persistente de la información.
- **Dependencias:** Las flechas punteadas (`..>`) denotan dependencia, es decir, una capa requiere de los servicios o la información proporcionada por otra inferior. Las líneas con puntas sólidas indicando una relación de persistencia con el sistema de base de datos. Esto respeta el flujo de la arquitectura Modelo-Vista-Controlador (MVC) y promueve el desacoplamiento.
