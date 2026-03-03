# Diagrama de Clases - SIGERD

A continuación se presenta el código fuente en formato **PlantUML** del diagrama conceptual de clases del sistema SIGERD, basado en los roles, objetos principales y funciones reales del software. Este diagrama organiza los perfiles como clases individuales, respetando las operaciones lógicas que asumen en el código.

---

## Código PlantUML

```plantuml
@startuml SIGERD_DiagramaClases_Roles
left to right direction
skinparam classAttributeIconSize 0
skinparam monochrome false
skinparam linetype ortho
skinparam class {
    BackgroundColor White
    ArrowColor Black
    BorderColor #5B4EFF
}

class Administrador {
    + id : bigint
    + nombre : string
    + correo : string
    + contrasena : string
    + perfil_foto : string
    + estado : boolean
    --
    + iniciarSesion(correo, contrasena)
    + cerrarSesion()
    + gestionarTrabajadores()
    + gestionarInstructores()
    + crearTarea()
    + asignarTarea()
    + revisarTarea(tarea_id, estado)
    + convertirIncidenteATarea(incidente_id)
    + verTableroControl()
    + generarReportePDF()
    + actualizarPerfil()
}

class Instructor {
    + id : bigint
    + nombre : string
    + correo : string
    + contrasena : string
    + perfil_foto : string
    + estado : boolean
    --
    + iniciarSesion()
    + cerrarSesion()
    + reportarIncidente(titulo, fotos, descripcion)
    + verMisIncidentes()
    + actualizarPerfil()
}

class Trabajador {
    + id : bigint
    + nombre : string
    + correo : string
    + contrasena : string
    + perfil_foto : string
    + estado : boolean
    --
    + iniciarSesion()
    + cerrarSesion()
    + verTareasAsignadas()
    + iniciarTarea(tarea_id, fotos_iniciales)
    + finalizarTarea(tarea_id, fotos, comentarios)
    + actualizarPerfil()
}

class Tarea {
    + id : bigint
    + titulo : string
    + descripcion : text
    + prioridad : string
    + estado : string
    + ubicacion : string
    + fecha_limite : datetime
    + evidencia_inicial : json
    + evidencia_final : json
    + referencias : json
    + descripcion_final : text
    + fecha_creacion : timestamp
    --
    + actualizarEstado()
    + subirEvidencias()
}

class Incidente {
    + id : bigint
    + titulo : string
    + descripcion : text
    + ubicacion : string
    + estado : string
    + fecha_reporte : datetime
    + evidencia_inicial : json
    + evidencia_final : json
    + descripcion_resolucion : text
    + fecha_creacion : timestamp
    --
    + cambiarEstado()
}

class Notificacion {
    + id : bigint
    + tipo : string
    + titulo : string
    + mensaje : text
    + enlace : string
    + estado_lectura : boolean
    + fecha_creacion : timestamp
    --
    + marcarComoLeida()
}

' Relaciones principales (Inspiradas en el diseño del sistema)
Administrador "1" -- "*" Trabajador : gestiona >
Administrador "1" -- "*" Instructor : gestiona >

Administrador "1" -- "*" Tarea : crea, evalua, asigna >
Trabajador "1" -- "*" Tarea : ejecuta, realiza >

Instructor "1" -- "*" Incidente : reporta, registra >
Administrador "1" -- "*" Incidente : revisa >

Incidente "1" -- "0..*" Tarea : genera, deriva en >

Administrador "1" -- "*" Notificacion : recibe (acerca de incidentes/revisiones) >
Trabajador "1" -- "*" Notificacion : recibe (acerca de asignaciones/veredictos) >
Instructor "1" -- "*" Notificacion : recibe (acerca de cambios de estado) >

@enduml
```

### Notas sobre el diagrama
- La organización visual, responsabilidades y atributos mapean directamente las operaciones ejecutadas por los controladores en SIGERD (`Admin/TaskController`, `Worker/TaskController`, `Instructor/IncidentController`).
- Aunque el modelo en base de datos de Laravel es unificado en `User`, la abstracción de diagramas orientados a objetos exige la clara separación conductual para reflejar explícitamente qué métodos asume cada iteración o "rol" ante el negocio, coincidiendo con la imagen de referencia.
