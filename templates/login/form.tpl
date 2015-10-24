{extends file="main.tpl"}
{block name="content"}
	<div class="page-header">
		<h1>Manage Account <small>Manage your account on LDAP-connected services.</small></h1>
	</div>

    <div class="row">
		<form class="form-horizontal" role="form" method="post">
			<div class="form-group">
				<label for="inputFirstName" class="col-sm-2 control-label">Given Name</label>
				<div class="col-sm-5">
					<div class="input-group">
						<span class="input-group-addon"><span class="glyphicon glyphicon-tag" aria-hidden="true"></span></span>
						<input type="text" class="form-control" id="inputFirstName" placeholder="Given Name" name="givenName" value="{$givenName}"/>
					</div>
				</div>
			</div>
						
			<div class="form-group">
				<label for="inputSurname" class="col-sm-2 control-label">Surname</label>
				<div class="col-sm-5">
					<div class="input-group">
						<span class="input-group-addon"><span class="glyphicon glyphicon-tags" aria-hidden="true"></span></span>
						<input type="text" class="form-control" id="inputSurname" placeholder="Surname" name="sn" value="{$sn}"/>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label for="inputUsername" class="col-sm-2 control-label">Username</label>
				<div class="col-sm-3">
					<div class="input-group">
						<span class="input-group-addon"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></span>
						<input type="text" class="form-control" id="inputUsername" placeholder="Username" readonly name="username" value="{$username}"/>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label for="inputDisplayName" class="col-sm-2 control-label">Display Name</label>
				<div class="col-sm-5">
					<div class="input-group">
						<span class="input-group-addon"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></span>
						<input type="text" class="form-control" id="inputDisplayName" placeholder="Display Name" name="displayname" value="{$displayname}"/>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label for="inputEmail" class="col-sm-2 control-label">Email Address</label>
				<div class="col-sm-5">
					<div class="input-group">
						<span class="input-group-addon"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span></span>
						<input type="email" class="form-control" id="inputEmail" placeholder="Email" required name="mail" value="{$mail}" />
					</div>
				</div>
			</div>

			<fieldset>
				<legend>Password</legend>
				<p>
					You last changed your password on {$shadowLastChange->format('Y-m-d')}.
				</p>

				<div class="form-group">
					<label for="inputPassword" class="col-sm-2 control-label">Password</label>
					<div class="col-sm-5">
						<div class="input-group">
							<span class="input-group-addon"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span></span>
							<input type="password" class="form-control" id="inputPassword" placeholder="Password" name="password"/>
						</div>
					</div>
				</div>
			
				<div class="form-group">
					<label for="inputConfirmPassword" class="col-sm-2 control-label">Confirm Password</label>
					<div class="col-sm-5">
						<div class="input-group">
							<span class="input-group-addon"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span></span>
							<input type="password" class="form-control" id="inputConfirmPassword" placeholder="Confirm Password" name="passwordConfirm"/>
						</div>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<legend>SSH Keys</legend>

				<div class="form-group">
					<label for="inputKeys" class="col-sm-2 control-label">SSH Keys</label>
					
					<div class="col-sm-10">
						<div class="input-group">
							<span class="input-group-addon"><span class="glyphicon glyphicon-certificate" aria-hidden="true"></span></span>
							<textarea class="form-control" id="inputKeys" placeholder="ssh-rsa .....
ssh-rsa .....
ssh-rsa ....." name="sshkeys" rows="5">{$sshkeys}</textarea>
						</div>
					</div>
				</div>
			</fieldset>

			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-primary">Update Account</button>
				</div>
			</div>

			
		</form>
    </div>
{/block}