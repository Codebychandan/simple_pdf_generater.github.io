<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "submission";

$conn = mysqli_connect($server, $username, $password, $database);
if(!$conn){
//     echo "Successfully connected";
//  }
//  else{
    die("Error". mysqli_connect_error());
}

?>

<?php 
$insert = false;
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $uuid = $_POST['UUID'];
    $name = $_POST['name'];
    $number = $_POST['number'];
    $city = $_POST['city'];
    
    // check for empty fields
    if(empty($name) || empty($number) || empty($city)){
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <strong>Error!</strong> Please fill in all the required fields.
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>';
    }
    else{
        // Check whether this name exists
        $existSql = "SELECT * FROM `submit_data` WHERE Name = '$name'"; 
        $result = mysqli_query($conn, $existSql);
        $numexistrows = mysqli_num_rows($result);

        if ($numexistrows > 0) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                      <strong>Error!</strong> Entry already exists.
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>';
        }
        else{
            $sql = "INSERT INTO `submit_data` (`Name`,`Phone_number`, `City`) VALUES ('$name', '$number', '$city')";
            $result = mysqli_query($conn, $sql);
            
            if($result){
                $insert = true;
            }
            else{
                $insert = false;
            }
        }
    } 
}
?>

<?php 
    if (isset($_GET['download'])) {
        require('fpdf.php');
        // Get the data to display on the PDF from the database
        $query = "SELECT * FROM submit_data ORDER BY UUID DESC LIMIT 1";
        $result = mysqli_query($conn, $query);
        
        // Create the table header
        $header = array('UUID', 'Name', 'Phone Number', 'City');
        
        class PDF extends FPDF
        {
            // Page header
            function Header()
            {
                // Set font
                $this->SetFont('Arial', 'B', 18);
                
                // Header text
                $header_text = "Cliant Data";
                
                // Output header text
                $this->Cell(2, 12, $header_text, 0, 1, 'L');
            }
        }

        // Initialize the PDF object
        $pdf = new PDF();
        $pdf->SetTitle('data');
        $pdf->AddPage();
        
        // Set the font and color for the table header
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(0);
        
        // Create the table header cells
        foreach ($header as $col) {
            $pdf->Cell(40, 10, $col, 1, 0, 'C', 1);
        }
        $pdf->Ln();
        
        // Set the font and color for the table data
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetFillColor(224, 235, 255);
        $pdf->SetTextColor(0);
        
        // Create the table data cells
        while ($data = mysqli_fetch_assoc($result)) {
            $pdf->Cell(40, 10, $data['UUID'], 1, 0, 'C', 1);
            $pdf->Cell(40, 10, $data['Name'], 1, 0, 'L', 1);
            $pdf->Cell(40, 10, $data['Phone_number'], 1, 0, 'L', 1);
            $pdf->Cell(40, 10, $data['City'], 1, 0, 'L', 1);
            $pdf->Ln();
        }
        
        // Output the PDF
        $pdf->Output();

        
    }
?>


<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <style>
            body{
                background-image: url('img/bg.jpg');
                
                background-repeat: no-repeat;
              background-size: 100rem;
                background-color: #f5f5f5;
            }
        </style>

    <title>PDF Generator</title>
</head>

<body>
    <?php 
        if ($insert == true) {
           echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
           <strong>Congrets!</strong> Your Data Submitted successfully! <button type="button" name="download" class="btn btn-link">Generate PDF</button>
        
           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </button>
         </div>';
        }
        
        
    ?>
    
    <h1 class="text-center pt-5">Welcome to Our PDF Generater</h1>
    <p class="text-center"><small>This is a Simple pdf generator. After submit your details, click to <u>Generate pdf</u></small></p>
    <div class="container w-50 p-2">
        <form method="post">
            <div class="form-group">
                <input type="hidden" class="form-control" name="UUID" id="UUID" aria-describedby="name">
            </div>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="name" id="name" aria-describedby="name"
                    placeholder="Enter name">
            </div>
            <div class="form-group">
                <label>Phone No.</label>
                <input type="number" class="form-control" name="number" id="number" placeholder="Enter Mobile Number">
            </div>
            <div class="form-group">
                <label for="city">City.</label>
                <input type="text" class="form-control" name="city" id="city" aria-describedby="city"
                    placeholder="Enter City">
            </div>
            <div class="form-group text-center">

            <button type="submit" class="btn btn-primary btn-lg btn-block">Submit</button>
            </div>
        </form>
    </div>
    <!-- Optional JavaScript -->
    <script>
    document.querySelector('button[name="download"]').addEventListener('click', function() {
        window.location.href = '?download';
    });
    </script>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
</body>

</html>