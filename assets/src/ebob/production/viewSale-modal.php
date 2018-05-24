<style type="text/css">
.updateSaleViewModalSpinner{
  right: 5px; 
  top: 6px; 
  width: 20px; 
  height: 20px;
  display: none
}

</style>
<div id="saleModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="sale-modal-title"></h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="form-group">
            <label class="col-md-4">Quantity</label>
            <div class="col-md-8">
              <span id="itemQuantitySaleViewModal"></span>
            </div>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="form-group">
            <label class="col-md-4">Price (Each)</label>
            <div class="col-md-8">
              <span id="itemPriceEachSaleViewModal"></span>
            </div>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="form-group">
            <label class="col-md-4">Price (Total)</label>
            <div class="col-md-8">
              <span id="itemFinalPriceSaleViewModal"></span>
            </div>
          </div>
        </div>
        <div class="row" style="display: none" id="updateQuantityDiv">
          <br>
          <div class="form-group">
            <label class="col-md-4">Return Quantity</label>
            <input type="number" id="itemQuantityUpdateSaleViewModal" class="form-control" style="width: 20%; display: inline;">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default closeModal" data-dismiss="modal">Close</button>
        <button type="button" id="updateSaleViewModalButton" class="btn btn-info">
          <img src="assets/raw/view-details-loader.gif" class="updateSaleViewModalSpinner" style="height: 15px;">
          <span id="updateSaleViewModalText">Update</span>
        </button>
      </div>
    </div>
  </div>
</div>