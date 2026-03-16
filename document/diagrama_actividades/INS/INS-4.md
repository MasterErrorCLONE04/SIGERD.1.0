# Diagrama de Actividades: HU-INS-004 (Cambiar Contraseña Autenticado)

**Historia de Usuario:** HU-INS-004
**Rol:** Instructor
**Acción:** Cambiar mi contraseña actual estando autenticado en el sistema.
**Propósito:** Actualizar mis credenciales de acceso por razones de seguridad.

**Casos de Uso:**
1. **Cambio exitoso:** Ingresa actual, nueva y confirmación correctas. Muestra `password-updated`.
2. **Actual incorrecta:** Muestra error y no realiza cambio.
3. **Nuevas no coinciden:** Muestra error y no actualiza.

---

### Código PlantUML

```plantuml
@startuml
skinparam ConditionEndStyle hline

start

:Instructor autenticado accede al formulario \nde cambio de contraseña en su perfil;
:Diligencia "Contraseña actual", "Nueva contraseña" \ny "Confirmar nueva contraseña";
:Hace clic en "Guardar";

:¿La contraseña actual ingresada es correcta?;
if () then (No)
  :Mostrar error de validación indicando \nque la contraseña actual es incorrecta;
  kill
else (Sí)
  :¿La nueva contraseña y su confirmación coinciden?;
  if () then (No)
    :Mostrar error de validación: \n"Las contraseñas no coinciden";
    kill
  else (Sí)
    :El sistema actualiza la contraseña en la base de datos;
    :Muestra el mensaje de éxito "password-updated";
    stop
  endif
endif

@enduml
```
