<?php
// Include the database connection file
include('../../../config/connect.php');

if (isset($_POST['dept']) && !empty($_POST['dept'])) {

    $dept = $_POST['dept'];
    $query = "SELECT * from staff where D_id='$dept'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '
    <tr>
        <td class="px-4 py-2 text-center">' . $row["Name"] . '</td>
        <td class="px-4 py-2 text-center">
            <span class="' . ($row["status"] === 'A' ? 'text-green-500' : 'text-red-500') . '">' . ($row["status"] === 'A' ? 'Active' : 'Deactive') . '</span>
        </td>
        <td class="px-4 py-2 text-center">' . $row["DOJ"] . '</td>
      <td class="px-4 py-2 text-center">
    <a href="#" class=" toggle-status block w-full text-center p-2 text-sm ' .
                ($row["status"] === 'A' ? 'bg-red-500 text-white' : 'bg-green-500 text-white') . ' rounded-lg hover:bg-opacity-75" data-staff-id="' . $row["Staff_id"] . '"  data-new-status="' . ($row["status"] === 'A' ? 'D' : 'A') . '">
        ' . ($row["status"] === 'A' ? 'Deactivate' : 'Activate') . '
    </a>
</td>
    </tr>
';
        }
    } else {
        echo '<tr class=" text-center">
                        <td colspan="4">No Staff Members</td>
                    </tr>';
    }
}

if (isset($_POST['ndept']) && !empty($_POST['ndept'])) {


    $ndept = $_POST['ndept'];
    $nquery = "SELECT * from staff where D_id='$ndept'";
    $nresult = $conn->query($nquery);
    if ($nresult->num_rows > 0) {
        while ($row = $nresult->fetch_assoc()) {
            echo '
    <tr>
        <td class="px-4 py-2 text-center">' . $row["Name"] . '</td>
        <td class="px-4 py-2 text-center">
            <span class="' . ($row["status"] === 'A' ? 'text-green-500' : 'text-red-500') . '">' . ($row["status"] === 'A' ? 'Active' : 'Deactive') . '</span>
        </td>
        <td class="px-4 py-2 text-center">' . $row["DOJ"] . '</td>
      <td class="px-4 py-2 text-center">
    <a href="#" class=" toggle-status2 block w-full text-center p-2 text-sm ' .
                ($row["status"] === 'A' ? 'bg-red-500 text-white' : 'bg-green-500 text-white') . ' rounded-lg hover:bg-opacity-75" data-staff-id="' . $row["Staff_id"] . '"  data-new-status="' . ($row["status"] === 'A' ? 'D' : 'A') . '">
        ' . ($row["status"] === 'A' ? 'Deactivate' : 'Activate') . '
    </a>
</td>
    </tr>
';
        }
    } else {
        echo '<tr class=" text-center">
                        <td colspan="4">No Staff Members</td>
                    </tr>';
    }
}
