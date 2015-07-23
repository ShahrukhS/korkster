<?php
session_start();
	include 'headers/_user-details.php';
	$username = $_GET['username'];
	
	/* getting user details */
	$stmt = $dbh->prepare("SELECT u.ID, u.username, u.profilePic, u.fname, u.lname, u.active, u.joinDate, u.description, c.name, c.city FROM users u INNER JOIN colleges c ON u.collegeID = c.id WHERE u.username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
	if($row = $stmt->fetch()){
		$userID = $row['ID'];
		$username = $row['username'];
		$profilePic = $row['profilePic'];
		$fullname = $row['fname'].' '.$row['lname'];
        $activeFlag = $row['active'];
		$joinDate = $row['joinDate'];
		$description = $row['description'];
		
		$college_name = $row['name'];
		$city = $row['city'];
	}else{
		header("Location: 404.php");
		exit();
	}
	
	/* getting korks details */
	$stmt = $dbh->prepare("SELECT k.id, k.title, k.detail, k.price, k.image, k.status, k.expiryDate, kc.category, COUNT(i.korkID) as `bids` FROM korks k INNER JOIN kork_categories kc ON k.catID = kc.cat_id left outer join `inbox` i on k.id = i.korkID WHERE k.userID = :userID GROUP BY k.id ORDER BY k.id DESC");
    $stmt->bindParam(':userID', $userID);
    $stmt->execute();
    $allKorks = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	/*$now = time(); // or your date as well
    //$date = DateTime::createFromFormat("Y-m-d", $dateOfCreation);
    $joinDate = strtotime($joinDate);
    $datediff_user = $now - $joinDate;
    $joinedAgo = floor($datediff_user/(60*60*24));*/
	
	/** Number of Products **/
	$stmt = $dbh->prepare("SELECT count(id) FROM korks WHERE userID = :userID AND status > -1");
	$stmt->bindParam(':userID', $userID);
	$stmt->execute();
		
	$result = $stmt->fetchAll();
	$prod_num=$result[0][0];

    function nice_number($n) {
        // first strip any formatting;
        $n = (0+str_replace(",", "", $n));

        // is this a number?
        if (!is_numeric($n)) return false;

        // now filter it;
        /*if ($n > 1000000000000) return round(($n/1000000000000), 2).' trillion';
        elseif ($n > 1000000000) return round(($n/1000000000), 2).' B';*/
        if ($n > 1000000) return round(($n/1000000), 2).'M';
        elseif ($n > 1000) return round(($n/1000), 2).'K';

        return number_format($n);
    }
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<title><?php echo $username; ?> | WalknSell</title>
<link href="css/copied.css" media="all" rel="stylesheet" />
<link href="css/copied1.css" media="all" rel="stylesheet" />
<link href="css/copied2.css" media="all" rel="stylesheet" />
<link rel="stylesheet" href="css/style.css" type="text/css">
<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
<link rel="stylesheet" href="css/jquery.bxslider.css" type="text/css">
<link rel="stylesheet" href="css/media.css" type="text/css">
<link rel="stylesheet" href="css/fontello.css" type="text/css">
<link rel="stylesheet" href="css/jquery.sidr.dark.css" type="text/css">
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">
<style>
.modal-dialog {
	padding-top: 180px;
}
.modal-body {
	border-bottom: 0px;
}
*, *:before, *:after {
	-webkit-box-sizing: initial;
	-moz-box-sizing: initial;
	box-sizing: initial;
}
img {
vertical-align: top;
}
</style>
    
<?php
if(!empty($_SESSION['username'])){
    echo "<script>
        var sender = $_userID;
        var receiver = $userID;
        </script>";
}
?>

<script src="js/modern.js"></script>
<script src="js/jquery-1.10.2.min.js"></script>




<script src="js/jquery.fitvids.js"></script>
<script src="js/jquery.bxslider.js"></script>
<script src="js/jquery.sidr.min.js"></script>
<script src="js/custom.js"></script>
<script src="js/bootstrap.min.js"></script>

<script>
$(document).ready(function() {
  $('#simple-menu').sidr();
});

$(document).ready(function() {
   $(window).bind('scroll', function(e){
	   parallax();
	  });
});

function parallax(){
	var scrollposition = $(window).scrollTop();
	$('article.header_bg_para').css('top',(0-(scrollposition * 0.2))+'px');
	$('.full_article_bg').css('top',(0-(scrollposition * 1.1))+'px');
	}
</script>



<script>


var error;

$(document).ready(function(e) 
{
    
sendMessage();

	
});


function sendMessage()
{
    // variable to hold request
    var request;
    // bind to the submit event of our form
    $("#msgsend").on('click',function(event){
    // show loading bar until the json is recieved



    //alert(sender+receiver);

        request = $.ajax({
            url: "catlog_sendmsg.php",
            type: "post",
            data: {msg:$('#msg').val(),sender:sender,receiver:receiver}
        });

            // callback handler that will be called on success
        request.done(function (response, textStatus, jqXHR){
            // log a message to the console
            if(response=="Message Sent!"){
                $('#shoading').html('<span class =\'alert alert-success\'><strong>Your message has been sent successfully! </strong>.');
            }else {
                $('#shoading').html('<span class=\'alert alert-danger\'>Sorry, There has been an error in our system!' + response+'</span>');
            }

            //window.location.href = "your-questions.html";
        });

        // callback handler that will be called on failure
        request.fail(function (jqXHR, textStatus, errorThrown){
            // log the error to the console

            alert('Request Failed!');
            console.error(
                "The following error occured: "+
                textStatus, errorThrown
            );
        });

        // callback handler that will be called regardless
        // if the request failed or succeeded
        request.always(function () {
            // reenable the inputs
        });
	});
	
}



</script>



<!--[if lt IE 9]>
			<script src="js/lib/html5shiv.js"></script>
		<![endif]-->
</head>

<body>
<div class="wrapper">
    <div class="header_bg">
      <header class="main-header"> <a id="simple-menu" class="icon-menu" href="#sidr"></a>
        <?php include 'headers/menu-top-navigation.php';?>
      </header>
    </div>
      <?php include 'headers/subhead.php' ?>
      <div class="clear"></div>

  <div class="submenu_wrap">
    <div class="category_submenu">
      <nav>
        <ul class="topic-list">
          <li><a href="#">Advertising</a></li>
          <li><a href="#">Video &amp; Animation</a></li>
          <li><a href="#">Graphics &amp; Design</a></li>
          <li><a href="#">Programming &amp; Tech</a></li>
          <li><a href="#">Music &amp; Audio</a></li>
          <li><a href="#">Gifts</a></li>
          <li><a href="#">Fun &amp; Bizarre</a></li>
          <li><a href="#">Online Marketing</a></li>
          <li><a href="#">Writing &amp; Translation</a></li>
        </ul>
      </nav>
    </div>
  </div>
<!--/.header_bg-->
<!-- <article class="header_bg_para">

</article> -->
<?php include 'headers/popup.php';?>
<div class="main-content">
                    

                <script>
                    document.reviews_prefetched = {"total_count":1175,"ratings":[{"id":16021908,"rater_id":662039,"user_id":1938987,"is_seller":false,"value":10,"comment":"Excellent experience.  Very talented and easy to work with.  Highly recommended!","valuation":{"question_1_id":20,"question_1_value":10,"question_2_id":40,"question_2_value":10,"question_3_id":60,"question_3_value":10},"order_id":92053673,"created_at":"about 9 hours","updated_at":"2015-01-22T01:22:22.000Z","rater_username":"cblando","rater_name":null,"photo_size":"user-pict-50","work_sample_type":"image","work_sample":"//cdnil1.fiverrcdn.com/deliveries/4236815/medium/creative-logo-design_ws_1421770195.jpg?1421770195","rater_link":"/cblando","rater_image":"\u003cspan class=\"missing-image-user\"\u003ec\u003c/span\u003e","gig_link":"/umaisdesigns/design-killer-signature-logo"},{"id":16014767,"rater_id":2495909,"user_id":1938987,"is_seller":false,"value":10,"comment":"thx +++","valuation":{"question_1_id":20,"question_1_value":10,"question_2_id":40,"question_2_value":10,"question_3_id":60,"question_3_value":10},"order_id":92084478,"created_at":"about 17 hours","updated_at":"2015-01-21T17:44:25.000Z","rater_username":"dzhunt3r","rater_name":null,"photo_size":"user-pict-50","work_sample_type":"image","work_sample":"//cdnil0.fiverrcdn.com/deliveries/4242154/medium/creative-logo-design_ws_1421822466.jpg?1421822466","rater_link":"/dzhunt3r","rater_image":"\u003cspan class=\"missing-image-user\"\u003ed\u003c/span\u003e","gig_link":"/umaisdesigns/design-killer-signature-logo"},{"id":16007212,"rater_id":3547451,"user_id":1938987,"is_seller":false,"value":10,"comment":"Fantastic. I am so happy. Thanks alot. Quick service and great style. \r\n10 out of 10. ","valuation":{"question_1_id":20,"question_1_value":10,"question_2_id":40,"question_2_value":10,"question_3_id":60,"question_3_value":10},"order_id":91701197,"created_at":"1 day","updated_at":"2015-01-21T09:25:57.000Z","rater_username":"goldjonas","rater_name":null,"photo_size":"user-pict-50","work_sample_type":"image","work_sample":"//cdnil0.fiverrcdn.com/deliveries/4231711/medium/creative-logo-design_ws_1421718932.jpg?1421718932","rater_link":"/goldjonas","rater_image":"\u003cspan class=\"missing-image-user\"\u003eg\u003c/span\u003e","gig_link":"/umaisdesigns/design-a-killer-logo-with-unlimited-repetitions"},{"id":16002632,"rater_id":4191627,"user_id":1938987,"is_seller":false,"value":10,"comment":"Great turnaround time and beautiful design.","valuation":{"question_1_id":20,"question_1_value":10,"question_2_id":40,"question_2_value":10,"question_3_id":60,"question_3_value":10},"order_id":92070846,"created_at":"1 day","updated_at":"2015-01-21T02:24:58.000Z","rater_username":"samiam_pd","rater_name":null,"photo_size":"user-pict-50","work_sample_type":"image","work_sample":"//cdnil0.fiverrcdn.com/deliveries/4240363/medium/creative-logo-design_ws_1421802031.jpg?1421802031","rater_link":"/samiam_pd","rater_image":"\u003cspan class=\"missing-image-user\"\u003es\u003c/span\u003e","gig_link":"/umaisdesigns/design-killer-signature-logo"},{"id":16002238,"rater_id":2654374,"user_id":1938987,"is_seller":false,"value":10,"comment":"Awesome product and whoa, that was amazingly fast!","valuation":{"question_1_id":20,"question_1_value":10,"question_2_id":40,"question_2_value":10,"question_3_id":60,"question_3_value":10},"order_id":91944019,"created_at":"1 day","updated_at":"2015-01-21T01:55:04.000Z","rater_username":"oeildelynx","rater_name":null,"photo_size":"user-pict-50","rater_link":"/oeildelynx","rater_image":"\u003cimg src=\"//cdnil0.fiverrcdn.com/photos/2876145/small/ma_face.jpg?1395053581\"  alt=\"oeildelynx\"  width=\"60\" height=\"60\"\u003e","gig_link":"/umaisdesigns/design-a-killer-logo-with-unlimited-repetitions"},{"id":16001358,"rater_id":1609607,"user_id":1938987,"is_seller":false,"value":10,"comment":"The service and final product were stellar.  I highly recommend Umais Designs!","valuation":{"question_1_id":20,"question_1_value":10,"question_2_id":40,"question_2_value":10,"question_3_id":60,"question_3_value":10},"order_id":91615695,"created_at":"1 day","updated_at":"2015-01-21T00:48:24.000Z","rater_username":"steamteacher","rater_name":null,"photo_size":"user-pict-50","work_sample_type":"image","work_sample":"//cdnil0.fiverrcdn.com/deliveries/4238695/medium/creative-logo-design_ws_1421783276.jpg?1421783275","rater_link":"/steamteacher","rater_image":"\u003cspan class=\"missing-image-user\"\u003es\u003c/span\u003e","gig_link":"/umaisdesigns/design-a-killer-logo-with-unlimited-repetitions"},{"id":16000276,"rater_id":3268483,"user_id":1938987,"is_seller":false,"value":10,"comment":"Outstanding Experience!","valuation":{"question_1_id":20,"question_1_value":10,"question_2_id":40,"question_2_value":10,"question_3_id":60,"question_3_value":10},"order_id":92060433,"created_at":"1 day","updated_at":"2015-01-20T23:24:55.000Z","rater_username":"mattaudette","rater_name":null,"photo_size":"user-pict-50","rater_link":"/mattaudette","rater_image":"\u003cspan class=\"missing-image-user\"\u003em\u003c/span\u003e","gig_link":"/umaisdesigns/design-killer-signature-logo"},{"id":15998250,"rater_id":3986638,"user_id":1938987,"is_seller":false,"value":10,"comment":"Outstanding Experience!","valuation":{"question_1_id":20,"question_1_value":10,"question_2_id":40,"question_2_value":10,"question_3_id":60,"question_3_value":10},"order_id":91710108,"created_at":"1 day","updated_at":"2015-01-20T21:04:29.000Z","rater_username":"juddwheeler","rater_name":null,"photo_size":"user-pict-50","work_sample_type":"image","work_sample":"//cdnil0.fiverrcdn.com/deliveries/4238910/medium/creative-logo-design_ws_1421784978.jpg?1421784978","rater_link":"/juddwheeler","rater_image":"\u003cspan class=\"missing-image-user\"\u003ej\u003c/span\u003e","gig_link":"/umaisdesigns/design-a-killer-logo-with-unlimited-repetitions"},{"id":15994742,"rater_id":3369303,"user_id":1938987,"is_seller":false,"value":10,"comment":"Outstanding Experience!","valuation":{"question_1_id":20,"question_1_value":10,"question_2_id":40,"question_2_value":10,"question_3_id":60,"question_3_value":10},"order_id":92003321,"created_at":"1 day","updated_at":"2015-01-20T17:52:22.000Z","rater_username":"larandlancaster","rater_name":"Larand","photo_size":"user-pict-50","work_sample_type":"image","work_sample":"//cdnil0.fiverrcdn.com/deliveries/4229903/medium/creative-logo-design_ws_1421699667.jpg?1421699667","rater_link":"/larandlancaster","rater_image":"\u003cspan class=\"missing-image-user\"\u003el\u003c/span\u003e","gig_link":"/umaisdesigns/design-killer-signature-logo"},{"id":15994257,"rater_id":2805264,"user_id":1938987,"is_seller":false,"value":10,"comment":"My design is perfect! Thanks so much will definitely recommend to other buyer!","valuation":{"question_1_id":20,"question_1_value":10,"question_2_id":40,"question_2_value":10,"question_3_id":60,"question_3_value":10},"order_id":91803872,"created_at":"1 day","updated_at":"2015-01-20T17:26:57.000Z","rater_username":"chelseadennis","rater_name":"Chelsea","photo_size":"user-pict-50","work_sample_type":"image","work_sample":"//cdnil1.fiverrcdn.com/deliveries/4237169/medium/creative-logo-design_ws_1421772718.jpg?1421772718","rater_link":"/chelseadennis","rater_image":"\u003cspan class=\"missing-image-user\"\u003ec\u003c/span\u003e","gig_link":"/umaisdesigns/design-a-killer-logo-with-unlimited-repetitions"},{"id":15993723,"rater_id":2153869,"user_id":1938987,"is_seller":false,"value":10,"comment":"I am happy with the designs.","valuation":{"question_1_id":20,"question_1_value":10,"question_2_id":40,"question_2_value":10,"question_3_id":60,"question_3_value":10},"order_id":91380808,"created_at":"1 day","updated_at":"2015-01-20T17:02:28.000Z","rater_username":"srashok","rater_name":null,"photo_size":"user-pict-50","rater_link":"/srashok","rater_image":"\u003cimg src=\"//cdnil1.fiverrcdn.com/photos/2375635/small/Camera360_2013_11_26_06174820131126182108.jpg?1385734495\"  alt=\"srashok\"  width=\"60\" height=\"60\"\u003e","gig_link":"/umaisdesigns/design-a-killer-logo-with-unlimited-repetitions"},{"id":15993018,"rater_id":4003724,"user_id":1938987,"is_seller":false,"value":10,"comment":"Came up with three good designs and I definitely would go with him again for future work!","valuation":{"question_1_id":20,"question_1_value":10,"question_2_id":40,"question_2_value":10,"question_3_id":60,"question_3_value":10},"order_id":91291441,"created_at":"2 days","updated_at":"2015-01-20T16:28:37.000Z","rater_username":"alterityllc","rater_name":null,"photo_size":"user-pict-50","work_sample_type":"image","work_sample":"//cdnil0.fiverrcdn.com/deliveries/4216211/medium/creative-logo-design_ws_1421546233.jpg?1421546233","rater_link":"/alterityllc","rater_image":"\u003cspan class=\"missing-image-user\"\u003ea\u003c/span\u003e","gig_link":"/umaisdesigns/design-a-killer-logo-with-unlimited-repetitions"},{"id":15991011,"rater_id":1173010,"user_id":1938987,"is_seller":false,"value":9,"comment":"Good Experience!","valuation":{"question_1_id":20,"question_1_value":10,"question_2_id":40,"question_2_value":8,"question_3_id":60,"question_3_value":8},"order_id":91745198,"created_at":"2 days","updated_at":"2015-01-20T14:46:43.000Z","rater_username":"flyfrodo","rater_name":"Jeremy","photo_size":"user-pict-50","work_sample_type":"image","work_sample":"//cdnil0.fiverrcdn.com/deliveries/4230155/medium/creative-logo-design_ws_1421701598.jpg?1421701598","rater_link":"/flyfrodo","rater_image":"\u003cspan class=\"missing-image-user\"\u003ef\u003c/span\u003e","gig_link":"/umaisdesigns/design-a-killer-logo-with-unlimited-repetitions"},{"id":15986384,"rater_id":933186,"user_id":1938987,"is_seller":false,"value":10,"comment":"I am regular customer of this gig because of the high quality and good service!","valuation":{"question_1_id":20,"question_1_value":10,"question_2_id":40,"question_2_value":10,"question_3_id":60,"question_3_value":10},"order_id":91644689,"created_at":"2 days","updated_at":"2015-01-20T08:00:08.000Z","rater_username":"tommydh","rater_name":"Tommy","photo_size":"user-pict-50","rater_link":"/tommydh","rater_image":"\u003cimg src=\"//cdnil1.fiverrcdn.com/photos/1153925/small/fiverr.jpg?1378892250\"  alt=\"tommydh\"  width=\"60\" height=\"60\"\u003e","gig_link":"/umaisdesigns/design-a-killer-logo-with-unlimited-repetitions"},{"id":15984431,"rater_id":4089589,"user_id":1938987,"is_seller":false,"value":10,"comment":"i love it, Thank you, it was worth it. Thank you","valuation":{"question_1_id":20,"question_1_value":10,"question_2_id":40,"question_2_value":10,"question_3_id":60,"question_3_value":10},"order_id":91775842,"created_at":"2 days","updated_at":"2015-01-20T04:40:09.000Z","rater_username":"whattahek","rater_name":"Hector","photo_size":"user-pict-50","work_sample_type":"image","work_sample":"//cdnil0.fiverrcdn.com/deliveries/4232618/medium/creative-logo-design_ws_1421728195.jpg?1421728195","rater_link":"/whattahek","rater_image":"\u003cimg src=\"//cdnil1.fiverrcdn.com/photos/4311061/small/2014-06-09_13.42.24.jpg?1420346960\"  alt=\"whattahek\"  width=\"60\" height=\"60\"\u003e","gig_link":"/umaisdesigns/design-a-killer-logo-with-unlimited-repetitions"},{"id":15983475,"rater_id":4183928,"user_id":1938987,"is_seller":false,"value":10,"comment":"Simple and quick.  I received exactly what I had hoped.  Thank you Umaisdesigns.  Fiverr is good stuff.","valuation":{"question_1_id":20,"question_1_value":10,"question_2_id":40,"question_2_value":10,"question_3_id":60,"question_3_value":10},"order_id":92042654,"created_at":"2 days","updated_at":"2015-01-20T03:22:21.000Z","rater_username":"aalvarez1077","rater_name":null,"photo_size":"user-pict-50","work_sample_type":"image","work_sample":"//cdnil0.fiverrcdn.com/deliveries/4231482/medium/creative-logo-design_ws_1421716449.jpg?1421716449","rater_link":"/aalvarez1077","rater_image":"\u003cspan class=\"missing-image-user\"\u003ea\u003c/span\u003e","gig_link":"/umaisdesigns/design-killer-signature-logo"},{"id":15983144,"rater_id":3673733,"user_id":1938987,"is_seller":false,"value":10,"comment":"This is my first time using Fiverr, and you nailed it first try, and unbelievably accommodating. I am already using your services again with other companies I manage. Great job! ","valuation":{"question_1_id":20,"question_1_value":10,"question_2_id":40,"question_2_value":10,"question_3_id":60,"question_3_value":10},"order_id":91964561,"created_at":"2 days","updated_at":"2015-01-20T02:55:51.000Z","rater_username":"kevunger","rater_name":null,"photo_size":"user-pict-50","work_sample_type":"image","work_sample":"//cdnil1.fiverrcdn.com/deliveries/4231651/medium/creative-logo-design_ws_1421718291.jpg?1421718291","rater_link":"/kevunger","rater_image":"\u003cimg src=\"//cdnil1.fiverrcdn.com/photos/3895219/small/IMG_8325-Edit-3.jpg?1421286786\"  alt=\"kevunger\"  width=\"60\" height=\"60\"\u003e","gig_link":"/umaisdesigns/design-killer-signature-logo"},{"id":15982947,"rater_id":3975675,"user_id":1938987,"is_seller":false,"value":10,"comment":"He was very happy to continue to make modifications until we were pleased. Easy to work with, we will certainly use umaisdesigns again! ","valuation":{"question_1_id":20,"question_1_value":10,"question_2_id":40,"question_2_value":10,"question_3_id":60,"question_3_value":10},"order_id":91159963,"created_at":"2 days","updated_at":"2015-01-20T02:40:44.000Z","rater_username":"lsims40514","rater_name":null,"photo_size":"user-pict-50","work_sample_type":"image","work_sample":"//cdnil1.fiverrcdn.com/deliveries/4195604/medium/creative-logo-design_ws_1421338336.jpg?1421338336","rater_link":"/lsims40514","rater_image":"\u003cspan class=\"missing-image-user\"\u003el\u003c/span\u003e","gig_link":"/umaisdesigns/design-a-killer-logo-with-unlimited-repetitions"},{"id":15979908,"rater_id":1527290,"user_id":1938987,"is_seller":false,"value":10,"comment":"Awesome service love my logo! will definitely use again!","valuation":{"question_1_id":20,"question_1_value":10,"question_2_id":40,"question_2_value":10,"question_3_id":60,"question_3_value":10},"order_id":91999101,"created_at":"2 days","updated_at":"2015-01-19T22:54:30.000Z","rater_username":"coachrush","rater_name":"Rusharlette","photo_size":"user-pict-50","rater_link":"/coachrush","rater_image":"\u003cimg src=\"//cdnil1.fiverrcdn.com/photos/1750434/small/1401915238701_Profile.jpg?1401915239\"  alt=\"coachrush\"  width=\"60\" height=\"60\"\u003e","gig_link":"/umaisdesigns/design-killer-signature-logo"},{"id":15979324,"rater_id":4169625,"user_id":1938987,"is_seller":false,"value":10,"comment":"Outstanding Experience!","valuation":{"question_1_id":20,"question_1_value":10,"question_2_id":40,"question_2_value":10,"question_3_id":60,"question_3_value":10},"order_id":91993953,"created_at":"3 days","updated_at":"2015-01-19T22:16:55.000Z","rater_username":"kevinchernoff","rater_name":null,"photo_size":"user-pict-50","work_sample_type":"image","work_sample":"//cdnil1.fiverrcdn.com/deliveries/4229882/medium/creative-logo-design_ws_1421699517.jpg?1421699517","rater_link":"/kevinchernoff","rater_image":"\u003cspan class=\"missing-image-user\"\u003ek\u003c/span\u003e","gig_link":"/umaisdesigns/design-killer-signature-logo"}],"user_rating":97};
                    document.bundle_prefetched = {"id":2226306,"user_id":1938987,"category_id":3,"sub_category_id":49,"title":"design a KILLER logo with  unlimited repetitions","price":25,"gig_url":"/umaisdesigns/design-a-killer-logo-with-unlimited-repetitions?extras=2227876","extras":[{"id":2227876,"text":"Vector file format","price":"20.0","duration_for_extra_fast":false}],"image":"\u003cimg src=\"//cdnil1.fiverrcdn.com/photos/2226306/v2_680/optima_JME_FIVERR_3.jpg\"     \u003e"};
                </script>


                <header class="mp-box mp-hero-new hero-small mp-user-hero" itemscope="" itemtype="http://schema.org/Organization">

                    <div class="hero-slide sel" style="background-image: url('img/header_bg.jpg');">
                    </div>

	<div class="box-row hero-text">
		<h1>
			
			<span itemprop="name"><?php echo $username; ?></span>
				<small>
					<span class="js-user-one-liner"><?php echo $college_name; ?></span>
				</small>
		</h1>
		<div class="error-container js-user-one-liner-error"></div>
        <!--<div class="hero-rating js-hero-rating" data-user-rating="97" data-user-ratings-count="1175" itemprop="aggregateRating" itemscope="" itemtype="http://schema.org/AggregateRating">
		<meta itemprop="reviewCount" content="1175">
		<meta itemprop="ratingValue" content="4.9">    
        <i class="fa fa-star"></i>
		<i class="fa fa-star"></i>
		<i class="fa fa-star"></i>
		<i class="fa fa-star"></i>
		<i class="fa fa-star"></i>
		1175 Reviews</div>-->
	</div>

                    <div class="hero-profile-image">
                        <div class="box-row cf">
                            <span class="user-data rf">Member since <?php echo date('F, Y', strtotime($joinDate))?></span>
                            <span class='user-pict-130'><img src="img/users/<?php echo $profilePic; ?>" class='user-pict-img' alt='umaisdesigns' itemprop='logo' width='130' height='130' data-reload='inprogress'></span>
                        </div>
                    </div>

                    <div class="box-row mp-hero-connector-slim noborder">&nbsp;</div>

                    <img alt="Bg hero small spacer" class="trans-img" src="//cdnil21.fiverrcdn.com/assets/v2_backgrounds/bg-hero-small-spacer-7c831c845101e6082cb60043c5c3be49.png">

                </header>

	<article class="mp-box mp-box-grey mp-user-info p-b-40">
		<div class="box-row bordered p-b-30">

		<?php
        if(!empty($allKorks)){
            $kork_id = $allKorks[0]['id'];
            $kork_title = $allKorks[0]['title'];
            $kork_detail = $allKorks[0]['detail'];
            $kork_price = nice_number($allKorks[0]['price']);
            $kork_image = $allKorks[0]['image'];
            $kork_status = $allKorks[0]['status'];
            $kork_date = $allKorks[0]['expiryDate'];
            $kork_bids = $allKorks[0]['bids'];
            $kork_cat = $allKorks[0]['category'];
            echo "<aside class='user-bundle js-user-bundle'>
                <h4>$username's Best Seller</h4>
                <a href='cate_desc.php?korkID=$kork_id' class='bundle-item js-gtm-event-auto' data-gtm-category='new-user-page' data-gtm-action='click' data-gtm-label='top-package-with-extras'>
                <span class='bundle-badge'>$kork_cat</span>
                <span class='gig-pict-290'><img src='img/korkImages/$kork_image' data-reload='inprogress'></span>
                <h1 class='truncate'>$kork_title</h1>
                <h3 class='details-block-ellipsis'>$kork_detail</h3>
                <div class='bundle-sub cf'>
                    <span class='bundle-price'><small>Total</small>RS. $kork_price</span>
                </div></a>
            </aside>";
        }
        ?>

                        <header>
                            <h2>About <?php echo $fullname; ?>
                                <span class="user-is-online js-user-is-online" data-user-id="umaisdesigns"><em></em>online</span>
                            </h2>
                            <div class="desc">
                                <textarea class="user-edit-desc js-edit-desc" maxlength="300" name="user-edit-desc" tabindex="2" rows="1" data-org="Expert in Graphics Designing, Photography, Photoshopping, Logo Designing, Business cards, Advertisements, Flyer, Booklet, Book Covers, Illustrations and Company Branding. " readonly style="overflow: hidden; word-wrap: break-word; height: 72px;"><?php echo ($description == NULL) ? "$fullname has no description." : $description; ?></textarea>
                            </div>
                        </header>

                        <ul class="user-stats cf">
                                <li class="icn-country">From: <em><?php echo $city; ?></em></li>
                            <li class="icn-speaks">
                                Number of Gigs:
                                    <em><?php echo $prod_num; ?></em>
                            </li>
                            <li class="icn-response">Avg. Response Time: <em>1 Day</em></li>
                            <li class="icn-recent">Recent Delivery: <em>1 day ago</em></li>
                            <li class="<?php echo ($activeFlag == 0) ? "icn-cross" : "icn-verified" ?>">Email Verified</li>
                            
                            
                        </ul>

                        <footer class="cf">
                                <?php
                                if(!empty($_SESSION['username'])){
                                    if($username == $_username){
                                        echo '<a class="btn-standard btn-edit js-btn-edit-user" href="profile_edit.php" rel="nofollow"><i></i>Edit</a>';
                                    }else{
                                        echo "<a href='#' class='btn-standard btn-green-grad btn-contact js-btn-user-contact js-gtm-event-auto' data-toggle='modal' data-target='#message'><i></i>Contact</a>";
                                    }
                                }
								?>
                        </footer>

                    </div>
                </article>
		<?php
        if(!empty($allKorks)){
            echo "<div class='mp-box mp-box-grey'>
                    <div class='box-row p-b-20 featured_prod'>
					<header>
						<h2>$username's Gigs</h2>
					</header>		
					<article  class='prod_detail col-lg-12'>
      	            <ul class='row'>";
			foreach ($allKorks as $row){
			$kork_id = $row['id'];
			$kork_title = $row['title'];
			$kork_detail = $row['detail'];
			$kork_price = nice_number($row['price']);
			$kork_date = $row['expiryDate'];
			$kork_status = $row['status'];
			$kork_image = $row['image'];
			$kork_category = $row['category'];
			$kork_bids = $row['bids'];
			if($kork_status == 0 || $kork_status == 1){
				($kork_status == 0) ? $kork_status = "available" : $kork_status = "sold";
                echo "<li class='col-lg-3 col-md-6 col-sm-6'><a href='cate_desc.php?korkID=$kork_id'>
						<span class='$kork_status korkbadge'></span>
						<div class='col-lg-12 single_product'>
							<div class='img_wrap'>
								<img src='img/korkImages/$kork_image' alt='' class='img-responsive'>
							</div>
                            <h3 class='block-ellipsis'>$kork_title</h3>
							<p class='prod_cat_22'>$kork_category Category</p>
							<p class='attributes'>".date('m-d-Y | h:i A', strtotime($kork_date))."</p>
							<div class='price_tag_22'>
								<span class='price_main'>Rs. $kork_price</span>
								<span class='offer_dt'>$kork_bids BID",($kork_bids > 1) ? "S" : "","</span>
							</div>
					   </div>
					</a></li>";
			}
			}
            echo "</ul>
                <div class='clear'></div>
                </article>
                </div></div>";
        }else if(!empty($_SESSION['username']) && $_username == $username){
            echo "<div id='contentSub' class='clearfix'>
              <div class='contentBox'>
                  <p class='noKorks'> You have no gigs to sell.</p>
                  <p class='noKorksCreate'><a href='create_gig.php' class='entypo-pencil'> Do you want to start selling today?</a></p>
              </div>
            </div>";
        }
		?>
    <?php include 'headers/menu-bottom-navigation.php'; ?>
    </div>
    <div class="modal fade" id="message" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
            <h1 class="modal-title" id="myModalLabel">Contact Now</h1>
            <p>Please enter your message!</p>
          </div>
          <div class="modal-body">
            <form id="msg-form" method="post">
              <textarea id="msg" class="form-control txt_boxes" placeholder="Enter Your Message"></textarea>
              <div style="width: 0%;"><input type="button" id="msgsend" style="margin-right:10px" class="btn_signup" value="send" />
              </div>
            </form>
              <div id="shoading" style="margin: 40px 80px 10px;"></div>
            <div class="clearfix"></div>
          </div>
        </div>
      </div>
    </div>
<script src ="js/register.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    
$('.bxslider').bxSlider({
  video: true,
  useCSS: false
});
  });
</script> 
<script>
function getlist(x){
    $(".hidee").hide();
    $("#veiwlist"+x).show();
}
</script> 




<script src="js/nav-admin-dropdown.js"></script>
<script src="js/school-list.js"></script>
</body>
</html>
