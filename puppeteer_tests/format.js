const fs = require('fs');
const data = JSON.parse(fs.readFileSync('puppeteer_tests/results.json', 'utf8')).casos.slice(-7);
let out = '';
data.forEach(r => {
    let state = r.estado.includes('Exitoso') ? '✅ Exitoso' : (r.estado.includes('Fallido') ? '❌ Fallido' : '⚠️ Error Técnico');
    out += `─────────────────────────────────────
CASO: ${r.id}
MÓDULO: ${r.modulo}
FUNCIONALIDAD: ${r.funcionalidad}
─────────────────────────────────────
BEFORE  → ${r.capturas.before}  ✓
DURING  → ${r.capturas.during}  ✓
AFTER   → ${r.capturas.after}   ✓
─────────────────────────────────────
RESULTADO ESPERADO: ${r.resultado_esperado}
RESULTADO OBTENIDO: ${r.resultado_obtenido}
ESTADO: ${state}
TIEMPO: ${r.tiempo_ms}ms
─────────────────────────────────────
\n`;
});
fs.writeFileSync('puppeteer_tests/report.txt', out);
