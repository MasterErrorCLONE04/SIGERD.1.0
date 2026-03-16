# Guía de Sustentación Técnica: Sistema SIGERD

Este documento contiene 20 posibles preguntas técnicas que un jurado podría realizar durante la sustentación del software SIGERD.

---

## Ronda 1: Estructura, Seguridad y Vistas

### 1. Rutas y Seguridad (Middlewares)
**Pregunta:** ¿Cómo garantizas a nivel de código que un "Trabajador" no pueda ingresar escribiendo en la URL `/admin/dashboard`? ¿Qué mecanismo exacto de Laravel estás utilizando para proteger esto?

**Respuesta Ideal:**
> "Utilizamos el sistema de **Middlewares** de Laravel, específicamente uno personalizado llamado `RoleMiddleware` (`RoleMiddleware.php`). En el archivo `web.php`, agrupé las rutas de cada actor bajo métodos como `Route::middleware(['auth', 'role:administrador'])`. Este middleware funciona como un filtro: toma al usuario autenticado (`Auth::user()`) y verifica si la columna `role` en la base de datos coincide con el rol exigido por la ruta. Si un Trabajador intenta entrar al panel de Admin, el middleware detecta que su rol es 'trabajador', no autoriza la entrada y corta la ejecución devolviendo un error 403 (Acceso Denegado)."

### 2. Vistas (Blade y Alpine.js)
**Pregunta:** Usted ya está usando el motor de plantillas Blade que renderiza Laravel desde el servidor. ¿Por qué fue necesario incluir Alpine.js en su proyecto? ¿Qué problema específico le resuelve Alpine.js que Blade por sí solo no podía solucionar fácilmente?

**Respuesta Ideal:**
> "Blade es excelente para estructurar el HTML e inyectar datos desde la base de datos, pero opera del lado del **servidor**. Si yo dependiera solo de Blade para hacer que un modal aparezca, requeriría hacer una petición al servidor y recargar toda la página. 
> 
> Usamos **Alpine.js** porque es un framework del lado del **cliente**. Nos permite agregar interactividad ligera (como cambiar de estados, mostrar alertas toast, desplegar el menú de usuario o controlar el modal de "Convertir a Tarea" con `x-data` o `@click`) **sin recargar la página**. Esto mejora drásticamente la experiencia del usuario (UX) haciéndola mucho más fluida, sin tener que importar librerías pesadas como jQuery o React."

---

## Ronda 2: Modelos, Base de Datos y Lógica (Eloquent)

### 3. Modelos y Relaciones (Eloquent)
**Pregunta:** En su base de datos existe una relación entre los incidentes que reporta el instructor, las tareas que realizan los trabajadores y los usuarios en general. ¿Cómo están relacionados los modelos `Incident`, `Task` y `User` y qué relaciones de Eloquent utilizó?

**Respuesta Ideal:**
> "La arquitectura de la base de datos utiliza relaciones de tipo uno a muchos. 
> - **Instructor a Incidente:** Un usuario tiene muchos incidentes (`hasMany`), y un incidente pertenece a un instructor (`belongsTo` ligado a la llave foránea `reported_by`).
> - **Incidente a Tarea:** Un incidente puede requerir varias tareas o acciones físicas para resolverse (`hasMany`), y cada tarea pertenece a un reporte de incidente específico (`belongsTo` en `incident_id`).
> - **Usuario a Tarea (Doble Relación):** La tabla de tareas se relaciona dos veces con los usuarios: a través de `created_by` (el administrador que genera la tarea) y `assigned_to` (el trabajador que ejecuta la tarea). Ambas son relaciones `belongsTo` hacia el modelo `User`."

### 4. Controladores y Flujo de Negocio
**Pregunta:** En el controlador `IncidentController` o `TaskController`, ¿cuál es el paso a paso lógico que se ejecuta cuando un Administrador le da clic a "Convertir a Tarea"? ¿Qué sucede con el estado del incidente original?

