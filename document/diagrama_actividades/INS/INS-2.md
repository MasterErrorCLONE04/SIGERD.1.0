# Diagrama de Actividades: HU-INS-002 (Cierre de Sesión)

**Historia de Usuario:** HU-INS-002
**Rol:** Instructor
**Acción:** Cerrar la sesión activa en el sistema.
**Propósito:** Proteger mi cuenta y garantizar que nadie más pueda acceder a mi información.

**Casos de Uso:**
1. **Cierre de sesión exitoso:** Invalida sesión, destruye token y redirige a `/login`.
2. **Acceso bloqueado post-cierre:** Redirige al login si intenta acceder a rutas protegidas sin sesión.
3. **No retorno con botón atrás:** Redirige al login si usa el botón atrás del navegador.

---

### Código PlantUML

```plantuml
@startuml
skinparam ConditionEndStyle hline

start

:Instructor autenticado hace clic en "Cerrar Sesión";

:El sistema recibe y procesa la solicitud;
:Invalida la sesión activa en el servidor;
:Destruye el token de autenticación del usuario;
:Redirige al instructor a la página pública (/login);

fork
  :¿El instructor intenta acceder directamente \na rutas protegidas (ej: /instructor/dashboard)?;
  if () then (Sí)
    :El sistema detecta ausencia de sesión válida;
    :Redirige automáticamente al /login;
  else (No)
  endif
fork again
  :¿El instructor usa el botón "Atrás" \ndel navegador web para volver al panel?;
  if () then (Sí)
    :La vista protegida valida estado de sesión;
    :Al no existir sesión, redirige \nnuevamente al /login;
  else (No)
  endif
end fork

stop
@enduml
```
