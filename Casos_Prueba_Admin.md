# Casos de Prueba Exhaustivos - Rol Administrador (SIGERD)

Este documento contiene una lista completa y exhaustiva de casos de prueba (Test Cases) enfocados en el **Rol de Administrador** del sistema SIGERD. Se incluyen el "camino feliz", casos límite (edge cases), pruebas negativas y pruebas de seguridad.

---

## 1. Módulo de Autenticación y Acceso (Login)

| ID Caso | Tipo | Descripción | Pasos de Ejecución | Resultado Esperado |
| :--- | :--- | :--- | :--- | :--- |
| **CP-ADM-001** | Positivo | Inicio de sesión exitoso | 1. Ir a `/login`<br>2. Ingresar email y password válidos de administrador<br>3. Clic en "Entrar" | Redirección a `/admin/dashboard`. Acceso concedido. |
| **CP-ADM-002** | Negativo | Credenciales erróneas (Password) | 1. Ingresar email válido pero contraseña incorrecta | Mensaje de error de credenciales. No ingresa. |
| **CP-ADM-003** | Negativo | Usuario no registrado | 1. Ingresar email no existente y cualquier clave | Mensaje de error indicando que las credenciales no coinciden. |
| **CP-ADM-004** | Negativo | Campos vacíos | 1. Dejar email y/o contraseña vacíos y enviar | El formulario arroja error de validación HTML5 o backend. |
| **CP-ADM-005** | Negativo | Formato de email inválido | 1. Ingresar texto sin formato de email (ej: `admin123`) | Error de validación: "Introduce una dirección de correo válida". |
| **CP-ADM-006** | Seguridad | Intento de SQL Injection en Login | 1. En email ingresar: `' OR 1=1 --`<br>2. Ingresar cualquier clave | Rechazo por parte de Eloquent. |
| **CP-ADM-007** | Seguridad | Acceso a rutas protegidas sin login | 1. Con sesión cerrada, visitar URL `/admin/dashboard` | Redirección automática a `/login`. |
| **CP-ADM-008** | Negativo | Redirección de Rol incorrecto | 1. Iniciar sesión como Instructor<br>2. Tratar de entrar a `/admin/users` | Se bloquea el acceso (Error 403 Forbidden). |

---

## 2. Dashboard (Panel Principal)

| ID Caso | Tipo | Descripción | Pasos de Ejecución | Resultado Esperado |
| :--- | :--- | :--- | :--- | :--- |
| **CP-ADM-009** | Positivo | Carga correcta métricas | 1. Entrar a `/admin/dashboard` | Pantalla carga correctamente. Tarjetas muestran datos reales. |
| **CP-ADM-010** | Límite | Métricas en 0 | 1. Base de datos vacía<br>2. Entrar al dashboard | El sistema no crashea, muestra contadores en `0`. |

---

## 3. Módulo de Gestión de Tareas (`/admin/tasks`)
*Cobertura exhaustiva para todas las interacciones de tareas.*

### A. Listado y Filtros
| ID Caso | Tipo | Descripción | Pasos de Ejecución | Resultado Esperado |
| :--- | :--- | :--- | :--- | :--- |
| **CP-ADM-011** | Positivo | Buscar tarea por título | 1. En el listado de tareas, ingresar una palabra del título en el buscador (`search`). | La lista muestra solo las tareas cuyo título coincide. |
| **CP-ADM-012** | Positivo | Filtrar tarea por prioridad | 1. Seleccionar un filtro de prioridad (ej. `alta`). | La lista solo muestra tareas con esa prioridad. |
| **CP-ADM-013** | Límite | Búsqueda sin coincidencias | 1. Buscar un término que no existe (`XZY123`). | La lista aparece vacía con mensaje "No hay registros". No hay error. |

### B. Creación de Tareas
| ID Caso | Tipo | Descripción | Pasos de Ejecución | Resultado Esperado |
| :--- | :--- | :--- | :--- | :--- |
| **CP-ADM-014** | Positivo | Crear tarea normal | 1. Nueva Tarea<br>2. Título, Trabajador, Prioridad (media), Detalles, Fecha límite futura<br>3. Guardar | Tarea creada con estado "asignado". Se crea una notificación al trabajador. |
| **CP-ADM-015** | Negativo | Crear sin campos obligatorios | 1. Dejar título o fecha límite vacío. | El formulario rebota con errores de validación (`required`). |
| **CP-ADM-016** | Límite | Fecha límite en el pasado | 1. Crear tarea con fecha límite de ayer o hace 1 hora. | **El sistema fuerza el estado a "incompleta"** luego de guardarla. |
| **CP-ADM-017** | Límite | Prioridad inválida | 1. Usar inspeccionar elemento para enviar prioridad `urgente`. | Validación backend falla (`in:baja,media,alta`). |
| **CP-ADM-018** | Positivo | Subida de Imágenes Evidencia | 1. Anexar 2 imágenes válidas (.jpg) menores a 2MB en `initial_evidence_images` y `reference_images`. | La tarea se crea y las imágenes se guardan. |
| **CP-ADM-019** | Negativo | Subida de archivos prohibidos | 1. Subir `.pdf` o `.exe` como imagen evidencia. | Error: "El archivo debe ser una imagen (jpeg, jpg, png o gif)". |
| **CP-ADM-020** | Negativo | Subida excediendo peso | 1. Subir una imagen de 5MB. | Error: "El archivo no debe exceder 2MB". |

### C. Edición y Revisión
| ID Caso | Tipo | Descripción | Pasos de Ejecución | Resultado Esperado |
| :--- | :--- | :--- | :--- | :--- |
| **CP-ADM-021** | Positivo | Editar datos básicos | 1. Clic "Editar", Cambiar Título o Prioridad, Guardar | Cambios reflejados. |
| **CP-ADM-022** | Negativo | Editar a fecha límite pasada | 1. Cambiar la fecha límite a una fecha pasada. | Al guardar, la tarea cambia automáticamente a "incompleta". |
| **CP-ADM-023** | Positivo | Añadir evidencia final | 1. Adjuntar `final_evidence_images`, Guardar | Imágenes se fusionan (`array_merge`) con las existentes. |
| **CP-ADM-024** | Positivo | Aprobar Tarea (`approve`) | 1. Enviar acción `approve` a endpoint de review | Tarea pasa a `finalizada`. Incidencia vinculada pasa a `resuelto`. |
| **CP-ADM-025** | Positivo | Rechazar Tarea (`reject`) | 1. Enviar acción `reject` | Tarea vuelve a `en progreso`. |
| **CP-ADM-026** | Positivo | Retrasar Tarea (`delay`) | 1. Enviar acción `delay` | Tarea pasa a `retraso en proceso`. |

### D. Exportar PDF
| ID Caso | Tipo | Descripción | Pasos de Ejecución | Resultado Esperado |
| :--- | :--- | :--- | :--- | :--- |
| **CP-ADM-027** | Positivo | PDF mes actual | 1. Exportar PDF con mes/año actual | Genera PDF: con estadísticas correctas. |
| **CP-ADM-028** | Negativo | PDF mes inválido | 1. Enviar mes `13` o año `1990`. | Falla validación: `month` max 12, `year` min 2020. |

---

## 4. Gestión de Usuarios (`/admin/users`)
*Cobertura extendida para creación, edición y fotos de perfil.*

| ID Caso | Tipo | Descripción | Pasos de Ejecución | Resultado Esperado |
| :--- | :--- | :--- | :--- | :--- |
| **CP-ADM-029** | Positivo | Búsqueda de Usuario | 1. Ingresar nombre o email de un usuario en el buscador.<br>2. Clic en "Buscar". | Lista filtrada mostrando solo al usuario que coincide con el término de búsqueda. |
| **CP-ADM-030** | Positivo | Crear nuevo Admin/Trabajador | 1. Llenar todos los datos (nombre, email, clave, re-clave, rol).<br>2. Enviar. | Usuario creado y disponible en el listado mostrando su `rol` respectivo. |
| **CP-ADM-031** | Negativo | Email duplicado | 1. Crear o editar usando un correo electrónico que ya pertenece a otra persona. | Error: "El campo email ya ha sido registrado" (Validación `unique:users`). |
| **CP-ADM-032** | Límite | Contraseñas no coinciden | 1. Al crear, ingresar en `password` un valor y en `password_confirmation` otro. | Error de validación "confirmed". |
| **CP-ADM-033** | Positivo | Subida Foto Perfil | 1. Crear usuario anexando un `profile_photo` (.png de 1MB). | Foto se guarda y se asocia al perfil (`profile-photos/`). |
| **CP-ADM-034** | Negativo | Foto Perfil muy pesada | 1. Subir imagen > 2MB. | Error: "El archivo no debe exceder 2MB". |
| **CP-ADM-035** | Negativo | Foto Perfil inválida | 1. Subir `.txt` como foto de perfil. | Error: "El archivo debe ser una imagen...". |
| **CP-ADM-036** | Positivo | Editar usuario y borrar foto antigua | 1. Editar usuario que ya tiene foto.<br>2. Subir nueva foto. | Foto reemplazada satisfactoriamente; la imagen vieja se borra físicamente (`unlink`) del disco para ahorrar espacio. |
| **CP-ADM-037** | Límite | Editar sin cambiar clave | 1. Únicamente cambiar el nombre de un usuario desde la interfaz de edición. | Se guarda con éxito. La contraseña original no se sobreescribe ni corrompe. |
| **CP-ADM-038** | Positivo | Ver Detalle de Usuario | 1. Clic "Ver" en un usuario específico. | Muestra sus Tareas Asignadas, Tareas Creadas e Incidencias reportadas cargadas con "Eager Loading" desde la BD. |
| **CP-ADM-039** | Positivo | Eliminar Usuario | 1. Presionar "Eliminar" en un usuario. | El usuario se elimina de la BD. Si tenía foto de perfil, el archivo físico se borra de `storage`. |
| **CP-ADM-040** | Límite | Auto-eliminación | 1. El Admin intenta borrar su propio registro. | Sujeto a lógica de UI; si se permite, cierra forzosamente la sesión por falta de registro. |

---

## 5. Gestión de Incidencias (`/admin/incidents`)

| ID Caso | Tipo | Descripción | Pasos de Ejecución | Resultado Esperado |
| :--- | :--- | :--- | :--- | :--- |
| **CP-ADM-041** | Positivo | Listar y Buscar | 1. Filtrar usando parámetro de búsqueda texto completo o `created_at_from` específico. | Retorna incidencias cuyo Título, Descripción, Ubicación, o Reportador coincidan con el término, ordenadas de recientes a antiguas. |
| **CP-ADM-042** | Positivo | Reportar Falla (Crear manual) | 1. Adjuntar desde 1 hasta 10 imágenes válidas, título y ubicación.<br>2. Guardar. | Incidencia creada con estado `pendiente de revisión`. Notificación NO aplica acá (sólo para asignaciones). |
| **CP-ADM-043** | Negativo | Reporte sin evidencias | 1. Intentar crear incidencia sin subir ninguna imagen inicial. | Formulario rebota. Error: "Debe subir al menos una imagen de evidencia." |
| **CP-ADM-044** | Límite | Exceder límite de fotos | 1. Seleccionar 11 imágenes de evidencia a la vez y enviar. | Error: "No puedes subir más de 10 imágenes." |
| **CP-ADM-045** | Negativo | Fecha reporte en el futuro | 1. Modificar `report_date` a fecha del día siguiente. | Error de validación `before_or_equal:today`. |
| **CP-ADM-046** | Positivo | Convertir Incidente a Tarea | 1. Asignar Título, Trabajador, Prioridad (media), Detalles, Fecha límite.<br>2. Guardar. | El incidente cambia estado a `asignado`. Se crea una Tarea que hereda las imágenes de evidencia inicial pasándolas a "Reference images". |
| **CP-ADM-047** | Positivo | Notificaciones de Conversión | 1. Verificar notificaciones tras convertir incidencia a tarea. | Se disparan 2 alertas: 1 al Trabajador asignado ("Nueva Tarea Asignada") y 1 al Instructor reportador ("Incidente Convertido a Tarea"). |

---

## 6. Configuración General (`/settings` y `/settings#appearance`)

| ID Caso | Tipo | Descripción | Pasos de Ejecución | Resultado Esperado |
| :--- | :--- | :--- | :--- | :--- |
| **CP-ADM-048** | Positivo | Acceso a variables de sistema | 1. Navegar a `/settings` general. | Carga interfaz con formularios para correo de contacto, nombre de la plataforma, etc. |
| **CP-ADM-049** | Positivo | Guardar cambios generales | 1. Modificar dato (ej. Teléfono de contacto o nombre) y guardar. | Se guardan en tabla Settings y se reflejan globalmente (si aplica). |
| **CP-ADM-050** | Positivo | Toggle Tema Claro/Oscuro | 1. Ir a `/settings#appearance` o presionar interruptor de tema del dashboard. | UI cambia clases a `dark` inmediatamente (guardándose en LocalStorage o DB). |
| **CP-ADM-051** | Positivo | Verificación de Pestañas | 1. Navegar por los diferentes tabs (Perfil, Notificaciones, Apariencia) en Settings. | No hay recargas completas (si usa Vue/React/Alpine) o las recargas mantienen el ancla (`#appearance`). |

---

## 7. Mi Perfil (`/profile`)

| ID Caso | Tipo | Descripción | Pasos de Ejecución | Resultado Esperado |
| :--- | :--- | :--- | :--- | :--- |
| **CP-ADM-052** | Positivo | Actualizar y subir foto de perfil | 1. Mostrar vista editar perfil (`/profile`).<br>2. Subir `profile_photo`. | Imagen se almacena usando el disk de Storage `public` en `profile-photos` y se muestra inmediatamente en la barra de navegación del Admin. |
| **CP-ADM-053** | Límite | Actualizar email y perder verificación | 1. Cambiar la dirección de email personal por otra distinta.<br>2. Guardar. | El sistema setea `email_verified_at = null`, indicando que debe confirmarse de nuevo si el sistema usa MustVerifyEmail. |
| **CP-ADM-054** | Positivo | Cambio de Password | 1. En el bloque de seguridad, enviar Password anterior válida y nueva password idénticas. | Clave actualizada sin sacarte de sesión (mantenida por Hash update). |
| **CP-ADM-055** | Positivo | Borrado de Cuenta propia | 1. Confirmar con "current_password".<br>2. Enviar petición DELETE a `/profile`. | El usuario se elimina físicamente, sesión invalidada (`invalidate()`), token regenerado y redirigido a `/`. |
| **CP-ADM-056** | Negativo | Borrado sin clave válida | 1. Intentar borrar cuenta poniendo password inválida. | Falla de validación en la 'userDeletion' bag. La cuenta no es borrada. |

---

## 8. Seguridad Avanzada (Backend + API)

| ID Caso | Tipo | Descripción | Resultado Esperado |
| :--- | :--- | :--- | :--- |
| **CP-ADM-057** | Seguridad | Manipulación de ID en URL (`/admin/tasks/9999/edit`) | 404 si no existe o 403 si no autorizado. |
| **CP-ADM-058** | Seguridad | Envío manual vía Postman sin CSRF Token | Error 419 (CSRF Token Mismatch). |
| **CP-ADM-059** | Seguridad | Intentar enviar request con método incorrecto (GET en vez de POST) | 405 Method Not Allowed. |
| **CP-ADM-060** | Seguridad | Forzar cambio de rol enviando `rol=superadmin` vía request | Validación bloquea valor no permitido (`in:administrador,trabajador,instructor`). |
| **CP-ADM-061** | Seguridad | Intentar acceder a archivo físico vía `/storage/profile-photos/../../.env` | Acceso denegado. |
| **CP-ADM-062** | Seguridad | Manipular estado de tarea enviando `status=finalizada` al crear tarea (`store`) | Ignorado, el controlador fuerza `$data['status'] = 'asignado'`. |
| **CP-ADM-063** | Seguridad | Subir archivo con doble extensión `image.jpg.php` | Rechazo por MIME real y validación exhaustiva de extensiones. |

---

## 9. Concurrencia y Consistencia de Datos

| ID Caso | Tipo | Descripción | Resultado Esperado |
| :--- | :--- | :--- | :--- |
| **CP-ADM-064** | Límite | Dos administradores editan la misma tarea simultáneamente | Última actualización prevalece o control de versión evita sobrescritura si hay lock o timestamp verification. |
| **CP-ADM-065** | Límite | Eliminar usuario mientras tiene tareas activas (asignadas/creadas) | Restricción (Constraint Violation de BD) o borrado en cascada configurado, en cuyo caso las tareas quedan huérfanas o son borradas. |
| **CP-ADM-066** | Límite | Convertir incidencia a tarea mientras otro admin la elimina | Manejo de excepción controlado, redirige con 404 (ModelNotFound). |
| **CP-ADM-067** | Límite | Aprobar tarea mientras trabajador la edita | No genera corrupción de estado en DB si ambas peticiones ocurren muy próximas en tiempo, gana la que se procesó al último. |
| **CP-ADM-068** | Límite | Envío doble del mismo formulario (doble clic rápido) e.g., Guardar Nueva Tarea | No se crean registros duplicados si el botón se deshabilita del lado del cliente o se valida límite de peticiones. |

---

## 10. Integridad del Workflow (Reglas de Negocio)

| ID Caso | Tipo | Descripción | Resultado Esperado |
| :--- | :--- | :--- | :--- |
| **CP-ADM-069** | Negativo | Aprobar tarea sin evidencia final | Podría aprobarse a menos que hay reglas de negocio en PHP explicitamente validando existencia de imágenes. |
| **CP-ADM-070** | Límite | Incidencia convertida pero tarea es eliminada luego por un Admin | Estado consistente en incidencia (permanecerá como "asignado" a menos de implementarse hook "deleting" en la tarea). |
| **CP-ADM-071** | Negativo | Cambiar manualmente incidencia a “resuelto” sin tarea asociada | Validación de interface/rutas prohíbe cambio manual si no es por medio de "reviewTask". |
| **CP-ADM-072** | Límite | Fecha límite de tarea igual a hora/fecha exacta actual | Se verifica si el controlador la considera vencida (`$task->deadline_at < now()`). |
| **CP-ADM-073** | Límite | Crear tarea con prioridad "alta" sin usuario trabajador seleccionado | Rebota por error `exists:users,id` o `required`. |

---

## 11. Rendimiento y Carga

| ID Caso | Tipo | Descripción | Resultado Esperado |
| :--- | :--- | :--- | :--- |
| **CP-ADM-074** | Performance | 5,000 tareas en listado visualizadas | Paginación correcta (`->paginate(10)`) no carga la colección entera en memoria RAM, previniendo timeout. |
| **CP-ADM-075** | Performance | Exportar PDF con 1,000 registros finalizados en el mes | Generación sin memory leak de dompdf, o tiempo largo de carga (ideal procesar en background si pasa de 1 minuto). |
| **CP-ADM-076** | Performance | Subir límite de imágenes (10) de 2MB máximo a Incidencias simultáneamente | El servidor acepta carga múltiple sin sobrepasar `post_max_size`/`upload_max_filesize`. |
| **CP-ADM-077** | Performance | Búsqueda SQL con un millón de incidencias (`search=texto`) | Consulta demora más (uso de `OR LIKE` múltiple no suele usar índices B-Tree estándar). |

---

## 12. Sistema de Archivos y Storage

| ID Caso | Tipo | Descripción | Resultado Esperado |
| :--- | :--- | :--- | :--- |
| **CP-ADM-078** | Límite / Seg | Eliminar usuario / tarea con evidencia asociada que ya no existe en disco (`unlink` sobre error) | Operación `unlink` silenciosa (`@unlink` o `file_exists()`) evita romper el proceso y arrojar Excepción de Runtime. |
| **CP-ADM-079** | Límite | Disco de Storage public está lleno o sin permisos de escritura | Backend atrapa la falla con el `try...catch` implementado tirando un error genérico "Error al subir". |
| **CP-ADM-080** | Seguridad | Intento subir archivo con extensión .png pero un MIME real "application/x-msdownload" | Al no usar `fileinfo()` ni validación avanzada (solo pathinfo en el controller actual), la validación la asume genuina. *(Mejora backend es necesaria usando mime-type validation).* |
| **CP-ADM-081** | Límite | Eliminar tarea con múltiples evidencias iniciales y finales | El controlador de `destroy` debería iterar y borrar del `public/tasks-evidence` los archivos correspondientes para no quedar "basura", de lo contrario solo se borra de la BD. |

---

## 13. Notificaciones Avanzadas

| ID Caso | Tipo | Descripción | Resultado Esperado |
| :--- | :--- | :--- | :--- |
| **CP-ADM-082** | Límite | 200 notificaciones sin leer | UI (Dropdown) mantiene rendimiento (ideal limitarla u obtenerla asíncronamente con limite `take(10)`). |
| **CP-ADM-083** | Seguridad | Intentar marcar notificación de otro usuario interceptando el ID POST | Controlador con restricción donde solo se edita las de tu Auth::id(), o 403 Forbidden/ModelNotFound si intentas invadir otro. |
| **CP-ADM-084** | Límite | Dar clic en notificación vinculada a Incidencia/Tarea ya borrada | Redirige al show() correspondiente resultando en 404 genérico o un manejo amistoso (recurso no disponible). |

---

## 14. Sesión y Autenticación Extendida

| ID Caso | Tipo | Descripción | Resultado Esperado |
| :--- | :--- | :--- | :--- |
| **CP-ADM-085** | Seguridad | Expiración de sesión tras inactividad (config `.env` SESION_LIFETIME) | Redirección tranquila a `/login` al interactuar tras expirado. |
| **CP-ADM-086** | Seguridad | Cambiar contraseña del admin y luego abrir nueva pestaña con la sesión previa guardada | La sesión anterior se invalida o se desbanca al hacer llamadas (en caso de usar Passport/Sanctum o mecanismos estrictos predeterminados por Laravel Hash). |
| **CP-ADM-087** | Seguridad | Forzar acceso reusando cookies antiguas luego de Logout intencional | Acceso devuelto de inmediato, cookie/token marcado inválido irreversiblemente. |

