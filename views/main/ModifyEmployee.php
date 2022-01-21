<?php 
    //error_reporting(0);
    require_once($_SERVER["DOCUMENT_ROOT"].'/PruebaNexura/config/config.php');
    require(constant('PATH').'/controllers/EmployeeListController.php');

    $idEmployee = base64_decode($_GET['id']);
    $employee = queryEmployee($idEmployee);


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

<body onload="noBack();">    
    <!--container-->
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col">
                <h1 class="display-4 text-center">Modificar Empleado</h1>
            </div>
        </div>
        

        <div class="row justify-content-center">
            <div class="col-2">
                
            </div>
            <div class="col">

                <form name="modify" id="modifyForm" method="post" action="ModifyEmployee.php">
                    <div class="row mb-3 justify-content-center">
                        <label for="nombreCompleto" class="col-sm-3 col-form-label">Nombre Completo *</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="nombreCompleto" name="nombreCompleto"placeholder="Nombre completo del empleado" value="<?php echo $employee->getName();?>" required>
                        </div>
                    </div>

                    <div class="row mb-3 justify-content-center">
                        <label for="correo" class="col-sm-3 col-form-label">Correo electrónico *</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="correo" name="correo" placeholder="Correo electrónico" value="<?php echo $employee->getEmail();?>" required>
                        </div>
                    </div>

                    <div class="row mb-3 justify-content-center">
                        <label for="sexoRadio" class="col-sm-3 col-form-label">Sexo *</label>
                        <div class="col-sm-8">
                          <div class="form-check">

                            <input class="form-check-input" type="radio" name="sexoRadio" id="femenino" value="F">
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
                            <?php 
                                if ($employee->getGender()=='F') {
                                    echo '
                                        <script type="text/javascript">
                                            document.querySelector("#femenino").checked = true;
                                        </script>
                                    ';
                                } else {
                                    echo '
                                        <script type="text/javascript">
                                            document.querySelector("#masculino").checked = true;
                                        </script>
                                    ';
                                }
                            ?>
                        </div>
                    </div>                    

                    <div class="row mb-3 justify-content-center">
                        <label for="area" class="col-sm-3 col-form-label">Area *</label>
                        <div class="col-sm-8">
                            <?php
                                $result = listAreas();
                            ?>
                            <select id="area" name="area" class="form-select">
                                <option value="">--Seleccione Area--</option>
                            <?php
                                while($rowArea = mysqli_fetch_array($result, MYSQLI_NUM)){
                                   echo "<option value='".$rowArea[0]."' id='".$rowArea[0]."'>".$rowArea[1]."</option>";

                                   if ($employee->getDeparment()['id'] == $rowArea[0]) {
                                        echo '
                                            <script type="text/javascript">
                                                var area = document.getElementById("area");
                                                area.options.namedItem('.$rowArea[0].').selected = true;
                                            </script>
                                        ';
                                   }
                                }
                            ?>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3 justify-content-center">
                        <label for="descripcion" class="col-sm-3 col-form-label">Descripción *</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" placeholder="Descripción de la experiencia del empleado" id="descripcion" name="descripcion" ><?php echo $employee->getDescription();?></textarea>
                        </div>
                    </div>

                    <div class="row mb-3 justify-content-center">
                        <div class="col-sm-5">
                            <input class="form-check-input mt-2" type="checkbox" id="boletin" value="" name="boletin" aria-label="Deseo recibir boletín informativo">
                            <label for="boletin" class="col-sm-8 col-form-label">Deseo recibir boletín informativo</label>
                        </div>
                        <?php 
                            if ($employee->getNewsletter() == "1") {
                                echo '
                                        <script type="text/javascript">
                                            document.querySelector("#boletin").checked = true;
                                        </script>
                                    ';
                            }
                        ?>                      
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
                                    <input class="form-check-input mt-2" type="checkbox" id="rol'.$rowRole[0].'" value="'.$rowRole[0].'" name="roles[]" aria-label="Rol Empleado">
                                    <label for=rol"'.$rowRole[0].'" class="col-sm-8 col-form-label">'.$rowRole[1].'</label>
                                    </div>
                                    <label class="col-sm-3 col-form-label"></label>
                                    ';                               
                                }
                                
                                foreach ($employee->getRole() as $key => $value) {
                                    echo '
                                            <script type="text/javascript">
                                                document.querySelector("#rol'.$key.'").checked = true;
                                            </script>
                                        ';
                                }
                            ?>
                    </div>

                    <div class="row mb-3 justify-content-center">
                        <div class="col-sm-5">
                            <button type="button" class="btn btn-primary btn-lg btn-block login-button"  name="btnModificar" value="modificar" id="modificar" data-toggle="modal" data-target="#" onclick="validateForm();">Modificar</button>
                        </div>
                    </div>
                    
                </form>

            </div>
            <div class="col-2">
                
            </div>
        </div>

        <!-- Modal para error de formulario-->
        <div class="modal fade" id="myModalError" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="myModalErrorLabel">Error</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body" id="modal-body"></div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
              </div>
            </div>
          </div>
        </div>
    <!--container-->
    </div>

    <?php require_once(constant('PATH').'/views/shared/__footer.php'); ?>

</body>
</html>



<script type="text/javascript">
    /**
     * Funcion que permite deshabilitar en retroceso en la pagina
     */
    function noBack() {
        window.location.hash="no-back-button";
        window.location.hash="Again-No-back-button" //chrome
        window.onhashchange=function(){window.location.hash="no-back-button";}
    }

    /**
     * Funcion javascript que permite validar el formulario antes de ser enviado. Se realiza la validacion de
     * los campos que no se encuentren vacios. En caso de que falte algun campo obligatorio se detiene el
     * envio del formulario.
     */
    function validateForm(){
        var form = document.getElementById("modifyForm");
        var name = document.getElementById('nombreCompleto');
        var email = document.getElementById('correo');
        var gender = document.querySelectorAll('input[name="sexoRadio"]:checked');
        var area = document.getElementById('area');
        var description = document.getElementById('descripcion');
        var listRoles = document.querySelectorAll('input[name="roles[]"]:checked');
        

        if (name.value!="" && email.value!="" && gender.length>0 && area.selectedIndex!=0 && description.value!="" && listRoles.length>0) {
            form.submit();
        }else{
            document.getElementById("modal-body").innerHTML = "Faltan Datos. Los campos * son obligatorios";

            var myModalError = new bootstrap.Modal(document.getElementById("myModalError"));
            myModalError.show();

            return false;
        }        
    }
</script>   
