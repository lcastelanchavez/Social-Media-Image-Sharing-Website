#!/usr/local/bin/php

<?php 
    if(isset($_POST['submit_button'])) { //if user clicked submit button 
        if(isset($_POST['color']) && isset($_POST['person_to_view'])) { //if fields are set
            
            $username = $_POST['person_to_view'];  //create varible to store user
            $color_set = $_POST['color'];  //create variable to store desired color 


        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <?php echo '<title>', $username ,' photos</title>' ?>
        <style> 
            <?php echo "body, head { background-color:",$color_set, ";}" 
            ?> 
        </style> 
    </head>
    <body>
        <?php 
        if(isset($_POST['submit_button'])) { //if user clicked submit button 
            if(isset($_POST['color']) && isset($_POST['person_to_view'])) {//if fields are set


                try {
                   $mydb = new SQLite3('users.db'); //opens or creates database
                }
                catch(Exception $ex) { //if fail to establish connection
                  echo $ex->getMessage(); 
                }

                $folderName = str_replace(' ','_',$username); //replace spaces in name with '_' to find folder of same name
        
                $search = "SELECT picName, ogPicName, views FROM users WHERE Username='{$username}';";  
                $run = $mydb->query($search); //run command to get table 


                if($run) { //if search command runs 
                    while($row = $run->fetchArray()) { //go through each row of table until end 
                        //create the image src/link based upon current row. Original image name retrieved 
                        $img_src = 'https://www.pic.ucla.edu/~lesliecastelan/HW7/photos/' . $folderName .'/'. $row['ogPicName']; 

                        echo "<img src= '{$img_src}' width='200px'>", '<br/>'; //displaying picture 
                        echo "<strong>'{$row['picName']}' has '{$row['views']}' view(s). </strong>", '<br/>'; //displaying name of picture and image 

                        $views = $row['views'];
                        $updated_views = $views + 1; //adding one to the picture's views 
                        //echo $updated_views, '<br/>'; 

                        //updating the views of each image 
                        $update_views = "UPDATE users SET views='{$updated_views}' WHERE Username='{$username}' and picName ='{$row['picName']}';";
                        $update_cmmd = $mydb->query($update_views); 
                    }
                    
                    $mydb->close(); //close connection

                }

            }
    }

     ?>  

    </body>

</html> 