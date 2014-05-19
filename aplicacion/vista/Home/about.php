    <div class="container-fluid" style="padding:50px;padding-top:70px;">
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<h1 class="page-header">Acerca de nosotros</h1>
			<div class="container">
				<ol>
				<?php
					$homepage = file_get_contents(URL.'public/errores.txt');
					$arr = explode(";",$homepage);
					foreach($arr as $element)
					{
						echo '<li>'.$element.'</li>';
					}
				?>
				</ol>
			</div>
		</div>
	</div>