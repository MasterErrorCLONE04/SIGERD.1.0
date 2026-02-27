# Casos de Prueba Exhaustivos - Rol Trabajador (SIGERD)

Este documento contiene una lista completa y exhaustiva de casos de prueba (Test Cases) enfocados en el **Rol de Trabajador** del sistema SIGERD. Se incluyen el "camino feliz", casos límite (edge cases), pruebas negativas, pruebas de seguridad, concurrencia y UX.

---

## 1️⃣ Módulo de Autenticación y Acceso (Login)

| ID Caso | Tipo | Descripción | Pasos de Ejecución | Resultado Esperado |
| :--- | :--- | :--- | :--- | :--- |
| **CP-TRB-001** | Positivo | Inicio de sesión exitoso como trabajador | 1. Ir a `/login`<br>2. Ingresar email y password válidos de trabajador<br>3. Clic en "Entrar" | Redirección a su panel o dashboard. Acceso concedido al área de trabajador. |
| **CP-TRB-002** | Negativo | Login con contraseña incorrecta | 1. Ingresar email válido pero contraseña incorrecta | Mensaje de error de credenciales. No ingresa. |
| **CP-TRB-003** | Negativo | Login con usuario no registrado | 1. Ingresar email no existente y cualquier clave | Mensaje de error indicando que las credenciales no coinciden. |
| **CP-TRB-004** | Seguridad | Acceso a ruta protegida sin autenticación | 1. Con sesión cerrada, visitar URL de tareas de trabajador (`/tasks`) | Redirección automática al inicio de sesión (`/login`). |
| **CP-TRB-005** | Seguridad | Intento de acceso a panel de administrador | 1. Iniciar sesión como Trabajador<br>2. Tratar de entrar a `/admin/users` o `/admin/dashboard` | Se bloquea el acceso de inmediato (Error 403 Forbidden o redirección por Middleware de roles). |
| **CP-TRB-006** | Negativo | Envío de formulario login con campos vacíos | 1. Dejar email y/o contraseña vacíos y enviar | El formulario arroja error de validación HTML5 o backend reconociendo campos requeridos. |

---

## 2️⃣ Dashboard (Panel Principal del Trabajador)

| ID Caso | Tipo | Descripción | Pasos de Ejecución | Resultado Esperado |
| :--- | :--- | :--- | :--- | :--- |
| **CP-TRB-007** | Positivo | Carga correcta de métricas del dashboard | 1. Entrar al Dashboard destinado al trabajador | Pantalla carga correctamente. Tarjetas muestran conteo exacto de "Mis tareas asignadas", "Tareas En Progreso", y "Tareas Completadas". |
| **CP-TRB-008** | Límite | Dashboard con métricas en cero | 1. Usuario nuevo sin tareas asignadas alguna vez<br>2. Entrar al dashboard | El sistema es estable, no hay errores ni excepciones, muestra contadores en `0`. |

---

## 3️⃣ Gestión de Tareas

### A. Listado y Filtros
| ID Caso | Tipo | Descripción | Pasos de Ejecución | Resultado Esperado |
| :--- | :--- | :--- | :--- | :--- |
| **CP-TRB-009** | Positivo | Visualización exclusiva de tareas asignadas | 1. Ir a la vista de "Mis tareas" | El Query Builder asegura visualizar solo las tareas donde `worker_id` corresponde al usuario actual. Tareas de otros trabajadores no son visibles. |
| **CP-TRB-010** | Positivo | Búsqueda de tarea por palabra clave | 1. En su listado, ingresar una palabra del título o descripción en el buscador. | La lista muestra solo las tareas coincidentes dentro del subconjunto de sus tareas asignadas. |
| **CP-TRB-011** | Positivo | Filtrado de tareas por estado | 1. Seleccionar un filtro como "En Progreso" o "Finalizada". | La grilla se recalcula dinámicamente, ocultando las tareas que no coinciden con la selección de estado. |

