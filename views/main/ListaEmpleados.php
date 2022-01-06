<?php 

    require_once($_SERVER["DOCUMENT_ROOT"].'/PruebaNexura/config/config.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>

    <title>Lista Empleados</title>

    <?php require (constant('PATH').'/views/shared/__header.php'); ?>

    <style type="text/css">

        @font-face{
            src: url("https://fonts.googleapis.com/css?family=Oxygen");
            font-family: 'Oxygen', sans-serif;
            font-display: swap;
        }

        body { font-family: "Oxygen", sans-serif }

        #footer {
            width: 100%;
            height: auto;
            background-color: #eee;
        }
    </style>
</head>

<body>    
    <!--container-->
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col">
                <h1 class="display-3 text-center">Lista de empleados</h1>
            </div>
        </div>
        

        <div class="row justify-content-center">
            <div class="col-2">
                
            </div>
            <div class="col">

                <form name="listaempleados" method="post" action="ListaEmpleados.php">
                    <table class="table">
                      <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Email</th>
                            <th scope="col">Sexo</th>
                            <th scope="col">Area</th>
                            <th scope="col">Boletín</th>
                            <th scope="col">Boletín</th>
                            <th scope="col">Modificar</th>
                            <th scope="col">Eliminar</th>
                        </tr>
                      </thead>
                      <tbody>

                      </tbody>
                    </table>                   
                    
                </form>

            </div>
            <div class="col-2">
                
            </div>
        </div>

    <!--container-->
    </div>

    <?php require_once(constant('PATH').'/views/shared/__footer.php'); ?>

</body>

</html>
