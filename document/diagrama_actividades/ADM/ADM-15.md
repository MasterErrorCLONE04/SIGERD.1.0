# Diagrama de Actividades: HU-ADM-015 (Detalle de Tarea)

**Historia de Usuario:** HU-ADM-015
**Rol:** Administrador
**Acción:** Ver el detalle completo de una tarea específica.
**Propósito:** Revisar toda la información y evidencia relacionada.

**Casos de Uso:**
1. **Ver detalle completo:** Muestra título, estado, prioridad, ubicación, trabajador, imágenes, fechas.
2. **Tarea vinculada a incidente:** Si hay un incidente previo, muestra la info relacionada.
3. **Sin evidencia final:** Si no se ha subido evidencia, muestra apartado vacío o texto informativo.

---

### Código PlantUML

```plantuml
@startuml
skinparam ConditionEndStyle hline

start

:Administrador selecciona una tarea del listado;

:El sistema carga la información base de la tarea;
note right
Título, estado, prioridad,
ubicación, trabajador,
imágenes y fechas.
end note

fork
  :¿La tarea está vinculada a un incidente reportado?;
  if () then (Sí)
    :Cargar bloque con información del \nincidente asociado;
  else (No)
  endif
fork again
  :¿El trabajador ha subido imágenes de \nevidencia final?;
  if () then (Sí)
    :Mostrar imágenes de la evidencia \nfinal de trabajo;
  else (No)
    :Mostrar mensaje informativo: \n"Sin evidencia final";
  endif
end fork

:Mostrar todo el detalle unificado en la vista;

stop
@enduml
```
