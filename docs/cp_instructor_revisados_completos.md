# Casos de Prueba – Módulo Instructor (SIGERD) - Revisados

Se han revisado los casos de prueba para el módulo de instructor, corrigiendo los mal planteados y actualizando las rutas y nombres de acciones para que coincidan con la interfaz de usuario actual (que utiliza ahora un formulario modal en la vista de lista en lugar de una vista separada ( `/incidents/create` ) para la creación de reportes).

## 1. Autenticación y Acceso (Login)
| ID | Nombre | Precondición | Datos de Entrada | Pasos | Resultado Esperado |
|----|--------|-------------|-----------------|-------|--------------------|
| CP-INS-001 | Inicio de sesión exitoso como instructor | Usuario instructor existe en BD con credenciales válidas. | Email: `instructor1@sigerd.com` / Password: `password` | 1. Ir a `/login`<br>2. Ingresar credenciales válidas<br>3. Clic en "Iniciar Sesión" | Redirección al panel o dashboard. Acceso concedido al área de instructor. |
| CP-INS-002 | Login con contraseña incorrecta | El usuario instructor existe en el sistema. | Email: `instructor1@sigerd.com` / Password: `wrongpassword` | 1. Ir a `/login`<br>2. Ingresar email válido y contraseña incorrecta<br>3. Clic en "Iniciar Sesión" | Mensaje de error: *"These credentials do not match our records."* No ingresa. |
| CP-INS-003 | Login con usuario no registrado | El email utilizado no está registrado en el sistema. | Email: `noexiste@sigerd.com` / Password: `password` | 1. Ir a `/login`<br>2. Ingresar email no existente<br>3. Clic en "Iniciar Sesión" | Mensaje de error indicando que las credenciales no coinciden. |
| CP-INS-004 | Acceso a ruta protegida sin autenticación *(Seguridad)* | El usuario no tiene sesión iniciada. | URL directa: `/instructor/incidents` *(Corregido)* | 1. Con sesión cerrada, visitar `/instructor/incidents` | Redirección automática a `/login`. |
| CP-INS-005 | Intento de acceso a panel de administrador o trabajador *(Seguridad)* | Instructor con sesión activa. | URL directa: `/admin/users` | 1. Iniciar sesión como Instructor<br>2. Tratar de entrar a `/admin/users` o al tablero del trabajador | Acceso bloqueado (Error 403 Forbidden o redirección). |
| CP-INS-006 | Envío de formulario login con campos vacíos | Ninguna. | Ambos campos en blanco. | 1. Dejar email y/o contraseña vacíos<br>2. Enviar el formulario de login | El formulario arroja error de validación requiriendo ambos campos. |

---

## 2. Dashboard (Panel Principal del Instructor)
| ID | Nombre | Precondición | Datos de Entrada | Pasos | Resultado Esperado |
|----|--------|-------------|-----------------|-------|--------------------|
| CP-INS-007 | Carga correcta de métricas del dashboard | Instructor con sesión activa. | Acceso a la ruta principal del panel. | 1. Entrar al Dashboard del instructor | La pantalla carga mostrando métricas relevantes. |
| CP-INS-008 | Dashboard con métricas en cero *(Límite)* | Usuario instructor nuevo sin reportes previos en BD. | Acceso al panel con instructor sin actividad. | 1. Autenticarse con instructor recién creado<br>2. Entrar al dashboard | Los contadores se muestran en **0** sin excepciones ni errores de UI. |

---

