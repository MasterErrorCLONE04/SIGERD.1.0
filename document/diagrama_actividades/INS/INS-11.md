# Diagrama de Actividades: HU-INS-011 (Configuraciones y Preferencias)

**Historia de Usuario:** HU-INS-011
**Rol:** Instructor
**Acción:** Acceder y configurar las preferencias personales del sistema.
**Propósito:** Personalizar apariencia, gestionar preferencias de notificaciones y configurar seguridad.

**Casos de Uso:**
1. **Acceso:** Redirección a `/settings` mostrando pestaña "Notificaciones".
2. **Navegación:** Sin recarga de página (componentes).
3. **Toggles:** Manejo de alertas vía correo o de estados. Reflejos en UI inmediato.
4. **Temas (Claro/Oscuro/Sistema):** Guarda en LocalStorage, el de Sistema "escucha" SO.
5. **Privacidad/Seguridad:** Funcionalidad en "Construcción".
6. **Persistencia:** Carga del tema del sistema configurado incluso tras refrescar.

---

### Código PlantUML

```plantuml
@startuml
skinparam ConditionEndStyle hline

start

:Instructor hace clic en "Configuración" en el sidebar;
:El sistema redirige de inmediato a /settings;
:Despliega pestaña activa por defecto "Notificaciones";

fork
  :Instructor interactúa con el sub-menú \ninterno de configuración;
  :Permuta entre vistas dinámicas \n(sin recargar la pestaña del navegador);
fork again
  :Instructor activa o desactiva los Toggles \nsobre nuevas alertas o promociones;
  :El sistema procesa y refleja el botón on/off \nen la interfaz y BD;
fork again
  :Instructor selecciona opciones de \n"Apariencia";
  
  :¿Cuál fue la selección efectuada?;
  if () then (Claro)
    :Aplicar estilos en tono claro "Light";
    :Almacenar atributo de preferencia en localStorage;
  else (Oscuro)
    :¿Se eligió Modo Oscuro?;
    if () then (Sí)
      :Aplicar diseño Darkmode "Oscuro";
      :Almacenar atributo de preferencia en localStorage;
    else (Sistema)
      :Detectar perfil configurado en \nel Sistema Operativo local;
      :Aplicar estilo base;
      :Guardar configuración y activar listener local "MatchMedia";
    endif
  endif
fork again
  :Instructor recarga la página post-visita \no desde una pestaña nueva;
  :El sistema detecta automáticamente la llave \nen LocalStorage y aplica los estilos;
fork again
  :Instructor hace clic en \n"Seguridad y Privacidad";
  :Desplegar pantalla de mantenimiento \n("Próximamente disponible");
end fork

stop
@enduml
```
