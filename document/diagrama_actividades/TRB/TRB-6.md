# Diagrama de Actividades: HU-TRB-006 (Listado Completo de Tareas)

**Historia de Usuario:** HU-TRB-006
**Rol:** Trabajador
**Acción:** Ver el listado completo de todas las tareas asignadas.
**Propósito:** Tener una vista organizada de todas mis responsabilidades de mantenimiento y su estado actual.

**Casos de Uso:**
1. **Lista con datos:** Muestra tabla paginada (10 por web) ordenada por fecha límite ascendente. Visualiza título, administrador, estado, prioridad y límite.
2. **Lista vacía:** Muestra mensaje si el trabajador no tiene ninguna asignación.
3. **Búsqueda por texto:** Filtra tareas por título o descripción.
4. **Filtrado por estado:** Muestra únicamente tareas con ese estado seleccionado.
5. **Filtrado por prioridad:** Muestra únicamente tareas con la prioridad seleccionada.
6. **Combinación de filtros:** Filtro simultáneo de texto, estado y prioridad.
7. **Limpieza de filtros:** Borra los selectores y recarga la tabla completa.
8. **Paginación:** Activa controles si existen más de 10 tareas filtradas o base.
9. **Visualización estricta (Privacidad):** Garantiza que sólo vea las tareas que están a su nombre.
10. **Badge dinámico:** Renderiza colores para el estado y para la prioridad.

---

### Código PlantUML

```plantuml
@startuml
skinparam ConditionEndStyle hline

start

:Trabajador accede a la sección /worker/tasks;

:El sistema consulta la base de datos de tareas;\nnote right: Restringe la consulta EXCLUSIVAMENTE \nal ID de usuario del trabajador autenticado.

:¿El trabajador posee al menos una tarea asignada?;
if () then (No)
  :Mostrar mensaje: "No existen tareas asignadas a tu cuenta";
  stop
else (Sí)
  :Generar tabla (10 ítems/página) \nordenada por fecha límite (próximas primero);
  :Adjuntar componentes Badge \npara Estado y Prioridad;
  
  fork
    :¿El total de filas resultantes es \nmayor a 10 tareas?;
    if () then (Sí)
      :Renderizar barra de controles \npara la paginación;
    else (No)
    endif
  fork again
    :¿El trabajador manipula las casillas del \nbuscador o los dropdown de filtros?;
    if () then (Sí)
      :¿El clic se ejecutó \nsobre "Limpiar Filtros"?;
      if () then (Sí)
        :Borrar filtros de texto, estado y prioridad;
        :Recargar listado al estado original general;
      else (No)
        :Combinar filtros aplicados en la consulta BD \n(Texto, Estado, Prioridad);
        
        :¿Se encontraron tareas bajo \nesos parámetros cruzados?;
        if () then (Sí)
          :Renderizar tabla con los resultados \nespecíficos;
        else (No)
          :Mostrar mensaje de que \nninguna tarea cumple todos los filtros;
        endif
      endif
    else (No)
    endif
  end fork
endif

stop
@enduml
```
