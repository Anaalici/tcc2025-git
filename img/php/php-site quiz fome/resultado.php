<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="style.css">
  

</head>
  <?php
  
  $opt1 = $_GET ['pergunta1'];
  $opt2 = $_GET ['pergunta2'];
  $opt3 = $_GET ['pergunta3'];
  $opt4 = $_GET ['pergunta4'];
  $opt5 = $_GET ['pergunta5'];
  $opt6 = $_GET ['pergunta6'];

  $respostas = 0;


   if ($opt1 == "opt4")
   {
     $respostas++;
   }
   else {
     $respostas = $respostas;
   }

   if($opt2 == "opt3")
   {
     $respostas++;
   }
   else {
     $respostas = $respostas;
   }

   if($opt3 == "opt1")
   {
     $respostas++;
   }
   else  {
     $respostas = $respostas;
   }

   if ($opt4 == "opt2")
   {
     $respostas++;
   }
   else 
   { 
     $respostas = $respostas; 
   }

   if ($opt5 == "opt1")
   {
     $respostas++;
   }
   else { 
     $respostas = $respostas;
 }

 if ($opt6 == "opt3")
 {
   $respostas++;
 }
 else {
   $respostas = $respostas;
 }


?>
<h1 class="h2">
<?php
 echo "Você acertou:".$respostas;  
 ?>
 </h1>
 <h1 class="h3">
 <?php

 echo "Hoje em dia, temos conhecimento de que infelizmente a fome é algo que vem sendo muito ocorrdo porém pouco comentado,  <br> sendo assim, é de extrema importância que possamos tornar algo visível e claro, fazer de tudo para que isso seja menos ocorrido, ou seja,  <br>disperdiçando menos comida, apoiando pequenos agricultures, tendo melhor acesso ao mercado, entre outros.";
?>
</h1>
</body>
</html>