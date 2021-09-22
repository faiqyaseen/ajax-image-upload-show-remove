<?php

if(isset($_FILES['file'])){
    if($_FILES['file']['name'] != ""){
        $filename = $_FILES['file']['name'];
        $extension = pathinfo($filename,PATHINFO_EXTENSION);
        $valid_extension = array("jpg","jpeg","png","gif");

        if(in_array($extension,$valid_extension)){
            $new_name = rand() . time() . $filename;
            $path = "img/" . $new_name;

            if(move_uploaded_file($_FILES['file']['tmp_name'],$path)){
                echo '<img src="'.$path.'" /> <hr> <button class="btn btn-danger" data-path="'.$path.'" id="delete-btn">Delete</button>';
            }
        }else{
            echo 1;
        }

    }else{
        echo 0;
    }
}

if(isset($_POST['path'])){
    if(!empty($_POST['path'])){
        unlink($_POST['path']);
        echo 1;
    }
    else{
        echo 0;
    }
}
    
    
?>