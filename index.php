
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Number validate</title>
    <style>  
    .error {color: #FF0001;}  
    </style>
</head>
<body class="bg-light">
<?php
    $nameErr = $emailErr = $mobilenoErr = $genderErr = $websiteErr = $agreeErr = "";  
    $name = $email = $mobileno = $gender = $website = $agree = "";  
    if ($_SERVER["REQUEST_METHOD"] == "POST") {  
        if ( empty($_POST["name"])) {  
                $nameErr = "Name is required";  
        } else {  
            $name = input_data($_POST["name"]);  
                // check if name only contains letters and whitespace  
                if (!preg_match("/^[a-zA-Z ]*$/",$name)) {  
                    $nameErr = "Only alphabets and white space are allowed";  
                }  
        }  
        if ( empty($_POST["email"])) {  
                $emailErr = "Email is required";  
        } else {  
                $email = input_data($_POST["email"]);  
                // check that the e-mail address is well-formed  
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {  
                    $emailErr = "Invalid email format";  
                }  
            }   
   if ( empty($_POST["mobileno"])) {  
           $mobilenoErr = "Mobile no is required";  
   } else {  
            $mobileno = $_POST["countryCode"].$_POST["mobileno"]; 
            $access_key = "05a00f644a06e062b56ee2cb1c625a13";
            $url = "http://apilayer.net/api/validate?access_key=$access_key&number=$mobileno";
            $get_request = file_get_contents($url);
            $json = json_decode($get_request, true);
            if ($json["valid"] == 0) {
                $mobilenoErr = "Phone number is not real."; ;
            }
            else{
                $status["success"] = "Phone Number is valid.";
            }
   }
   if ( empty($_POST["address"])) {  
        $addressErr = "address is required";  
    } else {  
    $address = input_data($_POST["address"]);  
        
    } 
    
    
}
function input_data($data) {  
    $data = trim($data);  
    $data = stripslashes($data);  
    $data = htmlspecialchars($data);  
    return $data;  
  }  
?>
    <div class="container py-5">
        <div class="row">
            <div class="col-md-5 shadow rounded bg-white mx-auto p-4">
                <h3 class="text-center fw-bold mb-3">Sign Up</h3>
                
                <form action="" method="post">
                    <label for="number">Name</label>
                    <div class="mb-3 input-group">
                        <input type="text" class="form-control w-50" name="name" id="name" placeholder="abcde" >
                    </div> 
                    <label class="error"><?php echo $nameErr; ?> </label>  
                    <br>
                    <label for="number">E-Mail</label>
                    <div class="mb-3 input-group">
                        <input type="text" class="form-control w-50" name="email" id="email" placeholder="abcde@g.com " >
                    </div>
                    <label class="error"><?php echo $emailErr; ?> </label>  
                    <br>
                    <label for="number">Phone Number</label>
                    <div class="mb-3 input-group">
                        <select name="countryCode" class="form-control" required>
                            <option value="+91">+91</option>
                        </select>
                        <input type="number" class="form-control w-50" name="mobileno" id="mobileno" placeholder="14158586273" >
                      
                    </div>
                    <label class="error"><?php echo $mobilenoErr; ?> </label>  
                    <br>
                    <label for="number">addresss</label>
                    <div class="mb-3 input-group">
                        
                        <textarea type="text" class="form-control w-50" name="address" id="address" placeholder="At/post Pune " ></textarea>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
        <div class="container py-5">
            <div class="row">
                <div class="col-md-5 shadow rounded bg-white mx-auto p-4">
                    <h3 class="text-center fw-bold mb-3">Result</h3>
                    <?php
                        if(isset($_POST['submit'])) {  
                            if($nameErr == "" && $emailErr == "" && $mobilenoErr == "") { 
                                echo "<div class='alert alert-success'>{$status["success"]}</div>";
                                echo "<p><strong>Number: </strong> {$json["number"]}</p>";
                                echo "<p><strong>Local Format: </strong> {$json["local_format"]}</p>";
                                echo "<p><strong>International Format: </strong> {$json["international_format"]}</p>";
                                echo "<p><strong>Country Prefix: </strong> {$json["country_prefix"]}</p>";
                                echo "<p><strong>Country Code: </strong> {$json["country_code"]}</p>";
                                echo "<p><strong>Country Name: </strong> {$json["country_name"]}</p>";
                                echo "<p><strong>Location: </strong> {$json["location"]}</p>";
                                echo "<p><strong>Carrier: </strong> {$json["carrier"]}</p>";
                                echo "<p><strong>Line Type: </strong> {$json["line_type"]}</p>";
                            }
                        }   
            
                    if (isset($status["error"])) {
                        echo "<div class='alert alert-danger'>{$status["error"]}</div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>