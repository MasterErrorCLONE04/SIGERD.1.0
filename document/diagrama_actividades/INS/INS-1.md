# Diagrama de Actividades: HU-INS-001 (Inicio de Sesión)

**Historia de Usuario:** HU-INS-001
**Rol:** Instructor
**Acción:** Iniciar sesión en el sistema con mis credenciales.
**Propósito:** Acceder a mi panel de reportes y gestionar las fallas que identifico en el centro.

**Casos de Uso:**
1. **Inicio de sesión exitoso:** Autentica y redirige a `/instructor/dashboard`.
2. **Credenciales incorrectas:** Muestra error y no permite el acceso.
3. **Redirección automática:** Redirige a `/instructor/dashboard` al entrar a `/dashboard`.
4. **Acceso denegado a admin:** Bloquea acceso a rutas de administrador redirigiendo al dashboard del instructor.

---

### Código PlantUML

```plantuml
@startuml
skinparam ConditionEndStyle hline

start

:Instructor intenta iniciar sesión;
:Completa formulario de login con email y \ncontraseña, y hace clic en "Iniciar sesión";

:El sistema valida las credenciales;

:¿Las credenciales son correctas?;
if () then (No)
  :Mostrar mensaje de error;
  :Denegar acceso al sistema;
  kill
else (Sí)
  :El sistema autentica al usuario;
  
  :¿El instructor intenta acceder a \nuna ruta protegida de administrador (/admin/*)?;
  if () then (Sí)
    :Bloquear acceso por permisos insuficientes;
    :Redirigir automáticamente a /instructor/dashboard;
  else (No)
    :¿El instructor accede a la ruta \ngenérica /dashboard?;
    if () then (Sí)
      :Detectar el rol (Instructor);
      :Redirigir automáticamente a /instructor/dashboard;
    else (No)
      :Redirigir automáticamente a /instructor/dashboard \ncomo ruta por defecto post-login;
    endif
  endif
  stop
endif

@enduml
```
