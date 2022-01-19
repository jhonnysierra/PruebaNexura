<?php 
    error_reporting(0);
    require_once($_SERVER["DOCUMENT_ROOT"].'/PruebaNexura/config/config.php');
    require(constant('PATH').'/controllers/MainController.php');
    require(constant('PATH').'/models/Employee.php');

    /**
     * Se valida si se presiono el boton guardar. Se captura la informacion ingresada en el formulario y se
     * crea una clase de tipo empleado. Se envia el objeto a la clase controlador para que se realice
     * el ingreso de la informacion a la base de datos.
     */
    if($_POST['btnGuardar']=='guardar'){

        $idUser= generateIdEmployee();
        $name= $_REQUEST['nombreCompleto'];
        $email= $_REQUEST['correo'];
        $gender = $_REQUEST['sexoRadio'];
        $deparment = $_REQUEST['area'];

        if(isset($_POST['boletin'])){
            $newsletter = "1";
        }else{
            $newsletter = "0";
        }

        $description = $_REQUEST['descripcion'];

        $roles = array();

        if(!empty($_POST['roles'])){
            foreach($_POST['roles'] as $selected){
                array_push($roles, $selected);
            }
        }   

        if (!empty($idUser) && !empty($name) && !empty($email) && !empty($gender) && !empty($deparment)) {
            $employee = new Employee($idUser, $name, $email, $gender, $deparment, $description, $newsletter, $roles);
            saveEmployee($employee);      
        }else{
            alertError("Los campos con * son obligatorios");
        }
    }        
?>

<!DOCTYPE html>
<html lang="es">
<head>

    <title>Prueba Técnica Desarrollador PHP Nexura</title>

    <?php require(constant('PATH').'/views/shared/__header.php');?>

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

                <form name="main" id="mainForm" method="post" action="MainApplication.php">
                    <div class="row mb-3 justify-content-center">
                        <label for="nombreCompleto" class="col-sm-3 col-form-label">Nombre Completo *</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="nombreCompleto" name="nombreCompleto"placeholder="Nombre completo del empleado" required>
                        </div>
                    </div>

                    <div class="row mb-3 justify-content-center">
                        <label for="correo" class="col-sm-3 col-form-label">Correo electrónico *</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="correo" name="correo" placeholder="Correo electrónico" required>
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
                                <option value="">--Seleccione Area--</option>
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
                                <input class="form-check-input mt-2" type="checkbox" id=rol"'.$rowRole[0].'" value="'.$rowRole[0].'" name="roles[]" aria-label="Rol Empleado">
                                <label for=rol"'.$rowRole[0].'" class="col-sm-8 col-form-label">'.$rowRole[1].'</label>
                                </div>
                                <label class="col-sm-3 col-form-label"></label>
                                ';
                            }
                            ?>
                    </div>

                    <div class="row mb-3 justify-content-center">
                        <div class="col-sm-5">
                            <button type="submit" class="btn btn-primary btn-lg btn-block login-button"  name="btnGuardar" value="guardar" id="guardar" data-toggle="modal" data-target="#" onclick="validateForm();">Guardar</button>

                            <a class="btn btn-info btn-lg" href="EmployeeList.php" role="link">Lista empleados</a>
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

<script type="text/javascript">
    /**
     * Funcion javascript que permite validar el formulario antes de ser enviado. Se realiza la validacion de
     * los campos que no se encuentren vacios. En caso de que falte algun campo obligatorio se detiene el
     * envio del formulario.
     */
    function validateForm(){
        var form = document.getElementById("mainForm");
        var name = document.getElementById('nombreCompleto');
        var email = document.getElementById('correo');
        var gender = document.querySelectorAll('input[name="sexoRadio"]:checked');
        var area = document.getElementById('area');
        var description = document.getElementById('descripcion');
        var listRoles = document.querySelectorAll('input[name="roles[]"]:checked');
        

        if (name.value!="" && email.value!="" && gender.length>0 && area.selectedIndex!=0 && description.value!="" && listRoles.length>0) {
            form.submit();
        }else{
            alert('Faltan datos');
        }        
    }
</script>