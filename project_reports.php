<!DOCTYPE HTML>

<html>

<head>
  <title>Project Reports</title>

  <style>

     table td, th {
         border: 1px solid black;
         padding: 5px;
     }

     .container {

     display: flex;
     justify-content: center;
     align-items: center;
     flex-direction: column;
     margin-top: 2%
     }

     a:visited {
        color: blue;
     }

     </style>
</head>

<body>




    <form action="showProjectInterests.php" method="post" id="submitForm">

    <?php

      require("db_connect.php");

      $txt = '';
      $txt .= '<div class="container">';
      $txt .= '<h2>Project Reports</h2>';

      $sql = 'select projectName, id from project order by projectName';
      $query = $dbh->prepare($sql);
      $query->execute();
      $projects = $query->fetchAll(PDO::FETCH_ASSOC);

      $txt .= '<p style="width:30%;text-align:center;">Select a project from the drop down list below to see people interested in the project.</p>';
      $txt .= '<select name="projectId" id="projectList" style="height:5%;">' . "\n";
      $txt .= '<option value="0">  -- Select a Project --  </option>' . "\n";
      foreach($projects as $project) {
          $txt .= sprintf('<option value="%s">%s</option>', $project['id'], $project['projectName']) . "\n";
      }

      $txt .= '</select>';
      echo $txt;
    ?>
    <br/>
  <!--  <button type="submit">Submit</button> -->
</form>
    <br/>
    <div id="projectDiv"></div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    //   document.getElementById('submitForm').addEventListener('submit', function (e) {
    document.getElementById('projectList').addEventListener('change', function () {
        //  e.preventDefault();
        const value = this.value; //document.getElementById('projectList').value;

        if (value === '0') {
            //  e.preventDefault(); // stop the submit
            //alert('Please select a project before submitting.');
            document.getElementById('projectDiv').innerHTML = 'Please select a project';
        } else {
            const projectName = this.options[this.selectedIndex].text;
            getTable(value, projectName);
        }
    });
});

async function getTable(projectId, projectName) {
    const response = await fetch('showProjectInterests.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'projectId=' + encodeURIComponent(projectId),
    });

    const result = await response.text();

    if (result == 'false') {
        document.getElementById('projectDiv').innerHTML =
            'No one has shown interest in ' + projectName;
    } else {
        document.getElementById('projectDiv').innerHTML = result;
    }
}
</script>

</body>

</html>