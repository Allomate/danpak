<?php

class WebServices extends CI_Model
{

    public function GetAuth($key)
    {
        return $this->db->select('api_secret')->where('api_secret', $key)->get("service_secret_key")->row();
    }

    public function GetAuthSession($session)
    {
        return $this->db->select('session')->where('session', $session)->get("employee_session")->row();
    }

    public function GetRetailers($userInfo)
    {
        $username = $this->db->select('username')->where('session', $userInfo['session'])->get('employee_session')->row()->username;
        if ($this->db->select('employee_id')->where('employee_username', $username)->get('employees_info')->row()):
            $employee_id = $this->db->select('employee_id')->where('employee_username', $username)->get('employees_info')->row()->employee_id;
            if ($this->db->select('GROUP_CONCAT(retailer_id) as retailer_ids')->where(['employee_id' => $employee_id, 'LOWER(assigned_for_day)' => date("l")])->get('retailers_assignment')->row()):
                $retailerIds = $this->db->select('GROUP_CONCAT(retailer_id) as retailer_ids')->where(['employee_id' => $employee_id, 'LOWER(assigned_for_day)' => date("l")])->get('retailers_assignment')->row()->retailer_ids;
                return $this->db->select('id as retailer_id, retailer_name, retailer_phone, retailer_email, retailer_address, REPLACE(retailer_image,"./","' . base_url() . '") as retailer_image, retailer_lats, retailer_longs, (SELECT territory_name from territory_management where id = rd.retailer_territory_id) as territory_name, (SELECT count(*) FROM visits_marked where retailer_id = rd.id and DATE(created_at) = CURDATE()) as visit_marked, retailer_city, retailer_type_id, retailer_territory_id')->where("find_in_set(id, '" . $retailerIds . "')")->get("retailers_details rd")->result();
            endif;
        endif;
    }

    public function GetCategories()
    {
        return $this->db->select('sub_category_id as category_id, sub_category_name as category_name')->get("sub_categories")->result();
    }

    public function DoneVisits($userInfo)
    {
        $username = $this->db->select('username')->where('session', $userInfo['session'])->get('employee_session')->row()->username;
        $employee_id = $this->db->select('employee_id')->where('employee_username', $username)->get('employees_info')->row()->employee_id;
        if ($this->db->select('GROUP_CONCAT(retailer_id) as retailer_ids')->where('employee_id = '.$employee_id.' and LOWER(assigned_for_day) = LOWER(DAYNAME(CURDATE()))')->get('retailers_assignment')->row()):
            $retailersAssigned = $this->db->select('GROUP_CONCAT(retailer_id) as retailer_ids')->where('employee_id = '.$employee_id.' and LOWER(assigned_for_day) = LOWER(DAYNAME(CURDATE()))')->get('retailers_assignment')->row()->retailer_ids;
            if ($this->db->where('find_in_set(retailer_id, "' . $retailersAssigned . '") and employee_id = ' . $employee_id . ' and DATE(created_at) = CURDATE()')->get('visits_marked')->result()):
                $retailersList = $this->db->select('GROUP_CONCAT(retailer_id) as retailersList')->where('find_in_set(retailer_id, "' . $retailersAssigned . '") and employee_id = ' . $employee_id . ' and DATE(created_at) = CURDATE()')->get('visits_marked')->row()->retailersList;
                return $this->db->select('`id` as retailer_id, `retailer_name`, `retailer_phone`, `retailer_email`, `retailer_address`, `retailer_lats`, `retailer_longs`, `retailer_city`, `retailer_image`, `created_at`, (SELECT territory_name from territory_management where id = rd.retailer_territory_id) as territory_name, retailer_city')->where("find_in_set(id, '" . $retailersList . "')")->get("retailers_details rd")->result();
            else:
                return "No visits done";
            endif;
        else:
            return "No retailers assigned";
        endif;
    }

    public function GetRetailerTypes()
    {
        return $this->db->select('id as retailer_type_id, retailer_type_name')->get("retailer_types")->result();
    }

    public function GetAreas()
    {
        return $this->db->select('id as area_id, area_name')->get("area_management")->result();
    }

    public function GetTerritories()
    {
        return $this->db->select('id as territory_id, territory_name')->get("territory_management")->result();
    }

    public function StoreRetailerInformationOffline($retailerInfo)
    {
        $usersession = $retailerInfo['session'];
        $username = $this->db->select('username')->where('session', $usersession)->get('employee_session')->row()->username;
        $employee_id = $this->db->select('employee_id')->where('employee_username', $username)->get('employees_info')->row()->employee_id;
        unset($retailerInfo['session']);
        $exceptionsArray = array();
        $result = array();
        foreach ($retailerInfo["retailers"] as $ret) {
            $oldId = $ret["retailer_id"];
            unset($ret['retailer_id']);
            $ret["added_by"] = $employee_id;
            $response = $this->db->insert('retailers_details', $ret);
            if ($response) {
                $newId = $this->db->insert_id();
                $result[] = array('new_id' => $newId, 'old_id' => $oldId);
            } else {
                $exceptionsArray[] = array('old_id' => $oldId, 'error' => $response);
            }
        }
        if (sizeOf($exceptionsArray)):
            return array('status' => 'Exceptions', 'response' => $exceptionsArray);
        endif;
            return array('status' => 'Success', 'response' => $result);
    }

