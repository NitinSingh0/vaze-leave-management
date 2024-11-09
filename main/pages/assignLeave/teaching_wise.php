
<?php
// Include the database connection file
include('../../../config/connect.php');

if (isset($_POST['year'])&& !empty($_POST['year'])&& !empty($_POST['dept'])&& !empty($_POST['type']) && !empty($_POST['sub_table'])) {
    
$dept=$_POST['dept'];
$year= $_POST['year'];
$type=$_POST['type'];
    $sub_table= $_POST['sub_table'];
    $query = "SELECT * FROM staff where D_id='$dept'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        echo '
        <div class=" m-2 p-4 border-2 border-blue-800 border-opacity-10 rounded-sm">
';
if($sub_table == 1){
echo'
        <div class="mb-4">
        <label class=" pl-2 mb-3 block text-base text-gray-700 font-semibold">Teacher</label>
        <select name="teacher_wise_teacher" id="teacher_wise_teacher" class="focus:ring-2 focus:ring-blue-500 w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-gray-700  outline-none focus:border-[#6A64F1] focus:shadow-md ">
        '
        ;
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

if($type==='D'){
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
                                <input type="number" min="0" placeholder="No. Of Medical Leave"  name="' . ($sub_table == 1 ? 'teacher_wise_ml' : 'department_wise_ml') . '" id="' . ($sub_table == 1 ? 'teacher_wise_ml' : 'department_wise_ml') . '" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-gray-700  outline-none focus:border-[#6A64F1] focus:shadow-md focus:ring-2 focus:ring-blue-500""/>
                                 

                            </div>
                        </div>
                    </div>
    
    
    ';

}
elseif($type==='J'){

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
                                <input type="number" min="0" placeholder="No. Of Earned Leave"  name="' . ($sub_table == 1 ? 'teacher_wise_el' : 'department_wise_el') . '" id="' . ($sub_table == 1 ? 'teacher_wise_el' : 'department_wise_el') . '" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-gray-700  outline-none focus:border-[#6A64F1] focus:shadow-md focus:ring-2 focus:ring-blue-500""/>
                                 

                            </div>
                        </div>
                    </div>
    
    
    ';

}


echo '
 </div>

   <div class=" m-4 flex justify-center ">
                    <button type="button" id="' . ($sub_table == 1 ? 'teaching_wise_submit' : 'department_wise_submit') . '" class=" bg-blue-500 text-white px-4 py-2 rounded-xl hover:bg-blue-600 hover:translate-y-[200px] w-full  ">Assign</button>
                </div>
                
 
 ';

    } else {
        echo ' <div class="mb-4"> 
        <label class="mb-3 block text-base text-gray-700 font-semibold">Teacher</label>
        <select  class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-gray-700  outline-none focus:border-[#6A64F1] focus:shadow-md">
        <option  value="" selected disabled > No Teacher Available</option>
        </select>
      </div>';
    }
}



if (isset($_POST['nyear']) && !empty($_POST['nyear']) && !empty($_POST['ndept']) && !empty($_POST['ndept']) && !empty($_POST['sub_table2'])) {

    $dept = $_POST['ndept'];
    $year = $_POST['nyear'];
  //  $type = $_POST['type'];
    $sub_table = $_POST['sub_table2'];

    $query1 = "SELECT College FROM department where D_id='$dept'";
    $result1 = $conn->query($query1);
    $row1=$result1->fetch_assoc();
    $type = $row1['College'];

    $query = "SELECT * FROM staff where D_id='$dept'";
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

        if ($type === 'O') {
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
                    <button type="button" id="' . ($sub_table == 1 ? 'individual_submit' : 'all_submit') . '" class=" bg-blue-500 text-white px-4 py-2 rounded-xl hover:bg-blue-600 hover:translate-y-[200px] w-full  ">Assign</button>
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
