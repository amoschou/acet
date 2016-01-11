<?php

$Gc = strtoupper($_SESSION['cont']);
$Connection = get_connection();

$LongName = select_from('GeneralCapability','ac_GeneralCapabilities WHERE GcShort = ?',array($Gc));

echo "<div class=\"alert alert-info\">This page is ugly, I know. But it provides the information in an easy to use table. I’m working on fixing this.</div>";

echo "<h1>$LongName</h1>";
echo "<h2>Learning Continuum</h2>";


echo "<p>Typically, by the end of Foundation Year, students achieve Level 1.<br />";
echo "Typically, by the end of Year 2, students achieve Level 2.<br />";
echo "Typically, by the end of Year 4, students achieve Level 3.<br />";
echo "Typically, by the end of Year 6, students achieve Level 4.<br />";
echo "Typically, by the end of Year 8, students achieve Level 5.<br />";
echo "Typically, by the end of Year 10, students achieve Level 6.</p>";

$Q = "
SELECT
  Code AS \"Subelement\",
  Level1 AS \"Level 1\",
  Level1a AS \"Level 1a\",
  Level1b AS \"Level 1b\",
  Level1c AS \"Level 1c\",
  Level1d AS \"Level 1d\",
  Level1e AS \"Level 1e\",
  Level2 AS \"Level 2\",
  Level3 AS \"Level 3\",
  Level4 AS \"Level 4\",
  Level5 AS \"Level 5\",
  Level6 AS \"Level 6\"
FROM
  CROSSTAB
  (
    '
      SELECT
        HumanCode,
        ContinuaLevel,
        Point
      FROM
        ac_ContinuaPoints
        JOIN
        ac_Subelements_HumanCode
         ON subelhumancode = humancode
      WHERE
        HumanCode LIKE ''$Gc%''
      ORDER BY
        HumanCode
    ',
    '
      SELECT
        ContinuaLevel
      FROM
        ac_ContinuaLevels
      ORDER BY
        ContLevOrd
    '
  ) AS CT
    (
      Code TEXT,
      Level1 TEXT,
      Level1a TEXT,
      Level1b TEXT,
      Level1c TEXT,
      Level1d TEXT,
      Level1e TEXT,
      Level2 TEXT,
      Level3 TEXT,
      Level4 TEXT,
      Level5 TEXT,
      Level6 TEXT
    )
  JOIN
  ac_Subelements_HumanCode
    ON Code = SubelHumanCode
ORDER BY
  TagOrd,
  ElementCode,
  SubelementCode
";

$S = $Connection->prepare($Q);
// $S->bindValue(':a',$Gc."%",PDO::PARAM_STR);
$S->execute();
dump_result($S,'table-bordered table-condensed');

