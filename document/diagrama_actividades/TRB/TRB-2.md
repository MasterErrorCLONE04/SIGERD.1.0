# Diagrama de Actividades: HU-TRB-002 (Cierre de Sesión)

**Historia de Usuario:** HU-TRB-002
**Rol:** Trabajador
**Acción:** Cerrar la sesión activa en el sistema.
**Propósito:** Proteger mi cuenta cuando termino de trabajar.

**Casos de Uso:**
1. **Cierre de sesión exitoso:** Invalida sesión y redirige a `/login`.
2. **Acceso bloqueado post-cierre:** Redirige al login si intenta acceder a rutas protegidas sin sesión.
3. **Bloqueo con botón atrás:** Redirige al login si usa el botón atrás del navegador después de salir.

---

### Código PlantUML

```plantuml
@startuml
skinparam ConditionEndStyle hline

start

:Trabajador autenticado hace clic en "Cerrar Sesión";

:El sistema recibe y procesa la solicitud;
:Invalida la sesión activa en el servidor;
:Destruye el token de autenticación del usuario;
:Redirige al trabajador a la página pública (/login);

fork
  :¿El trabajador intenta acceder directamente \na rutas protegidas (ej: /worker/dashboard)?;
  if () then (Sí)
    :El sistema detecta ausencia de sesión válida;
    :Redirige automáticamente al /login;
  else (No)
  endif
fork again
  :¿El trabajador usa el botón "Atrás" \ndel navegador web para volver al panel?;
  if () then (Sí)
    :La vista protegida valida el estado de la sesión;
    :Al no existir sesión, redirige \nnuevamente al /login;
  else (No)
  endif
end fork

stop
@enduml
```
