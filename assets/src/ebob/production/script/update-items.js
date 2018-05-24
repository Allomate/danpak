$(document).ready(function(){
  $('#viewDetailsTable').DataTable();
  $('#viewDetailsTable_filter').css('float', 'right');
  var itemId = null;

  $('#mainCategoryDD').change(function(){
    var ajaxData = {
      'catId': $(this).val(),
      'catType': 'sub'
    };
    fetchCategories(ajaxData);
  });

  $('#subCatDD').change(function(){
    var ajaxData = {
      'catId': $(this).val(),
      'catType': 'sub'
    };
    fetchSubCategories(ajaxData, false, null);
  });

  $('#updateDetailsFromModal').click(function(){
    if ($('#updatebtnText').text() == "Update") {
      $('#itemName').hide();
      $('#itemNameInput').fadeIn();
      $('#itemBrand').hide();
      $('#itemBrandInput').fadeIn();
      $('#itemSize').hide();
      $('#itemSizeInput').fadeIn();
      $('#itemColor').hide();
      $('#itemColorInput').fadeIn();
      $('#itemQuantity').hide();
      $('#itemQuantityInput').fadeIn();
      $('#itemSell').hide();
      $('#itemSellInput').fadeIn();
      $('#itemPurchase').hide();
      $('#itemPurchaseInput').fadeIn();
      $('#itemExp').hide();
      $('#itemExpInput').fadeIn();
      $('#itemBarcode').hide();
      $('#itemBarcodeInput').fadeIn();
      $('#subCategoryDiv').hide();
      $('#mainCategoryDiv').hide();
      $('#prodCategoryDiv').hide();
      $('#updatingCategoriesDiv').fadeIn();
      $('#prodImgDisplay').hide();
      $('#prodImgDiv').fadeIn();

      $('#updatebtnText').text("Save");
      $('#updateDetailsFromModal').removeClass('btn-info');
      $('#updateDetailsFromModal').addClass('btn-success');
    }else{

      if( document.getElementById("itemImage").files.length > 0){
        $('#updateProdImageForm').ajaxSubmit({
          type: "POST",
          url: "ajax_scripts/updateItemImage.php",
          data: $('#updateProdImageForm').serialize(),
          cache: false,
          success: function (response) {
            if (response != "Success") {
              swal('Image Upload Failed', 'Unable to upload image at the moment', 'error');
            }
          }
        });
      }

      $('#updatebtnText').hide();
      $('.updateDetailsLoader').fadeIn();
      $('#updateDetailsFromModal').removeClass('btn-success');
      var ajaxData = {
        "itemId" : itemId,
        "itemName": $('#itemNameInput').val(),
        "itemBrand": $('#itemBrandInput').val(),
        "itemSize": $('#itemSizeInput').val(),
        "itemColor": $('#itemColorInput').val(),
        "itemExpiry": $('.expiryText').val(),
        "itemQuantity": $('#itemQuantityInput').val(),
        "itemPurchase": $('#itemPurchaseInput').val(),
        "itemSale": $('#itemSellInput').val(),
        "itemBarcode": $('#itemBarcodeInput').val(),
        "category_id": $('#prodCategoryDD').val(),
        "image_deleted": $('#imageDeleted').val()
      }
      ajaxer('update_item_details.php', ajaxData, function(response){
        if (response == "Success") {
          $('#itemName').fadeIn();
          $('#itemNameInput').hide();
          $('#itemBrand').fadeIn();
          $('#itemBrandInput').hide();
          $('#itemSize').fadeIn();
          $('#itemSizeInput').hide();
          $('#itemColor').fadeIn();
          $('#itemColorInput').hide();
          $('#itemQuantity').fadeIn();
          $('#itemQuantityInput').hide();
          $('#itemSell').fadeIn();
          $('#itemSellInput').hide();
          $('#itemPurchase').fadeIn();
          $('#itemPurchaseInput').hide();
          $('#itemExp').fadeIn();
          $('#itemExpInput').hide();
          $('#itemBarcode').fadeIn();
          $('#itemBarcodeInput').hide();
          $('#subCategoryDiv').fadeIn();
          $('#mainCategoryDiv').fadeIn();
          $('#prodCategoryDiv').fadeIn();
          $('#updatingCategoriesDiv').hide();
          $('#prodImgDisplay').fadeIn();
          $('#prodImgDiv').hide();

          $('#updatebtnText').fadeIn();
          $('.updateDetailsLoader').hide();
          $('.closeModal').fadeOut();
          $('#updatebtnText').text("Updated");
          $('#updateDetailsFromModal').addClass('btn-success');
          setTimeout(function(){
            $('#myModal').modal('hide');
            setTimeout(function(){
              location.reload();
            }, 500)
          }, 1000)
        }else{
          swal(
            'Failed',
            'Unable to update',
            'error'
            )
        }
      });

    }
  });

  $(document).on('click',".deleteItem",function(){
    var id = $(this).attr('id');
    swal({
      title: 'Are you certain to delete this item?',
      showCancelButton: true,
      confirmButtonText: 'Yes',
      showLoaderOnConfirm: true,
      preConfirm: function () {
        return new Promise(function (resolve, reject) {
          var ajaxData = { "itemId": id };
          ajaxer('delete_item.php', ajaxData, function(response){
            if (response == "Deleted") {
              swal({
                title: 'Item Deleted',
                type: 'success',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ok'
              }).then(function () {
                setTimeout(function(){
                  location.reload();
                }, 500);
              })
            }else{
              swal(
                'Failed',
                'Unable to delete this item',
                'error'
                )
            }
          });
        })
      },
      allowOutsideClick: false
    })

  });

  $(document).on('click',".deleteImgSpan",function(){
    if ($('#imageDeleted').val() == "") {
      $('#imageDeleted').val($(this).attr('id'));
    }else{
      $('#imageDeleted').val($('#imageDeleted').val()+","+$(this).attr('id'));
    }
    $(this).parent().parent().parent().parent().fadeOut(300);
  });

  $(document).on('click',".viewItemDetails",function(){
    $('#itemName').fadeIn();
    $('#itemNameInput').hide();
    $('#itemBrand').fadeIn();
    $('#itemBrandInput').hide();
    $('#itemSize').fadeIn();
    $('#itemSizeInput').hide();
    $('#itemColor').fadeIn();
    $('#itemColorInput').hide();
    $('#itemQuantity').fadeIn();
    $('#itemQuantityInput').hide();
    $('#itemSell').fadeIn();
    $('#itemSellInput').hide();
    $('#itemPurchase').fadeIn();
    $('#itemPurchaseInput').hide();
    $('#itemExp').fadeIn();
    $('#itemExpInput').hide();
    $('#itemBarcode').fadeIn();
    $('#itemBarcodeInput').hide();
    $('#subCategoryDiv').fadeIn();
    $('#mainCategoryDiv').fadeIn();
    $('#prodCategoryDiv').fadeIn();
    $('#updatingCategoriesDiv').hide();
    $('#prodImgDisplay').fadeIn();
    $('#prodImgDiv').hide();

    $('#updatebtnText').fadeIn();
    $('.updateDetailsLoader').hide();
    $('#updatebtnText').text("Update");
    $('#updateDetailsFromModal').addClass('btn-info');
    $('#updateDetailsFromModal').removeClass('btn-success');

    itemId = $(this).attr('id');
    $('#itemIdText').val(itemId);
    var col = $(this).parent().parent().children().index($(this).parent());
    var row = ($(this).parent().parent().parent().children().index($(this).parent().parent()) + 1);
    $('#viewDetailsTable tr:eq(' + row + ') td:eq(' + col + ') .viewItemDetails').removeClass('btn-info');
    $('#viewDetailsTable tr:eq(' + row + ') td:eq(' + col + ') #viewDetailsText').hide();
    $('#viewDetailsTable tr:eq(' + row + ') td:eq(' + col + ') .viewDetailsLoader').fadeIn();
    $('#viewDetailsTable tr:eq(' + row + ') td:eq(' + col + ') .viewItemDetails').attr('disabled', 'disabled');
    var ajaxData = {
      "id": itemId
    }
    
    ajaxer('getItemData.php', ajaxData, function(response){
      var response = JSON.parse(response);
      var ajaxData = {
        'catId': response.main_category,
        'catType': 'sub'
      };

      fetchCategories(ajaxData, response.sub_category, response.product_category, true);

      $('.modal-title').text(response.name + " - " + response.barcode);
      $('#itemName').text(response.name);
      $('#itemNameInput').val(response.name);
      $('#itemBrand').text(response.brand);
      $('#itemBrandInput').val(response.brand);
      $('#itemSize').text(response.size);
      $('#itemSizeInput').val(response.size);
      $('#itemColor').text(response.color);
      $('#itemColorInput').val(response.color);
      $('#itemQuantity').text(response.quantity);
      $('#itemQuantityInput').val(response.quantity);
      $('#itemPurchase').text(response.purchased);
      $('#itemPurchaseInput').val(response.purchased);
      $('#itemSell').text(response.sale);
      $('#itemSellInput').val(response.sale);
      $('#itemExp').text(response.expiry);
      $('#itemExpInput .expiryText').val(response.expiry);
      $('#itemBarcode').text(response.barcode);
      $('#mainCategoryDD').val(response.main_category);
      $('#imageDeleted').val("");
      $('#subCatDD').val(response.sub_category);
      $('#prodCategoryDD').val(response.product_category);
      $('#mainCategorySpan').text(response.main_category_name);
      $('#subCategorySpan').text(response.sub_category_name);
      $('#prodCategorySpan').text(response.product_category_name);
      if (response.image != "" && response.image != null) {
        debugger;
        var image = response.image.split(",");
        $('#prodImgDisplay img').attr('src', image[0]);
        $('#prodImgs').empty();
        for (var i = 0; i < image.length; i++) {
          $('#prodImgs').append("<div class='col-md-3'><article><header><img src='"+image[i]+"' width='100%' height='auto'></header><content><center><span class='deleteImgSpan' id='"+image[i]+"'>DELETE</span></center></content></article></div>");
        }
      }

      $('#itemBarcodeInput').val(response.barcode);
      $('#viewDetailsTable tr:eq(' + row + ') td:eq(' + col + ') .viewItemDetails').addClass('btn-info');
      $('#viewDetailsTable tr:eq(' + row + ') td:eq(' + col + ') .viewDetailsLoader').hide();
      $('#viewDetailsTable tr:eq(' + row + ') td:eq(' + col + ') #viewDetailsText').fadeIn();
      $('#viewDetailsTable tr:eq(' + row + ') td:eq(' + col + ') .viewItemDetails').removeAttr('disabled');
      $('#myModal').modal('show');
    });
  });
});

