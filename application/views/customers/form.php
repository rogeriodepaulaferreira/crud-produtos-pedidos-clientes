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
					<div class="p-20 text-center">
						<span class="text-danger"><?php echo($this->session->flashdata('error')); ?></span>
					</div>
					<div class="col-md-offset-3 col-sm-12 col-md-6 well p-30">
						<form class="form-horizontal" method="POST">
							<div class="form-group">
								<label for="selectType">Tipo</label>
								<select name="type" class="form-control" id="selectType">
									<option<?php echo((isset($type)&&$type==1)?' selected':''); ?> value="1">
										Colaborador
									</option>
									<option<?php echo((isset($type)&&$type==2)?' selected':''); ?> value="2">
										Fornecedor
									</option>
								</select>
							</div>
							<div class="form-group">
								<label for="inputName">Nome</label>
								<input type="text" class="form-control" name="name" maxlength="100"
									   value="<?php echo(isset($name)?$name:''); ?>" id="inputName"
									   placeholder="Maximo de 100 caracteres">
								<span class="text-danger"><?php echo(form_error('name')) ?></span>
							</div>
							<div class="form-group">
								<label for="inputEmail">E-mail</label>
								<input type="email" class="form-control" name="email" maxlength="100"
									   value="<?php echo(isset($email)?$email:''); ?>" id="inputEmail"
									   placeholder="Maximo de 100 caracteres">
								<span class="text-danger"><?php echo(form_error('email')) ?></span>
							</div>
							<div class="form-group">
								<label for="inputTelephone">Telefone</label>
								<input type="tel" class="form-control" name="telephone" maxlength="15"
									   value="<?php echo(isset($telephone)?$telephone:''); ?>" id="inputTelephone"
									   placeholder="Maximo de 15 caracteres">
							</div>
							<div class="form-group">
								<label for="inputCellphone">Celular</label>
								<input type="tel" class="form-control" name="cellphone" maxlength="15"
									   value="<?php echo(isset($cellphone)?$cellphone:''); ?>" id="inputCellphone"
									   placeholder="Maximo de 15 caracteres">
							</div>
							<div class="form-group">
								<label for="inputBorndate">Data de nascimento</label>
								<input type="date" class="form-control" name="borndate" maxlength="15"
									   value="<?php echo(isset($borndate)?$borndate:''); ?>" id="inputBorndate"
									   placeholder="Maximo de 15 caracteres">
							</div>
							<div class="form-group">
								<label for="textareaComments">Observações</label>
								<textarea id="textareaComments" name="comments" class="form-control"
										  rows="10"><?php echo(isset($comments)?$comments:''); ?></textarea>
							</div>
							<hr>
							<div class="d-flex justify-content-between align-items-center pb-2 mb-3 ">
								<h2 class="h3 mb-30">Endereços</h2>
								<div class="btn-toolbar mb-2 mb-md-0">
									<button type="button" onclick="javascript:add();" class="btn btn-primary">
										Adicionar novo
									</button>
								</div>
							</div>
							<div id="adresses">
								<?php if (isset($addresses['zipcode']) && is_array($addresses)):
									foreach ($addresses['zipcode'] as $index => $address): ?>
										<div class="form-horizontal">
											<div class="form-group">
												<label for="inputZipcode<?php echo($index) ?>">CEP</label>
												<input type="text" name="addresses[zipcode][]" class="form-control" maxlength="10"
													   id="inputZipcode<?php echo($index) ?>"
													   value="<?php echo(isset($addresses['zipcode'][$index])?$addresses['zipcode'][$index]:''); ?>">
												<span class="text-danger"><?php echo(form_error("addresses[zipcode][{$index}]")) ?></span>
											</div>
											<div class="form-group">
												<label for="inputAddress<?php echo($index) ?>">Endereço</label>
												<input type="text" name="addresses[address][]" class="form-control" maxlength="100"
													   id="inputAddress<?php echo($index) ?>"
													   value="<?php echo(isset($addresses['address'][$index])?$addresses['address'][$index]:''); ?>">
												<span class="text-danger"><?php echo(form_error("addresses[address][{$index}]")) ?></span>
											</div>
											<div class="form-group">
												<label for="inputNumber<?php echo($index) ?>">Número</label>
												<input type="text" name="addresses[number][]" class="form-control" maxlength="10"
													   id="inputNumber<?php echo($index) ?>"
													   value="<?php echo(isset($addresses['number'][$index])?$addresses['number'][$index]:''); ?>">
												<span class="text-danger"><?php echo(form_error("addresses[number][{$index}]")) ?></span>
											</div>
											<div class="form-group">
												<label for="inputComplement<?php echo($index) ?>">Complemento</label>
												<input type="text" name="addresses[complement][]" class="form-control" maxlength="30"
													   id="inputComplement<?php echo($index) ?>"
													   value="<?php echo(isset($addresses['complement'][$index])?$addresses['complement'][$index]:''); ?>">
											</div>
											<div class="form-group">
												<label for="inputDistrict<?php echo($index) ?>">Bairro</label>
												<input type="text" name="addresses[district][]" class="form-control" maxlength="50"
													   id="inputDistrict<?php echo($index) ?>"
													   value="<?php echo(isset($addresses['district'][$index])?$addresses['district'][$index]:''); ?>">
												<span class="text-danger"><?php echo(form_error("addresses[district][{$index}]")) ?></span>
											</div>
											<div class="form-group">
												<label for="inputCity<?php echo($index) ?>">Cidade</label>
												<input type="text" name="addresses[city][]" class="form-control" maxlength="50"
													   id="inputCity<?php echo($index) ?>"
													   value="<?php echo(isset($addresses['city'][$index])?$addresses['city'][$index]:''); ?>">
												<span class="text-danger"><?php echo(form_error("addresses[city][{$index}]")) ?></span>
											</div>
											<div class="form-group">
												<label for="inputEstate<?php echo($index) ?>">Estado</label>
												<input type="text" name="addresses[state][]" class="form-control" maxlength="50"
													   id="inputEstate<?php echo($index) ?>"
													   value="<?php echo(isset($addresses['state'][$index])?$addresses['state'][$index]:''); ?>">
												<span class="text-danger"><?php echo(form_error("addresses[state][{$index}]")) ?></span>
											</div>
											<div class="row text-right">
												<button type="button" class="btn btn-danger" onclick="javascript:remove(this);">
													Remover
												</button>
											</div>
											<hr>
										</div>
									<?php endforeach;
								endif; ?>
							</div>
							<div class="form-group text-center">
								<button type="submit" class="btn btn-success">Enviar</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="hidden" id="template">
			<div class="form-horizontal">
				<div class="form-group">
					<label for="inputZipcode{n}">CEP</label>
					<input type="text" name="addresses[zipcode][]" class="form-control" maxlength="10"
					id="inputZipcode{n}">
				</div>
				<div class="form-group">
					<label for="inputAddress{n}">Endereço</label>
					<input type="text" name="addresses[address][]" class="form-control" maxlength="100"
					id="inputAddress{n}">
				</div>
				<div class="form-group">
					<label for="inputNumber{n}">Número</label>
					<input type="text" name="addresses[number][]" class="form-control" maxlength="10"
					id="inputNumber{n}">
				</div>
				<div class="form-group">
					<label for="inputComplement{n}">Complemento</label>
					<input type="text" name="addresses[complement][]" class="form-control" maxlength="30"
					id="inputComplement{n}">
				</div>
				<div class="form-group">
					<label for="inputDistrict{n}">Bairro</label>
					<input type="text" name="addresses[district][]" class="form-control" maxlength="50"
					id="inputDistrict{n}">
				</div>
				<div class="form-group">
					<label for="inputCity{n}">Cidade</label>
					<input type="text" name="addresses[city][]" class="form-control" maxlength="50"
					id="inputCity{n}">
				</div>
				<div class="form-group">
					<label for="inputEstate{n}">Estado</label>
					<input type="text" name="addresses[state][]" class="form-control" maxlength="50"
					id="inputEstate{n}">
				</div>
				<div class="row text-right">
					<button type="button" class="btn btn-danger" onclick="javascript:remove(this);">
						Remover
					</button>
				</div>
				<hr>
			</div>
		</div>
	<?php echo($content_bottom); ?>
<?php echo($footer); ?>
