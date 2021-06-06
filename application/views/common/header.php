<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!doctype html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<?php if (isset($canonical)): ?>
			<link rel="canonical" href="<?php echo($canonical) ?>">
		<?php endif; ?>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" >
		<link href="http://localhost/projeto-avaliacao/assets/css/general.css" rel="stylesheet" >
		<?php if (isset($styles)){
			foreach ($styles as $style){
				echo("<link href=\"{$style}\" rel=\"stylesheet\">");
			}
		} ?>
		<title>Gerenciador de pedidos</title>
	</head>
	<body>
