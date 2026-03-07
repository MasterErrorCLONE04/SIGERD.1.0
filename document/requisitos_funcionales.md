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


## 2. Rol: Instructor (Encargado de Dependencia)

### RF-INS-01
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RF-INS-01** |
| **Nombre de requisito** | Autenticación y Acceso al Sistema |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • INST-AUT-001, INST-AUT-002<br>El sistema debe permitir al instructor iniciar sesión mediante correo electrónico y contraseña. Una vez autenticado exitosamente, el sistema debe redirigir automáticamente al Dashboard del instructor sin pasos intermedios. Si las credenciales son incorrectas, debe mostrar "Usuario o contraseña incorrectos". Si la cuenta está desactivada o bloqueada, debe impedir el acceso y mostrar "Cuenta desactivada. Contacte al Administrador", sin permitir el inicio de sesión hasta que el administrador reactive la cuenta. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RF-INS-02
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RF-INS-02** |
| **Nombre de requisito** | Dashboard con Resumen de Reportes por Estado |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • INST-DASH-003, INST-DASH-006<br>El sistema debe mostrar en el Dashboard del instructor un resumen visual de sus reportes de fallas organizados por estado mediante tarjetas o widgets que muestren el conteo de:<br>• Reportes Pendientes (sin asignar)<br>• Reportes En Atención (con trabajador asignado)<br>• Reportes Resueltos (finalizados)<br>Si el instructor no ha creado reportes, debe mostrar el mensaje "Aún no has registrado fallas" junto con un botón de llamada a la acción (CTA) "Reportar Falla" que redirija al formulario de creación. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RF-INS-03
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RF-INS-03** |
| **Nombre de requisito** | Acceso Rápido al Módulo de Reportar Falla |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • INST-DASH-004<br>El sistema debe proporcionar un acceso rápido y destacado desde el Dashboard mediante un botón CTA (Call To Action) claramente visible etiquetado como "Reportar Falla" o "Nueva Falla". Al hacer clic, debe redirigir inmediatamente al formulario de creación de reportes. Este botón debe estar siempre disponible y en una posición prominente (por ejemplo, esquina superior derecha o centro del Dashboard). |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RF-INS-04
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RF-INS-04** |
| **Nombre de requisito** | Interfaz Responsive del Dashboard |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • INST-DASH-005<br>El sistema debe garantizar que el Dashboard del instructor y todas sus funcionalidades sean completamente adaptables (responsive) a diferentes dispositivos: PC, tablet y móvil. El layout debe ajustarse automáticamente con menú colapsable en móviles, tarjetas de resumen apiladas verticalmente en pantallas pequeñas, y botones/enlaces accesibles mediante touch. Todos los elementos deben mantener usabilidad y legibilidad en cualquier tamaño de pantalla. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RF-INS-05
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RF-INS-05** |
| **Nombre de requisito** | Creación de Reporte de Falla o Daño |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • INST-REP-007<br>El sistema debe proveer un formulario para que el instructor reporte defectos de infraestructura de su dependencia o laboratorio. El sistema exigirá un título expresivo, ubicación textual, descripción pormenorizada y la subida de evidencia fotográfica del daño. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RF-INS-06
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RF-INS-06** |
| **Nombre de requisito** | Registro Descriptivo de Ubicación del Reporte |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • INST-REP-007 (Escenario 3)<br>El sistema debe requerir que la ubicación ingresada al crear un reporte no esté vacía y no supere el límite máximo de caracteres perimitido (255 caracteres). Esta flexibilidad permitirá referenciar cualquier aula, cubículo o laboratorio físico del centro de manera descriptiva. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RF-INS-07
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RF-INS-07** |
| **Nombre de requisito** | Adjuntar Evidencias Fotográficas a Reportes |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • INST-REP-008<br>El sistema debe permitir al instructor adjuntar múltiples evidencias fotográficas al crear un reporte. Debe cumplir con las validaciones de formatos permitidos: JPG, JPEG, PNG, GIF. El tamaño máximo estrictamente permitido por cada archivo será de 2 MB. Si el archivo no es un formato de imagen permitido o excede el límite de peso, el backend rechazará la subida devolviendo el mensaje de error de validación pertinente y protegiendo el almacenamiento en disco. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RF-INS-08
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RF-INS-08** |
| **Nombre de requisito** | Visualización del Detalle Completo de Reportes |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • INST-REP-009<br>El sistema debe permitir al instructor visualizar el detalle completo de sus reportes creados. La vista de detalle debe mostrar: Título y descripción, Ubicación, Prioridad, Estado actual, Fechas, Evidencias adjuntas (galería) y el Trabajador asignado (nombre y contacto) o mensaje "Sin trabajador asignado". El detalle debe ser accesible desde la lista de reportes del Dashboard o historial. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RF-INS-09
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RF-INS-09** |
| **Nombre de requisito** | Seguimiento de Estado de Reportes |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • INST-REP-010<br>El sistema debe mantener actualizado el estado de los reportes del instructor y notificarle automáticamente cuando cambie: Pendiente → En Atención (cuando el administrador asigne trabajador); En Atención → Resuelto (cuando finaliza la reparación y el admin valida el cierre). Los cambios de estado deben reflejarse inmediatamente en el Dashboard. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RF-INS-10
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RF-INS-10** |
| **Nombre de requisito** | Inmutabilidad y Persistencia de los Reportes |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • INST-REP-011<br>Una vez que el sistema guarde el reporte creado por el instructor y las evidencias se suban al servidor, el reporte pasará a ser una entidad de registro inmutable para su creador. Con fines de integridad en auditoría y control de daños, no se permitirá la posterior edición ni eliminación asíncrona por parte del instructor. Toda aclaración subsecuente deberá pasar formalmente a través del administrador. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RF-INS-11
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RF-INS-11** |
| **Nombre de requisito** | Historial de Reportes Realizados |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • INST-HIS-012<br>El sistema debe mantener un historial completo de todos los reportes creados por el instructor, independientemente de su estado. La vista de historial debe mostrar fecha de creación, título del reporte, estado final, ubicación, prioridad y enlace al detalle completo. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RF-INS-12
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RF-INS-12** |
| **Nombre de requisito** | Visualización de Perfil Personal |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • INST-PER-013<br>El sistema debe permitir al instructor visualizar su perfil personal desde el menú o configuración. La vista de perfil debe mostrar: Nombre completo, Correo electrónico, Número de teléfono, Foto de perfil, Rol, Fecha de registro y Estado de la cuenta. Si los datos están incompletos, debe indicarse con "Datos incompletos. Complete su perfil". |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RF-INS-13
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RF-INS-13** |
| **Nombre de requisito** | Edición de Perfil Personal |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • INST-PER-014<br>El sistema debe permitir al instructor editar su información personal desde la sección de perfil (Nombre completo, correo electrónico y subida de foto de perfil). Si el usuario decide alterar su Correo Electrónico (`email`), el sistema desverificará inmediatamente la cuenta (`email_verified_at = null`) forzando un nuevo ciclo de confirmación de email por seguridad. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RF-INS-14
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RF-INS-14** |
| **Nombre de requisito** | Cambio de Contraseña Estando Autenticado |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • INST-PER-015<br>El sistema debe permitir al instructor cambiar su contraseña desde el perfil estando autenticado, exigiendo validación estricta de: Contraseña actual, y Nueva contraseña con confirmación (8 caracteres, mayúscula, número, especial). Al cambiar exitosamente alertará en interfaz y opcionalmente cerrará la sesión actual para reingreso. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RF-INS-15
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RF-INS-15** |
| **Nombre de requisito** | Notificaciones de Asignación de Trabajador a Reporte |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • INST-NOT-016<br>El sistema debe enviar notificaciones automáticas al instructor cuando el administrador asigne un trabajador a su reporte, especificando nombre del trabajador, título y fecha. La notificación debe mostrarse en el panel in-app con badge numérico visual. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RF-INS-16
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RF-INS-16** |
| **Nombre de requisito** | Notificaciones de Resolución de Reporte |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • INST-NOT-017<br>El sistema debe despachar alertas automáticas al instructor cuando su reporte sea marcado como "Resuelto" (Validado por el Administrador), proveyendo enlace directo al detalle del reporte resuelto en el centro de avisos in-app. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RF-INS-17
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RF-INS-17** |
| **Nombre de requisito** | Cierre de Sesión |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • Requisito Estándar de Seguridad<br>El sistema debe permitir al instructor cerrar su sesión de manera segura invalidando el state activo y redireccionando al usuario a la pantalla de entrada protegida. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RF-INS-18
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RF-INS-18** |
| **Nombre de requisito** | Recuperación de Contraseña |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • Requisito Estándar de Seguridad<br>El sistema debe permitir al instructor recuperar su contraseña desde el formulario de inicio de sesión mediante un enlace temporal vía e-mail válido por un tiempo determinado, asegurando el cifrado hash si se renueva exitosamente la password. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

