<?php

$Connection = get_connection();

$q0 = 'SELECT
        hLearningArea,
        LearningArea
      FROM
        ac_LearningAreas
      ORDER BY
        LearningArea';
$s0 = $Connection->prepare($q0);
$s0->execute();
foreach($s0 as $row0)
{
  echo "<h2>{$row0['learningarea']}</h2>";
  $q1 = 'SELECT
          Subject,
          Pathway,
          Sequence,
          hSubject,
          hPathway,
          hSequence
        FROM
          ac_r_sequences
          natural join
          ac_subjects
          natural join
          ac_Pathways
          natural join
          ac_sequences
          natural join
          ac_learningareas
        WHERE
          hLearningarea = :a
        ORDER BY
          Subject,
          Pathway,
          Sequence';
  $s1 = $Connection->prepare($q1);
  $s1->bindValue(':a',$row0['hlearningarea'],PDO::PARAM_STR);
  $s1->execute();
  echo "<p>";
  foreach($s1 as $row1)
  {
    $subject = $row1['subject'];
    $pathway = $row1['pathway'];
    $sequence = $row1['sequence'];
    $hsubject = $row1['hsubject'];
    $hpathway = $row1['hpathway'];
    $hsequence = $row1['hsequence'];
    $longhash = "$hsubject:$hpathway:$hsequence";
    if($pathway === '' && $sequence === '')
    {
      echo "<a href=\"/?nav=acf10-2&hash=$longhash\" class=\"btn btn-primary\" role=\"button\">$subject</a>&emsp;";
    }
    else
    {
      if($sequence === '')
      {
        echo "<a href=\"/?nav=acf10-2&hash=$longhash\" class=\"btn btn-primary\" role=\"button\">$subject ($pathway)</a>&emsp;";
      }
      else
      {
        if($pathway === '')
        {
          echo "<a href=\"/?nav=acf10-2&hash=$longhash\" class=\"btn btn-primary\" role=\"button\">$subject ($sequence)</a>&emsp;";
        }
        else
        {
          echo "<a href=\"/?nav=acf10-2&hash=$longhash\" class=\"btn btn-primary\" role=\"button\">$subject ($pathway, $sequence)</a>&emsp;";
        }
      }
    }
  }
  echo "</p>";
}
