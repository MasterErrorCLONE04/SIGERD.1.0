# Diagrama de Actividades: HU-ADM-003 (Recuperar Contraseña)

**Historia de Usuario:** HU-ADM-003
**Rol:** Administrador
**Acción:** Recuperar el acceso a mi cuenta cuando olvido mi contraseña
**Propósito:** Restablecer mi contraseña de forma segura a través de mi correo electrónico registrado.

**Casos de Uso:**
1. **Solicitud de restablecimiento con email válido:** Envía enlace de restablecimiento.
2. **Solicitud con email no registrado:** Muestra mensaje de cuenta no existente.
3. **Campo email vacío:** Muestra error de validación (campo obligatorio).
4. **Restablecimiento exitoso mediante token:** Actualiza contraseña e invalida token.
5. **Contraseñas no coinciden:** Error de validación al intentar cambiar la contraseña.
6. **Token inválido o expirado:** Error que impide el cambio de contraseña.

---

### Código PlantUML

```plantuml
@startuml
skinparam ConditionEndStyle hline

start

:Administrador accede a /forgot-password;
:Ingresa su email y hace clic en "Enviar enlace";

:¿Campo email vacío?;
if () then (Sí)
  :Mostrar error de validación: "Campo email es obligatorio";
  kill
else (No)
  :¿Email registrado en el sistema?;
  if () then (No)
    :Mostrar mensaje: "No existe cuenta asociada a ese email";
    kill
  else (Sí)
    :Sistema envía enlace de restablecimiento al correo;
    :Mostrar mensaje: "Enlace enviado";
  endif
endif

:Administrador accede a /reset-password/{token};

:¿Token válido y no expirado?;
if () then (No)
  :Mostrar mensaje: "Token inválido o expirado";
  kill
else (Sí)
  :Diligencia nueva contraseña y confirmación;
  
  :¿Contraseñas coinciden?;
  if () then (No)
    :Mostrar error de validación: "Las contraseñas no coinciden";
    kill
  else (Sí)
    :Sistema actualiza la contraseña;
    :Invalida el token;
    :Redirige a /login;
    :Mostrar mensaje de éxito;
    stop
  endif
endif

@enduml
```
