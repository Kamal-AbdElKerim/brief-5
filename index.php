
<?php include 'layout/coon.php';
$isActive = 'index.php';

if (isset($_POST["sign_out"])) {
    // Perform logout actions here, then redirect to index.php
    session_destroy();
    header("Location: index.php");
    exit(); // Ensure script execution stops after the redirection header
}

?>

<!DOCTYPE html>
<html lang="en">

     <?php    include 'layout/head.php'; ?>
     
     <style>
     /* Optional: Custom styling for the carousel */
     .carousel-item {
      height: 450px; /* Set your desired height */
    }
    .carousel-item img {
      width: 100%;
      height: 100%;
      object-fit: cover; /* Image will cover the entire slide */
    }
      /* Custom styles for Next and Previous buttons */
      .carousel-control-prev,
    .carousel-control-next {
      color: #0b0b0b; /* Change the color of the text */
    }

    /* Change color on hover/focus for Next and Previous buttons */
    .carousel-control-prev:hover,
    .carousel-control-prev:focus,
    .carousel-control-next:hover,
    .carousel-control-next:focus {
      color: #0b0b0b; /* Change the color of the text on hover/focus */
      text-decoration: none; /* Remove underline */
      outline: 0; /* Remove outline */
    }
        /* Custom styles for carousel control icons */
        .carousel-control-prev-icon,
    .carousel-control-next-icon {
      fill: #0b0b0b; /* Change the color of the control icons */
    }
  </style>
    <body>
    

   <?php include 'layout/navbar.php' ;
   

   
   
   
   ?>


  
   <?php





        if (isset($_POST['submit'])) {
            $name = htmlspecialchars($_POST['name']);
            $password = htmlspecialchars($_POST['Password']); 
          
    
    
            $stmt = $conn->query("SELECT * FROM users WHERE username = '$name' AND Password = '$password'");
         
            $userData = $stmt->fetch();}
            
       
            
    
            if (!empty($userData) ) {
             
                $_SESSION['name']    = $userData['username'] ;
                
                 header("Location: products.php");
                exit();
            } else {
                $error_message = "Invalid username or password";
            }
        
    
        

   
   ?>


<div class="page-index" id="top">

<?php include 'layout/start.php' ?>
</div>

<div class="page-index" id="top">

<!-- ***** form  ***** -->
<div class="subscribe">
<div class="container">
         
            <div class="row">
        <?php 
       
        
        if (!isset($_SESSION['name'])) {
   

   ?>
                <div class="col-lg-6  align-items-center justify-content-center">
                    <form method="post"  >
                      <div class="form-group mb-4 ">
                        <label for="exampleInputEmail1" class="form-label">Name</label>
                        <input  type="text" name="name" value="<?php   echo $name ?? '';  ?>" class="form-control rounded-pill" id="exampleInputEmail1" aria-describedby="emailHelp">
                      </div>
                      <div class="form-group mb-5 ">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input type="password" name="Password" class="form-control rounded-pill" id="exampleInputPassword1">
                      </div>
                      <button name="submit" type="submit" class="btn btn-primary mb-5">Submit</button>
                     <!-- Error message -->
                     <?php if (isset($error_message , $_POST['submit']) && empty($userData) ) { ?>
                        <div class="alert alert-danger mt-4" role="alert">
                            <?php echo $error_message; ?>
                        </div>
                    <?php } ?>

                   
                    </form>
                  </div>

                  <?php }else {    ?>
                    
                

          <div class="col-lg-6  align-items-center justify-content-center mb-5">
          <h1 class="user-select-all text-center">welcome back <?php echo $_SESSION['name'] ?></h1>
 
          </div>
                  
                 <?php    } ?>


                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-12">
                        <video class="video" autoplay controls loop muted >
                                <source src="assets/video/Uncharted.mp4" type="video/mp4">
                               
                                Your browser does not support the video tag.
                            </video>
                        </div>
                      
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
 

    
   <?php include 'layout/footer.php' ; ?>

   <?php include 'layout/js.php' ; ?>

   <script>
    // Activate the carousel
    document.addEventListener("DOMContentLoaded", function () {
      var myCarousel = document.getElementById('myCarousel');
      var carousel = new bootstrap.Carousel(myCarousel, {
        interval: 2600 // Adjust the interval (in milliseconds) for auto sliding
      });
    });
  </script>

  </body>
</html>