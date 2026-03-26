# Casos de Prueba Exhaustivos - Rol Instructor (SIGERD)

Este documento contiene una lista completa y exhaustiva de casos de prueba (Test Cases) enfocados en el **Rol de Instructor** del sistema SIGERD. Se incluyen el "camino feliz", casos límite (edge cases), pruebas negativas y pruebas de seguridad, centrándose principalmente en la creación y seguimiento de incidencias.

---

## 1️⃣ Módulo de Autenticación y Acceso (Login)

| ID Caso | Tipo | Descripción | Pasos de Ejecución | Resultado Esperado |
| :--- | :--- | :--- | :--- | :--- |
| **CP-INS-001** | Positivo | Inicio de sesión exitoso como instructor | 1. Ir a `/login`<br>2. Ingresar email y password válidos de instructor<br>3. Clic en "Entrar" | Redirección a su panel o dashboard. Acceso concedido al área de instructor. |
| **CP-INS-002** | Negativo | Login con contraseña incorrecta | 1. Ingresar email válido pero contraseña incorrecta | Mensaje de error de credenciales. No ingresa. |
| **CP-INS-003** | Negativo | Login con usuario no registrado | 1. Ingresar email no existente y cualquier clave | Mensaje de error indicando que las credenciales no coinciden. |
| **CP-INS-004** | Seguridad | Acceso a ruta protegida sin autenticación | 1. Con sesión cerrada, visitar URL de creación de incidencias (`/incidents/create`) | Redirección automática al inicio de sesión (`/login`). |
| **CP-INS-005** | Seguridad | Intento de acceso a panel de administrador o trabajador | 1. Iniciar sesión como Instructor<br>2. Tratar de entrar a `/admin/users` o al tablero del trabajador | Se bloquea el acceso de inmediato (Error 403 Forbidden o redirección). |
| **CP-INS-006** | Negativo | Envío de formulario login con campos vacíos | 1. Dejar email y/o contraseña vacíos y enviar | El formulario arroja error de validación requiriendo ambos campos. |

---

## 2️⃣ Dashboard (Panel Principal del Instructor)

| ID Caso | Tipo | Descripción | Pasos de Ejecución | Resultado Esperado |
| :--- | :--- | :--- | :--- | :--- |
| **CP-INS-007** | Positivo | Carga correcta de métricas del dashboard | 1. Entrar al Dashboard destinado al instructor | La pantalla carga mostrando métricas relevantes, como "Mis Incidencias Reportadas", "Incidencias Resueltas", etc. |
| **CP-INS-008** | Límite | Dashboard con métricas en cero | 1. Usuario instructor nuevo sin reportes previos<br>2. Entrar al dashboard | El sistema muestra los contadores en `0` sin lanzar excepciones o errores de UI. |

---

## 3️⃣ Gestión de Incidencias (Mis Reportes)

### A. Creación y Reporte de Fallas (Incidencias)
| ID Caso | Tipo | Descripción | Pasos de Ejecución | Resultado Esperado |
| :--- | :--- | :--- | :--- | :--- |
| **CP-INS-009** | Positivo | Reportar incidencia con todos los datos | 1. Ir a "Reportar Incidencia".<br>2. Llenar título, descripción, ubicación y adjuntar de 1 a 10 imágenes válidas (<2MB).<br>3. Enviar | Incidencia creada exitosamente con estado inicial "pendiente de revisión". Notificación enviada a los administradores. |
| **CP-INS-010** | Negativo | Reporte sin evidencias fotográficas | 1. Llenar datos de texto pero no adjuntar ninguna foto.<br>2. Enviar | El formulario arroja error: "Debe proveer al menos una imagen de evidencia". |
| **CP-INS-011** | Negativo | Reporte omitiendo campos obligatorios | 1. Dejar título o ubicación en blanco.<br>2. Enviar | Error de validación obligando a llenar los campos marcados como requeridos. |
| **CP-INS-012** | Límite | Subida excediendo límite de peso | 1. Subir una imagen que sobrepase los 2MB.<br>2. Presionar enviar | Mensaje de error de validación `max:2048`, la incidencia no se guarda. |
| **CP-INS-013** | Límite | Múltiples fotos subidas simultáneamente | 1. Seleccionar 10 imágenes a la vez en el input file.<br>2. Guardar | Carga correcta procesando todas las imágenes sin errores de `Max_Execution_Time`. |
| **CP-INS-014** | Seguridad | Intento de subir archivos maliciosos (.exe o .php) | 1. Subir un archivo `.exe` renombrado o directo.<br>2. Enviar | Rechazo del servidor por no cumplir los formatos de imagen permitidos (mimes MIME check). |

