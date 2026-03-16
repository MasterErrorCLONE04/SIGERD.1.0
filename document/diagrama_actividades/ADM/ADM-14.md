# Diagrama de Actividades: HU-ADM-014 (Crear Tareas de Mantenimiento)

**Historia de Usuario:** HU-ADM-014
**Rol:** Administrador
**Acción:** Crear nuevas tareas de mantenimiento y asignarlas a un trabajador.
**Propósito:** Organizar y delegar las actividades de mantenimiento.

**Casos de Uso:**
1. **Creación exitosa:** Crea la tarea (estado "asignado"), notifica, redirige.
2. **Fecha límite inválida:** Muestra error si la fecha es anterior al día de hoy.
3. **Campos obligatorios vacíos:** Errores de validación si faltan datos requeridos.
4. **Imágenes obligatorias:** Error si no se adjunta evidencia de referencia.
5. **Formato de imagen inválido:** Error de formato.
6. **Imagen supera tamaño:** Error si la imagen excede 2MB.
7. **Notificación al trabajador:** Informa al asignado al momento de crearla.
8. **Evidencia inicial opcional:** Almacena evidencia subida por el administrador. (Aunque dice imágenes obligatorias en CU4, dice evidencia inicial opcional en CU8. Asumiremos adjuntos de referencia obligatorios).

---

### Código PlantUML

```plantuml
@startuml
skinparam ConditionEndStyle hline

start

:Administrador completa el formulario de nueva tarea;
:Presiona "Crear Tarea";

:El sistema recibe y procesa los datos;

:¿Faltan datos en campos obligatorios?;
if () then (Sí)
  :Mostrar errores de validación;
  kill
else (No)
  :¿La fecha límite es anterior al día actual?;
  if () then (Sí)
    :Mostrar error de validación de fecha;
    kill
  else (No)
    :¿Se adjuntaron imágenes de referencia obligatorias?;
    if () then (No)
      :Mostrar error: "Las imágenes son obligatorias";
      kill
    else (Sí)
      :¿Los archivos superan 2MB o \ntienen formato inválido?;
      if () then (Sí)
        :Mostrar error de formato o tamaño;
        kill
      else (No)
        :El sistema crea la tarea en base de datos;
        :Establece estado como "Asignado";
        
        fork
          :¿Se adjuntó evidencia inicial extra?;
          if () then (Sí)
            :Almacenar evidencia inicial;
          else (No)
          endif
        fork again
          :Enviar notificación al trabajador asignado;
        end fork
        
        :Redirigir al listado con mensaje de éxito;
        stop
      endif
    endif
  endif
endif

@enduml
```
