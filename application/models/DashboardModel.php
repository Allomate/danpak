<?php

class DashboardModel extends CI_Model
{

    public function Dashboardv1Stats()
    {
        return array('stat' => $this->db->select('count(*) as total_orders, (SELECT count(*) from orders where LOWER(status) = "completed") as completed_orders, (SELECT count(*) from orders where LOWER(status) = "cancelled") as cancelled_orders, (SELECT count(*) from visits_marked) as retail_visits, FORMAT(ROUND((SELECT SUM(final_price) from order_contents)), 0) as total_sale, FORMAT(ROUND(((SELECT SUM(final_price) from order_contents)/count(*))), 0) as average_order')->get('orders')->row(), 'top_products' => $this->db->query('SELECT CONCAT((SELECT item_name from inventory_items where item_id = (SELECT item_id from inventory_preferences where pref_id = oc.pref_id)), " (", (SELECT unit_name from inventory_types_units where unit_id = (SELECT unit_id from inventory_preferences where pref_id = oc.pref_id)), ")") as product, item_quantity_booker, ROUND(((item_quantity_booker/(SELECT SUM(item_quantity_booker) as total_quantities
        from ((SELECT item_quantity_booker FROM `order_contents` oc order by item_quantity_booker desc LIMIT 0,5)) as sumed))*100), 2) as percent_value FROM `order_contents` oc order by item_quantity_booker desc LIMIT 0,5')->result());
    }

    public function add_territory($territoryData)
    {
        return $this->db->insert('territory_management', $territoryData);
    }

    public function getSingleTerritory($territoryId)
    {
        return $this->db->where('id', $territoryId)->get("territory_management")->row();
    }

    public function update_territory($territoryId, $territoryData)
    {
        return $this->db
            ->where('id', $territoryId)
            ->update('territory_management', $territoryData);
    }

    public function delete_territory($territoryId)
    {
        return $this->db->delete('territory_management', array('id' => $territoryId));
    }

    public function getMerchantsInTerritory($territoryId)
    {
        return $this->db->select('retailer_lats, retailer_longs')->where('retailer_territory_id', $territoryId)->get('retailers_details')->result();
    }

    public function db_backup()
    {
        return $this->db->select('count(*) as exist')->where('DATE(created_at) = CURDATE() and LOWER(backup_status) = "success"')->get('database_backup')->row();
    }

}
