<?php

$dumpfile = time() . '.ecowitt-data.json';

file_put_contents($dumpfile, "--- POST ---\n", FILE_APPEND);
file_put_contents($dumpfile, json_encode($_POST), FILE_APPEND);
file_put_contents($dumpfile, "\n--- SERVER ---\n", FILE_APPEND);
file_put_contents($dumpfile, json_encode($_SERVER), FILE_APPEND);
file_put_contents($dumpfile, "\n--- GET ---\n", FILE_APPEND);
file_put_contents($dumpfile, json_encode($_GET), FILE_APPEND);
file_put_contents($dumpfile, "\n--- RAW POST ---\n", FILE_APPEND);
file_put_contents($dumpfile,  file_get_contents('php://input'), FILE_APPEND);