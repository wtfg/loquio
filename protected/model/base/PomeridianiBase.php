<?php
Doo::loadCore('db/DooModel');

class PomeridianiBase extends DooModel{

    /**
     * @var int Max length is 11.
     */
    public $pomid;

    /**
     * @var varchar Max length is 255.
     */
    public $cognome;

    /**
     * @var varchar Max length is 255
     */
    public $nome;

    /**
     * @var varchar Max length is 255.
     */
    public $classe;

    /**
     * @var int Max length is 11.
     */
    public $did;
    /**
     * @var int Max length is 11.
     */
    public $uid;


    public $_table = 'pomeridiani';
    public $_primarykey = 'pomid';
    public $_fields = array('pomid','cognome','nome', 'classe','did', 'uid');

    public function getVRules() {
        return array(
                'pomid' => array(
                        array( 'integer' ),
                        array( 'maxlength', 11 ),
                        array( 'notnull' ),
                ),
                'cognome' => array(
                    array( 'varchar' ),
                    array( 'maxlength', 255 ),
                    array( 'notnull' ),
                ),

                'nome' => array(
                    array( 'varchar' ),
                    array( 'maxlength', 255 ),
                        array( 'notnull' ),
                ),
                'classe' => array(
                    array( 'varchar' ),
                    array( 'maxlength', 3 ),
                    array( 'notnull' ),
                ),
                'did' => array(
                    array( 'integer' ),
                    array( 'maxlength', 11 ),
                    array( 'notnull' ),
                ),
                'uid' => array(
                    array( 'integer' ),
                    array( 'maxlength', 11 ),
                    array( 'notnull' ),
                )
            );
    }

}