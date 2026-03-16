# Diagrama de Actividades: HU-INS-003 (Recuperar Contraseña)

**Historia de Usuario:** HU-INS-003
**Rol:** Instructor
**Acción:** Recuperar el acceso a mi cuenta cuando olvido mi contraseña.
**Propósito:** Restablecer mi contraseña de forma segura a través de mi correo.

**Casos de Uso:**
1. **Solicitud con email válido:** Envía enlace y muestra confirmación.
2. **Email no registrado:** Muestra mensaje de que no hay cuenta asociada.
3. **Campo vacío:** Error de validación.
4. **Restablecimiento exitoso:** Actualiza contraseña, invalida token y redirige a `/login`.
5. **No coinciden:** Error si confirmación no es igual.
6. **Token inválido/expirado:** Muestra error si el enlace caducó o es falso.

---

### Código PlantUML

```plantuml
@startuml
skinparam ConditionEndStyle hline

start

:Instructor accede a /forgot-password;
:Ingresa su email y hace clic en "Enviar enlace";

:¿Campo email vacío?;
if () then (Sí)
  :Mostrar error de validación;
  kill
else (No)
  :¿Email registrado en el sistema?;
  if () then (No)
    :Mostrar mensaje: "No existe cuenta asociada";
    kill
  else (Sí)
    :Sistema envía enlace de restablecimiento al correo;
    :Mostrar mensaje de confirmación;
  endif
endif

:Instructor accede al enlace recibido (/reset-password/{token});

:¿Token válido y no expirado?;
if () then (No)
  :Mostrar mensaje: "Token inválido o expirado";
  kill
else (Sí)
  :Diligencia nueva contraseña y confirmación;
  
  :¿Contraseñas coinciden?;
  if () then (No)
    :Mostrar error de validación por no coincidencia;
    kill
  else (Sí)
    :Sistema actualiza la contraseña en la BD;
    :Invalida el token para un solo uso;
    :Redirige al /login;
    :Mostrar mensaje de éxito;
    stop
  endif
endif

@enduml
```