function fetchCategories(ajaxData, responseDataSubCat, responseDataProdCat, fetchSubCat){
  $("#ajax_loader").show();
  ajaxer('getCategories.php', ajaxData, function(response){
    var data = JSON.parse(response);
    $('#subCatDD').empty();
    for (var i = 0; i < data.length; i++) {
      $('#subCatDD').append('<option value="'+data[i]["id"]+'">'+data[i]["name"]+'</option>');  
    }

    var ajaxNewData = { 'catId': $('#subCatDD').val(), 'catType': 'product' };
    ajaxer('getCategories.php', ajaxNewData, function(response){
      var dataNew = JSON.parse(response);
      $('#prodCategoryDD').empty();
      for (var i = 0; i < dataNew.length; i++) {
        $('#prodCategoryDD').append('<option value="'+dataNew[i]["id"]+'">'+dataNew[i]["name"]+'</option>');  
      }
      if (responseDataProdCat != null && responseDataSubCat != null) {
        $('#subCatDD').val(responseDataSubCat);
        if (fetchSubCat == true) {
          var ajaxData = {
            'catId': $('#subCatDD').val(),
            'catType': 'product'
          };
          fetchSubCategories(ajaxData, true, responseDataProdCat);
        }
      }
    });
    $("#ajax_loader").hide();

  });
}

function fetchSubCategories(ajaxData, fetchProdCat, prodCatId){
  ajaxer('getCategories.php', ajaxData, function(response){
    var ajaxNewData = { 'catId': $('#subCatDD').val(), 'catType': 'product' };
    ajaxer('getCategories.php', ajaxNewData, function(response){
      var dataNew = JSON.parse(response);
      $('#prodCategoryDD').empty();
      for (var i = 0; i < dataNew.length; i++) {
        $('#prodCategoryDD').append('<option value="'+dataNew[i]["id"]+'">'+dataNew[i]["name"]+'</option>');  
      }

      if (fetchProdCat == true) {
        $('#prodCategoryDD').val(prodCatId);
      }

    });
  });
}

function ajaxer( url, data, handleData ){
  $.ajax({
    type: 'POST',
    url: 'ajax_scripts/' + url,
    data: data,
    success: function(response){
      handleData(response);
    }
  });
}