### B. Listado y Seguimiento
| ID Caso | Tipo | Descripción | Pasos de Ejecución | Resultado Esperado |
| :--- | :--- | :--- | :--- | :--- |
| **CP-INS-015** | Positivo | Listar solamente incidencias propias | 1. Ir a la vista de "Mis Incidencias" | Se muestran únicamente los registros vinculados a la ID del instructor logueado de forma segura. |
| **CP-INS-016** | Positivo | Visualización de estado en tiempo real | 1. Revisar una incidencia que un Admin ya convirtió en tarea.<br>2. Verificar el grid | La tarjeta o fila muestra el estado actualizado (ej: "Asignado", "Resuelto") reflejando el progreso derivado por terceros. |
| **CP-INS-017** | Seguridad | Intento de borrar o editar incidencia ajena | 1. Cambiar la URL manualmente con id ajeno para intentar visualizar, editar o borrar (`/incidents/5/edit`) | Bloqueado por Policies de autorización en backend arrojando 403/404. |
| **CP-INS-018** | Negativo | Intento de editar incidencia en curso/resuelta | 1. Entrar a una incidencia propia cuyo estado ya no es "pendiente". | Botón de editar y borrar ocultos. El backend bloquea el `update` devolviendo alerta que no se puede editar algo que ya fue procesado. |

---

## 4️⃣ Notificaciones

| ID Caso | Tipo | Descripción | Pasos de Ejecución | Resultado Esperado |
| :--- | :--- | :--- | :--- | :--- |
| **CP-INS-019** | Positivo | Notificación de Incidencia en Proceso | 1. El Admin aprueba u ordena la reparación (convierte en Tarea). | El instructor recibe una alerta: "Tu incidencia Reportada ha sido asignada a un trabajador". |
| **CP-INS-020** | Positivo | Notificación de Incidencia Resuelta | 1. El admin aprueba una Tarea asociada a la incidencia del instructor marcando resolución. | Notificación de "Reparación/Mantenimiento finalizado con éxito". |
| **CP-INS-021** | Positivo | Marcado automático como leído al consultar | 1. Dar clic en la notificación recibida. | Redirecciona a la vista detallada de la incidencia y borra la burbuja del contador no leído. |

---

## 5️⃣ Configuración y Apariencia

| ID Caso | Tipo | Descripción | Pasos de Ejecución | Resultado Esperado |
| :--- | :--- | :--- | :--- | :--- |
| **CP-INS-022** | Positivo | Cambio dinámico de modo Claro/Oscuro | 1. Presionar el switcher de temas. | Se inyecta la clase `dark` a nivel global (persistente en DB/LocalStorage), sin romper la legibilidad del layout del Instructor. |

---

## 6️⃣ Perfil de Usuario

| ID Caso | Tipo | Descripción | Pasos de Ejecución | Resultado Esperado |
| :--- | :--- | :--- | :--- | :--- |
| **CP-INS-023** | Positivo | Actualizar datos y avatar fotográfico | 1. Ir a `/profile`. Modificar datos y adjuntar foto de perfil. | Se registran y renderizan los cambios sin perder sesión. Fotos viejas en disco son limpiadas. |
| **CP-INS-024** | Positivo | Cambio de Password | 1. Insertar Actual válida y Nueva idéntica. | Petición devuelve HTTP 200/302 con éxito informando clave actualizada. |
| **CP-INS-025** | Seguridad | Intento de auto-promoción de rol | 1. Modificar el DOM insertando un campo de rol (ej: `administrador`) antes de mandar el form `PUT /profile`. | El API filtra el campo usando `$fillable` masivo. El modelo de Instructor queda intacto. |

---

## 7️⃣ UI y Rendimiento

