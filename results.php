<!DOCTYPE html>
<html lang="en">
<head>

  <title>Mental Health Resources</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel = 'stylesheet' href = 'css/bootstrap.min.css' >
  <link rel="stylesheet" href="results.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

</head>
<body>

  <div class = "top">
    <h1 class="display-4 title">Mental Health Resources</h1>
  </div>

  <div id = 'container'>
    <form name = "form" action="results.php" method="POST" onsubmit="return validateForm()" >
      <div class = "field">
        <label for="location" class = "label">Location:</label>
        <select name="city" class = "form-control" id = "location">

          <option value="--">--</option>
          <option value="College Park">College Park</option>
          <option value="Berwyn Heights">Berwyn Heights</option>
          <option value="Greenbelt">Greenbelt</option>
          <option value="Hyattsville">Hyattsville</option>

        </select><br><br>
      </div>



      <div class = "field">
        <label for="cost" class = "label">Max cost per session:</label>
        <select name="cost" class = "form-control" id = "cost">

          <option value="none">--</option>
          <option value="100">$100</option>
          <option value="150">$150</option>
          <option value="200">$200</option>
          <option value="250">$250</option>
          <option value="300">$300</option>

        </select><br><br>

      </div>

      <div class = "field">
        <label for="specialty" class = "label">Specialty</label>
        <select name="specialty" class = "form-control" id = "cost">

          <option value="--">--</option>
          <option value="Trauma and PTSD">Trauma and PTSD</option>
          <option value="Anxiety">Anxiety</option>
          <option value="Depression">Depression</option>
          <option value="Family Conflict">Family Conflict</option>
          <option value="Grief">Grief</option>

        </select><br><br>

      </div>

      <div class = "field">
        <button type="submit" class="btn btn-default button-color">Submit</button>
      </div>

    </form>
  </div>







  <?php
  $mysqli = new mysqli("localhost", "root", "Sesame123!", "team23db", "3306");
  if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    exit(1);
  }

  $sql = "select * from therap";
  $city = $_POST["city"];
  $insurance = $_POST["insurance"];
  $cost = $_POST["cost"];
  $specialty = $_POST["specialty"];
  $first = True;

  if ($city !== "--") {
    if ($first) {
      $sql = $sql . " where city = '" . $city . "'";
      $first = False;
    }
  }

  if ($cost !== "--") {
    if ($first) {
      $sql = $sql . " where cost_session <= '" . $cost . "'";
      $first = False;
    } else {
      $sql = $sql . " and cost_session <= '" . $cost . "'";
    }
  }

  if ($specialty !== "--") {
    if ($first) {
      $sql = $sql . " where specialty LIKE \"%" . $specialty . "%\"";
    } else {
      $sql = $sql . " and specialty LIKE \"%" . $specialty . "%\"";
    }
  }

  $sql = $sql . ";";
  $result = $mysqli->query($sql);

  $rows = array();

  while($r = mysqli_fetch_assoc($result)) {
    $rows[] = $r;
  }
  $json_result = json_encode($rows);

  $result = $mysqli->query($sql);

  $mysqli->close();
  ?>

  <script type="text/javascript">

    var therapists = <?php echo $json_result ?>;

  </script>


  <br>
  <br>

  <?php
  echo "<p>number of results: " . $result->num_rows . "</p>"
  ?>

  <table class="table results">
    <thead>
      <tr>
        <th scope="col">Name</th>
        <th scope="col">City</th>
        <th scope="col">Cost per Session</th>
        <th scope="col"></th>
      </tr>
    </thead>
    <tbody>

      <?php

      $num_rows = $result->num_rows;

      for ($i = 0; $i < $num_rows; ++$i) {
        $row = $result->fetch_array(MYSQLI_ASSOC);
        echo "<tr>
        <td>" . $row["first_name"] . " " . $row["last_name"] . "</td>
        <td>" . $row["city"] ."</td>
        <td>" . "$" . $row["cost_session"] . "</td>
        <td><a href=\"#\" onClick=\"see_more(" . $i .")\" data-toggle=\"modal\" data-target=\"#myModal\">See more info</a></td>
        </tr>";
      }


      ?>

    </tbody>
  </table>

  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">More Information</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">


          <div id="accordion" class="data">


            <div id="headingOne" class = "info-label">


              <a href="#" data-toggle="collapse" data-target="#collapseOne">Qualifications</a>

            </div>

            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
              <div class="card-body" id="qualifications">

              </div>
            </div>

            <div id="headingTwo" class = "info-label">

              <a href="#" data-toggle="collapse" data-target="#collapseTwo">Specialty</a>

            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
              <div class="card-body" id="specialty">

              </div>
            </div>

            <div id="headingThree" class = "info-label">
              <a href="#" data-toggle="collapse" data-target="#collapseThree">Years of Practice</a>
            </div>
            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
              <div class="card-body" id="years">

              </div>
            </div>


            <div class="info-label" id="headingFour">
              <a href="#" data-toggle="collapse" data-target="#collapseFour">Insurance Accepted</a>
            </div>
            <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
              <div class="card-body" id="therapist_insurance">

              </div>
            </div>


            <div class="info-label" id="headingFive">
              <a href="#" data-toggle="collapse" data-target="#collapseFive">Faith</a>
            </div>
            <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordion">
              <div class="card-body" id ="faith">

              </div>
            </div>


            <div class="info-label" id="headingSix">
              <a href="#" data-toggle="collapse" data-target="#collapseSix">Alternative Languages</a>
            </div>
            <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordion">
              <div class="card-body" id = "language">

              </div>
            </div>

            <div class="info-label" id="headingSeven">
              <a href="#" data-toggle="collapse" data-target="#collapseSeven">Link to Profile</a>
            </div>
            <div id="collapseSeven" class="collapse" aria-labelledby="headingSeven" data-parent="#accordion">
              <div class="card-body" id="link">

              </div>
            </div>
          </div>

        </div>

      </div>
    </div>
  </div>
