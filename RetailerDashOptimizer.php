<?php

require_once './retailer-dash-optimizer-config.php';

$ctx = stream_context_create(array('http'=>
    array(
        'timeout' => 1200,  //1200 Seconds is 20 Minutes
    )
));

$json = file_get_contents('http://mgmt.danpakfoods.com/dashboard_services/Sales/RetailersData', false, $ctx);
$objRetsData = json_decode($json);

$json = file_get_contents('http://mgmt.danpakfoods.com/dashboard_services/Sales/RetailersDataCharts', false, $ctx);
$objRetsChartData = json_decode($json);

$sql = "DELETE FROM dashboard_retailer_temp";
$stmt = $conn->prepare($sql);
$stmt->execute();
$stmt->close();

$sql = "INSERT INTO `dashboard_retailer_temp`(`total_retail_outlets`, `productive_retail_outlets`, `avg_revenue`, `re_orders`, `productive_visits`, `total_visits`, `productive_ratio`, `avg_expansion_ratio`, `avg_sale_per_employee`, `avg_productive_retailers_per_employee`, `churned_retailers`, `avg_orders_per_retailer`, `created_at`) VALUES ('".$objRetsData->total_retail_outlets."','".$objRetsData->productive_retail_outlets."','".$objRetsData->avg_revenue."','".$objRetsData->re_orders."','".$objRetsData->productive_visits."','".$objRetsData->total_visits."','".$objRetsData->productive_ratio."','".$objRetsData->avg_expansion_ratio."','".$objRetsData->avg_sale_per_employee."','".$objRetsData->avg_productive_retailers_per_employee."','".$objRetsData->churned_retailers."','".$objRetsData->avg_orders_per_retailer."', DATE_ADD(NOW(), INTERVAL 10 HOUR))";
$stmt = $conn->prepare($sql);
$stmt->execute();
$stmt->close();

$retailerOutletData = "";
$counter = 0;
foreach($objRetsChartData->retail_outlets_data as $data){
    if($counter < (sizeOf($objRetsChartData->retail_outlets_data)-1)){
        $retailerOutletData .= "('" . $data->booking_territory . "', '" . $data->territory . "', '" . $data->total_retailers_added . "', '" . $data->ordering_retailers . "', 'retail_outlets_data', DATE_ADD(NOW(), INTERVAL 10 HOUR)), ";
    }else{
        $retailerOutletData .= "('" . $data->booking_territory . "', '" . $data->territory . "', '" . $data->total_retailers_added . "', '" . $data->ordering_retailers . "', 'retail_outlets_data', DATE_ADD(NOW(), INTERVAL 10 HOUR)) ";
    }
    $counter++;
}

$sql = "INSERT INTO `dashboard_retailer_temp`(`booking_territory`, `retail_outlet_territory`, `total_retailers_added`, `ordering_retailers`, `report_type`, `created_at`) VALUES ".$retailerOutletData;
$stmt = $conn->prepare($sql);
$stmt->execute();
$stmt->close();

$top10Territories = "";
$counter = 0;
foreach($objRetsChartData->top_10_territories_data as $data){
    if($counter < (sizeOf($objRetsChartData->top_10_territories_data)-1)){
        $top10Territories .= "('" . $data->territory . "', '" . $data->revenue . "', 'top_10_territories_data', DATE_ADD(NOW(), INTERVAL 10 HOUR)),";
    }else{
        $top10Territories .= "('" . $data->territory . "', '" . $data->revenue . "', 'top_10_territories_data', DATE_ADD(NOW(), INTERVAL 10 HOUR)) ";
    }
    $counter++;
}

$sql = "INSERT INTO `dashboard_retailer_temp`(`top_10_territory`, `revenue`, `report_type`, `created_at`) VALUES ".$top10Territories;
$stmt = $conn->prepare($sql);
$stmt->execute();
$stmt->close();

$result = json_decode(json_encode($objRetsChartData->arpu), true);
$sql = "INSERT INTO `dashboard_retailer_temp`(`0_300`, `301_500`, `501_1000`, `1000`, `report_type`, `created_at`) VALUES ('".$result["0_300"]."','".$result["301_500"]."','".$result["501_1000"]."','".$result["1000"]."', 'arpu', DATE_ADD(NOW(), INTERVAL 10 HOUR))";
$stmt = $conn->prepare($sql);
$stmt->execute();
$stmt->close();
echo "All Executions Successfull";
?>