### B. Ejecución y Evidencia
| ID Caso | Tipo | Descripción | Pasos de Ejecución | Resultado Esperado |
| :--- | :--- | :--- | :--- | :--- |
| **CP-TRB-012** | Positivo | Cambio de estado de asignado a en progreso | 1. Seleccionar tarea con estado "asignado"<br>2. Clic en botón "Iniciar" | La tarea cambia a estado "en progreso". Posible generación de notificación para el creador (Administrador). |
| **CP-TRB-013** | Positivo | Subida válida de imágenes como evidencia final | 1. En una tarea en progreso, adjuntar imágenes válidas (.jpg, .png) menores a 2MB<br>2. Guardar o Enviar a revisión | Imágenes guardadas correctamente en servidor y vinculadas al JSON `final_evidence_images` en BD. |
| **CP-TRB-014** | Negativo | Intento de enviar tarea sin evidencia obligatoria | 1. Intentar marcar la tarea "completada / en revisión" sin subir fotos finales. | Falla de validación informando: "Debe proveer evidencia final para enviar la tarea a revisión." (Si la regla existe). |
| **CP-TRB-015** | Negativo | Intento de subir archivo no permitido | 1. Intentar Subir un `.pdf`, `.mp4` o `.exe` en el input de evidencias. | Error de validación "mimes": Archivo no permitido, solo se aceptan imágenes fotográficas. |
| **CP-TRB-016** | Positivo | Envío correcto de tarea a revisión | 1. Subir evidencia válida y añadir comentarios<br>2. Confirmar envío | Transición de "en progreso" a "pendiente de revisión". El trabajador pierde capacidad de editarla mientras sea evaluada. |
| **CP-TRB-017** | Seguridad | Intento de acceso o edición de tarea ajena | 1. Modificar manualmente el parámetro ID en la URL para entrar al show o edit de una tarea de otro worker. | Acceso denegado (ErrorCode 403 / 404), validando autorización de Policies en Controlador. |

---

## 4️⃣ Notificaciones

| ID Caso | Tipo | Descripción | Pasos de Ejecución | Resultado Esperado |
| :--- | :--- | :--- | :--- | :--- |
| **CP-TRB-018** | Positivo | Recepción de notificación por nueva tarea asignada | 1. El Admin designa tarea a trabajador.<br>2. Trabajador refresca el panel. | Aparece en el ícono de campana o badge una nueva notificación no leída. |
| **CP-TRB-019** | Positivo | Recepción de notificación por tarea rechazada | 1. El Admin evalúa una tarea y la marca como "Rechazada/Corrección". | Trabajador recibe notificación avisando el motivo del rechazo; tarea regresa a "en progreso". |
| **CP-TRB-020** | Positivo | Recepción de notificación por tarea aprobada | 1. El Admin aprueba el trabajo realizado. | Trabajador recibe notificación de éxito. Tarea queda inamovible como "Finalizada". |
| **CP-TRB-021** | Positivo | Marcado de notificación como leída | 1. Clic sobre la campana y seleccionar una notificación nueva. | La notificación se marca con `read_at` (vía ajax o redirect) y el badge contador disminuye en 1. |

---

## 5️⃣ Configuración y Apariencia

| ID Caso | Tipo | Descripción | Pasos de Ejecución | Resultado Esperado |
| :--- | :--- | :--- | :--- | :--- |
| **CP-TRB-022** | Positivo | Cambio de tema claro a oscuro | 1. Interrumpir el tema vía menú de configuración o header de usuario. | Cambio inmediato (Alpine/JS) del theme aplicando clase `dark` y almacenando preferencia en DB/LocalStorage. |

---

## 6️⃣ Perfil de Usuario

| ID Caso | Tipo | Descripción | Pasos de Ejecución | Resultado Esperado |
| :--- | :--- | :--- | :--- | :--- |
| **CP-TRB-023** | Positivo | Actualización de datos personales y foto de perfil | 1. Ir a `/profile`<br>2. Cambiar nombre, email y subir foto (.png)<br>3. Guardar | Datos actualizados correctamente en BD. Avatar modificado en la Navbar en tiempo real. |
| **CP-TRB-024** | Positivo | Cambio exitoso de contraseña | 1. Ingresar current password válido.<br>2. Ingresar nuevo password x2.<br>3. Guardar. | Actualización de clave `Hash::make()` exitosa sin botar sesión actual del usuario. |
| **CP-TRB-025** | Negativo | Intento fallido por clave actual incorrecta | 1. Escribir mal el password actual (current).<br>2. Intentar actualizar contraseña. | Error de validación estricta "La contraseña actual no es correcta". |
| **CP-TRB-026** | Seguridad | Intento de auto-promoción de rol | 1. Usar inspeccionar elemento en Perfil.<br>2. Añadir input secreto `name="role" value="admin"`.<br>3. Enviar form. | El controlador desestima el input oculto al usar Fillables `$request->only()` o Auth validations. El rol del usuario `trabajador` no mutará jamás. |

---

## 7️⃣ UI y Rendimiento

| ID Caso | Tipo | Descripción | Pasos de Ejecución | Resultado Esperado |
| :--- | :--- | :--- | :--- | :--- |
| **CP-TRB-027** | UI / Límite | Visualización en modal (lightbox) de imágenes | 1. Clic sobre la miniatura de la evidencia cargada en la vista de detalle de la tarea. | El lightbox/modal se abre expandiendo la foto sin desbordar el viewport HTML. |
| **CP-TRB-028** | Rendimiento | Paginación eficiente con más de 500 tareas | 1. Base de datos con +500 tareas para el trabajador.<br>2. Entrar a la vista Listado. | La vista se carga en <2 segundos debido a `->paginate(10)`, limitando el consumo de memoria RAM de memoria PHP. |
| **CP-TRB-029** | Límite / UI | Prevención de doble envío al mandar tarea | 1. Doble clic rápido en "Enviar Revisión". | El formulario deshabilita el botón al instante del primer submit previniendo registros duplicados. |

---

## 8️⃣ Integridad de Estados y Transiciones

| ID Caso | Tipo | Descripción | Pasos de Ejecución | Resultado Esperado |
| :--- | :--- | :--- | :--- | :--- |
| **CP-TRB-030** | Límite | Intento de reiniciar tarea ya en progreso | 1. Recargar URL/Request de la acción "Iniciar" cuando la tarea ya está como "en progreso". | La lógica es idempotente, no produce falla crítica ni altera tiempos, se mantiene en curso ignorando la acción. |
| **CP-TRB-031** | Negativo | Forzar transición inválida vía request | 1. Usar Postman/Burp Suite para enviar un PUT y tratar de marcar `estado="finalizada"` directo desde trabajador. | El sistema rechaza o ignora el parámetro protegido por regla de validación de backend, aceptando solo envíos a "pendiente de revisión". |
| **CP-TRB-032** | Seguridad | Modificar worker_id desde cliente | 1. Al enviar una actualización (ej: notas), interceptar el request y meter `worker_id=99`. | Eloquent lo blinda por protección Mass Assignment; la tarea no es reasignada accidental o maliciosamente a un tercero. |

---

## 9️⃣ Control y Validación de Archivos

| ID Caso | Tipo | Descripción | Pasos de Ejecución | Resultado Esperado |
| :--- | :--- | :--- | :--- | :--- |
| **CP-TRB-033** | Límite | Subida de imagen límite (2MB exactos) | 1. Configurar un archivo gráfico de exactamente 2.048 KB.<br>2. Subir a evidencia final. | Laravel aprueba el Check de peso de la regla `max:2048` permitiéndolo. |
| **CP-TRB-034** | Negativo | Subida imagen corrupta/MIME alterado | 1. Cambiar la extensión de un `.exe` a `.jpg`.<br>2. Subir formulario. | La regla `image|mimes:jpeg,png,jpg` escanea MIME real rechazándolo contundentemente por seguridad. |
| **CP-TRB-035** | Seguridad | Intento de path traversal en nombre archivo | 1. Modificar payload multi-part alterando `filename` de la imagen a `../../shell.php`. | Laravel `Storage::putFile()` o `Str::uuid()` auto renombra el archivo haciendo inútil el Path Traversal. |

---

## 🔟 Concurrencia

| ID Caso | Tipo | Descripción | Pasos de Ejecución | Resultado Esperado |
| :--- | :--- | :--- | :--- | :--- |
| **CP-TRB-036** | Concurrencia | Modificación simultánea de tarea en 2 sesiones | 1. Abrir 2 navegadores con la misma tarea (sesión del trabajador).<br>2. Editar la tarea enviando desde ambas ventanas al instante. | Gana la última petición en escribirse a DB o existe bloqueo si se implementó Lock/Atomic updates. |
| **CP-TRB-037** | Concurrencia | Rechazo por Admin durante carga trabajador | 1. El trabajador aún está en "en progreso" cargando evidencias.<br>2. El admin fuerza un cambio a la tarea a su estado.<br>3. El trabajador guarda el form. | Sin colisión en BD, validación o catch evita un error fatal mostrando un flash message "Se modificó por otro agente". |

---

## 1️⃣1️⃣ Seguridad Avanzada

