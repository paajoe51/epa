<?php
// Include the PHPExcel library
require ('../assets/vendor/PHPExcel-1.8/Classes/PHPExcel.php');

// Create a new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Your Name")
                             ->setLastModifiedBy("Your Name")
                             ->setTitle("Student Data")
                             ->setSubject("Student Data Export")
                             ->setDescription("Export of student data from the database")
                             ->setKeywords("student data export")
                             ->setCategory("Export");

// Add a worksheet
$objPHPExcel->setActiveSheetIndex(0);
$sheet = $objPHPExcel->getActiveSheet();

// Set column headers
$columns = ['student_id', 'name', 'sex', 'course', 'course_duration', 'batch', 'amount_paid', 'payment_status'];
$col = 'A';
foreach ($columns as $column) {
    $sheet->setCellValue($col . '1', $column);
    $sheet->getColumnDimension($col)->setAutoSize(true);
    $col++;
}

// Fetch data from the database (adjust your database connection details)
include('conn.php');

$query = "SELECT student_id, name, sex, course, course_duration, batch, amount_paid, payment_status FROM students";
$stmt = $db->prepare($query);
$stmt->execute();

// Set row data
$row = 2;
while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $col = 'A';
    foreach ($columns as $column) {
        $sheet->setCellValue($col . $row, $data[$column]);
        $col++;
    }
    $row++;
}

// Save the Excel file
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('student_data.xlsx');

// Redirect to the file
header('Location: student_data.xlsx');
exit;
?>