    public function StoreRetailerInformation($retailerInfo)
    {
        $usersession = $retailerInfo['session'];
        unset($retailerInfo['session']);
        $this->db->insert('retailers_details', $retailerInfo);
        $retailerIdLatest = $this->db->insert_id();
        $username = $this->db->select('username')->where('session', $usersession)->get('employee_session')->row()->username;
        $employee_id = $this->db->select('employee_id')->where('employee_username', $username)->get('employees_info')->row()->employee_id;
        return $this->db
            ->where('id', $retailerIdLatest)
            ->update('retailers_details', array('added_by' => $employee_id));
    }

    public function UpdateRetailerInformation($retailer_id, $retailerInfo)
    {
        $usersession = $retailerInfo['session'];
        unset($retailerInfo['session']);
        $username = $this->db->select('username')->where('session', $usersession)->get('employee_session')->row()->username;
        $employee_id = $this->db->select('employee_id')->where('employee_username', $username)->get('employees_info')->row()->employee_id;
        $retailerInfo["updated_by"] = $employee_id;
        return $this->db
            ->where('id', $retailer_id)
            ->update('retailers_details', $retailerInfo);
    }

    public function AuthenticateLogin($loginInfo)
    {
        return $this->db->where(['employee_username' => $loginInfo['username'], 'employee_password' => $loginInfo['password']])->get('employees_info')->row();
    }

    public function GenerateSession($loginInfo)
    {
        $this->db->delete('employee_session', array('username' => $loginInfo['username']));
        return $this->db->insert('employee_session', $loginInfo);
    }

    public function RemoveSessionSignout($signoutInfo)
    {
        return $this->db->delete('employee_session', array('session' => $signoutInfo['session']));
    }

    public function GetCatalogue($userInfo)
    {
        if ($this->db->select('username')->where('session', $userInfo['session'])->get('employee_session')->row()):
            $username = $this->db->select('username')->where('session', $userInfo['session'])->get('employee_session')->row()->username;
            if ($this->db->select('employee_id')->where('employee_username', $username)->get('employees_info')->row()):
                $employee_id = $this->db->select('employee_id')->where('employee_username', $username)->get('employees_info')->row()->employee_id;

                $datePeriods = $this->db->select("catalogue_id, active_from, active_till")->where("employee_id", $employee_id)->get("catalogue_assignment")->result();
                $catalogue_id = 0;
                foreach ($datePeriods as $dates) {
                    $begin = new DateTime($dates->active_from);
                    $end = clone $begin;
                    $end->modify($dates->active_till);
                    $end->setTime(0, 0, 1);
                    $interval = new DateInterval('P1D');
                    $daterange = new DatePeriod($begin, $interval, $end);
                    foreach ($daterange as $date) {
                        if ($date->format('Y-m-d') == date("Y-m-d")) {
                            $catalogue_id = $dates->catalogue_id;
                            break;
                        }
                    }
                }

                if ($catalogue_id):
                    if (isset($userInfo["category_id"])):
                        if ($this->db->select('pref_id')->where(['id' => $catalogue_id])->get('catalogues')->row()):
                            $prefIds = $this->db->select('pref_id')->where(['id' => $catalogue_id])->get('catalogues')->row()->pref_id;
                            $preferences = $this->db->select('item_id')->where('find_in_set(pref_id, ("' . $prefIds . '")) and sub_category_id = ' . $userInfo["category_id"])->group_by('item_id')->get('inventory_preferences ip')->result();
                            $response = array();
                            foreach ($preferences as $pref) {
                                $itemDetails = $this->db->select('pref_id, sub_category_id as category_id, (SELECT item_name from inventory_items where item_id = ip.item_id) as item_name, (SELECT unit_name from inventory_types_units where unit_id = ip.unit_id) as unit_name, item_quantity, REPLACE(item_thumbnail,"./","' . base_url() . '") as item_thumbnail, REPLACE(item_image,"./","' . base_url() . '") as item_image, item_trade_price, (item_trade_price-(((SELECT discount from retailer_types where id = (SELECT retailer_type_id from retailers_details where id = ' . $userInfo['retailer_id'] . '))/100)*(ip.item_trade_price))) as after_discount')->where('item_id = ' . $pref->item_id . ' and find_in_set(pref_id, "' . $prefIds . '") and find_in_set(sub_category_id, "' . $userInfo["category_id"] . '")')->get('inventory_preferences ip')->result();
                                $response[] = array('item_parent_data' => array('item_id' => $pref->item_id, 'item_name' => $this->db->select('item_name')->where('item_id', $pref->item_id)->get('inventory_items')->row()->item_name, 'item_sku' => $this->db->select('item_sku')->where('item_id', $pref->item_id)->get('inventory_items')->row()->item_sku), 'item_childeren_data' => $itemDetails);
                            }
                            return $response;
                        else:
                            return false;
                        endif;
                    else:
                        if ($this->db->select('pref_id')->where(['id' => $catalogue_id])->get('catalogues')->row()):
                            $prefIds = $this->db->select('pref_id')->where(['id' => $catalogue_id])->get('catalogues')->row()->pref_id;
                            $preferences = $this->db->select('item_id')->where('find_in_set(pref_id, ("' . $prefIds . '"))')->group_by('item_id')->get('inventory_preferences ip')->result();
                            $response = array();
                            foreach ($preferences as $pref) {
                                $itemDetails = $this->db->select('pref_id, sub_category_id as category_id, (SELECT item_name from inventory_items where item_id = ip.item_id) as item_name, (SELECT unit_name from inventory_types_units where unit_id = ip.unit_id) as unit_name, item_quantity, REPLACE(item_thumbnail,"./","' . base_url() . '") as item_thumbnail, REPLACE(item_image,"./","' . base_url() . '") as item_image, item_trade_price, (item_trade_price-(((SELECT discount from retailer_types where id = (SELECT retailer_type_id from retailers_details where id = ' . $userInfo['retailer_id'] . '))/100)*(ip.item_trade_price))) as after_discount')->where('item_id = ' . $pref->item_id . ' and find_in_set(pref_id, "' . $prefIds . '")')->get('inventory_preferences ip')->result();
                                $response[] = array('item_parent_data' => array('item_id' => $pref->item_id, 'item_name' => $this->db->select('item_name')->where('item_id', $pref->item_id)->get('inventory_items')->row()->item_name, 'item_sku' => $this->db->select('item_sku')->where('item_id', $pref->item_id)->get('inventory_items')->row()->item_sku), 'item_childeren_data' => $itemDetails);
                            }
                            return $response;
                        else:
                            return false;
                        endif;
                    endif;
                else:
                    return false;
                endif;
            else:
                return false;
            endif;
        else:
            return false;
        endif;

    }