---

## 3. Rol: Trabajador (Ejecutor de Mantenimiento)

### RF-TRB-01
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RF-TRB-01** |
| **Nombre de requisito** | Autenticación y Acceso al Sistema |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • TRB-AUT-001<br>El sistema debe permitir al trabajador iniciar sesión mediante correo y contraseña. Al validar credenciales correctas, el Middleware restringirá su acceso exclusivamente a las rutas base protegidas `/worker/*`, redirigiéndolo sin intermediarios a su Dashboard Personal de tareas. Si la cuenta está desactivada o bloqueada, debe impedir el acceso de inmediato. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RF-TRB-02
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RF-TRB-02** |
| **Nombre de requisito** | Dashboard de Productividad (Métricas de Tareas) |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • TRB-DAS-002, TRAB-003<br>El sistema proveerá al trabajador un tablero numérico en vivo que totalice el volumen de su trabajo. Mostrará el conteo absoluto de Tareas Totales, Asignadas (nuevas), En Progreso, Realizadas (esperando revisión) y Finalizadas. Adicionalmente, destacará métricas críticas como Tareas con vencimiento próximo, Tareas Vencidas y Tareas de prioridad Alta. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RF-TRB-03
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RF-TRB-03** |
| **Nombre de requisito** | Accesos Rápidos en el Dashboard |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • TRAB-004<br>El sistema debe proporcionar accesos rápidos desde el Dashboard mediante botones o íconos claramente identificados hacia los módulos de: Historial de tareas completadas y Notificaciones. Estos accesos deben estar siempre visibles y funcionales, permitiendo navegación inmediata. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RF-TRB-04
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RF-TRB-04** |
| **Nombre de requisito** | Interfaz Responsive del Dashboard |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • TRAB-005<br>El sistema debe garantizar que el Dashboard del trabajador y todas sus funcionalidades sean completamente adaptables (responsive) a diferentes dispositivos: PC, tablet y celular. El diseño debe ajustarse automáticamente manteniendo la usabilidad y legibilidad en cualquier tamaño de pantalla. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RF-TRB-05
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RF-TRB-05** |
| **Nombre de requisito** | Visualización, Búsqueda y Filtrado de Tareas Asignadas |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • TRB-TAR-003, TRB-TAR-004<br>El módulo principal listará de manera paginada estricta y exclusivamente las tareas delegadas al trabajador. Proveerá filtros por Estado (asignado, en progreso) y Prioridad, ordenando siempre por urgencia de fecha límite. El trabajador no podrá visualizar tareas de otros compañeros. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RF-TRB-06
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RF-TRB-06** |
| **Nombre de requisito** | Visualización del Detalle Completo de Tareas |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • TRAB-007<br>El sistema debe permitir al trabajador ver la información íntegra de cada tarea asignada: Nombre, descripción, ubicación, prioridad, fechas límite y de creación, estado actual y admin asignador; así como cualquier foto o documento base provisto por la administración. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RF-TRB-07
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RF-TRB-07** |
| **Nombre de requisito** | Inicio de Trabajos (Evidencia Inicial) |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • TRB-TAR-005<br>Para poder cambiar el estado de una orden nueva de "Asignado" a "En Progreso", el sistema obligará al trabajador a subir fotografías de "Evidencia Inicial" (situación en la que encontró el desperfecto) validando estrictamente formatos de imagen y peso máximo habilitado. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RF-TRB-08
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RF-TRB-08** |
| **Nombre de requisito** | Reporte de Problemas o Imprevistos en Tareas |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • TRAB-009<br>El sistema debe permitir al trabajador reportar imprevistos marcando la tarea en estado excepcional (incompleta o retraso en proceso) adjuntando justificaciones escritas. Esto reflejará el obstáculo impidiéndole finalizar la tarea ordinariamente y alertando a la instancia superior. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RF-TRB-09
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RF-TRB-09** |
| **Nombre de requisito** | Finalización Operativa y Evidencia Final |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • TRB-TAR-006<br>Para concluir una tarea en desarrollo y mandarla a revisión ("Realizada"), el sistema forzará al trabajador a subir las imágenes de "Evidencia Final" comprobando el trabajo reparado, junto con una reseña textual corta del procedimiento ejercido. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RF-TRB-10
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RF-TRB-10** |
| **Nombre de requisito** | Notificaciones Recibidas desde Administración |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • TRAB-014, TRAB-015<br>El sistema emitirá notificaciones (Badge In-App y Email opcional) al trabajador cuando el administrador le asigne una Tarea Nueva o cuando el Admin modifique/cancele de imprevisto una Tesis ya asignada a su placa (notificaciones de cambio de estado). |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RF-TRB-11
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RF-TRB-11** |
| **Nombre de requisito** | Emisión de Notificaciones Automáticas al Admin |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • TRB-NOT-008<br>Cada vez que el trabajador avance formalmente sus tareas (arrancando a "En progreso" con la primera evidencia, o terminando en "Realizada" con la final), el backend despachará silenciamente notificaciones transaccionales al Admin creador alertando el avance. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RF-TRB-12
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RF-TRB-12** |
| **Nombre de requisito** | Restricciones de Creación y Manejo |
| **Tipo** | ☐ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☒ Restricción |
| **Fuente del requisito** | • TRB-SEC-007<br>El trabajador está inhabilitado a nivel controlador (HTTP 403) para crear nuevas tareas desde cero o para eliminar ningún registro existente del sistema, salvaguardando la arquitectura de delegación. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RF-TRB-13
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RF-TRB-13** |
| **Nombre de requisito** | Visualización y Edición de Perfil Personal |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • TRAB-011, TRAB-012<br>Heredando interfaces compartidas, el trabajador accederá a los ajustes de su perfil pudiendo adjuntar una fotografía formal (`profile_photo`), visualizar sus métricas de registro civil y corregir información de contacto, con controles sanitizados. |
| **Prioridad del requisito** | ☐ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☒ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RF-TRB-14
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RF-TRB-14** |
| **Nombre de requisito** | Cierre de Sesión Seguro |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • TRAB-016<br>El sistema debe permitir al trabajador cerrar sesión limpiando tokens de autenticación en el navegador y redirigiendo al inicio. Las sesiones expirarán globalmente tras un periodo extenso de inactividad, exigiendo reingreso. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |

### RF-TRB-15
| Campo | Detalle |
| :--- | :--- |
| **Número de requisito** | **RF-TRB-15** |
| **Nombre de requisito** | Recuperación y Cambio de Contraseña |
| **Tipo** | ☒ Requisito &nbsp;&nbsp;&nbsp;&nbsp; ☐ Restricción |
| **Fuente del requisito** | • TRAB-013, TRAB-017<br>El trabajador podrá rotar asíncronamente su clave de entrada validando la antigua si goza de sesión activa. Además, dispondrá de un link público para recibir correos temporales forjados que le permitan resetear una clave extraviada cumpliendo la política de contraseñas. |
| **Prioridad del requisito** | ☒ Alta/Esencial &nbsp;&nbsp;&nbsp;&nbsp; ☐ Media/Deseado &nbsp;&nbsp;&nbsp;&nbsp; ☐ Baja/ Opcional |
