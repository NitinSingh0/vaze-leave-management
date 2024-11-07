$(document).ready(function () {
  // Tab switching
  $("#department-tab").on("click", function () {
    $(".report-form").hide();
    $("#department-form").show();
  });

  $("#teacher-tab").on("click", function () {
    $(".report-form").hide();
    $("#teacher-form").show();
  });
  
  // Load departments based on selected college
    $("#college, #college-teacher").change(function () {
        alert("change function");
    let collegeType = $(this).val();
    let target =
      $(this).attr("id") === "college" ? "#department" : "#department-teacher";

    $.ajax({
      url: "get_departments.php",
      method: "POST",
      data: { college: collegeType },
      success: function (response) {
        $(target).html(response);
      },
    });
  });

  // Load staff based on selected department
    $("#department-teacher").change(function () {
      
        let departmentId = $(this).val();
        

    $.ajax({
      url: "get_staff.php",
      method: "POST",
      data: { department_id: departmentId },
      success: function (response) {
        $("#staff").html(response);
      },
    });
  });

  // Download reports
  $("#download-department-report").on("click", function () {
    let college = $("#college").val();
    let department = $("#department").val();
    window.location.href = `generate_report.php?report_type=department&college=${college}&department=${department}`;
  });

  $("#download-teacher-report").on("click", function () {
    let college = $("#college-teacher").val();
    let department = $("#department-teacher").val();
    let staff = $("#staff").val();
    window.location.href = `generate_report.php?report_type=teacher&college=${college}&department=${department}&staff=${staff}`;
  });
});