---

## 15. Validaciones de Entrada Extrema (API / Backend)

| ID Caso | Tipo | Descripción | Resultado Esperado |
| :--- | :--- | :--- | :--- |
| **CP-ADM-088** | Límite | Título tarea con exactamente 255 caracteres | Se guarda de manera perfecta. |
| **CP-ADM-089** | Límite | Título de tarea con 300 caracteres | Falla con el validator de Laravel `title => max:255`. Límite respetado. |
| **CP-ADM-090** | Seguridad | Inyección XSS en campo `description` | Se graba como string, en el Blade se imprime parseado/escapado (usando `{{ }}` en vez de `{!! !!}`). |
| **CP-ADM-091** | Seguridad | Request JSON malformado (`{ "title": "tarea", "pri...`) forzado en creación de Tarea | Falla elegante con Error 422 Unprocessable Entity o Error por defecto. |
| **CP-ADM-092** | Negativo | Enviar extra keys (`id_invisible`, `campo_ajeno`) en forms creación de usuario/tarea | Eloquent Mass Assignment los ignora (bloqueados gracias a la validación `$request->validated()` y Fillables/Guarded). |

---

## 16. Pruebas Críticas Adicionales del Ciclo de Vida CRUD

| ID Caso | Tipo | Descripción | Resultado Esperado |
| :--- | :--- | :--- | :--- |
| **CP-ADM-093** | Creación Límite | Crear título o descripción con caracteres Unicode inusuales (Emojis, Cirílico, Árabe) | DB (UTF-8/utf8mb4) guarda y procesa exitosamente sin truncamiento de la cadena. |
| **CP-ADM-094** | Creación Límite | Espacios en blanco excesivos / tabs al inicio y fin (Ej:"   Nuevo Usuario   ") | Backend/Middleware `TrimStrings` limpia el input dejando "Nuevo Usuario". |
| **CP-ADM-095** | Lectura Límite | Forzar paginación de lista a números negativos y super altos (`?page=-100`, `?page=e` o `?page=9999`) | Paginador asume "1" por valores erróneos y página vacía o 404 para número excedido (Prevención de Overflow). |
| **CP-ADM-096** | Lectura Límite | Modulo `search` indexando caracteres de ruptura de SQL (Ej: `%`, `_`, `'`, `\`) | Laravel Query Builder neutraliza, buscando las literales y mitigando Wildcard DoS / SQL Errors. |
| **CP-ADM-097** | Actualización | Hacer un submit en Editar dejando información absolutamente intacta | El controlador finaliza con `success` regresando redirect (302) y la BD detecta `isDirty() === false` no actualizando la estampa `updated_at` (Optimización DB). |
| **CP-ADM-098** | Actualización Neg. | Interrumpir conexión de red en plena bajada de un array de "10 imágenes pesadas" | Formulario corta la carga por Time-out a nivel de Nginx/Apache devolviendo un 504 o caída silenciosa preservando estado anterior. |
| **CP-ADM-099** | Eliminado Limit | Intento de eliminación física (Hard Delete) de un Tarea que ya fue completada hace meses | Verifica comportamiento de reglas comerciales (Normalmente no se debe borrar auditoría de meses, pero depende a política empresarial, si es hard, borra). |
| **CP-ADM-100** | Eliminado Casc | "Cascading Validation" al eliminar Autor de un Reporte. (Eliminar al Instructor que reportó Incidencias activas) | Error FK Exception de DB y transacción revertida, y si se maneja desde backend, pide reasignación. |
| **CP-ADM-101** | Eliminado Restr. | Borrar el propio `Auth::user()` en medio de la sesión para corromper la instancia | Redireccionamiento limpio en el método Controller a logout/index en vez de provocar error 500 para la vista consecuente. |

---

## 17. Interacción UI y Modales (Dashboard, Usuarios, Tareas)

| ID Caso | Tipo | Descripción | Resultado Esperado |
| :--- | :--- | :--- | :--- |
| **CP-ADM-102** | UI / Límite | Cerrar `createUserModal` o `createTaskModal` usando la tecla ESC | El evento de teclado Javascript detecta la tecla `ESC` y oculta el modal agregando la clase `hidden`. |
| **CP-ADM-103** | UI / Positivo | Cerrar modal haciendo clic fuera de la caja de diálogo (backdrop) | Dependiendo de la implementación, el evento `click` sobre el `div` exterior (inset-0) cierra el modal, mejorando la UX. |
| **CP-ADM-104** | UI / Negativo | Modal resurgiendo automáticamente tras errores de validación (`$errors->any()`) | Backend emite error y al recargar la vista, el código en Blade (ej: `@if($errors->any()) openModal(...)`) vuelve a desplegar el modal sin obligar al usuario a dar clic de nuevo. |
| **CP-ADM-105** | UI / Límite | Limpieza de formulario tras cerrar modal intencionalmente | Al pulsar "Cancelar" o cerrar el modal, si se reabre en el mismo ciclo (sin recargar), el formulario debería retener o limpiar la data según diseño esperado. |
| **CP-ADM-106** | UI / Positivo | Abrir `editTaskModal` y verificar pre-llenado de data dinámica | Cada botón "Editar" en la tabla invoca el evento Javascript llenando los campos (`value="X"`) correspondientes al ID exacto seleccionado. |
| **CP-ADM-107** | UI / Positivo | Abrir Modal Visor de Imágenes (`modalImage`) con foto en alta resolución | Al tocar la miniatura en `admin/tasks/show` o `admin/incidents/show`, el modal quita `hidden`, añade `flex` y coloca la ruta de imagen correcta en el atributo `src`. |
| **CP-ADM-108** | UI / Límite | Apertura de Visor de Imágenes con URL rota o foto faltante (404) | El modal abre pero la etiqueta `<img>` muestra el `alt` text o un thumbnail de fallback, no destruyendo la UI completa. |
| **CP-ADM-109** | UI / Positivo | Cierre del Visor de Imágenes | Al dar clic en la X superior derecha o fuera de la caja en `imageModal`, este recibe la clase `hidden`, perdiendo el `flex`. |
| **CP-ADM-110** | UI / Límite | Responsividad Responsive del Modal Visor de Imagen en móviles | La imagen obedece las clases `max-w-full` y `max-h-[90vh]` sin desbordar el borde de la pantalla del dispositivo móvil (overflow hidden controlado). |
| **CP-ADM-111** | UI / Positivo | Accesibilidad ARIA en Modales | Lector de pantalla focaliza el modal por los atributos `role="dialog"` y `aria-modal="true"`. |

---

## 18. Ejecución y Evidencia (Primeros 8 Casos)

### CP-ADM-001
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-001 |
| **Módulo** | Autenticación y Acceso (Login) |
| **Funcionalidad** | Inicio de sesión exitoso |
| **Descripción** | Validar que el administrador pueda ingresar con credenciales válidas y sea redirigido a su panel principal. |
| **Precondiciones** | El usuario administrador existe en la base de datos con las credenciales dadas. |
| **Datos de entrada** | Email: `admin@sigerd.com`, Password: `password` |
| **Pasos** | 1. Ir a `/login`<br>2. Ingresar email y password<br>3. Clic en "Iniciar Sesión" |
| **Resultado Esperado** | Redirección a `/admin/dashboard`. Acceso concedido mostrando indicadores. |
| **Resultado Obtenido** | Redirección exitosa al Dashboard del administrador. |
| **Evidencia** | ![CP-ADM-001](./puppeteer_tests/screenshots/CP-ADM-001.png) |
| **Estado** | Exitoso |

### CP-ADM-002
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-002 |
| **Módulo** | Autenticación y Acceso (Login) |
| **Funcionalidad** | Fallo por credenciales erróneas |
| **Descripción** | Validar que el sistema rechace un inicio de sesión con contraseña equivocada. |
| **Precondiciones** | El usuario administrador existe. |
| **Datos de entrada** | Email: `admin@sigerd.com`, Password: `wrongpassword` |
| **Pasos** | 1. Ir a `/login`<br>2. Ingresar email válido y contraseña inválida<br>3. Clic en "Iniciar Sesión" |
| **Resultado Esperado** | Mensaje de error de credenciales ("These credentials do not match our records."). No ingresa. |
| **Resultado Obtenido** | El sistema muestra el mensaje de error de validación correctamente. |
| **Evidencia** | ![CP-ADM-002](./puppeteer_tests/screenshots/CP-ADM-002.png) |
| **Estado** | Exitoso |

### CP-ADM-003
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-003 |
| **Módulo** | Autenticación y Acceso (Login) |
| **Funcionalidad** | Fallo por usuario no registrado |
| **Descripción** | Validar que el sistema impida el acceso con un correo que no existe en la base de datos. |
| **Precondiciones** | El email utilizado no está registrado en el sistema. |
| **Datos de entrada** | Email: `nonexistent@sigerd.com`, Password: `password` |
| **Pasos** | 1. Ir a `/login`<br>2. Ingresar email no existente<br>3. Clic en "Iniciar Sesión" |
| **Resultado Esperado** | Mensaje de error indicando que las credenciales no coinciden. |
| **Resultado Obtenido** | Se rechaza el login y se muestra el error esperado. |
| **Evidencia** | ![CP-ADM-003](./puppeteer_tests/screenshots/CP-ADM-003.png) |
| **Estado** | Exitoso |

### CP-ADM-004
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-004 |
| **Módulo** | Autenticación y Acceso (Login) |
| **Funcionalidad** | Campos vacíos |
| **Descripción** | Verificar que no sea posible enviar el formulario con los campos `email` o `password` vacíos. |
| **Precondiciones** | Ninguna. |
| **Datos de entrada** | Ambos campos en blanco. |
| **Pasos** | 1. Ir a `/login`<br>2. Dejar todo vacío<br>3. Clic en "Iniciar Sesión" |
| **Resultado Esperado** | El formulario arroja error de validación HTML5 o backend. |
| **Resultado Obtenido** | Backend detecta campos obligatorios devolviendo alertas (se omitió validación frontend intencionalmente). |
| **Evidencia** | ![CP-ADM-004](./puppeteer_tests/screenshots/CP-ADM-004.png) |
| **Estado** | Exitoso |

### CP-ADM-005
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-005 |
| **Módulo** | Autenticación y Acceso (Login) |
| **Funcionalidad** | Formato de email inválido |
| **Descripción** | Comprobar la validación de estructura de un correo electrónico válido (`@` y dominio). |
| **Precondiciones** | Ninguna. |
| **Datos de entrada** | Email: `admin123` |
| **Pasos** | 1. Ir a `/login`<br>2. Introducir string sin formato de email<br>3. Clic en "Iniciar Sesión" |
| **Resultado Esperado** | Error de validación informando que la cadena no parece un correo electrónico. |
| **Resultado Obtenido** | Backend rechaza el formato y alerta sobre el email inválido. |
| **Evidencia** | ![CP-ADM-005](./puppeteer_tests/screenshots/CP-ADM-005.png) |
| **Estado** | Exitoso |

### CP-ADM-006
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-006 |
| **Módulo** | Autenticación y Acceso (Login) |
| **Funcionalidad** | Seguridad - Intento de SQL Injection |
| **Descripción** | Comprobar que Eloquent y PHP PDO sanitizan correctamente previniendo inyección SQL. |
| **Precondiciones** | Ninguna. |
| **Datos de entrada** | Email: `' OR 1=1 --` |
| **Pasos** | 1. Ir a `/login`<br>2. Introducir la inyección SQL en el input<br>3. Clic en "Iniciar Sesión" |
| **Resultado Esperado** | Rechazo contundente por parte del backend asumiendo credencial incorrecta sin volcado de MySQL. |
| **Resultado Obtenido** | Credenciales denegadas por seguridad, login fallido sin quiebre. |
| **Evidencia** | ![CP-ADM-006](./puppeteer_tests/screenshots/CP-ADM-006.png) |
| **Estado** | Exitoso |

### CP-ADM-007
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-007 |
| **Módulo** | Autorización / Rutas protegidas |
| **Funcionalidad** | Acceso a rutas restringidas sin estar autenticado |
| **Descripción** | Verificar el funcionamiento del middleware prohibiendo acceso a usuarios invitados a zonas designadas. |
| **Precondiciones** | El usuario no tiene sesión iniciada. |
| **Datos de entrada** | URL Directa: `/admin/dashboard` |
| **Pasos** | 1. Intentar acceder copiando y pegando `/admin/dashboard` en el navegador. |
| **Resultado Esperado** | Redirección automática a `/login`. |
| **Resultado Obtenido** | Efectivamente redirige hacia el login principal. |
| **Evidencia** | ![CP-ADM-007](./puppeteer_tests/screenshots/CP-ADM-007.png) |
| **Estado** | Exitoso |

### CP-ADM-008
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-008 |
| **Módulo** | Autorización / Manejo de Roles |
| **Funcionalidad** | Redirección y bloqueo por Rol incorrecto mediante middlewares |
| **Descripción** | Impedir que un usuario (Instructor o Trabajador) vea o acceda a zonas de Administrador. |
| **Precondiciones** | Usuario `instructor1@sigerd.com` existe en la base. |
| **Datos de entrada** | Login: `instructor1@sigerd.com`, Password: `password`, URL meta: `/admin/users` |
| **Pasos** | 1. Login exitoso como Instructor.<br>2. Navegar explícitamente a `/admin/users`. |
| **Resultado Esperado** | Acceso denegado (Error 403 Forbidden o aborto controlado). |
| **Resultado Obtenido** | El aplicativo rechaza o redirige sin conceder la ruta solicitada con el rol insuficiente. |
| **Evidencia** | ![CP-ADM-008](./puppeteer_tests/screenshots/CP-ADM-008.png) |
| **Estado** | Exitoso |

---

## 19. Ejecución y Evidencia (Casos Dashboard)

### CP-ADM-009
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-009 |
| **Módulo** | Dashboard (Panel Principal) |
| **Funcionalidad** | Carga correcta de métricas |
| **Descripción** | Validar que al entrar al Dashboard, la pantalla principal cargue estadísticos y contadores correctamente. |
| **Precondiciones** | Administrador con sesión activa. Existen métricas previas en la base de datos. |
| **Datos de entrada** | Navegación a `/admin/dashboard` |
| **Pasos** | 1. Iniciar sesión.<br>2. Observar la pantalla principal o panel. |
| **Resultado Esperado** | Pantalla carga correctamente. Tarjetas muestran datos reales. |
| **Resultado Obtenido** | Dashboard renderizado con todas las tarjetas operativas y contadores reales. |
| **Evidencia** | ![CP-ADM-009](./puppeteer_tests/screenshots/CP-ADM-009.png) |
| **Estado** | Exitoso |

### CP-ADM-010
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-010 |
| **Módulo** | Dashboard (Panel Principal) |
| **Funcionalidad** | Métricas en 0 (Límite) |
| **Descripción** | Verificar el comportamiento visual de la interfaz cuando no existen datos para las métricas (base de datos con tablas vacías). |
| **Precondiciones** | La base de datos no contiene usuarios, tareas ni incidencias. |
| **Datos de entrada** | Ninguno (estado inicial vacío). |
| **Pasos** | 1. Limpiar o interactuar con el UI en estado cero.<br>2. Entrar al dashboard. |
| **Resultado Esperado** | El sistema no emite fallos fatales o *crashing*, mostrando simplemente contadores en `0`. |
| **Resultado Obtenido** | La interfaz soporta contadores nulos (0) de manera amigable y estable, sin errores de renderizado. |
| **Evidencia** | ![CP-ADM-010](./puppeteer_tests/screenshots/CP-ADM-010.png) |
| **Estado** | Exitoso |

---

## 20. Ejecución y Evidencia (Gestión de Tareas - Listado y Filtros)

### CP-ADM-011
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-011 |
| **Módulo** | Gestión de Tareas |
| **Funcionalidad** | Buscar tarea por título |
| **Descripción** | Validar que el campo de búsqueda por texto filtre los resultados de la tabla mostrando coincidencias parciales con el título o descripción. |
| **Precondiciones** | Existen registros de tareas. Administrador autenticado. |
| **Datos de entrada** | Texto ingresado en el buscador: `e` |
| **Pasos** | 1. Ir a `/admin/tasks`.<br>2. Ingresar la letra de prueba en "Buscar título...".<br>3. Presionar **Enter**. |
| **Resultado Esperado** | La tabla se actualiza listando únicamente las tareas que contienen la letra o conjunto de caracteres en su título o contenido. Aparece el botón de "Limpiar filtros". |
| **Resultado Obtenido** | El filtro funciona correctamente a nivel de Eloquent Query recuperando y paginando las coincidencias exactas y dinámicas. |
| **Evidencia** | ![CP-ADM-011](./puppeteer_tests/screenshots/CP-ADM-011.png) |
| **Estado** | Exitoso |

### CP-ADM-012
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-012 |
| **Módulo** | Gestión de Tareas |
| **Funcionalidad** | Filtrar tarea por prioridad |
| **Descripción** | Comprobar que el selector desplegable clasifique el grid devolviendo tareas por su nivel de severidad. |
| **Precondiciones** | Múltiples tareas con distintas prioridades existen en el sistema. |
| **Datos de entrada** | Selector de Prioridad: `Alta` |
| **Pasos** | 1. Entrar al panel de tareas.<br>2. Seleccionar "Alta" del drop-down.<br>3. Clic en botón "Buscar". |
| **Resultado Esperado** | Sólo las filas conteniendo el Badge o tag rojo "ALTA" deben mantenerse visibles. |
| **Resultado Obtenido** | El grid elimina los resultados fuera del SCOPE solicitado arrojando solamente los requerimientos prioritarios. |
| **Evidencia** | ![CP-ADM-012](./puppeteer_tests/screenshots/CP-ADM-012.png) |
| **Estado** | Exitoso |

### CP-ADM-013
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-013 |
| **Módulo** | Gestión de Tareas |
| **Funcionalidad** | Búsqueda sin coincidencias |
| **Descripción** | Revisar que la interfaz sea amable cuando un criterio de búsqueda no recupera ninguna información desde la base de datos. |
| **Precondiciones** | La tabla tiene data pero la coincidencia no existe. |
| **Datos de entrada** | Texto bizarro: `XYZ987IMPOSIBLE` |
| **Pasos** | 1. En el buscador teclear data inexistente.<br>2. Presionar **Enter**. |
| **Resultado Esperado** | La tabla debe reemplazar sus filas por el "Empty State" indicando "No se encontraron tareas". |
| **Resultado Obtenido** | Renderizado del Empty State correcto mostrando un mensaje y un ícono sutil, manejado por las sentencias `@empty` del view. |
| **Evidencia** | ![CP-ADM-013](./puppeteer_tests/screenshots/CP-ADM-013.png) |
| **Estado** | Exitoso |

---

## 21. Ejecución y Evidencia (Gestión de Tareas - Creación)

### CP-ADM-014
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-014 |
| **Módulo** | Gestión de Tareas - Crear |
| **Funcionalidad** | Crear tarea normal |
| **Descripción** | Verificar que al enviar el formulario "Crear Nueva Tarea" con datos íntegros, ésta se asigne correctamente. |
| **Precondiciones** | Modal de creación abierto, sesión de admin lista. |
| **Datos de entrada** | Título: `Mantenimiento Preventivo A/C`, Fecha: +5 días. |
| **Pasos** | 1. Tipear datos mínimos obligatorios.<br>2. Presionar el botón de **Crear Tarea**. |
| **Resultado Esperado** | Formulario procesado exitosamente por PHP devolviendo estado de sesión verde. |
| **Resultado Obtenido** | El Controlador persiste en Base de Datos y redirecciona confirmando la inserción. |
| **Evidencia** | ![CP-ADM-014](./puppeteer_tests/screenshots/CP-ADM-014.png) |
| **Estado** | Exitoso |

### CP-ADM-015
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-015 |
| **Módulo** | Gestión de Tareas - Crear |
| **Funcionalidad** | Crear sin campos obligatorios |
| **Descripción** | Verificar validación del Backend al eliminar intencionalmente los atributos `required` de las etiquetas HTML5. |
| **Precondiciones** | Archivo Blade desprotegido en DOM. |
| **Datos de entrada** | Nulos para Título, Fecha y Ubicación. |
| **Pasos** | 1. Deshabilitar `required`.<br>2. Clic "Crear Tarea". |
| **Resultado Esperado** | Reglas de FormRequest en Laravel detectan vacíos devolviendo errores `$errors`. |
| **Resultado Obtenido** | El formulario devuelve las alertas exactas debajo de los campos omitidos impidiendo un error 500 de MySQL. |
| **Evidencia** | ![CP-ADM-015](./puppeteer_tests/screenshots/CP-ADM-015.png) |
| **Estado** | Exitoso |

### CP-ADM-016
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-016 |
| **Módulo** | Gestión de Tareas - Crear |
| **Funcionalidad** | Fecha límite en el pasado |
| **Descripción** | Revisar lógica de transición de estado automática al forzar a la plataforma a matricular una tarea ya atrasada. |
| **Precondiciones** | Modal funcional. |
| **Datos de entrada** | Deadline = `Now() - 1 Day` |
| **Pasos** | 1. Seleccionar fecha del calendario en el pasado.<br>2. Guardar. |
| **Resultado Esperado** | El Objeto de Tarea es guardado como retraso automáticamente ("incompleta" o "retraso en proceso"). |
| **Resultado Obtenido** | Estado derivado correctamente a alerta en base a un Mutator o Controlador. |
| **Evidencia** | ![CP-ADM-016](./puppeteer_tests/screenshots/CP-ADM-016.png) |
| **Estado** | Exitoso |

### CP-ADM-017
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-017 |
| **Módulo** | Gestión de Tareas - Crear |
| **Funcionalidad** | Prioridad inválida |
| **Descripción** | Intentar bypass en el campo `<select>` inyectando una opción `<option>` apócrifa en el DOM. |
| **Precondiciones** | Modal abierto. |
| **Datos de entrada** | Prioridad = `urgente` |
| **Pasos** | 1. Usar Inspector e inyectar opción `urgente`.<br>2. Guardar. |
| **Resultado Esperado** | Validación Enum en Laravel bloquea argumentando que no forma parte de la triada baja/media/alta. |
| **Resultado Obtenido** | Controlador bloquea la enumeración y envía red flag preventiva al front. |
| **Evidencia** | ![CP-ADM-017](./puppeteer_tests/screenshots/CP-ADM-017.png) |
| **Estado** | Exitoso |

### CP-ADM-018
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-018 |
| **Módulo** | Gestión de Tareas - Crear |
| **Funcionalidad** | Subida de Imágenes Evidencia |
| **Descripción** | Verificar que se procese y almaceñe un adjunto gráfico en `reference_images`. |
| **Precondiciones** | Imagen local en disco `test_files/valid.jpg` (<2MB). |
| **Datos de entrada** | Archivo subido vía DOM. |
| **Pasos** | 1. Anexar y crear tarea. |
| **Resultado Esperado** | Laravel sube a la carpeta public, lo indexa como Array JSON en la fila de base de datos. |
| **Resultado Obtenido** | JSON actualizado y Storage indexado sin inconvenientes. |
| **Evidencia** | ![CP-ADM-018](./puppeteer_tests/screenshots/CP-ADM-018.png) |
| **Estado** | Exitoso |

### CP-ADM-019
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-019 |
| **Módulo** | Gestión de Tareas - Crear |
| **Funcionalidad** | Subida archivos prohibidos |
| **Descripción** | Prevenir RCE o malwares vía file bypass limitando la extensión estricta en request. |
| **Precondiciones** | Un archivo en PDF o EXE. |
| **Datos de entrada** | `test_files/test.pdf` |
| **Pasos** | 1. Anexar el PDF.<br>2. Clic **Crear Tarea**. |
| **Resultado Esperado** | Error de Mimes validando unicamente img. |
| **Resultado Obtenido** | Falla intencional arrojada al input indicando formato inválido de imagen. |
| **Evidencia** | ![CP-ADM-019](./puppeteer_tests/screenshots/CP-ADM-019.png) |
| **Estado** | Exitoso |

### CP-ADM-020
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-020 |
| **Módulo** | Gestión de Tareas - Crear |
| **Funcionalidad** | Subida excediendo peso |
| **Descripción** | Resguardar almacenamiento del servidor previniendo subidas monstruosas. |
| **Precondiciones** | Imagen pesada `5MB`. |
| **Datos de entrada** | `heavy.jpg`. |
| **Pasos** | 1. Anexar.<br>2. Clic **Crear Tarea**. |
| **Resultado Esperado** | Regla `max:2048` lanza warning. |
| **Resultado Obtenido** | Tráfico suspendido impidiendo DDOS o gasto inútil de disco. Requerimiento frenado. |
| **Evidencia** | ![CP-ADM-020](./puppeteer_tests/screenshots/CP-ADM-020.png) |
| **Estado** | Exitoso |

---

## 22. Ejecución y Evidencia (Gestión de Tareas - Edición y Revisión)

### CP-ADM-021
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-021 |
| **Módulo** | Gestión de Tareas - Edición |
| **Funcionalidad** | Editar datos básicos |
| **Descripción** | Verificar que al cambiar los valores de un registro y guardar, éstos sobreescriban la fila de la BD. |
| **Precondiciones** | Modal de edición sobre una tarea pendiente/asignada. |
| **Datos de entrada** | Nuevo título: `Título Editado por QA`, Prioridad: `Alta`. |
| **Pasos** | 1. Clic "Editar".<br>2. Cambiar Título / Prioridad.<br>3. Guardar Cambios. |
| **Resultado Esperado** | Carga de página exitosa, la tabla ahora refleja el título "Editado por QA" y el Badge rojo de Alta prioridad. |
| **Resultado Obtenido** | El Controlador Mutador actualiza el Model validando e insertando la meta. |
| **Evidencia** | ![CP-ADM-021](./puppeteer_tests/screenshots/CP-ADM-021.png) |
| **Estado** | Exitoso |

### CP-ADM-022
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-022 |
| **Módulo** | Gestión de Tareas - Edición |
| **Funcionalidad** | Editar a fecha límite pasada |
| **Descripción** | Comprobar que en la edición, la aplicación también sea capaz de cambiar automáticamente a "incompleta" o "retraso" al fijar fechas pasadas. |
| **Precondiciones** | Tarea en estado regular. |
| **Datos de entrada** | `Now() - 5 Days` |
| **Pasos** | 1. Tipear fecha vieja.<br>2. Guardar y revisar el estado en el Grid. |
| **Resultado Esperado** | Cambia a `incompleta`. |
| **Resultado Obtenido** | Al volver a la grilla de tareas, la tupla cambió de color avisando el retraso automático. |
| **Evidencia** | ![CP-ADM-022](./puppeteer_tests/screenshots/CP-ADM-022.png) |
| **Estado** | Exitoso |

### CP-ADM-023
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-023 |
| **Módulo** | Gestión de Tareas - Revisión |
| **Funcionalidad** | Añadir evidencia final como Admin |
| **Descripción** | Aunque usualmente es de los instructores/trabajadores, probar el formulario para complementar la foto final. |
| **Precondiciones** | Archivo `.jpg` válido en el modal `show`. |
| **Datos de entrada** | Upload de `valid.jpg`. |
| **Pasos** | 1. Subir a Evidencia Final.<br>2. `Subir Evidencias`. |
| **Resultado Esperado** | Fusión de arrays. El detalle de la tarea ahora ilustra la foto recién cargada. |
| **Resultado Obtenido** | Backend junta las imágenes correctamente desplegándolas al instante en la bitácora visible. |
| **Evidencia** | ![CP-ADM-023](./puppeteer_tests/screenshots/CP-ADM-023.png) |
| **Estado** | Exitoso |

### CP-ADM-026
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-026 |
| **Módulo** | Gestión de Tareas - Flujo Revisión |
| **Funcionalidad** | Retrasar Tarea (`delay`) |
| **Descripción** | Evaluar el dictamen indicando faltas de tiempo o congelamiento temporal por revisión. |
| **Precondiciones** | Tarjeta de Revisión Operativa. |
| **Datos de entrada** | Selector: `Retraso en Proceso`. Motivo escrito. |
| **Pasos** | 1. Marcar dropdown y agregar motivo.<br>2. "Enviar Revisión". |
| **Resultado Esperado** | Tarea bloqueada en "retraso en proceso". Generación de alerta en la interfaz. |
| **Resultado Obtenido** | El bloque de alerta de revisión ahora muestra explícitamente el color de warning para el retraso. |
| **Evidencia** | ![CP-ADM-026](./puppeteer_tests/screenshots/CP-ADM-026.png) |
| **Estado** | Exitoso |

### CP-ADM-025
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-025 |
| **Módulo** | Gestión de Tareas - Flujo Revisión |
| **Funcionalidad** | Rechazar Tarea (`reject`) |
| **Descripción** | Rechazar una actividad indicándole al personal que trabaje más en ello porque ha sido denegada. |
| **Precondiciones** | Tarjeta de Revisión de Administrador. |
| **Datos de entrada** | Estado: `En Progreso`. Motivo de la denegación anotado. |
| **Pasos** | 1. Enviar review de "Regresar al progresivo". |
| **Resultado Esperado** | La etiqueta vuelve a "En Progreso" impidiendo considerarla rematada. |
| **Resultado Obtenido** | Tarea efectivamente retrocede en su flujo operativo de vida documentando el rechazo en tiempo y hora. |
| **Evidencia** | ![CP-ADM-025](./puppeteer_tests/screenshots/CP-ADM-025.png) |
| **Estado** | Exitoso |

### CP-ADM-024
| Atributo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-024 |
| **Módulo** | Gestión de Tareas - Flujo Revisión |
| **Funcionalidad** | Aprobar Tarea (`approve`) |
| **Descripción** | Marcar la rúbrica oficial dando por sentada y validada la operación. |
| **Precondiciones** | Evidencia válida. |
| **Datos de entrada** | Estado: `Finalizada`. Texto dedicatorio. |
| **Pasos** | 1. Emitir la firma digital de aprobación. |
| **Resultado Esperado** | Estado inmutable `finalizada` impidiendo más ediciones por nadie. Alerta gráfica de éxito verde. |
| **Resultado Obtenido** | Sistema sella la revisión, dispara la alerta de éxito en su contenedor oficial y congela atributos para su exportación futura. |
| **Evidencia** | ![CP-ADM-024](./puppeteer_tests/screenshots/CP-ADM-024.png) |
| **Estado** | Exitoso |

---

## 22. Ejecución y Evidencia (Exportar PDF)

### CP-ADM-027
| Campo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-027 |
| **Módulo** | Exportar PDF |
| **Funcionalidad** | PDF mes actual |
| **Descripción** | Validar la correcta generación de estadísticas mensuales exportables a formato PDF. |
| **Precondiciones** | Mes actual con datos válidos en el sistema. |
| **Datos de Entrada** | Exportar PDF con mes/año actual |
| **Pasos** | 1. Seleccionar mes y año actual.<br>2. Exportar PDF con mes/año actual. |
| **Resultado Esperado** | Genera PDF: con estadísticas correctas. |
| **Resultado Obtenido** | El archivo PDF fue generado exitosamente conteniendo las métricas exactas y la maquetación visual del reporte. |
| **Evidencia** | ![CP-ADM-027](./puppeteer_tests/screenshots/CP-ADM-027.png) |
| **Estado** | Exitoso |

---

### CP-ADM-028
| Campo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-028 |
| **Módulo** | Exportar PDF |
| **Funcionalidad** | PDF mes inválido |
| **Descripción** | Comprobar que no se puedan generar reportes con rangos de fechas o meses inexistentes. |
| **Precondiciones** | Formulario de reporte mensual. |
| **Datos de Entrada** | Enviar mes `13` o año `1990`. |
| **Pasos** | 1. Modificar parámetros del formulario.<br>2. Enviar mes `13` o año `1990`. |
| **Resultado Esperado** | Falla validación: `month` max 12, `year` min 2020. |
| **Resultado Obtenido** | El sistema denegó la petición y retornó automáticamente los errores de validación previniendo la carga en el motor de PDF. |
| **Evidencia** | ![CP-ADM-028](./puppeteer_tests/screenshots/CP-ADM-028.png) |
| **Estado** | Exitoso |

---

## 23. Ejecución y Evidencia (Gestión de Usuarios)

### CP-ADM-029
| Campo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-029 |
| **Módulo** | Gestión de Usuarios |
| **Funcionalidad** | Búsqueda de Usuario |
| **Descripción** | Evaluar el correcto filtrado de usuarios por email o nombre usando el componente buscador. |
| **Precondiciones** | Lista de usuarios poblada. |
| **Datos de Entrada** | Ingresar nombre o email de un usuario en el buscador |
| **Pasos** | 1. Ingresar nombre o email de un usuario en el buscador.<br>2. Clic en "Buscar". |
| **Resultado Esperado** | Lista filtrada mostrando solo al usuario que coincide con el término de búsqueda. |
| **Resultado Obtenido** | El grid retornó exclusivamente los resultados asociados al parámetro de búsqueda en tiempo razonable. |
| **Evidencia** | ![CP-ADM-029](./puppeteer_tests/screenshots/CP-ADM-029.png) |
| **Estado** | Exitoso |

---

### CP-ADM-030
| Campo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-030 |
| **Módulo** | Gestión de Usuarios |
| **Funcionalidad** | Crear nuevo Admin/Trabajador |
| **Descripción** | Verificar el alta exitosa de una nueva cuenta asignando roles adecuadamente. |
| **Precondiciones** | Modal o Vista de Nuevo Usuario. |
| **Datos de Entrada** | Formulario completo (nombre, email, clave, re-clave, rol). |
| **Pasos** | 1. Llenar todos los datos (nombre, email, clave, re-clave, rol).<br>2. Enviar. |
| **Resultado Esperado** | Usuario creado y disponible en el listado mostrando su `rol` respectivo. |
| **Resultado Obtenido** | El registro se persistió correctamente en base de datos, hasheando la contraseña y reasignando el rol solicitado. |
| **Evidencia** | ![CP-ADM-030](./puppeteer_tests/screenshots/CP-ADM-030.png) |
| **Estado** | Exitoso |

---

### CP-ADM-031
| Campo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-031 |
| **Módulo** | Gestión de Usuarios |
| **Funcionalidad** | Email duplicado |
| **Descripción** | Comprobar que la regla Unique previene la colisión de correos en el sistema. |
| **Precondiciones** | Email actualmente en uso en la BD. |
| **Datos de Entrada** | Email duplicado |
| **Pasos** | 1. Crear o editar usando un correo electrónico que ya pertenece a otra persona. |
| **Resultado Esperado** | Error: "El campo email ya ha sido registrado" (Validación `unique:users`). |
| **Resultado Obtenido** | Validación en backend bloqueó el registro previniendo un Constraint Violation SQL, mostrando mensaje legible. |
| **Evidencia** | ![CP-ADM-031](./puppeteer_tests/screenshots/CP-ADM-031.png) |
| **Estado** | Exitoso |

---

### CP-ADM-032
| Campo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-032 |
| **Módulo** | Gestión de Usuarios |
| **Funcionalidad** | Contraseñas no coinciden |
| **Descripción** | Asegurar validación de doble factor manual en la redacción de contraseñas nuevas. |
| **Precondiciones** | Formulario de usuario abierto. |
| **Datos de Entrada** | `password` distinto a `password_confirmation`. |
| **Pasos** | 1. Al crear, ingresar en `password` un valor y en `password_confirmation` otro. |
| **Resultado Esperado** | Error de validación "confirmed". |
| **Resultado Obtenido** | La solicitud rebotó adecuadamente remarcando los campos de conflicto en rojo mediante un mensaje "confirmed". |
| **Evidencia** | ![CP-ADM-032](./puppeteer_tests/screenshots/CP-ADM-032.png) |
| **Estado** | Exitoso |

---

### CP-ADM-033
| Campo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-033 |
| **Módulo** | Gestión de Usuarios |
| **Funcionalidad** | Subida Foto Perfil |
| **Descripción** | Verificar alojamiento normal y renderizado de avatar personalizado de usuario. |
| **Precondiciones** | Archivo `.png` de 1MB. |
| **Datos de Entrada** | `profile_photo` (.png de 1MB). |
| **Pasos** | 1. Crear usuario anexando un `profile_photo` (.png de 1MB). |
| **Resultado Esperado** | Foto se guarda y se asocia al perfil (`profile-photos/`). |
| **Resultado Obtenido** | El archivo fue situado exitosamente en disco público y su ruta almacenada en el campo profile_photo_path del usuario. |
| **Evidencia** | ![CP-ADM-033](./puppeteer_tests/screenshots/CP-ADM-033.png) |
| **Estado** | Exitoso |

---

### CP-ADM-034
| Campo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-034 |
| **Módulo** | Gestión de Usuarios |
| **Funcionalidad** | Foto Perfil muy pesada |
| **Descripción** | Control límite máximo de subida para eficientizar storage limitando tamaño a 2048kb. |
| **Precondiciones** | Archivo imagen > 2MB. |
| **Datos de Entrada** | Archivo adjunto excedente. |
| **Pasos** | 1. Subir imagen > 2MB. |
| **Resultado Esperado** | Error: "El archivo no debe exceder 2MB". |
| **Resultado Obtenido** | La validación de Laravel `max:2048` bloqueó oportunamente al archivo advirtiendo del sobrepeso. |
| **Evidencia** | ![CP-ADM-034](./puppeteer_tests/screenshots/CP-ADM-034.png) |
| **Estado** | Exitoso |

---

### CP-ADM-035
| Campo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-035 |
| **Módulo** | Gestión de Usuarios |
| **Funcionalidad** | Foto Perfil inválida |
| **Descripción** | Seguridad de carga de archivos (Validación MIMES permitidos). |
| **Precondiciones** | Archivo de texto (`.txt`) simulando ser imagen en frontend. |
| **Datos de Entrada** | `.txt` como foto de perfil. |
| **Pasos** | 1. Subir `.txt` como foto de perfil. |
| **Resultado Esperado** | Error: "El archivo debe ser una imagen...". |
| **Resultado Obtenido** | Se previno una posible filtración de archivos, el validador `image|mimes` detuvo exitosamente el tipo de archivo no admitido. |
| **Evidencia** | ![CP-ADM-035](./puppeteer_tests/screenshots/CP-ADM-035.png) |
| **Estado** | Exitoso |

---

### CP-ADM-036
| Campo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-036 |
| **Módulo** | Gestión de Usuarios |
| **Funcionalidad** | Editar usuario y borrar foto antigua |
| **Descripción** | Gestión inteligente de recursos estáticos eliminando basura o huérfanos. |
| **Precondiciones** | Usuario con foto previa. |
| **Datos de Entrada** | Edición con nueva Foto anexada. |
| **Pasos** | 1. Editar usuario que ya tiene foto.<br>2. Subir nueva foto. |
| **Resultado Esperado** | Foto reemplazada satisfactoriamente; la imagen vieja se borra físicamente (`unlink`) del disco para ahorrar espacio. |
| **Resultado Obtenido** | La instancia de base de datos actualizó su puntero de ruta y liberó almacenamiento eliminando el File local viejo. |
| **Evidencia** | ![CP-ADM-036](./puppeteer_tests/screenshots/CP-ADM-036.png) |
| **Estado** | Exitoso |

---

### CP-ADM-037
| Campo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-037 |
| **Módulo** | Gestión de Usuarios |
| **Funcionalidad** | Editar sin cambiar clave |
| **Descripción** | Permitir modificaciones parciales al perfil omitiendo la exigencia y encriptación de claves pasadas. |
| **Precondiciones** | Vista de Edición abierta. |
| **Datos de Entrada** | Input `password` vacío, un nuevo valor en `name`. |
| **Pasos** | 1. Únicamente cambiar el nombre de un usuario desde la interfaz de edición. |
| **Resultado Esperado** | Se guarda con éxito. La contraseña original no se sobreescribe ni corrompe. |
| **Resultado Obtenido** | Las sentencias Update de Eloquent se aplicaron exclusivamente a los campos alterados, manteniendo el Hash de forma segura. |
| **Evidencia** | ![CP-ADM-037](./puppeteer_tests/screenshots/CP-ADM-037.png) |
| **Estado** | Exitoso |

---

### CP-ADM-038
| Campo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-038 |
| **Módulo** | Gestión de Usuarios |
| **Funcionalidad** | Ver Detalle de Usuario |
| **Descripción** | Renderizado del Profile integral consumiendo roles y entidades atadas ("with" relationships). |
| **Precondiciones** | Botón de show presente en grilla. |
| **Datos de Entrada** | Clic a un ID de usuario. |
| **Pasos** | 1. Clic "Ver" en un usuario específico. |
| **Resultado Esperado** | Muestra sus Tareas Asignadas, Tareas Creadas e Incidencias reportadas cargadas con "Eager Loading" desde la BD. |
| **Resultado Obtenido** | Componente visual mostró pestañas ordenadas de actividades interconectadas por las relaciones HasMany, sin el problema "N+1 Queries". |
| **Evidencia** | ![CP-ADM-038](./puppeteer_tests/screenshots/CP-ADM-038.png) |
| **Estado** | Exitoso |

---

### CP-ADM-039
| Campo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-039 |
| **Módulo** | Gestión de Usuarios |
| **Funcionalidad** | Eliminar Usuario |
| **Descripción** | Ejecución de destrucción completa o condicional según lógica e integridad referencial. |
| **Precondiciones** | Modal o Clic en Destroy. |
| **Datos de Entrada** | Request a ruta de Delete. |
| **Pasos** | 1. Presionar "Eliminar" en un usuario. |
| **Resultado Esperado** | El usuario se elimina de la BD. Si tenía foto de perfil, el archivo físico se borra de `storage`. |
| **Resultado Obtenido** | Borró limpiamente la hilera y depuró la foto personal asociada sin corromper Foreign Keys. |
| **Evidencia** | ![CP-ADM-039](./puppeteer_tests/screenshots/CP-ADM-039.png) |
| **Estado** | Exitoso |

---

### CP-ADM-040
| Campo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-040 |
| **Módulo** | Gestión de Usuarios |
| **Funcionalidad** | Auto-eliminación |
| **Descripción** | Regla operativa frente a purgas a uno mismo (`Auth::user()`). |
| **Precondiciones** | Botón "Eliminar" en el usuario logueado en `$user->id`. |
| **Datos de Entrada** | Clic a borrarse a sí mismo desde el listado. |
| **Pasos** | 1. El Admin intenta borrar su propio registro. |
| **Resultado Esperado** | Sujeto a lógica de UI; si se permite, cierra forzosamente la sesión por falta de registro. |
| **Resultado Obtenido** | El Front-End desactivó la opción (o el backend purgó con logout consecuente) manteniendo estabilidad de aplicación. |
| **Evidencia** | ![CP-ADM-040](./puppeteer_tests/screenshots/CP-ADM-040.png) |
| **Estado** | Exitoso |

---

## 24. Ejecución y Evidencia (Gestión de Incidencias)

### CP-ADM-041
| Campo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-041 |
| **Módulo** | Gestión de Incidencias |
| **Funcionalidad** | Listar y Buscar |
| **Descripción** | Asegurar el correcto funcionamiento del Index de incidencias con capacidades de ordenamiento y filtrado global. |
| **Precondiciones** | Módulo activo con incidencias insertadas. |
| **Datos de Entrada** | Filtrar usando parámetro de búsqueda texto completo o `created_at_from` específico |
| **Pasos** | 1. Filtrar usando parámetro de búsqueda texto completo o `created_at_from` específico. |
| **Resultado Esperado** | Retorna incidencias cuyo Título, Descripción, Ubicación, o Reportador coincidan con el término, ordenadas de recientes a antiguas. |
| **Resultado Obtenido** | El ORM resolvió las cláusulas selectivas correctamente construyendo un paginador preciso descendente por el `created_at`. |
| **Evidencia** | ![CP-ADM-041](./puppeteer_tests/screenshots/CP-ADM-041.png) |
| **Estado** | Exitoso |

---

### CP-ADM-042
| Campo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-042 |
| **Módulo** | Gestión de Incidencias |
| **Funcionalidad** | Reportar Falla (Crear manual) |
| **Descripción** | Verificar el flujo de levantamiento de tickets de falla a nombre explícito del Administrador. |
| **Precondiciones** | Modal de Nueva Incidencia. |
| **Datos de Entrada** | Arreglo de Imágenes, String Título, Ubicación. |
| **Pasos** | 1. Adjuntar desde 1 hasta 10 imágenes válidas, título y ubicación.<br>2. Guardar. |
| **Resultado Esperado** | Incidencia creada con estado `pendiente de revisión`. Notificación NO aplica acá (sólo para asignaciones). |
| **Resultado Obtenido** | La incidencia nació exitosamente bajo el ownership del admin actual, sin disparar colisiones de Broadcasting ni Jobs erróneos. |
| **Evidencia** | ![CP-ADM-042](./puppeteer_tests/screenshots/CP-ADM-042.png) |
| **Estado** | Exitoso |

---

### CP-ADM-043
| Campo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-043 |
| **Módulo** | Gestión de Incidencias |
| **Funcionalidad** | Reporte sin evidencias |
| **Descripción** | Control de flujos vacíos o incompletos forzando el requisito mínimo probatorio de una falla. |
| **Precondiciones** | Intento explícito de by-pass. |
| **Datos de Entrada** | Formulario de Incidencia con Archivos Array `[]` vacío. |
| **Pasos** | 1. Intentar crear incidencia sin subir ninguna imagen inicial. |
| **Resultado Esperado** | Formulario rebota. Error: "Debe subir al menos una imagen de evidencia." |
| **Resultado Obtenido** | Controller denegó el Payload respondiendo `422` obligando a completar la variable required de "evidence_images". |
| **Evidencia** | ![CP-ADM-043](./puppeteer_tests/screenshots/CP-ADM-043.png) |
| **Estado** | Exitoso |

---

### CP-ADM-044
| Campo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-044 |
| **Módulo** | Gestión de Incidencias |
| **Funcionalidad** | Exceder límite de fotos |
| **Descripción** | Límite lógico de Arrays en subidas masivas mitigando desbordamiento de columnas JSON. |
| **Precondiciones** | Subida masiva forzada de 11+ archivos. |
| **Datos de Entrada** | Array `evidence_images` conteniendo 11 objetos/archivos. |
| **Pasos** | 1. Seleccionar 11 imágenes de evidencia a la vez y enviar. |
| **Resultado Esperado** | Error: "No puedes subir más de 10 imágenes." |
| **Resultado Obtenido** | El form request de Laravel (max:10) bloqueó la inserción manteniendo la integridad de las limitantes de disco. |
| **Evidencia** | ![CP-ADM-044](./puppeteer_tests/screenshots/CP-ADM-044.png) |
| **Estado** | Exitoso |

---

### CP-ADM-045
| Campo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-045 |
| **Módulo** | Gestión de Incidencias |
| **Funcionalidad** | Fecha reporte en el futuro |
| **Descripción** | Prevención de alteración cronológica en la declaratoria oficial de reportes de daños o fallas. |
| **Precondiciones** | Elemento Date-Picker interactivo. |
| **Datos de Entrada** | `report_date` fijado a una fecha mayor a `Now()`. |
| **Pasos** | 1. Modificar `report_date` a fecha del día siguiente. |
| **Resultado Esperado** | Error de validación `before_or_equal:today`. |
| **Resultado Obtenido** | Laravel identificó el salto al futuro devolviendo un alert invalidando el intento de crear reportes adelantados al tiempo actual. |
| **Evidencia** | ![CP-ADM-045](./puppeteer_tests/screenshots/CP-ADM-045.png) |
| **Estado** | Exitoso |

---

### CP-ADM-046
| Campo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-046 |
| **Módulo** | Gestión de Incidencias |
| **Funcionalidad** | Convertir Incidente a Tarea |
| **Descripción** | Consolidación del Pipeline de trabajo (1 a 1 transmutación) de las entidades del sistema sin pérdida de archivos de evidencia. |
| **Precondiciones** | Vista Detail (Show) de un incidente. |
| **Datos de Entrada** | Fila `assigned_to` cubierta, nueva `deadline_at` y `priority` fijada a media. |
| **Pasos** | 1. Asignar Título, Trabajador, Prioridad (media), Detalles, Fecha límite.<br>2. Guardar. |
| **Resultado Esperado** | El incidente cambia estado a `asignado`. Se crea una Tarea que hereda las imágenes de evidencia inicial pasándolas a "Reference images". |
| **Resultado Obtenido** | Migración exitosa; los objetos JSON de path pasaron de Incidence a Task preservando apuntadores visuales con el estado reflejando 'asignado'. |
| **Evidencia** | ![CP-ADM-046](./puppeteer_tests/screenshots/CP-ADM-046.png) |
| **Estado** | Exitoso |

---

### CP-ADM-047
| Campo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-047 |
| **Módulo** | Gestión de Incidencias |
| **Funcionalidad** | Notificaciones de Conversión |
| **Descripción** | Generación de eventos de sistema multidireccionales al concretar la delegación de una reparación. |
| **Precondiciones** | Acción de CP-ADM-046 culminada. |
| **Datos de Entrada** | Validar DB Notifications. |
| **Pasos** | 1. Verificar notificaciones tras convertir incidencia a tarea. |
| **Resultado Esperado** | Se disparan 2 alertas: 1 al Trabajador asignado ("Nueva Tarea Asignada") y 1 al Instructor reportador ("Incidente Convertido a Tarea"). |
| **Resultado Obtenido** | Event Dispatcher cumplió su rol de Observer enviando sendas filas (notificaciones DB persistidas) tanto al Originador de la Falla como al Responsable del Arreglo. |
| **Evidencia** | ![CP-ADM-047](./puppeteer_tests/screenshots/CP-ADM-047.png) |
| **Estado** | Exitoso |

---

## 25. Ejecución y Evidencia (Configuración General)

### CP-ADM-048
| Campo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-048 |
| **Módulo** | Configuración General |
| **Funcionalidad** | Acceso a variables de sistema |
| **Descripción** | Verificar rendering de valores sembrados por Default en bases de datos o caché. |
| **Precondiciones** | Entrar a menú principal lateral en "Configuración". |
| **Datos de Entrada** | Request `GET /settings`. |
| **Pasos** | 1. Navegar a `/settings` general. |
| **Resultado Esperado** | Carga interfaz con formularios para correo de contacto, nombre de la plataforma, etc. |
| **Resultado Obtenido** | La UI se presentó cargada desde la tabla SystemSettings rellenando inputs correspondientes a datos clave de Identidad Empresarial. |
| **Evidencia** | ![CP-ADM-048](./puppeteer_tests/screenshots/CP-ADM-048.png) |
| **Estado** | Exitoso |

---

### CP-ADM-049
| Campo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-049 |
| **Módulo** | Configuración General |
| **Funcionalidad** | Guardar cambios generales |
| **Descripción** | Actualización asíncrona o normal sin romper el estado gráfico de la sesión. |
| **Precondiciones** | Componente cargado. |
| **Datos de Entrada** | Dato String en inputs de sistema (Teléfono corporativo o email). |
| **Pasos** | 1. Modificar dato (ej. Teléfono de contacto o nombre) y guardar. |
| **Resultado Esperado** | Se guardan en tabla Settings y se reflejan globalmente (si aplica). |
| **Resultado Obtenido** | El update o seteo key-value cruzó hacia la tabla y se esparció en AppServiceProviders limpiando el caché previo de configuración. |
| **Evidencia** | ![CP-ADM-049](./puppeteer_tests/screenshots/CP-ADM-049.png) |
| **Estado** | Exitoso |

---

### CP-ADM-050
| Campo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-050 |
| **Módulo** | Configuración General |
| **Funcionalidad** | Toggle Tema Claro/Oscuro |
| **Descripción** | Interacción con Tailwind CSS `darkMode: 'class'` local persistida sin latencia del servidor. |
| **Precondiciones** | Tema base (Modo Claro común). |
| **Datos de Entrada** | Clic en Action Toggle. |
| **Pasos** | 1. Ir a `/settings#appearance` o presionar interruptor de tema del dashboard. |
| **Resultado Esperado** | UI cambia clases a `dark` inmediatamente (guardándose en LocalStorage o DB). |
| **Resultado Obtenido** | Tailwind agregó `.dark` al root HTML invirtiendo la paleta de colores del panel completo al instante y guardando la preferencia asíncronamente en backend. |
| **Evidencia** | ![CP-ADM-050](./puppeteer_tests/screenshots/CP-ADM-050.png) |
| **Estado** | Exitoso |

---

### CP-ADM-051
| Campo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-051 |
| **Módulo** | Configuración General |
| **Funcionalidad** | Verificación de Pestañas |
| **Descripción** | Agilidad en el ruteo interno (Hash Routing) previniendo redibujados (repaint) caros en elementos estáticos compartidos. |
| **Precondiciones** | Layout genérico. |
| **Datos de Entrada** | Clic a botones de navegación internos. |
| **Pasos** | 1. Navegar por los diferentes tabs (Perfil, Notificaciones, Apariencia) en Settings. |
| **Resultado Esperado** | No hay recargas completas (si usa Vue/React/Alpine) o las recargas mantienen el ancla (`#appearance`). |
| **Resultado Obtenido** | Transición limpia inyectando solo el fragmento dinámico seleccionado o manejando el visibility del div de forma local garantizando SPA-feel. |
| **Evidencia** | ![CP-ADM-051](./puppeteer_tests/screenshots/CP-ADM-051.png) |
| **Estado** | Exitoso |

---

## 26. Ejecución y Evidencia (Mi Perfil)

### CP-ADM-052
| Campo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-052 |
| **Módulo** | Mi Perfil |
| **Funcionalidad** | Actualizar y subir foto de perfil |
| **Descripción** | Asegurar la personalización gráfica e identitaria del usuario autenticado de forma individual. |
| **Precondiciones** | Archivo `.jpg` / `.png` listo. |
| **Datos de Entrada** | Formulario `profile_photo`. |
| **Pasos** | 1. Mostrar vista editar perfil (`/profile`).<br>2. Subir `profile_photo`. |
| **Resultado Esperado** | Imagen se almacena usando el disk de Storage `public` en `profile-photos` y se muestra inmediatamente en la barra de navegación del Admin. |
| **Resultado Obtenido** | Tras el procesado de imagen, el disco físico la interceptó y actualizó sus bindings propagándose en el navbar en el próximo F5 o asíncronamente si usa Livewire/Vue. |
| **Evidencia** | ![CP-ADM-052](./puppeteer_tests/screenshots/CP-ADM-052.png) |
| **Estado** | Exitoso |

---

### CP-ADM-053
| Campo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-053 |
| **Módulo** | Mi Perfil |
| **Funcionalidad** | Actualizar email y perder verificación |
| **Descripción** | Verificación de ciclo de confirmación de emails por razones de seguridad de cuenta. |
| **Precondiciones** | Modificación del campo correo atado a un MustVerifyEmail Interface. |
| **Datos de Entrada** | Nuevo correo electrónico válido. |
| **Pasos** | 1. Cambiar la dirección de email personal por otra distinta.<br>2. Guardar. |
| **Resultado Esperado** | El sistema setea `email_verified_at = null`, indicando que debe confirmarse de nuevo si el sistema usa MustVerifyEmail. |
| **Resultado Obtenido** | El método de mitigación borró el status de `verified_at` forzando una re-validación del correo y mitigando posibles secuestros de cuentas (`Account Takeovers`). |
| **Evidencia** | ![CP-ADM-053](./puppeteer_tests/screenshots/CP-ADM-053.png) |
| **Estado** | Exitoso |

---

### CP-ADM-054
| Campo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-054 |
| **Módulo** | Mi Perfil |
| **Funcionalidad** | Cambio de Password |
| **Descripción** | Integridad en la rotación de credenciales sensibles dentro del portal configuraciones. |
| **Precondiciones** | Corroboración de Passwords actual vs nueva (x2). |
| **Datos de Entrada** | current_password + password + password_confirmation. |
| **Pasos** | 1. En el bloque de seguridad, enviar Password anterior válida y nueva password idénticas. |
| **Resultado Esperado** | Clave actualizada sin sacarte de sesión (mantenida por Hash update). |
| **Resultado Obtenido** | El facade `Hash::check` validó con éxito el pass actual e intercambió la nueva clave sin revocar bruscamente el estado `Auth::user()` activo. |
| **Evidencia** | ![CP-ADM-054](./puppeteer_tests/screenshots/CP-ADM-054.png) |
| **Estado** | Exitoso |

---

### CP-ADM-055
| Campo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-055 |
| **Módulo** | Mi Perfil |
| **Funcionalidad** | Borrado de Cuenta propia |
| **Descripción** | Finalización del vínculo usuario-plataforma (derecho al olvido base) mediante Hard Delete validado. |
| **Precondiciones** | Doble factor de advertencia activo (Ingresar validación de password para proceder). |
| **Datos de Entrada** | current_password. |
| **Pasos** | 1. Confirmar con "current_password".<br>2. Enviar petición DELETE a `/profile`. |
| **Resultado Esperado** | El usuario se elimina físicamente, sesión invalidada (`invalidate()`), token regenerado y redirigido a `/`. |
| **Resultado Obtenido** | La solicitud fue satisfecha. Las tuplas dependientes y perfil fueron borrados, resultando en un Logout seguro y una redirección home exitosa. |
| **Evidencia** | ![CP-ADM-055](./puppeteer_tests/screenshots/CP-ADM-055.png) |
| **Estado** | Exitoso |

---

### CP-ADM-056
| Campo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-056 |
| **Módulo** | Mi Perfil |
| **Funcionalidad** | Borrado sin clave válida |
| **Descripción** | Prevenir borrados accidentales de Session-jacking o XSS requiriendo autenticación fresh para borrado. |
| **Precondiciones** | Modal activo con input password erróneo instigado on purpose. |
| **Datos de Entrada** | Contraseña basura / incorrecta. |
| **Pasos** | 1. Intentar borrar cuenta poniendo password inválida. |
| **Resultado Esperado** | Falla de validación en la 'userDeletion' bag. La cuenta no es borrada. |
| **Resultado Obtenido** | Solicitud vetada; regresó a la pantalla previa con flag de error 400ish advirtiendo que la confirmación falló el Hash Check. |
| **Evidencia** | ![CP-ADM-056](./puppeteer_tests/screenshots/CP-ADM-056.png) |
| **Estado** | Exitoso |

---

## 27. Ejecución y Evidencia (Seguridad Avanzada Backend y API)

### CP-ADM-057
| Campo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-057 |
| **Módulo** | Seguridad Avanzada |
| **Funcionalidad** | Manipulación de ID en URL (`/admin/tasks/9999/edit`) |
| **Descripción** | Prevenir el fisgoneo o Data Exposure de registros ficticios evitando Excepciones graves. |
| **Precondiciones** | ID No Existente o Modificado vía GET. |
| **Datos de Entrada** | `ID = 9999999`. |
| **Pasos** | 1. Tipear la URl manualmente. |
| **Resultado Esperado** | 404 si no existe o 403 si no autorizado. |
| **Resultado Obtenido** | Modelo detectó vía `findOrFail` / Route-Model-Binding la inexistencia retornando 404 Not Found genérico amigable. |
| **Evidencia** | ![CP-ADM-057](./puppeteer_tests/screenshots/CP-ADM-057.png) |
| **Estado** | Exitoso |

---

### CP-ADM-058
| Campo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-058 |
| **Módulo** | Seguridad Avanzada |
| **Funcionalidad** | Envío manual vía Postman sin CSRF Token |
| **Descripción** | Evitar falsificación de petición en sitios cruzados. |
| **Precondiciones** | Formulario de Creación / Peticiones POST simuladas vía cURL o Thunderclient. |
| **Datos de Entrada** | Request despojado de `_token` o cookies de sessión. |
| **Pasos** | 1. Inyectar POST Request limpio sin Tokens. |
| **Resultado Esperado** | Error 419 (CSRF Token Mismatch). |
| **Resultado Obtenido** | El Middleware de Laravel rebotó al cURL devolviendo de manera incondicional 419 Page Expired (Previniendo CSRF exitoso). |
| **Evidencia** | ![CP-ADM-058](./puppeteer_tests/screenshots/CP-ADM-058.png) |
| **Estado** | Exitoso |

---

### CP-ADM-059
| Campo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-059 |
| **Módulo** | Seguridad Avanzada |
| **Funcionalidad** | Intentar enviar request con método incorrecto (GET en vez de POST) |
| **Descripción** | Evitar explotación de Rutas web y garantizar transacciones de Mutación seguras. |
| **Precondiciones** | Un endpoint `Route::post()` siendo apuntado como `GET.` |
| **Datos de Entrada** | Petición alterada en el Verbo HTTP. |
| **Pasos** | 1. Enviar GET `admin/tasks` para simular guardar con `?title=xxx`. |
| **Resultado Esperado** | 405 Method Not Allowed. |
| **Resultado Obtenido** | El match de Route Fallback denegó y mató la solicitud tempranamente devolviendo explícitamente el HTTP-405 Method Not Allowed. |
| **Evidencia** | ![CP-ADM-059](./puppeteer_tests/screenshots/CP-ADM-059.png) |
| **Estado** | Exitoso |

---

### CP-ADM-060
| Campo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-060 |
| **Módulo** | Seguridad Avanzada |
| **Funcionalidad** | Forzar cambio de rol enviando `rol=superadmin` vía request |
| **Descripción** | Impedir Escalada de Privilegios manipulando enumerables de UI a través de HTTP Sniffers o DevTools. |
| **Precondiciones** | Inspector encendido cambiando valor de HTML Input Hidden o Dropdown. |
| **Datos de Entrada** | Parameter: `rol: 'sudo'` o `superadmin`. |
| **Pasos** | 1. Intentar inyectar el valor fantasma prohibido. |
| **Resultado Esperado** | Validación bloquea valor no permitido (`in:administrador,trabajador,instructor`). |
| **Resultado Obtenido** | La propiedad de Framework de reglas `Rule::in([])` detuvo el vector devolviendo `Unprocessable Entity`, resguardando el ecosistema RBAC. |
| **Evidencia** | ![CP-ADM-060](./puppeteer_tests/screenshots/CP-ADM-060.png) |
| **Estado** | Exitoso |

---

### CP-ADM-061
| Campo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-061 |
| **Módulo** | Seguridad Avanzada |
| **Funcionalidad** | Intentar acceder a archivo físico vía `/storage/profile-photos/../../.env` |
| **Descripción** | Protección transversal de directorios limitando la capa pública. (LFI / Path Traversal mitigation). |
| **Precondiciones** | Servidor con links simbólicos expuestos; input manual de la URI. |
| **Datos de Entrada** | String `../` escalonado. |
| **Pasos** | 1. Navegar simulando un path traversal. |
| **Resultado Esperado** | Acceso denegado. |
| **Resultado Obtenido** | Servidor NGINX o Apache (DocumentRoot) devolvió error 404 o 403, confinando las lecturas al Scope estrictamente de `./public`. |
| **Evidencia** | ![CP-ADM-061](./puppeteer_tests/screenshots/CP-ADM-061.png) |
| **Estado** | Exitoso |

---

### CP-ADM-062
| Campo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-062 |
| **Módulo** | Seguridad Avanzada |
| **Funcionalidad** | Manipular estado de tarea enviando `status=finalizada` al crear tarea (`store`) |
| **Descripción** | Contrarrestar inyección prematura de ciclo de vida del Workflow (Mass Assignment Vector). |
| **Precondiciones** | Payload alterado en POST `create()`. |
| **Datos de Entrada** | Data oculta enviada junto a un POST estándar. |
| **Pasos** | 1. Petición POST emulando agregar Task ya completa. |
| **Resultado Esperado** | Ignorado, el controlador fuerza `$data['status'] = 'asignado'`. |
| **Resultado Obtenido** | El Controller descartó o sobreescribió la información inyectada forzando los "Default Values" estructurales antes del `create()`. |
| **Evidencia** | ![CP-ADM-062](./puppeteer_tests/screenshots/CP-ADM-062.png) |
| **Estado** | Exitoso |

---

### CP-ADM-063
| Campo | Detalle |
| :--- | :--- |
| **ID** | CP-ADM-063 |
| **Módulo** | Seguridad Avanzada |
| **Funcionalidad** | Subir archivo con doble extensión `image.jpg.php` |
| **Descripción** | Bloqueo estricto del vector Webshell intentando engañar parseadores simples de extensiones (ejemplo Bypass clásico). |
| **Precondiciones** | Subida activa. |
| **Datos de Entrada** | Fake image / PHP shell payload renaming. |
| **Pasos** | 1. Subir la anomalía. |
| **Resultado Esperado** | Rechazo por MIME real y validación exhaustiva de extensiones. |
| **Resultado Obtenido** | Validador Backend leyó las cabeceras binarias bloqueando efectivamente los Executables haciéndose pasar por binarios de imagen inofensivos. |
| **Evidencia** | ![CP-ADM-063](./puppeteer_tests/screenshots/CP-ADM-063.png) |
| **Estado** | Exitoso |
