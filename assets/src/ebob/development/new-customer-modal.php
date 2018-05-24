<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">New Customer</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="form-group">
            <label class="col-md-2" style="line-height: 33px; text-align: center">Name <span style="color: red">*</span></label>
            <div class="col-md-10">
              <input type="text" class="form-control" id="customerName">
            </div>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="form-group">
            <label class="col-md-2" style="line-height: 33px; text-align: center">Phone <span style="color: red">*</span></label>
            <div class="col-md-10">
              <input type="number" class="form-control" id="customerPhone">
            </div>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="form-group">
            <label class="col-md-2" style="line-height: 33px; text-align: center">Gender <span style="color: red">*</span></label>
            <div class="col-md-10" style="line-height: 33px">
              <input type="radio" name="gender" value="Male"> Male &nbsp;&nbsp;&nbsp;
              <input type="radio" name="gender" value="Female"> Female
            </div>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="form-group">
            <label class="col-md-2" style="line-height: 33px; text-align: center">Email</label>
            <div class="col-md-10" style="line-height: 33px">
              <input type="email" id="customerEmail" class="form-control">
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" style="height: 40px" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-sm btn-success" style="width: 45%; height: 40px" id="newCustomerModalButton" style="width: 100%; height: 40px">
          <img src="assets/raw/view-details-loader.gif" class='newCustomerModalSpinner'/>
          <span id="newCustomerModalText">Submit</span>
        </button>
      </div>
    </div>
  </div>
</div>