<?php

function acf10_get_strands($hSubject)
{
  $Connection = get_connection();
  $q = 'SELECT Strand,hStrand
        FROM ac_Strands
        NATURAL JOIN ac_r_Strands
        WHERE hSubject = :a
        ORDER BY StrOrd';
  $s = $Connection->prepare($q);
  $s->bindValue(':a',$hSubject,PDO::PARAM_STR);
  $s->execute();
  return $s;
}

function acf10_get_substrands($hSubject,$hStrand)
{
  $Connection = get_connection();
  $q = 'SELECT
           Substrand,
           hSubstrand
        FROM
          ac_Substrands
        NATURAL JOIN
          ac_r_Substrands
        WHERE
          hSubject = :a
          AND
          hStrand = :b
        ORDER BY
          SubOrd';
  $s = $Connection->prepare($q);
  $s->bindValue(':a',$hSubject,PDO::PARAM_STR);
  $s->bindValue(':b',$hStrand,PDO::PARAM_STR);
  $s->execute();
  return $s;
}

function acf10_get_organisers($hSubject,$hStrand,$hSubstrand)
{
  $Connection = get_connection();
  $q = 'SELECT
           Organiser,
           hOrganiser
        FROM
          ac_Organisers
        NATURAL JOIN
          ac_r_Organisers
        WHERE
          hSubject = :a
          AND
          hStrand = :b
          AND
          hSubstrand = :c
        ORDER BY
          OrgOrd';
  $s = $Connection->prepare($q);
  $s->bindValue(':a',$hSubject,PDO::PARAM_STR);
  $s->bindValue(':b',$hStrand,PDO::PARAM_STR);
  $s->bindValue(':c',$hSubstrand,PDO::PARAM_STR);
  $s->execute();
  return $s;
}

function acf10_get_contentdescriptions($hNarrowPigeonhole)
{
  $a = explode(':',$hNarrowPigeonhole);
  $Connection = get_connection();
  $q = "SELECT
          CdId,
          CdCode,
          ContentDesc,
          CdOrd
        FROM
          ac_ContentDescriptions
          NATURAL JOIN
          ac_r_ContentDescriptions
        WHERE
          hSubject = :a AND
          hPathway = :b AND
          hSequence = :c AND
          hLevel = :d AND
          hStrand = :e AND
          hSubstrand = :f AND
          hOrganiser = :g
        ORDER BY
          CdOrd";
  $s = $Connection->prepare($q);
  $s->bindValue(':a',$a[0],PDO::PARAM_STR);
  $s->bindValue(':b',$a[1],PDO::PARAM_STR);
  $s->bindValue(':c',$a[2],PDO::PARAM_STR);
  $s->bindValue(':d',$a[3],PDO::PARAM_STR);
  $s->bindValue(':e',$a[4],PDO::PARAM_STR);
  $s->bindValue(':f',$a[5],PDO::PARAM_STR);
  $s->bindValue(':g',$a[6],PDO::PARAM_STR);
  $s->execute();
  return $s;
}


function acf10_get_gcccps($CdOrElId,$CdOrEl)
{
  $Connection = get_connection();
  $q = "SELECT
          GcCcp,
          TagOrd,
          GcCcpName,
          LOWER(TRANSLATE(GcCcpName,' ()’','-')) AS ClassName
        FROM ac_{$CdOrEl}_gcccptagging
          NATURAL JOIN ac_gcsccps
        WHERE {$CdOrEl}Id = :a
        ORDER BY TagOrd";
  $s = $Connection->prepare($q);
  $s->bindValue(':a',$CdOrElId,PDO::PARAM_STR);
  $s->execute();
  return $s;
}

function acf10_get_elements($CdOrElId,$GcCcp,$CdOrEl)
{
  $Connection = get_connection();
  $q = "SELECT DISTINCT
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
            FROM ac_{$CdOrEl}_GcSubelementTagging
            WHERE {$CdOrEl}Id = :a)
          AND
          GcShort = :b
        ORDER BY
          ElementCode";
  $s = $Connection->prepare($q);
  $s->bindValue(':a',$CdOrElId,PDO::PARAM_STR);
  $s->bindValue(':b',$GcCcp,PDO::PARAM_STR);
  $s->execute();
  return $s;
}

function acf10_get_subelements($CdId,$ElementId,$CdOrEl)
{
  $Connection = get_connection();
  $q = "SELECT
            SubelementId,
            Subelement,
            SubelementCode,
            ElementCode||'.'||SubelementCode AS Code
          FROM
            ac_{$CdOrEl}_GcSubelementTagging
            NATURAL JOIN
            ac_Subelements
            NATURAL JOIN
            ac_Elements
          WHERE
            {$CdOrEl}Id = :a
            AND
            ElementId = :b
          ORDER BY
            SubelementCode";
  $s = $Connection->prepare($q);
  $s->bindValue(':a',$CdId,PDO::PARAM_STR);
  $s->bindValue(':b',$ElementId,PDO::PARAM_STR);
  $s->execute();
  return $s;
}