    public function BookOrder($orderDetails)
    {
        if ($this->db->select('username')->where('session', $orderDetails['session'])->get('employee_session')->row()):
            $username = $this->db->select('username')->where('session', $orderDetails['session'])->get('employee_session')->row()->username;
            if ($this->db->select('employee_id')->where('employee_username', $username)->get('employees_info')->row()):
                $employee_id = $this->db->select('employee_id')->where('employee_username', $username)->get('employees_info')->row()->employee_id;

                $datePeriods = $this->db->select("catalogue_id, active_from, active_till")->where("employee_id", $employee_id)->get("catalogue_assignment")->result();
                $catalogue_id = 0;
                foreach ($datePeriods as $dates) {
                    $begin = new DateTime($dates->active_from);
                    $end = clone $begin;
                    $end->modify($dates->active_till);
                    $end->setTime(0, 0, 1);
                    $interval = new DateInterval('P1D');
                    $daterange = new DatePeriod($begin, $interval, $end);
                    foreach ($daterange as $date) {
                        if ($date->format('Y-m-d') == date("Y-m-d")) {
                            $catalogue_id = $dates->catalogue_id;
                            break;
                        }
                    }
                }

                unset($orderDetails['session']);
                if ($catalogue_id):
                    $orderDetails["catalogue_id"] = $catalogue_id;
                    $orderDetails["employee_id"] = $employee_id;
                    $pref_id = $orderDetails["pref_id"];
                    $item_quantity_booker = $orderDetails["item_quantity_booker"];
                    $booker_discount = $orderDetails["booker_discount"];
                    unset($orderDetails["pref_id"]);
                    unset($orderDetails["item_quantity_booker"]);
                    unset($orderDetails["booker_discount"]);
                    $campaign_id = "";
                    $campaign_pref_id = "";
                    $campaign_booker_quantity = "";
                    $campaign_booker_discount = "";
                    if(isset($orderDetails["campaign_id"])){
                        $campaign_id = $orderDetails["campaign_id"];
                        $campaign_pref_id = $orderDetails["campaign_pref_id"];
                        $campaign_booker_quantity = $orderDetails["campaign_booker_quantity"];
                        $campaign_booker_discount = $orderDetails["campaign_booker_discount"];
                        unset($orderDetails["campaign_id"]);
                        unset($orderDetails["campaign_pref_id"]);
                        unset($orderDetails["campaign_booker_quantity"]);
                        unset($orderDetails["campaign_booker_discount"]);
                        $campaign_id = explode(",", str_replace(' ', '', $campaign_id));
                        $campaign_pref_id = explode(",", str_replace(' ', '', $campaign_pref_id));
                        $campaign_booker_quantity = explode(",", str_replace(' ', '', $campaign_booker_quantity));
                        $campaign_booker_discount = explode(",", str_replace(' ', '', $campaign_booker_discount));
                    }
                    $orderDetails["invoice_number"] = mt_rand(1000000000, mt_getrandmax());
                    $this->db->insert('orders', $orderDetails);
                    $order_id = $this->db->insert_id();
                    $territory_id = $this->db->select('territory_id')->where('employee_id', $employee_id)->get('employees_info')->row()->territory_id;
                    $area_id = $this->db->select('area_id')->where('id', $territory_id)->get('territory_management')->row()->area_id;
                    $region_id = $this->db->select('region_id')->where('id', $area_id)->get('area_management')->row()->region_id;
                    if (!$this->db->where('id', $order_id)->update('orders', array("booking_territory" => $territory_id, "booking_area" => $area_id, "booking_region" => $region_id))):
                        return "Unable to update booker territory/area/region";
                    endif;
                    $pref_id = explode(",", $pref_id);
                    $item_quantity_booker = explode(",", $item_quantity_booker);
                    $booker_discount = explode(",", $booker_discount);
                    for ($i = 0; $i < sizeof($pref_id); $i++) {
                        $individualPriceForThisPrefId = $this->db->select('(item_trade_price-(((SELECT discount from retailer_types where id = (SELECT retailer_type_id from retailers_details where id = ' . $orderDetails['retailer_id'] . '))/100)*(ip.item_trade_price))) as after_discount')->where('pref_id', $pref_id[$i])->get('inventory_preferences ip')->row()->after_discount;
                        if ($booker_discount[$i]):
                            $individualPriceForThisPrefId = $individualPriceForThisPrefId - (($booker_discount[$i] / 100) * $individualPriceForThisPrefId);
                        endif;
                        $final_price = $individualPriceForThisPrefId * $item_quantity_booker[$i];
                        $orderContents[] = array("pref_id" => $pref_id[$i], "item_quantity_booker" => $item_quantity_booker[$i], "booker_discount" => $booker_discount[$i], "order_id" => $order_id, "final_price" => $final_price);
                        $deductFromThisQuantity = $this->db->select('item_quantity')->where('pref_id', $pref_id[$i])->get('inventory_preferences')->row()->item_quantity;
                        $finalQuantity = $deductFromThisQuantity - $item_quantity_booker[$i];
                        $this->db->where('pref_id', $pref_id[$i])->update('inventory_preferences', array('item_quantity' => $finalQuantity));
                    }
                    // return $this->db->insert_batch('order_contents', $orderContents);
                    if ($this->db->insert_batch('order_contents', $orderContents)):
                        if($campaign_id !== ""){
                            for ($i = 0; $i < sizeof($campaign_id); $i++) {
                                $campaign = $this->db->where('campaign_id', $campaign_id[$i])->get('campaign_management')->row();
                                $final_price =  $this->db->select('CEIL(((((((SELECT item_trade_price from inventory_preferences where pref_id = cm.eligibility_criteria_pref_id) - cm.scheme_amount))-(((SELECT discount from retailer_types where id = (SELECT retailer_type_id from retailers_details where id = ' . $orderDetails['retailer_id'] . '))/100)*((SELECT item_trade_price from inventory_preferences where pref_id = cm.eligibility_criteria_pref_id) - cm.scheme_amount)))) * "'.$campaign_booker_quantity[$i].'")) as final_price')->where('campaign_id', $campaign_id[$i])->get('campaign_management cm')->row()->final_price;
                
                                if($campaign->scheme_type !== "1") :
                                    $final_price = $this->db->select('CEIL((((((SELECT item_trade_price from inventory_preferences where pref_id = (SELECT min(item_inside_pref_id) from sub_inventory_management where inside_this_item_pref_id = cm.eligibility_criteria_pref_id)) - cm.discount_on_tp_pkr) - (((SELECT discount from retailer_types where id = (SELECT retailer_type_id from retailers_details where id = ' . $orderDetails['retailer_id'] . '))/100)*((SELECT item_trade_price from inventory_preferences where pref_id = (SELECT min(item_inside_pref_id) from sub_inventory_management where inside_this_item_pref_id = cm.eligibility_criteria_pref_id)) - cm.discount_on_tp_pkr))) * (SELECT min(quantity) from sub_inventory_management where inside_this_item_pref_id = cm.eligibility_criteria_pref_id)) * "'.$campaign_booker_quantity[$i].'")) as final_price')->where('campaign_id', $campaign_id[$i])->get('campaign_management cm')->row()->final_price;
                                endif;
                                
                                $orderContentsForCampaign[] = array("pref_id" => $campaign_pref_id[$i], "item_quantity_booker" => $campaign_booker_quantity[$i], "booker_discount" => $campaign_booker_discount[$i], "order_id" => $order_id, "campaign_id" => $campaign_id[$i], "final_price" => $final_price);
                                $deductFromThisQuantity = $this->db->select('item_quantity')->where('pref_id', $campaign_pref_id[$i])->get('inventory_preferences')->row()->item_quantity;
                                $finalQuantity = $deductFromThisQuantity - $campaign_booker_quantity[$i];
                                $this->db->where('pref_id', $campaign_pref_id[$i])->update('inventory_preferences', array('item_quantity' => $finalQuantity));
                            }

                            if ($this->db->insert_batch('order_contents', $orderContentsForCampaign)):
                                return "Success";
                            endif;
                        }else{
                            return "Success";
                        }
                    endif;
                else:
                    return "Unable to find catalogue for today";
                endif;
            else:
                return "Unable to find employee id with this username";
            endif;
        else:
            return "Unable to find employee with this session";
        endif;
    }

