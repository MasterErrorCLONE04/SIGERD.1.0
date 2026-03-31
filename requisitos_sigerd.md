# Requisitos Específicos y Funcionales - Sistema SIGERD

A continuación se detallan de forma estructurada y detallada los requisitos funcionales subdivididos para los 3 roles principales del sistema (Administrador, Instructor/Encargado y Trabajador), según el análisis de las funcionalidades existentes.

---

## 1. Rol: ADMINISTRADOR

| Campo | Descripción |
| :--- | :--- |
| **Número de requisito** | **RF-ADM-01** |
| **Nombre de requisito** | Gestión de Usuarios |
| **Tipo** | ☑ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | - Crear, editar, eliminar y asignar roles a los usuarios (trabajadores y encargados de dependencias).<br>- Restablecer contraseñas de usuarios. |
| **Prioridad del requisito**| ☑ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

<br>

| Campo | Descripción |
| :--- | :--- |
| **Número de requisito** | **RF-ADM-02** |
| **Nombre de requisito** | Dashboard con Métricas del Sistema |
| **Tipo** | ☑ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | - Muestra métricas principales en tiempo real: total de usuarios, tareas activas y tareas completadas.<br>- Incluye accesos rápidos al módulo de gestión de usuarios, tareas y reportes.<br>- Si no hay datos, mostrar mensajes: "No hay datos disponibles" o "Aún no hay tareas registradas". |
| **Prioridad del requisito**| ☑ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

<br>

| Campo | Descripción |
| :--- | :--- |
| **Número de requisito** | **RF-ADM-03** |
| **Nombre de requisito** | Gestión de Incidencias: Visualización y Filtros |
| **Tipo** | ☑ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | - Ver el listado histórico de todas las incidencias reportadas.<br>- Buscar incidencias específicas por título, descripción, ubicación o utilizando el nombre/email del usuario que reportó.<br>- Filtrar incidencias por fecha exacta de creación. |
| **Prioridad del requisito**| ☑ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

<br>

| Campo | Descripción |
| :--- | :--- |
| **Número de requisito** | **RF-ADM-04** |
| **Nombre de requisito** | Gestión de Incidencias: Conversión a Tareas |
| **Tipo** | ☑ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | - Permitir al administrador convertir un incidente reportado en una tarea operativa.<br>- Al convertir, se debe definir: título de la tarea, descripción, prioridad, fecha límite y ubicación.<br>- Trasladar automáticamente las imágenes de evidencia del incidente a las imágenes de referencia de la tarea.<br>- Actualizar el estado del incidente a "asignado". |
| **Prioridad del requisito**| ☑ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

<br>

| Campo | Descripción |
| :--- | :--- |
| **Número de requisito** | **RF-ADM-05** |
| **Nombre de requisito** | Gestión de Tareas: Creación Directa y Asignación |
| **Tipo** | ☑ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | - Crear tareas independientemente de un incidente.<br>- Asignar prioridad (Baja, Media, Alta) y un trabajador responsable.<br>- Permitir subir múltiples imágenes de evidencia inicial y de referencia (máx. 2MB, formatos: jpeg, jpg, png, gif). |
| **Prioridad del requisito**| ☑ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

<br>

| Campo | Descripción |
| :--- | :--- |
| **Número de requisito** | **RF-ADM-06** |
| **Nombre de requisito** | Gestión de Tareas: Revisión y Aprobación |
| **Tipo** | ☑ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | - Interfaz para revisar tareas subidas por trabajadores en estado "realizada".<br>- **Acción Aprobar:** Pasa a estado "finalizada". Si viene de un incidente, marca el incidente también como "resuelto".<br>- **Acción Rechazar:** Pasa a "en progreso" para que el trabajador lo corrija.<br>- **Acción Retrasar:** Cambia el estado a "retraso en proceso". |
| **Prioridad del requisito**| ☑ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

<br>

| Campo | Descripción |
| :--- | :--- |
| **Número de requisito** | **RF-ADM-07** |
| **Nombre de requisito** | Generación de Reportes PDF |
| **Tipo** | ☑ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | - Exportar reportes detallados en PDF (seleccionando mes y año).<br>- Incluir estadísticas: total de tareas, desglose por prioridad, tiempo promedio de finalización de tareas y un top de tareas completadas según trabajador. |
| **Prioridad del requisito**| ☑ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

<br>

| Campo | Descripción |
| :--- | :--- |
| **Número de requisito** | **RF-ADM-08** |
| **Nombre de requisito** | Recepción de Notificaciones |
| **Tipo** | ☑ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | - Recibir notificaciones en tiempo real cuando un instructor reporta un nuevo incidente.<br>- Recibir notificaciones cuando un trabajador actualiza de estado una tarea, cuando la inicia o cuando la marca como "realizada". |
| **Prioridad del requisito**| ☐ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☑ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