function acf10_get_elaborations($CdId)
{
  $Connection = get_connection();
  $q = "SELECT
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
  $s = $Connection->prepare($q);
  $s->bindValue(':a',$CdId,PDO::PARAM_STR);
  $s->execute();
  return $s;
}


//  'Substrand','ContentDesc',$hSubject,$hStrand,$hSubstrand

function num_contents($Container,$Contents,$h1 = NULL,$h2 = NULL,$h3 = NULL,$h4 = NULL,$h5 = NULL,$h6 = NULL,$h7 = NULL)
{
  $Connection = get_connection();
  switch($Container)
  {
    case('ContentDesc'):
      switch($Contents)
      {
        case('GcCcp'):
          $Q = "SELECT COUNT(*) FROM ac_cd_GcCcpTagging where CdId = :a";
          $S = $Connection->prepare($Q);
          $S->bindValue(':a',$h1,PDO::PARAM_STR);
          $S->execute();
          return $S->fetchColumn();
          break;
        default:
          break;
      }
      break;
    case('Elaboration'):
      switch($Contents)
      {
        case('GcCcp'):
          $Q = "SELECT COUNT(*) FROM ac_el_GcCcpTagging where ElId = :a";
          $S = $Connection->prepare($Q);
          $S->bindValue(':a',$h1,PDO::PARAM_STR);
          $S->execute();
          return $S->fetchColumn();
          break;
        default:
          break;
      }
      break;
    case('Substrand'):
      switch($Contents)
      {
        case('ContentDesc'):
          $Q = "
                SELECT COUNT(*)
                FROM
                  ac_ContentDescriptions
                  NATURAL JOIN
                  ac_r_ContentDescriptions
                WHERE
                  hSubject = :a
                  AND
                  hPathway = :b
                  AND
                  hSequence = :c
                  AND
                  hLevel = :d
                  AND
                  hStrand = :e
                  AND
                  hSubstrand = :f
                ";
          $S = $Connection->prepare($Q);
          $S->bindValue(':a',$h1,PDO::PARAM_STR);
          $S->bindValue(':b',$h2,PDO::PARAM_STR);
          $S->bindValue(':c',$h3,PDO::PARAM_STR);
          $S->bindValue(':d',$h4,PDO::PARAM_STR);
          $S->bindValue(':e',$h5,PDO::PARAM_STR);
          $S->bindValue(':f',$h6,PDO::PARAM_STR);
          $S->execute();
          return $S->fetchColumn();
          break;
        default:
          break;
      }
      break;
    case('Strand'):
      switch($Contents)
      {
        case('ContentDesc'):
          $Q = "
                SELECT COUNT(*)
                FROM
                  ac_ContentDescriptions
                  NATURAL JOIN
                  ac_r_ContentDescriptions
                WHERE
                  hSubject = :a
                  AND
                  hPathway = :b
                  AND
                  hSequence = :c
                  AND
                  hLevel = :d
                  AND
                  hStrand = :e
                ";
          $S = $Connection->prepare($Q);
          $S->bindValue(':a',$h1,PDO::PARAM_STR);
          $S->bindValue(':b',$h2,PDO::PARAM_STR);
          $S->bindValue(':c',$h3,PDO::PARAM_STR);
          $S->bindValue(':d',$h4,PDO::PARAM_STR);
          $S->bindValue(':e',$h5,PDO::PARAM_STR);
          $S->execute();
          return $S->fetchColumn();
          break;
        default:
          break;
      }
      break;
    case('Organiser'):
      switch($Contents)
      {
        case('ContentDesc'):
          $Q = "
                SELECT COUNT(*)
                FROM
                  ac_ContentDescriptions
                  NATURAL JOIN
                  ac_r_ContentDescriptions
                WHERE
                  hSubject = :a
                  AND
                  hPathway = :b
                  AND
                  hSequence = :c
                  AND
                  hLevel = :d
                  AND
                  hStrand = :e
                  AND
                  hSubstrand = :f
                  AND
                  hOrganiser = :g
                ";
          $S = $Connection->prepare($Q);
          $S->bindValue(':a',$h1,PDO::PARAM_STR);
          $S->bindValue(':b',$h2,PDO::PARAM_STR);
          $S->bindValue(':c',$h3,PDO::PARAM_STR);
          $S->bindValue(':d',$h4,PDO::PARAM_STR);
          $S->bindValue(':e',$h5,PDO::PARAM_STR);
          $S->bindValue(':f',$h6,PDO::PARAM_STR);
          $S->bindValue(':g',$h7,PDO::PARAM_STR);
          $S->execute();
          return $S->fetchColumn();
          break;
        default:
          break;
      }
      break;
    default:
      break;
  }
  return NULL;
}

