<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div id="throbber" style="display:none; min-height:120px;"></div>
<div id="noty-holder"></div>
<div id="wrapper">
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>
		<ul class="nav navbar-right top-nav">
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo($user_name); ?> <b class="fa fa-angle-down"></b></a>
				<ul class="dropdown-menu">
					<li><a href="<?php echo($logout); ?>"><i class="fa fa-fw fa-power-off"></i> Sair</a></li>
				</ul>
			</li>
		</ul>
		<div class="collapse navbar-collapse navbar-ex1-collapse">
			<ul class="nav navbar-nav side-nav">
				<li>
					<a href="/projeto-avaliacao">
						<i class="glyphicon glyphicon-home"></i> Inicio
					</a>
				</li>
				<li>
					<a href="/projeto-avaliacao/colaboradores-fornecedores">
						<i class="glyphicon glyphicon-user"></i>  Colaboradores / Fornecedores
					</a>
				</li>
				<li>
					<a href="/projeto-avaliacao/produtos">
						<i class="glyphicon glyphicon-barcode"></i>
						Produtos
					</a>
				</li>
				<li>
					<a href="/projeto-avaliacao/pedidos">
						<i class="glyphicon glyphicon-credit-card"></i>
						Pedidos
					</a>
				</li>
			</ul>
		</div>
	</nav>