---

## 2. Rol: INSTRUCTOR (Encargado de Dependencia)

| Campo | Descripción |
| :--- | :--- |
| **Número de requisito** | **RF-INC-01** |
| **Nombre de requisito** | Registro de Incidentes |
| **Tipo** | ☑ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | - Formulario para reportar incidentes solicitando: título, descripción detallada y ubicación.<br>- Validar la subida mínima de 1 imagen y máxima de 10 imágenes fotográficas como evidencia inicial, sin exceder los 2MB de peso y en formatos permitidos (jpg, png).<br>- La fecha de reporte no puede ser mayor al día de hoy. |
| **Prioridad del requisito**| ☑ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

<br>

| Campo | Descripción |
| :--- | :--- |
| **Número de requisito** | **RF-INC-02** |
| **Nombre de requisito** | Historial y Seguimiento de Sus Incidentes |
| **Tipo** | ☑ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | - Ver un listado con los incidentes reportados únicamente por el propio instructor.<br>- Funcionalidades para buscar y filtrar sus propios registros según el estado (Pendiente de revisión, Asignado, En Progreso, Resuelto).<br>- Ordenamiento predeterminado mostrando el reporte más reciente de primero. |
| **Prioridad del requisito**| ☑ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

<br>

| Campo | Descripción |
| :--- | :--- |
| **Número de requisito** | **RF-INC-03** |
| **Nombre de requisito** | Visualización Visual de Incidentes |
| **Tipo** | ☑ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | - Posibilidad de ver el detalle individual de su reporte ingresado para constatar las fotos y la descripción cargada inicialmente. |
| **Prioridad del requisito**| ☑ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

<br>

| Campo | Descripción |
| :--- | :--- |
| **Número de requisito** | **RF-INC-04** |
| **Nombre de requisito** | Recepción de Notificaciones y Alertas |
| **Tipo** | ☑ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | - El sistema debe notificar al Instructor responsable cuando el Administrador convierta su incidente reportado en una tarea de trabajo operativa, lo que le indicará que ya se encuentra una solución en progreso. |
| **Prioridad del requisito**| ☐ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☑ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

---

## 3. Rol: TRABAJADOR

| Campo | Descripción |
| :--- | :--- |
| **Número de requisito** | **RF-TRA-01** |
| **Nombre de requisito** | Visualización de Tareas Asignadas |
| **Tipo** | ☑ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | - Visualizar un panel exclusivo con las tareas que el Administrador ha delegado a su cuenta.<br>- Aplicar automáticamente un ordenamiento por nivel de urgencia, mostrando primero las tareas con fecha límite más próxima. |
| **Prioridad del requisito**| ☑ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

<br>

| Campo | Descripción |
| :--- | :--- |
| **Número de requisito** | **RF-TRA-02** |
| **Nombre de requisito** | Busqueda y Filtrado de Carga Operativa |
| **Tipo** | ☑ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | - Herramientas para que el trabajador pueda buscar tareas por título/descripción y filtrar el contenido del listado por "Estado" (Pendiente, En progreso) y por "Prioridad" (Baja, Media, Alta). |
| **Prioridad del requisito**| ☐ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☑ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

<br>

| Campo | Descripción |
| :--- | :--- |
| **Número de requisito** | **RF-TRA-03** |
| **Nombre de requisito** | Actualización y Comienzo de Tarea (Evidencia Inicial) |
| **Tipo** | ☑ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | - Permitir al operario subir imágenes fotográficas del estado en el que encontró el problema antes de operarlo.<br>- Al subir la evidencia inicial, el sistema debe cambiar el estado de la tarea automáticamente de "asignado" a "en progreso". |
| **Prioridad del requisito**| ☑ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

<br>

| Campo | Descripción |
| :--- | :--- |
| **Número de requisito** | **RF-TRA-04** |
| **Nombre de requisito** | Registro de Resolución, Descripción y Evidencias |
| **Tipo** | ☑ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | - Al finalizar la labor, requerir al trabajador cargar de forma simultánea imágenes de evidencia final (hasta 2MB por foto) y redactar una conclusión o texto descriptivo sobre la resolución obtenida.<br>- Al completarlo, cambiar el estado automáticamente a "realizada". |
| **Prioridad del requisito**| ☑ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

<br>

| Campo | Descripción |
| :--- | :--- |
| **Número de requisito** | **RF-TRA-05** |
| **Nombre de requisito** | Recepción de Notificaciones |
| **Tipo** | ☑ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | - Obtener notificaciones push/mensajes del sistema automáticamente cada vez que un administrador genere y asigne directamente una nueva tarea o convierta el reporte de un instructor en una tarea delegada a su persona. |
| **Prioridad del requisito**| ☐ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☑ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |
