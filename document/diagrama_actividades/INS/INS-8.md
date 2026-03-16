# Diagrama de Actividades: HU-INS-008 (Detalle de Falla Reportada)

**Historia de Usuario:** HU-INS-008
**Rol:** Instructor
**Acción:** Ver el detalle completo de un reporte de falla enviado.
**Propósito:** Conocer el estado actual de la incidencia y revisar evidencia.

**Casos de Uso:**
1. **Ver detalle completo:** Título, estado, desc., ubicación, fecha, id e imágenes.
2. **Zoom en fotos iniciales:** Hace clic en imagen y se abre en modal interactivo (descargar).
3. **Acceso denegado externo:** 404 si intenta acceder a incidentes de otros usando la URL.
4. **Aviso pendiente revisión:** Mensaje informativo cuando está en revisión por admins.
5. **Aviso asignado:** Si ya se volvió tarea, muestra al trabajador y que "está en progreso".
6. **Aviso resuelto:** Si la tarea terminó, expone descripción de solución, fecha y fotos finales.
7. **Zoom en fotos finales:** Modal con badge respectivo para las partes finales.
8. **Botón volver:** Redirige al listado nuevamente.

---

### Código PlantUML

```plantuml
@startuml
skinparam ConditionEndStyle hline

start

:Instructor intenta acceder a la vista detallada de un reporte;

:El sistema verifica su identidad y propiedad del reporte;

:¿El incidente (ID de URL) fue creado por este Instructor autenticado?;
if () then (No)
  :Denegar acceso a los datos;
  :Retornar página de Error 404 (No encontrado);
  stop
else (Sí)
  :Cargar la información base y fotos de la primera fase;
  
  :¿Cuál es el estado actual de la incidencia?;
  if () then (Pendiente)
    :Mostrar aviso: "En revisión por administración";
  else (Asignado/EnProgreso)
    :¿El reporte se convirtió en tarea (Asignado/En progreso)?;
    if () then (Sí)
      :Cargar datos del trabajador a cargo;
      :Mostrar aviso: "Trabajo en progreso";
    else (Resuelto)
      :Cargar fecha y texto descriptivo de la resolución;
      :Cargar sección con las evidencias finales del arreglo;
    endif
  endif
  
  :Cargar y componer la página de detalles unificada;
  
  fork
    :¿Clic en evidencia inicial enviada?;
    if () then (Sí)
      :Abrir imagen en modal vista completa para zoom;
      :Mostrar opciones adicionales de descargar o cerrar;
    else (No)
    endif
  fork again
    :¿Clic en evidencia final de respuesta (Si la hay)?;
    if () then (Sí)
      :Abrir imagen en modal vista completa;
      :Añadir distintivo "Final" (Badge) en la vista;
    else (No)
    endif
  fork again
    :¿Clic en botón para "Volver a la lista"?;
    if () then (Sí)
      :Redirigir a ruta /instructor/incidents;
    else (No)
    endif
  end fork
endif

stop
@enduml
```
