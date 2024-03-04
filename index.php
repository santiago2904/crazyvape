<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="./iconos/icono.ico" type="image/x-icon">
    <link rel="icon" href="./iconos/icono.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <style>
        body,
        html {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        .gradient-custom {
            background: linear-gradient(45deg, #7BBFE3, #5A92B8);
            height: 100%;
        }

        .error-box {
            background-color: #f8d7da;
            color: #721c24;
            border-color: #f5c6cb;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
        }

        .rounded-image-container {
            text-align: center;
            border-radius: 15px;
            overflow: hidden;
            margin-bottom: 30px;
        }

        .rounded-image-container img {
            border-radius: 15px;
            width: 50%;
            /* Para que la imagen llene el contenedor */
        }
    </style>
</head>

<body class="gradient-custom d-flex justify-content-center align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">

                <div class="card bg-dark text-white">
                    <div class="card-body p-5">

                        <div class="rounded-image-container">
                            <img src="./iconos/logo.png" alt="Imagen de fondo" />
                        </div>
                        <h2 class="fw-bold mb-2 text-uppercase text-center">Iniciar Sesion</h2>

                        <form action="login_conexion.php" method="POST">
                            <div class="form-outline form-white mb-4">
                                <input type="text" id="Usuario" name="Usuario" class="form-control form-control-lg" />
                                <label class="form-label" for="Usuario">Usuario</label>
                            </div>

                            <div class="form-outline form-white mb-4">
                                <input type="password" id="Clave" name="Clave" class="form-control form-control-lg" />
                                <label class="form-label" for="Clave">Contraseña</label>
                            </div>

                            <?php
                            if (isset($_GET['error']) && $_GET['error'] == 'incorrecto') {
                            ?>
                                <div class="error-box">
                                    <p class="error" align="center">Usuario o contraseña incorrectos.</p>
                                    <p class="error" align="center">Por favor, verifique los datos ingresados.</p>
                                </div>
                            <?php
                            }
                            ?>
                            <div style="margin-bottom: 20px;"></div>
                            <button class="btn btn-outline-light btn-lg px-5 d-block w-100" type="submit">Iniciar Sesion</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>