# Diagrama de Actividades: HU-INS-009 (Notificaciones sobre Reportes)

**Historia de Usuario:** HU-INS-009
**Rol:** Instructor
**Acción:** Recibir y visualizar notificaciones sobre el estado de mis reportes de fallas.
**Propósito:** Estar al tanto de cuando mis incidentes son convertidos en tarea o cuando el mantenimiento es finalizado.

**Casos de Uso:**
1. **Conversión a tarea:** Recibe notificación automática si cambian un incidente suyo.
2. **Resolución:** Recibe notificación automática si el incidente es finalizado con éxito.
3. **Contador de no leídas:** Badge rojo con cantidad en la campana si hay pendientes.
4. **Sin no leídas:** Muestra el ícono normal sin badge.
5. **Listado:** La ruta `/notifications` exhibe el historial completo.
6. **Marcar una leída:** Clic sobre la tarjeta la marca internamente como leída.
7. **Marcar todas como leídas:** El botón superior "Marcar todas" limpia el contador.

---

### Código PlantUML

```plantuml
@startuml
skinparam ConditionEndStyle hline

start

:Instructor está navegando en el panel;

:El sistema consulta las notificaciones \ndirigidas al instructor en tiempo real;

:¿Existen notificaciones sin leer?;
if () then (Sí)
  :Renderizar badge con la cantidad \nsobre el icono de notificaciones;
else (No)
  :Solo renderizar la campana normal \n(sin badge de colores);
endif

fork
  :El instructor hace clic en un elemento \ndel menú de notificaciones /dropdown;
  
  :¿La opción es "Ver todas" o /notifications?;
  if () then (Sí)
    :Mostrar historial completo de notificaciones (leídas y no);
  else (No)
    :¿La selección fue "Marcar todas como leídas"?;
    if () then (Sí)
      :Actualizar estado en BD para todas;
      :Desaparecer el badge de contador;
    else (No)
      :¿Se hizo clic sobre una \nnotificación específica del panel?;
      if () then (Sí)
        :Desplegar mensaje y marcar como leída individualmente;
        :Reducir el contador del badge en -1;
      else (No)
      endif
    endif
  endif
fork again
  :El sistema procesa evento externo \npor parte de un Administrador;
  
  :¿El admin convirtió un incidente \ndel instructor en Tarea?;
  if () then (Sí)
    :Disparar nueva notificación: "Tu \nincidente ha sido convertido...";
  else (No)
    :¿El admin aprobó una tarea y \nresolvió un incidente del instructor?;
    if () then (Sí)
      :Disparar nueva notificación: "Reparación \nfinalizada con éxito en: [título]";
    else (No)
    endif
  endif
  
  :Actualizar badge del instructor (+1);
end fork

stop
@enduml
```
