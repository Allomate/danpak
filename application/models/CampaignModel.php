<?php

class CampaignModel extends CI_Model{

	public function getAllCampaigns(){
		return $this->db->select('`campaign_id`, `campaign_name`, `eligibility_criteria_pref_id`, `minimum_quantity_for_eligibility`, `item_given_free_pref_id`, `quantity_for_free_item`, `scheme_amount`, `price_discount_of_this_pref_id`, `scheme_type`, `created_at`')->get("campaign_management cm")->result();
	}

	public function add_campaign($campaignData){
		return $this->db->insert('campaign_management', $campaignData);
	}

	public function getItemPrice($pref_id){
		return $this->db->select('item_trade_price')->where('pref_id', $pref_id)->get('inventory_preferences')->row()->item_trade_price;
	}

	public function getSingleCampaign($campaignId){
		return $this->db->where('campaign_id', $campaignId)->get("campaign_management")->row();
	}

	public function update_campaign($campaignId, $campaignData){
		return $this->db
				->where('campaign_id',$campaignId)	
					->update('campaign_management', $campaignData);
	}

	public function delete_campaign($campaignId){
		return $this->db->delete('campaign_management', array('campaign_id' => $campaignId)); 
    }
    
    public function getCampaignDetails($campaignId){
        if($this->db->select('scheme_type')->where('campaign_id', $campaignId)->get('campaign_management')->row()->scheme_type == "1") :
			return array('scheme_type'=> '1', 'data' => $this->db->select('(SELECT item_name from inventory_items where item_id = (SELECT item_id from inventory_preferences where pref_id = cm.eligibility_criteria_pref_id)) as item_name, cm.minimum_quantity_for_eligibility, cm.quantity_for_free_item, (cm.minimum_quantity_for_eligibility+cm.quantity_for_free_item) as qty, (SELECT item_trade_price from inventory_preferences where pref_id = cm.eligibility_criteria_pref_id) as `trade_price`, scheme_amount, (scheme_amount*((cm.minimum_quantity_for_eligibility+cm.quantity_for_free_item))) as amount_after_scheme_deduction, scheme_type')->where('campaign_id', $campaignId)->get('campaign_management cm')->row());
		elseif($this->db->select('scheme_type')->where('campaign_id', $campaignId)->get('campaign_management')->row()->scheme_type == "2"):
			return array('scheme_type'=> '2', 'data' => $this->db->select('(SELECT unit_plural_name from inventory_types_units where unit_id = (SELECT unit_id from inventory_preferences where pref_id = cm.eligibility_criteria_pref_id)) as packaging, (SELECT item_trade_price from inventory_preferences where pref_id = cm.eligibility_criteria_pref_id) * cm.minimum_quantity_for_eligibility as packaging_price_total, (SELECT item_trade_price from inventory_preferences where pref_id = cm.eligibility_criteria_pref_id) as packaging_price_each, (SELECT unit_plural_name from inventory_types_units where unit_id = (SELECT unit_id from inventory_preferences where pref_id = (SELECT min(item_inside_pref_id) from sub_inventory_management where inside_this_item_pref_id = cm.eligibility_criteria_pref_id))) as containing_item, (SELECT min(quantity) from sub_inventory_management where inside_this_item_pref_id = cm.eligibility_criteria_pref_id) as containing_quantity, (SELECT item_trade_price from inventory_preferences where pref_id = (SELECT min(item_inside_pref_id) from sub_inventory_management where inside_this_item_pref_id = cm.eligibility_criteria_pref_id)) as containing_item_price_each, discount_on_tp_pkr, minimum_quantity_for_eligibility, (SELECT unit_short_name from inventory_types_units where unit_id = (SELECT unit_id from inventory_preferences where pref_id = cm.eligibility_criteria_pref_id)) as unit_short_name')->where('campaign_id', $campaignId)->get('campaign_management cm')->row());
        endif;
        return array('scheme_type'=> '3', 'data' => $this->db->select('(SELECT unit_plural_name from inventory_types_units where unit_id = (SELECT unit_id from inventory_preferences where pref_id = cm.eligibility_criteria_pref_id)) as packaging, (SELECT item_warehouse_price from inventory_preferences where pref_id = cm.eligibility_criteria_pref_id) * cm.minimum_quantity_for_eligibility as packaging_price_total, (SELECT item_warehouse_price from inventory_preferences where pref_id = cm.eligibility_criteria_pref_id) as packaging_price_each, offered_gift_price, minimum_quantity_for_eligibility, (SELECT unit_short_name from inventory_types_units where unit_id = (SELECT unit_id from inventory_preferences where pref_id = cm.eligibility_criteria_pref_id)) as unit_short_name')->where('campaign_id', $campaignId)->get('campaign_management cm')->row());
    }

}

?>
