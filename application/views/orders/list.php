<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php echo($header); ?>
	<?php echo($content_top); ?>
		<div id="page-wrapper">
			<div class="container-fluid">
				<div class="row" id="main" >
					<div class="d-flex justify-content-between align-items-center pb-2 mb-3 ">
						<h1 class="h2 mb-30">Pedidos</h1>
						<div class="btn-toolbar mb-2 mb-md-0">
							<a class="btn btn-success" href="<?php echo($ws); ?>" target="_blank">
								Exportar
							</a>
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
										<th>Fornecedor</th>
										<th>Coloborador</th>
										<th width="300"></th>
									</tr>
								</thead>
								<tbody>
									<?php if ($orders): ?>

										<?php foreach ($orders as $order): ?>
											<tr>
												<td><?php echo($order['fornecedor']); ?></td>
												<td><?php echo($order['colaborador']); ?></td>
												<td  class="text-right">
													<?php if ($order['finalizado']==false):  ?>
														<a class="btn btn-sm btn-orange" href="<?php echo("{$toggle}{$order['id']}"); ?>">
															Finalizar pedido
														</a>
														<a class="btn btn-sm btn-default"
														   href="<?php echo("{$edit}{$order['id']}"); ?>">
															Editar
														</a>
														<a class="btn btn-sm btn-danger"
														   href="<?php echo("{$delete}{$order['id']}"); ?>">
															Excluir
														</a>
													<?php endif; ?>
												</td>
											</tr>
										<?php endforeach ?>

									<?php else: ?>
										<tr>
											<td class="text-center" colspan="3"> Nenhum pedido cadastrado no momento</td>
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
