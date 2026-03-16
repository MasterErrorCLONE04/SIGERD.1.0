# Diagrama de Actividades: HU-ADM-025 (Configuraciones y Preferencias)

**Historia de Usuario:** HU-ADM-025
**Rol:** Administrador
**Acción:** Acceder y configurar las preferencias personales del sistema desde la sección de configuración.
**Propósito:** Personalizar la apariencia de la plataforma, gestionar notificaciones y revisar opciones de privacidad y seguridad.

**Casos de Uso:**
1. **Acceso a configuraciones:** Redirige a /settings activando Notificaciones por defecto.
2. **Navegación:** Visualiza secciones sin recargar la página (hash Alpine.js).
3. **Notificaciones (Nuevas Tareas/Incidentes):** Refleja visualmente si están activas.
4. **Notificaciones (Actualizaciones):** Refleja visualmente el cambio del toggle.
5. **Notificaciones (Alertas Promocionales):** Inactiva por defecto, refleja cambios visuales.
6. **Tema Claro:** Aplica tema, guarda en localStorage y marca la opción.
7. **Tema Oscuro:** Aplica tema, guarda en localStorage y marca la opción.
8. **Tema Sistema:** Detecta SO, aplica el que corresponda y guarda en localStorage.
9. **Privacidad y Seguridad:** Muestra funcionalidad en construcción.
10. **Persistencia:** Al recargar la página, se carga el tema preferido de localStorage.

---

### Código PlantUML

```plantuml
@startuml
skinparam ConditionEndStyle hline

start

:Administrador hace clic en "Configuración"\nen el menú lateral;
:El sistema redirige a /settings;
:Muestra por defecto la pestaña "Notificaciones";

fork
  :Hace clic en cualquier opción del menú \nlateral de configuración;
  :El sistema carga el contenido \ndinámicamente sin recargar la página;
fork again
  :Administrador interactúa con las \npreferencias de notificaciones;
  
  fork
    :¿Activa o desactiva toggle de \n"Nuevas Tareas o Incidentes"?;
    if () then (Sí)
      :Reflejar el cambio visual \ne interno del toggle correspondiente;
    else (No)
    endif
  fork again
    :¿Activa o desactiva toggle de \n"Actualizaciones de Estado o Promociones"?;
    if () then (Sí)
      :Reflejar el cambio visual \ne interno del toggle correspondiente;
    else (No)
    endif
  end fork
fork again
  :Administrador interactúa con la \napariencia (Tema del sistema);
  
  :¿Elige "Claro"?;
  if () then (Sí)
    :Aplicar tema claro en el DOM;
    :Guardar preferencia en localStorage;
  else (No)
    :¿Elige "Oscuro"?;
    if () then (Sí)
      :Aplicar tema oscuro en el DOM;
      :Guardar preferencia en localStorage;
    else (No)
      :¿Elige "Sistema"?;
      if () then (Sí)
        :Detectar preferencia del SO;
        :Aplicar claro/oscuro de acuerdo al SO;
        :Guardar en localStorage y escuchar cambios;
      else (No)
      endif
    endif
  endif
fork again
  :Administrador hace clic en \n"Privacidad y Seguridad";
  :Mostrar vista informativa: \n"Funcionalidad en construcción";
end fork

stop
@enduml
```
