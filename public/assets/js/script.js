
function alertDelete(){
	var x = confirm("Bạn có chắc muốn xoá bản ghi này không?");
	if (x)
		return true;
	else
		return false;
}


 $(document).ready(function(){
  $('a#del-imge-detail').on('click',function(){
    var _token = $("form[name='frmEditProduct']").find("input[name='_token']").val();
    $id = $(this).parent().find("img").attr('idHinh');
    var rid = $(this).parent().find("img").attr('id');
    $.ajax
     ({
     url: baseURL +'/dashboard/edit/product/img/'+$id,
     type: 'GET',
     dataType: 'html',
     success: function(data)
       {
          $('#'+rid).remove();
          console.log(data);
       }
     });
  });
});


 $(document).ready(function(){
  $('#add-image').click(function(){
    $('#insert-image-detail').append('<div class="form-group"><input type="file" name="fileImage[]"></div>');
  });
});




