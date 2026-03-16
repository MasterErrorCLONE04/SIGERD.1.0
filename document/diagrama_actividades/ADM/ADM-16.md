# Diagrama de Actividades: HU-ADM-016 (Editar Tarea)

**Historia de Usuario:** HU-ADM-016
**Rol:** Administrador
**Acción:** Editar los datos de una tarea existente.
**Propósito:** Actualizar información o reasignar recursos.

**Casos de Uso:**
1. **Edición exitosa:** Guarda los cambios y muestra mensaje de éxito.
2. **Cambio de estado:** Actualiza el estado seleccionado de la tarea.
3. **Adición de imágenes:** Guarda nuevas imágenes junto con las existentes.
4. **Fecha límite vencida:** Si la fecha pasó y no está finalizada, el estado cambia automáticamente a "incompleta".

---

### Código PlantUML

```plantuml
@startuml
skinparam ConditionEndStyle hline

start

:Administrador edita los datos de la tarea;
:Hace clic en "Guardar / Actualizar";

:¿Los datos ingresados son válidos?;
if () then (No)
  :Mostrar errores de validación;
  kill
else (Sí)
  :¿El administrador agregó nuevas imágenes?;
  if () then (Sí)
    :Guardar las nuevas imágenes junto con \nlas existentes en el servidor;
  else (No)
  endif
  
  :¿La fecha límite ya pasó y la tarea no\nha sido marcada como finalizada?;
  if () then (Sí)
    :Cambiar el estado a "Incompleta" \nautomáticamente;
  else (No)
    :¿El administrador cambió el \nestado manualmente?;
    if () then (Sí)
      :Actualizar la tarea con el \nnuevo estado seleccionado;
    else (No)
    endif
  endif
  
  :Guardar todos los cambios en la base de datos;
  :Redirigir con mensaje: \n"Tarea actualizada exitosamente";
  stop
endif

@enduml
```