**Respuesta Ideal:**
> "Cuando el administrador envía el formulario mediante `POST`, el primer paso en el método del controlador es **validar** fuertemente los datos entrantes (ej: que la fecha límite no sea en el pasado, que el ID del trabajador exista, que las prioridades sean válidas). 
> 
> Si la validación (`$request->validate()`) es exitosa, se crea un nuevo registro en la tabla `tasks` (Tarea) insertando estos datos y guardando la relación con el `incident_id`. Finalmente, el mismo controlador actualiza (`update`) la columna `status` del incidente original, pasándolo del estado 'pendiente de revisión' al estado **'asignado'**. Así, el sistema sabe que el reporte ya está siendo atendido."

### 5. Seguridad: Carga de Archivos (Uploads)
**Pregunta:** En su aplicación los usuarios pueden subir imágenes al servidor como evidencia. ¿Qué medidas específicas de validación implementó en sus Controladores para defender a su servidor de ataques donde el usuario suba un virus oculto bajo una extensión `.jpg`?

**Respuesta Ideal:**
> "La aplicación implementa un estricto arreglo de validación en la carga de archivos: `'reference_images.*' => ['image', 'mimes:jpeg,png,jpg,gif', 'max:10240']`.
> 
> Esta validación nos asegura protección en 3 capas:
> 1. La regla `image`: Obliga a Laravel a inspeccionar el contenido interno del archivo (su cabecera MIME) y no solo la extensión. Si se renombra un archivo `.exe` o `.php` a `.jpg`, Laravel detectará que internamente no es una imagen y lo bloqueará.
> 2. La regla `mimes:`: Establece explícitamente una lista blanca limitando a que únicamente se admitan archivos visuales inofensivos (jpeg, png, gif).
> 3. La regla `max:`: Limita cada archivo a 10MB para prevenir escenarios donde un usuario malintencionado intente inundar el servidor subiendo archivos gigantescos."

---

## Ronda 3: Roles, Flujos y Casos de Uso (15 Nuevas Preguntas)

**6. ¿Podría explicar el ciclo de vida narrativo (flujo) de un Trabajador desde que se le asigna una tarea hasta que ésta se da por Completada?**
> "El ciclo de vida del Trabajador en SIGERD es muy operativo: Él ingresa a su Dashboard y ve las nuevas tareas en estado 'Asignado'. Al iniciar el trabajo físico (arreglar una lámpara, etc.), él entra al detalle de la tarea y cambia el estado a **'En Progreso'**. Al finalizar la reparación, requiere regresar al software para llenar un comentario técnico y, **obligatoriamente, subir fotos** como evidencia final del trabajo terminado. Al enviar este formulario, la tarea cambia a estado **'Realizada'**, finalizando la participación del trabajador y dejándola a la espera de que el Administrador revise las fotos y la pase a estado 'Finalizada' cerrado el reporte de incidencia ligado."

**7. Si quisiera escalar el proyecto y agregar un nuevo rol llamado "Supervisor" que solo pueda ver reportes pero no editarlos, ¿qué cambios a nivel de código y base de datos tendría que realizar?**
> "Inicialmente, iría a la migración de la tabla `users` y en la validación del modelo añadiría 'supervisor' al enumerado (`ENUM`) de roles. Segundo, en el archivo `web.php` configuraría un nuevo grupo de rutas con un prefijo `/supervisor` y le aplicaría un middleware custom como `Route::middleware(['auth', 'role:supervisor'])`. Por último, crearía un controlador y unas vistas (Dashboard) separadas, configurando Eloquent para que este usuario solo utilice consultas de tipo `->get()` o `->find()`, pero nunca operaciones de `create`, `update` o `delete`."

**8. He notado consultas a la base de datos en su controlador, de este tipo: `$incident = Incident::with(['reportedBy', 'tasks'])->findOrFail($id);`. ¿Qué significa el método `with()` y por qué no hizo un `join` tradicional de SQL?**
> "El método `with()` es una técnica de **Eager Loading** (Carga ansiosa) en el ORM de Eloquent. Básicamente, le dice al sistema que no solo extraiga el incidente, sino que también de manera proactiva traiga los datos del usuario creador y sus tareas antes de enviárselo a la vista. 
> Esto soluciona el clásico problema **N+1** que hace lenta la aplicación, evitando ejecutar una nueva consulta SQL cada vez que en el `foreach` de Blade intentamos imprimir el nombre de usuario (`$incident->reportedBy->name`)."

