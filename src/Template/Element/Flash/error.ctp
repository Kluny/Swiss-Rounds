<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}

if(isset($errors) && is_array($errors)) {
	$errorList = '<ul>';
	foreach($errors as $k => $error) {
		if(is_array($error)) {
			$error = '<pre>' . print_r($error, true) . '</pre>';
		} 
		$errorList .= '<li>' . $k . ':' . $error . '</li>';
	} 
	$errorList = '</ul>';
	
	$message .= $errorList;
}
?>
<div class="message error" onclick="this.classList.add('hidden');"><?= $message ?></div>
