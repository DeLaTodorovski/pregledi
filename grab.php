<?php
require 'functions.php';
require 'Database.php';
require 'header.php';
$config = require('config.php');
$db = new Database($config['database']);

if(isset($_GET['broj']) && $_GET['broj'] != "" && $_GET['broj'] > 0 && $_GET['broj'] < 35 && $_GET['odd'] < 10 && isset($_GET['odd']) && $_GET['odd'] != "" && $_GET['odd'] > 0 && is_numeric($_GET['odd']) && is_numeric($_GET['broj'])) {
    echo "Преглед за ".$_GET['broj']." ученици <br>";

    echo "
    <form method='POST' action=''>
	<table class='table'>
    <thead class='thead-primary'>
    <tr>
    <th>Бр.</th>
    <th>Име</th>
    <th>Презиме</th>
    <th>Пол</th>
    </tr>
    </thead>
    <tbody>";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "Успешно внесени ".$_GET['broj']." ученици:";
    }

    for ($i=0; $i < $_GET['broj']; $i++){
        $ime = '';
        $prezime = '';
        $pol = '';
        $maski = '';
        $zenski = '';

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

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_POST["ime".($i+1)])) {
              echo "Name is empty";
            } else {
                $db->insert("INSERT INTO `ucenici`(`ime`, `prezime`, `pol`, `oddelenie`, `bukva`, `nid`) VALUES (?, ?, ?, ?, ?, ?) ", [$_POST["ime".($i+1)], $_POST["prezime".($i+1)], $_POST["pol".($i+1)], $_GET['odd'], $_GET['bukva'], $_GET['nastavnik']]);
                echo "<pre>";
                echo "".$_POST["ime".($i+1)]. " " .$_POST["prezime".($i+1)]."\n";
                echo "</pre>";
            }
          }

    }

        
    echo "</tbody></table>
    <button type='submit'>Внеси</button>
    </form>
    ";



}else{ 
    ?>
    <form method="get" action="./grab.php">
    <label for="broj">Број на ученици:</label>
    <input name="broj" type="number" value=0 min='1' max='30' style='idth: 5em'>
    <label for="odd">Избери одделение:</label>
    <select name="odd" id="odd">
        <option value="7">седмо</option>
        <option value="8">осмо</option>
        <option value="9">деветто</option>
    </select>
    <label for="nastavnik">Класен раководител:</label>
    <select name="nastavnik" id="nastavnik">
    <?php
        $nastavnici = $db->query("select * from nastavnik WHERE id > 0")->fetchAll();
        foreach ($nastavnici as $nastavnik) {
            echo '<option value="'.$nastavnik['id'].'" >'.$nastavnik['ime'].' '.$nastavnik['prezime'].'</option>';
        }
    ?>
    </select>
    <label for="bukva">Буква:</label>
    <select name="bukva" id="бbukva">
        <option value="A">А</option>
        <option value="Б">Б</option>
        <option value="В">В</option>
    </select>

    <button type="submit">Продолжи</button>
    </form>
    
    <?php
}
    ?>