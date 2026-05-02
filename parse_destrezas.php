<?php

$xml = shell_exec('unzip -p "Requermientos Inicial/MATERIAS_INICIAL.docx" word/document.xml | sed -e "s/<[^>]*>//g"');

// Split by sentences or specific markers?
// Actually, it's easier to just use the text.
echo $xml;
