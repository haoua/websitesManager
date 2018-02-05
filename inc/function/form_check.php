<?php 
if (!isset($GLOBALS["erreur"])) {
	$GLOBALS["erreur"] = false;
}

function vide($data, $element){
	if (empty($data) || $data == "") {
		$GLOBALS["erreur"] = true;
		return "Merci de remplir le champ ".$element;
	}
}
