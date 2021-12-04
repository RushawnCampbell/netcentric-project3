<!-- DEBUGGING MODE -->
<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
?>
<!-- END OF DEBUGGING MODE -->





<?php

require_once 'dbconfig.php';
function notEmpty($x){ //negates the built-in function...better for this program
    return !empty($x);
}
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    echo "Connected to $dbname at $host successfully.";
    if($_SERVER['REQUEST_METHOD'] == 'POST'){ //makes sure HTML uses POST
    if (isset( $_POST['submit'])) //makes sure form is filled out
{
    $a = false; //these will become true if the relevant validation is successful
    $b = false;
    $c = false;
    $d = false;
    $e = false;
    $f = false;
    $g = false;
    $h = false;
    
    $clerkID = (int)$_POST['clerkID']; //assigns values from form to variables
    $constID = (int)$_POST['constID'];
    $pdID = (int)$_POST['pdID'];
    $pollStation = $_POST['pollStation'];
    $c1votes = (int)$_POST['c1votes'];
    $c2votes = (int)$_POST['c2votes'];
    $rejected = (int)$_POST['rejected'];
    $total = (int)$_POST['total'];

    if (notEmpty($clerkID)){//beginning of validation before storing to database
    if (is_int($clerkID)){
        $a = true;
       
    }}
    if (notEmpty($constID)){
        if (is_int($constID)){
        $b = true;
        
    }}
    if (notEmpty($pdID)){
        if(is_int($pdID)){
        $c = true;
        
    }}
    if (notEmpty($pollStation)){
    if (ctype_alnum($pollStation)){
        $d = true;
        
    }}
    if($total === ($rejected + $c2votes + $c1votes)){
        $e = $f = $g = $h = true;
        
    }   
    

    $hiddenField = $_POST['hiddenField']; 
    
    if($a&&$b&&$c&&$d&&$e&&$f&&$g&&$h){ //ensuring that all validation was successful
        //add to database
        $insert = "INSERT INTO StationVotes
        (clerk_id,constituency_id,poll_division_id,polling_station_code,candidate1Votes,candidate2Votes,rejectedVotes,totalVotes,record_digest)
        VALUES('$clerkID','$constID','$pdID','$pollStation','$c1votes','$c2votes','$rejected','$total', NULL)";
        
        $sub = $conn->query($insert);

        //reading from database
        $sub = $conn->query("SELECT * FROM StationVotes");
        $records = $sub->fetchALL(PDO ::FETCH_ASSOC);

        //concatenating and printing database data as specified
        $table = '<div>
                    <table>
            <thead>
                <tr>
                <th>Constituency</th><th>Polling Div.</th><th>Polling Stn</th>
                <th>Candidate1</th><th>Candidate2</th>
                <th>Rejected</th><th>Total</th>
                </tr>
            </thead>
            <tbody>';
            foreach($records as $record){
                
                $table .= '<tr><td>' . $record['constituency_id'] . '</td><td>' . 
                $record['poll_division_id'] . '</td><td>' . 
                $record['polling_station_code'] . '</td><td>' . 
                $record['candidate1Votes'] . '</td><td>' . 
                $record['candidate2Votes'] . '</td><td>' . 
                $record['rejectedVotes'] . '</td><td>' . 
                $record['totalVotes'] . '</td></tr>';
            }//end foreach

        $table .= '</tbody></table></div>';
        echo $table;
        //}//end valid data if


    }//end received if

}
}//end server request method if

    $conn = null;
} catch (PDOException $pe) {
    die("Could not connect to the database $dbname :" . $pe->getMessage());
}



?>


