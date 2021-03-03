<?php

session_start();
//conecto con la base de datos

// 0= casilla tapada 9= mina
//variables del juego
$row;
$colum;
$valorMinas=0;
$valueM=0;
$time = time();
$numeroMinas=0;
$casillasVistas=0;


    if(isset($_POST["value"])){
        $valor =intval($_POST["value"]);
        if($valor>20 || $valor<8){

            $_SESSION["error"]=$valor;
            header("Location:index.php");
        }else{
            $_SESSION["cantidad"]=$valor;
            $valorMinas=intval(($valor*$valor)*0.35);
            $valueM=$valorMinas;
            $_SESSION["cantidadM"]=$valorMinas;
            $_SESSION["win"]=intval(($_SESSION["cantidad"]*$_SESSION["cantidad"]))-$_SESSION["cantidadM"];
            echo $_SESSION["win"];
        }
    }
   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" media="screen" href="game.css" />
    <title>Buscaminas</title>
</head>
<body  >
    <div id="titleGame"><h1>Buscaminas</h1>
    <div class="boton">
    <button id="Buttons1" onclick="redit(event)">Nuevo Juego</button></div>
    </div>
    <div id="statics">
    <div id="headerStyle">
        <?php 
        if(!isset($_SESSION["contadorM"])){
            $_SESSION["contadorM"]= $_SESSION["cantidadM"];
        }else if (isset($_GET["resta"])&&$_GET["resta"]==1){
            $_SESSION["contadorM"]--;
        }else if(isset($_GET["resta"])&&$_GET["resta"]=='2'){
            
            $_SESSION["contadorM"]+=2;
        }

        echo '<h2> minas: '.$_SESSION["contadorM"].'</h2>';
        if(!isset($_SESSION["Casillas"])){
            $_SESSION["Casillas"]=$casillasVistas;
           
        }else{
            $casillasVistas=$_SESSION["Casillas"];
            
        }
       
        ?>
    
     <?php 
        $_SESSION["contador"]=$time;
        echo '<h2> tiempo: '.date("H:i:s",  $_SESSION["contador"]).'</h2>';
        ?>
    </div>
    </div>
    <div id="gameStart">
    <?php
    $contador=0; 
    if(!isset($_SESSION["matriz"])&&!isset($_SESSION["visible"])){
        

       $row= $_SESSION["cantidad"];
       $colum= $_SESSION["cantidad"];
       for($i=0; $i<$row; $i++){
           for($j=0; $j<$colum; $j++){
               $matriz[$i][$j]=0;
               $visible[$i][$j]=0;
           }
       }

       $_SESSION["status"]="start";
       $casillasVistas=0;
      

       for($k=0; $k<$_SESSION["cantidadM"]; $k++){
           $ranRow=rand(0,$row-1);
           $randColum=rand(0,$colum-1);
           if($matriz[$ranRow][$randColum]==0){
            $matriz[$ranRow][$randColum]=9;
           }else{
               $k--;
           }
       }

       for($i=0; $i<$row; $i++){
           for($j=0; $j<$colum; $j++){
               $conteo=0;
               if($matriz[$i][$j]==0){
                //valido direcciones 
                if($i>0){
                    if($matriz[$i-1][$j]==9){
                        $conteo++;
                    }
                }
                if($j>0){
                    if($matriz[$i][$j-1]==9){
                        $conteo++;
                    }
                }
                if($i<$row-1){
                    if($matriz[$i+1][$j]==9){
                        $conteo++;
                    }
                }
                if($j<$row-1){
                    if($matriz[$i][$j+1]==9){
                        $conteo++;
                    }
                }
                //diagonales
                if($i<$row-1&&$j>0){
                    if($matriz[$i+1][$j-1]==9){
                        $conteo++;
                    }
                }
                if($i<$row-1&&$j<$row-1){
                    if($matriz[$i+1][$j+1]==9){
                        $conteo++;
                    }
                }
                if($i>0&&$j<$row-1){
                    if($matriz[$i-1][$j+1]==9){
                        $conteo++;
                    }
                }
                if($i>0&&$j>0){
                    if($matriz[$i-1][$j-1]==9){
                        $conteo++;
                    }
                }

               }
               if($conteo!=0){
                $matriz[$i][$j]=$conteo;
               }
               if($conteo==0&& $matriz[$i][$j]!=9){
                $matriz[$i][$j]='x';
               }
           }
       }

       $_SESSION["matriz"]=$matriz;
       $_SESSION["visible"]=$visible;

    }else{
        $matriz=$_SESSION["matriz"];
        $visible=$_SESSION["visible"];
        //cambiar el estado si pierdo
       if(isset($_GET["finish"])&&$_GET["finish"]=='4'){
        $_SESSION["status"]="finish";
        // si gano
       }else if(isset($_GET["finish"])&&$_GET["finish"]=='5'){
        $_SESSION["status"]="win";
       }
       
        if($_SESSION["status"]=='start'){
            if(isset($_GET["valor"])&&isset($_GET["i"])&&isset($_GET["j"])){
                $f=intval($_GET["i"]);
                $c=intval($_GET["j"]);
                if(intval($_GET["valor"])==1){
                    if($visible[$f][$c]==0){
                        $visible[$f][$c]='m';
                    }else if($visible[$f][$c]=='m'){
                        $visible[$f][$c]=0;
                        header("Location:game.php?resta=2");
                    }
                }else{
                    if($visible[$f][$c]==0){
                       if($matriz[$f][$c]==9){
                        for($i=0; $i<$_SESSION["cantidad"]; $i++){
                            for($j=0; $j<$_SESSION["cantidad"]; $j++){
                               if($matriz[$i][$j]==9){
                                $visible[$i][$j]=9;
                               }
                            }
                        }
                        $_SESSION["status"]="finish";
                        header("location:game.php?finish=4");
                       }else{
                        $visible[$f][$c]=$matriz[$f][$c];
                        $casillasVistas++;
                       
                        if( intval($_SESSION["Casillas"])>=intval($_SESSION["win"])){
                            $_SESSION["status"]="win";
                            header("location:game.php?finish=5");
                      }else{
                          $f2=$f; $c2=$c;
                            if($f2>0){
                                if($matriz[$f2-1][$c2]!=9){
                                    $visible[$f2-1][$c2]=$matriz[$f2-1][$c2];
                                    $casillasVistas++;
                                }
                            }
                            if($f2<$_SESSION["cantidad"]-1){
                                if($matriz[$f2+1][$c2]!=9){
                                    $visible[$f2+1][$c2]=$matriz[$f2+1][$c2];
                                    $casillasVistas++;
                                }
                            }
                            if($c2>0){
                                if($matriz[$f2][$c2-1]!=9){
                                    $visible[$f2][$c2-1]=$matriz[$f2][$c2-1];
                                    $casillasVistas++;
                                }
                            }
                            if($c2<$_SESSION["cantidad"]-1){
                                if($matriz[$f2][$c2+1]!=9){
                                    $visible[$f2][$c2+1]=$matriz[$f2][$c2+1];
                                    $casillasVistas++;
                                }
                            }
                            if($c2<$_SESSION["cantidad"]-1&&$f2<$_SESSION["cantidad"]-1){
                                if($matriz[$f2+1][$c2+1]!=9){
                                    $visible[$f2+1][$c2+1]=$matriz[$f2+1][$c2+1];
                                    $casillasVistas++;
                                }
                            }
                            if($c2<$_SESSION["cantidad"]-1&&$f2>0){
                                if($matriz[$f2-1][$c2+1]!=9){
                                    $visible[$f2-1][$c2+1]=$matriz[$f2-1][$c2+1];
                                    $casillasVistas++;
                                }
                            }
                            if($c2>0&&$f2>0){
                                if($matriz[$f2-1][$c2-1]!=9){
                                    $visible[$f2-1][$c2-1]=$matriz[$f2-1][$c2-1];
                                    $casillasVistas++;
                                }
                            }
                            if($c2>0&&$f2<$_SESSION["cantidad"]-1){
                                if($matriz[$f2+1][$c2-1]!=9){
                                    $visible[$f2+1][$c2-1]=$matriz[$f2+1][$c2-1];
                                    $casillasVistas++;
                                }
                            }
                            $_SESSION["Casillas"]=$casillasVistas;
                        }
                       }
                    }
                }
               
            }
        }else if($_SESSION["status"]=='finish'){
            echo "perdiste";
            
        }else{
            echo "ganaste";
        }
        $_SESSION["matriz"]=$matriz;
        $_SESSION["visible"]=$visible;
       

    }

    
    ?>

    
    <table >
    <?php
    if($_SESSION["status"]=='start'){
        for($i=0; $i<$_SESSION["cantidad"]; $i++)
        {
            echo "<tr>";
            for($j=0; $j<$_SESSION["cantidad"]; $j++)
            {
                echo '<td><input type="submit" value="'.$visible[$i][$j].'" class="buton" onmousedown="presiono(event,'.$i.','.$j.')" ></input></td>';
            }
            echo"</tr>";
        }
    }else if ($_SESSION["status"]=='finish'){
        for($i=0; $i<$_SESSION["cantidad"]; $i++)
        {
            echo "<tr>";
            for($j=0; $j<$_SESSION["cantidad"]; $j++)
            {
                echo '<td><input type="submit" value="'.$visible[$i][$j].'" class="buton"  ></input></td>';
            }
            echo"</tr>";
        }
    }else{
        echo '<form action="user.php" method="POST">';
        echo '<input type="text" name="Nombre" placeholder="Nombre">';
        echo '<input type="text" name="Apellido"placeholder="Apellido">';
        echo '<input type="text" value="'.date("H:i:s",  $_SESSION["contador"]).'" name="Tiempo">';
        echo '<button type"submit">enviar </button >';
        echo '</form>';
    }
    ?>

    </table>
    <button class="Butons" onclick="start(event)">Reiniciar</button>
    <h2>Jugador con menos tiempo: <?php echo $_SESSION["usuario"]["Nombre"];?> tiempo:<?php echo $_SESSION["usuario"]["Tiempo"];?> </h2>
</div>
    
</body>
<script type="text/javascript">

document.addEventListener('contextmenu', function(e) {
  e.preventDefault();
});

function presiono(event,i,j){

    if (event.button==2)
    document.location.href="game.php?i="+i+"&j="+j+"&valor="+1+"&resta="+1;
	else if (event.button==1)
		alert("El botón del ratón pulsado fue el medio");
    else{
        document.location.href="game.php?i="+i+"&j="+j+"&valor="+2;
    }  
}

function start(event){
    document.location.href="juegonuevo.php";
}
function redit(event){
    document.location.href="newgame.php";
}



</script>
</html>