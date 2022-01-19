<?php
    require_once($_SERVER["DOCUMENT_ROOT"].'/PruebaNexura/config/config.php');
    require_once(constant('PATH').'/libs/conexion_li.php');
    require(constant('PATH').'/libs/alerts.php');

    $conexionLi = $conexion;
    
    function listArea(){
        $sql="select a.id,a.nombre from areas a";
        
        return mysqli_query($GLOBALS["conexionLi"], $sql);
    }

    function listRoles(){
        $sql="select r.id, r.nombre from roles r";
        
        return mysqli_query($GLOBALS["conexionLi"], $sql);
    }

    function saveEmployee(Employee $employee){
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

        $sql1 = "insert into empleado values('$id', '$name', '$email', '$gender', '$deparment', '$newsletter', '$description')";
        $result1 = mysqli_query($GLOBALS["conexionLi"], $sql1);

        if (!empty($roles)) {
            foreach($roles as $rol){
                $sql2 = "insert into empleado_rol values('$id','$rol')";
                $result2 = mysqli_query($GLOBALS["conexionLi"], $sql2);
            }
        }

        if ($result1 == true && $result2==true) {
            alertSucces("Se guardó la información del empleado exitosamente.");
        }else{
            alertError("Algo salió mal!!! La información no se pudo guardar.");
        }

        $transaction = "COMMIT";
        mysqli_query($GLOBALS["conexionLi"], $transaction);
    }

    function generateIdEmployee(){
        $maxId = "select max(id)+1 from empleado";
        $exeMaxId = mysqli_query($GLOBALS["conexionLi"], $maxId);
        $resulMaxId = mysqli_fetch_row($exeMaxId);

        return $resulMaxId[0];
    }
?>