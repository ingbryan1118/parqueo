<nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
    <div class="position-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
                <?php
                // Lógica condicional para ocultar elementos según el tipo de usuario
                if ($tipoUsuario != 2) {
                    //             echo '<li class="nav-item">
                    //     <a class="nav-link" href="reporte.php">
                    //         <i class="fa fa-sign-out"></i> Reporte
                    //     </a>
                    //   </li>';
                    echo '';
                }
                ?>
            <li class="nav-item">
                <a class="nav-link" href="creaplaca.php">
                    <i class="fa fa-sign-out"></i> Crear Placa
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="verplacas.php">
                    <i class="fa fa-sign-out"></i> Ver Placas
                </a>
            </li>
            <a class="nav-link active" href="index.php">
                <i class="fa fa-home"></i> Registrar Parqueo
            </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="parqueo.php">
                    <i class="fa fa-list"></i> Lista de parqueo
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="parqueoMensual.php">
                    <i class="fa fa-list"></i> Listado Parqueo Mensual
                </a>
            </li>
            <?php
            // Lógica condicional para ocultar elementos según el tipo de usuario
                if ($tipoUsuario != 2) {
                    echo '<li class="nav-item">
                                    <a class="nav-link" href="reporte.php">
                                        <i class="fa fa-sign-out"></i> Reporte
                                    </a>
                                </li>';
                    echo '<li class="nav-item">
                    <a class="nav-link" href="creaUsuario.php">
                        <i class="fa fa-sign-out"></i> Crear Usuario
                    </a>
                    </li>';

                    echo '<li class="nav-item">
                    <a class="nav-link" href="tarifas.php">
                        <i class="fa fa-sign-out"></i> Tarifas
                    </a>
                    </li>';
                }
            ?>
            <li class="nav-item">
                <a class="nav-link" href="login.php">
                    <i class="fa fa-sign-out"></i> Login
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="logout.php">
                    <i class="fa fa-sign-out"></i> Cerrar Sesión
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="reiniciar.php">
                    <i class="fa fa-sign-out"></i> Reiniciar
                </a>
            </li>
            
        </ul>
    </div>
</nav>