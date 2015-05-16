{extends file="main.tpl"}
{block name="content"}
	<div class="page-header">
		<h1>Log In <small>Log in to manage your account.</small></h1>
	</div>

	{if $authFailed}
	<div class="alert alert-danger" role="alert">Login failed: bad username or password.</div>
	{/if}
    
	<div class="row">
		<form class="form-horizontal" role="form" method="post">
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
				<label for="inputPassword" class="col-sm-2 control-label">Password</label>
				<div class="col-sm-10">
					<div class="input-group">
						<span class="input-group-addon"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span></span>
						<input type="password" class="form-control" id="inputPassword" placeholder="Password" required name="password"/>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-primary">Log In</button>
				</div>
			</div>
		</form>
    </div>
{/block}