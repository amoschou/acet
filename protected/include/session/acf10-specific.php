<?php

include DIR_SESSION.'acf10-functions.php';

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

?>

<div class="row">
  <div class="col-sm-6">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h2 class="panel-title">Level description</h2>
      </div>
      <div class="panel-body">
        <?php
          echo select_from('LevelDesc',
                           "ac_LevelDescsAchStds
                            WHERE
                              hSubject = ?
                              AND
                              hPathway = ?
                              AND
                              hSequence = ?
                              AND
                              hLevel = ?",
                            $hArrayBroadPigeonhole);
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
          echo select_from('AchStd',
                           "ac_LevelDescsAchStds
                            WHERE
                              hSubject = ?
                              AND
                              hPathway = ?
                              AND
                              hSequence = ?
                              AND
                              hLevel = ?",
                            $hArrayBroadPigeonhole);
        ?>
      </div>
    </div>
  </div>
</div>

<h2>Content descriptions</h2>

<?php

$S = $Connection->prepare("SELECT GcShort FROM ac_GeneralCapabilities");
$S->execute();
$GcShortArray = $S->fetchAll(PDO::FETCH_COLUMN,0);
$S = $Connection->prepare("SELECT CcpShort FROM ac_CrossCurriculumPriorities");
$S->execute();
$CcpShortArray = $S->fetchAll(PDO::FETCH_COLUMN,0);

