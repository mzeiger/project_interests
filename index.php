<?php
session_start();

require __DIR__ . '/db_connect.php';

$sql = 'select * from project order by position';
$query = $dbh->prepare($sql);
$query->execute();
$projects = $query->fetchAll(PDO::FETCH_ASSOC);

$loggedIn = !empty($_SESSION['person_id']);
$signedInEmail = $loggedIn ? (string) ($_SESSION['person_email'] ?? '') : '';
?>
<!DOCTYPE HTML>
<!-- index.php is the main call for the interests page for project interests -->

<html>

<head>

    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    <title>Kiwanis Projects</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
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

        .pwd-input-wrap {
            position: relative;
            width: 100%;
        }

        .pwd-input-wrap .form-control {
            padding-right: 2.5rem;
        }

        .pwd-input-wrap .pwd-toggle-inside {
            position: absolute;
            right: 0.2rem;
            top: 50%;
            transform: translateY(-50%);
            width: 2.25rem;
            height: 1.85rem;
            border: none;
            background: transparent;
            color: #6c757d;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.25rem;
            z-index: 5;
            padding: 0;
        }

        .pwd-input-wrap .pwd-toggle-inside:hover,
        .pwd-input-wrap .pwd-toggle-inside:focus-visible {
            color: #212529;
            background: rgba(0, 0, 0, 0.06);
            outline: none;
        }

        .pwd-input-wrap .pwd-toggle-inside i {
            font-size: 1.1rem;
            pointer-events: none;
        }

        .swal-register-form .pwd-input-wrap .pwd-toggle-inside {
            height: 1.65rem;
            width: 2.1rem;
        }

        .swal-register-form .pwd-input-wrap .pwd-toggle-inside i {
            font-size: 1rem;
        }

        .action-toolbar {
            background: #fff;
            border: 1px solid #dee2e6;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
            max-width: 56rem;
            margin-left: auto;
            margin-right: auto;
        }

        .swal-register-form {
            text-align: left;
        }

        .swal-register-form .reg-field {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 0.65rem;
        }

        .swal-register-form .reg-field>label {
            flex: 0 0 6.25rem;
            margin: 0;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .swal-register-form .reg-field-grow {
            flex: 1;
            min-width: 0;
        }

        .swal-register-form .reg-field-grow .form-control {
            width: 100%;
        }
    </style>

</head>

<body data-logged-in="<?php echo $loggedIn ? '1' : '0'; ?>">

    <div class="mt-5" style="width: 80%; margin: 0 auto;">
        <h2 class="text-center mb-3">Select Projects</h2>
        <h3 class="text-center mb-4">Choose the projects that interest you.</h3>


        <?php
        $txt = '<form action="updateProjects.php" method="post" id="submitForm">' . "\n";

        $txt .= '<div class="alert alert-info mb-4" style="max-width: 720px; margin: 0 auto;">';
        $txt .= '<h5 class="mb-0">Click <strong>Sign in</strong> and enter your email and password to load and save your interests. ';
        $txt .= 'New here? Click <button type="button" class="btn btn-primary btn-sm" id="sweetAlerts">Register</button>. ';
        $txt .= 'After signing in, choose projects and click <span class="text-success">Submit</span>.</h5>';
        $txt .= '</div>';

        $guestClass = $loggedIn ? 'd-none' : '';
        $userClass = $loggedIn ? '' : 'd-none';
        $safeEmail = htmlspecialchars($signedInEmail, ENT_QUOTES, 'UTF-8');

        $txt .= '<div class="row mb-4 justify-content-center">';
        $txt .= '<div class="col-12 px-2">';
        $txt .= '<div class="action-toolbar d-flex flex-wrap align-items-center justify-content-evenly gap-2 gap-md-3 px-2 px-sm-3 py-3 w-100">';
        $txt .= '<div id="authGuest" class="d-flex align-items-center ' . $guestClass . '">';
        $txt .= '<button type="button" class="btn btn-primary" id="btnOpenSignIn">Sign in</button>';
        $txt .= '</div>';
        $txt .= '<div id="authUser" class="d-flex flex-wrap align-items-center justify-content-center gap-2 ' . $userClass . '">';
        $txt .= '<span class="text-nowrap mb-0"><strong>Signed in as</strong> <span id="signedInEmail">' . $safeEmail . '</span></span>';
        $txt .= '<a href="logout.php" class="btn btn-outline-secondary">Sign out</a>';
        $txt .= '</div>';
        $txt .= '<button type="submit" class="btn btn-success">Submit</button>' . "\n";
        $txt .= '<button type="button" class="btn btn-secondary" onclick="projectReports()">Go to Report\'s Screen</button>' . "\n";
        $txt .= '<a href="projectinterestinstructions.html" class="btn btn-link py-2" onclick="openInstructions(event)">View Instructions</a>';
        $txt .= '</div></div></div>';

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
            function setSignedInView(email) {
                document.body.dataset.loggedIn = '1';
                document.getElementById('authGuest').classList.add('d-none');
                document.getElementById('authUser').classList.remove('d-none');
                document.getElementById('signedInEmail').textContent = email;
            }

            function escapeHtmlForSwal(s) {
                const d = document.createElement('div');
                d.textContent = s;
                return d.innerHTML;
            }

            function openForgotPasswordDialog() {
                Swal.fire({
                    title: 'Forgot password',
                    width: '28rem',
                    html: `
            <p class="text-start small text-muted mb-2">Enter your account email. If it is registered, we will send a message to that address with a link to reset your password. The link is valid for one hour.</p>
            <label for="fp_email" class="form-label small mb-1">Email</label>
            <input type="email" id="fp_email" class="form-control form-control-sm" autocomplete="email" maxlength="50">
        `,
                    showCancelButton: true,
                    confirmButtonText: 'Send reset link',
                    cancelButtonText: 'Cancel',
                    allowOutsideClick: false,
                    focusConfirm: false,
                    didOpen: () => {
                        document.getElementById('fp_email').focus();
                    },
                    preConfirm: () => {
                        const email = document.getElementById('fp_email').value.trim();
                        if (!email) {
                            Swal.showValidationMessage('Enter your email.');
                            return false;
                        }
                        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                            Swal.showValidationMessage('Enter a valid email.');
                            return false;
                        }
                        Swal.showLoading();
                        return fetch('forgot_password_request.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded'
                                },
                                body: new URLSearchParams({
                                    email
                                }),
                                credentials: 'same-origin',
                            })
                            .then((r) => r.json())
                            .then((data) => {
                                Swal.hideLoading();
                                if (!data.ok) {
                                    Swal.showValidationMessage(data.error || 'Request failed.');
                                    return false;
                                }
                                return {
                                    message: data.message ||
                                        'If an account exists for that email, check your inbox.',
                                    dev_reset_url: data.dev_reset_url || null,
                                };
                            })
                            .catch(() => {
                                Swal.hideLoading();
                                Swal.showValidationMessage('Network error. Please try again.');
                                return false;
                            });
                    },
                }).then((result) => {
                    if (!result.isConfirmed || !result.value) {
                        return;
                    }
                    const v = result.value;
                    if (typeof v === 'object' && v.dev_reset_url) {
                        const u = v.dev_reset_url;
                        Swal.fire({
                            title: 'Password reset link',
                            html: `<p class="text-start small mb-3">${escapeHtmlForSwal(v.message)}</p>
                <p class="mb-2"><a class="btn btn-primary" target="_blank" rel="noopener noreferrer" href="${escapeHtmlForSwal(u)}">Open reset page</a></p>
                <button type="button" class="btn btn-outline-secondary btn-sm" id="swalCopyResetUrl">Copy URL to clipboard</button>`,
                            confirmButtonText: 'Close',
                            didOpen: () => {
                                const btn = document.getElementById('swalCopyResetUrl');
                                if (btn) {
                                    btn.addEventListener('click', () => {
                                        navigator.clipboard.writeText(u).then(() => {
                                            btn.textContent = 'Copied!';
                                        }).catch(() => {
                                            sweetAlerts('', 'Could not copy. Select the address from the browser bar after opening the link.', 'info');
                                        });
                                    });
                                }
                            },
                        });
                    } else if (typeof v === 'object' && v.message) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Check your email',
                            text: v.message,
                            confirmButtonText: 'Close',
                        });
                    } else if (typeof v === 'string' && v) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Check your email',
                            text: v,
                            confirmButtonText: 'Close',
                        });
                    }
                });
            }

            function openSignInDialog() {
                Swal.fire({
                    title: 'Sign in',
                    width: '30rem',
                    html: `
            <div class="swal-register-form px-1">
              <div class="reg-field">
                <label for="signin_email">Email</label>
                <div class="reg-field-grow"><input type="email" id="signin_email" class="form-control form-control-sm" maxlength="50" autocomplete="username"></div>
              </div>
              <div class="reg-field">
                <label for="signin_pwd">Password</label>
                <div class="reg-field-grow">
                  <div class="pwd-input-wrap">
                    <input type="password" id="signin_pwd" class="form-control form-control-sm" maxlength="128" autocomplete="current-password">
                    <button type="button" class="pwd-toggle-inside signin-pwd-toggle" data-target="signin_pwd" title="Show password" aria-label="Show password"><i class="bi bi-eye"></i></button>
                  </div>
                </div>
              </div>
              <div class="d-flex justify-content-end w-100 mt-1">
                <button type="button" class="btn btn-link btn-sm p-0 swal-forgot-link">Forgot password?</button>
              </div>
            </div>
        `,
                    showCancelButton: true,
                    confirmButtonText: 'Sign in',
                    cancelButtonText: 'Cancel',
                    allowOutsideClick: false,
                    focusConfirm: false,

                    didOpen: () => {
                        document.getElementById('signin_email').focus();
                        document.querySelectorAll('.signin-pwd-toggle').forEach((btn) => {
                            btn.addEventListener('click', () => {
                                const id = btn.getAttribute('data-target');
                                const input = document.getElementById(id);
                                if (!input) return;
                                const icon = btn.querySelector('i');
                                const show = input.type === 'password';
                                input.type = show ? 'text' : 'password';
                                if (icon) {
                                    icon.className = show ? 'bi bi-eye-slash' : 'bi bi-eye';
                                }
                                btn.setAttribute('title', show ? 'Hide password' : 'Show password');
                                btn.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
                            });
                        });
                        const forgot = document.querySelector('.swal-forgot-link');
                        if (forgot) {
                            forgot.addEventListener('click', (ev) => {
                                ev.preventDefault();
                                Swal.close();
                                setTimeout(() => openForgotPasswordDialog(), 200);
                            });
                        }
                    },

                    preConfirm: () => {
                        const email = document.getElementById('signin_email').value.trim();
                        const pwd = document.getElementById('signin_pwd').value;
                        if (!email || !pwd) {
                            Swal.showValidationMessage('Email and password are required.');
                            return false;
                        }
                        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                            Swal.showValidationMessage('Enter a valid email.');
                            return false;
                        }

                        Swal.showLoading();

                        return fetch('login.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded'
                                },
                                body: new URLSearchParams({
                                    email,
                                    pwd
                                }),
                                credentials: 'same-origin',
                            })
                            .then((r) => r.json())
                            .then((data) => {
                                Swal.hideLoading();
                                if (!data.ok) {
                                    Swal.showValidationMessage(data.error || 'Sign-in failed.');
                                    return false;
                                }
                                setSignedInView(data.email);
                                loadUserProjectChecks();
                                return true;
                            })
                            .catch(() => {
                                Swal.hideLoading();
                                Swal.showValidationMessage('Network error. Please try again.');
                                return false;
                            });
                    },
                });
            }

            function loadUserProjectChecks() {
                document.querySelectorAll('.projectCheckbox').forEach((cb) => {
                    cb.checked = false;
                });
                fetch('populateCheckBoxes.php', {
                        method: 'POST',
                        credentials: 'same-origin',
                    })
                    .then((r) => r.json())
                    .then((ids) => {
                        ids.forEach((id) => {
                            const el = document.getElementById(id);
                            if (el) {
                                el.checked = true;
                            }
                        });
                    });
            }

            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('btnOpenSignIn').addEventListener('click', (e) => {
                    e.preventDefault();
                    openSignInDialog();
                });

                const qs = new URLSearchParams(window.location.search);
                if (qs.get('reset') === '1') {
                    sweetAlerts('Password updated', 'You can sign in with your new password.', 'success');
                    if (window.history.replaceState) {
                        window.history.replaceState({}, '', window.location.pathname);
                    }
                }

                if (document.body.dataset.loggedIn === '1') {
                    loadUserProjectChecks();
                }

                document.getElementById('submitForm').addEventListener('submit', async function(event) {
                    event.preventDefault();
                    if (document.body.dataset.loggedIn !== '1') {
                        sweetAlerts('', 'Please sign in before submitting.', 'warning');
                        return;
                    }
                    const formData = new FormData();
                    document
                        .querySelectorAll('.projectCheckbox:checked')
                        .forEach((cb) => formData.append('items[]', cb.value));

                    const response = await fetch('updateProjects.php', {
                        method: 'POST',
                        body: formData,
                        credentials: 'same-origin',
                    });

                    const message = await response.text();
                    sweetAlerts('Results', message, 'info');
                });
            });
        </script>

        <script>
            document.getElementById('sweetAlerts').addEventListener('click', (event) => {
                event.preventDefault();
                Swal.fire({
                    title: 'Register',
                    width: '34rem',
                    html: `
            <div class="swal-register-form px-1">
              <div class="reg-field">
                <label for="email">Email</label>
                <div class="reg-field-grow"><input type="email" id="email" class="form-control form-control-sm" maxlength="50" autocomplete="email"></div>
              </div>
              <div class="reg-field">
                <label for="fname">First name</label>
                <div class="reg-field-grow"><input type="text" id="fname" class="form-control form-control-sm" maxlength="20" autocomplete="given-name"></div>
              </div>
              <div class="reg-field">
                <label for="lname">Last name</label>
                <div class="reg-field-grow"><input type="text" id="lname" class="form-control form-control-sm" maxlength="30" autocomplete="family-name"></div>
              </div>
              <div class="reg-field">
                <label for="pwd">Password</label>
                <div class="reg-field-grow">
                  <div class="pwd-input-wrap">
                    <input type="password" id="pwd" class="form-control form-control-sm" minlength="8" maxlength="128" autocomplete="new-password" placeholder="Min. 8 characters">
                    <button type="button" class="pwd-toggle-inside reg-pwd-toggle" data-target="pwd" title="Show password" aria-label="Show password"><i class="bi bi-eye"></i></button>
                  </div>
                </div>
              </div>
              <div class="reg-field">
                <label for="pwd2">Confirm</label>
                <div class="reg-field-grow">
                  <div class="pwd-input-wrap">
                    <input type="password" id="pwd2" class="form-control form-control-sm" minlength="8" maxlength="128" autocomplete="new-password" placeholder="Re-enter password">
                    <button type="button" class="pwd-toggle-inside reg-pwd-toggle" data-target="pwd2" title="Show password" aria-label="Show password"><i class="bi bi-eye"></i></button>
                  </div>
                </div>
              </div>
            </div>
            <div id="outputTrue" style="color:green;margin-top:0.5rem;"></div>
            <div id="outputFalse" style="color:red;margin-top:0.25rem;"></div>
        `,
                    showCancelButton: true,
                    confirmButtonText: 'Submit',
                    cancelButtonText: 'Cancel',
                    allowOutsideClick: false,

                    didOpen: () => {
                        document.querySelectorAll('.reg-pwd-toggle').forEach((btn) => {
                            btn.addEventListener('click', () => {
                                const id = btn.getAttribute('data-target');
                                const input = document.getElementById(id);
                                if (!input) return;
                                const icon = btn.querySelector('i');
                                const show = input.type === 'password';
                                input.type = show ? 'text' : 'password';
                                if (icon) {
                                    icon.className = show ? 'bi bi-eye-slash' : 'bi bi-eye';
                                }
                                btn.setAttribute('title', show ? 'Hide password' : 'Show password');
                                btn.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
                            });
                        });
                    },

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
                                credentials: 'same-origin',
                            })
                            .then((r) => r.text())
                            .then((text) => {
                                if (text.startsWith('t')) {
                                    setSignedInView(email);
                                    loadUserProjectChecks();
                                    Swal.close();
                                    sweetAlerts('Welcome', 'You are registered and signed in.', 'success');
                                } else if (text === 'false') {
                                    document.getElementById('outputFalse').innerHTML =
                                        'Email already exists';
                                    document.getElementById('outputTrue').innerHTML = '';
                                } else {
                                    document.getElementById('outputFalse').innerHTML = text;
                                    document.getElementById('outputTrue').innerHTML = '';
                                }

                                return false;
                            });
                    },
                });
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