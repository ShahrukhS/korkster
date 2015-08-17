<?php
include "headers/connect_database.php";

if(isset($_GET['search_text'])){
	$search_text = $_GET['search_text'];
	$search_mode=$_GET['mode'];

if(!empty($search_text)){
	
	
		 
		  if($search_mode=='register'){
              $search_text = $search_text."%";
              $stmt = $dbh->prepare("SELECT name,city FROM colleges WHERE name LIKE :name LIMIT 5");
              $stmt->bindParam(':name', $search_text);
              $stmt->execute();
              $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
              if(!empty($result)){
                  foreach($result as $query_row){
                    $name = $query_row['name'];
                    $city = $query_row['city'];

                    $name_hypens = str_replace(' ', '-', $name);

                    echo "<a href='#'><li id='list'> {$name} - {$city} </li></a>";
                  }
              }else{
                echo "No results found!";
              }
		  }else{
			   $query = "SELECT ID,name,city FROM colleges WHERE name LIKE '$search_text%' || city LIKE '$search_text%' LIMIT 5 ";
		  
		  $query_run = mysqli_query($con,$query);
			  while($query_row = mysqli_fetch_assoc($query_run)){
			$name = $query_row['name'];
			$city = $query_row['city'];
			$id = $query_row['ID'];
			$name_hypens = str_replace(' ', '-', $name);
			
			//echo "<a href='/WalknSell/school/$name_hypens'><li id='list'> {$name} - {$city} </li></a>";
			//echo "<li id='unilist'> <a href='#'>$name</a></li>";
			echo "<a href='school-category.php?schoolID={$id}&schoolName={$name_hypens}'><li id='list'> {$name} - {$city} </li></a>";
			
		  }  
			  
			  }


}

}

?>