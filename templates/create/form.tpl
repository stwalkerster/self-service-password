{extends file="main.tpl"}
{block name="content"}
	<div class="page-header">
		<h1>Create Account <small>Create an account for use on LDAP-connected services.</small></h1>
	</div>

    <div class="row">
		<form class="form-horizontal" role="form" method="post">
			<div class="form-group">
				<label for="inputFirstName" class="col-sm-2 control-label">Given Name</label>
				<div class="col-sm-10">
					<div class="input-group">
						<span class="input-group-addon"><span class="glyphicon glyphicon-tag" aria-hidden="true"></span></span>
						<input type="text" class="form-control" id="inputFirstName" placeholder="Given Name" required name="givenName"/>
					</div>
				</div>
			</div>
						
			<div class="form-group">
				<label for="inputSurname" class="col-sm-2 control-label">Surname</label>
				<div class="col-sm-10">
					<div class="input-group">
						<span class="input-group-addon"><span class="glyphicon glyphicon-tags" aria-hidden="true"></span></span>
						<input type="text" class="form-control" id="inputSurname" placeholder="Surname" required name="sn"/>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label for="inputUsername" class="col-sm-2 control-label">Username</label>
				<div class="col-sm-10">
					<div class="input-group">
						<span class="input-group-addon"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></span>
						<input type="text" class="form-control" id="inputUsername" placeholder="Username" required name="username" />
					</div>
				</div>
			</div>
			<div class="form-group">
				<label for="inputEmail" class="col-sm-2 control-label">Email Address</label>
				<div class="col-sm-10">
					<div class="input-group">
						<span class="input-group-addon"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span></span>
						<input type="email" class="form-control" id="inputEmail" placeholder="Email" required name="mail" />
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
					<div class="input-group">
						<div class="g-recaptcha" data-sitekey="{$recaptchaclientkey}"></div>
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-primary">Create Account</button>
				</div>
			</div>

			
		</form>
    </div>
{/block}