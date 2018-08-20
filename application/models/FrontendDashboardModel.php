<?php

class FrontendDashboardModel extends CI_Model
{

    public function getChartsData()
    {
        $retOrDist = "ret";
        $data = $this->db->query("SELECT CONCAT((SELECT item_name from inventory_items where item_id = (SELECT item_id from inventory_preferences where pref_id = oc.pref_id)),' (', (SELECT unit_name from inventory_types_units where unit_id = (SELECT unit_id from inventory_preferences where pref_id = oc.pref_id)),')') as item,
        SUM(case when item_quantity_updated is null then item_quantity_booker when item_quantity_updated = 0 then item_quantity_booker else item_quantity_updated end) as quantity_sold from order_contents oc
        where order_id IN (SELECT id from orders where LOWER(status) = 'completed' and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."')))
        and pref_id != 0 and pref_id IS NOT NULL
        group by pref_id
        order by quantity_sold desc
        LIMIT 0, 10")->result();
        $index = 0;
        $total = array_sum(array_column($data, "quantity_sold"));
        foreach ($data as $val) {
            $data[$index]->percent = round(($val->quantity_sold / $total) * 100, 2);
            $index++;
        }
        return array("products_sold_by_category" => $this->db->query("SELECT category, SUM(quantity) as total from (SELECT id, pref_id, (SELECT sub_category_name from sub_categories where sub_category_id = (SELECT sub_category_id from inventory_preferences where pref_id = oc.pref_id)) as category,
        SUM((case when item_quantity_updated = 0 then item_quantity_booker when item_quantity_updated is null then item_quantity_booker else item_quantity_updated end)) as quantity FROM `order_contents` oc
        where order_id IN (SELECT id FROM `orders` where MONTH(created_at) = 7 and LOWER(status) = 'completed' and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."')))
        and pref_id != 0
        group by pref_id) as result_set
        group by category
        order by SUM(quantity) desc")->result(), "avg_daily_sale" => $this->db->query("SELECT FLOOR((DAYOFMONTH(created_at) - 1) / 7) + 1 as week, DAYNAME(DATE(created_at)) as day, DATE(created_at), ROUND((SELECT SUM(final_price) from order_contents where find_in_set(order_id, GROUP_CONCAT(orders.id)))) as daily_sale, count(*) as total_orders,
ROUND(((SELECT SUM(final_price) from order_contents where find_in_set(order_id, GROUP_CONCAT(orders.id)))/count(*))) as avg_daily_order FROM `orders`
where MONTH(created_at) = 7 and LOWER(status) = 'completed' and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."'))
group by DATE(created_at)")->result(), "top_10" => $data);
    }

    public function getSalesData()
    {
        $retOrDist = "ret";
        $visitVsOrderData = $this->db->query("SELECT took_order from visits_marked")->result();
        $productive = 0;
        foreach ($visitVsOrderData as $retailers) {
            if ($retailers->took_order == (int) "1") {
                $productive++;
            }
        }
        return array("mtd_sale" => $this->db->query("SELECT ROUND(SUM(final_price)) as mtd_sale from order_contents where order_id IN (SELECT id FROM `orders` where MONTH(created_at) = 7 and LOWER(status) = 'completed' and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."')))")->row()->mtd_sale, "projected_mtd_sale" => $this->db->query('SELECT ROUND((SELECT ROUND(SUM(final_price)) as achieved_sales from order_contents
        where order_id IN (SELECT id from orders
        where LOWER(status) = "completed"
        and MONTH(created_at) = 7 and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = "'.$retOrDist.'")) and DAY(DATE(created_at)) <= (SELECT DAY(DATE(created_at)) as passed_days from orders
            where LOWER(status) = "completed"
            and MONTH(created_at) = 7 and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = "'.$retOrDist.'"))
            group by DATE(created_at)
            order by DATE(created_at) desc
            LIMIT 1)
        order by DATE(created_at)))+(((SELECT ROUND(SUM(final_price)) as achieved_sales from order_contents
        where order_id IN (SELECT id from orders
        where LOWER(status) = "completed"
        and MONTH(created_at) = 7 and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = "'.$retOrDist.'"))
        and DAY(DATE(created_at)) <= (SELECT DAY(DATE(created_at)) as passed_days from orders
            where LOWER(status) = "completed"
            and MONTH(created_at) = 7 and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = "'.$retOrDist.'"))
            group by DATE(created_at)
            order by DATE(created_at) desc
            LIMIT 1)
        order by DATE(created_at)))/(SELECT DAY(DATE(created_at)) as passed_days from orders
        where LOWER(status) = "completed"
        and MONTH(created_at) = 7 and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = "'.$retOrDist.'"))
        group by DATE(created_at)
        order by DATE(created_at) desc
        LIMIT 1)) * (SELECT (DAY(LAST_DAY(created_at)))-DAY(DATE(created_at)) as remaining_days from orders
        where LOWER(status) = "completed"
        and MONTH(created_at) = 7 and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = "'.$retOrDist.'")) group by DATE(created_at) order by DATE(created_at) desc
        LIMIT 1))) as projected_mtd_sales')->row()->projected_mtd_sales, "gross_margin" => $this->db->query("SELECT CONCAT(ROUND((SUM(profit)/(SUM(items_booked*cost_price)))*100), '%') as gross_margin from (SELECT ROUND(final_price-(((CASE
    WHEN item_quantity_updated = 0 THEN item_quantity_booker
    WHEN item_quantity_updated IS NULL THEN item_quantity_booker
    ELSE item_quantity_updated
