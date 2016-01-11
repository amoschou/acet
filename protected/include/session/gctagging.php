<?php

$a = explode(':',$_SESSION['hBroadPigeonhole']);

$hBroadPigeonhole = $_SESSION['hBroadPigeonhole'];
unset($_SESSION['hBroadPigeonhole']);
$hArrayBroadPigeonhole = explode(':',$hBroadPigeonhole);
$hSubject = $hArrayBroadPigeonhole[0];
$hPathway = $hArrayBroadPigeonhole[1];
$hSequence = $hArrayBroadPigeonhole[2];
$hLevel = $hArrayBroadPigeonhole[3];

$Connection = get_connection();
$qq0 = 'SELECT
          Subject,
          Pathway,
          Sequence,
          Level
        FROM
          ac_r_BroadPigeonholes
          NATURAL JOIN
          ac_Subjects
          NATURAL JOIN
          ac_Pathways
          NATURAL JOIN
          ac_Sequences
          NATURAL JOIN
          ac_Levels
        WHERE
          hSubject = :a AND
          hPathway = :b AND
          hSequence = :c AND
          hLevel = :d';
$ss0 = $Connection->prepare($qq0);
$ss0->bindValue(':a',$hSubject,PDO::PARAM_STR);
$ss0->bindValue(':b',$hPathway,PDO::PARAM_STR);
$ss0->bindValue(':c',$hSequence,PDO::PARAM_STR);
$ss0->bindValue(':d',$hLevel,PDO::PARAM_STR);
$ss0->execute();
foreach($ss0 as $rrow0)
{
  $Subject = $rrow0['subject'];
  $Pathway = $rrow0['pathway'];
  $Sequence = $rrow0['sequence'];
  $Level = $rrow0['level'];
}

echo "<h1>$Subject</h1>";
echo "<dl class=\"dl-horizontal\">";
if($Pathway !== '')
{
  echo "<dt>Pathway</dt>";
  echo "<dd>$Pathway</dd>";
}
if($Sequence !== '')
{
  echo "<dt>Sequence</dt>";
  echo "<dd>$Sequence</dd>";
}
echo "<dt>Level</dt>";
echo "<dd>$Level</dd>";
echo "</dl>";

echo "<h2>General capability and Cross-curriculum priority tagging for content descriptions</h2>";

echo "<p>A ✓ indicates that the content description has at least one subelement of the general capability or has the cross-curriculum priority attached.</p>";
// echo "<p>A (✓) indicates the same for one of its elaborations.</p>";

// FIXME: Remove the hard coding for the 10 GCs and CCPs in these SQLs.

$Connection = get_connection();

$Q = "SELECT
        Strand AS \"Str\",
        Substrand AS \"Sub\",
        Organiser AS \"Org\",
        CdCode AS \"CD code\",
        LIT AS \"LIT\",
        NUM AS \"NUM\",
        ICT AS \"ICT\",
        CCT AS \"CCT\",
        PSC AS \"PSC\",
        EU AS \"EU\",
        ICU AS \"ICU\",
        INDG AS \"INDG\",
        ASIA AS \"ASIA\",
        SUST AS \"SUST\"
      FROM
        ac_v_crosstab_cd_gcccptagging
        NATURAL RIGHT JOIN
        ac_ContentDescriptions
        NATURAL JOIN
        ac_r_ContentDescriptions
        NATURAL JOIN
        ac_Strands
        NATURAL JOIN
        ac_r_Strands
        NATURAL JOIN
        ac_Substrands
        NATURAL JOIN
        ac_r_Substrands
        NATURAL JOIN
        ac_Organisers
        NATURAL JOIN
        ac_r_Organisers
      WHERE
        hSubject = :a
        AND
        hPathway = :b
        AND
        hSequence = :c
        AND
        hLevel = :d
      ORDER BY
        StrOrd,
        SubOrd,
        OrgOrd,
        CdOrd";
$S = $Connection->prepare($Q);
$S->bindValue(':a',$a[0],PDO::PARAM_STR);
$S->bindValue(':b',$a[1],PDO::PARAM_STR);
$S->bindValue(':c',$a[2],PDO::PARAM_STR);
$S->bindValue(':d',$a[3],PDO::PARAM_STR);
$S->execute();
dump_result($S,'table-bordered table-condensed');

echo "<h2>General capability and Cross-curriculum priority tagging for elaborations</h2>";


echo "<p>A ✓ indicates that the elaboration has at least one subelement of the general capability or has the cross-curriculum priority attached.</p>";

$Q = "SELECT
        Strand AS \"Str\",
        Substrand AS \"Sub\",
        Organiser AS \"Org\",
        CdCode AS \"CD code\",
        ElCode AS \"El code\",
        LIT AS \"LIT\",
        NUM AS \"NUM\",
        ICT AS \"ICT\",
        CCT AS \"CCT\",
        PSC AS \"PSC\",
        EU AS \"EU\",
        ICU AS \"ICU\",
        INDG AS \"INDG\",
        ASIA AS \"ASIA\",
        SUST AS \"SUST\"
      FROM
        ac_v_crosstab_el_gcccptagging
        NATURAL RIGHT JOIN
        ac_Elaborations
        NATURAL RIGHT JOIN
        ac_ContentDescriptions
        NATURAL JOIN
        ac_r_ContentDescriptions
        NATURAL JOIN
        ac_Strands
        NATURAL JOIN
        ac_r_Strands
        NATURAL JOIN
        ac_Substrands
        NATURAL JOIN
        ac_r_Substrands
        NATURAL JOIN
        ac_Organisers
        NATURAL JOIN
        ac_r_Organisers
      WHERE
        hSubject = :a
        AND
        hPathway = :b
        AND
        hSequence = :c
        AND
        hLevel = :d
      ORDER BY
        StrOrd,
        SubOrd,
        OrgOrd,
        CdOrd,
        ElOrd";
$S = $Connection->prepare($Q);
$S->bindValue(':a',$a[0],PDO::PARAM_STR);
$S->bindValue(':b',$a[1],PDO::PARAM_STR);
$S->bindValue(':c',$a[2],PDO::PARAM_STR);
$S->bindValue(':d',$a[3],PDO::PARAM_STR);
$S->execute();
dump_result($S,'table-bordered table-condensed');
