<?php

$Connection = get_connection();

?>

<h2>Cross curriculum priorities</h2>

<?php

$Q = "SELECT GcCcp,GcCcpName FROM ac_GcsCcps JOIN ac_CrossCurriculumPriorities ON CcpShort = GcCcp ORDER BY TagOrd";
$S = $Connection->prepare($Q);
$S->execute();
foreach($S as $Row)
{
  echo "<h3>{$Row['gcccpname']}</h3>";
  $Q1 = "SELECT hKeyConcept,KeyConcept FROM ac_KeyConcepts WHERE CcpShort = :a ORDER BY KeyOrd";
  $S1 = $Connection->prepare($Q1);
  $S1->bindValue(':a',$Row['gcccp'],PDO::PARAM_STR);
  $S1->execute();
  foreach($S1 as $Row1)
  {
    echo "<h4>{$Row1['keyconcept']}</h4>";
    $Q2 = "SELECT OrganisingIdea,OiCode FROM ac_OrganisingIdeas WHERE CcpShort = :a AND hKeyConcept = :b";
    $S2 = $Connection->prepare($Q2);
    $S2->bindValue(':a',$Row['gcccp'],PDO::PARAM_STR);
    $S2->bindValue(':b',$Row1['hkeyconcept'],PDO::PARAM_STR);
    $S2->execute();
    echo "<dl class=\"dl-horizontal\">";
    foreach($S2 as $Row2)
    {
      echo "<dt>{$Row['gcccp']} {$Row2['oicode']}</dt>";
      echo "<dd>{$Row2['organisingidea']}</dd>";
    }
    echo "</dl>";
  }
}

?>
