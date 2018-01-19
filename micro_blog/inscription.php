<?php	
	require_once('lib/Smarty.class.php');

	$smarty=new Smarty();
	$smarty->assign('var',$var);

	include("haut.inc.php");

	$smarty->display('temp.tpl');
	
?>