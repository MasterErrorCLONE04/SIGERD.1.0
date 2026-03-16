# Diagrama de Actividades: HU-ADM-023 (Notificaciones)

**Historia de Usuario:** HU-ADM-023
**Rol:** Administrador
**Acción:** Recibir y visualizar notificaciones sobre eventos importantes del sistema.
**Propósito:** Estar al tanto de las actualizaciones y cambios realizados por otros usuarios.

**Casos de Uso:**
1. **Contador de no leídas:** Muestra un badge sobre la campana de notificaciones.
2. **Sin no leídas:** Oculta el badge de la barra de navegación.
3. **Listado:** Acceder al historial completo en `/notifications`.
4. **Marcar una como leída:** Al hacer clic en la notificación específica.
5. **Marcar todas como leídas:** Acción general en la vista.

---

### Código PlantUML

```plantuml
@startuml
skinparam ConditionEndStyle hline

start

:Administrador interactúa con el sistema;

fork
  :¿El administrador tiene notificaciones \nsin leer?;
  if () then (Sí)
    :Mostrar indicador (badge) con o \nel número en el menú;
  else (No)
    :Ocultar el badge en el ícono \nde notificaciones;
  endif
fork again
  :Administrador accede a /notifications;
  :El sistema muestra el historial completo;
  
  fork
    :¿El administrador hace clic \nen una notificación?;
    if () then (Sí)
      :Marcar la notificación como "leída";
      :Actualizar el contador (badge);
    else (No)
    endif
  fork again
    :¿El administrador hace clic en \n"Marcar todas como leídas"?;
    if () then (Sí)
      :Marcar en la base de datos todas las\nnotificaciones del administrador como leídas;
      :Ocultar el badge de la barra;
    else (No)
    endif
  end fork
end fork

stop
@enduml
```
