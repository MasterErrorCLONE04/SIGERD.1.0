# Diagrama de Actividades: HU-TRB-012 (Configuraciones y Preferencias)

**Historia de Usuario:** HU-TRB-012
**Rol:** Trabajador
**Acción:** Acceder y configurar las preferencias personales del sistema.
**Propósito:** Personalizar la apariencia de la plataforma y gestionar preferencias.

**Casos de Uso:**
1. **Acceso UI:** Al pulsar Configuración dirige a `/settings`, entra predeterminado en `Notificaciones`.
2. **Navegación:** Renderizado de pestañas en un mismo layout vía Javascript (sin refrescar URI base completo).
3. **Toggles Funcionales:** Toggle de "nuevos encargos" (nuevas tareas) o "cambio estado" asimilan clics instantáneos y envían peticiones asíncronas para afectar sus flags de permisos de correos. Igual para promociones.
4. **Temas del DOM:** Light (fija claro en base localStorage); Dark (fija oscuro en base localStorage); System (invoca un MatchMedia de OS local, y aplica CSS correspondiente a la solicitud del SO).
5. **Persistencia Visual:** Visitas futuras evalúan `localStorage` en carga y re-pintan su preferencia.
6. **Privacidad:** Mockup visual, bloque de "Funcionalidad construyéndose".

---

### Código PlantUML

```plantuml
@startuml
skinparam ConditionEndStyle hline

start

:Trabajador selecciona menú "Configuración";
:Enrutamiento nativo hacia panel central `/settings`;
:Disposición en pantalla de bloque \n"Notificaciones" (tab default);

fork
  :Trabajador permuta clics sobre \nnavegación tipo "Tab" interna;
  :Javascript inyecta el componente respectivo \nen el contenedor sin recargar página global;
fork again
  :Trabajador maneja interruptores (Toggles);
  :Interactúa con flag "Nuevas Tareas", "Actualizaciones" \no "Alertas Promocionales";
  
  :El navegador actualiza esteticamente \nel radio switch (activado o desactivado);
  :Postea via fetch la preferencia a los ajustes de usuario en API;
fork again
  :Ingresa a solapa de "Apariencia";
  
  :¿Qué botón de preferencia temática pulsa?;
  if () then (Claro)
    :Remover flag black en etiqueta HTML;
    :Cargar "theme: light" en cache de _localStorage_;
  else (Oscuro)
    :¿Escoge Oscuro / Dark Mode?;
    if () then (Sí)
      :Adjuntar clase black en etiqueta padre HTML;
      :Cargar "theme: dark" en cache de _localStorage_;
    else (Sistema)
      :Analizar vía window.matchMedia preferencia SO;
      :Aplicar Dark/Light supeditado al resultado técnico;
      :Cargar "theme: system" en cache _localStorage_ \n(y prender watcher local);
    endif
  endif
fork again
  :Trabajador oprime en sección "Seguridad y Privacidad";
  :Panel central expulsa vista "Proximamente o En Construcción";
fork again
  :Trabajador recarga con F5 o abre la URL \nen cualquier otro momento;
  :Lectura inmediata del _localStorage_;
  :Repintar theme visual guardado \n(aplicar persistencia automática);
end fork

stop
@enduml
```
