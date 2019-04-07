<?php
$res = "success";

require_once('../../config.php');
require_once('DBconnect.php');

require_once('../../mod/vpl/vpl.class.php');//not able to access vpl class methods
require_once('../../mod/vpl/vpl_submission.class.php');

$courseid = $_POST['courseid'];
$email = $_POST['email'];
$userid = $USER->id;
//******************Student Contribution*************************/
$dbquery = $db->prepare("SELECT AVG(g.finalgrade) as finalgrade,g.itemid as id, e.courseid as cid, e.itemname as name FROM mdl_grade_grades g INNER JOIN mdl_grade_items e  on g.itemid =e.id WHERE e.courseid = 3 AND g.finalgrade<= g.rawgrademax AND g.itemid!=1 AND e.itemname IS NOT NULL GROUP BY e.id");
$dbquery->bindParam(1,$courseid);
$dbquery -> execute();
$row = $dbquery -> fetchAll(PDO::FETCH_ASSOC);

require_once "Mail.php";
	    $email_body = "Hello, this is the average grade for each lab ";
	    $email_body .= "\n";
            foreach($row as $r){
		    
		    $email_body .= $r['name'];
		    $email_body .= ": ";
		    $email_body .= floor($r['finalgrade']);
	            $email_body .= "%";
		    $email_body .= "\n";
		    
		
	    }


            $host = "mail.cs.nuim.ie";
            $username = "u180350";
            $password = "";
            $port = "25";
            $to = $email;//$USER->email;
            $email_from = "conan.keaveney.2016@mumail.ie";
            $email_subject = "Test: ";
            
            $email_address = "conan.keaveney.2016@mumail.ie";

            $headers = array('From' => $email_from, 'To' => $to, 'Subject' => $email_subject, 'Reply-To' => $email_address);
            $smtp = Mail::factory('smtp', array('host' => $host, 'port' => $port, 'auth' => false, 'username' => $username, 'password' => $password));
            $mail = $smtp->send($to, $headers, $email_body);
            if (PEAR::isError($mail)) {
                echo ("<p>" . $mail->getMessage() . "</p>");
            } else {
                echo ("<p>Message successfully sent!</p>");
            }
	    



//echo json_encode($userid);

?>
