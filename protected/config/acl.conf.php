<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

// anonymous user can only access Blog index page.
$acl['anonymous']['allow'] = array(
							'LoginController'=>array('firstPage','registerPage'), 'PrenotController'=>array('showPrenDocente')
				);

$acl['user']['allow'] = array(
							'LoginController'=>'*',
                            'PrenotController'=>'*',
                            "UserController" =>array("panelUser"),
                            "PomeridianiController" => "*"
							
                                );
$acl['user']['deny'] = array(
							
                                                        'LoginController'=>array('registerPage'),
                                                        'AdminController'=>'*',
                                                        'BookoffController' => '*',
    "PomeridianiController" => array("viewPomeridianiAdmin")
                                );

$acl['docente']['allow'] = array(
							'LoginController'=>'*',
                            'PrenotController'=>'*',
                            'BookoffController' => array('snag'),
                            "UserController" =>array("panelUser")
							
                                );

$acl['docente']['deny'] = array(
							'PrenotController'=>array('showPrenUser', 'newPren'),
                                                        'LoginController'=>array('registerPage'),
                                                        'AdminController'=>'*',
                                );


$acl['admin']['allow'] = '*';

						
						
$acl['user']['failRoute'] = array(
								'_default'=>'/error'	//if not found this will be used
							);

$acl['admin']['failRoute'] = array(
								'_default'=>'/error'	//if not found this will be used
							
							);					


$acl['anonymous']['failRoute'] = array(
								'_default'=>'/error'
							);								
?>

