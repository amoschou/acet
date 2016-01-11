<h1>Year 8</h1>

<div class="row">
  <div class="col-sm-6">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h2 class="panel-title">Level description</h2>
      </div>
      <div class="panel-body">
        <?php
          echo select_from('LevelDesc',"ac_m_LevelDescsAchStds WHERE Level = 'Year 8'");
        ?>
      </div>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h2 class="panel-title">Achievement standard</h2>
      </div>
      <div class="panel-body">
        <?php
          echo select_from('AchStd',"ac_m_LevelDescsAchStds WHERE Level = 'Year 8'");
        ?>
      </div>
    </div>
  </div>
</div>
<h2>Content descriptions</h2>
<?php

$Connection = get_connection();
$q0 = 'SELECT Strand,hStrand FROM ac_m_Strands';
$s0 = $Connection->prepare($q0);
$s0->execute();
foreach($s0 as $row0)
{
  echo "<h3>{$row0['strand']}</h3>";
  $q1 = "SELECT Substrand,hSubstrand FROM ac_m_Substrands
         WHERE hStrand = :a";
  $s1 = $Connection->prepare($q1);
  $s1->bindValue(':a',$row0['hstrand'],PDO::PARAM_STR);
  $s1->execute();
  foreach($s1 as $row1)
  {
    echo "<h4>{$row1['substrand']}</h4>";
    $q2 = "SELECT CdId,CdCode,ContentDesc
           FROM ac_m_ContentDescriptions
           WHERE
             hSubstrand = :a
             AND
             hLevel = :b
           ORDER BY CdOrd";
    $s2 = $Connection->prepare($q2);
    $s2->bindValue(':a',$row1['hsubstrand'],PDO::PARAM_STR);
    $s2->bindValue(':b',Config::read('app.hlevel.year8'),PDO::PARAM_STR);
    $s2->execute();
    echo "<div class=\"list-group\">";
    foreach($s2 as $row2)
    {
      echo "<div class=\"list-group-item\">";
      echo "<dl>";
      echo "<dt>{$row2['cdcode']}</dt>";
      echo "<dd>{$row2['contentdesc']}<br />";
      $q3 = "SELECT
               GcCcp,
               TagOrd,
               GcCcpName,
               LOWER(TRANSLATE(GcCcpName,' ()’','-')) AS ClassName
             FROM ac_cd_gcccptagging
               NATURAL JOIN ac_gcsccps
            WHERE CdId = :a
            ORDER BY TagOrd";
      $s3 = $Connection->prepare($q3);
      $s3->bindValue(':a',$row2['cdid'],PDO::PARAM_STR);
      $s3->execute();
      echo "<div class=\"btn-group\" role=\"group\" aria-label=\"...\">";
      foreach($s3 as $row3)
      {
        echo "<div class=\"btn-group\" role=\"group\" aria-label=\"...\">";
        echo "<button class=\"btn
                              btn-default
                              dropdown-toggle\"
                       type=\"button\"
                data-toggle=\"dropdown\"
              aria-haspopup=\"true\"
              aria-expanded=\"true\">";
        echo "<span class=\"icon icon-{$row3['classname']}\"></span>";
        echo "&nbsp;".$row3['gcccp']."&nbsp;";
        echo "</button>";
        echo "<ul class=\"dropdown-menu\">";
        $q4 = "SELECT DISTINCT
                 ElementId,
                 Element,
                 ElementCode
              FROM
                ac_Subelements
                NATURAL JOIN
                ac_Elements
              WHERE
                SubelementID IN (
                  SELECT SubelementId
                  FROM ac_cd_GcSubelementTagging
                  WHERE CdId = :a)
                AND
                GcShort = :b
              ORDER BY
                ElementCode";
        $s4 = $Connection->prepare($q4);
        $s4->bindValue(':a',$row2['cdid'],PDO::PARAM_STR);
        $s4->bindValue(':b',$row3['gcccp'],PDO::PARAM_STR);
        $s4->execute();
        $NotFirst = FALSE;
        foreach($s4 as $row4)
        {
          if($NotFirst)
          {
            echo "<li role=\"separator\" class=\"divider\"></li>";
          }
          $NotFirst = TRUE;
          echo "<li class=\"dropdown-header\">{$row4['element']}</li>";
          echo "<li role=\"separator\" class=\"divider\"></li>";
          $q5 = "SELECT
                    SubelementId,
                    Subelement,
                    SubelementCode,
                    ElementCode||'.'||SubelementCode AS Code
                  FROM
                    ac_cd_GcSubelementTagging
                    NATURAL JOIN
                    ac_Subelements
                    NATURAL JOIN
                    ac_Elements
                  WHERE
                    CdId = :a
                    AND
                    ElementId = :b
                  ORDER BY
                    SubelementCode";
          $s5 = $Connection->prepare($q5);
          $s5->bindValue(':a',$row2['cdid'],PDO::PARAM_STR);
          $s5->bindValue(':b',$row4['elementid'],PDO::PARAM_STR);
          $s5->execute();
          foreach($s5 as $row5)
          {
            echo "<li><a>{$row5['code']}: {$row5['subelement']}</a></li>";
          }
        }
        echo "</ul>";
        echo "</div>";
      }
      echo "</div>";
      echo "</dd>";
      echo "</dl>";
      echo "</div>";
      $q6 = "SELECT
               ElId,
               ElCode,
               Elaboration,
               ElOrd
             FROM
               ac_Elaborations
             WHERE
               CdId = :a
             ORDER BY
               ElOrd";
      $s6 = $Connection->prepare($q6);
      $s6->bindValue(':a',$row2['cdid'],PDO::PARAM_STR);
      $s6->execute();
      foreach($s6 as $row6)
      {
        echo "<div class=\"list-group-item\">";
        echo "<dl class=\"dl-horizontal\">";
        echo "<dt>{$row6['elcode']}</dt>";
        echo "<dd>{$row6['elaboration']}<br />";
        $q7 = "SELECT
                 GcCcp,
                 TagOrd,
                 GcCcpName,
                 LOWER(TRANSLATE(GcCcpName,' ()’','-')) AS ClassName
               FROM ac_el_gcccptagging
                 NATURAL JOIN ac_gcsccps
              WHERE ElId = :a
              ORDER BY TagOrd";
        $s7 = $Connection->prepare($q7);
        $s7->bindValue(':a',$row6['elid'],PDO::PARAM_STR);
        $s7->execute();
        echo "<div class=\"btn-group\" role=\"group\" aria-label=\"...\">";
        foreach($s7 as $row7)
        {
          echo "<div class=\"btn-group\" role=\"group\" aria-label=\"...\">";
          echo "<button class=\"btn
                                btn-default
                                dropdown-toggle\"
                         type=\"button\"
                  data-toggle=\"dropdown\"
                aria-haspopup=\"true\"
                aria-expanded=\"true\">";
          echo "<span class=\"icon icon-{$row7['classname']}\"></span>";
          echo "&nbsp;".$row7['gcccp'];
          echo "</button>";
          echo "<ul class=\"dropdown-menu\">";
          $q8 = "SELECT DISTINCT
                   ElementId,
                   Element,
                   ElementCode
                FROM
                  ac_Subelements
                  NATURAL JOIN
                  ac_Elements
                WHERE
                  SubelementID IN (
                    SELECT SubelementId
                    FROM ac_cd_GcSubelementTagging
                    WHERE CdId = :a)
                  AND
                  GcShort = :b
                ORDER BY
                  ElementCode";
          $s8 = $Connection->prepare($q8);
          $s8->bindValue(':a',$row6['elid'],PDO::PARAM_STR);
          $s8->bindValue(':b',$row7['gcccp'],PDO::PARAM_STR);
          $s8->execute();
          $NotFirst = FALSE;
          foreach($s8 as $row8)
          {
            if($NotFirst)
            {
              echo "<li role=\"separator\" class=\"divider\"></li>";
            }
            $NotFirst = TRUE;
            echo "<li class=\"dropdown-header\">{$row8['element']}</li>";
            echo "<li role=\"separator\" class=\"divider\"></li>";
            $q9 = "SELECT
                      SubelementId,
                      Subelement,
                      SubelementCode,
                      ElementCode||'.'||SubelementCode AS Code
                    FROM
                      ac_cd_GcSubelementTagging
                      NATURAL JOIN
                      ac_Subelements
                      NATURAL JOIN
                      ac_Elements
                    WHERE
                      CdId = :a
                      AND
                      ElementId = :b
                    ORDER BY
                      SubelementCode";
            $s9 = $Connection->prepare($q9);
            $s9->bindValue(':a',$row6['elid'],PDO::PARAM_STR);
            $s9->bindValue(':b',$row8['elementid'],PDO::PARAM_STR);
            $s9->execute();
            foreach($s9 as $row9)
            {
              echo "<li><a>{$row9['code']}: {$row9['subelement']}</a></li>";
            }
          }
          echo "</ul>";
          echo "</div>";
        }
        echo "</div>";
        echo "</dd>";
        echo "</dl>";
        echo "</div>";
      }
    }
    echo "</div>";
  }
}
