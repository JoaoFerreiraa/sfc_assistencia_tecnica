<?php
    setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    date_default_timezone_set('America/Sao_Paulo');

    $data = date('Y/m/d');
    // $data = explode("/", $data);

    $msgData = "Sorocaba, ".strftime('%d de %B de %Y', strtotime($data));

echo '
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .corpo{
            margin-left: 3vw;
        }
    </style>
</head>

<body>
    <div class="corpo">
        <p>'.$msgData.'</p>
    </div>
</body>

</html>';