    public function UpdateEmployeePicture($empPic)
    {
        $employee_id = $this->db->select('employee_id')->where('employee_id = (SELECT employee_id from employees_info where employee_username = (SELECT username from employee_session where session = "' . $empPic['session'] . '"))')->get('employees_info')->row()->employee_id;
        return $this->db
            ->where('employee_id', $employee_id)
            ->update('employees_info', array('employee_picture' => $empPic["employee_picture"]));
    }

    public function GetProfile($employee)
    {
        return $this->db->select('`employee_id`, `employee_first_name`, `employee_last_name`, `employee_username`, `employee_password`, `employee_email`, `employee_address`, `employee_city`, `employee_country`, REPLACE(`employee_picture`, "./", "' . base_url() . '") as employee_picture, (SELECT CONCAT(employee_first_name," ", employee_last_name) from employees_info where employee_id = ei.employee_id) as reporting_to, (SELECT territory_name from territory_management where id = ei.territory_id) as territory, (SELECT area_name from area_management where id = (SELECT area_id from territory_management where id = ei.territory_id)) as area, (SELECT region_name from regions_info where id = (SELECT region_id from area_management where id = (SELECT area_id from territory_management where id = ei.territory_id))) as region, `employee_cnic`, `employee_hire_at`, `employee_fire_at`, `employee_designation`, `employee_phone`, `employee_salary`, `employee_base_station_lats`, `employee_base_station_longs`, `created_at`')->where('employee_id = (SELECT employee_id from employees_info where employee_username = (SELECT username from employee_session where session = "' . $employee['session'] . '"))')->get('employees_info ei')->row();
    }

