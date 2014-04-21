<?php
Doo::loadCore('db/DooModel');

class UtentiBase extends DooModel{

    /**
     * @var int Max length is 11.
     */
    public $uid;

    /**
     * @var varchar Max length is 255.
     */
    public $email;

    /**
     * @var varchar Max length is 255.
     */
    public $pass;

    /**
     * @var varchar Max length is 255.
     */
    public $nome;

    /**
     * @var varchar Max length is 255.
     */
    public $cognome;

    /**
     * @var int Max length is 11.
     */
    public $acl;

    public $_table = 'utenti';
    public $_primarykey = 'uid';
    public $_fields = array('uid','email','pass','nome','cognome','telefono','altramail','acl');

    public function getVRules() {
        return array(
                'uid' => array(
                        array( 'integer' ),
                        array( 'maxlength', 11 ),
                        array( 'optional' ),
                ),

                'email' => array(
                        array( 'maxlength', 255 ),
                        array( 'notnull' ),
                ),

                'pass' => array(
                        array( 'maxlength', 255 ),
                        array( 'notnull' ),
                ),

                'nome' => array(
                        array( 'maxlength', 255 ),
                        array( 'notnull' ),
                ),

                'cognome' => array(
                        array( 'maxlength', 255 ),
                        array( 'notnull' ),
                ),
            
                'telefono' => array(
                        array( 'maxlength', 255 ),
                        array( 'notnull' ),
                ),

                'altramail' => array(
                        array( 'maxlength', 255 ),
                        array( 'notnull' ),
                ),

                'acl' => array(
                        array( 'integer' ),
                        array( 'maxlength', 11 ),
                        array( 'notnull' ),
                )
            );
    }

}