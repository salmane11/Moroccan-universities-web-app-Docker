<!DOCTYPE html>
<html>
    <header>
        <title>Moroccan universities</title>
        <link rel="stylesheet" type="text/css" href="universities.css" />
    </header>
    <body>
        <div class="header">
            <h1>UNIVERSITIES</h1>
            <img src="flag.png" alt="Morocco"/>
        </div><br><br><br><br><br>
        <h1>A list of moroccan universities</h1>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
            image:<input type="file" name="image"/>
            name:<input type="text" name="name"/>
            speciality:<input type="text" name="speciality"/><br><br>
            <button type="submit" value="Add new university">Add new university</button>
            <button type ="reset" value="cancel">cancel</button>
        </form>
        <div class="card">
        <!-- <?php
            $jsonUniversities = file_get_contents("universities.json");
            $myUniversities=json_decode($jsonUniversities,true);
            foreach($myUniversities as $key1=> $university){
                echo"<div class='university'>
                    <img src='".$university["image"]."'/>
                    <p>".$university["name"]."</p>
                    <h3>".$university["speciality"]."</h3>
                </div>";
            }


            $image=$name=$speciality="";
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $target_dir = "images/";
                $fileName=$_FILES["image"]["name"];
                $target_file = $target_dir . basename($fileName);
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    echo "The file ". htmlspecialchars( basename( $_FILES["image"]["name"])). " has been uploaded.";
                }else {
                    echo "Sorry, there was an error uploading your file.";
                }
                $name=$_POST["name"];
                $speciality=$_POST["speciality"];

                $data=array("image"=>$target_file,"name"=>$name,"speciality"=>$speciality);
                array_push($myUniversities,$data);
                $jsonData = json_encode($myUniversities);
                $myJsonFile=fopen("universities.json","w");
                fwrite($myJsonFile,$jsonData);
                echo $target_file,$imageFileType,$name,$speciality;
            }
        ?> -->


        <?php
        $servername = "universitiesdb";
        $username = "root";
        $password = "root";
        $dbname="universities";

        // Create connection
        $conn = new mysqli($servername, $username, $password,$dbname);
        // Check connection
        if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        }
        else {
            echo "connexion bien etablie";
        }
        $sql = "CREATE TABLE universities (
            image VARCHAR(30) ,
            name VARCHAR(30),
            speciality VARCHAR(50)
            )";
            
            if ($conn->query($sql) === TRUE) {
              echo "Table created successfully";
            }

        $image=$name=$speciality="";
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $target_dir = "images/";
            $fileName=$_FILES["image"]["name"];
            $target_file = $target_dir . basename($fileName);
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            echo "The file ". htmlspecialchars( basename( $_FILES["image"]["name"])). " has been uploaded.";
            }else {
                echo "Sorry, there was an error uploading your file.";
            }
            $name=$_POST["name"];
            $speciality=$_POST["speciality"];

            $sqlPost="INSERT INTO universities values ('$target_file','$name','$speciality')";
            echo $target_file,$imageFileType,$name,$speciality;
            if ($conn->query($sqlPost) === TRUE) {
                echo "values inserted successfully";
            } else {
                echo "Error inserting values : " . $conn->error;
            }
        }
        
        $sql = "SELECT * from universities";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo"<div class='university'>
                    <img src='".$row["image"]."'/>
                    <p>".$row["name"]."</p>
                    <h3>".$row["speciality"]."</h3>
                </div>";
            }
        } else {
            echo "0 results";
        }

        $conn->close();
        ?>
        

        </div>
    </body>
</html>