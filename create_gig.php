<?php
session_start();
include 'headers/_user-details.php';
?>



<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<title>Create Gig</title>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap-tagsinput.css" type="text/css">

<link rel="stylesheet" href="css/style.css" type="text/css">
<link rel="stylesheet" href="css/media.css" type="text/css">
<link rel="stylesheet" href="css/fontello.css" type="text/css">
<link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="css/jquery.sidr.dark.css" type="text/css">
<!--
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">-->
<!-- blueimp Gallery styles -->
<link rel="stylesheet" href="css/blueimp-gallery.min.css">
<script src="js/dropzone.min.js"></script>
<link href="css/dropzone.min.css" rel="stylesheet">

<style>
*, *:before, *:after {
	-webkit-box-sizing: initial;
	-moz-box-sizing: initial;
	box-sizing: initial;
}
img {
	vertical-align: top;
}
input[type="file"] {
display: initial;
}
p {
margin: initial;
}
</style>
<!--<script src="js/jquery.min.js"></script>-->
<script src="js/jquery-1.10.2.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.sidr.min.js"></script>
<script src="js/custom.js"></script>
<script src="js/bootstrap-tagsinput.js"></script>

<script>
$(document).ready(function() {
  $('#simple-menu').sidr();
});
</script>


<!--[if lt IE 9]>
	<script src="js/lib/html5shiv.js"></script>
<![endif]-->
</head>

<body>
<div class="inbox_des create_gig">
  <div class="header_bg">
    <header class="main-header"> <a id="simple-menu" class="icon-menu" href="#sidr"></a>
      <?php include 'headers/menu-top-navigation.php';?>
    </header>
    <div class="clear"></div>
  </div>
  <!--/.header_bg-->
  <div id="backgroundPopup"></div>
  <div class="content_inbox">
  <form name="create_gig" id="fileupload" method="post" enctype="multipart/form-data">
  	<!--<form id="fileupload"  method="POST" enctype="multipart/form-data">    action="create_gig.php" -->

  <!--<form id="fileupload" action="//jquery-file-upload.appspot.com/" method="POST" enctype="multipart/form-data">-->
  
    <h2>Create a new gig</h2>
    <div class="left_gig">
      <div class="form_row">
        <div class="label_wrap">
          <label for="gig_title">Gig Title</label>
        </div> 
        <div class="input_wrap gig_title">
          <input class="gig_text title" style="width:95%" maxlength="80"  name="korkName"/ required>
        </div>
        <aside class="gig-tooltip">
          <figure>
            <figcaption>
              <h3>Describe your Gig.</h3>
              <p>This is your Gig title. Choose wisely, you can only use 80 characters.</p>
            </figcaption>
            <div class="gig-tooltip-img"></div>
          </figure>
        </aside>
      </div>
      <div class="form_row">
        <div class="label_wrap">
          <label for="gig_category">Category</label>
        </div>
        <div class="input_wrap">
          <!--<div class="fake-dropdown fake-dropdown-double"> <a  class="dropdown-toggle category" data-toggle="dropdown" data-autowidth="true" >CATEGORIES</a>
            <div class="dropdown-menu mega_menu" >
              <div class="dropdown-inner">
                <ul>
                  <li>Gifts</li>
                  <li>Graphics & Design</li>
                  <li><a href="#">Video & Animation</a></li>
                  <li><a href="#">Online Marketing</a></li>
                  <li><a href="#">Writing & Translation</a></li>
                  <li><a href="#">Advertising</a></li>
                  <li><a href="#">Business</a></li>
                </ul>
              </div>
            </div>
            <div class="clear"></div>
          </div>-->
		<select class="fake-dropdown fake-dropdown-double dropdown-inner " style="width:95%" name="category" required>
        <option value="0">Select Category</option>
		<?php
			$sql = "SELECT category FROM kork_categories";
			$option_num = 1;
			foreach($dbh->query($sql) as $row) {
				$category = $row['category'];
				echo "<option value='$option_num'>$category</option>";
				$option_num++;
			}
		?>
        </select>
        </div>
        <aside class="gig-tooltip">
          <figure>
            <figcaption>
              <h3>Select a Category.</h3>
              <p>This is your Gig category. Choose wisely for better promotion.</p>
            </figcaption>
            <div class="gig-tooltip-img"></div>
          </figure>
        </aside>
      </div>
     <div class="form_row">
        <div class="label_wrap">
          <label for="gig_gallery">gig gallery</label>
        </div>
        <div class="input_wrap" id="gig_gallery_wrap">
        <div id="my-dropzone" class="dropzone">
			<div class="dropzone-previews"></div>
		</div>
    
          <!--<div class="file_input_inner">
            <!--  <button type="file" class="btn_signup" name="file" id="name">Browse</button>  -->
            
            <!--<input id="fileupload" type="file" name="file[]" multiple required>
            
            <p>JPEG file, 2MB Max, <span class="grey_c">you own the copyrights</span></p>
          </div>-->
		  
        </div>
      </div>
      
      <div class="form_row">
        <div class="label_wrap">
          <label for="taginput">Tags</label>
        </div>
        <div class="input_wrap gig_tags">
          <input class="gig_tags_text" type="text" data-role="tagsinput" id="taginput" name="taginput" />
        
        </div>
      </div>
      <div class="form_row">
        <div class="label_wrap">
          <label for="priceinput">Price</label>
        </div>
        <div class="input_wrap gig_price">
          <input class="gig_text price" type="number" id="priceinput" name="priceinput" style="width:95%;"/>
        
        </div>
      </div>
      
      <div class="form_row">
        <div class="label_wrap">
          <label for="gig_desc">Description</label>
        </div>
        <div class="input_wrap gig_desc">
          <textarea class="gig_text desc" rows="10" maxlength="200" name="korkDesc" required></textarea>
        </div>
      </div>
     <!-- <div class="form_row">
        <div class="label_wrap">
          <label for="gig_title">instruction for buyer</label>
        </div>
        <div class="input_wrap gig_title">
          <textarea class="gig_desc_text" rows="2" maxlength="80"></textarea>
        </div>
      </div> -->
    </div>
    <div class="bottom_save_block">
      <button id="submit-all" type="submit" class="btn_signup">Submit &amp; Continue</button> <!--onclick="submitForm('create_gig.php')"-->
      <button class="btn_signup btn_cancel">Cancel</button>
    </div>
	</form>
    <div class="clear"></div>
  </div>
  <?php include 'headers/menu-bottom-navigation.php' ?>
