import fs from 'fs';

const filePath = 'c:/laragon/www/SIGERD.1.0/Casos_Prueba_Trabajador.md';

const markdownToAppend = `
---

### CP-TRB-018
| Campo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-018 |
| **Módulo** | Notificaciones |
| **Funcionalidad** | Recepción de notificación por nueva tarea asignada |
| **Descripción** | Verificar que cuando el administrador le destina una tarea al trabajador, este reciba una alerta visual con detalle. |
| **Precondiciones** | El administrador seleccionó al trabajador como responsable. |
| **Datos de Entrada** | (Asignación en backend) |
| **Pasos** | 1. Refrescar el panel principal.<br>2. Comprobar aparición de contador y abrir la campana de notificaciones. |
| **Resultado Esperado** | Icono de campana con badge de alerta. Al abrir muestra mensaje "Nueva Tarea Asignada". |
| **Resultado Obtenido** | Notificación renderizada satisfactoriamente a través de Alpine. |
| **Estado** | ✅ Pasó |
| **Evidencia** | ![CP-TRB-018](puppeter_test_trabajador/CP-TRB-018.png) |

---

### CP-TRB-019
| Campo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-019 |
| **Módulo** | Notificaciones |
| **Funcionalidad** | Recepción de notificación por tarea rechazada |
| **Descripción** | Comprobar que en evento de un rechazo de evidencia el operario sea anoticiado. |
| **Precondiciones** | El trabajador mandó a revisar y el admin declinó el avance. |
| **Datos de Entrada** | (Evaluación en backend) |
| **Pasos** | 1. Revisar campana de notificaciones en sesión. |
| **Resultado Esperado** | Aparición de objeto con aviso y redirección a corrección de la tarea asignada especifica. |
| **Resultado Obtenido** | Generación de notificación "Tarea Rechazada" visible. |
| **Estado** | ✅ Pasó |
| **Evidencia** | ![CP-TRB-019](puppeter_test_trabajador/CP-TRB-019.png) |

---

### CP-TRB-020
| Campo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-020 |
| **Módulo** | Notificaciones |
| **Funcionalidad** | Recepción de notificación por tarea aprobada |
| **Descripción** | Validar aviso en cierre aprobatorio definitivo por parte de gerencia. |
| **Precondiciones** | Tarea mandada a revisión. |
| **Datos de Entrada** | (Aprobación en backend) |
| **Pasos** | 1. Verificación del menú de campana. |
| **Resultado Esperado** | Se exhibe mensaje finalizador "Tarea Aprobada" con fecha integrada. |
| **Resultado Obtenido** | Notificación afirmativa correctamente generada. |
| **Estado** | ✅ Pasó |
| **Evidencia** | ![CP-TRB-020](puppeter_test_trabajador/CP-TRB-020.png) |

---

### CP-TRB-021
| Campo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-021 |
| **Módulo** | Notificaciones |
| **Funcionalidad** | Marcado de notificación como leída |
| **Descripción** | Confirmar interactividad de marcar ítems visualizados. |
| **Precondiciones** | Hay al menos 1 notificación sin leer emergente. |
| **Datos de Entrada** | Clic izquierdo sobre el cuerpo del aviso. |
| **Pasos** | 1. Clic en la caja de la notificación no leída. |
| **Resultado Esperado** | Acción HTTP/AJAX registra marcado en la BD. |
| **Resultado Obtenido** | Ítem se registra como leído correctamente vía JS \`markAsRead\`. |
| **Estado** | ✅ Pasó |
| **Evidencia** | ![CP-TRB-021](puppeter_test_trabajador/CP-TRB-021.png) |

---

### CP-TRB-022
| Campo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-022 |
| **Módulo** | Configuración y Apariencia |
| **Funcionalidad** | Cambio de tema claro a oscuro |
| **Descripción** | Comprobar transición entre CSS claro a nocturno con Tailwind. |
| **Precondiciones** | La aplicación carga los assets visualmente. |
| **Datos de Entrada** | Selector de botón "Luna" Theming. |
| **Pasos** | 1. Pulsar en el toggle de Dark Mode del navbar. |
| **Resultado Esperado** | Implementación de tema oscuro fluido de manera reactiva (.dark CSS). |
| **Resultado Obtenido** | Inversión de paleta completada a modo oscuro. |
| **Estado** | ✅ Pasó |
| **Evidencia** | ![CP-TRB-022](puppeter_test_trabajador/CP-TRB-022.png) |

---

### CP-TRB-023
| Campo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-023 |
| **Módulo** | Perfil de Usuario |
| **Funcionalidad** | Actualización de datos personales y foto de perfil |
| **Descripción** | Constatar que la modificación nombre/email/avatar se asiente. |
| **Precondiciones** | Posicionar al trabajador en la ruta \`/profile\`. |
| **Datos de Entrada** | Nombre editado, Avatar.JPG validos. |
| **Pasos** | 1. Llenar Name inputs y ubicar foto válida en el prompt.<br>2. "Guardar". |
| **Resultado Esperado** | Retorno exitoso 200 de confirmación "Guardado" que actualiza top-navbar. |
| **Resultado Obtenido** | Modificación persistente en la BD, la navbar lee datos recientes. |
| **Estado** | ✅ Pasó |
| **Evidencia** | ![CP-TRB-023](puppeter_test_trabajador/CP-TRB-023.png) |

---

### CP-TRB-024
| Campo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-024 |
| **Módulo** | Perfil de Usuario |
| **Funcionalidad** | Cambio exitoso de contraseña |
| **Descripción** | Verificar que proveyendo old y new matches de password se blinde un cambio. |
| **Precondiciones** | Trabajador dispone del Hash actual mentalmente. |
| **Datos de Entrada** | Password previo, Confirmaciones idénticas. |
| **Pasos** | 1. Llenar 3 inputs con clave actual y dos nuevas repetidas de control.<br>2. Clic Guardar en el bloque de seguridad. |
| **Resultado Esperado** | Contraseña cifrada de nuevo, banner flash "Guardado". |
| **Resultado Obtenido** | Password modificado de forma segura. |
| **Estado** | ✅ Pasó |
| **Evidencia** | ![CP-TRB-024](puppeter_test_trabajador/CP-TRB-024.png) |

---

### CP-TRB-025
| Campo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-025 |
| **Módulo** | Perfil de Usuario |
| **Funcionalidad** | Intento fallido por clave actual incorrecta |
| **Descripción** | Comprobar que en caso de error o fraude en old password no se conceda la alteración. |
| **Precondiciones** | Trabajador en bloque de cambiar clave. |
| **Datos de Entrada** | Clave antigua inválida o errática. |
| **Pasos** | 1. Ejecutar llenado con Password actual erróneo y tratar de proseguir. |
| **Resultado Esperado** | Bloqueo por validación con mensaje expreso del framework "La contraseña actual no es correcta". |
| **Resultado Obtenido** | Intento denegado arrojando Request Alert error. |
| **Estado** | ✅ Pasó |
| **Evidencia** | ![CP-TRB-025](puppeter_test_trabajador/CP-TRB-025.png) |

---

### CP-TRB-026
| Campo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-026 |
| **Módulo** | Seguridad |
| **Funcionalidad** | Intento de auto-promoción de rol |
| **Descripción** | Control de escalamiento de privilegios vía alteración de formulario web. |
| **Precondiciones** | Trabajador domina DOM DevTools para inyectar input secreto. |
| **Datos de Entrada** | \\\`<input name="role" value="admin">\\\` appended al form PATCH. |
| **Pasos** | 1. Inyectar artificialmente la variable de role y Enviar Formulario. |
| **Resultado Esperado** | Laravel omite totalmente el intento ya que el rol viene dictaminado y no asimilado en \\\`fillables\\\` directos sin middleware auth superior. |
| **Resultado Obtenido** | Nula propagación del rol en DB manteniendo sesión restrictiva del trabajador inalterable. |
| **Estado** | ✅ Pasó |
| **Evidencia** | ![CP-TRB-026](puppeter_test_trabajador/CP-TRB-026.png) |

---

`;

fs.appendFileSync(filePath, markdownToAppend);
console.log('Appended final batch to Casos_Prueba_Trabajador.md');
