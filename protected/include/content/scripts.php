<?php

function print_scripts()
{
  echo "<!--[if lt IE 9]>";
  echo "<script src=\"/js/jquery-1.11.3.min.js\"></script>";
  echo "<![endif]-->";
  echo "<!--[if gte IE 9]><!-->";
  echo "<script src=\"/js/jquery-2.1.4.min.js\"></script>";
  echo "<!--<![endif]-->";
  echo "<script src=\"/js/bootstrap.min.js\"></script>";
  echo "<script src=\"/js/framy.js\"></script>";
  // IE10 viewport hack for Surface/desktop Windows 8 bug
  echo "<script src=\"/js/ie10-viewport-bug-workaround.js\"></script>";
  echo "<script src=\"https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.9.3/js/bootstrap-select.min.js\"></script>";
//   echo "<script src=\"https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.9.3/js/i18n/defaults-*.min.js\"></script>";
}
