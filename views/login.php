<!DOCTYPE html>
<html>

<head>
    <title>Iniciar sesión</title>
    <!-- Agregar enlace al archivo CSS de Bootstrap -->
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>

<body>
    <div class="container">


        <h2>Iniciar sesión</h2>

        <form action="procesar_login.php" method="POST">
            <div class="form-group">
                <label for="correo">Correo electrónico:</label>
                <input type="email" name="correo" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="contrasena">Contraseña:</label>
                <input type="password" name="contrasena" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Iniciar sesión</button>
        </form>
    </div>

    <!-- Agregar enlace al archivo JavaScript de Bootstrap (opcional) -->

    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
</body>

</html>