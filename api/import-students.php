<?php
require('../assets/vendor/PhpSpreadsheet-1.23.0/src/Bootstrap.php');
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

// Function to validate and sanitize data
function sanitizeData($data) {
    // Your validation and sanitization logic here
    return $data;
}

$importedRecords = 0;
$skippedRecords = 0;

if (isset($_FILES['file']) && !empty($_FILES['file']['tmp_name'])) {
    $inputFileName = $_FILES['file']['tmp_name'];

    $reader = new Xlsx();
    $spreadsheet = $reader->load($inputFileName);
    $sheet = $spreadsheet->getActiveSheet();

    // Assuming the first row contains headers
    $headers = $sheet->rangeToArray('A1:' . $sheet->getHighestDataColumn() . '1')[0];

    // Get the column index of student_id
    $studentIdColumnIndex = array_search('student_id', $headers);

    // Fetch data from the database
    $query = "SELECT student_id FROM students";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $existingStudentIds = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Iterate through rows
    foreach ($sheet->getRowIterator(2) as $row) {
        $rowData = $row->toArray(null, true, true, true);

        // Assuming student_id is in column A
        $studentId = sanitizeData($rowData['A']);

        if (!in_array($studentId, $existingStudentIds)) {
            // Perform your import logic here

            // Increment the imported records count
            $importedRecords++;
        } else {
            // Increment the skipped records count
            $skippedRecords++;
        }
    }
}

$result = [
    'importedRecords' => $importedRecords,
    'skippedRecords' => $skippedRecords,
];

// Return the result as JSON
header('Content-Type: application/json');
echo json_encode($result);
?>
