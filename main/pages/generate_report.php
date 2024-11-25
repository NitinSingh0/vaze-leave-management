<?php
require('fpdf.php');

// Database connection
include('../../config/connect.php');
// Set the timezone
date_default_timezone_set('Asia/Kolkata');
// Collect GET parameters
$reportType = $_GET['report_type'];
$college = $_GET['college'];
$department = $_GET['department'];
$staff = $_GET['staff'] ?? null;



// Set leave columns based on the college and department conditions
$leaveColumns = [];
if ($college === 'D') { // Degree College
    if ($department === 'office_lab') {
        $leaveColumns = ['n_cl_leave', 'n_dl_leave', 'n_emhm_leave', 'n_off_pay_leave'];
    } else {
        $leaveColumns = ['d_cl_leave', 'd_dl_leave', 'd_mhm_leave'];
    }
} elseif ($college === 'J') { // Junior College
    $leaveColumns = ['j_cl_leave', 'j_dl_leave', 'j_ehm_leave'];
}

// Initialize FPDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Times', 'B', 18);

// College Header with Logo
$pdf->Image('../assets/logos/logo.jpg', 10, 10, 20); // College logo at top left corner
$pdf->Cell(0, 10, "V.G. Vaze College of Arts, Science and Commerce", 0, 1, 'C');
$pdf->SetFont('Times', '', 14);
$pdf->Cell(0, 10, "Affiliated to the University of Mumbai", 0, 1, 'C');
$pdf->Ln(10);

// Report Title
$pdf->SetFont('Times', 'B', 16);
$pdf->Cell(0, 10, $reportType === 'department' ? "Department Leave Report" : "Individual Teacher Leave Report", 0, 1, 'C');
$pdf->Ln(5);

// College and Department Information
$pdf->SetFont('Times', '', 12);
$pdf->Cell(0, 10, "College: " . ($college === 'D' ? 'Degree' : 'Junior'), 0, 1);

if ($department) {
    $departmentQuery = "SELECT Name FROM department WHERE D_id = '$department'";
    $departmentResult = $conn->query($departmentQuery);
    $departmentName = $departmentResult->fetch_assoc()['Name'];
    $pdf->Cell(0, 10, "Department: " . $departmentName, 0, 1);
}

// Generate Department Report
if ($reportType === 'department') {
    // Fetch and display each staff member's leave data
    $staffQuery = "SELECT Staff_id, Name, Designation, DOJ, Username FROM staff WHERE D_id = '$department'";
    $staffResult = $conn->query($staffQuery);

    while ($staffRow = $staffResult->fetch_assoc()) {
        $pdf->Ln(8);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(0, 10, "Staff: " . $staffRow['Name'], 0, 1);

        $pdf->SetFont('Times', '', 10);
        $pdf->Cell(0, 10, "Designation: " . $staffRow['Designation'], 0, 1);
        $pdf->Cell(0, 10, "Date of Joining: " . $staffRow['DOJ'], 0, 1);
        $pdf->Cell(0, 10, "Username: " . $staffRow['Username'], 0, 1);

        // Fetch leave totals
        $clLeave = $dlLeave = $otherLeave = 0;
        foreach ($leaveColumns as $column) {
            $leaveQuery = "SELECT SUM(No_of_days) AS total FROM $column WHERE Staff_id = '{$staffRow['Staff_id']}' AND leave_approval_status = 'PA'";
            $leaveResult = $conn->query($leaveQuery);
            $leaveTotal = $leaveResult->fetch_assoc()['total'] ?? 0;

            if (strpos($column, 'cl') !== false) {
                $clLeave += $leaveTotal;
            } elseif (strpos($column, 'dl') !== false) {
                $dlLeave += $leaveTotal;
            } else {
                $otherLeave += $leaveTotal;
            }
        }

        // Display leave totals
        $pdf->SetFont('Times', '', 10);
        $pdf->Cell(0, 8, "Total CL Leaves: " . $clLeave, 0, 1);
        $pdf->Cell(0, 8, "Total DL Leaves: " . $dlLeave, 0, 1);
        $pdf->Cell(0, 8, "Total Other Leaves: " . $otherLeave, 0, 1);
    }

    $pdf->Ln(10);
    $pdf->SetFont('Times', 'B', 12);
    $pdf->Cell(0, 10, "Report Generated on: " .date("F j, Y, g:i A"), 0, 1);
}

// Generate Individual Teacher Report
elseif ($reportType === 'teacher' && $staff) {
    $staffQuery = "SELECT Name, Designation, DOJ, Username FROM staff WHERE Staff_id = '$staff'";
    $staffResult = $conn->query($staffQuery);
    $staffData = $staffResult->fetch_assoc();

    $pdf->Ln(10);
    $pdf->SetFont('Times', 'B', 12);
    $pdf->Cell(0, 10, "Staff: " . $staffData['Name'], 0, 1);
    $pdf->SetFont('Times', '', 10);
    $pdf->Cell(0, 10, "Designation: " . $staffData['Designation'], 0, 1);
    $pdf->Cell(0, 10, "Date of Joining: " . $staffData['DOJ'], 0, 1);
    $pdf->Cell(0, 10, "Username: " . $staffData['Username'], 0, 1);

    // Leave Details with Approval Status = 'PA'
    $pdf->Ln(5);
    $pdf->SetFont('Times', 'B', 12);
    $pdf->Cell(0, 10, "Leave Details", 0, 1);
    $pdf->SetFont('Times', '', 10);

    foreach ($leaveColumns as $column) {
        $leaveQuery = "SELECT From_date, To_date, No_of_days FROM $column WHERE Staff_id = '$staff' AND leave_approval_status = 'PA'";
        $leaveResult = $conn->query($leaveQuery);

        $pdf->Cell(0, 8, strtoupper($column) . " Leaves:", 0, 1);
        while ($leaveRow = $leaveResult->fetch_assoc()) {
            $pdf->Cell(0, 8, "From: " . $leaveRow['From_date'] . " To: " . $leaveRow['To_date'] . " Days: " . $leaveRow['No_of_days'], 0, 1);
        }
    }

    $pdf->Ln(10);
    $pdf->SetFont('Times', 'B', 12);
    $pdf->Cell(0, 10, "Report Generated on: " . date("F j, Y, g:i A"), 0, 1);
}

// Output PDF
$pdf->Output('D', 'Leave_Report.pdf');
$conn->close();
?>