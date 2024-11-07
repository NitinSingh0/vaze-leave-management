<?php
require('fpdf.php');

// Database connection
include('../../config/connect.php');

// Collect GET parameters
$reportType = $_GET['report_type'];
$college = $_GET['college'];
$department = $_GET['department'];
$staff = $_GET['staff'] ?? null;

// Set the leave columns based on the college and department conditions
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
$pdf->SetFont('Arial', 'B', 16);

// Generate Department Report
if ($reportType === 'department') {
    $pdf->Cell(0, 10, "Department Leave Report", 0, 1, 'C');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, "College: " . ($college === 'D' ? 'Degree' : 'Junior'), 0, 1);

    // Fetch department name
    $departmentQuery = "SELECT Name FROM department WHERE D_id = '$department'";
    $departmentResult = $conn->query($departmentQuery);
    $departmentName = $departmentResult->fetch_assoc()['Name'];
    $pdf->Cell(0, 10, "Department: " . $departmentName, 0, 1);

    // Fetch and display each staff member's leave data
    $staffQuery = "SELECT Staff_id, Name, Designation, DOJ, Username FROM staff WHERE D_id = '$department'";
    $staffResult = $conn->query($staffQuery);

    while ($staffRow = $staffResult->fetch_assoc()) {
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, "Staff: " . $staffRow['Name'], 0, 1);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 10, "Designation: " . $staffRow['Designation'], 0, 1);
        $pdf->Cell(0, 10, "Date of Joining: " . $staffRow['DOJ'], 0, 1);
        $pdf->Cell(0, 10, "Username: " . $staffRow['Username'], 0, 1);

        // Fetch leave totals
        $clLeave = $dlLeave = $otherLeave = 0;
        foreach ($leaveColumns as $column) {
            $leaveQuery = "SELECT SUM(No_of_days) AS total FROM $column WHERE Staff_id = '{$staffRow['Staff_id']}'";
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
        $pdf->Cell(0, 10, "Total CL Leaves: " . $clLeave, 0, 1);
        $pdf->Cell(0, 10, "Total DL Leaves: " . $dlLeave, 0, 1);
        $pdf->Cell(0, 10, "Total Other Leaves: " . $otherLeave, 0, 1);
    }

    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, "Report Generated on: " . date("Y-m-d H:i:s"), 0, 1);
}

// Generate Individual Teacher Report
elseif ($reportType === 'teacher' && $staff) {
    $pdf->Cell(0, 10, "Individual Teacher Leave Report", 0, 1, 'C');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, "College: " . ($college === 'D' ? 'Degree' : 'Junior'), 0, 1);

    // Fetch department and staff names
    $departmentQuery = "SELECT Name FROM department WHERE D_id = '$department'";
    $departmentResult = $conn->query($departmentQuery);
    $departmentName = $departmentResult->fetch_assoc()['Name'];
    $pdf->Cell(0, 10, "Department: " . $departmentName, 0, 1);

    $staffQuery = "SELECT Name, Designation, DOJ, Username FROM staff WHERE Staff_id = '$staff'";
    $staffResult = $conn->query($staffQuery);
    $staffData = $staffResult->fetch_assoc();
    $pdf->Cell(0, 10, "Staff: " . $staffData['Name'], 0, 1);
    $pdf->Cell(0, 10, "Designation: " . $staffData['Designation'], 0, 1);
    $pdf->Cell(0, 10, "Date of Joining: " . $staffData['DOJ'], 0, 1);
    $pdf->Cell(0, 10, "Username: " . $staffData['Username'], 0, 1);

    // Display leave details with approval status = 'PA'
    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, "Leave Details", 0, 1);
    $pdf->SetFont('Arial', '', 10);

    foreach ($leaveColumns as $column) {
        $leaveQuery = "SELECT From_date, To_date, No_of_days FROM $column WHERE Staff_id = '$staff' AND leave_approval_status = 'PA'";
        $leaveResult = $conn->query($leaveQuery);

        $pdf->Cell(0, 10, strtoupper($column) . " Leaves:", 0, 1);
        while ($leaveRow = $leaveResult->fetch_assoc()) {
            $pdf->Cell(0, 10, "From: " . $leaveRow['From_date'] . " To: " . $leaveRow['To_date'] . " Days: " . $leaveRow['No_of_days'], 0, 1);
        }
    }

    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, "Report Generated on: " . date("Y-m-d H:i:s"), 0, 1);
}

// Output PDF
$pdf->Output('D', 'Leave_Report.pdf');
$conn->close();
?>