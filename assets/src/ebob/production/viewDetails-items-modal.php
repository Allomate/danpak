<style type="text/css">
  .deleteImgSpan, .deleteThumbSpan, .deleteColImgSpan, .deleteSizeGuide{
    background-color: brown; width: 100%; display: block; color: white; font-weight: bold; cursor: pointer; padding: 10px
  }
  .deleteImgSpan:hover, .deleteThumbSpan:hover, .deleteColImgSpan:hover, .deleteSizeGuide:hover{
    background-color: #42dff4;
  }
</style>
<div id="myModal" class="modal fade" role="dialog">
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
                  <input type="text" id="itemBarcodeInput" class="form-control" style="display: none" />
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
                  <input type="text" id="itemNameInput" class="form-control" style="display: none" />
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
                  <input type="text" id="itemSizeInput" class="form-control" style="display: none" />
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
                  <input type="text" id="itemColorInput" class="form-control" style="display: none" />
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
                  <div class='input-group date' id='itemExpInput' style="display: none" >
                    <input type='text' class="form-control expiryText" />
                    <span class="input-group-addon">
                      <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group" id="subCategoryDiv">
              <div class="row">
                <div class="col-md-4">
                  <label>Sub Category</label>
                </div>
                <div class="col-md-8">
                  <span id="subCategorySpan"></span>
                </div>
              </div>
            </div>
            <div class="form-group" id="prodImgDisplay">
              <div class="row">
                <div class="col-md-4">
                  <label>Image</label>
                </div>
                <div class="col-md-8">
                <img src="" width="164px" height="auto">
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
                  <input type="text" id="itemBrandInput" class="form-control" style="display: none" />
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
                  <input type="text" id="itemQuantityInput" class="form-control" style="display: none" />
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
                  <input type="number" id="itemPurchaseInput" class="form-control" style="display: none" />
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
                  <input type="number" id="itemSellInput" class="form-control" style="display: none" />
                </div>
              </div>
            </div>
            <div class="form-group" id="mainCategoryDiv">
              <div class="row">
                <div class="col-md-4">
                  <label>Main Category</label>
                </div>
                <div class="col-md-8">
                  <span id="mainCategorySpan"></span>
                </div>
              </div>
            </div>
            <div class="form-group" id="prodCategoryDiv">
              <div class="row">
                <div class="col-md-4">
                  <label>Product Category</label>
                </div>
                <div class="col-md-8">
                  <span id="prodCategorySpan"></span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row" id="updatingCategoriesDiv" style="display: none">
          <div class="col-md-4">
            <div class="form-group" style="text-align: center">
              <label class="control-label" style="text-align: center;">Main Category</label>
              <div class="col-md-12">
                <?php
                require_once 'database/config.php';
                $sql = "SELECT category_id, category_name from main_categories where company_category_id = ( SELECT company_category_id from company_info where company_id = (SELECT company_id from employees_info where employee_username = (SELECT employee from employee_session where session = ?))) order by category_name";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('s', $_COOKIE["US-K"]);
                $stmt->execute();
                $stmt->bind_result($catId, $catName);?>
                <select class="form-control" id="mainCategoryDD">
                  <?php while ($stmt->fetch()) {?>
                  <option value="<?php echo $catId;?>"><?php echo $catName;?></option>
                  <?php }
                  $stmt->close();
                  ?>
                </select>  
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group" style="text-align: center;">
              <label class="control-label" style="text-align: center;">Sub Category</label>
              <div class="col-md-12">
                <select class="form-control" id="subCatDD">
                </select>  
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group" style="text-align: center">
              <label class="control-label" style="text-align: center;">Item Category</label>
              <div class="col-md-12">
                <select class="form-control" id="prodCategoryDD">
                </select>  
              </div>
            </div>
          </div>
        </div>
            <input type="text" id="imageDeleted" name="deleteImg" hidden>
        <div id="prodImgDiv" style="display: none">
          <h4>Product image</h4>
          <form method="post" class="form-horizontal" enctype="multipart/form-data" id="updateProdImageForm">
            <div class="form-group">
              <label class="col-md-3 control-label" style="text-align: center;">Update Image</label>
              <div class="col-md-9">
                <input type="file" id="itemImage" name="itemImage[]" data-input="false" multiple="multiple" class="form-control" accept=".png, .jpeg, .jpg, .bmp">
              </div>
            </div>
            <input type="text" id="itemIdText" name="itemId" hidden>
          </form>
          <div class="row">
            <div id="prodImgs"></div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default closeModal" data-dismiss="modal">Close</button>
        <button type="button" id="updateDetailsFromModal" class="btn btn-info">
          <img src="assets/raw/view-details-loader.gif" class="updateDetailsLoader" style="height: 15px;">
          <span id="updatebtnText">Update</span>
        </button>
      </div>
    </div>

  </div>
</div>
<div id='ajax_loader' style="position: fixed; left: 48%; top: 40%; display: none; z-index: 100000000">
  <img src="assets/raw/button-loader.gif" id="loading-indicator" style="width: auto; height: 50px" />
</div>