import sys

with open("c:/laragon/www/SIGERD.1.0/requisitos_funcionales.md", "r", encoding="utf-8") as f:
    text = f.read()

parts = text.split("## 2. Rol: Instructor")
if len(parts) >= 2:
    with open("c:/laragon/www/SIGERD.1.0/requisitos_funcionales.md", "w", encoding="utf-8") as fw:
        with open("c:/laragon/www/SIGERD.1.0/admin_block.md", "r", encoding="utf-8") as fb:
            admin_text = fb.read()
        fw.write(admin_text + "\n\n## 2. Rol: Instructor" + parts[1])
        print("Success: Replaced the Admin block!")
else:
    print("Error: Could not find '## 2. Rol: Instructor' separator in the file.")
