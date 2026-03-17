# Diagrama de Actividades: HU-TRB-007 (Detalle de Tarea)

**Historia de Usuario:** HU-TRB-007
**Rol:** Trabajador
**Acción:** Ver el detalle completo de una tarea que me ha sido asignada.
**Propósito:** Conocer todas las especificaciones del trabajo a realizar.

**Casos de Uso:**
1. **Ver detalle completo:** Título, estado, prioridad, descripción, ubicación, fecha límite, asignador.
2. **Aviso vinculación:** Si la tarea nació de un incidente, un banner indica el título original.
3. **Galería inicial (Admin):** Muestra fotos de referencia brindadas por quien asigna la tarea.
4. **Galería inicial (Trabajador):** Muestra fotos subidas por el trabajador de cómo encontró el fallo (o "Sin registros").
5. **Galería final (Trabajador):** Muestra fotos subidas del arreglo realizado (o "Sin registros").
6. **Zoom múltiple:** Clic en cualquier foto lanza un modal para ver ampliada (con botón descarga).
7. **Descripción final:** Si ya culminó el trabajo, expone en un bloque su comentario o descripción de cierre.
8. **Acceso denegado (Seguridad):** 404 si fuerza en URL el ID de una tarea de otro operario.

---

### Código PlantUML

```plantuml
@startuml
skinparam ConditionEndStyle hline

start

:Trabajador solicita ver el detalle \nde una tarea específica;

:El sistema valida la pertenencia de la tarea;

:¿La tarea solicitada pertenece \nal trabajador autenticado?;
if () then (No)
  :Denegar acceso e información;
  :Lanzar página de Error 404;
else (Sí)
  :Cargar datos técnicos (título, prioridad, \nfechas límite, descripción, ubicación);
  
  :¿Esta tarea fue convertida \ndesde un "Incidente" reportado?;
  if () then (Sí)
    :Generar y mostrar banner \ncon título del reporte original;
    :Agregar nombre del Instructor reportante;
  else (No)
  endif
  
  :Cargar y mostrar galería de "Referencia"\n(fotos subidas por el administrador);
  
  fork
    :Cargar bloque de \n"Evidencia Inicial";
    :¿El trabajador ya subió imágenes iniciales?;
    if () then (Sí)
      :Mostrar imágenes de \nla condición inicial;
    else (No)
      :Mostrar mensaje: "Sin registros iniciales";
    endif
  fork again
    :Cargar bloque de \n"Evidencia Final";
    :¿El trabajador ya subió imágenes \nfinales y descripción de resolución?;
    if () then (Sí)
      :Mostrar bloque con el texto descriptivo \nde la "Descripción Final del Trabajo";
      :Mostrar imágenes de \nla intervención finalizada;
    else (No)
      :Mostrar mensaje: "Sin registros finales";
    endif
  end fork
  
  :¿El trabajador hace clic en \nalguna imagen disponible de las galerías?;
  if () then (Sí)
    :Lanzar vista modal de visualización en tamaño \ncompleto (zoom) de dicha fotografía;
    :Habilitar la opción interactiva de "Descargar";
  else (No)
  endif
endif

stop
@enduml
```
