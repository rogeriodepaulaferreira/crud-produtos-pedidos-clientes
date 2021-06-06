<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php echo($header); ?>
	<?php echo($content_top); ?>
		<div id="page-wrapper">
			<div class="container-fluid">
				<div class="row" id="main" >
					<div class="d-flex justify-content-between align-items-center pb-2 mb-3 ">
						<h1 class="h2 mb-30">  Colaboradores / Fornecedores</h1>
						<div class="btn-toolbar mb-2 mb-md-0">
							<a class="btn btn-dark" href="<?php echo($add); ?>">
								Adicionar
							</a>
						</div>
					</div>
					<span class="text-danger"><?php echo($this->session->flashdata('error')); ?></span>
					<span class="text-success"><?php echo($this->session->flashdata('success')); ?></span>
					<div class="col-sm-12 col-md-12 well" id="content">
						<div class="table-responsive">
							<table class="table table-striped table-sm">
								<thead>
									<tr>
										<th>Tipo</th>
										<th>Nome</th>
										<th>Telefone</th>
										<th>Celular</th>
										<th>E-mail</th>
										<th width="300"></th>
									</tr>
								</thead>
								<tbody>
									<?php if ($customers): ?>

										<?php foreach ($customers as $customer): ?>
											<tr>
												<td>
													<?php echo($customer->type==1?'Colaborador':'Fornecedor'); ?>
												</td>
												<td><?php echo($customer->name); ?></td>
												<td><?php echo($customer->telephone); ?></td>
												<td><?php echo($customer->cellphone); ?></td>
												<td><?php echo($customer->email); ?></td>
												<td class="text-right">
													<?php if ($customer->type==1):
														if ($customer->status): ?>
															<a class="btn btn-sm btn-orange" href="<?php echo("{$toggle}{$customer->id}"); ?>">
																Bloquear
															</a>
														<?php else: ?>
															<a class="btn btn-sm btn-green" href="<?php echo("{$toggle}{$customer->id}"); ?>">
																Habilitar
															</a>
														<?php endif;
													endif; ?>
													<?php if ($customer->status): ?>
														<a class="btn btn-sm btn-default"
														   href="<?php echo("{$edit}{$customer->id}"); ?>">
															Editar
														</a>
														<a class="btn btn-sm btn-danger"
														   href="<?php echo("{$delete}{$customer->id}"); ?>">
															Excluir
														</a>
													<?php endif; ?>
												</td>
											</tr>
										<?php endforeach ?>

									<?php else: ?>
										<tr>
											<td class="text-center" colspan="6"> Nenhum cadastrado no momento</td>
										</tr>
									<?php endif; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php echo($content_bottom); ?>
<?php echo($footer); ?>
