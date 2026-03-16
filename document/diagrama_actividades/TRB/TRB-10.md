# Diagrama de Actividades: HU-TRB-010 (Notificaciones sobre Tareas)

**Historia de Usuario:** HU-TRB-010
**Rol:** Trabajador
**Acción:** Recibir y visualizar notificaciones sobre las tareas que me son asignadas.
**Propósito:** Estar al tanto de nuevas asignaciones y actualizaciones sobre mis tareas de mantenimiento.

**Casos de Uso:**
1. **Asignación de Tarea:** Notificación automática ("Te han asignado una nueva tarea...") al crearse la asignación.
2. **Rechazo de Trabajo:** Si el admin rechaza su trabajo final, vuelve a "En progreso" y notifica la corrección.
3. **Aprobación de Trabajo:** Si el admin lo aprueba, se culmina el proceso con mensaje de éxito.
4. **Contadores / Menús:** Badge encima de la campana si hay >0 sin leer; si no hay, no existe badge; Historial en `/notifications`.
5. **Acciones de lectura:** Clic sobre una noti específica la marca; clic sobre "Marcar todas" limpia el contador completo.

---

### Código PlantUML

```plantuml
@startuml
skinparam ConditionEndStyle hline

start

:Trabajador se encuentra usando el sistema;

:El sistema consulta las notificaciones \npersonales del trabajador en tiempo real;

:¿Existen notificaciones sin leer para él?;
if () then (Sí)
  :Renderizar badge de contador (con cantidad) \nsobre la campana de notificaciones;
else (No)
  :Renderizar icono de campana \nlimpio (sin el badge numérico);
endif

fork
  :El trabajador hace clic en el menú o dropdown \nde notificaciones;
  
  :¿La opción elegida fue /notifications o "Ver todas"?;
  if () then (Sí)
    :Sistema carga la ruta de historial \ncomplejo de notificaciones;
  else (No)
    :¿La selección fue "Marcar todas como leídas"?;
    if () then (Sí)
      :Marcar en masa todas sus \nnotificaciones activas en Base de Datos;
      :Desaparecer el badge de contador;
    else (No)
      :¿Se hizo clic específico \nsobre la tarjeta de una notificación?;
      if () then (Sí)
        :Abrir enlace subyacente y \nmarcar individualmente como "leída";
        :Restar en 1 el contador del badge;
      else (No)
      endif
    endif
  endif
fork again
  :El sistema procesa interacción \ngenerada por el Administrador;
  
  :¿El admin creó una nueva tarea \nponiendo a este trabajador como asignado?;
  if () then (Sí)
    :Generar notificación: "Te han asignado \nuna nueva tarea: [título]";
  else (No)
    :¿El admin revisó la tarea de \neste trabajador y RECHAZÓ su labor?;
    if () then (Sí)
      :Devolver la tarea a estado "En progreso";
      :Generar notificación de rechazo / corrección;
    else (No)
      :¿El admin APROBÓ la labor \ndel trabajador en la tarea?;
      if () then (Sí)
        :Pasar estado de tarea a "Finalizada";
        :Generar notificación de éxito en validación;
      else (No)
      endif
    endif
  endif
  
  :Incrementar el contador de su badge (+1);
end fork

stop
@enduml
```