$s0 = acf10_get_strands($hSubject);
foreach($s0 as $row0)
{
  $Strand = $row0['strand'];
  $hStrand = $row0['hstrand'];
  if(num_contents('Strand','ContentDesc',$hSubject,$hPathway,$hSequence,$hLevel,$hStrand))
  {
    if($Strand !== '')
    {
      echo "<h3><small>Strand</small> $Strand</h3>";
    }
    $s1 = acf10_get_substrands($hSubject,$hStrand);
    foreach($s1 as $row1)
    {
      $Substrand = $row1['substrand'];
      $hSubstrand = $row1['hsubstrand'];
      if(num_contents('Substrand','ContentDesc',$hSubject,$hPathway,$hSequence,$hLevel,$hStrand,$hSubstrand))
      {
        if($Substrand !== '')
        {
          echo "<h4><small>Substrand</small> $Substrand</h4>";
        }
        $s2 = acf10_get_organisers($hSubject,$hStrand,$hSubstrand);
        foreach($s2 as $row2)
        {
          $Organiser = $row2['organiser'];
          $hOrganiser = $row2['horganiser'];
          if(num_contents('Organiser','ContentDesc',$hSubject,$hPathway,$hSequence,$hLevel,$hStrand,$hSubstrand,$hOrganiser))
          {
            if($Organiser !== '')
            {
              echo "<h5><small>Organiser</small> $Organiser</h4>";
            }
            $hNarrowPigeonhole = '';
            $hNarrowPigeonhole .= $hSubject;
            $hNarrowPigeonhole .= ':'.$hPathway;
            $hNarrowPigeonhole .= ':'.$hSequence;
            $hNarrowPigeonhole .= ':'.$hLevel;
            $hNarrowPigeonhole .= ':'.$hStrand;
            $hNarrowPigeonhole .= ':'.$hSubstrand;
            $hNarrowPigeonhole .= ':'.$hOrganiser;
            $s3 = acf10_get_contentdescriptions($hNarrowPigeonhole);
            echo "<div class=\"list-group\">";
            foreach($s3 as $row3)
            {
              $CdId = $row3['cdid'];
              $CdCode = $row3['cdcode'];
              $ContentDesc = $row3['contentdesc'];
              echo "<div class=\"list-group-item list-group-item-success\">";
              echo "<dl>";
              echo "<dt>$CdCode</dt>";
              echo "<dd>$ContentDesc";
              $s4 = acf10_get_gcccps($CdId,'Cd');
              if(num_contents('ContentDesc','GcCcp',$CdId))
              {
                echo "<br />";
                echo "<div class=\"btn-group\" role=\"group\" aria-label=\"...\">";
                foreach($s4 as $row4)
                {
                  $GcCcp = $row4['gcccp'];
                  echo "<div
                           class=\"btn-group\"
                           role=\"group\"
                           aria-label=\"...\">";
                  if(in_array($GcCcp,$GcShortArray,TRUE))
                  {
                    $ButtonColour = 'info';
                  }
                  else
                  {
                    if(in_array($GcCcp,$CcpShortArray,TRUE))
                    {
                      $ButtonColour = 'warning';
                    }
                    else
                    {
                      $ButtonColour = 'default';
                    }
                  }
                  echo "<button class=\"btn
                                        btn-$ButtonColour
                                        dropdown-toggle\"
                                 type=\"button\"
                          data-toggle=\"dropdown\"
                        aria-haspopup=\"true\"
                        aria-expanded=\"true\">";
                  echo "<span class=\"icon icon-{$row4['classname']}\"></span>";
                  echo "&nbsp;".$GcCcp;
                  echo "</button>";
                  echo "<ul class=\"dropdown-menu\">";
                  $s5 = acf10_get_elements($CdId,$GcCcp,'Cd');
                  $NotFirst = FALSE;
                  foreach($s5 as $row5)
                  {
                    $Element = $row5['element'];
                    $ElementId = $row5['elementid'];
                    if($NotFirst)
                    {
                      echo "<li role=\"separator\" class=\"divider\"></li>";
                    }
                    $NotFirst = TRUE;
                    echo "<li class=\"dropdown-header\">$Element</li>";
                    echo "<li role=\"separator\" class=\"divider\"></li>";
                    $s6 = acf10_get_subelements($CdId,$ElementId,'Cd');
                    foreach($s6 as $row6)
                    {
                      echo "<li><a>{$row6['code']}: {$row6['subelement']}</a></li>";
                    } // foreach($s6 as $row6)
                  } // foreach($5 as $row5)
                  echo "</ul>";
                  echo "</div>";
                } // foreach($s4 as $row4)
                echo "</div>";
              }
              echo "</dd>";
              echo "</dl>";
              echo "</div>";
              $s7 = acf10_get_elaborations($CdId);
              foreach($s7 as $row7)
              {
                $ElId = $row7['elid'];
                $ElCode = $row7['elcode'];
                $Elaboration = $row7['elaboration'];
                echo "<div class=\"list-group-item\">";
                echo "<dl class=\"dl-horizontal\">";
                echo "<dt>$ElCode</dt>";
                echo "<dd>$Elaboration";
                $s8 = acf10_get_gcccps($ElId,'El');
                if(num_contents('Elaboration','GcCcp',$ElId))
                {
                  echo "<br />";
                  echo "<div class=\"btn-group\" role=\"group\" aria-label=\"...\">";
                  foreach($s8 as $row8)
                  {
                    $GcCcp = $row8['gcccp'];
                    echo "<div
                             class=\"btn-group\"
                             role=\"group\"
                             aria-label=\"...\">";
                    if(in_array($GcCcp,$GcShortArray,TRUE))
                    {
                      $ButtonColour = 'info';
                    }
                    else
                    {
                      if(in_array($GcCcp,$CcpShortArray,TRUE))
                      {
                        $ButtonColour = 'warning';
                      }
                      else
                      {
                        $ButtonColour = 'default';
                      }
                    }
                    echo "<button class=\"btn
                                          btn-$ButtonColour
                                          dropdown-toggle\"
                                   type=\"button\"
                            data-toggle=\"dropdown\"
                          aria-haspopup=\"true\"
                          aria-expanded=\"true\">";
                    echo "<span class=\"icon icon-{$row8['classname']}\"></span>";
                    echo "&nbsp;".$GcCcp;
                    echo "</button>";
                    echo "<ul class=\"dropdown-menu\">";
                    $s9 = acf10_get_elements($ElId,$GcCcp,'El');
                    $NotFirst = FALSE;
                    foreach($s9 as $row9)
                    {
                      $Element = $row9['element'];
                      $ElementId = $row9['elementid'];
                      if($NotFirst)
                      {
                        echo "<li role=\"separator\" class=\"divider\"></li>";
                      }
                      $NotFirst = TRUE;
                      echo "<li class=\"dropdown-header\">$Element</li>";
                      echo "<li role=\"separator\" class=\"divider\"></li>";
                      $s10 = acf10_get_subelements($ElId,$ElementId,'El');
                      foreach($s10 as $row10)
                      {
                        echo "<li><a>{$row10['code']}: {$row10['subelement']}</a></li>";
                      } // foreach($s10 as $row10)
                    } // foreach($9 as $row9)
                    echo "</ul>";
                    echo "</div>";
                  } // foreach($s8 as $row8)
                  echo "</div>";
                }
                echo "</dd>";
                echo "</dl>";
                echo "</div>";



            
            
              } // foreach($s7 as $row7)
          
          
          
            } // foreach($s3 as $row3)
            echo "</div>";
          }
        }
      } // foreach($s2 as $row2)
    } // foreach($s1 as $row1)
  }
} // foreach($s0 as $row0)



