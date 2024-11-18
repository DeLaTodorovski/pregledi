<?php

function dd($value)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";

    die();
}

function urlIs($value) {
    return $_SERVER['REQUEST_URI'] === $value;
}

  function uspeh($array){
    
    $sumarum = array_sum($array);
    $countar = count($array);
    $sumarum = $sumarum / $countar;
    $result = round($sumarum, 2);
    
    if($result >= 1 && $result < 2){
      return "Недоволен";
    } else if($result >= 2 && $result < 2.5){
      return "Доволен";
    } else if($result >= 2.5 && $result < 3.5){
      return "Добар";
    } else if($result >= 3.5 && $result < 4.5){
      return "Многу добар";
    } else if($result >= 4.5 && $result <= 5){
      return "Одличен";
    }else{
      return "Грешка!";
    }
  
  }
  
    function prosek($array){
    
    $sumarum = array_sum($array);
    $countar = count($array);
    $sumarum = $sumarum / $countar;
    return round($sumarum, 2);
  
  }