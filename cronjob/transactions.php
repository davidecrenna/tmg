<?
	set_include_path('/home/topmanager/domains/topmanagergroup.com/public_html/');
	include 'area_header.php';
	$area = new Area();
	$area->Process_users_transactions();
?>