**9. Sobre notificaciones en SIGERD: ¿Están utilizando notificaciones en tiempo real con WebSockets (Pusher) o son un modelo tradicional de Base de datos?**
> "Actualmente, SIGERD utiliza un modelo tradicional basado en Polling sobre base de datos para la generación de notificaciones. En la lógica de negocio (usualmente controladores) creamos un nuevo registro en la tabla `notifications` vinculado al `user_id` receptor. En el frontend, implementamos un pequeño script en Alpine.js o nativo que, mediante llamadas AJAX (fetch API) a la ruta `notifications.index`, consulta las alertas no leídas cada `X` segundos sin recargar la página."

**10. Ustedes generan reportes en PDF del rendimiento de los trabajadores. ¿Qué técnica o librería implementó para lograr esta conversión en Laravel?**
> "Implementamos la librería de terceros `barryvdh/laravel-dompdf` que es un binding o adaptador sobre `dompdf` clásico. La lógica es: en el Controlador capturamos o infiltramos la colección de tareas finalizadas mediante Eloquent, preparamos un arreglo con estadística matemática, y luego pasamos todas esas variables hacia una vista Blade específica (carente de Navbar y Sidebar). El facade `Pdf::loadView()` procesa esa vista y devuelve un archivo descargable con todo el diseño CSS compilado en PDF."

**11. Hablemos de contraseñas. ¿Cómo se asegura en SIGERD que las credenciales de los usuarios no sean robadas fácilmente de la base de datos?**
> "Laravel ofrece un excelente grado de seguridad por defecto. Todas las contraseñas en la tabla `users` de SIGERD son "hasheadas" utilizando el algoritmo criptográfico moderno **Bcrypt** o Argón2i (por defecto al usar el Trait o método `Hash::make()`). Nunca almacenamos plantext. Incluso si la base de datos es expuesta, las contraseñas no se pueden desencriptar a la inversa (ir de Hash a Texto Plano) de forma determinista."

**12. Al usar Git y Github para su repositorio, la base de datos y su archivo `.env` nunca son compartidos por temas de seguridad. Si el jurado instalara su proyecto en Laragon desde cero, ¿cómo podría "levantar" la estructura de la base de datos rápidamente sin hacerlo manualmente en PhpMyAdmin?**
> "Laravel cuenta con un esquema de versionado de bases de datos llamado **Migraciones (`database/migrations`)**. Si clonan el proyecto, mediante consola primero crearían el archivo `.env` basándose en `.env.example`, y luego ejecutando `php artisan migrate`, Laravel construirá automáticamente todas las tablas, columnas, relaciones y tipos de datos requeridos en cuestión de segundos."

**13. Siguiendo en ese escenario: si levantan las migraciones, la base de datos estará vacía. ¿Cómo solucionarían en código crear un usuario "Administrador" inicial para poder entrar al software tras la primera instalación?**
> "Usaríamos **Seeders** y **Factories** de Laravel. Específicamente, en `DatabaseSeeder.php` programamos la creación de un modelo `User` fijo usando `User::create([...])` con rol 'administrador' y las credenciales iniciales por defecto. Tan solo tendrían que correr el comando `php artisan migrate:fresh --seed` para la estructura y el dato quemado simultáneamente."

**14. Acerca del patrón MVC (Modelo-Vista-Controlador). ¿Donde reside la "lógica de negocio o inteligencia" real de la funcionalidad de cambiar estados y enviar correos de notificaciones?**
> "Todo lo pesado que implica tomar decisiones y actualizar en base de datos está encapsulado en el nivel del **Controlador**. Por ejemplo, el `TaskController`. El **Modelo** (`Task.php`) solo se encarga de definir los campos llenables (fillables) y las relaciones estructurales, la **Vista** se limita solo a mostrar esos datos sin hacer cálculos pesados. Esta separación nos permite en el controlador llamar eventos o dispatchar Jobs tras validar todo satisfactoriamente."

**15. ¿Qué significa o qué es el `$fillable` de los Modelos (ej: en `User.php` o `Task.php`) y para qué protege esta propiedad?**
> "La propiedad protegida `$fillable` en los modelos sirve para indicarle a Laravel exactamente qué campos de la tabla se pueden asignar masivamente en un array (por ejemplo haciendo `Task::create($request->all())`).
> Esta es una barrera crucial contra la vulnerabilidad conocida como **Asignación Masiva** (*Mass Assignment Vulnerability*). Si protegemos con $fillable no importa que un atacante inyecte un input `<input name="role" value="admin">` falseando el form: Laravel ignorará la instrucción al no estar definida explícitamente y nos protege de cambios forzados de rol o IDs ajenas."

