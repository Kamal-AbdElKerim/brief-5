<?php
include 'layout/coon.php';
$isActive = "products.php";
 // Start session if not started already

// Fetch all products initially

if ( isset($_POST['submit_checkbox'] )) {

    $query = "SELECT * FROM product  ";

  
    if (isset($_POST["quantite_min"]) ) {
        
        $query .= "WHERE quantite_min >= quantite_stock ";

    }

    if ($_POST["quantity"] === "1") {
        // Sort by quantity (assuming 'quantity' is the column name)
        $query .= "ORDER BY quantite_min DESC";
       

    }else if ($_POST["quantity"] === "2") {
        $query .= "ORDER BY quantite_min ASC";
    } else if ($_POST["quantity"] === "0") {
        $query ;
    } 
     else if ($_POST["quantity"] === "3") {
        $query .= "ORDER BY prix_unitaire ASC ";
    } 
    else if ($_POST["quantity"] === "4") {
        $query .= "ORDER BY prix_unitaire DESC ";
    } 

   
   
   
}else {
    $query = "SELECT * FROM product";
}


$stmt = $conn->prepare($query);
$stmt->execute();
$result_all = $stmt->fetchAll();




    if (!empty($_POST['categories'])&& isset($_POST['submit_checkbox'])) {
        $categories = $_POST['categories'];
        $clean_categories = array_map('intval', $categories);
        $category_condition = implode(', ', $clean_categories);

        $query_category = "SELECT * FROM product WHERE category_id IN ($category_condition)";

        if (isset($_POST["quantite_min"])) {
            $query_category .= " AND quantite_min >= quantite_stock";
        }

        if ($_POST["quantity"] === "1") {
            $query_category .= " ORDER BY quantite_min DESC";
        } else if ($_POST["quantity"] === "2") {
            $query_category .= " ORDER BY quantite_min ASC";
        }   else if ($_POST["quantity"] === "3") {
            $query_category .= " ORDER BY prix_unitaire ASC ";
        } 
        else if ($_POST["quantity"] === "4") {
            $query_category .= " ORDER BY prix_unitaire DESC";
        } 
        
      
     

        // Execute the query and fetch results
        $stmt = $conn->prepare($query_category);
        $stmt->execute();
        $result = $stmt->fetchAll();
    } else {
        // No checkboxes selected, display all products
        $result = $result_all;
    }


    

    
?>



<!DOCTYPE html>
<html lang="en">

     <?php    include 'layout/head.php'; ?>
    
     <style>
.item1 { grid-area: header; }
.item2 { grid-area: menu; }
.item3 { grid-area: main; }
.item5 { grid-area: footer; }

.grid-container {
  display: grid;
  grid-template-areas:
    'menu header header header header header'
    'menu main main main main main'
    
    'footer footer footer footer footer footer';
  gap: 47px;
  padding: 10px;
}

.grid-container > div {
 
  padding: 20px 0;

}
</style>
    <body>

  
    <!-- ***** Header Area Start ***** -->
    <?php include 'layout/navbar.php' ;
    
   

    if (isset($_POST["sign_out"])) {
        // Perform logout actions here, then redirect to index.php
        session_destroy();
        header("Location: index.php");
        exit(); // Ensure script execution stops after the redirection header
    }
    ?>
    <!-- ***** Header Area End ***** -->
   

    

    
  

  
    <?php   


