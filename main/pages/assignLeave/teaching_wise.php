<?php
// Include the database connection file
include('../../../config/connect.php');

// Teaching staff Form
if (isset($_POST['year']) && !empty($_POST['year']) && !empty($_POST['dept']) && !empty($_POST['type']) && !empty($_POST['sub_table'])) {

    $dept = $_POST['dept'];
    $year = $_POST['year'];
    $type = $_POST['type'];
    $sub_table = $_POST['sub_table'];
    $query = "SELECT * FROM staff where D_id='$dept' AND status='A' ";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        echo '
        <div class=" m-2 p-4 border-2 border-blue-800 border-opacity-10 rounded-sm">
';

        //iF Teacher Wise is selected
        if ($sub_table == 1) {
            echo '
        <div class="mb-4">
        <label class=" pl-2 mb-3 block text-base text-gray-700 font-semibold">Teacher</label>
        <select name="teacher_wise_teacher" id="teacher_wise_teacher" class="focus:ring-2 focus:ring-blue-500 w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-gray-700  outline-none focus:border-[#6A64F1] focus:shadow-md ">
        ';
            echo '<option  value="" selected disabled > Select a Teacher</option>';

            while ($row = $result->fetch_assoc()) {
                echo '<option  value="' . $row['Staff_id'] . '">' . $row['Name'] . '</option>';
            }
            echo '</select>
        </div>';
        }



        echo '<div class="-mx-3 flex flex-wrap">
                        <div class="w-full px-3 sm:w-1/2">
                            <div class="mb-5">
                                <label class="pl-2 mb-3 block text-base text-gray-700 font-semibold">
                                   Casual Leave
                                </label>
                                <input type="number" placeholder="No. Of Casual Leave" min="0" name="' . ($sub_table == 1 ? 'teacher_wise_cl' : 'department_wise_cl') . '" id="' . ($sub_table == 1 ? 'teacher_wise_cl' : 'department_wise_cl') . '" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-gray-700  outline-none focus:border-[#6A64F1] focus:shadow-md focus:ring-2 focus:ring-blue-500""/>
                                    
                            </div>

                        </div>

                        <div class="w-full px-3 sm:w-1/2">
                            <div class="mb-5">
                                <label class=" pl-2 mb-3 block text-base text-gray-700 font-semibold">
                                   Maternity Leave
                                </label>
                                <input type="number" placeholder="No. Of Maternity Leave" min="0" name="' . ($sub_table == 1 ? 'teacher_wise_ma' : 'department_wise_ma') . '" id="' . ($sub_table == 1 ? 'teacher_wise_ma' : 'department_wise_ma') . '" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-gray-700  outline-none focus:border-[#6A64F1] focus:shadow-md focus:ring-2 focus:ring-blue-500""/>
                                 

                            </div>
                        </div>
                    </div>
 
 
 
 ';
        //If degree then Ml
        if ($type === 'D') {
            echo '
                       <div class="-mx-3 flex flex-wrap">
                        <div class="w-full px-3 sm:w-1/2">
                            <div class="mb-5">
                                <label class="pl-2 mb-3 block text-base text-gray-700 font-semibold">
                                   Half Pay Leave
                                </label>
                                <input type="number" placeholder="No. Of Half Pay Leave"  min="0" name="' . ($sub_table == 1 ? 'teacher_wise_hl' : 'department_wise_hl') . '" id="' . ($sub_table == 1 ? 'teacher_wise_hl' : 'department_wise_hl') . '" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-gray-700  outline-none focus:border-[#6A64F1] focus:shadow-md focus:ring-2 focus:ring-blue-500""/>
                                    
                            </div>

                        </div>

                        <div class="w-full px-3 sm:w-1/2">
                            <div class="mb-5">
                                <label class=" pl-2 mb-3 block text-base text-gray-700 font-semibold">
                                   Medical Leave
                                </label>
                                <input type="number" min="0" placeholder="No. Of Medical Leave"  name="' . ($sub_table == 1 ? 'teacher_wise_ml_el' : 'department_wise_ml_el') . '" id="' . ($sub_table == 1 ? 'teacher_wise_ml_el' : 'department_wise_ml_el') . '" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-gray-700  outline-none focus:border-[#6A64F1] focus:shadow-md focus:ring-2 focus:ring-blue-500""/>
                                 

                            </div>
                        </div>
                    </div>
    
    
    ';         // if Junior Then EL
        } elseif ($type === 'J') {

            echo '
                       <div class="-mx-3 flex flex-wrap">
                        <div class="w-full px-3 sm:w-1/2">
                            <div class="mb-5">
                                <label class="pl-2 mb-3 block text-base text-gray-700 font-semibold">
                                   Half Pay Leave
                                </label>
                                <input type="number" min="0" placeholder="No. Of Half Pay Leave"  name="' . ($sub_table == 1 ? 'teacher_wise_hl' : 'department_wise_hl') . '" id="' . ($sub_table == 1 ? 'teacher_wise_hl' : 'department_wise_hl') . '" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-gray-700  outline-none focus:border-[#6A64F1] focus:shadow-md focus:ring-2 focus:ring-blue-500""/>
                                    
                            </div>

                        </div>

                        <div class="w-full px-3 sm:w-1/2">
                            <div class="mb-5">
                                <label class=" pl-2 mb-3 block text-base text-gray-700 font-semibold">
                                   Earned Leave
                                </label>
                                <input type="number" min="0" placeholder="No. Of Earned Leave"  name="' . ($sub_table == 1 ? 'teacher_wise_ml_el' : 'department_wise_ml_el') . '" id="' . ($sub_table == 1 ? 'teacher_wise_ml_el' : 'department_wise_ml_el') . '" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-gray-700  outline-none focus:border-[#6A64F1] focus:shadow-md focus:ring-2 focus:ring-blue-500""/>
                                 

                            </div>
                        </div>
                    </div>
    
    
    ';
        }


        echo '
 </div>
                <div class=" m-4 flex justify-center ">
                    <button type="button" onclick="' . ($sub_table == 1 ? 'teachingSubmit()' : 'departmentSubmit()') . ' " id="' . ($sub_table == 1 ? 'teaching_wise_submit' : 'department_wise_submit') . '" class=" bg-blue-500 text-white px-4 py-2 rounded-xl hover:bg-blue-600 hover:translate-y-[200px] w-full  ">Assign</button>
                </div>
                
 
 ';     // IF No teacher in the department
    } else {
        echo ' <div class="mb-4"> 
        <label class="mb-3 block text-base text-gray-700 font-semibold">Teacher</label>
        <select  class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-gray-700  outline-none focus:border-[#6A64F1] focus:shadow-md">
        <option  value="" selected disabled > No Teacher Available</option>
        </select>
      </div>';
    }
}

//Non Teaching staff Form

if (isset($_POST['nyear']) && !empty($_POST['nyear']) && !empty($_POST['ntype']) && !empty($_POST['ntype']) && !empty($_POST['sub_table2'])) {

    $ntype = $_POST['ntype'];
    $year = $_POST['nyear'];
    //  $type = $_POST['type'];
    $sub_table = $_POST['sub_table2'];


    $query = "SELECT * FROM staff where Job_role='$ntype'  AND status='A' ";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        echo '
        <div class=" m-2 p-4 border-2 border-blue-800 border-opacity-10 rounded-sm">
';
        if ($sub_table == 1) {
            echo '
        <div class="mb-4">
        <label class=" pl-2 mb-3 block text-base text-gray-700 font-semibold">Non Teaching Staff:</label>
        <select name="individual_teacher" id="individual_teacher" class="focus:ring-2 focus:ring-blue-500 w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-gray-700  outline-none focus:border-[#6A64F1] focus:shadow-md ">
        ';
            echo '<option  value="" selected disabled > Select a Non Teaching Staff</option>';

            while ($row = $result->fetch_assoc()) {
                echo '<option  value="' . $row['Staff_id'] . '">' . $row['Name'] . '</option>';
            }
            echo '</select>
        </div>';
        }



        echo '<div class="-mx-3 flex flex-wrap">
                        <div class="w-full px-3 sm:w-1/2">
                            <div class="mb-5">
                                <label class="pl-2 mb-3 block text-base text-gray-700 font-semibold">
                                   Casual Leave
                                </label>
                                <input type="number" placeholder="No. Of Casual Leave" min="0" name="' . ($sub_table == 1 ? 'individual_cl' : 'all_cl') . '" id="' . ($sub_table == 1 ? 'individual_cl' : 'all_cl') . '" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-gray-700  outline-none focus:border-[#6A64F1] focus:shadow-md focus:ring-2 focus:ring-blue-500""/>
                                    
                            </div>

                        </div>

                        <div class="w-full px-3 sm:w-1/2">
                            <div class="mb-5">
                                <label class=" pl-2 mb-3 block text-base text-gray-700 font-semibold">
                                   Maternity Leave
                                </label>
                                <input type="number" placeholder="No. Of Maternity Leave" min="0" name="' . ($sub_table == 1 ? 'individual_ma' : 'all_ma') . '" id="' . ($sub_table == 1 ? 'individual_ma' : 'all_ma') . '" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-gray-700  outline-none focus:border-[#6A64F1] focus:shadow-md focus:ring-2 focus:ring-blue-500""/>
                                 

                            </div>
                        </div>
                    </div>


                    <div class="-mx-3 flex flex-wrap">
                        <div class="w-full px-3 sm:w-1/2">
                            <div class="mb-5">
                                <label class="pl-2 mb-3 block text-base text-gray-700 font-semibold">
                                   Half Pay Leave
                                </label>
                                <input type="number" placeholder="No. Of Half Pay Leave"  min="0" name="' . ($sub_table == 1 ? 'individual_hl' : 'all_hl') . '" id="' . ($sub_table == 1 ? 'individual_hl' : 'all_hl') . '" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-gray-700  outline-none focus:border-[#6A64F1] focus:shadow-md focus:ring-2 focus:ring-blue-500""/>
                                    
                            </div>

                        </div>

                        <div class="w-full px-3 sm:w-1/2">
                            <div class="mb-5">
                                <label class=" pl-2 mb-3 block text-base text-gray-700 font-semibold">
                                   Medical Leave
                                </label>
                                <input type="number" min="0" placeholder="No. Of Medical Leave"  name="' . ($sub_table == 1 ? 'individual_ml' : 'all_ml') . '" id="' . ($sub_table == 1 ? 'individual_ml' : 'all_ml') . '" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-gray-700  outline-none focus:border-[#6A64F1] focus:shadow-md focus:ring-2 focus:ring-blue-500""/>
                                 

                            </div>
                        </div>
                    </div>
 
 
 
 ';

        if ($ntype === 'NO') {
            echo '
                       <div class="-mx-3 flex flex-wrap">
                        <div class="w-full px-3 sm:w-1/2">
                            <div class="mb-5">
                                <label class="pl-2 mb-3 block text-base text-gray-700 font-semibold">
                                   Earned Leave
                                </label>
                                <input type="number" placeholder="No. Of Earned Leave"  min="0" name="' . ($sub_table == 1 ? 'individual_el' : 'all_el') . '" id="' . ($sub_table == 1 ? 'individual_el' : 'all_el') . '" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-gray-700  outline-none focus:border-[#6A64F1] focus:shadow-md focus:ring-2 focus:ring-blue-500""/>
                                    
                            </div>

                        </div>

                       
                    </div>
    
    
    ';
        }


        echo '
 </div>

   <div class=" m-4 flex justify-center ">
                    <button type="button" onclick="' . ($sub_table == 1 ? 'IndivSubmit()' : 'allSubmit()') . '" id="' . ($sub_table == 1 ? 'individual_submit' : 'all_submit') . '" class=" bg-blue-500 text-white px-4 py-2 rounded-xl hover:bg-blue-600 hover:translate-y-[200px] w-full  ">Assign</button>
                </div>
                
 
 ';
    } else {
        echo ' <div class="mb-4"> 
        <label class="mb-3 block text-base text-gray-700 font-semibold">Teacher</label>
        <select  class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-gray-700  outline-none focus:border-[#6A64F1] focus:shadow-md">
        <option  value="" selected disabled > No Non-Teaching staff Available</option>
        </select>
      </div>';
    }
}

?>
<script>
    function teachingSubmit() {
        //alert("teching_wiseyy");
        var t_type = document.getElementById('teaching_type').value;
        var teaching_wise_t = document.getElementById('teacher_wise_teacher').value;
        var teaching_wise_cl = document.getElementById('teacher_wise_cl').value;
        var teaching_wise_ma = document.getElementById('teacher_wise_ma').value;
        var teaching_wise_hl = document.getElementById('teacher_wise_hl').value;
        var teaching_wise_ml_el = document.getElementById('teacher_wise_ml_el').value;
        var a_type = document.getElementById('teaching_year').value;


        if (teaching_wise_t === "" || teaching_wise_cl === "" || teaching_wise_ma === "" || teaching_wise_hl === "" || teaching_wise_ml_el === "") {
            alert("Please Assign All the Leaves !!");

        } else {
            // console.log({
            //     year: a_type,
            //     teaching_t: teaching_wise_t,
            //     teaching_cl: teaching_wise_cl,
            //     teaching_ma: teaching_wise_ma,
            //     teaching_hl: teaching_wise_hl,
            //     teaching_el: teaching_wise_ml_el // if applicable
            // });


            $.ajax({
                url: "action.php",
                type: "POST",
                dataType: 'json', // Expect a JSON response
                data: {
                    type: t_type,
                    year: a_type,
                    teaching_t: teaching_wise_t,
                    teaching_cl: teaching_wise_cl,
                    teaching_ma: teaching_wise_ma,
                    teaching_hl: teaching_wise_hl,
                    teaching_ml_el: teaching_wise_ml_el
                },
                success: function(response) {
                    if (response.status === 'success') {
                        alert(response.message); // Show success message
                        //loadContent('dl');
                    } else {
                        alert(response.message); // Show error message if any
                        // loadContent('dl');
                    }
                },
                error: function(xhr, status, error) {
                    //console.error("AJAX Error: ", status, error);
                    //console.log("Response Text:", xhr.responseText);
                    alert("AJAX Error: " + status + " " + error + "\nResponse Text: " + xhr.responseText);
                }

            });

        }



    }


    function departmentSubmit() {
       // alert("DEPARTMENT_wise");
        var t_type = document.getElementById('teaching_type').value;
        var department_wise_cl = document.getElementById('department_wise_cl').value;
        var department_wise_ma = document.getElementById('department_wise_ma').value;
        var department_wise_hl = document.getElementById('department_wise_hl').value;
        var department_wise_ml_el = document.getElementById('department_wise_ml_el').value;
        var a_type = document.getElementById('teaching_year').value;
        var dept = document.getElementById('teaching_department').value;

        if (department_wise_cl === "" || department_wise_ma === "" || department_wise_hl === "" || department_wise_ml_el === "" || t_type === "" || a_type === "" || dept === "") {
            alert("Please Assign All the Leaves !!");

        } else {
            // console.log({
            //     year: a_type,
            //     teaching_t: teaching_wise_t,
            //     teaching_cl: teaching_wise_cl,
            //     teaching_ma: teaching_wise_ma,
            //     teaching_hl: teaching_wise_hl,
            //     teaching_el: teaching_wise_ml_el // if applicable
            // });


            $.ajax({
                url: "action.php",
                type: "POST",
                dataType: 'json', // Expect a JSON response
                data: {
                    type: t_type,
                    year: a_type,
                    department: dept,
                    department_wise_cl: department_wise_cl,
                    department_wise_ma: department_wise_ma,
                    department_wise_hl: department_wise_hl,
                    department_wise_ml_el: department_wise_ml_el
                },
                success: function(response) {
                    if (response.status === 'success') {
                        alert(response.message); // Show success message
                        //loadContent('dl');
                    } else {
                        alert(response.message); // Show error message if any
                        // loadContent('dl');
                    }
                },
                error: function(xhr, status, error) {
                    //console.error("AJAX Error: ", status, error);
                    //console.log("Response Text:", xhr.responseText);
                    alert("AJAX Error: " + status + " " + error + "\nResponse Text: " + xhr.responseText);
                }

            });

        }



    }


    function IndivSubmit() {
        //alert("Individual");
        var nt_type = document.getElementById('nt_type').value;
        var individual_teacher = document.getElementById('individual_teacher').value;
        var individual_cl = document.getElementById('individual_cl').value;
        var individual_ma = document.getElementById('individual_ma').value;
        var individual_hl = document.getElementById('individual_hl').value;
        var individual_ml = document.getElementById('individual_ml').value;
        var individual_el = "ok123";
        var nt_year = document.getElementById('nt_year').value;

        if (nt_type == 'NO') {
            individual_el = document.getElementById('individual_el').value;
        }

        if (individual_teacher === "" || individual_cl === "" || individual_ma === "" || individual_hl === "" || individual_ml === "" || individual_el === "" || nt_year === "") {
            alert("Please Assign All the Leaves !!");

        } else {
            // console.log({
            //     year: a_type,
            //     teaching_t: teaching_wise_t,
            //     teaching_cl: teaching_wise_cl,
            //     teaching_ma: teaching_wise_ma,
            //     teaching_hl: teaching_wise_hl,
            //     teaching_el: teaching_wise_ml_el // if applicable
            // });

            $.ajax({
                url: "action2.php",
                type: "POST",
                dataType: 'json', // Expect a JSON response
                data: {
                    teacherId: individual_teacher,
                    year: nt_year,
                    indiv_cl: individual_cl,
                    indiv_ma: individual_ma,
                    indiv_hl: individual_hl,
                    indiv_el: individual_el,
                    indiv_ml: individual_ml
                },
                success: function(response) {
                    if (response.status === 'success') {
                        alert(response.message); // Show success message
                        //loadContent('dl');
                    } else {
                        alert(response.message); // Show error message if any
                        // loadContent('dl');
                    }
                },
                error: function(xhr, status, error) {
                    //console.error("AJAX Error: ", status, error);
                    //console.log("Response Text:", xhr.responseText);
                    alert("AJAX Error: " + status + " " + error + "\nResponse Text: " + xhr.responseText);
                }

            });

        }



    }

    function allSubmit() {
       // alert("All");
        var nt_type = document.getElementById('nt_type').value;
        var all_cl = document.getElementById('all_cl').value;
        var all_ma = document.getElementById('all_ma').value;
        var all_hl = document.getElementById('all_hl').value;
        var all_ml = document.getElementById('all_ml').value;
        var all_el = "ok123";
        var nt_year = document.getElementById('nt_year').value;

        if (nt_type == 'NO') {
            all_el = document.getElementById('all_el').value;
        }

        if (all_cl === "" || all_ma === "" || all_hl === "" || all_ml === "" || all_el === "" || nt_year === "") {
            alert("Please Assign All the Leaves !!");

        } else {
            // console.log({
            //     year: a_type,
            //     teaching_t: teaching_wise_t,
            //     teaching_cl: teaching_wise_cl,
            //     teaching_ma: teaching_wise_ma,
            //     teaching_hl: teaching_wise_hl,
            //     teaching_el: teaching_wise_ml_el // if applicable
            // });

            $.ajax({
                url: "action2.php",
                type: "POST",
                dataType: 'json', // Expect a JSON response
                data: {
                    type: nt_type,
                    year: nt_year,
                    all_cl: all_cl,
                    all_ma: all_ma,
                    all_hl: all_hl,
                    all_el: all_el,
                    all_ml: all_ml
                },
                success: function(response) {
                    if (response.status === 'success') {
                        alert(response.message); // Show success message
                        //loadContent('dl');
                    } else {
                        alert(response.message); // Show error message if any
                        // loadContent('dl');
                    }
                },
                error: function(xhr, status, error) {
                    //console.error("AJAX Error: ", status, error);
                    //console.log("Response Text:", xhr.responseText);
                    alert("AJAX Error: " + status + " " + error + "\nResponse Text: " + xhr.responseText);
                }

            });

        }




    }
</script>