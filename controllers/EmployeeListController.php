<?php
    require_once($_SERVER["DOCUMENT_ROOT"].'/PruebaNexura/config/config.php');
    require_once(constant('PATH').'/libs/conexion_li.php');
    require(constant('PATH').'/libs/alerts.php');
    require(constant('PATH').'/models/Employee.php');

    $conexionLi = $conexion;

    /**
     * Funcion que permite listar todos los empleados registrados
     * @return Array Employee Arreglo de objetos de la clase Employee
     */
    function listEmployee(){
        $sql = "select e.id, e.nombre, e.email, e.sexo, a.id, e.descripcion, e.boletin from empleado e, areas a where e.area_id = a.id";
        $resultList = mysqli_query($GLOBALS["conexionLi"], $sql);

        $listEmployee = array();
        $listRoles = array();
        $listArea = array();
        
        while($rowEmployee = mysqli_fetch_array($resultList, MYSQLI_NUM)){
            $listRoles = listRolesEmployee($rowEmployee[0]);
            $listArea = listAreaEmployee($rowEmployee[4]);
            $employee = new Employee($rowEmployee[0], $rowEmployee[1], $rowEmployee[2], $rowEmployee[3], $listArea, $rowEmployee[5], $rowEmployee[6], $listRoles);
            array_push($listEmployee, $employee);
        }

        return $listEmployee;
    }

    /**
     * Funcion que permite consultar los roles en los que tiene registrado un empleado 
     * @param type $idEmployee Identificacion del empleado a consultar
     * @return Array Arreglo asociativo con los roles del empleado
     */
    function listRolesEmployee($idEmployee){
        $sql="select r.id, r.nombre from empleado_rol er, roles r, empleado e where er.empleado_id = e.id AND er.rol_id = r.id AND er.empleado_id='$idEmployee'";

        $resultList = mysqli_query($GLOBALS["conexionLi"], $sql);

        $listRoles = array();
        $arrayTemp = array();

        while($rowRoles = mysqli_fetch_array($resultList, MYSQLI_NUM)){
            $data = $rowRoles[0]."|".$rowRoles[1];
            //array_push($listRoles, $data);
            $listRoles["$rowRoles[0]"] = $rowRoles[1];
            //$arrayTemp = array_merge($arrayTemp, $arrayTemp["$rowRoles[0]"] => $rowRoles[1]);
        }
        return $listRoles;
    }
    
    /**
     * Funcion que permite consultar el area en la que se encuentra un empleado
     * @param type $idArea Codigo del area en la que se encuentra registrado un empleado
     * @return Array asociativo con el codigo y area en la que se encuentra un empelado
     */
    function listAreaEmployee($idArea){
        $sql="select a.id, a.nombre from areas a where a.id='$idArea'";
        $resultList = mysqli_query($GLOBALS["conexionLi"], $sql);

        $listArea = array();

        while($rowArea = mysqli_fetch_array($resultList, MYSQLI_NUM)){
            // Se crea un array asociativo para almacenar el codigo y area de una empleado
            $listArea['id'] = $rowArea[0];
            $listArea['nombre'] = $rowArea[1];
        }

        return $listArea;
    }

    /**
     * Funcion que permite eliminar del sistema un empleado
     * @param int $idEmployee Identificacion del empleado
     * @return N/A
     */
    function deleteEmployee($idEmployee){
         //Elimina los datos de la tabla empleado_rol
        $transaction = "START TRANSACTION";
        mysqli_query($GLOBALS["conexionLi"], $transaction);
        
        $sql1 = "delete er FROM empleado_rol er WHERE er.empleado_id = $idEmployee";
        $result1 = mysqli_query($GLOBALS["conexionLi"], $sql1);

        $sql2 = "delete e FROM empleado e WHERE e.id = $idEmployee";
        $result2 = mysqli_query($GLOBALS["conexionLi"], $sql2);

        $transaction = "COMMIT";
        mysqli_query($GLOBALS["conexionLi"], $transaction);

        if ($result1 == true && $result2 == true) {
            echo '
                <script type="text/javascript">
                    var myModal = new bootstrap.Modal(document.getElementById("myModalDelete"));
                    myModal.show();

                    var modalDelete = document.getElementById("myModalDelete");
                    modalDelete.addEventListener("hidden.bs.modal", function () {
                        window.location = "EmployeeList.php";
                    });
                </script>
            ';
        } else {
            alertError("Ocurrió un error y no se pudo eliminar el usuario");
            echo '
                <script type="text/javascript">
                    var modalDeleteError = document.getElementById("myModalError");
                    modalDeleteError.addEventListener("hidden.bs.modal", function () {
                        window.location = "EmployeeList.php";
                    });
                </script>
            ';
        }
    }

    function queryEmployee($idEmployee){
        $sql = "select e.id, e.nombre, e.email, e.sexo, a.id, e.descripcion, e.boletin FROM empleado e, areas a where e.area_id = a.id AND e.id = $idEmployee";
        $resultList = mysqli_query($GLOBALS["conexionLi"], $sql);

        $listRoles = array();
        $listArea = array();
        
        while($rowEmployee = mysqli_fetch_array($resultList, MYSQLI_NUM)){
            $listRoles = listRolesEmployee($rowEmployee[0]);
            $listArea = listAreaEmployee($rowEmployee[4]);
            $employee = new Employee($rowEmployee[0], $rowEmployee[1], $rowEmployee[2], $rowEmployee[3], $listArea, $rowEmployee[5], $rowEmployee[6], $listRoles);
        }
        return $employee;
    }

    function updateEmployee(Employee $employee){
        $id = $employee->getId();
        $name = $employee->getName();
        $email = $employee->getEmail();
        $gender = $employee->getGender(); 
        $deparment = $employee->getDeparment();
        $description = $employee->getDescription();
        $newsletter = $employee->getNewsletter();
        $roles = $employee->getRole();

        $transaction = "START TRANSACTION";
        mysqli_query($GLOBALS["conexionLi"], $transaction);

        $sql1 = "UPDATE empleado SET nombre = '$name', email = '$email', sexo = '$gender', area_id = '$deparment', boletin = '$newsletter', descripcion = '$description' WHERE id = $id";
        $result1 = mysqli_query($GLOBALS["conexionLi"], $sql1);

        // Se elimina los roles del empleado de la tabla empleado_rol
        $sql2 = "DELETE FROM empleado_rol WHERE empleado_id=$id";
        $result2 = mysqli_query($GLOBALS["conexionLi"], $sql2);

        if (!empty($roles)) {
            foreach($roles as $rol){
                $sql3 = "insert into empleado_rol values('$id','$rol')";
                $result3 = mysqli_query($GLOBALS["conexionLi"], $sql3);
            }
        }

        $transaction = "COMMIT";
        mysqli_query($GLOBALS["conexionLi"], $transaction);    

        if ($result1 == true && $result2 == true && $result3 == true) {
            alertSucces("Se guardó la información del empleado exitosamente.");
            echo '
                <script type="text/javascript">
                    var modalupdate = document.getElementById("myModal");
                    modalupdate.addEventListener("hidden.bs.modal", function () {
                        window.location = "EmployeeList.php";
                    });
                </script>
            ';

        }else{
            alertError("Algo salió mal!!! La información no se pudo guardar.");
        }
    }


    /**
     * Lista todas las areas para cargar en la lista del formulario
     */
    function listAreas(){
        $sql="select a.id,a.nombre from areas a";
        
        return mysqli_query($GLOBALS["conexionLi"], $sql);
    }

    /**
     * Lista todos los roles para cargar en el formulario
     */
    function listRoles(){
        $sql="select r.id, r.nombre from roles r";
        
        return mysqli_query($GLOBALS["conexionLi"], $sql);
    }  
?>