# Diagrama de Actividades: HU-ADM-007 (Crear Nuevo Usuario desde Dashboard)

**Historia de Usuario:** HU-ADM-007
**Rol:** Administrador
**Acción:** Crear un nuevo usuario directamente desde el panel de control sin salir del dashboard.
**Propósito:** Registrar nuevos miembros del personal de forma ágil sin necesidad de navegar al módulo de usuarios.

**Casos de Uso:**
1. **Apertura de modal (Botón superior):** Abre el modal completo.
2. **Apertura de modal (Acciones rápidas):** Abre el modal completo.
3. **Creación exitosa:** Crea el usuario, guarda foto y redirige al listado de usuarios con éxito.
4. **Campos obligatorios:** Muestra errores de validación en campos requeridos.
5. **Reapertura automática:** Ante errores de servidor, reabre el modal y muestra los mensajes.
6. **Cierre sin guardar:** Al cancelar, hacer clic fuera o presionar ESC.

---

### Código PlantUML

```plantuml
@startuml
skinparam ConditionEndStyle hline

start

:Administrador se encuentra en el dashboard;

fork
  :Hace clic en "Nuevo Usuario"\nen la barra superior;
fork again
  :Hace clic en la tarjeta "Nuevo Usuario"\nen Acciones Rápidas;
end fork

:El sistema abre el modal \ncon el formulario de creación;
note right
Campos: nombre, email, contraseña,
confirmación, rol y foto de perfil.
end note

:Administrador diligencia el formulario;

:¿El administrador decide guardar los cambios?;
if () then (No)
  :El sistema cierra el modal sin cambios;
else (Sí)
  :El sistema procesa la solicitud;
  
  :¿Los campos obligatorios y formato son válidos?;
  if () then (No)
    :El sistema redirige de vuelta;
    :Reabre automáticamente el modal;
    :Muestra errores de validación;
  else (Sí)
    :El sistema crea el usuario;
    :Guarda la foto de perfil (si aplica);
    :Redirige al listado de usuarios;
    :Muestra mensaje: "Usuario creado exitosamente";
  endif
endif

stop

@enduml
```
