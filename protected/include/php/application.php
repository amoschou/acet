<?php

Config::write('app.hempty','1B2M2Y8AsgTpgAmY7PhCfg');

Config::write('app.hsubject.mathematics','VAsh7Nsnb1CH7lhc7dbV0A');

Config::write('app.hlevel.year7',select_from('hlevel',"ac_Levels WHERE Level = 'Year 7'"));
Config::write('app.hlevel.year8',select_from('hlevel',"ac_Levels WHERE Level = 'Year 8'"));
Config::write('app.hlevel.year9',select_from('hlevel',"ac_Levels WHERE Level = 'Year 9'"));
Config::write('app.hlevel.year10',select_from('hlevel',"ac_Levels WHERE Level = 'Year 10'"));
Config::write('app.hlevel.year10a',select_from('hlevel',"ac_Levels WHERE Level = 'Year 10A'"));

