# Requisitos Funcionales - SIGERD

Este documento detalla los requisitos funcionales del sistema SIGERD, especificando el comportamiento y funciones que el sistema debe soportar.

---

## 1. Rol: Administrador

### RF-ADM-01
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RF-ADM-01** |
| **Nombre de requisito** | Autenticación y Acceso al Sistema |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • ADM-AUT-001, ADM-AUT-002<br>El sistema debe permitir al administrador iniciar sesión mediante correo electrónico y contraseña. Una vez autenticado exitosamente, el sistema debe redirigir automáticamente al Dashboard sin pasos intermedios. El sistema debe validar las credenciales contra la base de datos y gestionar sesiones activas, impidiendo el acceso con credenciales incorrectas o campos vacíos. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RF-ADM-02
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RF-ADM-02** |
| **Nombre de requisito** | Dashboard con Métricas del Sistema |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • ADM-DAS-003, ADM-DAS-004, ADM-DAS-006<br>El sistema debe mostrar en el Dashboard del administrador métricas principales: total de usuarios registrados, tareas activas y tareas completadas. Debe incluir accesos rápidos mediante íconos o botones a los módulos de gestión de usuarios, tareas y reportes. Cuando no existan datos registrados, el sistema debe mostrar mensajes informativos como "No hay datos disponibles" o "Aún no hay tareas registradas". |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RF-ADM-03
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RF-ADM-03** |
| **Nombre de requisito** | Interfaz Responsive del Dashboard |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • ADM-DAS-005<br>El sistema debe garantizar que el Dashboard y todos sus componentes sean completamente adaptables (responsive) a diferentes tamaños de pantalla: dispositivos móviles, tablets y PC. El diseño debe ajustarse automáticamente usando Tailwind CSS, manteniendo la funcionalidad y legibilidad en todos los dispositivos. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RF-ADM-04
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RF-ADM-04** |
| **Nombre de requisito** | Gestión Completa de Trabajadores (CRUD) |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • ADM-TRAB-007, ADM-TRAB-008, ADM-TRAB-009, ADM-TRAB-010<br>El sistema debe permitir al administrador crear, editar y eliminar cuentas de trabajadores. En la creación y edición, el sistema debe validar que todos los campos obligatorios estén completos (nombre, correo, contraseña, teléfono). Debe permitir asignar el rol "Trabajador" y guardar la información en la base de datos. La eliminación debe solicitar confirmación y actualizar automáticamente las listas de usuarios. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RF-ADM-05
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RF-ADM-05** |
| **Nombre de requisito** | Gestión Completa de Instructores (CRUD) |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • ADM-INST-012, ADM-INST-013, ADM-INST-014, ADM-INST-015<br>El sistema debe permitir al administrador crear, editar y eliminar cuentas de instructores. Debe validar campos obligatorios (nombre, correo, contraseña, teléfono) y permitir asignar el rol "Instructor". La funcionalidad debe ser equivalente a la gestión de trabajadores, con confirmación en eliminaciones y actualización automática de listados. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RF-ADM-06
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RF-ADM-06** |
| **Nombre de requisito** | Creación de Tareas con Prioridad |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • ADM-TAR-017<br>El sistema debe permitir al administrador crear tareas de mantenimiento con los siguientes campos obligatorios: título, descripción, ubicación, fecha límite y prioridad. Las opciones de prioridad deben ser: Baja, Media, Alta y Urgente. El sistema debe validar que todos los campos estén completos y que la prioridad sea válida antes de guardar. Si falta información, debe mostrar mensajes específicos como "Todos los campos son obligatorios" o "Seleccione la prioridad de la tarea". |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RF-ADM-07
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RF-ADM-07** |
| **Nombre de requisito** | Edición y Eliminación de Tareas |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • ADM-TAR-018, ADM-TAR-019<br>El sistema debe permitir al administrador editar cualquier campo de una tarea existente (título, descripción, ubicación, fecha, prioridad, trabajador asignado, estado). También debe permitir eliminar tareas con confirmación previa. La eliminación debe actualizar automáticamente la lista de tareas y las métricas del Dashboard. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RF-ADM-08
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RF-ADM-08** |
| **Nombre de requisito** | Asignación de Trabajadores a Tareas |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • ADM-TAR-020<br>El sistema debe permitir al administrador asignar un trabajador a cada tarea de mantenimiento desde el formulario de creación o edición. Al realizar la asignación, el sistema debe registrar la relación en la base de datos y enviar una notificación automática al trabajador asignado informándole sobre la nueva tarea. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RF-ADM-09
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RF-ADM-09** |
| **Nombre de requisito** | Gestión de Estados de Tareas |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • ADM-TAR-021<br>El sistema debe permitir al administrador cambiar el estado de las tareas entre: Pendiente, En Progreso y Finalizada. El cambio de estado debe reflejarse inmediatamente en la interfaz y en el Dashboard. Cuando una tarea cambie a "Finalizada", debe registrarse automáticamente en el historial con fecha y hora. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RF-ADM-10
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RF-ADM-10** |
| **Nombre de requisito** | Visualización de Lista de Tareas |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • ADM-TAR-022<br>El sistema debe mostrar una lista completa de todas las tareas registradas con la siguiente información: nombre/título, estado actual, trabajador asignado (si existe), prioridad y fecha límite. Si no existen tareas registradas, debe mostrar el mensaje "Aún no hay tareas registradas" con un botón de acceso rápido para crear la primera tarea. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RF-ADM-11
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RF-ADM-11** |
| **Nombre de requisito** | Filtrado de Tareas por Múltiples Criterios |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • ADM-TAR-023<br>El sistema debe permitir al administrador filtrar tareas por: estado (Pendiente, En Progreso, Finalizada), trabajador asignado y prioridad (Baja, Media, Alta, Urgente). Los filtros deben aplicarse dinámicamente sin recargar la página. Si no hay coincidencias, debe mostrar mensaje "No se encontraron tareas con esos criterios". El sistema debe validar que solo se utilicen valores permitidos en los filtros. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RF-ADM-12
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RF-ADM-12** |
| **Nombre de requisito** | Historial de Tareas Completadas |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • ADM-REP-024<br>El sistema debe mantener un historial de todas las tareas finalizadas con los siguientes datos: fecha de finalización, descripción de la tarea, trabajador asignado, estado final y tiempo de ejecución. El historial debe ser consultable desde un módulo específico. Si no hay tareas finalizadas, debe mostrar "No hay tareas registradas en el historial". |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RF-ADM-13
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RF-ADM-13** |
| **Nombre de requisito** | Generación de Reportes Estadísticos con Gráficas |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • ADM-REP-025<br>El sistema debe generar reportes estadísticos visuales que incluyan: tareas por estado (gráfica de torta o barras), tareas por prioridad, tareas por trabajador, y tendencias temporales (gráfica de líneas). Debe utilizar bibliotecas como Recharts o Chart.js. Si no existen datos suficientes, debe mostrar "No hay datos para generar el reporte" con sugerencia de registrar más actividad. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RF-ADM-14
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RF-ADM-14** |
| **Nombre de requisito** | Visualización de Perfil Personal |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • ADM-PER-026<br>El sistema debe permitir al administrador visualizar su perfil con la siguiente información: nombre completo, correo electrónico, rol (Administrador), fecha de creación de la cuenta y foto de perfil (si existe). Si los datos están incompletos, debe mostrar "Datos de perfil no disponibles" con opción para completarlos. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RF-ADM-15
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RF-ADM-15** |
| **Nombre de requisito** | Edición de Perfil Personal |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • ADM-PER-027<br>El sistema debe permitir al administrador editar sus datos personales: nombre, correo electrónico y foto de perfil. Debe validar que el correo tenga formato válido y que el nombre no esté vacío. Al guardar cambios exitosamente, debe mostrar "Perfil actualizado correctamente". Si hay errores de validación, debe indicar específicamente qué campo es inválido. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RF-ADM-16
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RF-ADM-16** |
| **Nombre de requisito** | Cambio de Contraseña |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • ADM-PER-028<br>El sistema debe permitir al administrador cambiar su contraseña desde el perfil. Debe solicitar: contraseña actual, nueva contraseña y confirmación de nueva contraseña. Debe validar que la contraseña actual sea correcta, que la nueva cumpla requisitos de seguridad (mínimo 8 caracteres) y que ambas contraseñas nuevas coincidan. Al cambiar exitosamente, debe mostrar "Contraseña cambiada con éxito". |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RF-ADM-17
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RF-ADM-17** |
| **Nombre de requisito** | Notificaciones de Tareas Completadas |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • ADM-NOT-029<br>El sistema debe enviar notificaciones automáticas al administrador cuando un trabajador marque una tarea como finalizada. La notificación debe incluir: nombre del trabajador, título de la tarea y fecha/hora de finalización. Debe mostrarse en el panel de notificaciones dentro de la aplicación y opcionalmente por correo electrónico. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RF-ADM-18
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RF-ADM-18** |
| **Nombre de requisito** | Notificaciones de Reportes de Fallas |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • ADM-NOT-030<br>El sistema debe enviar notificaciones automáticas al administrador cuando un instructor registre un nuevo reporte de falla. La notificación debe incluir: nombre del instructor, descripción breve de la falla, ubicación y prioridad (si fue asignada). Debe aparecer en el panel de notificaciones y opcionalmente por correo. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RF-ADM-19
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RF-ADM-19** |
| **Nombre de requisito** | Cierre de Sesión |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • ADM-CER-031<br>El sistema debe permitir al administrador cerrar sesión desde cualquier módulo mediante un botón claramente identificado en el menú. Al cerrar sesión, el sistema debe eliminar la sesión activa, limpiar tokens de autenticación y redirigir al formulario de inicio de sesión. También debe cerrar automáticamente la sesión después de un período de inactividad configurado, mostrando el mensaje "Tu sesión ha expirado por inactividad". |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RF-ADM-20
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RF-ADM-20** |
| **Nombre de requisito** | Recuperación de Contraseña |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • ADM-REC-032<br>El sistema debe permitir al administrador recuperar su contraseña desde el formulario de inicio de sesión mediante la opción "Olvidé mi contraseña". Al ingresar su correo registrado, el sistema debe enviar un enlace temporal (válido por 1 hora) para restablecer la contraseña. Desde ese enlace, el administrador debe poder ingresar una nueva contraseña que cumpla los requisitos de seguridad. Si el correo no está registrado, debe mostrar "El correo no está registrado en el sistema". |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RF-ADM-21
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RF-ADM-21** |
| **Nombre de requisito** | Módulo de Visualización y Gestión de Incidencias |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • ADM-INC-033<br>El sistema debe permitir al administrador acceder a un listado centralizado donde visualice cronológicamente todos los reportes de falla levantados por los Instructores. Se debe mostrar la información detallada de cada reporte, incluyendo título, descripción, prioridad sugerida, ubicación exacta y hasta 10 evidencias fotográficas adjuntas por registro. Debe incluir búsquedas por texto y filtrado por estado. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RF-ADM-22
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RF-ADM-22** |
| **Nombre de requisito** | Conversión Inmediata de Incidencias a Tareas Activas |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • ADM-INC-034<br>El sistema debe brindar un botón explícito de "Convertir en Tarea" en los reportes de incidentes. Al accionarse, la plataforma migrará automáticamente todos los datos originales (incluidas las fotografías iniciales) a una vista de "Creación de Tarea", obligando al Administrador únicamente a asignar una fecha límite, ajustar la prioridad real y delegarle la ejecución a un Trabajador específico. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RF-ADM-23
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RF-ADM-23** |
| **Nombre de requisito** | Ciclo de Revisión y Control de Calidad (Visto Bueno) |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • ADM-WF-035<br>Cuando el responsable (trabajador) envíe una tarea cambiándole su estatus a "Pendiente de Revisión", el sistema debe desplegarle al Administrador una vista especializada de inspección. Allí contrastará las fotos del problema inicial versus las fotos de evidencia finales subidas por el trabajador, y tendrá la potestad indelegable de "Aprobar" (cifrando la tarea como finalizada permanentemente), rechazarla o marcarla como demorada obligando al trabajador a rehacer el encargo. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RF-ADM-24
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RF-ADM-24** |
| **Nombre de requisito** | Exportación de Reportes Estáticos Mensuales (Vía DomPDF) |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • ADM-REP-036<br>Además de las métricas visuales mostradas en el Dashboard de estadísticas, el sistema debe proveer al Administrador la capacidad de emitir un reporte tangible de mantenimiento extrayendo de la base de datos todas las órdenes de trabajo debidamente finiquitadas dentro del mes en curso o periodos adyacentes. El informe será ensamblado y despachado de manera síncrona/asíncrona directamente como un archivo documentario PDF listo para su descarga, impresión o guardado digital. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |
