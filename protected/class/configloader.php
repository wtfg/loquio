<?php
/**
 * Created by PhpStorm.
 * User: Mauro
 * Date: 22/04/14
 * Time: 0.19
 */

class ConfigLoader{

    private static $_instance = null;
    private $fileName = "global/config/config.json";
    private $config;

    private function ConfigLoader(){
            $this->fileName = Doo::conf()->SITE_PATH . $this->fileName;
            $this->config = json_decode($this->readFile($this->fileName), true);
    }

    public static function getInstance(){
        if(ConfigLoader::$_instance == null)
            ConfigLoader::$_instance = new ConfigLoader();
        return ConfigLoader::$_instance;
    }

    /**
     * Chiamata solo se il file e' necessario
     */
    private function getInitialConfig(){
        $init = array("lookAheadTime" => 60, "schoolName" => "Test");
        return json_encode($init);
    }

    public function setParams($post){

        $lookAheadTime = trim($post["lookAheadTime"]);
        $schoolName = trim($post["schoolName"]);
        $schoolLocation = trim($post["schoolLocation"]);
        $pomeridianiTitle = trim($post["pomeridianiTitle"]);
        $pomeridianiMessage = trim($post["pomeridianiMessage"]);
        $pomeridianiActive =  isset($post['pomeridianiActive']) ? $post['pomeridianiActive'] : 'false';

        $this->setParam("lookAheadTime", $lookAheadTime);
        $this->setParam("schoolName", $schoolName);
        $this->setParam("schoolLocation", $schoolLocation);
        $this->setParam("pomeridianiTitle", $pomeridianiTitle);
        $this->setParam("pomeridianiMessage", $pomeridianiMessage);
        $this->setParam("pomeridianiActive", $pomeridianiActive);
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
        return array_key_exists($param,$this->config) ? stripslashes($this->config[$param]) : null;
    }

    public function setParam($param, $value){
        $this->config[$param] = addslashes($value);
        $this->saveToFile($this->fileName, json_encode($this->config));
    }

    public function setConfigByVal($str){
        $this->config = json_decode($str, true);
        $this->saveToFile($this->fileName, json_encode($this->config));
    }
}