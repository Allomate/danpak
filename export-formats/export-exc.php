<?php
$connect = mysqli_connect("localhost", "root", "", "allomate_danpak");
    $output = '';
    $query = "SELECT (SELECT item_name from inventory_items where item_id = ip.item_id) as item_name, (SELECT unit_name from inventory_types_units where unit_id = ip.unit_id) as unit_name, (SELECT item_sku from inventory_items where item_id = ip.item_id) as item_sku, item_trade_price from inventory_preferences ip";
    if($_GET['brand'] != "0"){
        $brandSelected = strtolower(rawurldecode($_GET['brand']));
        $query = 'SELECT (SELECT item_name from inventory_items where item_id = ip.item_id) as item_name, (SELECT unit_name from inventory_types_units where unit_id = ip.unit_id) as unit_name, (SELECT item_sku from inventory_items where item_id = ip.item_id) as item_sku, item_trade_price from inventory_preferences ip where item_id IN (SELECT item_id from inventory_items where LOWER(item_brand) = "'.$brandSelected.'")';
    }
 $result = mysqli_query($connect, $query);
 $sno = 1;
 if(mysqli_num_rows($result) > 0)
 {
  $output .= '
   <table class="table" bordered="1">  
                    <tr>  
                        <th>S.No</th>
                        <th>Sku</th>
                        <th>Name</th>
                        <th>Unit</th>
                        <th style="width: 150px">Trade Price</th>
                    </tr>
  ';
  while($row = mysqli_fetch_array($result))
  {
   $output .= '
    <tr>  
            <td>'.$sno++.'</td>  
            <td>'.$row["item_sku"].'</td>  
            <td>'.$row["item_name"].'</td>
            <td>'.$row["unit_name"].'</td>  
            <td>'.$row["item_trade_price"].'</td>  
                    </tr>
   ';
  }
  $output .= '</table>';
  header('Content-Type: application/xls');
  header('Content-Disposition: attachment; filename=download.xls');
  echo $output;
 }
