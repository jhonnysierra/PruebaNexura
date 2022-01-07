<?php 

    require_once($_SERVER["DOCUMENT_ROOT"].'/PruebaNexura/config/config.php');
    require(constant('PATH').'/controllers/MainController.php');
    require(constant('PATH').'/models/Employee.php');
    //require(constant('PATH').'/libs/conexion_li.php');

    if($_POST['btnGuardar']=='guardar'){

        $idUser= generateIdEmployee();
        $name= $_REQUEST['nombreCompleto'];
        $email= $_REQUEST['correo'];
        $gender= $_REQUEST['sexoRadio'];
        $deparment = $_REQUEST['area'];
        if(isset($_POST['boletin'])){
            $newsletter = "1";
        }else{
            $newsletter = "0";
        }
        $description = $_REQUEST['descripcion'];
        $role = "";

        $employee = new Employee($idUser, $name, $email, $gender, $deparment, $description, $newsletter, $role);

        //echo "Empleado:".$employee->getId();
        saveEmployee($employee);

    }        
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
            <div class="col">
                <h1 class="display-4 text-center">Crear Empleado</h1>
            </div>
        </div>
        

        <div class="row justify-content-center">
            <div class="col-2">
                
            </div>
            <div class="col">

                <form name="main" method="post" action="views/main/MainApplication.php">
                    <div class="row mb-3 justify-content-center">
                        <label for="nombreCompleto" class="col-sm-3 col-form-label">Nombre Completo *</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="nombreCompleto" name="nombreCompleto"placeholder="Nombre completo del empleado">
                        </div>
                    </div>

                    <div class="row mb-3 justify-content-center">
                        <label for="correo" class="col-sm-3 col-form-label">Correo electrónico *</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="correo" name="correo" placeholder="Correo electrónico">
                        </div>
                    </div>

                    <div class="row mb-3 justify-content-center">
                        <label for="sexoRadio" class="col-sm-3 col-form-label">Sexo *</label>
                        <div class="col-sm-8">
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="sexoRadio" id="femenino" value="F" checked>
                            <label class="form-check-label" for="sexoRadio">
                              Femenino
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="sexoRadio" id="masculino" value="M">
                            <label class="form-check-label" for="sexoRadio">
                              Masculino
                            </label>
                          </div>
                        </div>
                    </div>                    

                    <div class="row mb-3 justify-content-center">
                        <label for="area" class="col-sm-3 col-form-label">Area *</label>
                        <div class="col-sm-8">
                            <?php
                                $result = listArea();
                            ?>
                            <select id="area" name="area" class="form-select">
                            <?php
                                while($rowArea = mysqli_fetch_array($result, MYSQLI_NUM)){
                                   echo "<option value='".$rowArea[0]."'>".$rowArea[1]."</option>";
                                }
                            ?>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3 justify-content-center">
                        <label for="descripcion" class="col-sm-3 col-form-label">Descripción *</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" placeholder="Descripción de la experiencia del empleado" id="descripcion" name="descripcion"></textarea>
                        </div>
                    </div>

                    <div class="row mb-3 justify-content-center">
                        <div class="col-sm-5">
                            <input class="form-check-input mt-2" type="checkbox" id="boletin" value="" name="boletin" aria-label="Deseo recibir boletín informativo">
                            <label for="boletin" class="col-sm-8 col-form-label">Deseo recibir boletín informativo</label>
                        </div>                        
                    </div>

                    <div class="row mb-3 justify-content-center">
                        <?php
                            $resultRole = listRoles();
                        ?>
                        
                        <label class="col-sm-3 col-form-label">Roles *</label>
                        
                            <?php
                            while($rowRole = mysqli_fetch_array($resultRole, MYSQLI_NUM)){
                                echo'
                                <div class="col-sm-8">
                                <input class="form-check-input mt-2" type="checkbox" id="'.$rowRole[0].'" value="'.$rowRole[1].'" aria-label="Rol Empleado">
                                <label for="rol1" class="col-sm-8 col-form-label">'.$rowRole[1].'</label>
                                </div>
                                <label class="col-sm-3 col-form-label"></label>
                                ';
                            }
                            ?>
                        
                    </div>

                    <div class="row mb-3 justify-content-center">
                        <div class="col-sm-5">
                            <button type="submit" class="btn btn-primary btn-lg btn-block login-button"  name="btnGuardar" value="guardar" id="guardar" data-toggle="modal" data-target="#" onclick="">Guardar</button>

                            <a class="btn btn-info btn-lg" href="views/main/EmployeeList.php" role="link">Lista empleados</a>
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
