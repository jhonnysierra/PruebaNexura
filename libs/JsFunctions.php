<script type="text/javascript">
	/**
	 * Funcion que permite deshabilitar en retroceso en la pagina
	 */
	function noBack() {
        window.location.hash="no-back-button";
        window.location.hash="Again-No-back-button" //chrome
        window.onhashchange=function(){window.location.hash="no-back-button";}
    }
</script>    


    