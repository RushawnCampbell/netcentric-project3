<?php

require_once 'dbconfig.php';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    echo "Connected to $dbname at $host successfully.";

    if(isset($_POST['submit'])){
        $clrk_ID =filter_var($_POST['clerkID'], FILTER_SANITIZE_NUMBER_INT);
        $con_ID =filter_var($_POST['constID'], FILTER_SANITIZE_NUMBER_INT);
        $poll_div_ID = filter_var($_POST['pdID'], FILTER_SANITIZE_NUMBER_INT);
        $poll_station = filter_var($_POST['pollStation'], FILTER_SANITIZE_STRING);
        $Votes_1 = filter_var($_POST['c1votes'], FILTER_SANITIZE_NUMBER_INT);
        $Votes_2 = filter_var($_POST['c2votes'], FILTER_SANITIZE_NUMBER_INT);
        $rejected = filter_var($_POST['rejected'], FILTER_SANITIZE_NUMBER_INT);
        $total = filter_var($_POST['total'], FILTER_SANITIZE_NUMBER_INT);


        if(isset($clrk_ID) && isset($con_ID) && isset($poll_div_ID) && isset($poll_station)
         && isset($Votes_1) && isset($Votes_2) && isset($rejected) && isset($total)){
            
            $q = "INSERT INTO StationVotes(clerk_id,constituency_id,poll_division_id,polling_station_code,candidate1Votes,candidate2Votes,rejectedVotes,totalVotes)
             VALUES($clrk_ID,$con_ID,$poll_div_ID,'$poll_station',$Votes_1,$Votes_2,$rejected,$total);";

            if($conn->query($q) == TRUE){
                 echo "Record sucessfully submitted!";
             }
            else{
                echo "Eror uploading your data";
             }

            $data = "SELECT * FROM StationVotes";
            $Qry = $conn->query($data);
            $data_list = $Qry->fetchALL(PDO ::FETCH_ASSOC);
            var_dump($data_list[0]);
         }
    }


} catch (PDOException $pe) {
    die("Could not connect to the database $dbname :" . $pe->getMessage());
}


$candid1_tot = 0;
$candid2_tot = 0;
$reject_total = 0;
$total_total = 0;


?>

<table>
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
            <td><?=$row['constituency_id'];?></td>
            <td><?=$row['poll_division_id'];?></td>
            <td><?=$row['polling_station_code'];?></td>
            <td><?=$row['candidate1Votes'];?></td>
            <td><?=$row['candidate2Votes'];?></td>
            <td><?=$row['rejectedVotes'];?></td>
            <td><?=$row['totalVotes'];?></td>
        </tr>

        <?php
        $candid1_tot += $row['candidate1Votes'];
        $candid2_tot += $row['candidate2Votes'];
        $reject_total += $row['rejectedVotes'];
        $total_total += $row['totalVotes'];
        ?>


    <?php endforeach;?>
    <hr>
    <tfoot>
        <td> <strong>Total</strong></td>
        <td></td>
        <td></td>
        <td><strong><?=$candid1_tot;?></strong></td>
        <td><strong><?=$candid2_tot;?></strong></td>
        <td><strong><?=$reject_total;?></strong></td>
        <td><strong><?=$total_total;?></strong></td>
    </tfoot>


</table>