**16. Explíquenos cómo funciona el sistema de Enrutamiento o Routing de SIGERD para el manejo de las acciones CRUD cotidianas.**
> "En lugar de escribir cuatro, cinco o siete rutas independientes por cada entidad (una para `index`, otra para `create`, otra para `store`), utilizamos las cláusulas **`Route::resource('/tasks', TaskController::class)`**.  
> El sistema asume inteligentemente las 7 rutas RESTful de operaciones CRUD bajo el enfoque estandarizado y mapea directamente estos URIs hacia sus respectivos métodos clásicos del controlador (index -> /tasks, store -> POST /tasks, show -> /tasks/{id}, update -> PUT /tasks/{id}, etc)."

**17. Si su software de incidencias empieza a manejar miles y miles de reportes anuales, la vista principal que lista los incidentes se haría lenta de cargar. ¿Cómo han atenuado este potencial problema en sus vistas de listas?**
> "Hemos implementado la técnica de **Paginación** mediante Eloquent. En las llamadas al controlador (generalmente en los métodos `index`), en vez de usar `Incident::all()`, procesamos con  `Incident::paginate(10);`. Posteriormente en Blade (apoyados en frameworks CSS como Tailwind), dibujamos una barra de saltos con `{{ $incidents->links() }}` enviando a renderizar al servidor en lotes exactos optimizando la memoria RAM sobre nuestra aplicación y el motor MySQL."

**18. En caso de una excepción o error crítico del programa (por ejemplo, el servidor MySQL de Laragon se cae o falla una validación que no previeron) ¿Se le cae la vista o muestra un pantallazo de códigos a sus usuarios finales administradores o instructores?**
> "Laravel por sí integra un capturador estricto (`ExceptionHandler.php` y en las versiones recientes configurado sobre Bootstraps de app). Si el proyecto opera en producción (`APP_ENV=production` y `APP_DEBUG=false` en el entorno `.env`), un error crítico arrojará una discreta pantalla estática de estado HTTP (500 Server Error) informando la eventualidad técnica sin exponer a extraños rutas sensibles, queries, variables privadas ni la trazabilidad de la IP del servidor. Solo nosotros vía `storage/logs/laravel.log` veríamos la traza técnica de los stack frames."

**19. ¿Utilizaron la técnica de "Soft Deletes" para los incidentes y tareas eliminadas? ¿Por qué es bueno o malo borrar para siempre el registro físicamente?**
> *(Respuesta dependiendo de tu proyecto)* 
> "Por la naturaleza crítica del sistema de gestión de mantenimiento, la información estadística pasada es valiosa. En general, en sistemas empresariales se evita hacer un `DELETE` duro de MySQL. En Laravel es común implementar el trait `SoftDeletes` en el modelo y migrar una columna `deleted_at`. Eso oculta a todo nivel el registro como si lo borramos ante los ojos del usuario instructor, pero nos garantiza históricamente preservar el rastro del trabajo por motivos de reportaría y auditoría. Sin embargo, en SIGERD actualmente usamos...(borrado definitivo físico / Softdeletes) según la demanda de los requerimientos".

**20. Si ustedes son tres ingenieros/desarrolladores... ¿Cuáles fueron las estrategias de colaboración para unir todo este código (Blade, Controladores MVC de Laravel y Alpinejs)?**
> "Nuestra estrategia técnica fue utilizar **Arquitectura de Entornos y Git**.
> Todo operó sobre repositorios remotos. Uno creaba una nueva versión paralela, una rama (`Branch`), donde diseñaba las interfaces en Blade en `resources/views`, o actualizaba código bajo `app/Controllers`. Realizamos los respectivos *commits* y solicitamos los *Merges* hacia la rama `Main`. Cuando había conflictos de código en un mismo archivo `TaskController`, el sistema lo indicaba por Diff o Pull Requests para unificar e incorporar lógicamente sin reescribir por accidente el avance del otro desarrollador."
