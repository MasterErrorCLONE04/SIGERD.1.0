# Diagrama de Actividades: HU-ADM-022 (Convertir Incidente a Tarea)

**Historia de Usuario:** HU-ADM-022
**Rol:** Administrador
**Acción:** Convertir un incidente reportado en una tarea de mantenimiento.
**Propósito:** Gestionar la atención de las fallas reportadas asignando el trabajo al personal correspondiente.

**Casos de Uso:**
1. **Conversión exitosa:** Crea tarea con imágenes del incidente y cambia estado a asignado.
2. **Notificación al trabajador:** Informa al trabajador de su nueva asignación.
3. **Notificación al instructor:** Informa al creador del incidente que se está trabajando.
4. **Campos incompletos:** Muestra errores de validación.
5. **Fecha inválida:** Muestra error si la fecha de tarea es anterior al día actual.
6. **Reutilización:** Imágenes asocian automáticamente a la nueva tarea.

---

### Código PlantUML

```plantuml
@startuml
skinparam ConditionEndStyle hline

start

:Administrador accede al detalle de un incidente;
:Decide convertirlo y diligencia el \nformulario de nueva tarea;
:Presiona "Convertir a Tarea";

:El sistema recibe y procesa la solicitud;

:¿Faltan datos en campos obligatorios?;
if () then (Sí)
  :Mostrar errores de validación y \ndetener conversión;
else (No)
  :¿La fecha límite es anterior al día actual?;
  if () then (Sí)
    :Mostrar error de validación de fecha;
  else (No)
    :El sistema crea la tarea con estado "Asignado";
    :Asigna las imágenes del incidente a \nla tarea automáticamente;
    :Cambia el estado del incidente original \na "Asignado";
    
    fork
      :Enviar notificación al trabajador \nindicando que tiene una nueva tarea;
    fork again
      :Notificar al instructor reportante \nque su incidente fue convertido en tarea;
    end fork
    
    :Redirigir al listado de tareas con \nmensaje: "Incidente convertido en tarea";
  endif
endif

stop
@enduml
```
