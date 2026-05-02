<?php

$content = shell_exec('unzip -p "Requermientos Inicial/MATERIAS_INICIAL.docx" word/document.xml | sed -e "s/<[^>]*>//g"');
echo $content;
