<!-- DEBUGGING MODE -->
<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
?>
<!-- END OF DEBUGGING MODE -->
<?php

require_once 'dbconfig.php';


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])){

    $clrk_ID =filter_var($_POST['clerkID'], FILTER_SANITIZE_NUMBER_INT);
    $con_ID =filter_var($_POST['constID'], FILTER_SANITIZE_NUMBER_INT);
    $poll_div_ID = filter_var($_POST['pdID'], FILTER_SANITIZE_NUMBER_INT);
    $poll_station = filter_var($_POST['pollstat'], FILTER_SANITIZE_STRING);
    $Votes_1 = filter_var($_POST['c1votes'], FILTER_SANITIZE_NUMBER_INT);
    $Votes_2 = filter_var($_POST['c2votes'], FILTER_SANITIZE_NUMBER_INT);
    $rejected = filter_var($_POST['reject'], FILTER_SANITIZE_NUMBER_INT);
    $total = filter_var($_POST['totalv'], FILTER_SANITIZE_NUMBER_INT);


    if(isset($clrk_ID) && isset($con_ID) && isset($poll_div_ID) && isset($poll_station)
     && isset($Votes_1) && isset($Votes_2) && isset($rejected) && isset($total)){
        
        $q = "INSERT INTO StationVotes(clerk_id,constituency_id,poll_division_id,polling_station_code,candidate1Votes,candidate2Votes,rejectedVotes,totalVotes)
         VALUES($clrk_ID,$con_ID,$poll_div_ID,'$poll_station',$Votes_1,$Votes_2,$rejected,$total);";

        if($conn->query($q) == TRUE){
            $result= "Record sucessfully submitted!";
        }
        else{
            echo "Eror uploading your data";
         }

        $data = "SELECT * FROM StationVotes";
        $Qry = $conn->query($data);
        $data_list = $Qry->fetchALL(PDO ::FETCH_ASSOC);
     }

}
$candid1_tot = 0;
$candid2_tot = 0;
$reject_total = 0;
$total_total = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../styles/p1b.css"/>
    <title>Document</title>
</head>
<body>
    <div class="flex-containerp2">
    <section id="status"> <?= $result ?></section>
        <table class = "part-B">
            <tr>
                <th>Constituency</th>
                <th>Polling Div.</th>
                <th>Polling Stn</th>
                <th>Candidate1</th>
                <th>Candidate2</th>
                <th>Rejected</th>
                <th>Total</th>
            </tr>    
        
            <?php foreach($data_list as $row):?>
                <tr>
                   <th><?=$row['constituency_id'];?></th>
                   <th><?=$row['poll_division_id'];?></th>
                   <th><?=$row['polling_station_code'];?></th>
                   <th><?=$row['candidate1Votes'];?></th>
                   <th><?=$row['candidate2Votes'];?></th>
                   <th><?=$row['rejectedVotes'];?></th>
                   <th><?=$row['totalVotes'];?></th>
                </tr>
        
                <?php
                $candid1_tot += $row['candidate1Votes'];
                $candid2_tot += $row['candidate2Votes'];
                $reject_total += $row['rejectedVotes'];
                $total_total += $row['totalVotes'];
                ?>
        <?php endforeach;?>

        <th colspan="8"><hr/></th> 
        <tr id="lastrow">     
            <th>Total</th>                
            <th></th>
            <th></th>
            <th><?=$candid1_tot;?></th>
            <th><?=$candid2_tot;?></th>
            <th><?=$reject_total;?></th>
            <th><?=$total_total;?></th>
        </tr>
        </table>
    </div>
</body>
</html>
