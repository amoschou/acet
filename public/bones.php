<?php
/*
define('CONST_DOCROOT',$_SERVER['DOCUMENT_ROOT']);
$DocRootSlash = substr(CONST_DOCROOT,-1) === DIRECTORY_SEPARATOR ? '' : DIRECTORY_SEPARATOR;
define('CONST_DOCROOTSLASH',$DocRootSlash);
define('DIR_DOCROOT',CONST_DOCROOT.CONST_DOCROOTSLASH);
*/

define('DIR_APPROOT',__DIR__);
define('DIR_PROTECTED',dirname(__DIR__).DIRECTORY_SEPARATOR.'protected/');

define('DIR_INCLUDE',DIR_PROTECTED.'include/');
define('DIR_LIBRARY',DIR_INCLUDE.'library/');
define('DIR_CONTENT',DIR_INCLUDE.'content/');
define('DIR_CLASS',DIR_INCLUDE.'class/');
define('DIR_VAR',DIR_INCLUDE.'var/');
define('DIR_QUERIES',DIR_INCLUDE.'queries/');
define('DIR_SESSION',DIR_INCLUDE.'session/');
define('DIR_NOSESSION',DIR_INCLUDE.'nosession/');
define('DIR_READY',DIR_INCLUDE.'ready/');
define('DIR_PHP',DIR_INCLUDE.'php/');
define('DIR_NAV',DIR_INCLUDE.'nav/');

function superendsession()
{
  session_unset(); // $_SESSION = array();
  session_destroy();
  session_write_close();
  setcookie(session_name(),'',0,'/');
  session_regenerate_id(true);
}