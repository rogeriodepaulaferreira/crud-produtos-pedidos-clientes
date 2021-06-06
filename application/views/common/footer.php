<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
		<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
		<?php if (isset($scripts)){
			foreach ($scripts as $script){
				echo("<script src=\"{$script}\"></script>");
			}
		} ?>
	</body>
</html>
