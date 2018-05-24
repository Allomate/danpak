<div id="requestInventModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <div class="row">
                <div class="col-md-4">
                  <label>Barcode</label>
                </div>
                <div class="col-md-8">
                  <span id="itemBarcode"></span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-4">
                  <label>Name</label>
                </div>
                <div class="col-md-8">
                  <span id="itemName"></span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-4">
                  <label>Size</label>
                </div>
                <div class="col-md-8">
                  <span id="itemSize"></span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-4">
                  <label>Color</label>
                </div>
                <div class="col-md-8">
                  <span id="itemColor"></span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-4">
                  <label>Expiry</label>
                </div>
                <div class="col-md-8">
                  <span id="itemExp"></span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-6">
                  <label>Request Quantity</label>
                </div>
                <div class="col-md-6">
                  <input type="number" class="form-control" id="reqQuantityInput" min="1">
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <div class="row">
                <div class="col-md-4">
                  <label>Brand</label>
                </div>
                <div class="col-md-8">
                  <span id="itemBrand"></span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-4">
                  <label>Quantity</label>
                </div>
                <div class="col-md-8">
                  <span id="itemQuantity"></span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-4">
                  <label>Purchase</label>
                </div>
                <div class="col-md-8">
                  <span id="itemPurchase"></span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-4">
                  <label>Selling</label>
                </div>
                <div class="col-md-8">
                  <span id="itemSell"></span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-4">
                  <label>Category</label>
                </div>
                <div class="col-md-8">
                  To be implemented
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-2" style="text-align: center">
          </div>
          <div class="col-md-8">
            <div class="form-group">
              <div class="row">
                <div class="col-md-4">
                  <input type="checkbox" name="showFranchise">
                  <label style="color: gray" id="franchiseLabel">From Location:</label>
                </div>
                <div class="col-md-8">
                  <select id="franchiseId" class="form-control" disabled="disabled">
                    <?php
                    require_once 'database/config.php';
                    $sql = "SELECT franchise_id, franchise_name from franchise_info where company_id = (SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?)) and franchise_id NOT IN (SELECT franchise_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?))";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('ss', $_COOKIE["US-K"], $_COOKIE["US-K"]);
                    $stmt->execute();
                    $stmt->bind_result($id, $name);
                    while ($stmt->fetch()) {?>
                    <option value="<?php echo $id;?>"><?php echo $name;?></option>
                    <?php }
                    ?>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-2"></div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default closeModal" data-dismiss="modal">Close</button>
        <button type="button" id="requestForInventory" class="btn btn-info">
          <img src="assets/raw/view-details-loader.gif" class="requestSpinner">
          <span id="reqBtnText">Request</span>
        </button>
      </div>
    </div>

  </div>
</div>