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
$academicYear = $_GET['academicYear'];
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
class PDF extends FPDF
{
    // Page header
    function Header()
    {
        $this->Image('../assets/logos/logo.jpg', 10, 10, 20);
        $this->SetFont('Times', 'B', 16);
        $this->Cell(0, 10, "V.G. Vaze College of Arts, Science and Commerce", 0, 1, 'C');
        $this->SetFont('Times', '', 12);
        $this->Cell(0, 10, "Affiliated to the University of Mumbai", 0, 1, 'C');
        $this->Ln(10);
    }

    // Page footer
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Times', 'I', 10);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }

    // Table header
    function TableHeader($headers)
    {
        $this->SetFont('Times', 'B', 12);
        foreach ($headers as $header) {
            $this->Cell(45, 8, $header, 1, 0, 'C');
        }
        $this->Ln();
    }

    // Table row
    function TableRow($data)
    {
        $this->SetFont('Times', '', 10);
        foreach ($data as $cell) {
            $this->Cell(45, 8, $cell, 1, 0, 'C');
        }
        $this->Ln();
    }

    // Table header with color
    function ColoredTableHeader($headers, $bgColor)
    {
        $this->SetFillColor($bgColor[0], $bgColor[1], $bgColor[2]);
        $this->SetTextColor(255);
        $this->SetFont('Times', 'B', 12);
        foreach ($headers as $header) {
            $this->Cell(60, 8, $header, 1, 0, 'C', true);
        }
        $this->Ln();
    }

    // Table row with optional fill
    function ColoredTableRow($data, $fill)
    {
        $this->SetFont('Times', '', 10);
        $this->SetFillColor(240, 240, 240);
        $this->SetTextColor(0);
        foreach ($data as $cell) {
            $this->Cell(60, 8, $cell, 1, 0, 'C', $fill);
        }
        $this->Ln();
    }
}

$pdf = new PDF();
$pdf->AddPage();

// Report Title
$pdf->SetFont('Times', 'B', 14);
$pdf->Cell(0, 10, $reportType === 'department' ? "Department Leave Report" : "Individual Teacher Leave Report", 0, 1, 'C');
$pdf->Ln(5);

// College and Department Information
$pdf->SetFont('Times', '', 12);
$pdf->Cell(0, 8, "College: " . ($college === 'D' ? 'Degree' : 'Junior'), 0, 1);
if ($department) {
    $departmentQuery = "SELECT Name FROM department WHERE D_id = '$department'";
    $departmentResult = $conn->query($departmentQuery);
    $departmentName = $departmentResult->fetch_assoc()['Name'];
    $pdf->Cell(0, 8, "Department: " . $departmentName, 0, 1);
}

// Generate Department Report
if ($reportType === 'department') {
    $staffQuery = "SELECT Staff_id, Name, Designation, DOJ, Username FROM staff WHERE D_id = '$department'";
    $staffResult = $conn->query($staffQuery);

    while ($staffRow = $staffResult->fetch_assoc()) {
        $pdf->Ln(10);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(0, 10, "Staff: " . $staffRow['Name'], 0, 1);

        $pdf->SetFont('Times', '', 10);
        $pdf->Cell(0, 8, "Designation: " . $staffRow['Designation'], 0, 1);
        $pdf->Cell(0, 8, "Date of Joining: " . $staffRow['DOJ'], 0, 1);
        $pdf->Cell(0, 8, "Username: " . $staffRow['Username'], 0, 1);

        $clLeave = $dlLeave = $otherLeave = 0;

        // Leave Totals Table
        $pdf->Ln(5);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(0, 8, "Leave Totals", 0, 1);
        $pdf->ColoredTableHeader(['Leave Type', 'Total Days'], [0, 102, 204]);
        $fill = false;
        foreach ($leaveColumns as $column) {
            $leaveQuery = "SELECT SUM(No_of_days) AS total FROM $column WHERE Staff_id = '{$staffRow['Staff_id']}' AND leave_approval_status = 'PA' AND A_year ='$academicYear'";
            $leaveResult = $conn->query($leaveQuery);
            $leaveTotal = $leaveResult->fetch_assoc()['total'] ?? 0;

            if (strpos($column, 'cl') !== false) {
                $clLeave += $leaveTotal;
            } elseif (strpos($column, 'dl') !== false) {
                $dlLeave += $leaveTotal;
            } else {
                $otherLeave += $leaveTotal;
            }

            $pdf->ColoredTableRow([strtoupper($column), $leaveTotal ?: '0'], $fill);
            $fill = !$fill;
        }
    }

    $pdf->Ln(10);
    $pdf->SetFont('Times', 'B', 12);
    $pdf->Cell(0, 10, "Report Generated on: " . date("F j, Y, g:i A") . " for Academic year " . $academicYear . "-" . $academicYear + 1, 0, 1);
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
    $pdf->Cell(0, 8, "Designation: " . $staffData['Designation'], 0, 1);
    $pdf->Cell(0, 8, "Date of Joining: " . $staffData['DOJ'], 0, 1);
    $pdf->Cell(0, 8, "Username: " . $staffData['Username'], 0, 1);
    // Initialize leave totals
    $clLeave = $dlLeave = $otherLeave = 0;

   

    // Generate Leave Details
    foreach ($leaveColumns as $column) {
        $pdf->Ln(10);
        $pdf->SetFont('Times', 'B', 12);
        $leaveType = strtoupper(str_replace(['d_', 'j_', 'n_', '_leave'], '', $column));
        $pdf->Cell(0, 8, "$leaveType Leave Details", 0, 1);

        $pdf->ColoredTableHeader(['From Date', 'To Date', 'No. of Days'], [0, 102, 204]);

        $leaveQuery = "SELECT From_date, To_date, No_of_days FROM $column WHERE Staff_id = '$staff' AND leave_approval_status = 'PA' AND A_year = '$academicYear'";
        $leaveResult = $conn->query($leaveQuery);

        if ($leaveResult->num_rows > 0) {
            $fill = false;
            while ($leaveRow = $leaveResult->fetch_assoc()) {
                $pdf->ColoredTableRow([$leaveRow['From_date'], $leaveRow['To_date'], $leaveRow['No_of_days']], $fill);
                $fill = !$fill;
                // Sum up leave totals
                if (strpos($column, 'cl') !== false) {
                    $clLeave += $leaveRow['No_of_days'];
                } elseif (strpos($column, 'dl') !== false) {
                    $dlLeave += $leaveRow['No_of_days'];
                } else {
                    $otherLeave += $leaveRow['No_of_days'];
                }
            }
        } else {
            $pdf->ColoredTableRow(['-', '-', 'No Data'], false);
        }
    }
    // Display total leave counts
    $pdf->Ln(5);
    $pdf->SetFont('Times', 'B', 12);
    $pdf->Cell(0, 10, "Total Leave Summary:", 0, 1);
    $pdf->SetFont('Times', '', 10);
    $pdf->Cell(0, 8, "Total CL Leaves: " . $clLeave, 0, 1);
    $pdf->Cell(0, 8, "Total DL Leaves: " . $dlLeave, 0, 1);
    $pdf->Cell(0, 8, "Total Other Leaves: " . $otherLeave, 0, 1);

    $pdf->Ln(10);
    $pdf->SetFont('Times', 'B', 12);
    $pdf->Cell(0, 10, "Report Generated on: " . date("F j, Y, g:i A") . " for Academic year " . $academicYear."-".$academicYear+1, 0, 1);
}

// Output PDF
$pdf->Output('D', 'Leave_Report.pdf');
$conn->close();
?>