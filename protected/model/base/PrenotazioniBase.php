<?php
Doo::loadCore('db/DooModel');

class PrenotazioniBase extends DooModel{

    /**
     * @var int Max length is 11.
     */
    public $pid;

    /**
     * @var datetime
     */
    public $creata;

    /**
     * @var text
     */
    public $data;

    /**
     * @var text
     */
    public $ora;

    /**
     * @var int Max length is 11.
     */
    public $did;

    /**
     * @var int Max length is 11.
     */
    public $uid;

    /**
     * @var text
     */
    public $classe;

    /**
     * @var text
     */
    public $studente;

    /**
     * @var text
     */
    public $email;

    /**
     * @var text
     */
    public $tel;

    /**
     * @var text
     */
    public $codicecanc;

    public $_table = 'prenotazioni';
    public $_primarykey = 'pid';
    public $_fields = array('pid','creata','data','ora','did','uid','classe','studente','email','tel','codicecanc');

    public function getVRules() {
        return array(
                'pid' => array(
                        array( 'integer' ),
                        array( 'maxlength', 11 ),
                        array( 'optional' ),
                ),

                'creata' => array(
                        array( 'datetime' ),
                        array( 'notnull' ),
                ),

                'data' => array(
                        array( 'notnull' ),
                ),

                'ora' => array(
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
                ),

                'classe' => array(
                        array( 'notnull' ),
                ),

                'studente' => array(
                        array( 'notnull' ),
                ),

                'email' => array(
                        array( 'notnull' ),
                ),

                'tel' => array(
                        array( 'notnull' ),
                ),

                'codicecanc' => array(
                        array( 'notnull' ),
                )
            );
    }

}