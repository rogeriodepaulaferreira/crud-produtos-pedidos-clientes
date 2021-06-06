<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php echo($header); ?>
	<?php echo($content_top); ?>
		<div id="page-wrapper">
			<div class="container-fluid">
				<div class="row" id="main" >
					<div class="d-flex justify-content-between align-items-center pb-2 mb-3 ">
						<h1 class="h2 mb-30"><?php echo($title); ?></h1>
						<div class="btn-toolbar mb-2 mb-md-0">
							<a class="btn btn-dark" href="<?php echo($return); ?>">
								Voltar
							</a>
						</div>
					</div>
					<div class="col-md-offset-4 col-sm-12 col-md-4 well p-30">
						<form class="form-horizontal" method="POST">
							<div class="form-group">
								<label for="inputCode">Código</label>
								<input type="text" class="form-control" name="code" maxlength="20"
									   value="<?php echo(isset($code)?$code:''); ?>" id="inputCode"
									   placeholder="Maximo de 20 caracteres">
								<span class="text-danger"><?php echo(form_error('code')) ?></span>
							</div>
							<div class="form-group">
								<label for="inputName">Nome</label>
								<input type="text" class="form-control" name="name" maxlength="100"
									   value="<?php echo(isset($name)?$name:''); ?>" id="inputName"
									   placeholder="Maximo de 100 caracteres">
								<span class="text-danger"><?php echo(form_error('name')) ?></span>
							</div>
							<div class="form-group">
								<label for="textareaDescription">Descrição</label>
								<textarea id="textareaDescription" name="description" class="form-control"
										  rows="10"><?php echo(isset($description)?$description:''); ?></textarea>
							</div>
							<div class="form-group text-center">
								<button type="submit" class="btn btn-success">Enviar</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	<?php echo($content_bottom); ?>
<?php echo($footer); ?>
