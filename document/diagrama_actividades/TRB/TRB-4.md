# Diagrama de Actividades: HU-TRB-004 (Cambiar Contraseña Autenticado)

**Historia de Usuario:** HU-TRB-004
**Rol:** Trabajador
**Acción:** Cambiar mi contraseña actual estando autenticado en el sistema.
**Propósito:** Actualizar credenciales de acceso por seguridad.

**Casos de Uso:**
1. **Cambio exitoso:** Ingresa datos válidos, actualiza y muestra éxito.
2. **Actual incorrecta:** Muestra error de validación indicando contraseña incorrecta.
3. **Nuevas no coinciden:** Muestra error y no actualiza contraseñas.

---

### Código PlantUML

```plantuml
@startuml
skinparam ConditionEndStyle hline

start

:Trabajador autenticado accede al formulario \nde cambio de contraseña en su perfil;
:Diligencia "Contraseña actual", "Nueva contraseña" \ny "Confirmar nueva contraseña";
:Hace clic en "Guardar";

:¿La contraseña actual ingresada es correcta?;
if () then (No)
  :Mostrar error indicando que la \ncontraseña actual es incorrecta;
else (Sí)
  :¿La nueva contraseña y su confirmación coinciden?;
  if () then (No)
    :Mostrar error de validación: \n"Las contraseñas no coinciden";
  else (Sí)
    :El sistema actualiza la contraseña en la base de datos;
    :Muestra el mensaje de éxito "password-updated";
  endif
endif

stop
@enduml
```
