<!DOCTYPE HTML>
<!-- index.php is the main call for the interests page for project interests -->

<html>

<head>

    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    <title>Kiwanis Projects</title>

    <style>
        table td,
        th {
            border: 1px solid black;
            padding: 5px;
        }

        /* table th {
            border: 1px solid black;
            padding: 5px;
        } */

        td.divider {
            background-color: lightgray;
            text-align: center;
            font-size: large;
            font-weight: bold;
        }

        p {
            text-align: center;
        }

        .limit_width60 {
            width: 40%;
        }

        .limit_width10 {
            width: 10%;
        }

        .limit_width5 {
            width: 2%;
        }

        .limit_width2 {
            width: 4%;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            align-content: center;
            flex-direction: column;
            width: 85%;
            margin-left: 5%;
            margin-right: 5%;

        }
    </style>

</head>

<body>

    <?php

    require("db_connect.php");

    $sql = 'select * from project order by position';
    $query = $dbh->prepare($sql);
    $query->execute();
    $projects = $query->fetchAll(PDO::FETCH_ASSOC);

    $sql = 'select * from person order by email';
    $query = $dbh->prepare($sql);
    $query->execute();
    $emails = $query->fetchAll(PDO::FETCH_ASSOC);

    ?>

    <br />
    <div class="container">
        <h2 style="margin-top:2px;margin-bottom:2px;">Select Projects</h2>
        <h3 style="margin-top:2px;margin-bottom:2px;">Choose the projects that interest you.</h3>


        <?php
        $txt = '<form action="updateProjects.php" method="post" id="submitForm">' . "\n";
        $txt .= '<br/>';

        $txt .= '<h4 style="width:40%;text-aligh:left;margin-botton:10px;">If you can\'t find your email in the ';
        $txt .= '<span style="color:green;">Select Box</span> below then ';

        $txt .= 'click<br/>this button <button id="sweetAlerts">Register</button> to register.';
        $txt .= ' Otherwise select your email, select your projects, and click on the ';
        $txt .= '<span style="color:green;">Submit</span> button</h4>';
        $txt .= selectBox($emails) . "\n";
        $txt .= '<button type="submit" style="margin-left:5%;">Submit</button>' . "\n";
        $txt .= '<button type="button" style="margin-left:10%;" onclick="projectReports()">' . "\n";
        $txt .= 'Go to Report\'s Screen' . "\n";
        $txt .= '</button>';

        $txt .= '<a href="projectinterestinstructions.html" style="margin-left:15%;" ';
        $txt .= 'onclick="openInstructions(event)">View Instructions</a>';


        $txt .= "<br/><br/>" . "\n";
        $txt .= "<div>\n";
        $txt .= "<table>\n";
        $txt .= "<tr><th></th><th>Project</th><th>Project Manager</th><th>Estimated Time</th><th>Description</th><th>Full<br/>Description</th></tr>\n";

        foreach ($projects as $project) {

            if ($project['divider'] == 1) {
                $txt .= sprintf('<tr><td colspan="6" class="divider">%s</td></tr>', $project['projectName']);
            } else {
                $txt .= '<tr>';
                $txt .= '<td class="limit_width5">';
                $txt .=  checkbox($project);
                $txt .= '</td>';
                $txt .= sprintf('<td class="limit_width10">%s</td>', $project['projectName']);
                $txt .= sprintf('<td class="limit_width10">%s</td>', $project['projectHead']);
                $txt .= sprintf('<td class="limit_width10">%s</td>', $project['estimatedTime']);
                $txt .= sprintf('<td class="limit_width60">%s</td>', $project['projectDescription']);
                if (trim($project['fullDescription']) == "") {
                    $txt .= '<td></td>';
                } else {
                    $txt .= sprintf('<td class="limit_width2"><button type="button" class="openPopup" data-id="%s">Full Description</button></td>', $project['id']);
                }
                $txt .= "</tr>\n";
            }
        }

        $txt .= "</table>\n";

        $txt .= "</form>\n";
        $txt .= "</div>\n";
        echo $txt;


        function checkbox($proj): string
        {
            $rv = "";
            $rv .= '<input type="checkbox" class="projectCheckbox"';
            $rv .= ' name="items[]"';
            $rv .= ' value=' . '"' .  $proj['projectName'] . ':' . $proj['id'] . '"';
            $rv .= ' id=' . '"' . 'cb-' . $proj['id'] . '"';
            $rv .= '>';
            return $rv;
        }

        function selectBox($emails): string
        {
            $rv = "";
            $rv .= '<select id="email_list" name="email_list" onchange="handleEmailSelection(this.value)"   style="width:20%;">';
            $rv .= '<option value=""> -- Select your email -- </option>';
            foreach ($emails as $email) {
                $rv .= '<option value="' . $email['id'] . ":" . $email['email'] .  '">' . $email['email']  . '</option>' . "\n";
            }
            $rv .= '</select>';
            return $rv;
        }

        ?>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11">
        </script>

        <script>
            function projectReports() {
                window.open('project_reports.php');
            }
        </script>

        <script>
            function openInstructions(e) {
                e.preventDefault();

                const w = Math.floor(screen.width * 0.6);
                const h = Math.floor(screen.height * 0.6);
                const left = Math.floor((screen.width - w) / 2);
                const top = Math.floor((screen.height - h) / 2);

                window.open(
                    e.currentTarget.href,
                    'popup',
                    `width=${w},height=${h},left=${left},top=${top}`
                );
            }
        </script>


        <script>
            function sweetAlerts(title, message, icon) {
                swal.fire({
                    title: title,
                    text: message,
                    icon: icon,
                    confirmButtonText: 'Close',
                    width: '30%',
                });
            }
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document
                    .getElementById('submitForm')
                    .addEventListener('submit', async function(event) {
                        event.preventDefault(); // stop the submit
                        const email = document.getElementById('email_list').value;
                        if (email === '') {
                            sweetAlerts('', 'Please select an email before submitting.', 'warning');
                        } else {
                            const formData = new FormData();

                            // Add all checked checkboxes
                            document
                                .querySelectorAll('.projectCheckbox:checked')
                                .forEach((cb) => formData.append('items[]', cb.value));

                            formData.append('email_list', email);

                            console.log(formData);

                            const response = await fetch('updateProjects.php', {
                                method: 'POST',
                                body: formData,
                            });

                            const message = await response.text();
                            sweetAlerts('Results', message, 'info');
                        }
                    });
            });

            function handleEmailSelection(theValue) {
                // Uncheck all checkboxes
                document.querySelectorAll('input[type="checkbox"]').forEach((cb) => {
                    cb.checked = false;
                });

                fetch('populateCheckBoxes.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: 'cb=' + encodeURIComponent(theValue),
                    })
                    .then((r) => r.json())
                    .then((ids) => {
                        ids.forEach((id) => {
                            document.getElementById(id).checked = true;
                        });
                    });
            }
        </script>

        <script>
            document.getElementById('sweetAlerts').addEventListener('click', (event) => {
                event.preventDefault();
                Swal.fire({
                    title: 'Register',
                    html: `
            <input type="email" id="email" class="swal2-input" placeholder="Email">
            <input type="text" id="fname" class="swal2-input" placeholder="First Name">
            <input type="text" id="lname" class="swal2-input" placeholder="Last Name">
            <br/><br/><br/>
            <div id="outputTrue" style="color:green;"></div>
            <div id="outputFalse" style="color:red;"></div>
        `,
                    showCancelButton: true,
                    confirmButtonText: 'Submit',
                    cancelButtonText: 'Cancel',

                    // ? THIS is the key: run fetch here and return false to keep dialog open
                    preConfirm: () => {
                        const email = document.getElementById('email').value.trim();
                        const fname = document.getElementById('fname').value.trim();
                        const lname = document.getElementById('lname').value.trim();

                        if (!email || !fname || !lname) {
                            Swal.showValidationMessage('All fields are required');
                            return false; // keeps the modal open
                        }

                        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                            Swal.showValidationMessage('Enter a valid email');
                            return false; // keeps the modal open
                        }

                        Swal.showLoading();

                        return fetch('register.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded'
                                },
                                body: new URLSearchParams({
                                    email,
                                    fname,
                                    lname,
                                }),
                            })
                            .then((r) => r.text())
                            .then((text) => {
                                arr = [];
                                // ? Update the divs INSIDE the SweetAlert2 dialog
                                if (text.startsWith('t')) {
                                    arr = text.split(':');

                                    Swal.update({
                                        showConfirmButton: false,
                                        showCancelButton: false,
                                    });

                                    Swal.fire({
                                        icon: 'success',
                                        title: '',
                                        cancelButtonText: 'Close',
                                    });

                                    updateEmailList(arr[1], email);
                                    document.getElementById('outputTrue').innerHTML =
                                        'Registration succeeded';
                                    document.getElementById('outputFalse').innerHTML = '';
                                } else if (text === 'false') {
                                    document.getElementById('outputFalse').innerHTML =
                                        'Email already exists';
                                    document.getElementById('outputTrue').innerHTML = '';
                                } else {
                                    document.getElementById('outputFalse').innerHTML = text;
                                    document.getElementById('outputTrue').innerHTML = '';
                                }

                                // ? IMPORTANT: return false so SweetAlert2 does NOT close
                                return false;
                            });
                    },
                });

                function updateEmailList(id, email) {
                    const select = document.getElementById('email_list');
                    const newOption = new Option(email, id);
                    select.add(newOption);
                    // Convert options to array
                    const opts = Array.from(select.options);

                    // Sort alphabetically by text
                    opts.sort((a, b) => a.text.localeCompare(b.text));

                    // Remove all and re-add in sorted order
                    select.innerHTML = '';
                    opts.forEach((opt) => select.add(opt));
                }
            });
        </script>

        <script>
            // This opens the full description when the button is clicked
            document.addEventListener("click", async function(e) {
                if (e.target.classList.contains("openPopup")) {
                    const id = e.target.dataset.id;

                    const desc = await fetch("getFullDescription.php?id=" + id)
                        .then(r => r.text());

                    Swal.fire({
                        title: "Full Description",
                        html: `
                <div style="text-align:left;  overflow-y:auto;">
                    ${desc}
                </div>
            `,
                        width: 600,

                        // Modal behavior
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: true, // optional: allow Enter to confirm
                        showConfirmButton: true,
                        confirmButtonText: "OK"

                    });
                }
            });
        </script>

</body>



</html>