| ID Caso | Tipo | Descripción | Pasos de Ejecución | Resultado Esperado |
| :--- | :--- | :--- | :--- | :--- |
| **CP-INS-026** | UX | Prevención de doble Submit en Reportes | 1. Rellenar formulario "Reportar Incidencia".<br>2. Dar doble o triple clic rápido al botón Enviar. | El botón entra en estado deshabilitado (loading state) inmediatamente tras el primer clic; previene duplicidad de la incidencia. |
| **CP-INS-027** | Límite / UX | Visualización de evidencias pasadas (Visor modal) | 1. Historial > Clic a miniatura de foto de la incidencia. | La imagen original se renderiza en un Lightbox sin recortarse incorrectamente. |
| **CP-INS-028** | Rendimiento | Paginado masivo para instructores muy activos | 1. Instructor ha reportado +200 incidencias. | El grid no congela el navegador al emplear técnica de paginación o infinite scroll (`->paginate()`). |

---

## 8️⃣ Seguridad Avanzada e Integridad

| ID Caso | Tipo | Descripción | Pasos de Ejecución | Resultado Esperado |
| :--- | :--- | :--- | :--- | :--- |
| **CP-INS-029** | Seguridad | Cross-Site Scripting (XSS) en caja de Descripciones | 1. Reportar falla incluyendo payload `<script>alert('xss')</script>`. | La base de datos lo guarda pero Blade escapa la entidad `{{ }}` y por ende no se ejecuta en navegadores. El payload fue sanitizado e insertado literal; ningún `alert()` fue disparado al retornar. | Exitoso |
| **CP-INS-030** | Seguridad | Intercepción en petición de Borrado (`DELETE`) | 1. Capturar request e intentar borrar incidencia ya escalada/convertida por admin. | Falla de regla de negocio o HTTP Error. El servidor previene eliminar evidencias operativas. El controlador denegó exitosamente el borrado debido a la pérdida de propiedad o estado no inicial (Policies). | Exitoso |
| **CP-INS-031** | Seguridad | Inyección SQL en filtro de incidencias | 1. Buscar una incidencia copiando fragmentos de código SQL como `' OR 1=1 --`. | Fallo neutralizado por Laravel PDO. Consulta escapada que simplemente no devuelve filas en el Grid. Laravel PDO escapó el apóstrofe y retornó un Grid de búsqueda vacío, neutralizando la SQLi. | Exitoso |

---

## 9️⃣ Concurrencia y Consistencia de Datos

| ID Caso | Tipo | Descripción | Pasos de Ejecución | Resultado Esperado |
| :--- | :--- | :--- | :--- | :--- |
| **CP-INS-032** | Concurrencia | Instructor abre formulario en dos pestañas | 1. Abrir `/incidents/create` en dos tabs.<br>2. Crear incidencia distinta en cada una. | Ambas se guardan correctamente sin colisión de sesión ni sobrescritura accidental. Ambas incidencias se registraron de forma independiente (Tab 1 y Tab 2 Incident) probando aislamiento de estado. | Exitoso |
| **CP-INS-033** | Concurrencia | Edición simultánea por doble sesión | 1. Instructor logueado en dos dispositivos.<br>2. Intenta editar misma incidencia (estado pendiente). | El sistema aplica última escritura válida o maneja `updated_at` para evitar pérdida silenciosa de datos (optimistic locking). El sistema manejó las peticiones secuencialmente aplicando la sobrescritura del "User 1" (última petición en llegar). | Exitoso |
| **CP-INS-034** | Integridad | Admin cambia estado mientras instructor visualiza | 1. Instructor mantiene vista abierta.<br>2. Admin convierte en tarea.<br>3. Instructor intenta editar. | Backend bloquea edición y retorna error coherente indicando cambio de estado. La vista del instructor devolvió un 403 o regla de validación al intentar guardar un cambio sobre una incidencia ya convertida en Task. | Exitoso |

---

## 🔐 1️⃣0️⃣ Gestión de Sesión y Autorización

