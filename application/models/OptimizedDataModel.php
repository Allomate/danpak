<?php

class OptimizedDataModel extends CI_Model
{

    public function getRetailersOptimizedData()
    {
        return array("retail_outlets_data" => $this->db->query("SELECT booking_territory, retail_outlet_territory, total_retailers_added, ordering_retailers from dashboard_retailer_temp where report_type = 'retail_outlets_data'")->result(), "top_10_territories_data" => $this->db->query("SELECT top_10_territory, revenue from dashboard_retailer_temp where report_type = 'top_10_territories_data'")->result(), "arpu" => $this->db->query("SELECT `1000`, `0_300`, `301_500`, `501_1000` from dashboard_retailer_temp where report_type = 'arpu'")->row(), "total_retail_outlets" => $this->db->query("SELECT total_retail_outlets from dashboard_retailer_temp where report_type IS NULL")->row()->total_retail_outlets, "productive_retail_outlets" => $this->db->query("SELECT productive_retail_outlets from dashboard_retailer_temp where report_type IS NULL")->row()->productive_retail_outlets, "avg_revenue" => $this->db->query("SELECT avg_revenue from dashboard_retailer_temp where report_type IS NULL")->row()->avg_revenue, "re_orders" => $this->db->query("SELECT re_orders from dashboard_retailer_temp where report_type IS NULL")->row()->re_orders, "productive_visits" => $this->db->query("SELECT productive_visits from dashboard_retailer_temp where report_type IS NULL")->row()->productive_visits, "total_visits" => $this->db->query("SELECT total_visits from dashboard_retailer_temp where report_type IS NULL")->row()->total_visits, "productive_ratio" => $this->db->query("SELECT productive_ratio from dashboard_retailer_temp where report_type IS NULL")->row()->productive_ratio, "avg_expansion_ratio" => $this->db->query("SELECT avg_expansion_ratio from dashboard_retailer_temp where report_type IS NULL")->row()->avg_expansion_ratio, "avg_sale_per_employee" => $this->db->query("SELECT avg_sale_per_employee from dashboard_retailer_temp where report_type IS NULL")->row()->avg_sale_per_employee, "avg_productive_retailers_per_employee" => $this->db->query("SELECT avg_productive_retailers_per_employee from dashboard_retailer_temp where report_type IS NULL")->row()->avg_productive_retailers_per_employee, "churned_retailers" => $this->db->query("SELECT churned_retailers from dashboard_retailer_temp where report_type IS NULL")->row()->churned_retailers, "avg_orders_per_retailer" => $this->db->query("SELECT avg_orders_per_retailer from dashboard_retailer_temp where report_type IS NULL")->row()->avg_orders_per_retailer);
    }

}