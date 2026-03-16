# Diagrama de Actividades: HU-ADM-021 (Detalle de Incidente)

**Historia de Usuario:** HU-ADM-021
**Rol:** Administrador
**Acción:** Ver el detalle completo de un incidente específico.
**Propósito:** Analizar la información de la falla, su evidencia fotográfica y tomar decisiones sobre su atención.

**Casos de Uso:**
1. **Ver detalle completo:** Muestra información base, creador y evidencias iniciales.
2. **Incidente resuelto con evidencia:** Muestra descripción de resolución, fecha y fotos finales.
3. **Incidente con tarea vinculada:** Muestra información de tarea, trabajador y estado de la tarea.

---

### Código PlantUML

```plantuml
@startuml
skinparam ConditionEndStyle hline

start

:Administrador hace clic en un incidente del listado;

:El sistema carga la información del incidente;
note right
Título, descripción,
ubicación, fecha de reporte,
estado, reportante, 
y evidencia inicial.
end note

fork
  :¿El incidente está en estado "Resuelto"?;
  if () then (Sí)
    :Cargar y mostrar descripción de resolución, \nfecha e imágenes de evidencia final;
  else (No)
  endif
fork again
  :¿El incidente ha sido convertido en tarea \n(estado "Asignado", "En progreso", etc.)?;
  if () then (Sí)
    :Cargar y mostrar información de la tarea \nasociada, trabajador asignado y estado;
  else (No)
  endif
end fork

:Mostrar detalle completo unificado;

stop
@enduml
```
