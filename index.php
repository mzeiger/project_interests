<!DOCTYPE HTML>
<!-- index.php is the main call for the interests page for project interests -->

<html>

<head>

    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    <title>Kiwanis Projects</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            background-color: #f8f9fa;
        }

        .project-card {
            margin-bottom: 2rem;
        }

        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2), 0 8px 16px rgba(0, 0, 0, 0.15);
        }

        .card-body {
            padding: 0.75rem;
        }

        .divider {
            background-color: #e9ecef;
            text-align: center;
            font-size: large;
            font-weight: bold;
            padding: 1rem;
            margin: 1rem 0;
            border-radius: 0.5rem;
        }

        .form-check-input {
            width: 1.5em;
            height: 1.5em;
            margin-right: 0.75em;
            border: 2px solid #333;
            background-color: #fff;
            accent-color: #007bff;
            transform: scale(1.1);
            box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .form-check-input:checked {
            box-shadow: inset 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .form-check-label {
            font-weight: bold;
            font-size: 1.1em;
            vertical-align: middle;
        }

        .form-check {
            display: flex;
            align-items: center;
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

    <div class="mt-5" style="width: 80%; margin: 0 auto;">
        <h2 class="text-center mb-3">Select Projects</h2>
        <h3 class="text-center mb-4">Choose the projects that interest you.</h3>


        <?php
        $txt = '<form action="updateProjects.php" method="post" id="submitForm">' . "\n";

        $txt .= '<div class="alert alert-info mb-4" style="max-width: 600px; margin: 0 auto;">';
        $txt .= '<h5>If you can\'t find your email in the <span class="text-success">Select Box</span> below then ';
        $txt .= 'click this button <button type="button" class="btn btn-primary btn-sm" id="sweetAlerts">Register</button> to register.';
        $txt .= ' Otherwise select your email, select your projects, and click on the <span class="text-success">Submit</span> button.</h5>';
        $txt .= '</div>';

        $txt .= '<div class="row mb-4 justify-content-center">';
        $txt .= '<div class="col-md-4">';
        $txt .= selectBox($emails) . "\n";
        $txt .= '</div>';
        $txt .= '<div class="col-md-8 d-flex align-items-center">';
        $txt .= '<button type="submit" class="btn btn-success me-3">Submit</button>' . "\n";
        $txt .= '<button type="button" class="btn btn-secondary me-3" onclick="projectReports()">Go to Report\'s Screen</button>' . "\n";
        $txt .= '<a href="projectinterestinstructions.html" class="btn btn-link" onclick="openInstructions(event)">View Instructions</a>';
        $txt .= '</div>';
        $txt .= '</div>';

        $txt .= '<div class="row">' . "\n";

        foreach ($projects as $project) {

            if ($project['divider'] == 1) {
                $txt .= '<div class="col-12 divider">' . $project['projectName'] . '</div>';
            } else {
                $txt .= '<div class="col-md-6 col-lg-3">';
                $txt .= '<div class="card project-card h-100">';
                $txt .= '<div class="card-body">';
                $txt .= '<div class="form-check mb-2">';
                $txt .= checkbox($project);
                $txt .= '<label class="form-check-label" for="cb-' . $project['id'] . '">' . $project['projectName'] . '</label>';
                $txt .= '</div>';
                $txt .= '<p class="card-text"><strong>Manager:</strong> ' . $project['projectHead'] . '</p>';
                $txt .= '<p class="card-text"><strong>Estimated Time:</strong> ' . $project['estimatedTime'] . '</p>';
                $txt .= '<p class="card-text"><strong>Description:</strong> ' . $project['projectDescription'] . '</p>';
                if (trim($project['fullDescription']) != "") {
                    $txt .= '<button type="button" class="btn btn-info btn-sm openPopup" data-id="' . $project['id'] . '">Full Description</button>';
                }
                $txt .= '</div>';
                $txt .= '</div>';
                $txt .= '</div>';
            }
        }

        $txt .= '</div>' . "\n";

        $txt .= '</form>' . "\n";
        echo $txt;


        function checkbox($proj): string
        {
            $rv = '<input type="checkbox" class="form-check-input projectCheckbox"';
            $rv .= ' name="items[]"';
            $rv .= ' value="' . $proj['projectName'] . ':' . $proj['id'] . '"';
            $rv .= ' id="cb-' . $proj['id'] . '"';
            $rv .= ' title="Select to show interest"';
            $rv .= '>';
            return $rv;
        }

        function selectBox($emails): string
        {
            $rv = '<select id="email_list" name="email_list" class="form-select" onchange="handleEmailSelection(this.value)">';
            $rv .= '<option value=""> -- Select your email -- </option>';
            foreach ($emails as $email) {
                $rv .= '<option value="' . $email['id'] . ':' . $email['email'] . '">' . $email['email'] . '</option>' . "\n";
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
            <input type="email" id="email" class="swal2-input" placeholder="Email" maxlength="50">
            <input type="text" id="fname" class="swal2-input" placeholder="First Name" maxlength="20">
            <input type="text" id="lname" class="swal2-input" placeholder="Last Name" maxlength="30">
            <input type="password" id="pwd" class="swal2-input" placeholder="Password (min 8 characters)" minlength="8" maxlength="128" autocomplete="new-password">
            <input type="password" id="pwd2" class="swal2-input" placeholder="Confirm password" minlength="8" maxlength="128" autocomplete="new-password">
            <br/><br/><br/>
            <div id="outputTrue" style="color:green;"></div>
            <div id="outputFalse" style="color:red;"></div>
        `,
                    showCancelButton: true,
                    confirmButtonText: 'Submit',
                    cancelButtonText: 'Cancel',
                    allowOutsideClick: false,

                    // ? THIS is the key: run fetch here and return false to keep dialog open
                    preConfirm: () => {
                        const email = document.getElementById('email').value.trim();
                        const fname = document.getElementById('fname').value.trim();
                        const lname = document.getElementById('lname').value.trim();
                        const pwd = document.getElementById('pwd').value;
                        const pwd2 = document.getElementById('pwd2').value;

                        if (!email || !fname || !lname || !pwd || !pwd2) {
                            Swal.showValidationMessage('All fields including password are required');
                            return false; // keeps the modal open
                        }

                        if (pwd.length < 8) {
                            Swal.showValidationMessage('Password must be at least 8 characters');
                            return false;
                        }

                        if (pwd !== pwd2) {
                            Swal.showValidationMessage('Passwords do not match');
                            return false;
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
                                    pwd,
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