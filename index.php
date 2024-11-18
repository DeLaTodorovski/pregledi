<?php

require 'functions.php';
require 'Database.php';
require 'header.php';
$config = require('config.php');
$db = new Database($config['database']);

//$posts = $db->query("select * from oceni")->fetchAll();



// dd($posts);

if(isset($_GET['broj']) && $_GET['broj'] != "" && $_GET['broj'] > 0 && $_GET['broj'] < 35 && $_GET['odd'] < 10 && isset($_GET['odd']) && $_GET['odd'] != "" && $_GET['odd'] > 0 && is_numeric($_GET['odd']) && is_numeric($_GET['broj'])) {
    echo "Преглед за ".$_GET['broj']." ученици <br>";
    $oddelenija = $db->query("select * from oddelenie WHERE id = ".$_GET['odd']."")->fetchAll();
    echo "
    <form method='POST' action=''>
	<table class='table'>
    <thead class='thead-primary'>
    <tr>
    <th>Бр.</th>
    <th>Име</th>
    <th>Презиме</th>
    <th>Пол</th>
    ";

    foreach ($oddelenija as $oddelenie){
        $results = array();
        //echo json_decode($oddelenie['predmeti']);
        $to_arr = explode(',', $oddelenie['predmeti']);
        $results = array_merge($results, $to_arr);

        foreach ($results as $result){
         //Излистај ги предметите според одделението
         $predmeti = $db->query("select * from predmeti WHERE id = ".$result."")->fetchAll();
            foreach ($predmeti as $predmet){
            echo "<th class='predmet'>".$predmet['predmet']."</th>";
            }

        }

    }

    echo "
    <th class='verticalTableHeader'>Оправдани </th>
    <th class='verticalTableHeader'>Неоправдани </th>
    </tr>
    </thead>
    <tbody>";
    $array_o = [];
    for ($i=0; $i < $_GET['broj']; $i++){

        $ime = '';
        $prezime = '';
        $pol = '';
        $maski = '';
        $zenski = '';
        $predmet_p  = '';
        $opravdani = 0;
        $neopravdani = 0;


        if(isset($_POST['ime'.($i+1)])){  $ime = $_POST['ime'.($i+1)]; }
        if(isset($_POST['prezime'.($i+1)])){  $prezime = $_POST['prezime'.($i+1)]; }
        if(isset($_POST['pol'.($i+1)])){  $pol = $_POST['pol'.($i+1)]; }

        echo "<tr><td>".($i+1)."</td>";
        echo "<td> <input name='ime".($i+1)."' type='text' value='$ime' placeholder='Име' required></td>";
        echo "<td> <input name='prezime".($i+1)."' type='text' placeholder='Презиме' value='$prezime' required></td>";
            if($pol == 1){
                $maski = 'selected';
                $zenski = '';
            }else 
            if($pol == 2){
                $maski = '';
                $zenski = 'selected';
            }
        echo '<td> <select name="pol'.($i+1).'" id="pol" required>
        <option value="1" '.$maski.'>машки</option>
        <option value="2" '.$zenski.'>женски</option>
        </select>
        </td>';
        //Излистај ги одделениејата
  
            foreach ($oddelenija as $oddelenie){
                $results = array();
                //echo json_decode($oddelenie['predmeti']);
                $to_arr = explode(',', $oddelenie['predmeti']);
                $results = array_merge($results, $to_arr);
                $tarray = [];

                foreach ($results as $result){
                 //Излистај ги предметите според одделението
                 $predmeti = $db->query("select * from predmeti WHERE id = ".$result."")->fetchAll();
                 $count = $db->query("select * from predmeti WHERE id = ".$result."")->fetchColumn(); 


                    foreach ($predmeti as $predmet){
                        
                        $predmetid = $predmet['short'].($i+1);
                        if(isset($_POST[$predmetid])){  
                            $predmet_p = $_POST[$predmetid];
                        }
                        echo "<td><input type='number'  min='1' max='5' style='idth: 5em' name='".$predmetid."' value='";
                        if(isset($_POST[$predmetid])){  
                            echo $_POST[$predmetid]; 
                        }else{
                            echo 0;
                        }
                        echo "' required></td>";
                       
                       
                    }
                    
                    $tarray[$predmetid] = (int)$predmet_p;
                    
                }

                //var_dump($tarray);

                


                   // echo $prosek;
                
                  
                 
                //echo $count."<br>";


                // var_dump($tarray);
                if(isset($_POST['opravdani'.($i+1)])){  $opravdani = $_POST['opravdani'.($i+1)]; }
                if(isset($_POST['neopravdani'.($i+1)])){  $neopravdani = $_POST['neopravdani'.($i+1)]; }
                echo "<td><input type='number' min='1' max='500'  style='idth: 5em' name='opravdani".($i+1)."' value='$opravdani' required></td>";
                echo "<td><input type='number' min='1' max='500'  style='idth: 5em' name='neopravdani".($i+1)."' value='$neopravdani' required></td>";
                echo "<tr><td colspan='".($count+6)."'>Ученикот $ime $prezime постигна ".uspeh($tarray)." успех со просек ".prosek($tarray)."! ";

                if ($opravdani != '' && $neopravdani != ''){
                    $vkupno = (int)$opravdani+(int)$neopravdani;
                }else{
                    $vkupno = 0;
                }
                
                echo "Ученикот има вкупно $vkupno изостаноци од кои $opravdani се оправдани и $neopravdani неоправдани!</td></tr>";
                //$bigarray[] = array_push($tarray);
            
            }
            
            foreach($tarray as $key=>$value){ 
                $array_o[$key] = $value;
            }

        echo "</tr>";
    }

    //var_dump($array_o);

    
    
    echo "</tbody></table>
    <button type='submit'>Генерирај</button>
    </form>
    ";
    echo "Просек на одделението е ".prosek($array_o)." со постигнат ".uspeh($array_o)." успех!<br><br>";




} else {
    ?>

    <form method="get" action="./pregled">
    <label for="broj">Број на ученици:</label>
    <input name="broj" type="number" value=0 min='1' max='9' style='idth: 5em'>
    <label for="odd">Избери одделение:</label>
    <select name="odd" id="odd">
        <option value="1">прво</option>
        <option value="2">второ</option>
        <option value="3">трето</option>
        <option value="4">четврто</option>
        <option value="5">петто</option>
        <option value="6">шесто</option>
        <option value="7">седмо</option>
        <option value="8">осмо</option>
        <option value="9">деветто</option>
    </select>
    <button type="submit">Продолжи</button>
    </form>
    
    <?php
}

// $ime = $_POST['ime'];
// $prezime = $_POST['prezime'];
// $pol = $_POST['pol'];
// $pol = $_POST['opravdani'];
// $pol = $_POST['neopravdani'];
// $predmeti = $_POST['neopravdani'];
// $oceni = $_POST['oceni'];

require 'footer.php';