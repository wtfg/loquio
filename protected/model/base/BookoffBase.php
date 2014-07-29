<?php
Doo::loadCore('db/DooModel');

class BookoffBase extends DooModel{

    /**
     * @var int Max length is 11.
     */
    public $bookoffid;

    /**
     * @var varchar Max length is 255.
     */
    public $did;

    /**
     * @var varchar Max length is 65536.
     */
    public $datefrom;


    public $dateto;

    public $_table = 'bookoff';
    public $_primarykey = 'bookoffid';
    public $_fields = array('bookoffid','did','datefrom', 'dateto');

    public function getVRules() {
        return array(
                'bookoffid' => array(
                        array( 'integer' ),
                        array( 'maxlength', 11 ),
                        array( 'optional' ),
                ),

                'did' => array(
                    array( 'integer' ),
                    array( 'maxlength', 11 ),
                    array( 'notnull' ),
                ),

                'datefrom' => array(
                    array( 'integer' ),
                    array( 'maxlength', 20 ),
                        array( 'notnull' ),
                ),
                'dateto' => array(
                    array( 'integer' ),
                    array( 'maxlength', 20 ),
                    array( 'notnull' ),
                )
            );
    }

}