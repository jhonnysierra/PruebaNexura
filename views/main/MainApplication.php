<?php 

    //require_once('../../config/config.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>

    <title>Prueba Técnica Desarrollador PHP Nexura</title>

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
            <div class="col" style="border-style: dashed;border-width: 1px;">
                <h1 class="display-4 text-center">Crear Empleado</h1>
            </div>
        </div>
        

        <div class="row justify-content-center">
            <div class="col-2">
                
            </div>
            <div class="col">

                <form name="main" method="post" action="MainApplication.php">
                    <div class="row mb-3 justify-content-center">
                        <label for="nombreCompleto" class="col-sm-3 col-form-label">Nombre Completo *</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="nombreCompleto" placeholder="Nombre completo del empleado">
                        </div>
                    </div>

                    <div class="row mb-3 justify-content-center">
                        <label for="correo" class="col-sm-3 col-form-label">Correo electrónico *</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="correo" placeholder="Correo electrónico">
                        </div>
                    </div>

                    <div class="row mb-3 justify-content-center">
                        <label for="sexoRadio" class="col-sm-3 col-form-label">Sexo *</label>
                        <div class="col-sm-8">
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="sexoRadio" id="femenino" value="option1" checked>
                            <label class="form-check-label" for="sexoRadio">
                              Femenino
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="sexoRadio" id="masculono" value="option2">
                            <label class="form-check-label" for="sexoRadio">
                              Masculino
                            </label>
                          </div>
                        </div>
                    </div>                    

                    <div class="row mb-3 justify-content-center">
                        <label for="area" class="col-sm-3 col-form-label">Area *</label>
                        <div class="col-sm-8">
                            <select id="area" class="form-select">
                                <option selected>Choose...</option>
                                <option>...</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3 justify-content-center">
                        <label for="descripcion" class="col-sm-3 col-form-label">Descripción *</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" placeholder="Descripción de la experiencia del empleado" id="descripcion"></textarea>
                        </div>
                    </div>

                    <div class="row mb-3 justify-content-center">
                        <div class="col-sm-5">
                            <input class="form-check-input mt-2" type="checkbox" id="boletin" value="" aria-label="Deseo recibir boletín informativo">
                            <label for="boletin" class="col-sm-8 col-form-label">Deseo recibir boletín informativo</label>
                        </div>                        
                    </div>

                    <div class="row mb-3 justify-content-center">
                        <label for="roles" class="col-sm-3 col-form-label">Roles *</label>
                        <div class="col-sm-8">
                            <input class="form-check-input mt-2" type="checkbox" id="rol1" value="" aria-label="Deseo recibir boletín informativo">
                            <label for="rol1" class="col-sm-8 col-form-label">Rol1</label>
                        </div>                        
                    </div>

                    <div class="row mb-3 justify-content-center">
                        <div class="col-sm-5">
                            <button type="button" class="btn btn-primary btn-lg btn-block login-button"  name="btnGuardar" value="guardar" id="guardar" data-toggle="modal" data-target="#" onclick="">Crear cuenta</button>

                            <a class="btn btn-info btn-lg" href="views/main/ListaEmpleados.php" role="link">Lista empleados</a>
                        </div>
                    </div>
                    
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
