import fs from 'fs';
import path from 'path';

// 1. Generate an exactly 2048 KB (2097152 bytes) valid JPEG file
// A minimal 1x1 JPEG:
const base64Jpeg = "/9j/4AAQSkZJRgABAQEASABIAAD/2wBDAP//////////////////////////////////////////////////////////////////////////////////////wgALCAABAAEBAREA/8QAFBABAAAAAAAAAAAAAAAAAAAAAP/aAAgBAQABPxA=";
const jpegBuffer = Buffer.from(base64Jpeg, 'base64');
const targetSize = 2048 * 1024; // 2MB exact

// Create a new buffer of exactly 2MB
const buffer2MB = Buffer.alloc(targetSize);
// Copy the real JPEG data to the beginning
jpegBuffer.copy(buffer2MB, 0);

fs.writeFileSync('exact_2mb.jpg', buffer2MB);
console.log('Created exact_2mb.jpg (Size:', buffer2MB.length, 'bytes)');

// 2. Generate a spoofed / malicious file renamed to .jpg
const maliciousContent = "MZ\x90\x00\x03\x00\x00\x00\x04\x00\x00\x00\xFF\xFF\x00\x00\xB8\x00\x00\x00\x00\x00\x00\x00@\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00";
const spoofedBuffer = Buffer.from("MZ spoofed executable content, pretend I am a virus payload that bypasses checks if extension is just checked.");
fs.writeFileSync('spoofed.jpg', spoofedBuffer);
console.log('Created spoofed.jpg (Fake Image)');
