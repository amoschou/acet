<?php

$NameFirst = my_fix($_POST['inputNameFirst']);
$NameLast = my_fix($_POST['inputNameLast']);
$Email = my_fix($_POST['inputEmail2']);
$Blowfish = encrypt_password(random_str(16));

$Connection = get_connection();

try
{
  $Connection->beginTransaction();
  $q0 = gq_insert('framy_Personal','NameFirst,NameLast,Email',':a,:b,:c');
  $s0 = $Connection->prepare($q0);
  $s0->bindValue(':a',$NameFirst,PDO::PARAM_STR);
  $s0->bindValue(':b',$NameLast,PDO::PARAM_STR);
  $s0->bindValue(':c',$Email,PDO::PARAM_STR);
  $s0->execute();
  $s0->closeCursor();
  $PersonalId = $Connection->lastInsertId('framy_Personal_PersonalId_seq');
  
  $q1 = gq_insert('framy_Blowfish','PersonalId,Blowfish',':a,:b');
  $s1 = $Connection->prepare($q1);
  $s1->bindValue(':a',$PersonalId,PDO::PARAM_INT);
  $s1->bindValue(':b',$Blowfish,PDO::PARAM_STR);
  $s1->execute();
  $s1->closeCursor();
  
  $Connection->commit();
}
catch(Exception $e)
{
  $Connection->rollBack();
  superendsession();
  exception_error($e);
  die();
}

$_SESSION['PersonalId'] = $PersonalId;
$_SESSION['NameFirst'] = $NameFirst;
$_SESSION['NameLast'] = $NameLast;
$_SESSION['Email'] = $Email;

$_SESSION['submitCreateAccountHello'] = TRUE;
