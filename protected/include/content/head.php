<?php

function print_head()
{
?>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/favicon.ico">
    <title><?php echo Config::read('site.title'); ?></title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
<!--
    <link href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.6/cosmo/bootstrap.min.css" rel="stylesheet">
-->
    <link href="/css/navbar-static-top.css" rel="stylesheet">
    <link href="/css/sticky-footer.css" rel="stylesheet">
    <link href="/css/framy.css" rel="stylesheet">
    <link href="/css/icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/opt/bootstrap-select/bootstrap-select.min.css">    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
<?php
}