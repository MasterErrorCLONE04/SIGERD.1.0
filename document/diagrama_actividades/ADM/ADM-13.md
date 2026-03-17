# Diagrama de Actividades: HU-ADM-013 (Listado de Tareas)

**Historia de Usuario:** HU-ADM-013
**Rol:** Administrador
**Acción:** Ver el listado de todas las tareas registradas en el sistema.
**Propósito:** Supervisar el estado y progreso de todas las actividades de mantenimiento.

**Casos de Uso:**
1. **Lista de tareas con datos:** Muestra tabla paginada (10 tareas/página) ordenada desc.
2. **Lista de tareas vacía:** Si no hay tareas, muestra un mensaje informativo.
3. **Filtrado por título:** Filtra tareas por título ingresado.
4. **Filtrado por prioridad:** Filtra tareas por baja, media o alta.
5. **Combinación de filtros:** Aplica ambos filtros texto y prioridad conjuntamente.
6. **Sin resultados:** Muestra mensaje si no hay coincidencias con filtros.

---

### Código PlantUML

```plantuml
@startuml
skinparam ConditionEndStyle hline

start

:Administrador accede a la sección /admin/tasks;

:El sistema consulta la base de datos de tareas;

:¿Existen tareas registradas?;
if () then (No)
  :Mostrar mensaje: "No hay tareas registradas";
else (Sí)
  :Cargar tabla ordenada por fecha de \ncreación descendente;
  
  fork
    :¿Existen más de 10 tareas registradas?;
    if () then (Sí)
      :Mostrar controles de paginación;
    else (No)
    endif
  fork again
    :¿El administrador aplica filtros de \nbúsqueda (título) o prioridad?;
    if () then (Sí)
      :Aplicar filtros de concordancia;
      
      :¿Existen coincidencias con los filtros?;
      if () then (No)
        :Mostrar mensaje indicando que no hay\ntareas con esos criterios;
      else (Sí)
        :Actualizar la tabla con los resultados filtrados;
      endif
    else (No)
      :Mostrar tareas sin filtrar;
    endif
  end fork
endif

stop
@enduml
```
