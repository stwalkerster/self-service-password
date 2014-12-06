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
			<div class="form-group">
				<label for="inputPassword" class="col-sm-2 control-label">Password</label>
				<div class="col-sm-10">
					<div class="input-group">
						<span class="input-group-addon"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span></span>
						<input type="password" class="form-control" id="inputPassword" placeholder="Password" required name="password"/>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<label for="inputConfirmPassword" class="col-sm-2 control-label">Confirm Password</label>
				<div class="col-sm-10">
					<div class="input-group">
						<span class="input-group-addon"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span></span>
						<input type="password" class="form-control" id="inputConfirmPassword" placeholder="Confirm Password" required name="passwordConfirm"/>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-primary">Reset Password</button>
				</div>
			</div>
		</form>
    </div>
{/block}