    public function GetEmployeeOrders($employee)
    {
        $orderDetails = $this->db->select('id AS order_id, (SELECT retailer_name from retailers_details where id = orders.retailer_id) AS retailer_name, IFNULL(status, "Pending") AS status, invoice_number, (SELECT GROUP_CONCAT(pref_id) from order_contents where order_id = orders.id) as pref_id')->where('employee_id = (SELECT employee_id from employees_info where employee_username = (SELECT username from employee_session where session = "' . $employee['session'] . '"))')->get('orders')->result();
        foreach ($orderDetails as $order) {
            $order->pref_id = $this->db->select('(SELECT item_name from inventory_items where item_id = ip.item_id) as item_name, (SELECT unit_name from inventory_types_units where unit_id = ip.unit_id) as unit_name, (SELECT item_thumbnail from inventory_items where item_id = ip.item_id) as item_thumbnail, (SELECT item_quantity_booker from order_contents where pref_id = ip.pref_id and order_id = ' . $order->order_id . ') as item_quantity_booker, (SELECT final_price from order_contents where pref_id = ip.pref_id and order_id = ' . $order->order_id . ') as final_price')->where('find_in_set(pref_id, "' . $order->pref_id . '")')->get('inventory_preferences ip')->result();
        }
        return $orderDetails;

    }

    public function CheckStatus($attendanceData)
    {
        $employee_id = $this->db->select('employee_id')->where('employee_id = (SELECT employee_id from employees_info where employee_username = (SELECT username from employee_session where session = "' . $attendanceData['session'] . '"))')->get('employees_info')->row()->employee_id;

        if ($this->db->where('DATE(created_at) = CURDATE() and checking_status = 1 and employee_id = ' . $employee_id)->get('ams')->result()):
            if ($this->db->where('DATE(created_at) = CURDATE() and checking_status = 0 and employee_id = ' . $employee_id)->get('ams')->result()):
                return "1";
            else:
                return "2";
            endif;
        else:
            return "3";
        endif;
    }

    public function CheckInAttendance($attendanceData)
    {

        $employee_id = $this->db->select('employee_id')->where('employee_id = (SELECT employee_id from employees_info where employee_username = (SELECT username from employee_session where session = "' . $attendanceData['session'] . '"))')->get('employees_info')->row()->employee_id;

        if ($this->db->where('DATE(created_at) = CURDATE() and checking_status = 0 and employee_id = ' . $employee_id)->get('ams')->result()):
            return "Complete";
        endif;

        if ($this->db->where('DATE(created_at) = CURDATE() and checking_status = 1 and employee_id = ' . $employee_id)->get('ams')->result()):
            return "Exist";
        endif;

        $checkIn = array(
            'latitude' => $attendanceData['latitude'],
            'longitude' => $attendanceData['longitude'],
            'within_radius' => $attendanceData['within_radius'],
            'checking_status' => 1,
            'employee_id' => $employee_id,
        );
        return $this->db->insert('ams', $checkIn);
    }

