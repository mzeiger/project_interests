<!DOCTYPE HTML>

<html>

<head>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>Project Reports</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            background-color: #f8f9fa;
        }

        .mhk-brand-logo {
            max-height: 88px;
            width: auto;
            height: auto;
        }
    </style>
</head>

<body>
    <?php
    require_once __DIR__ . '/brand_header.php';
    mhk_brand_logo();
    ?>

    <form action="showProjectInterests.php" method="post" id="submitForm">

        <?php

        require("db_connect.php");

        $txt = '';
        $txt .= '<div class="container mt-5">';
        $txt .= '<h2 class="text-center mb-4">Project Reports</h2>';

        $sql = 'select projectName, id from project where divider = 0 order by projectName ';
        $query = $dbh->prepare($sql);
        $query->execute();
        $projects = $query->fetchAll(PDO::FETCH_ASSOC);

        $txt .= '<p class="text-center mb-3" style="max-width: 600px; margin: 0 auto;">Select a project from the drop down list below to see people interested in the project.</p>';
        $txt .= '<div class="row justify-content-center mb-4">';
        $txt .= '<div class="col-md-4">';
        $txt .= '<select name="projectId" id="projectList" class="form-select">' . "\n";
        $txt .= '<option value="0">  -- Select a Project --  </option>' . "\n";
        foreach ($projects as $project) {
            $txt .= sprintf('<option value="%s">%s</option>', $project['id'], $project['projectName']) . "\n";
        }
        $txt .= '</select>';
        $txt .= '</div>';
        $txt .= '</div>';
        echo $txt;
        ?>
    </form>
    <div id="projectDiv" class="container"></div>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            //   document.getElementById('submitForm').addEventListener('submit', function (e) {
            document.getElementById('projectList').addEventListener('change', function () {
                //  e.preventDefault();
                const value = this.value; //document.getElementById('projectList').value;

                if (value === '0') {
                    //  e.preventDefault(); // stop the submit
                    //alert('Please select a project before submitting.');
                    document.getElementById('projectDiv').innerHTML = '<div class="text-center fw-bold fs-5">Please select a project</div>';
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
                    '<div class="text-center fw-bold fs-5">No one has shown interest in ' + projectName + '</div>';
            } else {
                document.getElementById('projectDiv').innerHTML = result;
            }
        }
    </script>

</body>

</html>