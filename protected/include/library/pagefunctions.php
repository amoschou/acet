<?php

function exception_errorx($e)
{
  $s = '<dl>';
  $s .= get_dtdd("Message",$e->getMessage());
  $s .= "</dl>";
  error_page($s);
}
function exception_error($e)
{
  $s = '<dl>';
//  $s .= get_dtdd("Message",$e->getMessage());
//  $s .= get_dtdd("Previous",$e->getPrevious());
  $s .= get_dtdd("Code",$e->getCode());
//  $s .= get_dtdd("File",$e->getFile());
//  $s .= get_dtdd("Line",$e->getLine());
//  $s .= get_dtdd("Trace",$e->getTrace());
//  $s .= get_dtdd("TraceAsString",$e->getTraceAsString());
//  $s .= get_dtdd("ToString",$e->__toString());
  $s .= "</dl>";
  error_page($s);
}
function get_dtdd($dt = '',$dd = '')
{
  return "<dt>$dt</dt><dd>$dd</dd>";
}
function error_page($message)
{
  begin_mini_page();
  echo "<h1>".Config::read('site.title')."</h1>";
  echo "<h2>Error</h2>";
  echo "<div class=\"alert alert-danger\">";
  echo $message;
  echo "</div>";
  end_mini_page();
}
function begin_mini_page($nav = FALSE)
{
  echo "<!DOCTYPE html>";
  echo "<html lang=\"en\">";
  print_head();
  echo "<body>";
//  print_scripts();
//  print_iescriptblocks();
  echo "<div class=\"nojs-display-none oldie-display-none\">";
  if($nav)
  {
    print_navbar();
  }
  echo "<div class=\"container\">";
}
function end_mini_page()
{
  echo "</div>";
  echo "</div>";
  echo "</body>";
  echo "</html>";
  die();
}
function print_session()
{
  echo '<div class="container sessionhider"><pre>';
  echo print_r($_SESSION,1);
  echo '</pre></div>';
}
function print_lia($str,$url,$icon = NULL,$tooltip = 0)
{
  echo "<li><a onmouseover=\"this.style.cursor='pointer'\" onclick=\"navpage('$url');\"";
  switch($tooltip)
  {
    case(1):
      echo " data-toggle=\"tooltip\" data-placement=\"auto\" title=\"$str\"";
      break;
    case(2):
      echo " data-toggle=\"popover\" data-content=\"$str\" data-trigger=\"hover focus\" data-placement=\"auto\"";
      break;
  }
  echo ">";
  if(!is_null($icon))
  {
    echo "<span class=\"glyphicon glyphicon-$icon\"></span>";
    if(!$tooltip)
    {
      echo "&emsp;";
    }
  }
  if(!$tooltip)
  {
    echo $str;
  }
  echo '</a></li>';
}
function print_noscript()
{
?>
  <noscript>
    <style type="text/css">.nojs-display-none{display:none;}</style>
    <div class="container">
      <div class="alert alert-danger topmore">
        <p>You have JavaScript disabled and this web application won’t run. Javascript is required for interactivity. Come back when you’ve fixed that.</p>
        <p><a href="http://enable-javascript.com/" class="btn btn-default">Learn more</a></p>
      </div>
    </div>
  </noscript>
<?php
}



/*

  

  
  function print_iescriptblocks()
  {
    echo '<noscript><div class="container"><h1>MyAUCS</h1></div></noscript>';
    print_noscript();
    print_oldie();
  }
  function print_oldie()
  {
?>
    <!--[if lt IE 9]>
      <style type="text/css">.oldie-display-none{display:none;}</style>
      <div class="container">
        <div class="alert alert-danger">
          <p>You have an old version of Internet Explorer and this web application won’t run. Please use a recent browser such as Chrome, Firfox, Opera, Safari or Internet Explorer 9 or later. Come back when you’ve fixed that.</p>
          <p><a href="http://jquery.com/browser-support/" class="btn btn-default">Learn more</a></p>
        </div>
      </div>
    <[endif]-->
<?php
  }

*/