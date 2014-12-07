{extends file="main.tpl"}
{block name="content"}
	  <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h1>Welcome!</h1>
        <p>Log in to change your password, password recovery options, and information.</p>
		<p>Forgotten your password? You can reset that here too.</p>
		<p>New User? Create an account!</p>
        <div class="container">
			<div class="row">
				<div class="col-md-4"><a class="btn btn-lg btn-primary btn-block" href="index.php?action=login" role="button" disabled>Log in &raquo;</a></div>
				<div class="col-md-4"><a class="btn btn-lg btn-warning btn-block" href="index.php?action=reset" role="button">Reset password &raquo;</a></div>
				<div class="col-md-4"><a class="btn btn-lg btn-success btn-block" href="index.php?action=create" role="button">Create Account &raquo;</a></div>
			</div>
		</div>
      </div>
{/block}