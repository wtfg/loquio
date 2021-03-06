<?php
/**
 * Example Database connection settings and DB relationship mapping
 * $dbmap[Table A]['has_one'][Table B] = array('foreign_key'=> Table B's column that links to Table A );
 * $dbmap[Table B]['belongs_to'][Table A] = array('foreign_key'=> Table A's column where Table B links to );
 

//Food relationship
$dbmap['Food']['belongs_to']['FoodType'] = array('foreign_key'=>'id');
$dbmap['Food']['has_many']['Article'] = array('foreign_key'=>'food_id');
$dbmap['Food']['has_one']['Recipe'] = array('foreign_key'=>'food_id');
$dbmap['Food']['has_many']['Ingredient'] = array('foreign_key'=>'food_id', 'through'=>'food_has_ingredient');

//Food Type
$dbmap['FoodType']['has_many']['Food'] = array('foreign_key'=>'food_type_id');

//Article
$dbmap['Article']['belongs_to']['Food'] = array('foreign_key'=>'id');

//Recipe
$dbmap['Recipe']['belongs_to']['Food'] = array('foreign_key'=>'id');

//Ingredient
$dbmap['Ingredient']['has_many']['Food'] = array('foreign_key'=>'ingredient_id', 'through'=>'food_has_ingredient');

*/
$dbmap['Prenotazioni']['belongs_to']['Utenti'] = array('pid'=>'uid');
$dbmap['Utenti']['has_many']['Prenotazioni'] = array('uid'=>'pid');
$dbmap['Prenotazioni']['belongs_to']['Docenti'] = array('pkey'=>'did');
$dbmap['Docenti']['has_many']['Prenotazioni'] = array('did'=>'pid');
$dbmap['Docenti']['belongs_to']['Materie'] = array('dkey'=>'mid');
$dbmap['Materie']['has_many']['Docenti'] = array('mid'=>'did');
$dbmap['Docenti']['has_many']['Bookoff'] = array('did'=>'bookoffid');
$dbmap['Bookoff']['belongs_to']['Docenti'] = array('bookoffid'=>'did');




//$dbconfig[ Environment or connection name] = array(Host, Database, User, Password, DB Driver, Make Persistent Connection?);
/**
 * Database settings are case sensitive.
 * To set collation and charset of the db connection, use the key 'collate' and 'charset'
 * array('localhost', 'database', 'root', '1234', 'mysql', true, 'collate'=>'utf8_unicode_ci', 'charset'=>'utf8'); 
 62.149.150.59 
Sql150902_5
Sql150902
e7c6fd54
 */

 $dbconfig['dev'] = array('', '', '', '', 'mysql', true);
 $dbconfig['prod'] =  array('', '', '', '', 'mysql', true);
 
?>