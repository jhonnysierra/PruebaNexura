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
            return false;
        }        
    }
</script>    


    