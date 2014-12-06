{extends file="main.tpl"}
{block name="content"}
	<div class="page-header">
		<h1>Password Reset <small>Reset a forgotten or lost password.</small></h1>
	</div>

    <div class="row">
		<form class="form-horizontal" role="form">
			<div class="form-group has-success has-feedback">
				<label for="inputUsername" class="col-sm-2 control-label">Username</label>
				<div class="col-sm-10">
					<div class="input-group">
						<span class="input-group-addon"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></span>
						<input type="text" class="form-control" id="inputUsername" placeholder="Username" disabled value="{$username|escape}" />
						<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
					</div>
				</div>
			</div>
			<div class="form-group has-success has-feedback">
				<label for="inputEmail" class="col-sm-2 control-label">Email Address</label>
				<div class="col-sm-10">
					<div class="input-group">
						<span class="input-group-addon"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span></span>
						<input type="email" class="form-control" id="inputEmail" placeholder="Email" disabled value="{$email|escape}" />
						<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
					</div>
				</div>
			</div>
			<div class="alert alert-success" role="alert">
				<strong>Email sent!</strong> A password reset email has been sent to your email address. Follow the link in the email to continue.
			</div>
		</form>
    </div>
{/block}