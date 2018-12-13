<?php
$mysqli = new mysqli("localhost", "root", "Sesame123!", "team23db", "3306");
if ($mysqli->connect_errno) {
    echo "Failllled to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
$sql = "SELECT * FROM therap;";
$result = $mysqli->query($sql);

$num_rows = $result->num_rows;

for ($i = 0; $i < $num_rows; ++$i) {
    $row = $result->fetch_array(MYSQLI_ASSOC);    
    echo $row["person_id"] . " | " . $row["first_name"] . " | " . $row["last_name"] . " | " . $row["gender"] . " | " . $row["address"] . " | " . $row["city"] . " | " . $row["zipcode"] . " | " . $row["qualifications"] . " | " . $row["specialty"] . " | " . $row["cost_session"] . " | " . $row["insurance_id"] . " | " . $row["faith_id"] . " | " . $row["Alt_Languages"] . " | " . " | " . $row["summary_id"] . " | " . "<br>";
}"<br>";

$mysqli->close();
?>