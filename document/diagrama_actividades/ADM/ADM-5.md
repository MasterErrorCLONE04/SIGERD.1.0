# Diagrama de Actividades: HU-ADM-005 (Resumen del Dashboard)

**Historia de Usuario:** HU-ADM-005
**Rol:** Administrador
**Acción:** Ver un resumen general del estado del sistema al ingresar al panel de administración.
**Propósito:** Tener una visión global y en tiempo real del desempeño operativo del centro.

**Casos de Uso:**
1. **Estadísticas de usuarios:** Muestra total y distribución por roles (administradores, instructores, trabajadores).
2. **Estadísticas de tareas:** Muestra total y distribución por estados.
3. **Tareas con fecha límite próxima:** Muestra tareas que vencen en 7 días y no están finalizadas/canceladas.
4. **Tareas vencidas:** Muestra tareas con fecha límite superada que no están finalizadas/canceladas/realizadas.
5. **Estadísticas de incidentes:** Muestra total, pendientes de revisión y asignados.
6. **Dashboard sin datos:** Muestra todos los contadores en cero sin errores si no hay datos.

---

### Código PlantUML

```plantuml
@startuml
skinparam ConditionEndStyle hline

start

:Administrador accede al Panel de Administración (Dashboard);

:Sistema consulta la base de datos para obtener las métricas;

fork
  :¿Existen usuarios en el sistema?;
  if () then (Sí)
    :Mostrar total de usuarios y \ndistribución por roles;
  else (No)
    :Mostrar contadores de usuarios en cero;
  endif
fork again
  :¿Existen tareas en el sistema?;
  if () then (Sí)
    :Mostrar total de tareas y \ndistribución por estado;
    
    :Cálculo de fechas límites de tareas;
    fork
      :¿Hay tareas que vencen en los\npróximos 7 días (no finalizadas)?;
      if () then (Sí)
        :Mostrar contador de\ntareas próximas a vencer;
      else (No)
        :Mostrar contador de\ntareas próximas en cero;
      endif
    fork again
      :¿Hay tareas vencidas\n(no finalizadas/realizadas)?;
      if () then (Sí)
        :Mostrar contador de\ntareas vencidas;
      else (No)
        :Mostrar contador de\ntareas vencidas en cero;
      endif
    end fork
    
  else (No)
    :Mostrar contadores de tareas en cero;
  endif
fork again
  :¿Existen incidentes en el sistema?;
  if () then (Sí)
    :Mostrar total de incidentes,\npendientes y asignados;
  else (No)
    :Mostrar contadores de incidentes en cero;
  endif
end fork

:El Dashboard ha cargado completamente todas las estadísticas;

stop
@enduml
```