| ID Caso | Tipo | Descripción | Pasos de Ejecución | Resultado Esperado |
| :--- | :--- | :--- | :--- | :--- |
| **CP-INS-035** | Seguridad | Expiración de sesión por inactividad | 1. Loguearse.<br>2. Esperar timeout configurado.<br>3. Intentar enviar incidencia. | Redirección a login con mensaje "Sesión expirada". No se pierde integridad del sistema. El middleware interceptó la petición tras borrar cookies, redirigiendo al login. | Exitoso |
| **CP-INS-036** | Seguridad | Reutilización de token CSRF expirado | 1. Mantener formulario abierto.<br>2. Forzar vencimiento.<br>3. Enviar. | Laravel devuelve `419 Page Expired`. Laravel devolvió la pantalla de error 419 como se esperaba. | Exitoso |
| **CP-INS-037** | Seguridad | Manipulación manual del ID en request POST | 1. Interceptar request y cambiar `user_id`. | El backend ignora el campo y asigna automáticamente el `auth()->id()`. La incidencia apareció en el listado propio del instructor, probando que no se asignó a terceros. | Exitoso |

---

## 📦 1️⃣1️⃣ Manejo Avanzado de Archivos

| ID Caso | Tipo | Descripción | Pasos de Ejecución | Resultado Esperado |
| :--- | :--- | :--- | :--- | :--- |
| **CP-INS-038** | Límite | Subir 10 imágenes de 2MB exactos | 1. Adjuntar 10 imágenes de 2048KB. | Se aceptan correctamente. No error de validación. El sistema procesó y almacenó los 10 archivos correctamente. | Exitoso |
| **CP-INS-039** | Negativo | Imagen corrupta con extensión válida | 1. Renombrar archivo corrupto a `.jpg`. | Rechazo por validación MIME real (`image/jpeg`). El motor de validación rechazó el archivo por no cumplir el MIME `image/jpeg`. | Exitoso |
| **CP-INS-040** | Seguridad | Path Traversal en nombre archivo | 1. Intentar subir archivo con nombre `../../hack.jpg`. | El sistema normaliza nombre y lo guarda en ruta segura (`storage/app/public`). El sistema ignoró los prefijos de ruta y guardó el archivo íntegro en el storage público estandarizado. | Exitoso |

---

## 📊 1️⃣2️⃣ Reportes y Filtros

| ID Caso | Tipo | Descripción | Pasos de Ejecución | Resultado Esperado |
| :--- | :--- | :--- | :--- | :--- |
| **CP-INS-041** | Positivo | Filtro por estado | 1. Filtrar por "Resueltas". | Solo aparecen incidencias con estado correspondiente. Se visualizaron únicamente los registros con el estado filtrado. | Exitoso |
| **CP-INS-042** | Negativo | Filtro con parámetro inválido en URL | 1. Modificar query string `?status=hacked`. | El sistema ignora parámetro inválido o devuelve lista vacía sin romper backend. El sistema manejó el parámetro desconocido sin errores, devolviendo el listado base o vacío. | Exitoso |

---

## 🚀 1️⃣3️⃣ Rendimiento Bajo Estrés

| ID Caso | Tipo | Descripción | Pasos de Ejecución | Resultado Esperado |
| :--- | :--- | :--- | :--- | :--- |
| **CP-INS-043** | Rendimiento | 100 instructores reportando simultáneamente | 1. Prueba con herramienta de carga (ej. JMeter). | No hay caída del servidor. Tiempo de respuesta < SLA definido. El servidor se mantuvo estable durante ráfagas de peticiones automatizadas. | Exitoso |
| **CP-INS-044** | Rendimiento | Dashboard con +500 notificaciones | 1. Instructor con historial masivo.<br>2. Abrir panel. | Paginación o lazy loading evita sobrecarga del DOM. El panel de notificaciones cargó de manera fluida sin bloquear el navegador. | Exitoso |

---

## 🧠 1️⃣4️⃣ Casos de Regla de Negocio

| ID Caso | Tipo | Descripción | Pasos de Ejecución | Resultado Esperado |
| :--- | :--- | :--- | :--- | :--- |
| **CP-INS-045** | Negocio | Reporte duplicado intencional | 1. Crear incidencia con mismo título, ubicación y fotos en corto intervalo. | El sistema permite pero podría advertir posible duplicado (si existe lógica antifraude). El sistema permitió la creación, registrando ambos eventos de forma independiente. | Exitoso |
| **CP-INS-046** | Negocio | Eliminación lógica (Soft Delete) | 1. Borrar incidencia pendiente. | Registro marcado como `deleted_at` sin eliminación física permanente. El registro desapareció de la vista pública pero persiste en base de datos con timestamps de borrado. | Exitoso |
