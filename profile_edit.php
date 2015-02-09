<?php
session_start();
include 'headers/_user-details.php';
	
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		$imgFrom="users";
		include 'headers/image_upload.php';
		$fname = $_POST['fname'];
		$description = $_POST['userDesc'];
		$lname = $_POST['lname'];
		//$school = $_POST['userSchool'];
		
		$query = "SELECT ID from colleges WHERE name = :cname";
		$sth = $dbh->prepare($query);
		$sth->bindValue(':cname','IBA INSTITUTE OF BUSINESS ADMINISTRATION');
		$sth->execute();
		$schoolID = $sth->fetchColumn();
		
		$sth = $dbh->prepare("UPDATE users SET fname = :fname, lname = :lname, profilePic = :profilePic, collegeID = :schoolID WHERE ID = :userID");
		$sth->bindValue(':fname',$fname);
		$sth->bindValue(':lname',$lname);
		$sth->bindValue(':profilePic',$profilePic);
		$sth->bindValue(':schoolID',$schoolID);
		$sth->bindValue(':userID',$_userID);
		$sth->execute();
		
		header("Location: $_username");
	}		
// ending if block of $_POST
?>



<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<title>User Profile</title>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap-tagsinput.css" type="text/css">

<link rel="stylesheet" href="css/style.css" type="text/css">
<link rel="stylesheet" href="css/media.css" type="text/css">
<link rel="stylesheet" href="css/fontello.css" type="text/css">
<link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="css/jquery.sidr.dark.css" type="text/css">

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
  
  <form name="create_gig" action="profile_edit.php" method="post" enctype="multipart/form-data">
  
    <h2><?php echo $_username;?>'s Profile</h2>
    <div class="left_gig">
      <div class="form_row">
        <div class="label_wrap">
          <label for="firstname">First Name</label>
        </div>
        <div class="input_wrap user_fname" style="width:auto;">
          <input class="gig_text price" type="text" id="fname" value="<?php echo $_fname;?>" name="fname" style="width:198px;" required/>
        
        </div>
		<div class="label_wrap user_lname">
          <label for="lastname">Last Name</label>
        </div>
        <div class="input_wrap user_lname" style="width:auto;">
          <input class="gig_text price" type="text" id="lname" value="<?php echo $_lname;?>" name="lname" style="width:198px;" required/>
        </div>
      </div>
      <div class="form_row">
        <div class="label_wrap">
          <label for="gig_category">School</label>
        </div>
        <div class="input_wrap">
		<input type="text" class="form-control gig_text school_txt" value="<?php echo $_collegeName; ?>" name="userSchool" placeholder="School" size="" id="regsearch" onKeyUp="regfindmatch();" autocomplete="off" style="width:95%" required>
            <ul id ="regresults" name="schools" >
            </ul>
        <!--<select class="fake-dropdown fake-dropdown-double dropdown-inner " style="width:95%" name="school" required>
        <option value="0">Select School</option>-->
        <?php
			$sql = "SELECT category FROM kork_categories";
			$option_num = 1;
			foreach($dbh->query($sql) as $row) {
				$category = $row['category'];
				//echo "<option value='$option_num'>$category</option>";
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
          <label for="gig_gallery">Profile Picture</label>
        </div>
        <div class="input_wrap">
          <div class="file_input">
            <!--  <button type="file" class="btn_signup" name="file" id="name">Browse</button>  -->
            
            <input id="fileupload" type="file" name="file" multiple required >
            
            <p>JPEG file, 2MB Max, <span class="grey_c">you own the copyrights</span></p>
          </div>
        </div>
      </div>
      
      <div class="form_row">
        <div class="label_wrap">
          <label for="gig_desc">Description</label>
        </div>
        <div class="input_wrap gig_desc">
          <textarea class="gig_text desc" rows="10" maxlength="200" name="userDesc" required></textarea>
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
      <button type="submit" class="btn_signup">Save &amp; Continue</button>
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
</body>
</html>
