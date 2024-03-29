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
        <ul class="nav navbar-nav">
            <li class="dropdown" id="comprasDropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    Compras <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="lista_compras.php">Lista de Compras</a></li>
                    <li><a href="add_compra.php">Agregar Compra</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    Clientes <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="crud.php">Lista de Clientes</a></li>

                    <li><a href="add.php">Agregar Cliente</a></li>
                </ul>
            </li>
            <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] == "ADMIN") : ?>
                <li class="dropdown" id="empleadosDropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        Empleados <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="crudEmpleados.php">Lista de Empleados</a></li>
                        <li><a href="agregar_empleado.php">Agregar Empleado</a></li>
                    </ul>
                </li>
            <?php endif; ?>
        </ul>
        <!-- Mini perfil desplegable -->
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <?php
                    if (isset($_SESSION['usuario'])) {
                        echo $_SESSION['usuario'];
                    } else {
                        echo 'Mi Perfil';
                    }
                    ?>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <p>Nombre: <?php echo $_SESSION["nombres"]; ?></p>
                    </li>
                    <li>
                        <p>Correo: <?php echo $_SESSION["correo"]; ?></p>
                    </li>
                    <li role="separator" class="divider"></li>
                    <li><a href="cerrar_sesion.php">Cerrar Sesión</a></li>
                </ul>
            </li>
        </ul>
    </div><!--/.nav-collapse -->
</div>