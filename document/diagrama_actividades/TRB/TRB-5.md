# Diagrama de Actividades: HU-TRB-005 (Dashboard / Estado general)

**Historia de Usuario:** HU-TRB-005
**Rol:** Trabajador
**Acción:** Ver un resumen general del estado de mis tareas asignadas.
**Propósito:** Tener visibilidad inmediata sobre tareas pendientes, urgentes y vencidas.

**Casos de Uso:**
1. **Métricas de tareas:** 4 tarjetas: total, asignadas, en progreso, completadas.
2. **Alerta tareas vencidas:** Aviso rojo con cantidad vencida (no finalizadas/canceladas).
3. **Alerta fechas próximas:** Aviso amarillo con tareas que vencen en 7 días.
4. **Sin vencimientos:** Oculta la sección de alertas.
5. **Tareas urgentes:** 5 tareas de prioridad alta no finalizadas, orden ascendente por límite.
6. **Tareas recientes:** 5 asignaciones recientes con admin y tiempo.
7. **Dashboard sin tareas:** Contadores cero y mensajes de vacío.
8. **Ver Todas:** Enlace rápido al listado completo en `/worker/tasks`.

---

### Código PlantUML

```plantuml
@startuml
skinparam ConditionEndStyle hline

start

:Trabajador accede a /worker/dashboard;

:El sistema consulta la base de datos \npor las tareas del trabajador;

:¿El trabajador tiene tareas asignadas?;
if () then (No)
  :Mostrar contadores en cero;
  :Mostrar paneles informativos sin resultados;
else (Sí)
  :Mostrar métricas en 4 tarjetas \n(Total, Asignadas, En Progreso, Completadas);
  
  fork
    :Revisar fechas de las tareas no finalizadas;
    
    :¿Existen tareas con fecha límite \nya superada (vencidas)?;
    if () then (Sí)
      :Mostrar aviso rojo con cantidad de tareas vencidas;
    else (No)
      :¿Existen tareas que vencen \nen los próximos 7 días?;
      if () then (Sí)
        :Mostrar aviso amarillo de alertas;
      else (No)
        :Ocultar sección de alertas \n(No hay vencimientos);
      endif
    endif
  fork again
    :Cargar listado de hasta 5 tareas "Urgentes" \n(Prioridad alta no finalizadas) ordenadas por fecha;
  fork again
    :Cargar listado de las 5 tareas asignadas \nmás recientemente (histórico asignador y tiempo);
  end fork
endif

:El dashboard está completamente cargado;

:¿El trabajador hace clic en "Ver Todas mis Tareas"?;
if () then (Sí)
  :Redirigir a vista general de tareas \n/worker/tasks;
else (No)
endif

stop
@enduml
```
