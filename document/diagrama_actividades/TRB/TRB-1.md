# Diagrama de Actividades: HU-TRB-001 (Inicio de Sesión)

**Historia de Usuario:** HU-TRB-001
**Rol:** Trabajador
**Acción:** Iniciar sesión en el sistema con mis credenciales.
**Propósito:** Acceder a mi panel de trabajo y gestionar las tareas de mantenimiento asignadas.

**Casos de Uso:**
1. **Inicio de sesión exitoso:** Autentica y redirige a `/worker/dashboard`.
2. **Credenciales incorrectas:** Muestra error y no permite el acceso.
3. **Redirección automática:** Redirige a `/worker/dashboard` al entrar a `/dashboard`.
4. **Acceso denegado a otros roles:** Bloquea acceso a rutas de administrador o instructor redirigiendo al dashboard del trabajador.

---

### Código PlantUML

```plantuml
@startuml
skinparam ConditionEndStyle hline

start

:Trabajador intenta iniciar sesión;
:Completa formulario de login con email y \ncontraseña, y hace clic en "Iniciar sesión";

:El sistema valida las credenciales;

:¿Las credenciales son correctas?;
if () then (No)
  :Mostrar mensaje de error;
  :Denegar acceso al sistema;
  kill
else (Sí)
  :El sistema autentica al usuario;
  
  :¿El trabajador intenta acceder a una ruta protegida\nde administrador (/admin/*) o instructor (/instructor/*)?;
  if () then (Sí)
    :Bloquear acceso por permisos insuficientes;
    :Redirigir automáticamente a /worker/dashboard;
  else (No)
    :¿El trabajador accede a la ruta \ngenérica /dashboard?;
    if () then (Sí)
      :Detectar el rol (Trabajador);
      :Redirigir automáticamente a /worker/dashboard;
    else (No)
      :Redirigir automáticamente a /worker/dashboard \ncomo ruta por defecto post-login;
    endif
  endif
  stop
endif

@enduml
```
