  <?php
    error_reporting(0);

    $Staff_id = $_SESSION['Staff_id'];

    if (!$Staff_id) {
        echo "<script>alert('User not logged in.'); window.location.href='login.php';</script>";
        exit;
    }


    // Check if the first file exists
    if (file_exists('../../config/connect.php')) {
        include('../../config/connect.php');
    } else {
        // If the first file doesn't exist, include the fallback file
        include('../../../config/connect.php');
    }

    // Include your DB connection file

    // Fetch the existing password for the staff
    $sql = "SELECT * FROM staff WHERE Staff_id = '$Staff_id'";
    $result = $conn->query($sql);
    if ($result && $row = $result->fetch_assoc()) {
        $jobRole = $row['Job_role'];
        $designation = $row['Designation'];
    }
    ?>

  <!-- Sidebar -->
  <aside class="fixed flex flex-col w-1/5 bg-white border-r h-full px-4 py-6 overflow-y-auto">
      <ul class="space-y-2">
          <li>
              <details class="group">
                  <summary class="flex items-center justify-between px-4 py-2 text-gray-700 cursor-pointer font-medium">
                      Apply Leave
                      <span class="transition duration-300 transform group-open:-rotate-180">
                          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                              <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                          </svg>
                      </span>
                  </summary>
                  <ul class="mt-2 pl-4 space-y-1">
                      <!-- Leave options based on job role -->
                      <li><a href="#" class="block px-4 py-2 text-gray-700" onclick="loadContent('dl')">Duty Leave</a></li>
                      <li><a href="#" class="block px-4 py-2 text-gray-700" onclick="loadContent('cl')">Casual Leave</a></li>
                      <!-- Conditional rendering for MHM, EHM, OFF pay, etc. -->
                      <?php if ($jobRole == 'TD'): ?>
                          <li><a href="#" class="block px-4 py-2 text-gray-700" onclick="loadContent('medical')">MHM</a></li>
                      <?php elseif ($jobRole == 'TJ'): ?>
                          <li><a href="#" class="block px-4 py-2 text-gray-700" onclick="loadContent('medical')">EHM</a></li>
                      <?php elseif ($jobRole == 'NL'): ?>
                          <li><a href="#" class="block px-4 py-2 text-gray-700" onclick="loadContent('mediacl')">MHM</a></li>
                          <li><a href="#" class="block px-4 py-2 text-gray-700" onclick="loadContent('APPLY_OFF_PAY')">OFF Pay</a></li>
                      <?php elseif ($jobRole == 'NO'): ?>
                          <li><a href="#" class="block px-4 py-2 text-gray-700" onclick="loadContent('APPLY_OFF_PAY')">OFF Pay</a></li>
                          <li><a href="#" class="block px-4 py-2 text-gray-700" onclick="loadContent('medical')">MHME</a></li>
                      <?php elseif ($jobRole == 'OO'): ?>
                          <li><a href="#" class="block px-4 py-2 text-gray-700" onclick="loadContent('APPLY_OFF_PAY')">OFF Pay</a></li>
                          <li><a href="#" class="block px-4 py-2 text-gray-700" onclick="loadContent('medical')">MHME</a></li>
                      <?php endif; ?>
                  </ul>
              </details>
          </li>
          <li><a href="#" class="block px-4 py-2 text-gray-700" onclick="loadContent('status')">Check Status</a></li>
          <li><a href="#" class="block px-4 py-2 text-gray-700" onclick="loadContent('summary')">Summary</a></li>

          <!-- Additional options only for designation Principal , Vice Principal and HOD -->

          <?php if ($designation == 'Principal'): ?>

              <li><a href="Report.php" class="block px-4 py-2 text-gray-700">Report</a></li>

          <?php endif; ?>

          <?php if ($designation == 'HOD'): ?>
              <li><a href="HOD.php" class="block px-4 py-2 text-gray-700">HOD Leave Request</a></li>
              <li><a href="HOD_Report.php" class="block px-4 py-2 text-gray-700">Generate Report</a></li>
          <?php endif; ?>
          <?php if (strcasecmp(trim($designation), 'Vice Principal') === 0): ?>
              <li><a href="vicePrincipal.php" class="block px-4 py-2 text-gray-700" onclick="loadContent('VicePrincipalLeaveRequest')">Vice Principal Leave Request</a></li>

          <?php endif; ?>
      </ul>
      <!-- Additional options only for job role OO -->
      <?php if ($jobRole == 'OO' or $designation == 'Principal'): ?>
          <div class="mt-6">
              <h3 class="font-medium text-gray-800">Admin Options </h3>
              <ul class="mt-2 space-y-2">
                  <?php if ($jobRole == 'OO'): ?>
                      <li><a href="officeRemark.php" class="block px-4 py-2 text-gray-700">Leave Request</a></li>
                  <?php endif ?>

                  <?php if ($designation == 'Principal'): ?>
                      <li><a href="principalRequest.php" class="block px-4 py-2 text-gray-700">Principal Leave Request</a></li>
                  <?php endif ?>

                  <li><a href="#" class="block px-4 py-2 text-gray-700" onclick="loadContent('registration')">New Registration</a></li>
                  <li><a href="assignleave/assign_leave.php" class="block px-4 py-2 text-gray-700">Assign Leave</a></li>
                  <li><a href="#" class="block px-4 py-2 text-gray-700" onclick="loadContent('update')">Update Details</a></li>
                  <li><a href="#" class="block px-4 py-2 text-gray-700 mb-5" onclick="loadContent('active/deactive')">Deactivate Users</a></li>
              </ul>
          </div>
      <?php endif; ?>
  </aside>
  <script>
      function loadContent(page) {
          // Get the base URL up to the directory containing index.php
          const baseUrl = `${window.location.origin}/vaze-leave-management/main/pages/`;

          // Check if the current page is 'index.php'
          const isMainPage = window.location.pathname.includes("index.php");

          if (!isMainPage) {
              // Redirect to index.php with the 'page' parameter, using the base URL
              window.location.href = `${baseUrl}index.php?page=${page}`;
          } else {
              // If already on index.php, load the content dynamically
              fetch(`../components/${page}.php`)
                  .then(response => response.text())
                  .then(data => {
                      document.getElementById('dynamicContent').innerHTML = data;
                  })
                  .catch(error => console.error('Error loading content:', error));
          }
      }
  </script>