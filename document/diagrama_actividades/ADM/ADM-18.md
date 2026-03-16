# Diagrama de Actividades: HU-ADM-018 (Eliminar Tarea)

**Historia de Usuario:** HU-ADM-018
**Rol:** Administrador
**Acción:** Eliminar una tarea del sistema de forma permanente.
**Propósito:** Limpiar registros incorrectos o innecesarios.

**Casos de Uso:**
1. **Eliminación exitosa:** Confirma la acción, se elimina de BD y se muestra mensaje de éxito.

---

### Código PlantUML

```plantuml
@startuml
skinparam ConditionEndStyle hline

start

:Administrador accede al listado de tareas;
:Hace clic en "Eliminar" en una tarea;

:¿El administrador confirma la \neliminación en el modal?;
if () then (No)
  :Cancelar proceso de eliminación;
  stop
else (Sí)
  :El sistema procesa la solicitud;
  
  :Eliminar registro de la tarea en la base de datos;
  :Eliminar referencias de imágenes y archivos \nfísicos (evidencias / adjuntos);
  
  :Redirigir al listado de tareas;
  :Mostrar mensaje de éxito: \n"Tarea eliminada permanentemente";
  
  stop
endif

@enduml
```
