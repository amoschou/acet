<?php

$hNarrowSubject = $_SESSION['hNarrowSubject'];
unset($_SESSION['hNarrowSubject']);
$hArrayNarrowSubject = explode(':',$hNarrowSubject);
$hSubject = $hArrayNarrowSubject[0];
$hPathway = $hArrayNarrowSubject[1];
$hSequence = $hArrayNarrowSubject[2];

$Connection = get_connection();

$q0 = 'SELECT
         hLevel,
         Level
       FROM
         ac_r_BroadPigeonholes
         NATURAL JOIN
         ac_Levels
       WHERE
         hSubject = :a
         AND
         hPathway = :b
         AND
         hSequence = :c
       ORDER BY
         LevOrd';
$s0 = $Connection->prepare($q0);
$s0->bindValue(':a',$hSubject,PDO::PARAM_STR);
$s0->bindValue(':b',$hPathway,PDO::PARAM_STR);
$s0->bindValue(':c',$hSequence,PDO::PARAM_STR);
$s0->execute();
echo "<h2>Level</h2>";
echo "<p>";
foreach($s0 as $row0)
{
  $hLevel = $row0['hlevel'];
  $Level = $row0['level'];
  echo "<a href=\"/?nav=acf10-3&hash=$hNarrowSubject:$hLevel\" class=\"btn btn-primary\" role=\"button\">$Level</a>&emsp;";
}
echo "</p>";
