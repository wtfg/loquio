<?php
Doo::loadCore('db/DooModel');

class MaterieBase extends DooModel{

    /**
     * @var int Max length is 11.
     */
    public $mid;

    /**
     * @var varchar Max length is 255.
     */
    public $nome;

    public $_table = 'materie';
    public $_primarykey = 'mid';
    public $_fields = array('mid','nome');

    public function getVRules() {
        return array(
                'mid' => array(
                        array( 'integer' ),
                        array( 'maxlength', 11 ),
                        array( 'optional' ),
                ),

                'nome' => array(
                        array( 'maxlength', 255 ),
                        array( 'notnull' ),
                )
            );
    }

}