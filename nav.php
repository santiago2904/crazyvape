<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand visible-xs-block visible-sm-block" href="">Inicio</a>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav ">
					<li class="active"><a href="crudEmpleados.php">Lista de Empleados</a></li>
					<li class="active"><a href="crud.php">Lista de Clientes</a></li>
					<li><a href="add.php">Agregar datos</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
            		<li class="dropdown">
                		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    		<?php
                        		session_start();
                        		if(isset($_SESSION['usuario'])) {
                            		echo $_SESSION['usuario'];
                        		} else {
                            		echo 'Mi Perfil';
                        		}
                    		?>
                    		<span class="caret"></span>
                		</a>
                		<ul class="dropdown-menu">
                    		<li><a href="cerrar_sesion.php">Cerrar Sesión</a></li>
                		</ul>
            		</li>
        		</ul>
				
			</div><!--/.nav-collapse -->
			
	</div>