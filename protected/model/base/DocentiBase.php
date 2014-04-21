<?php
Doo::loadCore('db/DooModel');

class DocentiBase extends DooModel{

    /**
     * @var int Max length is 11.
     */
    public $did;

    /**
     * @var varchar Max length is 255.
     */
    public $nome;

    /**
     * @var varchar Max length is 255.
     */
    public $cognome;

    /**
     * @var varchar Max length is 255.
     */
    public $tel;

    /**
     * @var int Max length is 11.
     */
    public $mid;

    /**
     * @var varchar Max length is 255.
     */
    public $email;

    /**
     * @var text
     */
    public $giorniliberi;

    /**
     * @var text
     */
    public $orelibere;

    /**
     * @var int Max length is 11.
     */
    public $attivo;

    public $_table = 'docenti';
    public $_primarykey = 'did';
    public $_fields = array('did','nome','cognome','tel','mid','email','giorniliberi','orelibere','attivo');

    public function getVRules() {
        return array(
                'did' => array(
                        array( 'integer' ),
                        array( 'maxlength', 11 ),
                        array( 'optional' ),
                ),

                'nome' => array(
                        array( 'maxlength', 255 ),
                        array( 'notnull' ),
                ),

                'cognome' => array(
                        array( 'maxlength', 255 ),
                        array( 'notnull' ),
                ),

                'tel' => array(
                        array( 'maxlength', 255 ),
                        array( 'notnull' ),
                ),

                'mid' => array(
                        array( 'integer' ),
                        array( 'maxlength', 11 ),
                        array( 'notnull' ),
                ),

                'email' => array(
                        array( 'maxlength', 255 ),
                        array( 'notnull' ),
                ),

                'giorniliberi' => array(
                        array( 'notnull' ),
                ),

                'orelibere' => array(
                        array( 'notnull' ),
                ),

                'attivo' => array(
                        array( 'integer' ),
                        array( 'maxlength', 11 ),
                        array( 'notnull' ),
                )
            );
    }

}