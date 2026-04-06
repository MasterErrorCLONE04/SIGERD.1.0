# Casos de Prueba – Módulo Trabajador (SIGERD)

---

## 1. Autenticación y Accesos
| ID | Nombre | Precondición | Datos de Entrada | Pasos | Resultado Esperado |
|----|--------|-------------|-----------------|-------|--------------------|
| CP-TRB-001 | Inicio de sesión exitoso como trabajador | El usuario trabajador existe en la base de datos con credenciales válidas. | Email: `trabajador1@sigerd.com` / Password: `password` | 1. Ir a `/login`<br>2. Ingresar email y password válidos de trabajador<br>3. Clic en "Entrar" | Redirección a su panel o dashboard. Acceso concedido al área de trabajador. |
| CP-TRB-002 | Login con contraseña incorrecta | El usuario trabajador existe en la base de datos. | Email: `trabajador1@sigerd.com` / Password: `wrongpassword` | 1. Ir a `/login`<br>2. Ingresar email válido pero contraseña incorrecta<br>3. Clic en "Entrar" | Mensaje de error de credenciales. No ingresa al sistema. |
| CP-TRB-003 | Login con usuario no registrado | Ninguna. | Email: `notexists@sigerd.com` / Password: `password` | 1. Ir a `/login`<br>2. Ingresar email no existente y cualquier clave<br>3. Clic en "Entrar" | Mensaje de error indicando que las credenciales no coinciden. No ingresa. |
| CP-TRB-004 | Acceso a ruta protegida sin autenticación | Estar con la sesión cerrada. | URL: `/worker/tasks` | 1. Con sesión cerrada, visitar URL de tareas de trabajador (`/worker/tasks`) | Redirección automática al inicio de sesión (`/login`). |
| CP-TRB-005 | Intento de acceso a panel de administrador como trabajador | Haber iniciado sesión exitosamente con cuenta de trabajador. | URL: `/admin/users` | 1. Iniciar sesión como Trabajador<br>2. Tratar de entrar a `/admin/users` a través de la URL | Se bloquea el acceso de inmediato (Error 403 Forbidden o redirección por Middleware de roles). |
| CP-TRB-006 | Envío de formulario login con campos vacíos | Ninguna. | Email: (Vacío) / Password: (Vacío) | 1. Ir a `/login`<br>2. Dejar email y/o contraseña vacíos<br>3. Clic en "Entrar" | El formulario arroja error de validación HTML5 o backend reconociendo campos requeridos. |

## 2. Dashboard y Tareas (Listados)
| ID | Nombre | Precondición | Datos de Entrada | Pasos | Resultado Esperado |
|----|--------|-------------|-----------------|-------|--------------------|
| CP-TRB-007 | Carga correcta de métricas del dashboard | El usuario trabajador debe tener tareas asignadas. | N/A | 1. Iniciar sesión como trabajador.<br>2. Entrar al Dashboard destinado al trabajador (`/worker/dashboard`). | Pantalla carga correctamente. Tarjetas muestran conteo de tareas reales asignadas al trabajador. |
| CP-TRB-008 | Dashboard con métricas en cero | El usuario no debe tener tareas previas. | N/A | 1. Usuario nuevo sin tareas asignadas alguna vez.<br>2. Entrar al dashboard. | El sistema es estable, no hay errores ni excepciones, muestra contadores en 0. |
| CP-TRB-009 | Visualización exclusiva de tareas asignadas | El trabajador debe contar con tareas asignadas en la base de datos. | URL: `/worker/tasks` | 1. Iniciar sesión como trabajador.<br>2. Ir a la vista de "Mis tareas". | El Query Builder asegura visualizar solo las tareas del usuario actual. |
| CP-TRB-010 | Búsqueda de tarea por palabra clave | Disponer de más de una tarea para poder observar filtrado. | Palabra clave: `a` | 1. En su listado, ingresar una palabra del título o descripción en el buscador.<br>2. Presionar el botón de Buscar. | La lista muestra solo las tareas coincidentes dentro de sus asignadas. |
| CP-TRB-011 | Filtrado de tareas por estado | Entrar al listado mis tareas (`/worker/tasks`). | Estado: `en progreso` | 1. Seleccionar un filtro de estado como "En Progreso" o "Finalizada".<br>2. Ejecutar la búsqueda o refrescar vista si es dinámico. | La grilla se recalcula dinámicamente, ocultando las tareas que no coinciden con la selección. |

