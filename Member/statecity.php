<!-- Fill Dropdown Using Ajax -->

<?php
require '../include/connect.php';
if(isset($_POST['state_id'])){
    $state_id=$_POST['state_id'];
    $fetch_city="SELECT * FROM city WHERE state_id='$state_id' ORDER BY city_name";
    $fetch_city_run=mysqli_query($connection,$fetch_city);
}
?>
  <select name="city" id="">
    <option value="" selected disabled>Select City</option> 
    <?php
    while($city=mysqli_fetch_array($fetch_city_run)){
        echo"<option value='$city[0]'>$city[2]</option>";
    }
    ?>
</select>  
