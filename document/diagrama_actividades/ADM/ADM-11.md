# Diagrama de Actividades: HU-ADM-011 (Editar Usuario)

**Historia de Usuario:** HU-ADM-011
**Rol:** Administrador
**Acción:** Editar los datos de un usuario existente en el sistema.
**Propósito:** Mantener la información actualizada o corregir datos incorrectos.

**Casos de Uso:**
1. **Edición exitosa:** Guarda los cambios y muestra mensaje de éxito.
2. **Email duplicado:** Muestra error si el email pertenece a otro usuario.
3. **Actualización de foto:** Si hay nueva foto, elimina la anterior y guarda la nueva.
4. **Imagen inválida:** Error si el formato no está permitido o supera los 2MB.

---

### Código PlantUML

```plantuml
@startuml
skinparam ConditionEndStyle hline

start

:Administrador diligencia los cambios del usuario;
:Hace clic en "Actualizar";

:El sistema procesa los datos;

:¿El email pertenece a otro usuario registrado?;
if () then (Sí)
  :Mostrar error: "El email ya está registrado";
  kill
else (No)
  :¿El administrador seleccionó una nueva foto?;
  if () then (Sí)
    :¿El formato de imagen es permitido y\nno supera los 2MB?;
    if () then (No)
      :Mostrar error de validación de imagen;
      kill
    else (Sí)
      :Eliminar la imagen anterior del servidor;
      :Guardar la nueva imagen;
    endif
  else (No)
    :Mantener la imagen actual;
  endif
  
  :El sistema guarda los cambios en la base de datos;
  :Muestra mensaje: "Usuario actualizado exitosamente";
  stop
endif

@enduml
```
