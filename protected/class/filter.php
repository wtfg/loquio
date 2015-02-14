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
    private $separator = ";";
    private $newline = "\n";
    private $path = "temp/";
    private $extension = ".csv";
    /**
     * @param $d array array di oggetti imposta dati
     */
    function setData($d){
        $this->data = $d;
    }

    /**
     * @return array dati
     */
    function getData(){
        return $this->data;
    }

    /**
     * @param $t string blocks o channels
     * @param $extra string
     */
    function setType($t, $extra){
        $this->type = array($t => $extra);
    }

    /**
     * @return array divide docenti
     */
    function divide(){
        $teachers = array();
        foreach($this->data as $record){
            if(!array_key_exists($record->did, $teachers)){
                $teachers[$record->did] = array();
            }
            array_push($teachers[$record->did], $record);
        }
        $t = array();
        foreach($teachers as $key => $value){
            $this->divide_records($value);
            array_push($t, $this->output);
        }
        $this->divided = $t;
        return $this->divided;
    }
    private function makeCsvFile($name, $pages){
        $string = $name.$this->newline;
        $j = 0;
        foreach($pages as $record){
            $j+=1;
            $string .= $j . $this->separator . $record->cognome . " " . $record->nome . $this->separator . $record->classe .
                $this->newline;
        }
        file_put_contents($this->path . $name . $this->extension, $string) or die(error_get_last());
    }
    function toCsv(){

        $type = array_keys($this->type)[0];

        foreach($this->divided as $did => $pages){

            $a = Doo::loadModel("docenti", true);
            $a->did = $did;
            $a = Doo::db()->find($a, array("limit"=>1));

            if($a === false){
                continue;
            }
            $fileName = strtolower(str_replace(" ", "-", $a->nome."-".$a->cognome));
            if($type != "blocks" && $type != "channels"){
                $name = $fileName;
                $this->makeCsvFile($name, $pages);
                continue;
            }
            foreach($pages as $i => $page){
                $name = $fileName."-giorno-".($i +1);
                $this->makeCsvFile($name, $page);
            }

        }

    }

    function toPDF(){
        $v_dir = getcwd()."/temp/";
        $files = glob($v_dir.'*'); // get all file names
        foreach($files as $file){ // iterate files
            if(is_file($file)){
                $pdf = new pdfMaker();
                $header = array('N#', 'Nome', 'Classe');
                $data = $pdf->LoadData($file);

                $pdf->AddPage();
                $pdf->ImprovedTable($header,$data);
                $pdf->Output(substr($file,0,-4).".pdf");
            }
        }

    }
    function downloadZip(){
        $zipname = 'csv-reports.zip';
        $zip = new PclZip($zipname);
        $v_dir = getcwd()."/temp/"; // or dirname(__FILE__);
        $v_remove = $v_dir;

        $v_list = $zip->create($v_dir, PCLZIP_OPT_REMOVE_PATH, $v_remove);
        if ($v_list == 0) {
            die("Error : ".$zip->errorInfo(true));
        }else{
            $files = glob($v_dir.'*'); // get all file names
            foreach($files as $file){ // iterate files
                if(is_file($file))
                    unlink($file); // delete file
            }
            if (file_exists(getcwd()."/".$zipname)) {
                $file_url = getcwd()."/".$zipname;
                $this->headers($file_url);
                readfile($file_url);
                unlink($file_url);
            } else {
                exit("Could not find Zip file to download");
            }
        }
    }

    private function headers($file_url){
        header('Content-Type: "application/octet-stream"');
        header('Content-Disposition: attachment; filename="'.basename($file_url).'"');
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: ".filesize($file_url));
        header('Expires: 0');
        header('Cache-Control: private');
        header('Pragma: private');
        ob_clean();
        flush();
    }
    /**
     * I parametri sono:
     * 1) Niente
     * 2) Blocchi 50,110
     * 3) Canali (A-L)(M-Z)
     * 4) Per classi
     *
     */
    private function divide_records($data, $clear=true){
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
                #case "class":
                #    $this->classes($data, $value);
                #break;
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