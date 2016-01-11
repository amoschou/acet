<?php

  function dump_query($q,$array = NULL,$tableclass = NULL)
  {
    $Connection = get_connection();
    $s = $Connection->prepare($q);
    if(is_null($array))
    {
      $s->execute();
    }
    else
    {
      $s->execute($array);
    }
    return dump_result($s,$tableclass);
  }
  
  function dump_result($s,$tableclass = NULL)
  {
    return dump_old($s,$tableclass);
  }

  function dump_old($Result,$tableclass = NULL,$ahref = NULL,$ahrefreplace = NULL,$trclass = NULL,$trclassreplace = NULL)
  {
    if($Result !== FALSE)
    {
      if(!is_null($tableclass))
      {
        $tableclass = $tableclass.' ';
      }
      echo "<table class=\"{$tableclass}table\">";
      echo '<thead><tr>';
      for($i = 0 ; $i < $Result->columnCount() ; $i++)
      {
        $c = $Result->getColumnMeta($i);
        echo '<th>'.$c['name'].'</th>';
      }
      $tbodyattributes = !is_null($ahref) ? ' data-link="row" class="rowlink"' : '';
      echo "</tr></thead><tbody$tbodyattributes>";
      foreach($Result as $Row)
      {
        $trclass2 = NULL;
        if($trclass == '%DANGERSUCCESS%')
        {
          $trclass2 = str_replace('$','',$Row['Amount owing']) > 0.00 ? "danger" : "success";
        }
        if($trclass == '%Rolls:DANGER%')
        {
          $now = new DateTime("now");
          $trclass2 = date_create_from_format('D, j/m/Y',$Row['Date']) < $now ? "danger" : "";
        }
        $trattributes = !is_null($trclass2) ? " class=\"$trclass2\"" : '';
        echo "<tr$trattributes>";
        for($i = 0 ; $i < $Result->columnCount() ; $i++)
        {
          echo '<td>';
          if($i == 0 && !is_null($ahref))
          {
            if(!is_null($ahrefreplace))
            {
              $ahref2 = str_replace('@',${$ahrefreplace[0]}[$ahrefreplace[1]],$ahref.$ahrefextra);
            }
            else
            {
              $ahref2 = $ahref;
            }
            echo "<a href=\"{$ahref2}\"></a>";
          }
          echo $Row[$i];
          echo '</td>';
        }
        echo '</tr>';
      }
      echo '</tbody></table>';
    }
    else
    {
      echo '<p>Failed query</p>';
    }
  }