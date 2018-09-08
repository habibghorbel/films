<?php

session_start() ;


	include 'init.php';
     
     $do = isset($_GET['do']) ?  $_GET['do'] : 'manage';

     if ($do =='manage')
     { 
        $stmt = $con->prepare("SELECT * FROM users WHERE GroupID !=1");
        $stmt->execute();
        $rows = $stmt->fetchall();



     	?>
     <h1 class="text-center">Manage Member</h1>
        <div class="container">
        	<div class= "table-responsive">
        		<table class= "main-table text-center table table-bordered">
        			<tr>
                      <td>#ID</td>
                      <td>#username</td>
                      <td>#email</td>
                      <td>#Full name</td>
                      <td>#registerd date</td>
                      <td>#control</td>
        			</tr>
        			
        			<?php
        			    foreach ($rows as $row ) {
        			    	
        			    	echo "<tr>";
        			    	   echo "<td>" . $row["userID"] . "</td>";
        			    	   echo "<td>" . $row["username"] . "</td>";
        			    	   echo "<td>" . $row["email"] . "</td>";
        			    	   echo "<td>" . $row["fullname"] . "</td>";
        			    	   echo "<td>" . $row["Date"] . "</td>";
	        			    	   echo "<td>
	        			    	            <a href='members.php?do=Edit&userID=" . $row['userID'] . "' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
	                      	                <a href='members.php?do=Delete&userID=" . $row['userID'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a>
	        			    	   </td>" ;
        			    	echo "</tr>";
        			    }
        			?>
        			
        			
        		</table>
        		
        	</div>
           <a href="members.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> Add New Member</a>;
        </div>
     <?php } 
     elseif ($do == 'Add') 
     {  ?>
     
     	echo 'welcom to add page';
     	<h1 class="text-center">Add New Member</h1>
        <div class="container">
        	<form class="form-horizontal" action="?do=Insert" method="post">
        		<div class="form-group form-group-lg">
        			<label class="col-sm-2 control-label">usernames</label>
        			<div class="col-sm-10 col-md-7">
        				<input type="text" name="username" class="form-control"  autocomplete="off">	
        			</div>	
        		</div>
        		

        		<div class="form-group form-group-lg">
        			<label class="col-sm-2 control-label">password</label>
        			<div class="col-sm-10 col-md-7">
        				<input type="Password" name="Password" class="form-control" autocomplete="new-password">	
        			</div>	
        		</div>


        		<div class="form-group form-group-lg">
        			<label class="col-sm-2 control-label">Email</label>
        			<div class="col-sm-10 col-md-7">
        				<input type="Email" name="Email" class="form-control">	
        			</div>	
        		</div>


        		<div class="form-group form-group-lg">
        			<label class="col-sm-2 control-label">name</label>
        			<div class="col-sm-10 col-md-7">
        				<input type="text" name="name" class="form-control">	
        			</div>	
        		</div>


        		<div class="form-group form-group-lg">
        			
        			<div class="col-sm-offset-2 col-sm-10">
        				<input type="submit" value="Add Member" class="btn btn-primary btn-lg ">	
        			</div>	
        		</div>
        	</form>
        	
        </div>

    <?php 
}
     elseif ($do == 'Insert') {

 	echo "<h1 class='text-center'>Insert Member</h1>";

 	if ($_SERVER['REQUEST_METHOD'] == 'POST' ) {

 		$user = $_POST['username'];
 		$pass = $_POST['Password'];
 		$Email = $_POST['Email'];
 		$name = $_POST['name'];

        $stmt = $con->prepare("INSERT INTO 
        	                    users ( username ,password , email  , fullname, Date)
        	                    VALUES (:zuser, :zpass, :zmail, :zname , now())" );

        $stmt->execute(array(

               'zuser' => $user,
               'zpass' => $pass ,
               'zmail' => $Email,
               'zname' => $name
               ));            
             echo $stmt->rowcount() . 'record Inserted';

 	}


 
     }
     elseif ($do == 'Edit')
     { 
     $userID = isset($_GET['userID']) && is_numeric($_GET['userID']) ? intval($_GET['userID']): 0 ;
     echo  $userID;
	     $stmt = $con ->prepare("SELECT * FROM users where userID = ? limit 1 ");
	    	                          
	    	                        
	        $stmt->execute(array($userID));
	        $row = $stmt ->fetch();
	        $count = $stmt-> rowcount();

	        if ($stmt->rowcount() > 0) { ?>
       

     	<h1 class="text-center">Edit Member</h1>
        <div class="container">
        	<form class="form-horizontal" action="?do=update" method="post">
        	   <input type="hidden" name="userID" value="<?php echo $userID ?>"/>
        		<div class="form-group form-group-lg">
        			<label class="col-sm-2 control-label">usernames</label>
        			<div class="col-sm-10 col-md-7">
        				<input type="text" name="username" class="form-control"  autocomplete="off">	
        			</div>	
        		</div>
        		

        		<div class="form-group form-group-lg">
        			<label class="col-sm-2 control-label">password</label>
        			<div class="col-sm-10 col-md-7">
        				<input type="Password" name="Password" class="form-control" autocomplete="new-password">	
        			</div>	
        		</div>


        		<div class="form-group form-group-lg">
        			<label class="col-sm-2 control-label">Email</label>
        			<div class="col-sm-10 col-md-7">
        				<input type="Email" name="Email" class="form-control">	
        			</div>	
        		</div>


        		<div class="form-group form-group-lg">
        			<label class="col-sm-2 control-label">name</label>
        			<div class="col-sm-10 col-md-7">
        				<input type="text" name="name" class="form-control">	
        			</div>	
        		</div>


        		<div class="form-group form-group-lg">
        			
        			<div class="col-sm-offset-2 col-sm-10">
        				<input type="submit" value="save" class="btn btn-primary btn-lg ">	
        			</div>	
        		</div>
        	</form>
        	
        </div>

        


     <?php  
      }  else {
	        	echo 'theres no such id';
	        }
 }  elseif ($do == 'update') {

 	echo "<h1 class='text-center'>update Member</h1>";

 	if ($_SERVER['REQUEST_METHOD'] == 'POST' ) {

 		$ID = $_POST['userID'];
 		$user = $_POST['username'];
 		$Email = $_POST['Email'];
 		$name = $_POST['name'];

        $stmt = $con->prepare("UPDATE users SET username =? , email =? , fullname = ? WHERE userID =? ");
        $stmt->execute(array($user, $Email, $name, $ID) );
             
             echo $stmt->rowcount() . 'record updated';

 	}
 	


 } elseif ($do == 'Delete') {


 	 $userID = isset($_GET['userID']) && is_numeric($_GET['userID']) ? intval($_GET['userID']): 0 ;
     echo  $userID;
	     $stmt = $con ->prepare("SELECT * FROM users where userID = ? limit 1 ");
	    	                          
	    	                        
	        $stmt->execute(array($userID));
	        $count = $stmt-> rowcount();

	        if ($stmt->rowcount() > 0) {

	        	$stmt = $con->prepare("DELETE FROM users WHERE userID = :zuser");
	        	$stmt->bindParam(":zuser", $userID);
	        	$stmt->execute();
	        	echo "<div class='alert alert-success'>" . $stmt->rowcount() . ' record Deleteed</div>';

	        }

 }


	include $tpl .'footer.php';



	
  



