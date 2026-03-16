# Diagrama de Actividades: HU-INS-006 (Listado de Fallas Reportadas)

**Historia de Usuario:** HU-INS-006
**Rol:** Instructor
**Acción:** Ver el listado completo de todas las fallas reportadas al sistema.
**Propósito:** Monitorear el estado y seguimiento de cada incidencia reportada.

**Casos de Uso:**
1. **Lista con datos:** Muestra tabla paginada (10/pag) con título, desc, ubicación, estado, fecha.
2. **Lista vacía:** Muestra mensaje si no hay reportes y botón para enviar el primero.
3. **Búsqueda por texto:** Filtra título, descripción o ubicación.
4. **Filtrado por estado:** Filtra pendiente, asignado, resuelto o cerrado.
5. **Filtros combinados:** Muestra coincidencias con ambos criterios activos.
6. **Limpieza de filtros:** Si hace clic en "Limpiar", quita filtros y muestra tabla base.
7. **Búsqueda sin coincidencias:** Muestra mensaje y botón "Limpiar filtros".
8. **Paginación:** Si hay más de 10, muestra los controles.
9. **Restricción visual:** El sistema filtra en base de datos SOLO por id de instructor autenticado.
10. **Badge de estado:** Aplica gama cromática según estado.

---

### Código PlantUML

```plantuml
@startuml
skinparam ConditionEndStyle hline

start

:Instructor accede a su registro en /instructor/incidents;

:Sistema consulta los incidentes en la base de datos \n(Filtrando SOLO por ID de usuario autenticado);

:¿Muestra incidentes registrados bajo su nombre?;
if () then (No)
  :Mostrar mensaje: "No existen reportes";
  :Mostrar botón "Reportar primera falla";
  stop
else (Sí)
  :Cargar tabla (10 filas/página) ordenada por fecha desc.;
  :Renderizar en cada fila su respectivo Badge de estado coloreado;
  
  fork
    :¿Existen más de 10 incidentes en el resultado?;
    if () then (Sí)
      :Mostrar controles de la paginación de la tabla;
    else (No)
    endif
  fork again
    :¿El instructor manipula los filtros de búsqueda?;
    if () then (Sí)
      :¿El clic se hizo sobre el botón "Limpiar Filtros"?;
      if () then (Sí)
        :Eliminar los criterios de búsqueda activos;
        :Recargar tabla completa original;
      else (No)
        :Aplicar filtro de texto y/o estado solicitado;
        
        :¿Existen coincidencias bajo esos filtros?;
        if () then (No)
          :Mostrar mensaje informativo: "Sin resultados";
          :Habilitar opción visible para limpiar filtros;
        else (Sí)
          :Actualizar la tabla combinando ambas condiciones;
        endif
      endif
    else (No)
    endif
  end fork
endif

stop
@enduml
```
