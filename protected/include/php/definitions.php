<?php

// Site
Config::write('site.domain',$_SERVER['SERVER_NAME']);
Config::write('site.protocol','http');

// Database
Config::write('db.prefix','pgsql');

$Connection = get_connection();
$Connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Initialisation
Config::write('var.showsession',FALSE);

//Developent
Config::write('dev.noemail',TRUE);