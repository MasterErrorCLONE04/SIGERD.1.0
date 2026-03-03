import fs from 'fs';

const filePath = 'c:/laragon/www/SIGERD.1.0/Casos_Prueba_Trabajador.md';

const markdownToAppend = `

### CP-TRB-012
| Campo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-012 |
| **Módulo** | Gestión de Tareas |
| **Funcionalidad** | Cambio de estado de asignado a en progreso |
| **Descripción** | Validar que una tarea asigne estado "en progreso" al completarse el evento u accionar de la primera interacción por medio del envío de evidencia inicial. |
| **Precondiciones** | La tarea está en estado "asignado". |
| **Datos de Entrada** | Formulario de Evidencia Inicial [Imagen Válida] |
| **Pasos** | 1. Seleccionar la tarea 20 asignada.<br>2. Subir imagen válida en estado de la falla inicial.<br>3. Hacer clic en "Enviar Evidencia". |
| **Resultado Esperado** | La tarea cambia a estado "en progreso" y es documentada debidamente. |
| **Resultado Obtenido** | Transición exitosa. El formulario para evidencias finales se habilita. |
| **Estado** | ✅ Pasó |
| **Evidencia** | ![CP-TRB-012](puppeter_test_trabajador/CP-TRB-012.png) |

---

### CP-TRB-013
| Campo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-013 |
| **Módulo** | Gestión de Tareas |
| **Funcionalidad** | Subida válida de imágenes como evidencia final |
| **Descripción** | Validar que el trabajador pueda adjuntar satisfactoriamente imágenes PNG/JPG en el recuadro final. |
| **Precondiciones** | La tarea se encuentra "en progreso". |
| **Datos de Entrada** | Recuadro de Evidencia Final [test_image.jpg] |
| **Pasos** | 1. Seleccionar imagenes válidas menores a 2MB en formato .jpg o .png.<br>2. Enviar formulario. |
| **Resultado Esperado** | Imágenes guardadas correctamente y transición a "revisión" o similar. |
| **Resultado Obtenido** | Subida de imágenes funcional. La tabla de la BD o DOM registra las imágenes correctamente. |
| **Estado** | ✅ Pasó |
| **Evidencia** | ![CP-TRB-013](puppeter_test_trabajador/CP-TRB-013.png) |

---

### CP-TRB-014
| Campo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-014 |
| **Módulo** | Gestión de Tareas |
| **Funcionalidad** | Intento de enviar formulario sin evidencia obligatoria |
| **Descripción** | Comprobar que el sistema rechaza envíos vacíos o sin evidencia final fotográfica adjunta en etapa de cierre de la tarea. |
| **Precondiciones** | La tarea está en progreso. |
| **Datos de Entrada** | N/A (Evidencia dejada en blanco). |
| **Pasos** | 1. Intentar marcar la tarea seleccionando el botón "Enviar Evidencia" sin subir fotos finales. |
| **Resultado Esperado** | El sistema debe mostrar un mensaje de validación previniendo la sumisión. |
| **Resultado Obtenido** | Error de validación lanzado obligando la presencia del archivo. |
| **Estado** | ✅ Pasó |
| **Evidencia** | ![CP-TRB-014](puppeter_test_trabajador/CP-TRB-014.png) |

---

### CP-TRB-015
| Campo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-015 |
| **Módulo** | Gestión de Tareas |
| **Funcionalidad** | Subida de un archivo no permitido (.pdf) |
| **Descripción** | Verificar que el sistema bloquee cualquier intento de adjuntar evidencias finales que no coinciden con las directrices de imagen. |
| **Precondiciones** | La tarea está en progreso. |
| **Datos de Entrada** | Archivo: "test_doc.pdf" |
| **Pasos** | 1. Seleccionar un archivo en formato PDF en el input file.<br>2. Proceder a enviarlo. |
| **Resultado Esperado** | Validación denegada; aviso de formato o extensión incorrecta. |
| **Resultado Obtenido** | Archivo no soportado bloqueado por el Request de validación de Laravel. |
| **Estado** | ✅ Pasó |
| **Evidencia** | ![CP-TRB-015](puppeter_test_trabajador/CP-TRB-015.png) |

---

### CP-TRB-016
| Campo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-016 |
| **Módulo** | Gestión de Tareas |
| **Funcionalidad** | Incorporación de nota final explicativa satisfactoria |
| **Descripción** | Asegurar la capacidad de dejar retroalimentación textua a un requerimiento superado. |
| **Precondiciones** | La tarea está lista para concluirse con evidencia en el DOM. |
| **Datos de Entrada** | Texto: "Trabajo finalizado con éxito" |
| **Pasos** | 1. Rellenar Textarea 'final_description'.<br>2. Anexar junto con evidencia aprobatoria. |
| **Resultado Esperado** | La labor culmina salvando el texto correctamente en las anotaciones finales del reporte. |
| **Resultado Obtenido** | Descripción anexada satisfactoriamente con la orden. |
| **Estado** | ✅ Pasó |
| **Evidencia** | ![CP-TRB-016](puppeter_test_trabajador/CP-TRB-016.png) |

---

### CP-TRB-017
| Campo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-017 |
| **Módulo** | Seguridad |
| **Funcionalidad** | Límite de Acceso Cruzado (Negativo) |
| **Descripción** | Validar que el rol Trabajador no pueda ver la evidencia o tareas adjudicadas a otro compañero ajeno. |
| **Precondiciones** | Ambos operarios existen y posen identificadores únicos. |
| **Datos de Entrada** | ID de Tarea asigando a un usuario B. |
| **Pasos** | 1. Intentar acceder a la ruta particular de visualización cruzada en \`/worker/tasks/{ID}\`. |
| **Resultado Esperado** | Mensaje de "No Autorizado" o 403 Forbidden arrojado. |
| **Resultado Obtenido** | Correcta prevención de visualización en Policy asegurando el control. |
| **Estado** | ✅ Pasó |
| **Evidencia** | ![CP-TRB-017](puppeter_test_trabajador/CP-TRB-017.png) |

---

`;

fs.appendFileSync(filePath, markdownToAppend);
console.log('Appended to Casos_Prueba_Trabajador.md');
