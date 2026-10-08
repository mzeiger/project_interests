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

        .main-container {
            display: flex;
            flex-direction: row;
            align-items: flex-start;
            justify-content: center;
            gap: 1%;
        }

        .left_div {
            /* height: 30%;
            width: 20%; */
            background-color: lightblue;
            padding: 5px;
            ;
        }

        .right_div {
            /* height: 30%;
            width: 20%; */
            background-color: lightblue;
            padding: 5px;
        }

        .drop_down {
            background-color: lightgray;
        }

        table {
            border-collapse: collapse;
        }

        tr td {
            border: 1px solid black;
            padding-left: 2px;
            padding-right: 2px;
        }
    </style>
</head>

<body>
    <?php
    require_once __DIR__ . '/brand_header.php';
    require_once __DIR__ . '/db_connect.php';
    mhk_brand_logo();
    ?>

    <div class="main-container">


        <div class="left_div">
            <h2 class="text-center mb-4">Listing by Members</h2>
            <?php
            $sql = "select fname, lname, projectName from v_project_person order by lname, fname";
            $query = $dbh->prepare($sql);
            $query->execute();
            $entries = $query->fetchAll(PDO::FETCH_ASSOC);
            $txt = "<table>";
            foreach ($entries as $entry) {
                $txt .= sprintf("<tr><td>%s&nbsp;%s</td><td>%s</td></tr>", $entry['fname'], $entry['lname'], $entry['projectName']);
            }
            $txt .= "</table>";
            echo $txt;
            $txt = "";
            $query = null;
            ?>
        </div> <!-- Left div -->


        <div class="drop_down">
            <form action=" showProjectInterests.php" method="post" id="submitForm">
                <div class="container mt-5">
                    <h2 class="text-center mb-4">Project Reports</h2>
                    <p class="text-center mb-3" style="max-width: 600px; margin: 0 auto;">Select a project from the drop down list below to see people interested in the project.</p>
                    <div class="row justify-content-center mb-4">
                        <div class="col-md-10">
                            <select name="projectId" id="projectList" class="form-select">
                                <option value="0"> -- Select a Project -- </option>
                                <?php
                                $sql = 'select projectName, id from project where divider = 0 order by projectName ';
                                $query = $dbh->prepare($sql);
                                $query->execute();
                                $projects = $query->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($projects as $project) {
                                    printf(
                                        '<option value="%s">%s</option>' . "\n",
                                        htmlspecialchars($project['id'], ENT_QUOTES, 'UTF-8'),
                                        htmlspecialchars($project['projectName'], ENT_QUOTES, 'UTF-8')
                                    );
                                }
                                $query = null;
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
            <div id="projectDiv" class="container">
                <!-- reults of clicking on the <select>  -->
            </div>
        </div> <!-- drop_down -->


        <div class="right_div">
            <h2 class="text-center mb-4">Listing by Project</h2>
            <?php
            $sql = "select fname, lname, projectName from v_project_person order by projectName, lname, fname";
            $query = $dbh->prepare($sql);
            $query->execute();
            $entries = $query->fetchAll(PDO::FETCH_ASSOC);
            $txt = "<table>";
            foreach ($entries as $entry) {
                $txt .= sprintf("<tr><td>%s</td><td>%s&nbsp;%s</td></tr>", $entry['projectName'], $entry['fname'], $entry['lname']);
            }
            $txt .= "</table>";
            echo $txt;
            $txt = "";
            $query = null;
            ?>
        </div> <!-- right_div -->

    </div> <!-- main-container -->


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            //   document.getElementById('submitForm').addEventListener('submit', function (e) {
            document.getElementById('projectList').addEventListener('change', function() {
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