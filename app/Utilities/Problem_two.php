<?php

namespace App\Utilities;
class Problem_two 
{
    public function stringIterations($text){
        $chars=array();
        for ($i=1; $i <= strlen($text); $i++) { 
            $chars=$this->calcularPorCadena($text,$i,$chars);
        }
        $result=array();
        foreach($chars as $char){
            $result[$char] =$this->count_substring($text, $char);
        }
        $max=max($result);

        return array("max" => $max, "allCharacters" => $result);
    }
    function calcularPorCadena($text,$len,$chars){
        
        for ($i=0; $i <strlen($text); $i++) { 
            $char=substr($text,$i,($len));
            if(!in_array($char, $chars)){
                array_push($chars, $char);
            }
        }
     
        return $chars;
    }

    function count_substring($text,$sub_string){
        $len1 = strlen($text);
        $len2 = strlen($sub_string);
        $j =0;
        $counter = 0;
        while($j < $len1){
            if($text[$j] == $sub_string[0]){
                if(substr($text,$j,$len2) == $sub_string)
                    $counter += 1;
            } 
            $j += 1;
        }
        return $counter*$len2;
    }
    

}
