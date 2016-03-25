
$(document).ready(function(){
	var user_href;
	var	user_href_splitted;
	var user_id;
	var img_src;
	var	img_src_splitted;
	var img_filename;
	var photo_id;

	$(".modal_thumbnails").click(function(){
		//alert("You are there!");//this one works
		$("#set_user_image").prop('disabled', false);
		user_href=$("#user-id").prop('href');//?	
		user_href_splitted = user_href.split("=");
		user_id = user_href_splitted[user_href_splitted.length - 1];
		// alert("user id for the one in edit is " + user_id);

		img_src=$(this).prop('src');
		img_src_splitted = img_src.split("/");
		img_filename = img_src_splitted[img_src_splitted.length - 1];
		// alert("the filename of the picture you just are selecting is " + img_filename);

		photo_id = $(this).attr('data'); //single quote is not working. Difference btwn .attr("data") & prop('data')
		// alert("the photo_id of the selected is " + photo_id);

		$.ajax({
			url: "includes/ajax_code.php",
			data: {photo_id:photo_id},
			type: "POST",
			success: function(data){
				if(!data.error){
					//location.reload(true);
					$("#modal_sidebar").html(data);
					//this make output data directly passed to
					// <div id="modal_sidebar"></div> in photo_library_modal.php
				}
			}
		})

	});



	$("#set_user_image").click(function(){
		//alert(img_filename);
		$.ajax({
			url: "includes/ajax_code.php",
			data: {img_filename:img_filename, user_id:user_id},
			type: "POST",
			success: function(data){
				if(!data.error){
					//location.reload(true);
					$(".user_image_box a img").prop('src', data);
			// this will assign the output data ( $user->ajax_save_user_image() )
			//            echo $this->image_path_and_placeholder();
			// to src="<?php echo $user->image_path_and_placeholder(); ?>" in edit_user.php

				}
			}

		})

	});



	/***** delete event confirm function ****/

	$(".delete_confirm").click(function(){

		return confirm("Are you sure you want to delete this item?");
	})


	tinymce.init({selector:'textarea'});	
});


