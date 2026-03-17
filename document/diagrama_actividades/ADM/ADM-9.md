# Diagrama de Actividades: HU-ADM-009 (Crear Usuario y Asignar Rol)

**Historia de Usuario:** HU-ADM-009
**Rol:** Administrador
**Acción:** Crear nuevos usuarios en el sistema y asignarles un rol específico.
**Propósito:** Gestionar el acceso de nuevos miembros del personal al sistema.

**Casos de Uso:**
1. **Creación de usuario con datos válidos:** Creación exitosa, guardado de foto y redirección.
2. **Email ya registrado:** Error por email en uso.
3. **Contraseñas no coinciden:** Error de validación (contraseña y confirmación).
4. **Foto de perfil obligatoria:** Error si no se selecciona foto.
5. **Formato de imagen inválido:** Error si la foto no es (jpeg, png, jpg, gif).
6. **Imagen excede tamaño máximo:** Error si foto supera 2MB.
7. **Asignación de rol:** Limita acceso según permisos del rol asignado.

---

### Código PlantUML

```plantuml
@startuml
skinparam ConditionEndStyle hline

start

:Administrador diligencia el formulario de nuevo usuario;
:Sube la foto de perfil y hace clic en "Guardar";

:El sistema recibe y procesa los datos;

:¿El email ya está registrado en el sistema?;
if () then (Sí)
  :Mostrar error de validación: "El email ya está en uso";
else (No)
  :¿Las contraseñas coinciden?;
  if () then (No)
    :Mostrar error de validación: "Las contraseñas no coinciden";
  else (Sí)
    :¿La foto de perfil fue seleccionada?;
    if () then (No)
      :Mostrar error de validación: "La foto de perfil es obligatoria";
    else (Sí)
      :¿El formato de la imagen es válido (jpeg, png, jpg, gif)?;
      if () then (No)
        :Mostrar error: "Formatos permitidos: jpeg, png, jpg, gif";
      else (Sí)
        :¿La imagen excede el tamaño máximo (2MB)?;
        if () then (Sí)
          :Mostrar error de validación por tamaño de archivo;
        else (No)
          :El sistema crea el usuario en la base de datos;
          :Asigna y guarda el rol seleccionado (limita acceso);
          :Guarda la foto de perfil en el servidor;
          :Redirige al listado de usuarios;
          :Muestra mensaje: "Usuario creado exitosamente";
        endif
      endif
    endif
  endif
endif

stop
@enduml
```
