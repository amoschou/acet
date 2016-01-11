<?php

if(version_compare(PHP_VERSION,'5.5.0') < 0)
{
  echo "PHP 5.5.0 or later is required. Please upgrade your PHP installation.";
  die();
}
/* We’re live! */
require_once __DIR__.DIRECTORY_SEPARATOR.'bones.php';
require_once DIR_PHP.'pagesetup.php';
if($_SERVER['REQUEST_METHOD'] == 'GET')
{
  if(isset($_GET['nav']))
  {
    $_SESSION['nav'] = $_GET['nav'];
    include DIR_NAV.DIRECTORY_SEPARATOR.'nav.php';
  }
}
ob_start();
echo "<!DOCTYPE html>";
echo "<html lang=\"en\">";
print_head();
echo "<body>";
print_noscript();
echo "<div class=\"oldie-display-none nojs-display-none\">";
print_navbar();
if(Config::read('var.showsession'))
{
  print_session();
  unset($_SESSION['dev']);
}
print_container();
print_footer();
echo "</div>";
print_scripts();
echo "</body>";
echo "</html>";
ob_end_flush();