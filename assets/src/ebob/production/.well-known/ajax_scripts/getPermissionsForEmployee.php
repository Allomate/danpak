<?php
require_once '../database/config.php';

$employee_id = $_POST["employee_id"];

$sql = "SELECT `id`, `employee_id`, `cx_dashboard`, `add_company`, `add_franchise`, `update_company`, `add_employee`, `view_employee`, `inbox`, `complain_heads`, `warehouse_inventory`, `location_inventory`, `inventory_requests`, `add_warehouse`, `dispatch_items`, `add_items`, `update_items`, `item_sale`, `add_targets`, `update_targets`, `permissions`, `pos_setup`, `warehouse_inventory_gallery`, `update_locations`, `location_inventory_gallery` FROM `access_rights` WHERE employee_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $employee_id);
$stmt->execute();
$stmt->bind_result($id, $employeeId, $dashboard, $add_company, $add_franchise, $update_company, $add_employee, $view_employee, $inbox, $complain_heads, $warehouse_inventory, $location_inventory, $inventory_requests, $add_warehouse, $dispatch_items, $add_items, $update_items, $item_sale, $add_targets, $update_targets, $access_rights, $pos_setup, $warehouse_inventory_gallery, $update_locations, $location_inventory_gallery);
while($stmt->fetch()){
	$details = array(
		'id' => $id,
		'employee_id' => $employee_id,
		'cx_dashboard' => $dashboard,
		'add_company' => $add_company,
		'update_company' => $update_company,
		'add_employee' => $add_employee,
		'view_employee' => $view_employee,
		'inbox' => $inbox,
		'complain_heads' => $complain_heads,
		'warehouse_inventory' => $warehouse_inventory,
		'location_inventory' => $location_inventory,
		'inventory_requests' => $inventory_requests,
		'add_warehouse' => $add_warehouse,
		'dispatch_items' => $dispatch_items,
		'add_items' => $add_items,
		'update_items' => $update_items,
		'item_sale' => $item_sale,
		'add_targets' => $add_targets,
		'update_targets' => $update_targets,
		'permissions' => $access_rights,
		'pos_setup' => $pos_setup,
		'warehouse_inventory_gallery' => $warehouse_inventory_gallery,
		'update_locations' => $update_locations,
		'location_inventory_gallery' => $location_inventory_gallery
	);
	die(json_encode($details));
}
?>