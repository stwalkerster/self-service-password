﻿{block name="header"}<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="img/favicon.ico">

    <title>Account Manager</title>

    <!-- Bootstrap core CSS -->
    <link href="{$webpath}/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{$webpath}/css/navbar.css" rel="stylesheet">
	
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

	<script src='https://www.google.com/recaptcha/api.js'></script>
  </head>

  <body>

    <div class="container">

      <!-- Static navbar -->
      <nav class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{$webpath}">Account Manager</a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
              <li><a href="https://jenkins.stwalkerster.co.uk/">Jenkins</a></li>
              <li><a href="https://phabricator.stwalkerster.co.uk/">Phabricator</a></li>
			  {if $authenticated}
				<li><a href="index.php?action=manage"><img src="https://secure.gravatar.com/avatar/{$gravatar}?s=20&d=identicon&r=pg" alt="avatar"/>&nbsp;<strong>{$name}</strong></a></li>
				<li><a href="index.php?action=logout">Log out</a></li>
			  {/if}
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>
{/block}
{block name="content"}

{/block}
{block name="footer"}
      <hr />

      <footer>
        <p>&copy; Simon Walker 2015</p>
      </footer>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="{$webpath}/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="{$webpath}/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>

</body>
</html>
{/block}