END))*(SELECT item_warehouse_price from inventory_preferences where pref_id = oc.pref_id)),2) as profit,
final_price,
((CASE
    WHEN item_quantity_updated = 0 THEN item_quantity_booker
    WHEN item_quantity_updated IS NULL THEN item_quantity_booker
    ELSE item_quantity_updated
END)) as items_booked, (SELECT item_warehouse_price from inventory_preferences where pref_id = oc.pref_id) as cost_price, (SELECT item_sku from inventory_items where item_id = (SELECT item_id from inventory_preferences where pref_id = oc.pref_id)) as sku from order_contents oc
where order_id IN (SELECT id FROM `orders` where MONTH(created_at) = 7 and LOWER(status) = 'completed' and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."')))) as gross_margin")->row()->gross_margin, "profit" => $this->db->query("SELECT ROUND(SUM(profit)) as profit from (SELECT ROUND(final_price-(((CASE
    WHEN item_quantity_updated = 0 THEN item_quantity_booker
    WHEN item_quantity_updated IS NULL THEN item_quantity_booker
    ELSE item_quantity_updated
END))*(SELECT item_warehouse_price from inventory_preferences where pref_id = oc.pref_id)),2) as profit,
final_price,
((CASE
    WHEN item_quantity_updated = 0 THEN item_quantity_booker
    WHEN item_quantity_updated IS NULL THEN item_quantity_booker
    ELSE item_quantity_updated
END)) as items_booked, (SELECT item_warehouse_price from inventory_preferences where pref_id = oc.pref_id) as cost_price, (SELECT item_sku from inventory_items where item_id = (SELECT item_id from inventory_preferences where pref_id = oc.pref_id)) as sku from order_contents oc
where order_id IN (SELECT id FROM `orders` where MONTH(created_at) = 7 and LOWER(status) = 'completed' and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."')))) as profit")->row()->profit, "total_orders" => $this->db->query("SELECT count(*) as total_orders from orders where LOWER(status) = 'completed' and MONTH(created_at) = 7 and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."'))")->row()->total_orders, "total_retail_visits" => $this->db->query("SELECT count(*) as total_retail_visits from visits_marked where MONTH(created_at) = 7 and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."'))")->row()->total_retail_visits, "success_order_ratio" => $this->db->query("SELECT ROUND((((SELECT count(*) from orders where MONTH(created_at) = 7 and status = 'completed' and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."')))/(SELECT count(*) FROM visits_marked where MONTH(created_at) = 7 and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."'))))*100)) as success_order_ratio")->row()->success_order_ratio, 'average_order_value' => $this->db->query('SELECT FORMAT(ROUND(((SELECT SUM(final_price) from order_contents)/count(*))), 0) as average_order from orders where retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id FROM `retailer_types` where retailer_or_distributor = "'.$retOrDist.'"))')->row()->average_order, "avg_products_per_order" => $this->db->query("SELECT ROUND(SUM((SELECT count(*) from order_contents where order_id = orders.id))/count(*), 2) as avg_products_per_order from orders
        where LOWER(status) = 'completed' and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."'))")->row()->avg_products_per_order, "active_employees" => $this->db->query("SELECT count(*) as active_employees from employees_info where employee_fire_at is NULL and employee_designation IN ('TSO', 'Order Booker')")->row()->active_employees, "total_employees" => $this->db->query("SELECT count(*) as total_employees from employees_info where employee_fire_at is NULL and employee_designation IN ('Order Booker', 'TSO')")->row()->total_employees, "avg_retailers_per_employee" => $this->db->query("SELECT ROUND(SUM(assigned)/count(*)) as avg_retailers_per_employee from (SELECT employee_id, count(*) as assigned from retailers_assignment
group by employee_id) as res_set")->row()->avg_retailers_per_employee, 'return_ratio' => $this->db->query("SELECT ROUND(((count(*)/(SELECT count(*) from visits_marked))*100), 2) as return_ratio from orders where LOWER(status) = 'cancelled' and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = 'ret'))")->row()->return_ratio, "avg_discount_per_order" => $this->db->query("SELECT ROUND(SUM(discount_given)/count(*),2) as avg_discount_per_order from (SELECT order_id, SUM(booker_discount) as discount_given from order_contents where order_id IN (SELECT id from orders where retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."'))) group by order_id) as result_set")->row()->avg_discount_per_order, "order_compliance" => $this->db->query("SELECT ROUND(((SELECT count(*) from orders where within_radius = 1)/(SELECT count(*) from orders))*100, 2) as order_compliance")->row()->order_compliance, "attendance_compliance" => $this->db->query("SELECT ROUND(((SELECT count(*) from ams where checking_status = 1 and within_radius = 1)/(SELECT count(*) from ams where checking_status = 1))*100, 2) as attendance_compliance")->row()->attendance_compliance, "visit_vs_orders_graph_data" => array("visited" => sizeOf($visitVsOrderData), "productive" => $productive, "total_retailers" => $this->db->query("SELECT count(*) as total_retailers from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."')")->row()->total_retailers), "avg_retailers_added_per_month" => $this->db->query("SELECT ROUND(SUM(total_retailers)/count(*)) avg_retailers_added_per_month from (SELECT count(*) as total_retailers from retailers_details group by MONTH(created_at)) as res_set")->row()->avg_retailers_added_per_month);
    }

    public function employeeReports($routeEmpId, $empDate){

        $retOrDist = "ret";
        
        $allOrdersForEmployee = $this->db->query("SELECT (SELECT count(*) from orders where retailer_id = rd.id and employee_id = ".$routeEmpId.") as orders, (SELECT count(*) from visits_marked where retailer_id = rd.id and employee_id = ".$routeEmpId.") as visits FROM retailers_details rd where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."') and id IN (SELECT retailer_id from retailers_assignment where employee_id = ".$routeEmpId.")")->result();
        
        $checkIn = $this->db->select('count(*), IFNULL(DATE_FORMAT(ADDTIME(TIME(created_at), "10:00:00"), "%r"), "Not checked in") as check_in_time')->where('employee_id = ' . $routeEmpId.' and checking_status = 1 and DATE(created_at) = "'.$empDate.'"')->get('ams')->row()->check_in_time;
        $checkOut = $this->db->select('count(*), IFNULL(DATE_FORMAT(ADDTIME(TIME(created_at), "10:00:00"), "%r"), "Not checked out") as check_out_time')->where('employee_id = ' . $routeEmpId.' and checking_status = 0 and DATE(created_at) = "'.$empDate.'"')->get('ams')->row()->check_out_time;

        $time_spent = "N/A";

        if($checkIn != "Not checked in" && $checkOut != "Not checked out"){
            $datetime1 = new DateTime($checkIn);
            $datetime2 = new DateTime($checkOut);
            $time_spent = $datetime1->diff($datetime2)->format('%hh %im');
        }

        $totalVisits = $this->db->query("SELECT took_order from visits_marked where employee_id = ".$routeEmpId." and DATE(created_at) = '".$empDate."' and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."'))")->result();
        $prodRatio = 0;
        if($totalVisits){
            $productiveVisits = 0;
            foreach ($totalVisits as $visit) {
                if ($visit->took_order == (int) "1") {
                    $productiveVisits++;
                }
            }
            $prodRatio = round(($productiveVisits/sizeOf($totalVisits))*100, 2);
        }

        return array("time_spent" => $time_spent, "check_in_time" => $checkIn, "check_out_time" => $checkOut, "today_sale" => $this->db->query("SELECT IFNULL(ROUND(SUM(final_price)), 0) as today_sale from order_contents where order_id IN (SELECT id FROM `orders` where status = 'completed' and employee_id = ".$routeEmpId." and DATE(created_at) = '".$empDate."' and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."')))")->row()->today_sale, "total_visits" => sizeOf($totalVisits), "productive_ratio" => $prodRatio."%", "avg_order_value" => $this->db->query("SELECT ROUND((SUM(total_sale)/count(*))) as avg_order_value from (SELECT id, ROUND((SELECT SUM(final_price) from order_contents where order_id = orders.id)) as total_sale from orders where status = 'completed' and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."')) and DATE(created_at) = '".$empDate."' and employee_id = ".$routeEmpId.") as avg_order_value")->row()->avg_order_value, "avg_products_per_order" => $this->db->query("SELECT ROUND(SUM((SELECT count(*) from order_contents where order_id = orders.id))/count(*), 2) as avg_products_per_order from orders
        where LOWER(status) = 'completed' and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."')) and DATE(created_at) = '".$empDate."' and employee_id = ".$routeEmpId)->row()->avg_products_per_order, "avg_discount_per_order" => $this->db->query("SELECT ROUND(SUM(discount_given)/count(*),2) as avg_discount_per_order from (SELECT order_id, SUM(booker_discount) as discount_given from order_contents where order_id IN (SELECT id from orders where employee_id = ".$routeEmpId." and DATE(created_at) = '".$empDate."' and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."'))) group by order_id) as result_set")->row()->avg_discount_per_order, "total_orders" => $this->db->query("SELECT count(*) as total_orders from orders where employee_id = ".$routeEmpId." and DATE(created_at) = '".$empDate."'")->row()->total_orders, "route_plan" => array('attendance' => $this->db->select('count(*), IFNULL(latitude, "") as route_lats, IFNULL(longitude, "") as route_longs')->where('employee_id = ' . $routeEmpId . ' and checking_status = 1 and DATE(created_at) = "' . $empDate . '"')->get('ams')->row(), 'shift_end' => $this->db->select('count(*), IFNULL(latitude, "") as route_lats, IFNULL(longitude, "") as route_longs')->where('employee_id = ' . $routeEmpId . ' and checking_status = 0 and DATE(created_at) = "' . $empDate . '"')->get('ams')->row(), "data" => $this->db->query("SELECT took_order, latitude, longitude, (SELECT retailer_name from retailers_details where id = vm.retailer_id) as retailer_name FROM `visits_marked` as vm where employee_id = ".$routeEmpId." and DATE(created_at) = '".$empDate."' and latitude != 0 and longitude != 0")->result()));
    }
    
    public function getEmployeeDays($empId){
        return $this->db->query("SELECT DATE(created_at) as date, count(*) as total FROM `visits_marked` where employee_id = ".$empId." group by DATE(created_at) order by DATE(created_at) desc")->result();
    }

    public function getRetailersData()
    {
        $retOrDist = "ret";
        $retailerVisits = $this->db->query("SELECT took_order from visits_marked where retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."'))")->result();
        $productiveVisits = 0;
        foreach ($retailerVisits as $visit) {
            if ($visit->took_order == (int) "1") {
                $productiveVisits++;
            }
        }
        $total_visits = sizeOf($retailerVisits);
        $productive_visits = $productiveVisits;

        $prodRet = $this->db->query("SELECT (SELECT count(*) from orders where retailer_id = rd.id) as ordered_times from retailers_details rd where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."')")->result();
        $prodRetailers = 0;
        foreach ($prodRet as $prod) {
            if ($prod->ordered_times > (int) "0") {
                $prodRetailers++;
            }
        }

        $reOrders = $this->db->query("SELECT (SELECT count(*) from orders where retailer_id = vm.retailer_id) as total_orders from visits_marked vm
        where took_order = 1 and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."'))")->result();
        $counter = 0;
        foreach ($reOrders as $val) {
            if ($val->total_orders > 1) {
                $counter++;
            }
        }
        return array("total_retail_outlets" => $this->db->query("SELECT count(*) as total_retail_outlets from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."')")->row()->total_retail_outlets, "productive_retail_outlets" => $prodRetailers, "avg_revenue" => $this->db->query("SELECT ROUND(SUM(sale_recorded)/count(*)) as avg_revenue from (SELECT retailer_id, ROUND((SELECT SUM(final_price) from order_contents where order_id IN (SELECT id from orders where retailer_id = ords.retailer_id)), 2) as sale_recorded FROM orders ords where retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."'))
        group by retailer_id) as res_set")->row()->avg_revenue, "re_orders" => round(($counter / sizeOf($reOrders)) * 100, 2)."%", "productive_visits" => $productive_visits, "total_visits" => sizeOf($retailerVisits), "productive_ratio" => round(array_sum(array_column($retailerVisits, 'took_order')) / sizeOf($retailerVisits)*100, 2)."%", "avg_expansion_ratio" => $this->db->query('SELECT round(((SUM(added_new)/assigned)/count(*))*100, 2) as avg_expansion_ratio from (SELECT count(*) as added_new, (SELECT count(*) from retailers_assignment where retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = "'.$retOrDist.'")) ) as assigned FROM `retailers_details` where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = "'.$retOrDist.'") group by MONTH(created_at)) as res_set')->row()->avg_expansion_ratio."%", "avg_sale_per_employee" => $this->db->query("SELECT ROUND(SUM(sale)/count(*)) as avg_sale_per_employee from (SELECT (SELECT SUM(final_price) from order_contents where order_id IN (SELECT id from orders where employee_id = ei.employee_id and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."')))) as sale, employee_id
FROM `employees_info` ei where employee_designation IN ('TSO', 'Order Booker')) as res_set")->row()->avg_sale_per_employee, "avg_productive_retailers_per_employee" => $this->db->query("SELECT ROUND(SUM(total_orders)/count(*)) avg_productive_retailers_per_employee from (SELECT employee_id, (SELECT count(DISTINCT retailer_id) from orders where retailer_id IN (SELECT retailer_id from retailers_assignment where employee_id = ei.employee_id)) as total_orders, (SELECT count(*) from retailers_assignment where employee_id = ei.employee_id) as retailers_assigned from employees_info ei) as result_set")->row()->avg_productive_retailers_per_employee, "churned_retailers" => $this->db->query("SELECT count(*) as churned_retailers from (SELECT
(SELECT count(*) from orders where retailer_id = rd.id and created_at >= DATE_SUB(NOW(), INTERVAL 45 DAY)) as ordered from retailers_details rd where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."')) as res_set where ordered = 0")->row()->churned_retailers, "avg_orders_per_retailer" => $this->db->query("SELECT ROUND(SUM(orders)/count(*), 2) as avg_orders_per_retailer from (SELECT (SELECT count(*) from orders where retailer_id = rd.id) as orders FROM retailers_details rd
where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."')) as res_set")->row()->avg_orders_per_retailer);

    }
    

    public function getRetailersChartsData()
    {
        $retOrDist = "ret";
        $data = $this->db->query("SELECT ROUND(total_revenue/total_orders, 2) as avg_revenue from (SELECT retailer_id, count(*) as total_orders, ROUND((SELECT SUM(final_price) from order_contents where order_id IN (SELECT id from orders where retailer_id = ords.retailer_id)), 2) as total_revenue from orders ords where retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."'))
        group by retailer_id) as res_set")->result();
        $resultArray = array();
        $counter0to300 = 0;
        $counter301to500 = 0;
        $counter501to1000 = 0;
        $counter1000 = 0;
        foreach ($data as $value) {
            if ($value->avg_revenue >= 0 && $value->avg_revenue <= 300) {
                $counter0to300++;
            } else if ($value->avg_revenue >= 301 && $value->avg_revenue <= 500) {
                $counter301to500++;
            } else if ($value->avg_revenue >= 501 && $value->avg_revenue <= 1000) {
                $counter501to1000++;
            } else {
                $counter1000++;
            }
        }
        $resultArray["0_300"] = $counter0to300;
        $resultArray["301_500"] = $counter301to500;
        $resultArray["501_1000"] = $counter501to1000;
        $resultArray["1000"] = $counter1000;
        return array("retail_outlets_data" => $this->db->query("SELECT booking_territory, territory, total_retailers_added, (SELECT count(*) from orders where retailer_id IN (SELECT id from retailers_details rd where rd.retailer_territory_id = res_set.booking_territory and retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."'))) as ordering_retailers
        from (SELECT booking_territory,
        (SELECT count(*) from retailers_details rd where rd.retailer_territory_id = orders.booking_territory and retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."')) as total_retailers_added,
        (SELECT territory_name from territory_management where id = orders.booking_territory) as territory
        from orders
        where retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."'))
        group by booking_territory) as res_set")->result(), "top_10_territories_data" => $this->db->query("SELECT territory, ROUND((SELECT SUM(final_price) from order_contents where order_id IN (SELECT id from orders where booking_territory = result_set.booking_territory and retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."'))))) as revenue from (SELECT booking_territory, (SELECT territory_name from territory_management where id = orders.booking_territory) as territory, count(*) as total_orders
        from orders where retailer_id IN (SELECT id from retailers_details where retailer_type_id IN (SELECT id from retailer_types where retailer_or_distributor = '".$retOrDist."'))
        group by booking_territory) as result_set
        order by revenue desc
        LIMIT 0, 10")->result(), "arpu" => $resultArray);
    }

}
