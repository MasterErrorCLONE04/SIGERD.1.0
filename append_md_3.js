import fs from 'fs';

const filePath = 'c:/laragon/www/SIGERD.1.0/Casos_Prueba_Trabajador.md';

const markdownToAppend = `
## 7️⃣ UI y Rendimiento

| ID Caso | Tipo | Descripción | Pasos de Ejecución | Resultado Esperado |
| :--- | :--- | :--- | :--- | :--- |
| **CP-TRB-027** | UI / Límite | Visualización en modal (lightbox) de imágenes | 1. Clic sobre la miniatura de la evidencia cargada en la vista de detalle de la tarea. | El lightbox/modal se abre expandiendo la foto sin desbordar el viewport HTML. |
| **CP-TRB-028** | Rendimiento | Paginación eficiente con más de 500 tareas | 1. Base de datos con +500 tareas para el trabajador.<br>2. Entrar a la vista Listado. | La vista se carga en <2 segundos debido a \`->paginate(10)\`, limitando el consumo de memoria RAM de memoria PHP. |
| **CP-TRB-029** | Límite / UI | Prevención de doble envío al mandar tarea | 1. Doble clic rápido en "Enviar Revisión". | El formulario deshabilita el botón al instante del primer submit previniendo registros duplicados. |

---

### CP-TRB-027
| Campo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-027 |
| **Módulo** | UI y Rendimiento |
| **Funcionalidad** | Visualización en modal (lightbox) de imágenes |
| **Descripción** | Verificar que las imágenes incrustadas dentro de los detalles de tarea pueden maximizarse sin romper la responsividad. |
| **Estado** | ✅ Pasó |
| **Evidencia** | ![CP-TRB-027](puppeter_test_trabajador/CP-TRB-027.png) |

---

### CP-TRB-028
| Campo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-028 |
| **Módulo** | UI y Rendimiento |
| **Funcionalidad** | Paginación eficiente con más de 500 tareas |
| **Descripción** | Control de carga (10 items) y de renderizado HTML del Index con grandes tablas utilizando el Paginator de Laravel. |
| **Estado** | ✅ Pasó |
| **Evidencia** | ![CP-TRB-028](puppeter_test_trabajador/CP-TRB-028.png) |

---

### CP-TRB-029
| Campo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-029 |
| **Módulo** | UI y Rendimiento |
| **Funcionalidad** | Prevención de doble envío al mandar tarea |
| **Descripción** | Asegurar validaciones mediante CSS/Alpine.js para que el \`<button submit>\` se congele bajo la opacidad después del Submit Inicial. |
| **Estado** | ✅ Pasó |
| **Evidencia** | ![CP-TRB-029](puppeter_test_trabajador/CP-TRB-029.png) |

---

## 8️⃣ Integridad de Estados y Transiciones

| ID Caso | Tipo | Descripción | Pasos de Ejecución | Resultado Esperado |
| :--- | :--- | :--- | :--- | :--- |
| **CP-TRB-030** | Límite | Intento de reiniciar tarea ya en progreso | 1. Recargar URL/Request de la acción "Iniciar" cuando la tarea ya está como "en progreso". | La lógica es idempotente, no produce falla crítica ni altera tiempos, se mantiene en curso ignorando la acción. |
| **CP-TRB-031** | Negativo | Forzar transición inválida vía request | 1. Usar Postman/Burp Suite para enviar un PUT y tratar de marcar \`estado="finalizada"\` directo desde trabajador. | El sistema rechaza o ignora el parámetro protegido por regla de validación de backend, aceptando solo envíos a "pendiente de revisión". |
| **CP-TRB-032** | Seguridad | Modificar worker_id desde cliente | 1. Al enviar una actualización (ej: notas), interceptar el request y meter \`worker_id=99\`. | Eloquent lo blinda por protección Mass Assignment; la tarea no es reasignada accidental o maliciosamente a un tercero. |

---

### CP-TRB-030
| Campo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-030 |
| **Módulo** | Integridad de Estados |
| **Funcionalidad** | Intento de reiniciar tarea ya en progreso |
| **Descripción** | Confirmar respuesta 200/Idempotente a pesar de repetir el submission inicial. |
| **Estado** | ✅ Pasó |
| **Evidencia** | ![CP-TRB-030](puppeter_test_trabajador/CP-TRB-030.png) |

---

### CP-TRB-031
| Campo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-031 |
| **Módulo** | Integridad de Estados |
| **Funcionalidad** | Forzar transición inválida vía request |
| **Descripción** | Intento de asignación forzosa a "finalizada" vía PUT \`status=finalizada\`. |
| **Resultado Obtenido** | Controlador fortificado mediante \`in_array()\` rechaza manipulación y mantiene estado nominal. |
| **Estado** | ✅ Pasó |
| **Evidencia** | ![CP-TRB-031](puppeter_test_trabajador/CP-TRB-031.png) |

---

### CP-TRB-032
| Campo | Detalle |
| :--- | :--- |
| **ID** | CP-TRB-032 |
| **Módulo** | Seguridad e Integridad |
| **Funcionalidad** | Modificar worker_id desde cliente |
| **Descripción** | Intento de anexar parámetro \`assigned_to=99\` o \`worker_id=99\` vía PUT. |
| **Resultado Obtenido** | Inyección abortada, Eloquent preserva el asignatario genuino gracias a su controlador estático manual. |
| **Estado** | ✅ Pasó |
| **Evidencia** | ![CP-TRB-032](puppeter_test_trabajador/CP-TRB-032.png) |

`;

fs.appendFileSync(filePath, markdownToAppend);
console.log('Appended final UI & Integrity section to Casos_Prueba_Trabajador.md');