## 3. Gestión de Evidencias y Estados
| ID | Nombre | Precondición | Datos de Entrada | Pasos | Resultado Esperado |
|----|--------|-------------|-----------------|-------|--------------------|
| CP-TRB-012 | Cambio de estado de asignado a en progreso | La tarea está en estado "asignado". | Formulario de Evidencia Inicial | 1. Seleccionar la tarea asignada.<br>2. Subir imagen inicial.<br>3. Enviar. | Estado "en progreso", foto anexada a la tarea. |
| CP-TRB-013 | Subida válida de imágenes como evidencia final | La tarea se encuentra "en progreso". | Recuadro de Evidencia Final | 1. Seleccionar imágenes válidas menores a 2MB en formato .jpg/.png y descripción final requerida.<br>2. Enviar. | Imágenes guardadas en `storage`, descripción rellenada y transición a "realizada". |
| CP-TRB-014 | Intento de enviar form sin evidencia obligatoria | La tarea está en progreso. | N/A (Evidencia dejada en blanco). | 1. Intentar marcar la tarea seleccionando botón "Enviar Evidencia" sin subir fotos finales. | El navegador bloquea nativamente o el sistema rechaza la solicitud preveniendo sumisión nula. |
| CP-TRB-015 | Subida de un archivo no permitido (.pdf) | La tarea está en progreso. | Archivo: "test_doc.pdf" | 1. Seleccionar un archivo en formato PDF en el input file.<br>2. Proceder a enviarlo. | Validación denegada (Backend arroja `mimes:jpeg,png,jpg,gif`); aviso de formato incorrecto. |
| CP-TRB-016 | Incorporación de nota final explicativa satisfactoria | La tarea está lista para concluirse con evidencia en el DOM. | Texto: "Trabajo finalizado con éxito" | 1. Rellenar Textarea 'final_description'.<br>2. Anexar junto con evidencia aprobatoria. | La labor culmina salvando el texto correctamente en las anotaciones finales del reporte. |
| CP-TRB-017 | Límite de Acceso Cruzado (Negativo) | Ambos operarios existen y poseen identificadores únicos. | ID de Tarea asignado a un usuario B. | 1. Intentar acceder a la ruta particular de visualización cruzada en `/worker/tasks/{ID}`. | Error 404/403 previniendo visualización de ajenos. |

## 4. Notificaciones y Preferencias
| ID | Nombre | Precondición | Datos de Entrada | Pasos | Resultado Esperado |
|----|--------|-------------|-----------------|-------|--------------------|
| CP-TRB-018 | Recepción de notificación por nueva tarea asignada | El administrador seleccionó al trabajador como responsable. | (Asignación en backend) | 1. Refrescar el panel principal.<br>2. Abrir campana de notificaciones. | Icono de campana con badge de alerta. Al abrir muestra mensaje "Nueva Tarea Asignada". |
| CP-TRB-019 | Recepción de notificación por tarea rechazada | El trabajador mandó a revisar y el admin declinó el avance. | (Evaluación en backend) | 1. Revisar campana de notificaciones en sesión. | Aparición de objeto con aviso "Tarea Rechazada" y redirección a corrección. |
| CP-TRB-020 | Recepción de notificación por tarea aprobada | Tarea mandada a revisión. | (Aprobación en backend) | 1. Verificación del menú de campana. | Se exhibe mensaje "Tarea Aprobada" con fecha integrada. |
| CP-TRB-021 | Marcado de notificación como leída | Hay al menos 1 notificación sin leer emergente. | Clic izquierdo sobre el aviso. | 1. Clic en la caja de la notificación no leída. | Acción HTTP/AJAX registra marcado en la BD. |
| CP-TRB-022 | Cambio de tema claro a oscuro | La aplicación carga los assets visualmente. | Selector de botón Theming. | 1. Pulsar en el toggle de Dark Mode del navbar. | Implementación de tema oscuro (`.dark` CSS). |
| CP-TRB-023 | Actualización de datos personales y foto de perfil | Posicionar al trabajador en la ruta `/profile`. | Nombre editado, Avatar válidos. | 1. Llenar Name inputs y ubicar foto válida.<br>2. Clic en "Guardar". | Retorno exitoso de confirmación "Guardado" que actualiza top-navbar. |
| CP-TRB-024 | Cambio exitoso de contraseña | Trabajador dispone del hash actual mentalmente. | Password previo, confirmaciones idénticas. | 1. Llenar inputs con clave actual y confirmaciones.<br>2. Clic Guardar. | Contraseña cifrada, banner flash "Guardado". |
| CP-TRB-025 | Intento fallido por clave actual incorrecta | Trabajador en bloque de cambiar clave. | Clave antigua inválida. | 1. Llenado con Password actual erróneo y proseguir. | Bloqueo por validación con mensaje "La contraseña actual no es correcta". |
| CP-TRB-026 | Intento de auto-promoción de rol | Se domina DOM DevTools para inyectar input secreto. | `<input name="role" value="admin">` | 1. Inyectar variable de role y Enviar Formulario. | Laravel omite el intento ya que el rol no está en `$fillable` (Mass Assignment protegiéndolo). |

