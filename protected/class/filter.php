<?php

/**
 * Class pFilter
 * ha 3/4 metodi
 *
 * 1) dati i parametri di divisione e dato un insieme, restituisce un array contenente quella roba
 * 2) dato un array contenente roba, crea un CSV
 * 3) dato un array contennete roba, crea un pdf
 */
class pFilter
{
    private $data = array();
    private $type = array();
    private $output = array();
    private $divided = array();

    function setData($d){
        $this->data = $d;
    }

    function detData($d){
        return $this->data;
    }

    function setType($t, $extra){
        $this->type = array($t => $extra);
    }

    function divideTeachers(){
        $teachers = array();
        foreach($this->data as $record){
            if(!array_key_exists($record->did, $teachers)){
                $teachers[$record->did] = array();
            }
            array_push($teachers[$record->did], $record);
        }
        $t = array();
        foreach($teachers as $key => $value){
            $this->divide($value);
            array_push($t, $this->output);
        }
        $this->divided = $t;
        return $this->divided;
    }
    /**
     * I parametri sono:
     * 1) Niente
     * 2) Blocchi 50,110
     * 3) Canali (A-L)(M-Z)
     * 4) Per classi
     *
     */
    function divide($data, $clear=true){
        if($clear)
            $this->output = array();

        foreach ($this->type as $key => $value){
            switch($key){
                case "blocks":
                    $this->blocks($data, $value);
                break;
                case "channels":
                    $this->channels($data, $value);
                break;
                case "class":
                    $this->classes($data, $value);
                break;
                default:
                    $this->output = $data;
                break;
            }
        }

    }

    /**
     * @param $value string valore scritto in bocchi quindi "50" spezzetta in bocchi di 50
     * mentre "50,100" fa 0-49, 50-100
     */
    private function blocks($data, $value){
        if(strpos($value,',') !== false){
            $value = explode(",", $value);
            $old = 0;
            foreach($value as $values){
                $values = intval($values);
                $a = array_slice($data, $old, $values);
                $old = $values;
                array_push($this->output,$a);
            }

        }else{
            $this->output = array_chunk($data, $value);
        }
    }

    /**
     * @param $value string il numero di canali AL,MZ
     */
    private function channels($data, $value){
        $value = explode(",", $value);
        foreach($value as $values){
            $current_channel = array();
            foreach($data as $record){
                $addable = $record->cognome[0] >= $values[0] && $record->cognome[0] <= $values[1];
                if($addable){
                    array_push($current_channel, $record);
                }
            }
            array_push($this->output, $current_channel);
        }
    }

    /**
     * @param $value string separa per classi
     */
    private function classes($data){
        $classes = array();
        foreach($data as $record){
            if(!array_key_exists($record->classe, $classes)){
                $classes[$record->classe] = array();
            }
            array_push($classes[$record->classe], $record);
        }
        $this->output = $classes;

    }
}

?>