## 3. Gestión de Incidencias – Mis Reportes
| ID | Nombre | Precondición | Datos de Entrada | Pasos | Resultado Esperado |
|----|--------|-------------|-----------------|-------|--------------------|
| CP-INS-009 | Reportar incidencia con todos los datos | Archivos válidos < 2 MB preparados, usuario autenticado. | Título, Descripción, Ubicación y foto `.png`. | 1. Ingresar a `/instructor/incidents`<br>2. Clic en "Reportar Nueva Falla" para abrir modal *(Corregido)*<br>3. Llenar los campos y adjuntar imagen<br>4. Enviar | Incidencia creada exitosamente con estado inicial **"pendiente de revisión"**. |
| CP-INS-010 | Reporte sin evidencias fotográficas *(Negativo)* | Se elimina el atributo HTML `required` para probar validación backend. | Formulario completo excepto el campo de imagen. | 1. Llenar los textos sin adjuntar fotos<br>2. Enviar el formulario | Error del backend indicando que se requiere al menos una imagen (Validación sobre `initial_evidence_images`). |
| CP-INS-011 | Reporte omitiendo campos obligatorios *(Negativo)* | Se elimina el atributo HTML `required`. | Formulario sin el campo Título. | 1. Dejar el título en blanco<br>2. Adjuntar imagen y descripción<br>3. Enviar | Error de validación obligando a completar el campo título. |
| CP-INS-012 | Subida excediendo límite de peso *(Límite)* | Archivo `.png` con tamaño > 2048 KB (≈ 3 MB). | Archivo mayor a 2048 KB. | 1. Subir la imagen pesada<br>2. Enviar el formulario | Mensaje de error (por regla `max:2048` que existe en el controlador) impidiendo guardar en BD. |
| CP-INS-013 | Múltiples fotos subidas simultáneamente *(Límite)* | Conjunto de hasta 10 imágenes `.png` válidas. | Selección múltiple de archivos. | 1. Seleccionar varias imágenes (el input soporta múltiple seleción de fábrica)<br>2. Enviar formulario | Carga correcta de todas las imágenes válidas procesadas en bucle dentro del controlador. |
| CP-INS-014 | Intento de subir archivos maliciosos *(Seguridad)* | Archivo de prueba `malicious.php`. Se elimina la restricción client-side. | Archivo `.php` cargado tras modificar el HTML. | 1. Modificar el HTML para permitir cualquier tipo de archivo<br>2. Subir `malicious.php`<br>3. Enviar formulario | Rechazo del archivo por validación MIME o reglas explícitas del backend (solo se permiten en código las extensiones: `jpeg`, `jpg`, `png` y `gif`). |

---

## 4. Gestión de Incidencias – Listado y Seguimiento
| ID | Nombre | Precondición | Datos de Entrada | Pasos | Resultado Esperado |
|----|--------|-------------|-----------------|-------|--------------------|
| CP-INS-015 | Listar solamente incidencias propias | BD con incidencias de múltiples usuarios. | Instructor accediendo a `/instructor/incidents`. | 1. Ingresar a la vista "Mis Reportes de Fallas" *(Corregido)* | Se muestran **únicamente** los registros asociados al ID del instructor autenticado. |
| CP-INS-016 | Visualización de estado actualizado | Incidencia del instructor procesada por Admin/Trabajador. | Acceso al listado de incidencias del instructor. | 1. Acceder al módulo "Mis Reportes de Fallas".<br>2. Ubicar la incidencia procesada. | La fila o tarjeta muestra el estado actualizado (ej. "Asignado", "En Progreso", "Resuelto"). |
| CP-INS-017 | Intento de visualizar incidencia ajena (IDOR) | Existencia de incidencias pertenecientes a otros usuarios. | URL manipulada: `/instructor/incidents/99999` | 1. Iniciar sesión como Instructor.<br>2. Modificar el ID en la URL para intentar visualizar un incidente de otro usuario. | Bloqueo o Error (404/403) ya que la consulta tiene scope a `Auth::id()`. IDOR prevenido. |
| CP-INS-018 | Verificación exclusión de rutas edición (API) | La aplicación cuenta con resource elements pero están excluidos `edit/update/destroy`. | Método PUT/DELETE HTTP. | 1. Utilizar un cliente o inspeccionar red para enviar un request HTTP PUT o DELETE a una incidencia. | El servidor responde con error HTTP 405 Method Not Allowed ya que la ruta ha sido eliminada. |

---

## 5. Notificaciones
| ID | Nombre | Precondición | Datos de Entrada | Pasos | Resultado Esperado |
|----|--------|-------------|-----------------|-------|--------------------|
| CP-INS-019 | Alerta de Incidencia Convertida en Tarea | Administrador convierte incidencia en tarea. | Instructor consulta vista general o campana. | 1. Admin convierte incidencia.<br>2. Instructor visualiza notificaciones. | Se genera notificación con el mensaje "Incidente Convertido a Tarea" asociada al instructor. |
| CP-INS-020 | Alerta de Incidencia Resuelta | Administrador aprueba como finalizada la tarea originada. | Instructor consulta vista general o campana. | 1. Admin cierra tarea como finalizada (Review).<br>2. Instructor visualiza notificaciones. | Se genera notificación "Incidencia Resuelta" con link a detalles visualizando estados y reportes. |
| CP-INS-021 | Marcado automático como leído al consultar | Existe al menos una notificación en estado unread. | Clic sobre un elemento del drop-down de notificaciones. | 1. Hacer clic en la notificación generada (campanita). | Acorde a la UI, redirige a la vista o AJAX API marca como leído quitando badge de alerta visual. |

---

