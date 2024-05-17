<?php
include "main.php";

use simitsdk\phpjasperxml\PHPJasperXML;

if (isset($_GET['type']) && isset($_GET['file'])) {
    $type = $_GET['type'];
    $filedir = $_GET['file'];

    // File path
    $filename = __DIR__ . '/templates/' . $filedir;

    $config = parse_ini_file('konfig.ini');

    // enable jika tes welcome
    // $config = [
    //     'driver' => 'array',
    //     'data' => []
    // ];

    // Generate report
    $report = new PHPJasperXML();
    $report->load_xml_file($filename);

    // Loop GET Params
    foreach ($_GET as $key => $value) {
        // Exclude 'type' and 'file' parameters
        if ($key != 'type' && $key != 'file') {
            $report->setParameter([$key => $value]);
        }
    }

    // Set additional parameter
    $report->setParameter(['welcome' => 'Welcome'])
        ->setDataSource($config)
        ->export($type);
} else {
    echo "Type or file parameter is missing.";
}
