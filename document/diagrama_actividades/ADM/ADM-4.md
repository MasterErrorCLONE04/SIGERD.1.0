# Diagrama de Actividades: HU-ADM-004 (Cambiar Contraseña Estando Autenticado)

**Historia de Usuario:** HU-ADM-004
**Rol:** Administrador
**Acción:** Cambiar mi contraseña actual estando autenticado en el sistema.
**Propósito:** Actualizar credenciales de acceso por razones de seguridad.

**Casos de Uso:**
1. **Cambio exitoso de contraseña:** El administrador ingresa correctamente su contraseña actual y la nueva.
2. **Contraseña actual incorrecta:** La contraseña actual ingresada no coincide con la almacenada.
3. **Contraseñas nuevas no coinciden:** La nueva contraseña y su confirmación son diferentes.
4. **Contraseña no cumple requisitos:** La nueva contraseña no cumple con las reglas mínimas de seguridad.

---

### Código PlantUML

```plantuml
@startuml
skinparam ConditionEndStyle hline

start

:Administrador autenticado accede a la vista de perfil / configuración;
:Diligencia "Contraseña actual", "Nueva contraseña" y "Confirmar nueva contraseña";
:Hace clic en "Guardar";

:¿Contraseña actual es correcta?;
if () then (No)
  :Mostrar error de validación: "La contraseña actual es incorrecta";
  kill
else (Sí)
  :¿Contraseña nueva cumple requisitos de seguridad?;
  if () then (No)
    :Mostrar mensaje: "La contraseña no cumple los requisitos mínimos";
    kill
  else (Sí)
    :¿Contraseña nueva y confirmación coinciden?;
    if () then (No)
      :Mostrar error de validación: "Las contraseñas no coinciden";
      kill
    else (Sí)
      :Sistema actualiza la contraseña en la base de datos;
      :Mostrar mensaje de éxito en la misma página;
      stop
    endif
  endif
endif

@enduml
```
