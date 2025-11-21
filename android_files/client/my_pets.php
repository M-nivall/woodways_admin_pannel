  <?php


  include '../../include/connections.php';

   $userID = $_POST['userID'];

  $select="SELECT * FROM pets WHERE client_id = '$userID' ";
  $query=mysqli_query($con,$select);


    if(mysqli_num_rows($query)>0){
        $response['status']=1;
        $response['message']="Stock";
        $response['details']=array();

        while ($row=mysqli_fetch_array($query)){
              $index['pet_id']=$row['pet_id'];
              $index['pet_name']=$row['pet_name'];
              $index['species']=$row['species'];
              $index['breed']=$row['breed'];
              $index['gender']=$row['gender'];
              $index['date_of_birth']=$row['date_of_birth'];
              $index['weight']=$row['weight'];


            array_push($response['details'],$index);
        }
        echo json_encode($response);
    }
    ?>