    public function CheckOutAttendance($attendanceData)
    {

        $employee_id = $this->db->select('employee_id')->where('employee_id = (SELECT employee_id from employees_info where employee_username = (SELECT username from employee_session where session = "' . $attendanceData['session'] . '"))')->get('employees_info')->row()->employee_id;

        if ($this->db->where('DATE(created_at) = CURDATE() and checking_status = 0 and employee_id = ' . $employee_id)->get('ams')->result()):
            return "Exist";
        endif;

        if ($this->db->where('DATE(created_at) = CURDATE() and checking_status = 1 and employee_id = ' . $employee_id)->get('ams')->result()):
            $checkIn = array(
                'latitude' => $attendanceData['latitude'],
                'longitude' => $attendanceData['longitude'],
                'within_radius' => $attendanceData['within_radius'],
                'checking_status' => 0,
                'employee_id' => $this->db->select('employee_id')->where('employee_id = (SELECT employee_id from employees_info where employee_username = (SELECT username from employee_session where session = "' . $attendanceData['session'] . '"))')->get('employees_info')->row()->employee_id,
            );
            return $this->db->insert('ams', $checkIn);
        else:
            return "Unable";
        endif;
    }

    public function MarkVisit($visitData)
    {
        $employee_id = $this->db->select('employee_id')->where('employee_id = (SELECT employee_id from employees_info where employee_username = (SELECT username from employee_session where session = "' . $visitData['session'] . '"))')->get('employees_info')->row()->employee_id;
        if ($this->db->where('retailer_id = ' . $visitData["retailer_id"] . ' and employee_id = ' . $employee_id . ' and DATE(created_at) = CURDATE()')->get('visits_marked')->result()):
            return "Marked already for today";
        endif;

        $markVisit = array(
            'retailer_id' => $visitData["retailer_id"],
            'employee_id' => $this->db->select('employee_id')->where('employee_id = (SELECT employee_id from employees_info where employee_username = (SELECT username from employee_session where session = "' . $visitData['session'] . '"))')->get('employees_info')->row()->employee_id,
        );
        return $this->db->insert('visits_marked', $markVisit);
    }

    public function GetMarkStatus($visitData)
    {
        if ($this->db->where(['retailer_id' => $visitData["retailer_id"], 'assigned_for_day' => date("l")])->get('visits_marked')->row()) {
            return "Marked";
        } else {
            return "Unmarked";
        }
    }

    public function VisitPlan($planData)
    {

        $employee_id = $this->db->select('employee_id')->where('employee_id = (SELECT employee_id from employees_info where employee_username = (SELECT username from employee_session where session = "' . $planData['session'] . '"))')->get('employees_info')->row()->employee_id;

        if ($this->db->where('employee_id = ' . $employee_id . ' and DATE(plan_for_day) = CURDATE()')->get('employee_visit_plan')->result()):
            return "plan_exist";
        endif;

        $dataPlaning = array();

        $retailers = explode(",", $planData["retailersList"]);

        for ($i = 0; $i < sizeof($retailers); $i++) {
            $dataPlaning[] = array(
                'retailer_id' => $retailers[$i],
                'employee_id' => $employee_id,
            );
        }

        return $this->db->insert_batch('employee_visit_plan', $dataPlaning);

    }

    public function UpdateVisitPlan($planData)
    {

        $employee_id = $this->db->select('employee_id')->where('employee_id = (SELECT employee_id from employees_info where employee_username = (SELECT username from employee_session where session = "' . $planData['session'] . '"))')->get('employees_info')->row()->employee_id;
        if ($this->db->delete('employee_visit_plan', 'employee_id = ' . $employee_id . ' and DATE(plan_for_day) = CURDATE()')):
            $dataPlaning = array();
            $retailers = explode(",", $planData["retailersList"]);
            for ($i = 0; $i < sizeof($retailers); $i++) {
                $dataPlaning[] = array(
                    'retailer_id' => $retailers[$i],
                    'employee_id' => $employee_id,
                );
            }
            return $this->db->insert_batch('employee_visit_plan', $dataPlaning);
        else:
            return $this->db->delete('employee_visit_plan', 'employee_id = ' . $employee_id . ' and DATE(plan_for_day) = CURDATE()');
        endif;
    }

