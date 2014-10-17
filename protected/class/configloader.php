<?php
/**
 * Created by PhpStorm.
 * User: Mauro
 * Date: 22/04/14
 * Time: 0.19
 */

class ConfigLoader{


    public function ConfigLoader($filepath){
        $this->fileName = $filepath."/config.json";
        $this->config = json_decode($this->readFile($this->fileName), true);
    }

    /**
     * Chiamata solo se il file e' necessario
     */
    private function getInitialConfig(){
        $init = array("lookAheadTime" => 60, "schoolName" => "Test");
        return json_encode($init);
    }

    /**
     * Legge un file e lo ritorna a stringa
     * @param $file
     * @return string
     */
    private function readFile($file){
        if(file_exists($file)){
            return file_get_contents($file);
        }else{
            $f = fopen($file, "a");
            $this->config = $this->getInitialConfig();
            fwrite($f, json_encode($this->config));
            fclose($f);

            return "";
        }
    }

    /**
     * @param $file
     * @param $str
     */
    private function saveToFile($file, $str){
        $f = fopen($file, "w");
        fwrite($f, $str);
        fclose($f);
    }

    public function getParam($param){
        return array_key_exists($param,$this->config) ? $this->config[$param] : null;
    }

    public function setParam($param, $value){
        $this->config[$param] = $value;
        $this->saveToFile($this->fileName, json_encode($this->config));
    }

    public function setConfigByVal($str){
        $this->config = json_decode($str, true);
        $this->saveToFile($this->fileName, json_encode($this->config));
    }
}