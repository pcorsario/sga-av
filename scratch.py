from docx import Document

doc = Document('Requermientos Inicial/MATERIAS_INICIAL.docx')

current_subject = None
count = 0

for para in doc.paragraphs:
    text = para.text.strip()
    if not text: continue
    
    # Check if all caps -> probably a subject
    if text.isupper():
        if current_subject:
            print(f"{current_subject}: {count} destrezas")
        current_subject = text
        count = 0
    else:
        count += 1

if current_subject:
    print(f"{current_subject}: {count} destrezas")

