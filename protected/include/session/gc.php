<?php

$Connection = get_connection();

?>

<h2>General capabilities</h2>

<?php

$Q = "SELECT GcCcp,GcCcpName FROM ac_GcsCcps JOIN ac_GeneralCapabilities ON GcShort = GcCcp ORDER BY TagOrd";
$S = $Connection->prepare($Q);
$S->execute();
foreach($S as $Row)
{
  echo "<h3>{$Row['gcccpname']}</h3>";
  echo "<p><a class=\"btn btn-primary\" href=\"/?nav=cont&gc={$Row['gcccp']}\">View the learning continuum&emsp;<span class=\"glyphicon glyphicon-chevron-right\"></span></a></p>";
  $Q2 = "SELECT ElementId,Element,ElementCode FROM ac_elements WHERE GcShort = :a ORDER BY ElementCode";
  $S2 = $Connection->prepare($Q2);
  $S2->bindValue(':a',$Row['gcccp'],PDO::PARAM_STR);
  $S2->execute();
  foreach($S2 as $Row2)
  {
    echo "<h4>{$Row2['element']}</h4>";
    $Q3 = "SELECT SubelementId,Subelement,Subelementcode FROM ac_subelements WHERE ElementId = :a ORDER BY SubelementCode";
    $S3 = $Connection->prepare($Q3);
    $S3->bindValue(':a',$Row2['elementid'],PDO::PARAM_STR);
    $S3->execute();
    echo "<dl class=\"dl-horizontal\">";
    foreach($S3 as $Row3)
    {
      echo "<dt>{$Row['gcccp']} {$Row2['elementcode']}.{$Row3['subelementcode']}</dt>";
      echo "<dd>{$Row3['subelement']}</dd>";
    }
    echo "</dl>";
  }
}

?>