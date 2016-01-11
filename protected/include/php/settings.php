<?php

// Time zone
date_default_timezone_set('Australia/Adelaide');

// Site
Config::write('site.title','Australian Curriculum Engagement Tool');
Config::write('site.includenone',FALSE);

// Email
// (Uncomment only one of the following three
// Config::write('email.transporttype','Smtp');
 Config::write('email.transporttype','Sendmail');
// Config::write('email.transporttype','Mail');

// SMTP
Config::write('smtp.host','smtp.gmail.com');
Config::write('smtp.port','465');
Config::write('smtp.encr','ssl');
Config::write('smtp.user','andmos@gmail.com');
Config::write('smtp.pass','ttrezhjcrurgvlaq');

// Sendmail
Config::write('email.sendmail','/usr/sbin/sendmail -bs');

// Database
Config::write('db.host','127.0.0.1');
Config::write('db.user','amoschou');
Config::write('db.port','5432');
Config::write('db.password','');
Config::write('db.basename','acmathematicsweb');

// Password
Config::write('password.cost',11);

