<?php 
$dau = $_POST['dau'];
  if(empty($dau)) 
  {
    echo("Вы не выбрали ни одного здания.");
  } 
  else
  {
    $N = count($dau);

    echo("Вы выбрали $N здание(й): ");
    for($i=0; $i < $N; $i++)
    {
      echo($dau[$i] . " ");
    }
  }


echo $_POST['dau'];
?>