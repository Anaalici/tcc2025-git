<?php
require__DIR__.'/vendor/autololad.php';
use Kreait/Firebase/Factory;

if (isset($_POST['codigo'])) {
    $factory = (new Factory())-> withDatabaseUri ('<?--link firebase-->');
    $database = $factory->creatDatabase ();
    $novaPalavra = [
        'Codigo'=>$_POST['codigo'],
        'ingles' =>$_POST ['pingles'],
        'traducao' => $POST ['ptraducao']
    ];
    $database->getReference ('Termos/'.$_POST ['codigo']) ->set ($novaPalavra);
    $msg = 'Palavra adicionada com sucesso!';
}
?>