</div>
<script>
$(function() {      
          $("nav.main_nav li#admin > ul").css("display","none");
        
			       
           			$("nav.main_nav li#admin").hover(function () {   
         							  $( "nav.main_nav li#admin > ul" ).css( "display", "block" );
	            },          
            	function () {      
							           $( "nav.main_nav li#admin > ul" ).css( "display", "none" );
				        });   
				     });
					 
</script> 
<script>
	$(document).ready(function(e) {
        $('.input_wrap').on('focus', function(){
			$(this).find('.gig-tooltip').css('background','red');
			});
    });
</script> 
<script src="js/school-list.js"></script>
<!--multiple image upload starts here -->


<script src="js/jquery.min.js"></script>
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script>
function submitForm(action)
    {
        document.getElementById('form1').action = action;
        document.getElementById('form1').submit();
    }
</script>
<script src="js/vendor/jquery.ui.widget.js"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="js/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="js/load-image.all.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="js/canvas-to-blob.min.js"></script>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
<script src="js/bootstrap.min.js"></script>
<!-- blueimp Gallery script -->
<script src="js/jquery.blueimp-gallery.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="js/jquery.iframe-transport.js"></script>
<!-- The main application script -->
<script src="js/main.js"></script>
<script type="text/javascript">
	var myDropzone = new Dropzone("div#my-dropzone", { 
	url: "creating_gig.php",
	method:"post",
	autoProcessQueue: false,
	paramName: "files",
        uploadMultiple: true,
        maxFiles: 100,
        init: function() {
            var submitButton = document.querySelector("#submit-all")
            dropzone = this; // closure

        submitButton.addEventListener("click", function(e) {
            e.preventDefault();
            e.stopPropagation();
            dropzone.processQueue(); // Tell Dropzone to process all queued files.
        });
            
        // Listen to the sendingmultiple event. In this case, it's the sendingmultiple event instead
        // of the sending event because uploadMultiple is set to true.
        this.on("sendingmultiple", function(file, xhr, formData) {
		// Gets triggered when the form is actually being sent.
          // Hide the success button or the complete form.
			var formValues = $('#fileupload').serialize();
			
			$.each(formValues.split('&'), function (index, elem) {
				var vals = elem.split('=');
				formData.append(vals[0],vals[1]);
			});
        });
        this.on("successmultiple", function(files, response) {
          // Gets triggered when the files have successfully been sent.
          // Redirect user or notify of success.
			if(response != "failed"){
				window.location = "cate_desc.php?korkID="+response;
			}
        });
        this.on("errormultiple", function(files, response) {
          // Gets triggered when there was an error sending the files.
          // Maybe show form again, and notify user of error
        });
		}
	});
</script>
</body>
</html>
