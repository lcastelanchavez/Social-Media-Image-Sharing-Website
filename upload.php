#!/usr/local/bin/php
<?php 
    if(isset($_POST['submit_button_upload'])) { //if the submit button is clicked
        if(isset($_POST['user_name']) && isset($_POST['user_img_title'])) { //if fields are filled set the username to set the title
            
            $oldFolderName = $_POST['user_name'];
            
        }
    }

?>  
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <?php echo '<title>Thank you, ',$oldFolderName,'!</title>' ?>
    </head>

    <body>
    <?php

    if(isset($_POST['submit_button_upload'])) { //if the submit button is clicked

        if(isset($_POST['user_name']) && isset($_POST['user_img_title'])) { //ensure fields are filled out otherwise don't do anything
            
    
            #echo $_POST['user_img_title'], ' ', $_POST['user_name'], '<br/>'; 
            
    
            
            $newfileName = $_POST['user_img_title']; 
            
            $folderName = str_replace(' ','_',$oldFolderName); 
            #echo $folderName, '<br/>'; 

           
            
            #exec("mv $fileName $newfileName"); 
    
            # $_POST['upload_pic']['name']; 
        
        
            try {
                $mydb = new SQLite3('users.db'); //opens or creates database
            }
            catch(Exception $ex) { //if fail to establish connection
                echo $ex->getMessage(); 
            }

            //create the table if not existing already 
            $statement = 'CREATE TABLE IF NOT EXISTS users(picName TEXT NOT NULL, ogPicName TEXT NOT NULL, Username TEXT NOT NULL, views INTEGER NOT NULL);';
            $createtable = $mydb->query($statement); 
            
            $search = "SELECT picName, Username FROM users;"; //select only the picture's desired name and username from the table 
            $run = $mydb->query($search); 

            if($run) { //if statment to select works successfully 
                while($row = $run->fetchArray()) { //go through each row and look for pic name and username
                    #var_dump($row); 
                    #echo '<br/>'; 
                    if($row['picName'] === $newfileName && $row['Username'] === $oldFolderName) { //make sure pic name under username does not already exist 
                        //if it exists, print message and exit 
                        echo "A photo named ", $newfileName, ' by ',$_POST['user_name']. ' already exists.', '<br/>'; 
                        exit(''); 

                    }
                }
                 //if photo doesn't already exist in database 
                $views= 0; 
                $image_original_name = $_FILES['upload_pic']['name']; //getting the actual name of the file
                //inserting the uploaded picture name, desired picture name, username and views into table 
                $insert_statement = "INSERT INTO users(picName, ogPicName, Username, views) VALUES ('$newfileName','$image_original_name','$oldFolderName', $views);";
                $insert_run = $mydb->query($insert_statement); //insert new record into table


                $user_folder_path = 'photos'. '/'. $folderName; 

                if(!is_dir($user_folder_path)) { //if not already a directory that exists with the desired name, create it 
                    mkdir($user_folder_path, 0755); //set permissions to public 
                    #exec("chmod 755 $folderName");
                }

                $temp_name = $_FILES['upload_pic']['tmp_name']; //retrieve temporary storage place of file 
    
                //creating directory of where want to move image to 
                $uploads_dir = "/net/laguna/h1/l/lesliecastelan/public_html/HW7/" .$user_folder_path .'/'. $_FILES['upload_pic']['name']; 

                move_uploaded_file($temp_name, $uploads_dir); //move the uploaded file into user's folder to store 
                echo 'Your image has been uploaded.', '<br/>'; 

                //display image and store it 
                //creating image src/path 
                $img_src = 'https://www.pic.ucla.edu/~lesliecastelan/HW7/photos/' . $folderName .'/'. $_FILES['upload_pic']['name']; 

                echo "<img src= '{$img_src}' width='30%' height='30%' > "; 


                
                $mydb->close(); 
            }
            
        
        }
    }



    ?>
        
       
    </body>
</html>