    public function GetVisitPlan($planData)
    {
        $employee_id = $this->db->select('employee_id')->where('employee_id = (SELECT employee_id from employees_info where employee_username = (SELECT username from employee_session where session = "' . $planData['session'] . '"))')->get('employees_info')->row()->employee_id;
        if (!$this->db->select('GROUP_CONCAT(retailer_id) as retailers')->where('employee_id = ' . $employee_id . ' and DATE(plan_for_day) = CURDATE()')->group_by('DATE(plan_for_day)')->get('employee_visit_plan')->row()):
            return "no_plan";
        endif;
        $retailersList = $this->db->select('GROUP_CONCAT(retailer_id) as retailers')->where('employee_id = ' . $employee_id . ' and DATE(plan_for_day) = CURDATE()')->group_by('DATE(plan_for_day)')->get('employee_visit_plan')->row()->retailers;
        if ($retailersList) {
            return $this->db->select('id as retailer_id, retailer_name, retailer_address, retailer_phone, retailer_lats, retailer_longs, (SELECT territory_name from territory_management where id = rd.retailer_territory_id) as territory_name, (SELECT IFNULL((SELECT count(retailer_id) from visits_marked where retailer_id = rd.id and employee_id = ' . $employee_id . ' and DATE(created_at) = CURDATE()), 0)) as visit_marked, retailer_city')->where("find_in_set(id, '" . $retailersList . "')")->get("retailers_details rd")->result();
        } else {
            return "no_plan";
        }
    }

    public function AnswerQuestionnaire($questionnaireData)
    {
        $employee_id = $this->db->select('employee_id')->where('employee_id = (SELECT employee_id from employees_info where employee_username = (SELECT username from employee_session where session = "' . $questionnaireData["session"] . '"))')->get('employees_info')->row()->employee_id;
        $questionnaireData["employee_id"] = $employee_id;
        unset($questionnaireData["session"]);
        return $this->db->insert('questionnaire_results', $questionnaireData);
    }

    public function GetQuestionnare($session)
    {
        $employee_id = $this->db->select('employee_id')->where('employee_id = (SELECT employee_id from employees_info where employee_username = (SELECT username from employee_session where session = "' . $session . '"))')->get('employees_info')->row()->employee_id;
        $findMyGroup = $this->db->select('GROUP_CONCAT(id) as id')->where("employee_id LIKE '%" . $employee_id . "%'")->get('bulletin_groups')->row();
        if ($findMyGroup):
            $findMyGroup = $findMyGroup->id;
            $questionnaire = $this->db->select('id as questionnaire_id, question, multiple_choices')->where("individual_id = " . $employee_id . " OR find_in_set(group_id, ('" . $findMyGroup . "'))")->get('questionnaires')->result();

            $counter = 0;
            foreach ($questionnaire as $value) {
                $choices = explode("<$>", $value->multiple_choices);
                $questionnaire[$counter]->choices = $choices;
                unset($questionnaire[$counter]->multiple_choices);
                $counter++;
            }
            return $questionnaire;
        else:
            $questionnaire = $this->db->select('id as questionnaire_id, question, multiple_choices')->where("individual_id = " . $employee_id . " OR group_id = " . $findMyGroup)->get('questionnaires')->result();

            if ($questionnaire):
                $counter = 0;
                foreach ($questionnaire as $value) {
                    $choices = explode("<$>", $value->multiple_choices);
                    $questionnaire[$counter]->choices = $choices;
                    unset($questionnaire[$counter]->multiple_choices);
                    $counter++;
                }
                return $questionnaire;
            else:
                return "No Questionnaire found";
            endif;
        endif;
    }

    public function GetBulletin($bulletinData)
    {
        $employee_id = $this->db->select('employee_id')->where('employee_id = (SELECT employee_id from employees_info where employee_username = (SELECT username from employee_session where session = "' . $bulletinData['session'] . '"))')->get('employees_info')->row();
        if ($employee_id):
            $employee_id = $employee_id->employee_id;
            $findMyGroup = $this->db->select('id')->where("employee_id LIKE '%" . $employee_id . "%'")->get('bulletin_groups')->row();
            if ($findMyGroup):
                $findMyGroup = $findMyGroup->id;
                $myMessages = $this->db->select('message, DATE(created_at) as sent_on')->where("individual_id = " . $employee_id . " OR group_id = " . $findMyGroup)->order_by("created_at", "desc")->get('bulletin_messages')->result();
                return $myMessages;
            else:
                return "No bulletins found";
            endif;
        else:
            return "No Employee found";
        endif;
    }

    public function StoreRouteData($routeData)
    {
        $employee_id = $this->db->select('employee_id')->where('employee_id = (SELECT employee_id from employees_info where employee_username = (SELECT username from employee_session where session = "' . $routeData['session'] . '"))')->get('employees_info')->row()->employee_id;
        unset($routeData["session"]);
        $routeData["employee_id"] = $employee_id;
        return $this->db->insert('employee_daily_routing', $routeData);
    }

