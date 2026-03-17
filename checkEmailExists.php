<?php


file_put_contents("debug_log.txt", "checkEmailExists.php was hit at " . date("Y-m-d H:i:s") . "\n", FILE_APPEND);

file_put_contents("debug_log.txt",
    "Hit at " . date("Y-m-d H:i:s") . "\n",
    FILE_APPEND
);

file_put_contents("debug_log.txt",
    "Email received: " . ($_POST['email'] ?? 'NO EMAIL') . "\n",
    FILE_APPEND
);

 echo $_POST['email'] ;



?>