## 5. Rendimiento y Ediciones Concurrentes
| ID | Nombre | Precondición | Datos de Entrada | Pasos | Resultado Esperado |
|----|--------|-------------|-----------------|-------|--------------------|
| CP-TRB-027 | Visualización en modal (lightbox) de imágenes | La tarea debe tener imágenes de evidencia. | Clic sobre miniatura. | 1. Clic sobre la miniatura de la evidencia cargada en la vista de detalle. | Modal se abre expandiendo la foto a pantalla completa. |
| CP-TRB-028 | Paginación eficiente con +500 tareas | Base de datos con +500 tareas para el trabajador. | N/A | 1. Entrar a la vista Listado. | Vista carga ágilmente debido a `paginate(10)`. |
| CP-TRB-029 | Prevención de doble envío al mandar tarea | Formulario de envío disponible. | Doble clic rápido en "Enviar Revisión". | 1. Doble clic rápido en "Enviar Revisión". | El formulario deshabilita el botón al instante del primer submit (`submitting=true`). |
| CP-TRB-030 | Intento de reiniciar tarea ya en progreso (Idempotencia) | La tarea ya se encuentra "en progreso". | URL/Request de la acción "Iniciar". | 1. Recargar URL/Request de la acción "Iniciar". | Lógica idempotente en Controller mantiene curso ignorando sobreescritura de status ("asignado"). |
| CP-TRB-031 | Forzar transición inválida vía request PUT | Tarea en "en progreso". | PUT con parámetro `status=finalizada`. | 1. Usar Postman/Burp Suite para forzar PUT a "finalizada". | El sistema rechaza parámetro protegido; sólo acciones legítimas escalan estados. |
| CP-TRB-032 | Modificar worker_id masivo desde cliente | Sesión activa como trabajador. | `worker_id=99` inyectado en PUT. | 1. Al enviar actualización, incrustar transferencia de ID. | Eloquent blinda actualización (Mass Assignment); la tarea no permite reasignaciones forzosas. |
| CP-TRB-033 | Subida de imagen límite (2MB exactos) | Tarea en progreso. | JPG/PNG de 2MB (2048 KB). | 1. Seleccionar imagen límite.<br>2. Enviar. | Laravel aprueba archivo respetando regla `max:2048`. |
| CP-TRB-034 | Subida de imagen corrupta/MIME alterado | Archivo `.exe` renombrado con extensión `.jpg`. | Ejecutable malicioso disimulado. | 1. Intentar adjuntar y enviar. | Directiva `mimes:jpeg,png,jpg` escanea MIME real y bloquea acceso. |
| CP-TRB-035 | Intento de path traversal en nombre archivo | Tarea en progreso. | Nombre falso `../../etc/passwd.jpg`. | 1. Emular carga declarando saltos de carpeta. | Librería Storage de Laravel sanitiza usando UUID y omite ruta relativa. |
| CP-TRB-036 | Edición concurrente múltiple desde 2 sesiones | Mismo usuario operando recurso en ventanas distintas. | Distintas fotos enviadas asincrónicamente. | 1. Modificar estatus/descripción desde Browser A y acto seguido el B. | Motor BD preserva último envío (Last Update Wins) o lanza error si choca status. |
| CP-TRB-037 | Contracarga forzada de Admin sobre Worker | Administrador manipula el estado mientras el trabajador ve pantalla cargable. | Post Admin vs Send Worker. | 1. Admin rechaza (Cancelada).<br>2. Trabajador manda formulario a Completada segundos después. | Aviso temporal de error al trabajador sin colisión del servidor. |

