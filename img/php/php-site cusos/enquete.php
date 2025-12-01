<!DOCTYPE html>
<html lang="ept-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmação Enquet</title>
</head>
<body>
    <?php 
        $animal= $_GET['animal'];
        $cor= $_GET['cor'];
        $idade = $_GET['idade'];
        $cores = $_GET['cores'];
        $sobremesa = $_GET['sobremesa'];
        $instagram = $_GET['instagram'];
    

        echo("animal: $animal <br>
        cor: $cor <br>
        idade: $idade <br>
        cores: $cores <br>
        sobremesa: $sobremesa<br>
        instagram: $instagram <br>"
        )
    ?>
</body>