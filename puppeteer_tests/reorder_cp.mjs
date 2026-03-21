import fs from 'fs';

const filepath = 'c:\\laragon\\www\\SIGERD.1.0\\CP.md';
let content = fs.readFileSync(filepath, 'utf8');

const removedAdms = [48, 49, 50, 51, 64, 65, 66, 67, 68];

function getNewNumber(oldNum) {
    let offset = 0;
    for (const r of removedAdms) {
        if (oldNum > r) offset++;
    }
    return oldNum - offset;
}

function pad(num) {
    return num.toString().padStart(3, '0');
}

// 1. Process INDEX items
let lines = content.split(/\r?\n/);
let outLines = [];

for (let i = 0; i < lines.length; i++) {
    let line = lines[i];

    let indexMatch = line.match(/^- \[CP-ADM-(\d{3})\]\(#cp-adm-(\d{3})\)/);
    if (indexMatch) {
        let oldNum = parseInt(indexMatch[1], 10);
        if (removedAdms.includes(oldNum)) {
            continue; // Skip the line
        } else {
            let newNumStr = pad(getNewNumber(oldNum));
            // Keep the rest of the line but replace the old numbers
            line = line.replace(/CP-ADM-\d{3}/g, `CP-ADM-${newNumStr}`);
            line = line.replace(/#cp-adm-\d{3}/g, `#cp-adm-${newNumStr}`);
            outLines.push(line);
            continue;
        }
    }
    outLines.push(line);
}

content = outLines.join('\n');

// 2. Process BLOCKS
// Split text keeping "### CP-" using positive lookahead
let parts = content.split(/^(?=### CP-)/m);

let newParts = [];

for (let part of parts) {
    let blockMatch = part.match(/^### CP-ADM-(\d{3})/);
    if (blockMatch) {
        let oldNum = parseInt(blockMatch[1], 10);
        if (removedAdms.includes(oldNum)) {
            continue; // Drop the chunk
        } else {
            let newNumStr = pad(getNewNumber(oldNum));
            let oldNumStr = pad(oldNum);
            let re = new RegExp(`CP-ADM-${oldNumStr}`, 'g');
            part = part.replace(re, `CP-ADM-${newNumStr}`);
            newParts.push(part);
        }
    } else {
        newParts.push(part);
    }
}

content = newParts.join('');

fs.writeFileSync(filepath, content, 'utf8');
console.log('Finalizado la correcion profunda de CP.md');
