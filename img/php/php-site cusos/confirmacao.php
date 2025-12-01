<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>


    <?php 
        $nome = $_GET['nome'];
        $endereco = $_GET['endereco'];
        $idade = $_GET['idade'];
        $telefone = $_GET['telefone'];
        $nomedopai = $_GET['nomedopai'];
        $nomedamae = $_GET['nomedamae'];
        $cidade = $_GET['cidade'];
        $datadenascimento = $_GET['datadenascimento'];
        $sexo = $_GET['sexo'];

        echo("nome: $nome <br>
        endereco: $endereco <br>
        idade: $idade <br>
        telefone: $telefone <br>
        nomedopai: $nomedopai <br>
        nomedamae: $nomedamae <br>
        cidade: $cidade <br>
        datadenascimento: $datadenascimento <br>
        sexo: $sexo <br>"
        )
    ?>
</body>