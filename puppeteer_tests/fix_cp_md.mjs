import fs from 'fs';
const filepath = 'c:\\laragon\\www\\SIGERD.1.0\\CP.md';
let content = fs.readFileSync(filepath, 'utf8');

const omittedCases = [
    // Configuración General
    'CP-ADM-048', 'CP-ADM-049', 'CP-ADM-050', 'CP-ADM-051',
    // Concurrencia y Consistencia de Datos (Carece de Optimistic Locking)
    'CP-ADM-064', 'CP-ADM-065', 'CP-ADM-066', 'CP-ADM-067', 'CP-ADM-068'
];

let modified = 0;

for (const id of omittedCases) {
    // Regex para encontrar el bloque del caso de prueba
    const blockRegex = new RegExp(`(### ${id}\\s+.*?\\| \\*\\*Estado\\*\\* \\| )(.*?)( \\|)`, 's');
    
    if (blockRegex.test(content)) {
        content = content.replace(blockRegex, `$1⚠️ Omitido (No implementado)$3`);
        modified++;
    }
    
    // Añadimos una nota en la descripción
    const descRegex = new RegExp(`(\\| \\*\\*ID\\*\\* \\| ${id}\\s+.*?\\| \\*\\*Descripción\\*\\* \\| )(.*?)( \\|)`, 's');
    if (descRegex.test(content)) {
        content = content.replace(descRegex, `$1[OMITIDO] $2$3`);
    }
}

fs.writeFileSync(filepath, content, 'utf8');
console.log(`Successfully updated ${modified} test cases in CP.md.`);
