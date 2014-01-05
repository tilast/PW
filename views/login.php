<a href="<?=Config::SITE_PREFIX?>/signup">Signup</a>
<form id="login-form" method="post">
	<label>
		<div>Login:</div>
		<input type="text" name="login" value="<?=$formLogin?>" />
	</label>
	<label>
		<div>Password:</div>
		<input type="password" name="password" />
	</label>

	<input type="submit" name="submit" class="uk-button">
</form>