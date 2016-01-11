<?php

  $NoWelcome = FALSE;
  
  if(isset($_SESSION['F–10 Curriculum']))
  {
    switch($_SESSION['F–10 Curriculum'])
    {
      case(1):
        unset($_SESSION['F–10 Curriculum']);
        $NoWelcome = TRUE;
        include DIR_SESSION.'acf10-1.php';
        break;
      case(2):
        unset($_SESSION['F–10 Curriculum']);
        $NoWelcome = TRUE;
        include DIR_SESSION.'acf10-2.php';
        break;
      case(3):
        unset($_SESSION['F–10 Curriculum']);
        $NoWelcome = TRUE;
        include DIR_SESSION.'acf10-3.php';
        break;
      case('Specific'):
        unset($_SESSION['F–10 Curriculum']);
        $NoWelcome = TRUE;
        include DIR_SESSION.'acf10-specific.php';
        break;
      default:
        break;
    }
  }
  
  if(isset($_SESSION['cont']))
  {
    $NoWelcome = TRUE;
    include DIR_SESSION.'cont.php';
    unset($_SESSION['cont']);
  }
  
  if(isset($_SESSION['Gc']))
  {
    unset($_SESSION['Gc']);
    $NoWelcome = TRUE;
    include DIR_SESSION.'gc.php';
  }
  if(isset($_SESSION['Ccp']))
  {
    unset($_SESSION['Ccp']);
    $NoWelcome = TRUE;
    include DIR_SESSION.'ccp.php';
  }
  if(isset($_SESSION['GcTagging']))
  {
    unset($_SESSION['GcTagging']);
    $NoWelcome = TRUE;
    include DIR_SESSION.'gctagging.php';
  }
  if(isset($_SESSION['CcpTagging']))
  {
    unset($_SESSION['CcpTagging']);
    $NoWelcome = TRUE;
    include DIR_SESSION.'ccptagging.php';
  }
  
  if(!$NoWelcome)
  {
    $NameFirst = select_from('NameFirst',"framy_Personal WHERE PersonalId = {$_SESSION['PersonalId']}",[]);
    $EchoWelcome = 1;
    if($EchoWelcome)
    {
?>
      <p class="lead">Welcome, <?php echo $NameFirst; ?></p>
      <h1>The Australian Curriculum</h1>
      <h2>F–10 Curriculum</h2>
      <div class="alert alert-warning" role="alert">
        <p>Until otherwise mentioned, this website incorporates version 8.1 of the Australian Curriculum. If you want to use version 7.5, please see <a href="http://www.australiancurriculum.edu.au/home/whats-changed">What’s changed</a> to see what’s different about it.</p>
      </div>
      <div class="row">
        <div class="col-sm-6">
          <div class="list-group">
            <div class="list-group-item active">Specific aspects</div>
            <div class="list-group-item">
              <p>For each subject and level, view the:</p>
              <ul>
                <li>Level description</li>
                <li>Content descriptions<br />
                    (with elaborations and any associated general capabilities and cross-curriculum priorities and their subelements)</li>
                <li>Achievement standard</li>
              </ul>
            </div>
            <a href="/?nav=acf10-1" class="text-right list-group-item list-group-item-info">Go&emsp;<span class="glyphicon glyphicon-chevron-right"></span></a>
            <!--
            <div class="list-group-item">
              <p>Before going here, you’ll need to select a subject and a year level.</p>
            </div>
            -->
          </div>
        </div>
        <div class="col-sm-6">
          <div class="list-group">
            <div class="list-group-item active">Common aspects</div>
            <div class="list-group-item">
              <p>View the general capabilities and cross-curriculum priorities common to all learning areas.</p>
            </div>
            <a href="/?nav=gc" class="text-right list-group-item list-group-item-info">General capabilities&emsp;<span class="glyphicon glyphicon-chevron-right"></span></a>
            <a href="/?nav=ccp" class="text-right list-group-item list-group-item-info">Cross-curriculum priorities&emsp;<span class="glyphicon glyphicon-chevron-right"></span></a>
            <div class="list-group-item">
              <p>View the general capabilities learning continua.</p>
            </div>
            <a href="/?nav=cont&gc=lit" class="text-right list-group-item list-group-item-info">Literacy&emsp;<span class="glyphicon glyphicon-chevron-right"></span></a>
            <a href="/?nav=cont&gc=num" class="text-right list-group-item list-group-item-info">Numeracy&emsp;<span class="glyphicon glyphicon-chevron-right"></span></a>
            <a href="/?nav=cont&gc=ict" class="text-right list-group-item list-group-item-info">Information and Communication Technology (ICT) Capability&emsp;<span class="glyphicon glyphicon-chevron-right"></span></a>
            <a href="/?nav=cont&gc=cct" class="text-right list-group-item list-group-item-info">Critical and Creative Thinking&emsp;<span class="glyphicon glyphicon-chevron-right"></span></a>
            <a href="/?nav=cont&gc=psc" class="text-right list-group-item list-group-item-info">Personal and Social Capability&emsp;<span class="glyphicon glyphicon-chevron-right"></span></a>
            <a href="/?nav=cont&gc=eu" class="text-right list-group-item list-group-item-info">Ethical Understanding&emsp;<span class="glyphicon glyphicon-chevron-right"></span></a>
            <a href="/?nav=cont&gc=icu" class="text-right list-group-item list-group-item-info">Intercultural Understanding&emsp;<span class="glyphicon glyphicon-chevron-right"></span></a>
          </div>
        </div>
      </div>
      <!--
      <div class="row">
        <div class="col-sm-6">
          <div class="list-group">
            <div class="list-group-item active">Subject</div>
            <?php
              $Connection = get_connection();
              $Q = "SELECT hLearningArea,LearningArea FROM ac_LearningAreas ORDER BY LearningArea";
              $S = $Connection->query($Q);
              foreach($S as $Row)
              {
                echo "<div class=\"list-group-item\">{$Row['learningarea']}</div>";
              }
            ?>
          </div>
        </div>
      </div>
      -->
<?php
    }
  }