<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php echo($header); ?>
	<div class="text-center">
		<form class="form-signin" method="POST">
			<h1 class="h4 mb-5">Para acessar entre seu login e senha</h1>
			<span class="text-danger"><?php echo($this->session->flashdata('error')); ?></span>
			<label for="inputEmail" class="sr-only">Login</label>
			<input type="text" id="inputLogin" name="user" class="form-control mb-3" placeholder="Login" required="" autofocus="">
			<span class="text-danger"><?php echo(form_error('user')) ?></span>
			<label for="inputPassword" class="sr-only">Senha</label>
			<input type="password" id="inputPassword" name="pass" class="form-control" placeholder="Senha" required="">
			<span class="text-danger"><?php echo(form_error('pass')) ?></span>
			<button class="btn btn-lg btn-dark btn-block" type="submit">Entrar</button>
		</form>
	</div>
<?php echo($footer); ?>