## 6. Configuración y Perfil de Usuario
| ID | Nombre | Precondición | Datos de Entrada | Pasos | Resultado Esperado |
|----|--------|-------------|-----------------|-------|--------------------|
| CP-INS-022 | Cambio dinámico de modo Claro/Oscuro | Instructor con sesión activa. | Toggle de tema Alpine/Tailwind. | 1. Presionar el botón switch de cambio de tema. | La clase `dark` es agregada o removida a nivel global del DOM fluidamente. |
| CP-INS-023 | Actualizar datos y avatar fotográfico | Instructor autenticado en configuración general. | Formulario con nombre y archivo `.png` o `.jpg`. | 1. Acceder a `/profile`.<br>2. Subir imagen hacia `profile_photo` imputeada.<br>3. Guardar. | Laravel vincula correctamente el archivo al storage público reemplazando el avatar base sin afectarle la sesión. |
| CP-INS-024 | Cambio de contraseña segura | Instructor sabe contraseña actual. | `password` actual y validaciones coincidentes. | 1. Acceder a configuración.<br>2. Ingresar antigua contraseña y enviar. | El controlador ProfileController autentica y registra la actualización validando seguridad de Hashes. |
| CP-INS-025 | Intento manual de auto-promoción de rol | Se conocen las DevTools. | `input name="role" value="admin"`. | 1. Forzar un append al form HTTP para escalar a administrador.<br>2. Enviar POST/PUT. | El controlador rechaza parámetros fuera del `$fillable` array protegiendo el Mass Assignment de BD satisfactoriamente. |

---

## 7. UI, Rendimiento y Seguridad Básica
| ID | Nombre | Precondición | Datos de Entrada | Pasos | Resultado Esperado |
|----|--------|-------------|-----------------|-------|--------------------|
| CP-INS-026 | Prevención de doble envío en reportes | Formulario en "Reportar Nueva Falla". | Clics rápidos al botón Submit. | 1. Disparar múltiples peticiones de guardado con el mouse aceleradamente en UI. | Previene inserciones múltiples redundantes mediante bloqueo nativo del submit o AlpineJS disables. |
| CP-INS-027 | Visualización de evidencias en visor modal | Incidente cuenta con "initial_evidence". | Clic a div container `onclick()`. | 1. Entrar al detalle.<br>2. Seleccionar miniatura del listado de evidencias en el componente de vista. | La función `openImageModal()` intercepta el clic, amplificando el source en ventana oscura completa z-index. |
| CP-INS-028 | Paginado masivo para volumen de reportes | Instructor histórico de la plataforma con +50 quejas. | Frontend requiriendo tabla vaciada. | 1. Ingresar mediante Menú a Mis Reportes históricas. | Controller `paginate(10)` interrumpe sobrecarga del GET dividiendo elementos lógicos eficientemente. |
| CP-INS-029 | Prevención de XSS en descripciones | Formulario activo para texto y descripción detallada. | Entrada: `<script>alert('XSS')</script>`. | 1. Ingresar tag HTML peligroso directo al reporte.<br>2. Cargar vista detalles. | La interpolación de Laravel Blade bloquea y muestra un escape html text format inofensivo. |
| CP-INS-030 | Protección borrado (DELETE) HTTP REST | Existía en antiguas versiones. | Método Forzado `DELETE` hacia `incident/x`. | 1. Construir un request a la dirección de eliminar del instructor. | Al estar protegidas y reducidas rutas fuente (`only index, store, show`), responde `HTTP Method Not Allowed`. |

---

