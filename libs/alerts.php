<?php

require_once($_SERVER["DOCUMENT_ROOT"].'/PruebaNexura/config/config.php');
require(constant('PATH').'/views/shared/__header.php');

function alertSucces($message){
	echo '
		<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-centered">
		    <div class="modal-content">
		      <div class="modal-header bg-primary text-white">
		        <h5 class="modal-title" id="myModalLabel">Mensaje</h5>
		        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		      </div>
		      <div class="modal-body">'.$message.'
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cerrar</button>
		      </div>
		    </div>
		  </div>
		</div>
	';

	echo '
	<script type="text/javascript">

		var myModal = new bootstrap.Modal(document.getElementById("myModal"));
        myModal.show();

	</script>
	';
}

function alertError($message){
	echo '

		<!-- Modal -->
		<div class="modal fade" id="myModalError" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog modal-dialog-centered">
		    <div class="modal-content">
		      <div class="modal-header bg-danger text-white">
		        <h5 class="modal-title" id="myModalErrorLabel">Error</h5>
		        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		      </div>
		      <div class="modal-body">'.$message.'</div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
		      </div>
		    </div>
		  </div>
		</div>
	';

	echo '

	<script type="text/javascript">
		var myModalError = new bootstrap.Modal(document.getElementById("myModalError"));
        myModalError.show();
	</script>
	';
}

?>