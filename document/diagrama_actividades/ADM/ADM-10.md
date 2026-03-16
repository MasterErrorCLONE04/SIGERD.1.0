# Diagrama de Actividades: HU-ADM-010 (Ver Perfil e Historial de Usuario)

**Historia de Usuario:** HU-ADM-010
**Rol:** Administrador
**Acción:** Ver el perfil completo y el historial de actividad de un usuario específico.
**Propósito:** Monitorear el rendimiento y las actividades del personal.

**Casos de Uso:**
1. **Perfil de trabajador:** Muestra estadísticas de tareas, incidentes e historial de tareas paginado (10/página).
2. **Perfil de administrador o instructor:** Muestra incidentes reportados y tareas creadas (sin bloque de tareas asignadas).
3. **Usuario sin actividad:** Muestra todos los contadores estadísticos en cero.

---

### Código PlantUML

```plantuml
@startuml
skinparam ConditionEndStyle hline

start

:Administrador hace clic en "Ver" \nen un usuario de la lista;

:El sistema consulta los datos \ny la actividad del usuario;

:¿El usuario tiene actividad registrada?;
if () then (No)
  :Mostrar contadores estadísticos en cero;
else (Sí)
  :Cargar actividad del usuario (incidentes/tareas);
endif

:¿El usuario tiene rol "Trabajador"?;
if () then (Sí)
  :Mostrar estadísticas de tareas e incidentes;
  :Mostrar el historial de tareas asignadas \n(paginado a 10 por página);
else (No)
  :Mostrar incidentes reportados;
  :Mostrar tareas creadas;
  :Ocultar bloque de "tareas asignadas";
endif

:El sistema muestra el perfil completo \ndel usuario con su respectiva información;

stop
@enduml
```