if (isset($_SESSION['name'])) {
   

?>


      <!-- ***** Main Banner Area Start ***** -->
      <div class="page-heading" id="top">
     
    </div>
    <!-- ***** Main Banner Area End ***** -->

    <!-- ***** Products Area Starts ***** -->
    <section class="section " id="top">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="section-heading">
                        <h2>Our Latest Products</h2>
                    </div>
                </div>
            </div>
            <form method="post" action="#">
            <div class="grid-container">

            <div class="item1 d-flex justify-content-end align-items-center">
                <span> Trier par : <span class="invisible">l</span> </span>
                <select id="mySelect" name="quantity" class="form-select w-25 " aria-label="Default select example" style="width:17% !important;">
                       
                        <option <?php if (isset($_POST["quantity"]) && $_POST["quantity"] === "0"  ) {echo 'selected';}else {echo 'selected';}  ?>   value="0">All</option>
                        <option <?php if (isset($_POST["quantity"]) && $_POST["quantity"] === "2"  ) echo 'selected'; ?>    value="2">Quantité, croissant </option>
                        <option <?php if (isset($_POST["quantity"]) && $_POST["quantity"] === "1"  ) echo 'selected'; ?>    value="1">Quantité, décroissant </option>
                        <option <?php if (isset($_POST["quantity"]) && $_POST["quantity"] === "3"  ) echo 'selected'; ?>    value="3">Prix, croissant </option>
                        <option <?php if (isset($_POST["quantity"]) && $_POST["quantity"] === "4"  ) echo 'selected'; ?>    value="4">Prix, décroissant </option>

                        </select>
    
  

    
</div>
  <div class="item2 ">
    
  <div class="col-lg-12">
              
     <h5>Composants</h5>
    <!-- Checkbox inputs -->
    <ul class="list-group">
    <li class="list-group-item">
    <input id="firstCheckboxStretched" class="form-check-input me-1 min" type="checkbox" value="2" name="categories[]" <?php if (isset($categories) && in_array('2', $categories)) echo 'checked'; ?>>
    <label class="form-check-label stretched-link o1 small-text" for="firstCheckboxStretched">Processeurs</label>
    </li> 
    <li class="list-group-item">
    <input id="secondCheckboxStretched" class="form-check-input me-1 min"  type="checkbox" value="3" name="categories[]" <?php if (isset($categories) && in_array('3', $categories)) echo 'checked'; ?>>
    <label class="form-check-label stretched-link o2 small-text" for="secondCheckboxStretched">Cartes graphiques</label>
    </li>
    
    
    <li class="list-group-item">
    <input  id="thirdCheckboxStretched" class="form-check-input me-1 min"  type="checkbox" value="1" name="categories[]" <?php if (isset($categories) && in_array('1', $categories)) echo 'checked'; ?>>
    <label class="form-check-label stretched-link small-text" for="thirdCheckboxStretched">Boitiers PC</label>
    </li>
   <br>
    <h5>Quantité min</h5>
    <ul  class="list-group">
    <li class="list-group-item">
    <input  id="thirdCheckboxStretched2" class="form-check-input me-1 min"  type="checkbox" value="4" name="quantite_min" <?php if (isset($_POST["quantite_min"]) && $_POST["quantite_min"] === "4" ) echo 'checked'; ?> >
    <label class="form-check-label stretched-link small-text" for="thirdCheckboxStretched2">Quantite min</label>
    </li>
    </ul>
    </ul>
    <br>
     <!-- <h5>Quantité</h5> -->
    <!-- Checkbox inputs -->
    <!-- <ul class="list-group">
    <li class="list-group-item">
    <input id="firstquantity0"  class="form-check-input me-1 " type="radio" value="0" name="quantity" <?php if (isset($_POST["quantity"]) && $_POST["quantity"] === "0" || !isset($_POST["quantity"]) ) echo 'checked'; ?> >
    <label class="form-check-label stretched-link" for="firstquantity0">All</label>

    </li> 
    <li class="list-group-item">
    <input id="firstquantity" class="form-check-input me-1" type="radio" value="1" name="quantity" <?php if (isset($_POST["quantity"]) && $_POST["quantity"] === "1" ) echo 'checked'; ?> >
    <label class="form-check-label stretched-link" for="firstquantity">Quantité, décroissant</label>

    </li> 
    <li class="list-group-item">
    <input id="firstquantity2" class="form-check-input me-1 " type="radio" value="2" name="quantity" <?php if (isset($_POST["quantity"]) && $_POST["quantity"] === "2" ) echo 'checked'; ?> >
    <label class="form-check-label stretched-link" for="firstquantity2">Quantité, croissant </label>

    </li> 
    </ul> -->
    
  
    <br>
    <button id="bu" type="submit" name="submit_checkbox" class="btn btn-info btn-lg invisible">
          <span class="glyphicon glyphicon-filter"><i class="fas fa-filter"></i></span> Filter </button>

</form>
                </div>
                </div>
                <div class="item3 row " >
                <?php 
                 if (isset($result) && !empty($result) ) {
                    foreach ($result as $row) { ?>
            
                    <div class="col-lg-6">
                    <div class="item">
                    <div class="row g-0  mb-4 position-relative" style="    border-bottom: 2px #857979 solid;border-top: 2px #857979 solid;border-radius: 20%;">
                        <div class="col-md-6 mb-md-0 p-md-4">
                            <img src="<?php echo $row['image_url']  ?>" class="w-100" alt="...">
                        </div>
                        <div class="col-md-6 p-4 ps-md-0">
                            <h5 class="mb-4"><?php echo $row['libelle']  ?></h5>
                            <h6 class="text-primary"><?php echo $row['prix_unitaire']  ?> MAD</h6>
                            <h6 class="text-success">Produit en stock (<?php echo $row['quantite_stock']  ?>) </h6>
                            <?php if ($row['quantite_min'] > $row['quantite_stock'] ) {  ?>
                               
                           
                            <h6 class="text-danger">Quantite min : <?php echo $row['quantite_min']  ?> </h6>

                            <?php }else {   ?>
                                <h6 class="text-subtle">Quantite min : <?php echo $row['quantite_min']  ?> </h6>

                                <?php  } ?>

                        </div>
                        </div>
                    </div>
                </div>

                <?php }}  ?>
                    
               
            

       


                   
                  
             
            </div>  

                </div>
                        
                        </div>
    </section>

    <?php }else {  ?>

              <!-- ***** Main Banner Area Start ***** -->
      <div class="page-heading" id="top">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="inner-content">
                        <h2 >Check Our Products</h2>
                        <h3 class="text-light"> &amp; You must Log in first</h3>
                        <a class="btn btn-primary ms-4 p-2" href="index.php">Log in</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ***** Main Banner Area End ***** -->

    
        <?php }   ?>
 
    
   
    <!-- ***** Products Area Ends ***** -->
    
    <!-- ***** Footer Start ***** -->
    <?php include 'layout/footer.php' ; ?>
   



