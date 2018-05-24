<div id="dispatchInventModal" class="modal fade" role="dialog">
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
                  <span id="itemBarcodeDispatchLocationInvent"></span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-4">
                  <label>Name</label>
                </div>
                <div class="col-md-8">
                  <span id="itemNameDispatchLocationInvent"></span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-4">
                  <label>Size</label>
                </div>
                <div class="col-md-8">
                  <span id="itemSizeDispatchLocationInvent"></span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-4">
                  <label>Color</label>
                </div>
                <div class="col-md-8">
                  <span id="itemColorDispatchLocationInvent"></span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-4">
                  <label>Expiry</label>
                </div>
                <div class="col-md-8">
                  <span id="itemExpDispatchLocationInvent"></span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-6">
                  <label>Dispatch Quantity</label>
                </div>
                <div class="col-md-6">
                  <input type="number" class="form-control" id="reqQuantityInputDispatchLocationInvent" min="1">
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
                  <span id="itemBrandDispatchLocationInvent"></span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-4">
                  <label>Quantity</label>
                </div>
                <div class="col-md-8">
                  <span id="itemQuantityDispatchLocationInvent"></span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-4">
                  <label>Purchase</label>
                </div>
                <div class="col-md-8">
                  <span id="itemPurchaseDispatchLocationInvent"></span>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-4">
                  <label>Selling</label>
                </div>
                <div class="col-md-8">
                  <span id="itemSellDispatchLocationInvent"></span>
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