<?php

require 'functions.php';
require 'Database.php';
require 'header.php';
$config = require('config.php');
$db = new Database($config['database']);

//$posts = $db->query("select * from oceni")->fetchAll();



// dd($posts);

if(isset($_GET['odd'])  && $_GET['odd'] < 10 && $_GET['odd'] != "" && $_GET['odd'] > 0 && is_numeric($_GET['odd']) && isset($_GET['bukva']) && $_GET['bukva'] != "") {
    
    $bukva = $_GET['bukva'];
    $ucenici = $db->query("SELECT * FROM `ucenici` WHERE `oddelenie` = ".$_GET['odd']." AND `bukva` = '$bukva'")->fetchAll();
    $brucenici = $db->count("SELECT count(*) FROM ucenici WHERE `oddelenie` = ? AND `bukva` = ? ", [$_GET['odd'], $bukva]);
    $bruceniciSoSlaba = $db->count("SELECT count(*) FROM ucenici WHERE `oddelenie` = ? AND `bukva` = ? AND `slabi` > ? ", [$_GET['odd'], $bukva, 0]);
    $bruceniciSoSlabi = $db->count("SELECT count(*) FROM ucenici WHERE `oddelenie` = ? AND `bukva` = ? AND `slabi` > ? ", [$_GET['odd'], $bukva, 1]);
    $bruceniMaski = $db->count("SELECT count(*) FROM ucenici WHERE `oddelenie` = ? AND `bukva` = ? AND `pol` = ? ", [$_GET['odd'], $bukva, 1]);
    $bruceniZenski = $db->count("SELECT count(*) FROM ucenici WHERE `oddelenie` = ? AND `bukva` = ? AND `pol` = ? ", [$_GET['odd'], $bukva, 2]);
    $brojOdlicni = $db->count("SELECT count(*) FROM ucenici WHERE `oddelenie` = ? AND `bukva` = ? AND `prosek` >= ? ", [$_GET['odd'], $bukva, 4.5]);
    $brojMnDobri = $db->count("SELECT count(*) FROM ucenici WHERE `oddelenie` = ? AND `bukva` = ? AND `prosek` >= ? AND `prosek` < ?", [$_GET['odd'], $bukva, 3.5, 4.5]);
    $brojDobri = $db->count("SELECT count(*) FROM ucenici WHERE `oddelenie` = ? AND `bukva` = ? AND `prosek` >= ? AND `prosek` < ?", [$_GET['odd'], $bukva, 2.5, 3.5]);
    $brojDovolni = $db->count("SELECT count(*) FROM ucenici WHERE `oddelenie` = ? AND `bukva` = ? AND `prosek` >= ? AND `prosek` < ?", [$_GET['odd'], $bukva, 2, 2.5]);
    $nastavnik = $db->query("SELECT * FROM `nastavnik` WHERE `oddelenie` = ".$_GET['odd']." AND `bukva` = '$bukva' ")->fetch();
    echo "<a href='./pregled'> << Врати се назад </a>";    

    
if ($brucenici > 0){
    // echo "Преглед за ".$_GET['broj']." ученици <br>";
    echo "<br>Преглед за ".$brucenici." ученици <br>";
    echo "Класен раководител ".$nastavnik['ime']." ".$nastavnik['prezime']."<br><br>";

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
    $i=0;
    foreach($ucenici as $ucenik){
    // for ($i=0; $i < $_GET['broj']; $i++){
        $i++;
        $id = $ucenik['id'];
        $ime = $ucenik['ime'];
        $prezime = $ucenik['prezime'];
        $pol = $ucenik['pol'];
        $maski = '';
        $zenski = '';
        $predmet_p  = '';
        $opravdani = '';
        $neopravdani = '';


        if(isset($_POST['ime'.$id])){  $ime = $_POST['ime'.$id]; }
        if(isset($_POST['prezime'.$id])){  $prezime = $_POST['prezime'.$id]; }
        if(isset($_POST['pol'.$id])){  $pol = $_POST['pol'.$id]; }

        echo "<tr><td>$i</td>";
        echo "<td> <input name='ime".$id."' type='text' value='$ime' placeholder='Име' required></td>";
        echo "<td> <input name='prezime".$id."' type='text' placeholder='Презиме' value='$prezime' required></td>";
            if($pol == 1){
                $maski = 'selected';
                $zenski = '';
            }else 
            if($pol == 2){
                $maski = '';
                $zenski = 'selected';
            }
        echo '<td> <select name="pol'.$id.'" id="pol" required>
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
                        
                        $predmetid = $predmet['short'].$id;
                        if(isset($_POST[$predmetid])){  
                            $predmet_p = $_POST[$predmetid];
                        }
                        // echo "<td><input type='number'  min='1' max='5' style='idth: 5em' name='".$predmetid."' value='";
                        // if(isset($_POST[$predmetid])){  
                        //     echo $_POST[$predmetid]; 
                        // }else{
                        //     echo 0;
                        // }
                        // echo "' required></td>";
                        if(isset($_POST['opravdani'.$id])){  $opravdani = $_POST['opravdani'.$id]; }
                       echo "<td><input type='number'  min='1' max='5' style='idth: 5em' name='".$predmetid."' value='$predmet_p' required></td>";
                       
                    }
                    
                    $tarray[$predmetid] = (int)$predmet_p;
      
                }
                $slabi  = 0;
                $slabiAr = [];
                foreach($tarray as $slaba){
                    if ($slaba == 1){
                        $slabiAr[] = $slaba;
                    }
                }
                $slabi = count($slabiAr);

                $site_oceni = implode(', ', $tarray);

                   // echo $prosek;
                //echo $count."<br>";

                if(isset($_POST['opravdani'.$id])){  $opravdani = $_POST['opravdani'.$id]; }
                if(isset($_POST['neopravdani'.$id])){  $neopravdani = $_POST['neopravdani'.$id]; }
                echo "<td><input type='number' min='1' max='500'  style='idth: 5em' name='opravdani".$id."' value='$opravdani' ></td>";
                echo "<td><input type='number' min='1' max='500'  style='idth: 5em' name='neopravdani".$id."' value='$neopravdani' required></td>";

                if ($opravdani != '' || $neopravdani != ''){
                    $vkupno = (int)$opravdani+(int)$neopravdani;
                }else{
                    $vkupno = 0;
                }

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    echo "<tr><td colspan='".($count+6)."'>Ученикот $ime $prezime постигна ".uspeh($tarray)." успех со просек ".prosek($tarray)." со $slabi слаби! ";
                    echo "Ученикот има вкупно $vkupno изостаноци од кои $opravdani се оправдани и $neopravdani неоправдани!</td></tr>";
                    $db->insert("UPDATE `ucenici` SET `oceni` = ?, `opravdani` = ?, `neopravdani` = ?, `slabi` = ?, `prosek` = ? WHERE `id` = ?", [$site_oceni, $opravdani, $neopravdani, $slabi, prosek($tarray), $id]);
                //$bigarray[] = array_push($tarray);
                }
            
            }
            
            foreach($tarray as $key=>$value){ 
                $array_o[$key] = $value;
            }

        echo "</tr>";
    }



    
    
    echo "</tbody></table>
    <button type='submit'>Генерирај</button>
    </form>
    <br>
    ";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        echo "
        <table class='table'>
        <thead class='thead-primary'>
        <tr>
        <th colspan=2>Пол</th>
        </tr>
        <thead>
        <tr><td>Женски:</td><td>$bruceniZenski</td></tr>
        <tr><td>Машки:</td><td>$bruceniMaski</td></tr>
        <tr><td>Вкупно:</td><td>$brucenici</td></tr>
        </table><br>";
        echo "
        <table class='table'>
        <thead class='thead-primary'>
        <tr>
        <th colspan=2>Успех</th>
        </tr>
        <thead>
        <tr><td>Одлични:</td><td>$brojOdlicni</td></tr>
        <tr><td>Многу добри:</td><td>$brojMnDobri</td></tr>
        <tr><td>Добри:</td><td>$brojDobri</td></tr>
        <tr><td>Доволни:</td><td>$brojDovolni</td></tr>
        <tr><td>Со 1 слаба:</td><td>$bruceniciSoSlaba</td></tr>
        <tr><td>Со повеќе слаби:</td><td>$bruceniciSoSlabi</td></tr>
        <tr><td>Просек на одделението </td><td> ".prosek($array_o)." со постигнат ".uspeh($array_o)." успех!</td></tr>
        </thead>
        </table><br>";
    }

}else{
    echo "Настана грешка во пребарувањето!<br><br>";
    echo "<a href='./pregled'> << Врати се назад </a>";    

}


} else {
    ?>

    <form method="get" action="./pregled">
    <label for="odd">Избери одделение:</label>
    <select name="odd" id="odd">
        <option value="7">седмо</option>
        <option value="8">осмо</option>
        <option value="9">деветто</option>
    </select>
    <label for="bukva">Буква:</label>
    <select name="bukva" id="bukva">
        <option value="A">А</option>
        <option value="Б">Б</option>
        <option value="В">В</option>
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