## 6. Seguridad y Resiliencia (Casos Extremos)
| ID | Nombre | Precondición | Datos de Entrada | Pasos | Resultado Esperado |
|----|--------|-------------|-----------------|-------|--------------------|
| CP-TRB-038 | Intento de inyección SQL (SQLi) en buscador | Búsqueda `?search=` expuesta. | Payload `1' OR '1'='1`. | 1. Insertar inyección en barra de búsqueda y disparar. | Query Builder (PDO) escapa texto devolviendo blindaje limpio. |
| CP-TRB-039 | Intento Stored XSS en Textarea Description | Input Notas Finales disponible. | `<script>alert('xss')</script>`. | 1. Escribir instrucción JS y mandar. | Blade templates renderizan en Entities HTML inactivando ejecución maliciosa. |
| CP-TRB-040 | Envío de formulario omitiendo CSRF Token | Formulario de evidencia abierto para envío. | Petición POST mutilada de `@csrf`. | 1. Enviar HTTP omitiendo o borrando `_token`. | Error 419 (Page Expired) frenando submit forzado. |
| CP-TRB-041 | Pérdida de conexión durante Upload múltiple | Subiendo MB en red lenta. | Desconexión Wi-Fi. | 1. Dar upload, desconectar internet, reconectar. | El error HTTP se frena sin escribir registros parciales en base de datos. |
| CP-TRB-042 | Recarga compulsiva (F5) tras emisión | Envío postal procesándose internamente. | Múltiples F5 teclado. | 1. "Finalizar", golpear F5 repentinamente. | Arquitectura PRG anula renvíos y descarta submit duplicado transparente. |
| CP-TRB-043 | Comportamiento correcto en Notificaciones Vacías | Nuevo trabajador sin alertas en DB. | Clic en campana. | 1. Dar Clic al menú. | Muestra estado "Zero State" inofensivo en lugar de romperse el foreach nulo. |
| CP-TRB-044 | Despliegue de imágenes Administrativas | Admin anexó referencias cruzadas previamente. | Modal ver fotos. | 1. Abrir vista de la orden y consultar adjuntos heredados. | La galería visibiliza el source correctamente sin bloqueo en cross-folder. |
| CP-TRB-045 | Tarea vencida intentando reactivación tardía | Fecha deadline en el pasado respecto al server time. | Acción Start. | 1. Intentar iniciar subida de status. | El backend con su policy o transiciona estipuladamente a incompleta si ameritaba o notifica. |
| CP-TRB-046 | Pérdida de File inputs tras recarga (F5 accidental) | Múltiples adjuntos seleccionados temporalmente. | Clic F5 navegador. | 1. Seleccionar 3 fotos, dar F5 sin guardar. | Limpieza del componente nativa, impidiendo adjuntos sucios residuales por seguridad de navegador. |
| CP-TRB-047 | Handling de Logging Out en caché temporal | Operario dando final local. | Botón `Cerrar`. | 1. Generar `/logout` validada, pulsar tecla navegador back. | Expiración local previene back-button view de panel. Redirige a inicio de sesión base. |
| CP-TRB-048 | Timeout Server Side | Operario deja abierto DOM por 3 hrs en laptop. | Post tras 3 hrs. | 1. Aguardar sobrepaso de Lifetime ENV session. | Controller dispara page expired (419) rechazando los campos vencidos con seguridad local. |
| CP-TRB-049 | UTF-8 Extremado con CJK/Emojis masivos | Tarea requiere comentarios. | Múltiples Emojis/CJK. | 1. Llenar campo con texto saturado multibite. | La inserción guarda impecable bajo set Charset `utf8mb4` nativo de DB. |
