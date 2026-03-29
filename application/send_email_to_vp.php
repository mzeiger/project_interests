<!DOCTYPE html>

<html>
<?php
$headTxt = "<head>
    <title>Applicant</title>

    <style>
        /* Ensure padding/borders are included in width calculations so things stay aligned at small widths */
        * {
            box-sizing: border-box;
        }

        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            align-content: center;
            padding: 5px;
            text-align: center;
            margin-left: auto;
            margin-right: auto;
            /* Prevent the layout from shrinking too small on narrow viewports */
            width: clamp(320px, 40%, 1200px);
        }

        .skills,
        .bio {
            border: 1px solid black;
            padding: 10px;
            text-align: left;
            line-height: 1.5;
            width: 100%;
            overflow-wrap: break-word;
        }

        .not_found {
            color: red;
            font-size: 30pt;
        }

        #applicant_info>div {
            width: 100%;
            box-sizing: border-box;
            overflow-x: auto;
        }

        .no-print {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .no-print label {
            white-space: nowrap;
        }

        tr,
        td {
            border: 1px solid black;
            padding: 5px;
        }

        table {
            width: 100%;
            max-width: 100%;
            margin: 0 auto;
            border-collapse: collapse;
        }

        @media (max-width: 400px) {
            body {
                width: 100%;
            }

            table {
                font-size: 14px;
                overflow-x: auto;
            }
        }

        @media print {
            .no-print {
                display: none !important;
            }

            @media print {
                .page-break {
                    page-break-before: always;
                    break-before: page;
                }
            }

            body {
                width: 90%;
            }


        }

        #print-button {
            display: none;
        }
    </style>
</head>

<body> ";


require 'db_connect.php';


$applicantName = $_REQUEST['name'];
$applicantEmail = $_REQUEST['email'];
$applicantInfo = $_REQUEST['applicantInfo'];

$applicantInfo = str_replace('</body>', '', $applicantInfo);
$applicantInfo = $headTxt . $applicantInfo;

$printButton = '<div class="no-print" style="display:flex;justify-content:center;">
        <button id="print-button" onclick="window.print()">Print Page</button>
    </div>';

$applicantInfo .= '<br/>' . $applicantInfo . $printButton . '</body>';

$sql = "select name AS vpName, email AS vpEmail from application_notification";
$query = $dbh->prepare($sql);
$query->execute();
$vps = $query->fetchAll();

foreach ($vps as $vp) {
    sendEmail($applicantName, $applicantEmail, $vp['vpName'], $vp['vpEmail'], $applicantInfo);
}

function sendEmail($applicantName, $applicantEmail, $vpName, $vpEmail, $applicantInfo)
{
    $txt = '';
    $txt .= sprintf('<h1>Hello %s at %s</h1>', $vpName, $vpEmail);
    $txt .= sprintf('<h2>You have received an application from %s at %s</h2>', $applicantName, $applicantEmail);
    $txt .= '<h2>Below is the application:</h2>';
    $txt .=   $applicantInfo;
    doTheSend($vpEmail, $applicantName, $txt);
}

function doTheSend($vpEmail, $applicantName, $msg)
{
    try {
        $to = $vpEmail;

        $now = new DateTime("now", new DateTimeZone("America/Denver"));
        $dt = $now->format('M d, Y H:i A');
        $subject = sprintf('An application has been submitted by %s on %s', $applicantName, $dt);
        $header = "From:noreply-application@monumenthillkiwanis.org" . time() . "\r\n";
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-type: text/html\r\n";
        $retval = mail($to, $subject, $msg, $header);
        //echo sprintf('Mail return value: %s', $retval);
    } catch (exception $ex) {
        echo $ex->getMessage();
    }
}
?>
</body>

</html>