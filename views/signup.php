<a href="<?=Config::SITE_PREFIX?>/login">Login</a>
<form id="login-form" method="post">
	<label>
		<div>Login:</div>
		<input type="text" name="login" value="<?=$formLogin?>" />
	</label>
	<label>
		<div>Password:</div>
		<input type="password" name="password" />
	</label>
	<label>
		<div>Password again:</div>
		<input type="password" name="passwordAgain" />
	</label>

	<input type="submit" name="submit">
</form>