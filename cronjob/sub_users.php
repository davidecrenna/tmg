<?
	set_include_path('/home/topmanager/domains/topmanagergroup.com/public_html/');
	include 'area_header.php';
	$area = new Area();
	$area->Process_sub_users();
?>