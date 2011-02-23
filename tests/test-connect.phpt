<?php
	require_once('functions.phpt');

	$conn = libvirt_connect('null');
	if (!is_resource($conn))
		bail('Connection to default hypervisor failed');

	$res = libvirt_node_get_info($conn);
	if (!is_array($res))
		bail('Node get info doesn\'t return an array');

	if (!is_numeric($res['memory']))
		bail('Invalid memory size');
	if (!is_numeric($res['cpus']))
		bail('Invalid CPU core count');
	unset($res);

	if (!libvirt_get_uri($conn))
		bail('Invalid URI value');

	if (!libvirt_get_hostname($conn))
		bail('Invalid hostname value');

	if (!($res = libvirt_domain_get_counts($conn)))
		bail('Invalid domain count');

	if ($res['active'] != count( libvirt_list_active_domains($conn)))
		bail('Numbers of active domains mismatch');

	if ($res['inactive'] != count( libvirt_list_inactive_domains($conn)))
		bail('Numbers of inactive domains mismatch');

	unset($res);
	unset($conn);

	success( basename(__FILE__) );
?>