| ID Caso | Tipo | Descripción | Pasos de Ejecución | Resultado Esperado |
| :--- | :--- | :--- | :--- | :--- |
| **CP-TRB-038** | Seguridad | Intento de inyección SQL en búsqueda | 1. En el campo general de Filtrado escribir payload SQLi: `1' OR '1'='1`. | Laravel Query Builder neutraliza usando Prepared Statements / Escaping PDO previniendo volcado de Data. |
| **CP-TRB-039** | Seguridad | Intento XSS en comentarios de finalización | 1. Al escribir el comentario final de prueba insertar script `<script>alert('xss')</script>`. | Blade escapa etiquetas (Entity encode `{{ }}`) mostrándolo como texto sin ejecutarse como HTML Script. |
| **CP-TRB-040** | Seguridad | Envío de formulario sin CSRF Token | 1. Quitar de la vista la etiqueta `@csrf`.<br>2. Enviar evidencia final completada. | Error 419 (Page Expired) - Protección VerifyCsrfToken middleware bloqueando CSRF Forgery attack. |

---

## 1️⃣2️⃣ UX y Resiliencia

| ID Caso | Tipo | Descripción | Pasos de Ejecución | Resultado Esperado |
| :--- | :--- | :--- | :--- | :--- |
| **CP-TRB-041** | UX | Pérdida de conexión durante subida | 1. Adjuntar 4MB de evidencia en internet lento y desconectar el WiFi momentaneamente. | El navegador arroja Exception, error asíncrono evitable y no provoca estado inconsistente parcial en los registros. |
| **CP-TRB-042** | UX | Recarga de página durante envío de tarea | 1. Dar F5 justo cuando procesa el botón de envío. | Si el backend soporta Idempotencia se evita creación fantasma / Post-Redirect-Get pattern. |
| **CP-TRB-043** | Límite | Visualización correcta con cero notificaciones | 1. Abrir la campana icon de notificaciones recién registrado. | Despliegue de un "Empty state" (Ej. No tienes notificaciones nuevas), previniendo error de iteración `@foreach` vacío. |

---

## 1️⃣3️⃣ Detalles y Ciclo de Vida de Tarea

| ID Caso | Tipo | Descripción | Pasos de Ejecución | Resultado Esperado |
| :--- | :--- | :--- | :--- | :--- |
| **CP-TRB-044** | Positivo | Visualización de Imágenes de Referencia | 1. Entrar a una tarea vinculada a una incidencia donde el Admin subió foto de referencia.<br>2. Revisar visor | El componente muestra la imagen o thumbnail cargado inicialmente por instructores/administración como apoyo al trabajador. |
| **CP-TRB-045** | Límite | Tarea vencida iniciada fuera de plazo | 1. Recibir una tarea con Deadline vencido y tratar de Iniciar (`en progreso`). | Se inicia pero aparece una alerta "Tarea con retraso", o si se predefine una regla dura en backend, bloquea la acción. |
| **CP-TRB-046** | Límite | Recarga de página con adjuntos encolados | 1. Seleccionar imagenes de evidencia y darle F5 accidentalmente antes de "Guardar". | El input file normal de HTML pierde los archivos cargados, forzando la UX obligatoria de re-seleccionar. |

---

## 1️⃣4️⃣ Sesión y Logout

| ID Caso | Tipo | Descripción | Pasos de Ejecución | Resultado Esperado |
| :--- | :--- | :--- | :--- | :--- |
| **CP-TRB-047** | Positivo | Cierre de sesión (Logout) exitoso | 1. Clic en Cerrar Sesión en dropdown superior derecha. | Invalida el `$request->session()->invalidate()`, borra Remember Me y manda al root principal Login de la app. |
| **CP-TRB-048** | Seguridad / UX | Guardar después de Timeout por inactividad | 1. Dejar pantalla en edición de tarea 120 minutos (y expirar session).<br>2. Clic Guardar Final | Formulario manda y arroja Error 419 Page Expired redireccionando posteriormente a inicio. (Manejo de excepciones inactividad). |

---

## 1️⃣5️⃣ Formularios Extremos

| ID Caso | Tipo | Descripción | Pasos de Ejecución | Resultado Esperado |
| :--- | :--- | :--- | :--- | :--- |
| **CP-TRB-049** | Límite | Uso de Emojis / Texto UTF-8 masivo | 1. Escribir 500 caracteres japoneses, chinos y emojis 👨🏻‍🔧 en los comentarios / notas enviando la tarea final.<br>2. Post/Submit | Inserción en DB guardada con set Charset (utf8mb4) soportándolo íntegro o si sobrepasa un validator (ej: string/limite max 255) entonces rebota limpio. |
