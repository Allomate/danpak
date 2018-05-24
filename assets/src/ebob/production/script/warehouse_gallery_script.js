$(document).ready(function(){
  $('.viewDetailBtn').click(function(){
    ajaxer('getItemData.php', { id: $(this).attr('id') }, function(response){
      $('#myModal').modal('show');
      var response = JSON.parse(response);
      $('.modal-title').text(response.name);
      $('#itemBarcode').text(response.barcode);
      $('#itemBrand').text(response.brand);
      $('#itemName').text(response.name);
      $('#itemPurchase').text(response.purchased);
      $('#itemSize').text(response.size);
      $('#itemSell').text(response.sale);
      $('#itemColor').text(response.color);
      $('#mainCategorySpan').text(response.main_category_name);
      $('#itemExp').text(response.expiry);
      $('#subCategorySpan').text(response.sub_category_name);
      $('#prodCategorySpan').text(response.product_category_name);
      $('#prodImgDisplay img').attr('src', response.image);
    });
  });
});

function ajaxer(url, data, handleData){
  $.ajax({
    type: 'POST',
    url: 'ajax_scripts/' + url,
    data: data,
    success: function(response){
      handleData(response);
    }
  });
}