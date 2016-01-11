<?php

switch($_SESSION['nav'])
{
  case(''):
    break;
  case('guest');
    unset($_SESSION['nav']);
    $_SESSION['LoggedIn'] = TRUE;
    $_SESSION['Email'] = '';
    $_SESSION['PersonalId'] = 2;
    header('Location: /');
    exit();
    break;
  case('copyright');
    unset($_SESSION['nav']);
    $_SESSION['Copyright'] = TRUE;
    header('Location: /');
    exit();
    break;
  case('cont');
    unset($_SESSION['nav']);
    $_SESSION['cont'] = $_GET['gc'];
    header('Location: /');
    exit();
    break;
  case('gc');
    unset($_SESSION['nav']);
    $_SESSION['Gc'] = 1;
    header('Location: /');
    exit();
    break;
  case('ccp');
    unset($_SESSION['nav']);
    $_SESSION['Ccp'] = 1;
    header('Location: /');
    exit();
    break;
  case('gctagging');
    unset($_SESSION['nav']);
    $_SESSION['GcTagging'] = 1;
    header('Location: /');
    exit();
    break;
  case('ccptagging');
    unset($_SESSION['nav']);
    $_SESSION['CcpTagging'] = 1;
    header('Location: /');
    exit();
    break;
  case('acf10-1');
    unset($_SESSION['nav']);
    $_SESSION['F–10 Curriculum'] = 1;
    header('Location: /');
    exit();
    break;
  case('acf10-2');
    unset($_SESSION['nav']);
    $_SESSION['F–10 Curriculum'] = 2;
    $_SESSION['hNarrowSubject'] = strtr($_GET['hash'],' ','+');
    header('Location: /');
    exit();
    break;
  case('acf10-3');
    unset($_SESSION['nav']);
    $_SESSION['F–10 Curriculum'] = 3;
    $_SESSION['hBroadPigeonhole'] = strtr($_GET['hash'],' ','+');
    header('Location: /');
    exit();
    break;
  case('acf10-specific');
    unset($_SESSION['nav']);
    $_SESSION['F–10 Curriculum'] = 'Specific';
    header('Location: /');
    exit();
    break;
  case('endsession'):
    get_outa_here();
    break;
  default:
    break;
}