# Diagrama de Actividades: HU-ADM-020 (Listado de Incidentes)

**Historia de Usuario:** HU-ADM-020
**Rol:** Administrador
**Acción:** Ver el listado completo de todos los incidentes reportados.
**Propósito:** Supervisar y gestionar todas las fallas o novedades reportadas.

**Casos de Uso:**
1. **Lista con datos:** Muestra tabla paginada (10/página) ordenada por fecha de creación desc.
2. **Lista vacía:** Muestra mensaje si no hay incidentes.
3. **Búsqueda general:** Filtra por título, descripción, ubicación o reportante.
4. **Filtrado por fecha:** Filtra incidentes reportados en una fecha específica.
5. **Filtros combinados:** El sistema aplica los dos criterios simultáneamente si están activos.

---

### Código PlantUML

```plantuml
@startuml
skinparam ConditionEndStyle hline

start

:Administrador accede a la ruta /admin/incidents;

:El sistema consulta la base de datos de incidentes;

:¿Existen incidentes reportados en el sistema?;
if () then (No)
  :Mostrar mensaje: "No hay incidentes registrados";
else (Sí)
  :Cargar tabla (10 incidentes/página) ordenada \npor fecha de creación descendente;
  
  fork
    :¿El administrador ingresó un texto \nen el buscador general?;
    if () then (Sí)
      :Filtrar por título, descripción,\nubicación o nombre de reportante;
    else (No)
    endif
  fork again
    :¿El administrador seleccionó \nuna fecha en el filtro?;
    if () then (Sí)
      :Filtrar incidentes que coincidan \ncon la fecha elegida;
    else (No)
    endif
  end fork
  
  :¿Se aplicó al menos un filtro de búsqueda?;
  if () then (Sí)
    :Combinar los resultados (match con ambas condiciones si aplican);
    
    :¿Existen coincidencias de acuerdo a los filtros?;
    if () then (No)
      :Mostrar mensaje indicando que no hay incidentes;
    else (Sí)
      :Actualizar la tabla con los resultados;
    endif
  else (No)
    :Mantener la tabla general sin filtros;
  endif
endif

stop
@enduml
```
