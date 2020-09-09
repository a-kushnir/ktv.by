<?php
include('../../lib/application.php');

function action_index()
{
	session_start();
	session_destroy();
	setcookie("PHPSESSID","",time()-3600,"/");
	redirect_to('index');
}
?>