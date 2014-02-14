<?php
include 'dbconnection.php';

switch($_GET['function_to_call'])
{
	# Return the positions for a given company as options in a select
	case 0:
	{
		if($_GET['companyid'] and strlen($_GET['companyid']) > 0){
			if($_GET['companyid'] == 'other'){
				echo '<option value="other">Other</option>';
			} else {
				$positions = mysqli_query($conn, "SELECT position_id, title ".
                									"FROM positions ".
                									"WHERE company_id = '". mysql_real_escape_string($_GET['companyid']) . "'");
				while ($pos = mysqli_fetch_array($positions)) {
              		echo '<option value="' . htmlspecialchars($pos[0]) . '">' . htmlspecialchars($pos[1]) . '</option>';
           		}
           		echo '<option value="other">Other</option>';
			}
		}
	}
}
?>