<?php include 'layout/js.php' ; ?>


<script>
    // start Quantity

// const radioButtons = document.getElementsByName("quantity");

// radioButtons.forEach((radio) => {
//   radio.addEventListener("change", () => {
//     let selectedValue = "";

//     radioButtons.forEach((rb) => {
//       if (rb.checked) {

//         selectedValue = rb.value;
//       }
//     });


//      if (selectedValue !== null ) {
//         document.getElementById("bu").click();
//      }

//   });
// });
    // end Quantity


// Get the select element by its ID
const selectElement = document.getElementById("mySelect");

// Add change event listener to the select element
selectElement.addEventListener("change", function() {
  // Get the selected value
  const selectedValue = this.value;
 console.log(selectedValue)
  // Display the selected value
  if (selectedValue !== null ) {
        document.getElementById("bu").click();
     }
    });



// Get all checkbox elements with the class 'option'
const checkboxes = document.querySelectorAll('.min');

// Add change event listeners to all checkboxes
checkboxes.forEach(checkbox => {
  checkbox.addEventListener('change', function() {
    let selectedValues = [];
    
    checkboxes.forEach(cb => {
      if (cb.checked) {
        selectedValues.push(cb.value);
      }
    });

    if (selectedValues.length > 0) {
        document.getElementById("bu").click();     } else {
            document.getElementById("bu").click();     }
  });
});



    
</script>




  </body>

</html>
