<div id="login" class="round contentitem">
	<form method="post" action="index.php" name="loginform">

			<p><label for="login_input_username">Username</label>
			<input id="login_input_username" class="login_input" type="text" name="user_name" required /></p>

			<p><label for="login_input_password">Password</label>
			<input id="login_input_password" class="login_input" type="password" name="user_password" autocomplete="off" required /></p>

			<p><input type="submit"  name="login" value="Log in" /></p>

	</form>

</div>
<script type="text/javascript">
<?php	
		
if (isset($login)) {
	if ($login->errors) {
			foreach ($login->errors as $error) { ?>
				showNotification(<?php echo '"'.$error.'"' ?>,'bad');
			<?php }
	}
	if ($login->messages) {
			foreach ($login->messages as $message) { ?>
				showNotification(<?php echo '"'.$message.'"' ?>,'good');
			<?php }
	}
}
?>
</script>