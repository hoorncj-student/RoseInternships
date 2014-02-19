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
	# Return the salary types for a given position
	case 1:
	{
		if($_GET['positionid'] and strlen($_GET['positionid']) > 0){
			if($_GET['positionid'] == 'other'){
				echo 'should not get here';
			} else {
				$postype = mysqli_query($conn, "SELECT type
												FROM positions
												WHERE position_id = ". mysql_real_escape_string($_GET['positionid']));
				$postypestring = mysqli_fetch_array($postype)[0];
				if($postypestring != 'full time'){
			      echo '<option value="hourly">Hourly</option>';
			    } else {
			      echo '<option value="annual">Annual</option>
			          <option value="monthly">Monthly</option>';
			    }
			}
		}
	}
}
?>