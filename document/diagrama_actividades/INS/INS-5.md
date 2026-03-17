# Diagrama de Actividades: HU-INS-005 (Dashboard / Estado general)

**Historia de Usuario:** HU-INS-005
**Rol:** Instructor
**Acción:** Ver un resumen general del estado de todas mis incidencias.
**Propósito:** Tener visibilidad inmediata sobre el estado de mis reportes y cuáles requieren seguimiento.

**Casos de Uso:**
1. **Métricas propias:** Muestra total enviados e incidentes asignados (en atención).
2. **Pendientes de revisión:** Muestra hasta 5 incidentes.
3. **Reportes recientes:** Muestra hasta 5 más recientes con badge de color.
4. **Colores de estado:** amarillo (pend.), azul (asig.), índigo (resu.), verde (cerrado).
5. **Dashboard sin incidentes:** Muestra contadores en cero y mensajes si no hay reportes.
6. **Nueva falla:** Modal rápido desde el dashboard para crear incidente.
7. **Ver Todos mis Reportes:** Redirección rápida al listado `/instructor/incidents`.

---

### Código PlantUML

```plantuml
@startuml
skinparam ConditionEndStyle hline

start

:Instructor accede a /instructor/dashboard;

:El sistema consulta la base de datos \npor los incidentes del instructor;

:¿El instructor tiene incidentes \nregistrados a su nombre?;
if () then (No)
  :Mostrar contadores estadísticos en cero;
  :Mostrar paneles vacíos con mensajes informativos;
else (Sí)
  :Mostrar métricas: Total de reportes enviados y \nTotal de incidentes en atención (asignados);
  
  fork
    :Cargar listado de hasta 5 incidentes \nen estado "Pendiente de revisión";
  fork again
    :Cargar listado de los 5 incidentes \nmás recientes (histórico general);
    
    :El sistema procesa y renderiza el \nbadge de estado correspondiente a la fila;
    
    :¿El estado es Pendiente?;
    if () then (Sí)
      :Mostrar badge Amarillo;
    else (No)
      :¿El estado es Asignado?;
      if () then (Sí)
        :Mostrar badge Azul;
      else (No)
        :¿El estado es Resuelto?;
        if () then (Sí)
          :Mostrar badge Índigo;
        else (No)
          :Mostrar badge Verde;
        endif
      endif
    endif
  end fork
endif

:El dashboard está completamente cargado;

fork
  :Instructor hace clic en \n"Reportar Nueva Falla";
  :Abrir el modal de \ncreación de incidente;
fork again
  :Instructor hace clic en \n"Ver Todos mis Reportes";
  :Redirigir a la vista \n/instructor/incidents;
end fork

stop
@enduml
```
