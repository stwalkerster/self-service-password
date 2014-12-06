{extends file="main.tpl"}
{block name="content"}
	<div class="page-header">
		<h1>Password Reset <small>Reset a forgotten or lost password.</small></h1>
	</div>

    <div class="row">
		<form class="form-horizontal" role="form" method="post">
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
			<div class="form-group has-success has-feedback">
				<label for="inputEmail" class="col-sm-2 control-label">Account Identifier (DN)</label>
				<div class="col-sm-10">
					<div class="input-group">
						<span class="input-group-addon"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span></span>
						<input type="email" class="form-control" id="inputDN" placeholder="DN" disabled value="{$dn|escape}" />
						<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
					</div>
				</div>
			</div>
			<div class="form-group has-success has-feedback">
				<label for="inputPassword" class="col-sm-2 control-label">Password</label>
				<div class="col-sm-10">
					<div class="input-group">
						<span class="input-group-addon"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span></span>
						<input type="password" class="form-control" id="inputPassword" placeholder="Password" disabled/>
						<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
					</div>
				</div>
			</div>
			
			<div class="form-group has-success has-feedback">
				<label for="inputConfirmPassword" class="col-sm-2 control-label">Confirm Password</label>
				<div class="col-sm-10">
					<div class="input-group">
						<span class="input-group-addon"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span></span>
						<input type="password" class="form-control" id="inputConfirmPassword" placeholder="Password" disabled/>
						<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
					</div>
				</div>
			</div>
			
			<div class="alert alert-success" role="alert">
				<strong>Password Changed!</strong> Your password has been successfully changed! You may now log in.
			</div>
		</form>
    </div>
{/block}