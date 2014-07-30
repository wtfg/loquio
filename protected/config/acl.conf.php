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
							
                                );
$acl['user']['deny'] = array(
							
                                                        'LoginController'=>array('registerPage'),
                                                        'AdminController'=>'*',
                                                        'BookoffController' => '*',
                                );

$acl['docente']['allow'] = array(
							'LoginController'=>'*',
                                                        'PrenotController'=>'*',
							
                                );

$acl['docente']['deny'] = array(
							'PrenotController'=>array('showPrenUser'), 
                                                        'PrenotController'=>array('newPren'),
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