## 8. Seguridad Avanzada y Casos Extremos
| ID | Nombre | Precondición | Datos de Entrada | Pasos | Resultado Esperado |
|----|--------|-------------|-----------------|-------|--------------------|
| CP-INS-031 | Mitigación de Inyección SQL en filtros | Vista de listado con filtro de búsqueda activo. | Cadena maliciosa: `' OR 1=1 --` | 1. Insertar cadena en el filtro de búsqueda.<br>2. Ejecutar consulta.<br>3. Revisar resultados en el grid. | Laravel PDO utiliza binding parametrizado; la consulta es escapada y bloquea inyecciones sin devolver toda la base de datos. |
| CP-INS-032 | Creación simultánea desde múltiples pestañas | Instructor autenticado con dos pestañas abiertas en Reportar Falla. | Tipos de Fallas distintas en cada Tab. | 1. Llenar Tab 1.<br>2. Llenar Tab 2.<br>3. Enviar ambas una tras otra. | Ambas incidencias se almacenan correctamente bajo el mismo perfil sin corrupción de variables de estado de la sesión. |
| CP-INS-033 | Intento de edición simultánea *(Deprecado)* | Instructor autenticado desde 2 equipos. | Modificación manual. | 1. Intentar acceder a ruta de modificación forzadamente desde Dispositivo A y B simultáneo. | El sistema rechaza las conexiones HTTP PUT con 405 Method Not Allowed, ya que los instructores no pueden editar en esta versión. |
| CP-INS-034 | Intento de alteración de estado post-Admin *(Deprecado)* | Admin convierte incidencia original a Tarea. | Envío modificado POST intentando forzar un Update. | 1. Administrador finaliza la falla.<br>2. Instructor intenta mandar paquete HTTP modificador falseado. | Backend arroja 405 debido a la remoción de endpoints. La integridad de estado en el backend se mantiene intacta. |
| CP-INS-035 | Expiración de sesión por inactividad | Instructor autenticado con formulario abierto. | Eliminación cookie `laravel_session`. | 1. Borrar cookie desde DevTools.<br>2. Intentar enviar el formulario de reporte.<br>3. Observar respuesta. | Middleware detecta sesión inválida, genera error HTTP 419 (Page Expired) o redirige al login. |
| CP-INS-036 | Reutilización o manipulación de token CSRF | Formulario abierto con token CSRF generado. | Valor `_token` modificado. | 1. Alterar el valor del input oculto `_token`.<br>2. Enviar formulario. | Respuesta HTTP 419 indicando que el token es inválido o ha expirado. |
| CP-INS-037 | Manipulación manual de user_id en request | Instructor autenticado en el DOM del reporte. | Campo inyectado `user_id = 999`. | 1. Insertar input oculto `user_id=999`.<br>2. Enviar incidencia. | El controlador ignora el request inyectado, forzando `reported_by` con el auth()->id() real. |
| CP-INS-038 | Carga simultánea límite de 10 imágenes permitidas | El formulario usa validación de arreglo e iteración for `count()`. | 10 fotos adjuntas correctas. | 1. Subir paquete masivo desde File Explorer.<br>2. Enviar Reporte. | Las imágenes se iteran fluidamente por el controlador, guardándose exitosamente en storage y JSON array en BD sin timeout. |
| CP-INS-039 | Validación MIME ante archivo corrupto/camuflado | Archivo de texto renombrado a `.jpg` mágicamente. | Falso `.jpg`. | 1. Intentar subir falso JPG.<br>2. Submit al controlador. | Fallo durante validación local del servidor bloqueando archivo que no procesa correctamente al ser movido. |
| CP-INS-040 | Mitigación de Path Traversal en nombre upload | Se inserta archivo con nombre dinámico `../../hack.png`. | Nombre peligroso. | 1. Modificar payload multi-part alterando filename enviado.<br>2. Verificar almacenamiento. | Laravel descarta nombres originales peligrosos; el Controller forza el renombramiento UUID+time(`uniqid().'_'.time()`) como barrera nativa. |
| CP-INS-041 | Filtrado correcto por estado de incidencia | Instructor con listado de estatus mixtos. | Selección `status="resuelta"`. | 1. Ejecutar el parámetro URL con el filtro correspondiente.<br>2. Visualizar UI. | Se despliegan exclusivamente las fallas cuyo label coincida con "resuelta". |
| CP-INS-042 | Criterios basura en query parameters de Filtro | Listado Instructor expuesto a variables GET GET. | `?status=script123`. | 1. Inyectar basura en query bar de URL.<br>2. Retornar vista. | Query scope del Where en Eloquent ignora strings falsos procediendo a retornar visualización de lista vacía en paz. |
| CP-INS-043 | Estabilidad ante Peticiones Concurrentes | Pruebas de Carga JMeter listas. | Más de 50 requests/seg simultáneos. | 1. Ejecutar carga contra la UI de listado instructor.<br>2. Medir Responses. | El endpoint GET Responde satisfactoriamente. |
| CP-INS-044 | Paginado funcional bajo volumen histórico extremo | Instructor que reporte >500 fallas existiendo en BD. | Login general para instructor masivo. | 1. Ingresar como instructor masivo.<br>2. Verificar Dashboard. | Componentes paginadores seccionan en conjuntos manejables previniendo el colapso del DOM visual. |
| CP-INS-045 | Inserción Múltiple o Duplicada Intencional | Existen reportes listos y no hay lock antifraude explícito en el diseño. | Creaciones idénticas. | 1. Crear incidencia X.<br>2. Re-Cargar misma Info al instante. | Conforme al Controlador, se emiten dos filas únicas individuales en BD con diferentes timestamps (Registro Independiente garantizado). |
| CP-INS-046 | Intento de Eliminación Lógica (SoftDelete) *(Deprecado)* | Instructor buscando forzar el borrado de sus fallos. | Solicitudes HTTP de destrucción. | 1. Enviar HTTP DELETE.<br>2. Evaluar BD. | Acciones bloqueadas. La app no contiene el endpoint SoftDelete para instructores. Retorna 404/405. |
