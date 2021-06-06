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
					<form class="form-horizontal" method="POST">
						<div class="col-md-offset-1 col-sm-12 col-md-4 well p-30">
							<div class="form-horizontal">
								<div class="form-group">
									<label for="selectFornecedorId">Fornecedor</label>
									<select name="fornecedor_id" class="form-control" id="selectFornecedorId">
										<option value=""> </option>
										<?php foreach ($fornecedores as $fornecedor): ?>
											<option<?php echo((isset($fornecedor_id)&&$fornecedor_id==$fornecedor->id)?' selected':''); ?> value="<?php echo($fornecedor->id); ?>">
												<?php echo($fornecedor->name); ?>
											</option>
										<?php endforeach; ?>
									</select>
									<span class="text-danger"><?php echo(form_error('fornecedor_id')) ?></span>
								</div>
								<div class="form-group">
									<label for="selectColaboradorId">Colaborador</label>
									<select name="colaborador_id" class="form-control" id="selectColaboradorId">
										<option value=""> </option>
										<?php foreach ($colaboradores as $colaborador): ?>
											<option<?php echo((isset($colaborador_id)&&$colaborador_id==$colaborador->id)?' selected':''); ?> value="<?php echo($colaborador->id); ?>">
												<?php echo($colaborador->name); ?>
											</option>
										<?php endforeach; ?>
									</select>
									<span class="text-danger"><?php echo(form_error('colaborador_id')) ?></span>
								</div>
								<div class="form-group">
									<label for="textareaObservacoes">Observações</label>
									<textarea id="textareaObservacoes" name="observacoes" class="form-control"
											  rows="10"><?php echo(isset($observacoes)?$observacoes:''); ?></textarea>
								</div>
								<div class="form-group text-center">
									<button type="submit" class="btn btn-success">Enviar</button>
								</div>
							</div>
						</div>
						<div class="col-md-offset-1 col-sm-12 col-md-5 well p-30">
							<div class="d-flex justify-content-between align-items-center pb-2 mb-3 ">
								<h2 class="h3 mb-30">Produtos</h2>
								<div class="btn-toolbar mb-2 mb-md-0">
									<button type="button" onclick="javascript:add();" class="btn btn-primary">
										Adicionar novo
									</button>
								</div>
							</div>
							<div id="orders_itens">
								<?php if (isset($orders_itens['product_id']) && is_array($orders_itens)):
									foreach ($orders_itens['product_id'] as $index => $item): ?>
										<div class="form-horizontal">
											<div class="form-group">
												<label for="inputProductId<?php echo($index) ?>">Produto</label>
												<select name="orders_itens[product_id][]" class="form-control" id="inputProductId<?php echo($index) ?>">
													<option value=""> </option>
													<?php foreach ($products as $product): ?>
														<option<?php echo((isset($orders_itens['product_id'][$index])&&$orders_itens['product_id'][$index]==$product->id)?' selected':''); ?> value="<?php echo($product->id); ?>">
															<?php echo($product->name); ?>
														</option>
													<?php endforeach; ?>
												</select>
												<span class="text-danger"><?php echo(form_error("orders_itens[product_id][{$index}]")) ?></span>
											</div>
											<div class="form-group">
												<label for="inputAddress<?php echo($index) ?>">Valor unitário</label>
												<input type="text" name="orders_itens[value][]" class="form-control" maxlength="15"
													   id="inputAddress<?php echo($index) ?>"
													   value="<?php echo(isset($orders_itens['value'][$index])?$orders_itens['value'][$index]:''); ?>">
												<span class="text-danger"><?php echo(form_error("orders_itens[value][{$index}]")) ?></span>
											</div>
											<div class="form-group">
												<label for="inputQuantidade<?php echo($index) ?>">Quantidade</label>
												<input type="number" name="orders_itens[quantidade][]" class="form-control" maxlength="11"
													   id="inputQuantidade<?php echo($index) ?>"
													   value="<?php echo(isset($orders_itens['quantidade'][$index])?$orders_itens['quantidade'][$index]:''); ?>">
												<span class="text-danger"><?php echo(form_error("orders_itens[quantidade][{$index}]")) ?></span>
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
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="hidden" id="template">
			<div class="form-horizontal">
				<div class="form-group">
					<label for="inputProductId{n}">Produto</label>
					<select name="orders_itens[product_id][]" class="form-control" id="inputProductId{n}">
						<option value=""> </option>
						<?php foreach ($products as $product): ?>
							<option<?php echo((isset($product_id)&&$product_id==$product->id)?' selected':''); ?> value="<?php echo($product->id); ?>">
								<?php echo($product->name); ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="form-group">
					<label for="inputAddress{n}">Valor unitário</label>
					<input type="text" name="orders_itens[value][]" class="form-control" maxlength="15"
						   id="inputAddress{n}">
				</div>
				<div class="form-group">
					<label for="inputQuantidade{n}">Quantidade</label>
					<input type="number" name="orders_itens[quantidade][]" class="form-control" maxlength="11"
						   id="inputQuantidade{n}">
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