</div>


<script>

function see_more(index) {


  var qualifications_text = document.createElement('p');

  if (therapists[index]["qualifications"] == null) {
    qualifications_text.innerHTML = "N/A";
  } else {
    qualifications_text.innerHTML = therapists[index]["qualifications"]
  }
  var qualifications = document.getElementById("qualifications");
  while (qualifications.firstChild) {
    qualifications.removeChild(qualifications.firstChild);
  }
  qualifications.appendChild(qualifications_text);



  var specialty_text = document.createElement('p');
  if (therapists[index]["specialty"] == null) {
    specialty_text.innerHTML = "N/A";
  } else {
    specialty_text.innerHTML = therapists[index]["specialty"]
  }
  var specialty = document.getElementById("specialty");
  while (specialty.firstChild) {
    specialty.removeChild(specialty.firstChild);
  }
  specialty.appendChild(specialty_text);



  var years_text = document.createElement('p');
  if (therapists[index]["years"] == null) {
    years_text.innerHTML = "N/A";
  } else {
    years_text.innerHTML = therapists[index]["min_years"]
  }
  var years = document.getElementById("years");
  while (years.firstChild) {
    years.removeChild(years.firstChild);
  }
  years.appendChild(years_text);



  var insurance_text = document.createElement('p');
  if (therapists[index]["insurance"] == null) {
    insurance_text.innerHTML = "N/A";
  } else {
    insurance_text.innerHTML = therapists[index]["insurance"]
  }
  var insurance = document.getElementById("therapist_insurance");
  while (insurance.firstChild) {
    insurance.removeChild(insurance.firstChild);
  }
  insurance.appendChild(insurance_text);





  var faith_text = document.createElement('p');
  if (therapists[index]["faith"] == null) {
    faith_text.innerHTML = "N/A";
  } else {
    faith_text.innerHTML = therapists[index]["faith"]
  }
  var faith = document.getElementById("faith");
  while (faith.firstChild) {
    faith.removeChild(faith.firstChild);
  }
  faith.appendChild(faith_text);



  var language_text = document.createElement('p');
  if (therapists[index]["language"] == null) {
    language_text.innerHTML = "N/A";
  } else {
    language_text.innerHTML = therapists[index]["language"]
  }
  var language = document.getElementById("language");
  while (language.firstChild) {
    language.removeChild(language.firstChild);
  }
  language.appendChild(language_text);



  var link_text = document.createElement('p');
  if (therapists[index]["summary"] == null) {
    link_text.innerHTML = "N/A";
  } else {
    link_text.innerHTML = "<a href=\"" + therapists[index]["summary"] +"\">Psychology Today Profile</a>"
  }
  var link = document.getElementById("link");
  while (link.firstChild) {
    link.removeChild(link.firstChild);
  }
  link.appendChild(link_text);

}

</script>

</body>
</html>