    public function AddCampaignToCart($campData){
        $campaign = $this->db->where('campaign_id', $campData["campaign_id"])->get('campaign_management')->row();

        if($campaign->minimum_quantity_for_eligibility > $campData["item_quantity"]){
            return "Minimum eligibility criteria for this campaign is " . $campaign->minimum_quantity_for_eligibility . ' number of items. You are not eligible';
        }

        if($this->db->select('item_quantity')->where('pref_id', $campaign->eligibility_criteria_pref_id)->get('inventory_preferences')->row()->item_quantity < $campData["item_quantity"]){
            return "Stock quantity is not enough for this campaign";
        }

        if($campaign->scheme_type == "1") :
            return $this->db->select('eligibility_criteria_pref_id as pref_id, "'.$campData["item_quantity"].'" as quantity, (SELECT REPLACE(item_thumbnail,"./","' . base_url() . '") from inventory_preferences where pref_id = cm.eligibility_criteria_pref_id) as item_thumbnail, (SELECT item_name from inventory_items where item_id = (SELECT item_id from inventory_preferences where pref_id = cm.eligibility_criteria_pref_id)) as item_name, CEIL(((((((SELECT item_trade_price from inventory_preferences where pref_id = cm.eligibility_criteria_pref_id) - cm.scheme_amount))-(((SELECT discount from retailer_types where id = (SELECT retailer_type_id from retailers_details where id = ' . $campData['retailer_id'] . '))/100)*((SELECT item_trade_price from inventory_preferences where pref_id = cm.eligibility_criteria_pref_id) - cm.scheme_amount)))))) as individual_price, CEIL(((((((SELECT item_trade_price from inventory_preferences where pref_id = cm.eligibility_criteria_pref_id) - cm.scheme_amount))-(((SELECT discount from retailer_types where id = (SELECT retailer_type_id from retailers_details where id = ' . $campData['retailer_id'] . '))/100)*((SELECT item_trade_price from inventory_preferences where pref_id = cm.eligibility_criteria_pref_id) - cm.scheme_amount)))) * "'.$campData["item_quantity"].'")) as final_price')->where('campaign_id', $campData["campaign_id"])->get('campaign_management cm')->row();
        endif;
        return $this->db->select('eligibility_criteria_pref_id as pref_id, '.$campData["item_quantity"].' as item_quantity, (SELECT REPLACE(item_thumbnail,"./","' . base_url() . '") from inventory_preferences where pref_id = cm.eligibility_criteria_pref_id) as item_thumbnail, (SELECT item_name from inventory_items where item_id = (SELECT item_id from inventory_preferences where pref_id = cm.eligibility_criteria_pref_id)) as item_name, CEIL((((((SELECT item_trade_price from inventory_preferences where pref_id = (SELECT min(item_inside_pref_id) from sub_inventory_management where inside_this_item_pref_id = cm.eligibility_criteria_pref_id)) - cm.discount_on_tp_pkr) - (((SELECT discount from retailer_types where id = (SELECT retailer_type_id from retailers_details where id = ' . $campData['retailer_id'] . '))/100)*((SELECT item_trade_price from inventory_preferences where pref_id = (SELECT min(item_inside_pref_id) from sub_inventory_management where inside_this_item_pref_id = cm.eligibility_criteria_pref_id)) - cm.discount_on_tp_pkr))) * (SELECT min(quantity) from sub_inventory_management where inside_this_item_pref_id = cm.eligibility_criteria_pref_id)))) as individual_price, CEIL((((((SELECT item_trade_price from inventory_preferences where pref_id = (SELECT min(item_inside_pref_id) from sub_inventory_management where inside_this_item_pref_id = cm.eligibility_criteria_pref_id)) - cm.discount_on_tp_pkr) - (((SELECT discount from retailer_types where id = (SELECT retailer_type_id from retailers_details where id = ' . $campData['retailer_id'] . '))/100)*((SELECT item_trade_price from inventory_preferences where pref_id = (SELECT min(item_inside_pref_id) from sub_inventory_management where inside_this_item_pref_id = cm.eligibility_criteria_pref_id)) - cm.discount_on_tp_pkr))) * (SELECT min(quantity) from sub_inventory_management where inside_this_item_pref_id = cm.eligibility_criteria_pref_id)) * "'.$campData["item_quantity"].'")) as final_price')->where('campaign_id', $campData["campaign_id"])->get('campaign_management cm')->row();
    }

    public function GetCampaigns(){
        return $this->db->select('campaign_id, scheme_type, (SELECT item_name from inventory_items where item_id = (SELECT item_id from inventory_preferences where pref_id = cm.eligibility_criteria_pref_id)) as product, CONCAT(cm.minimum_quantity_for_eligibility, " ", (SELECT unit_plural_name from inventory_types_units where unit_id = (SELECT unit_id from inventory_preferences where pref_id = cm.eligibility_criteria_pref_id))) as minimum_quantity_for_eligibility, CONCAT(cm.minimum_quantity_for_eligibility,"+",cm.quantity_for_free_item) as scheme, campaign_name, REPLACE(scheme_image,"./","' . base_url() . '") as background_image, discount_on_tp_pkr')->where('scheme_active', 1)->get('campaign_management cm')->result();
    }

}
