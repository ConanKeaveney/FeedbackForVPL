<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * The gradebook grader report
 *
 * @package   gradereport_grader
 * @copyright 2007 Moodle Pty Ltd (http://moodle.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once('../graphing_functions.php');
require_once('../../../config.php');
require_once($CFG->libdir.'/gradelib.php');
require_once($CFG->dirroot.'/user/renderer.php');
require_once($CFG->dirroot.'/grade/lib.php');
require_once($CFG->dirroot.'/grade/report/grader/lib.php');
require_once($CFG->dirroot.'/mod/vpl/vpl.class.php');
require_once($CFG->dirroot.'/mod/vpl/vpl_submission.class.php');

$courseid      = required_param('id', PARAM_INT);        // course id
$page          = optional_param('page', 0, PARAM_INT);   // active page
$edit          = optional_param('edit', -1, PARAM_BOOL); // sticky editting mode

$sortitemid    = optional_param('sortitemid', 0, PARAM_ALPHANUM); // sort by which grade item
$action        = optional_param('action', 0, PARAM_ALPHAEXT);
$move          = optional_param('move', 0, PARAM_INT);
$type          = optional_param('type', 0, PARAM_ALPHA);
$target        = optional_param('target', 0, PARAM_ALPHANUM);
$toggle        = optional_param('toggle', null, PARAM_INT);
$toggle_type   = optional_param('toggle_type', 0, PARAM_ALPHANUM);

$graderreportsifirst  = optional_param('sifirst', null, PARAM_NOTAGS);
$graderreportsilast   = optional_param('silast', null, PARAM_NOTAGS);

function email_grader(){

//******************Student Contribution*************************//
$tempid = $subinstance->userid;
$ty = gettype($tempid); 
$dbquery = $db->prepare("SELECT email FROM mdl_user WHERE id = $tempid");
$dbquery->execute();
$result = $dbquery->fetchAll(PDO::FETCH_ASSOC);

/*

//grader email
//todo: select lab avg and pass to email
$courseid = required_param('id', PARAM_INT);

$dbquery = $db->prepare("SELECT AVG(g.finalgrade) as finalgrade,g.itemid as id, e.courseid as cid, e.itemname as name FROM mdl_grade_grades g INNER JOIN mdl_grade_items e  on g.itemid =e.id WHERE e.courseid = 3 AND g.finalgrade<= g.rawgrademax AND g.itemid!=1 AND e.itemname IS NOT NULL GROUP BY e.id");
$dbquery->bindParam(1,$courseid);
$dbquery -> execute();
$row = $dbquery -> fetchAll(PDO::FETCH_ASSOC);
print_r($row);

foreach($row as $r){
	echo $r['name'];
}
#echo $courseid;
        foreach ($result as $key => $item) {
            $email = $item['email'];
            #echo '<input type="radio" name="email" value="' . $email . '">' . $email . '</input>';
	    //get all vpl class methods
            $arr = get_class_methods ( $vpl );
	    $arr2 = $vpl->get_graders();
            #print_r($arr);
            $array = json_decode(json_encode($arr2), True);
            foreach($array as $arr){
               # echo $arr['email'];

            error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED ^ E_STRICT);

            set_include_path("." . PATH_SEPARATOR . ($UserDir = dirname($_SERVER['DOCUMENT_ROOT'])) . "/pear/php" . PATH_SEPARATOR . get_include_path());
            require_once "Mail.php";

            $host = "mail.cs.nuim.ie";
            $username = "u180350";
            $password = "";
            $port = "25";
            $to = $arr['email'];
            $email_from = "conan.keaveney.2016@mumail.ie";
            $email_subject = "Test: ";
            $email_body = "Hello, this is the grader report for ";
            $email_body .= $vpl->get_course_module()->name;
            $email_body .= $submission->get_grade_comments();
            $email_address = "conan.keaveney.2016@mumail.ie";

            $headers = array('From' => $email_from, 'To' => $to, 'Subject' => $email_subject, 'Reply-To' => $email_address);
            $smtp = Mail::factory('smtp', array('host' => $host, 'port' => $port, 'auth' => false, 'username' => $username, 'password' => $password));
            #$mail = $smtp->send($to, $headers, $email_body);
            if (PEAR::isError($mail)) {
                echo ("<p>" . $mail->getMessage() . "</p>");
            } else {
                echo ("<p>Message successfully sent!</p>");
            }
	    }
        }

        //send email
        //******************Student Contribution*************************/

  
}


// The report object is recreated each time, save search information to SESSION object for future use.
if (isset($graderreportsifirst)) {
    $SESSION->gradereport['filterfirstname'] = $graderreportsifirst;
}
if (isset($graderreportsilast)) {
    $SESSION->gradereport['filtersurname'] = $graderreportsilast;
}

$PAGE->set_url(new moodle_url('/grade/report/grader/index.php', array('id'=>$courseid)));
$PAGE->requires->yui_module('moodle-gradereport_grader-gradereporttable', 'Y.M.gradereport_grader.init', null, null, true);

// basic access checks
if (!$course = $DB->get_record('course', array('id' => $courseid))) {
    print_error('invalidcourseid');
}
require_login($course);
$context = context_course::instance($course->id);

require_capability('gradereport/grader:view', $context);
require_capability('moodle/grade:viewall', $context);

// return tracking object
$gpr = new grade_plugin_return(array('type'=>'report', 'plugin'=>'grader', 'courseid'=>$courseid, 'page'=>$page));

// last selected report session tracking
if (!isset($USER->grade_last_report)) {
    $USER->grade_last_report = array();
}
$USER->grade_last_report[$course->id] = 'grader';

// Build editing on/off buttons

if (!isset($USER->gradeediting)) {
    $USER->gradeediting = array();
}

if (has_capability('moodle/grade:edit', $context)) {
    if (!isset($USER->gradeediting[$course->id])) {
        $USER->gradeediting[$course->id] = 0;
    }

    if (($edit == 1) and confirm_sesskey()) {
        $USER->gradeediting[$course->id] = 1;
    } else if (($edit == 0) and confirm_sesskey()) {
        $USER->gradeediting[$course->id] = 0;
    }

    // page params for the turn editting on
    $options = $gpr->get_options();
    $options['sesskey'] = sesskey();

    if ($USER->gradeediting[$course->id]) {
        $options['edit'] = 0;
        $string = get_string('turneditingoff');
    } else {
        $options['edit'] = 1;
        $string = get_string('turneditingon');
    }

    $buttons = new single_button(new moodle_url('index.php', $options), $string, 'get');
} else {
    $USER->gradeediting[$course->id] = 0;
    $buttons = '';
}

$gradeserror = array();

// Handle toggle change request
if (!is_null($toggle) && !empty($toggle_type)) {
    set_user_preferences(array('grade_report_show'.$toggle_type => $toggle));
}

// Perform actions
if (!empty($target) && !empty($action) && confirm_sesskey()) {
    grade_report_grader::do_process_action($target, $action, $courseid);
}

$reportname = get_string('pluginname', 'gradereport_grader');

// Do this check just before printing the grade header (and only do it once).
grade_regrade_final_grades_if_required($course);

// Print header
print_grade_page_head($COURSE->id, 'report', 'grader', $reportname, false, $buttons);

//Initialise the grader report object that produces the table
//the class grade_report_grader_ajax was removed as part of MDL-21562
$report = new grade_report_grader($courseid, $gpr, $context, $page, $sortitemid);
$numusers = $report->get_numusers(true, true);

// make sure separate group does not prevent view
if ($report->currentgroup == -2) {
    echo $OUTPUT->heading(get_string("notingroup"));
    echo $OUTPUT->footer();
    exit;
}

// processing posted grades & feedback here
if ($data = data_submitted() and confirm_sesskey() and has_capability('moodle/grade:edit', $context)) {
    $warnings = $report->process_data($data);
} else {
    $warnings = array();
}

// final grades MUST be loaded after the processing
$report->load_users();
$report->load_final_grades();
echo $report->group_selector;

// User search
$url = new moodle_url('/grade/report/grader/index.php', array('id' => $course->id));
$firstinitial = isset($SESSION->gradereport['filterfirstname']) ? $SESSION->gradereport['filterfirstname'] : '';
$lastinitial  = isset($SESSION->gradereport['filtersurname']) ? $SESSION->gradereport['filtersurname'] : '';
$totalusers = $report->get_numusers(true, false);
$renderer = $PAGE->get_renderer('core_user');
echo $renderer->user_search($url, $firstinitial, $lastinitial, $numusers, $totalusers, $report->currentgroupname);

//show warnings if any
foreach ($warnings as $warning) {
    echo $OUTPUT->notification($warning);
}

$studentsperpage = $report->get_students_per_page();
// Don't use paging if studentsperpage is empty or 0 at course AND site levels
if (!empty($studentsperpage)) {
    echo $OUTPUT->paging_bar($numusers, $report->page, $studentsperpage, $report->pbarurl);
}

$displayaverages = true;
if ($numusers == 0) {
    $displayaverages = false;
}

$reporthtml = $report->get_grade_table($displayaverages);

// print submit button
if ($USER->gradeediting[$course->id] && ($report->get_pref('showquickfeedback') || $report->get_pref('quickgrading'))) {
    echo '<form action="index.php" enctype="application/x-www-form-urlencoded" method="post" id="gradereport_grader">'; // Enforce compatibility with our max_input_vars hack.
    echo '<div>';
    echo '<input type="hidden" value="'.s($courseid).'" name="id" />';
    echo '<input type="hidden" value="'.sesskey().'" name="sesskey" />';
    echo '<input type="hidden" value="'.time().'" name="timepageload" />';
    echo '<input type="hidden" value="grader" name="report"/>';
    echo '<input type="hidden" value="'.$page.'" name="page"/>';
    echo $reporthtml;
    echo '<div class="submit"><input type="submit" id="gradersubmit" class="btn btn-primary"
        value="'.s(get_string('savechanges')).'" /></div>';
    echo '</div></form>';
} else {
    echo $reporthtml;
}

// prints paging bar at bottom for large pages
if (!empty($studentsperpage) && $studentsperpage >= 20) {
    echo $OUTPUT->paging_bar($numusers, $report->page, $studentsperpage, $report->pbarurl);
}

$event = \gradereport_grader\event\grade_report_viewed::create(
    array(
        'context' => $context,
        'courseid' => $courseid,
    )
);
$event->trigger();

?>

<!--PROJECT SECTION START-->

<?php if($options['edit'] == 1){ 

$graph_array = create_user_graph($courseid);
//$graph_pie = create_assignment_pie($courseid);
$graph_pie = create_user_graph_grade_bands($courseid);

  echo'
<!--CHARTS HTML SECTION END
<div id="chart_title" style="height: 25px;"><h4>User ID by overall course percentage</h4></div>
<div id="myfirstchart" style="height: 250px;"></div>
<div class="option_box">
    <select id="graph_select">
        <option value="user">Overall User Avg</option>
        <option value="assignment">Overall Assignment Avg</option>
        <option value="type">By Assignment Type</option>
    </select><br>
    <input type="radio" name="group1" checked>Results<br>
    <input id="pass_fail_radio" type="radio" name="group1">Pass/Fail Rate<br><br>
    <input type="button" id="graph_btn" value="Load Percentage Graph">
    <input type="button" id="num_graph_btn" value="Load Numerical Graph">
    <input type="button" id="grade_band_btn" value="Load Grade Bands">
    -->
    <form action="welcome.php" method="post">
    E-mail: <input type="text" id = "email_form" name="email"><br>
    </form>
    <input type="button" id="grade_email_btn" value="Send Grader Report">
    
 
</div> <br><br>
<div id="mysecondchart" style="height: 250px;"></div>
<input type="hidden" value='.$courseid.' id="html_course_value">
<!--CHARTS HTML SECTION END-->';

}
 ?>


 <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
 <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js" type="text/javascript"></script>
    <!--Theme-->
    <!--Wijmo Widgets JavaScript-->
  <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
 <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

 <!--PROJECT SCRIPTS SECTION START-->

 <script>

 //For displaying bar graphs
 function display_bar_graph(data_array){

Morris.Bar({
 
  element: 'myfirstchart',
  data: data_array,
  xkey: 'id',
  ykeys: ['finalgrade'],
  labels: ['finalgrade'], 
  parseTime:false,
  hideHover:true
});
}
//Colours for the pass/fail donuts
var colors_array= ["#00CC00", "#E50000"];

//for displaying donut graphs
function display_donut_graph(json_array){

Morris.Donut({
 
  element: 'myfirstchart',

  data: json_array,
 
  parseTime:false,

  colors:colors_array
});
}
//page load graph data
var ar = <?php echo json_encode($graph_array) ?>;
  var ar2 = <?php echo json_encode($graph_pie) ?>;
display_bar_graph(ar);
 </script>
 <script>
 //Load the gradeband piechart when the button is clicked
  $('#grade_band_btn').on('click', function (e) {
   $("#myfirstchart").html("");
   $('#chart_title').html("<h4>Percentage of users in each grade band</h4>");
   Morris.Donut({
    
       element: 'myfirstchart', 
       data: ar2,
      
       parseTime:false,
   });
 });
  //Function to load the graph titles
  function get_title(is_numerical){
      var type = $('#graph_select').val();
      if($('#pass_fail_radio').is(":checked")){
        var pass_fail = 1;
      }
      else {var pass_fail = 0;}

      if((type=='user')&&(is_numerical==0)&&(pass_fail==0)){
        $('#chart_title').html('<h4>Overall course percentage by user ID</h4>');
      }
      else if((type=='user')&&(is_numerical==1)&&(pass_fail==0)){
        $('#chart_title').html('<h4>Total no. of marks by user ID</h4>');
      }
      else if((type=='user')&&(is_numerical==0)&&(pass_fail==1)){
        $('#chart_title').html('<h4>Students total pass/fail rate in all labs/assignments</h4>');
      }
      else if((type=='user')&&(is_numerical==1)&&(pass_fail==1)){
        $('#chart_title').html('<h4>No. of pass/fails in all labs/assignments</h4>');
      }
      else if((type=='assignment')&&(is_numerical==0)&&(pass_fail==0)){
        $('#chart_title').html('<h4>Average percentage score by assignment</h4>');
      }
      else if((type=='assignment')&&(is_numerical==1)&&(pass_fail==0)){
        $('#chart_title').html('<h4>Average no. marks scored by assignment</h4>');
      }
      else if((type=='assignment')&&(is_numerical==0)&&(pass_fail==1)){
        $('#chart_title').html('<h4>Pass rate by assignment</h4>');
      }
      else if((type=='assignment')&&(is_numerical==1)&&(pass_fail==1)){
        $('#chart_title').html('<h4>No. of passes by assignment</h4>');
      }
      else if((type=='type')&&(is_numerical==0)&&(pass_fail==0)){
        $('#chart_title').html('<h4>Average percentage score by assignment type</h4>');
      }
      else if((type=='type')&&(is_numerical==1)&&(pass_fail==0)){
        $('#chart_title').html('<h4>Average no. of marks by assignment type</h4>');
      }
      else if((type=='type')&&(is_numerical==0)&&(pass_fail==1)){
        $('#chart_title').html('<h4>Pass rate by assignment type</h4>');
      }
      else if((type=='type')&&(is_numerical==1)&&(pass_fail==1)){
        $('#chart_title').html('<h4>No. of passes by assignment type</h4>');
      }

  }
//  </script>

 <script>
 //When the numerical graph buton is clicked
 $('#num_graph_btn').on('click', function (e) {
	console.log('hellooo');
      var is_numerical = 1;         
      load_graph(is_numerical);
      get_title(is_numerical);
  });
 //When the percentage graph button is clicked
 $('#graph_btn').on('click', function (e) {
    var is_numerical = 0;         
    load_graph(is_numerical);
    get_title(is_numerical);
});
 //When the email button is clicked
 $('#grade_email_btn').on('click', function (e) {
  
    
    var input = document.getElementById('email_form').value
    emfunc(input);
    console.log('function ran');
	
});

function emfunc(input){
    //console.log('emfunc');
 var userid = <?php echo json_encode($ty) ?>;
 var type = $('#graph_select').val();
      var courseid = $('#html_course_value').val();
      console.log('userid: ' + userid);

      //Checking to see if pass/fail radio is selected
      if($('#pass_fail_radio').is(":checked")){
        var pass_fail = 1;
      }
      else {var pass_fail = 0;}
postData =  ([{name: "userid", value: type},
                    {name: "courseid", value: courseid},
                    {name: "email", value: input},
                    {name: "pass_fail", value: pass_fail}]);
    $.ajax({
            type: "POST",
           url: '../grader_email.php',
           data: postData,
            success: function(data){
	     //console.log('data');
             console.log(data);
           }
         });
}

 //Send the data and load the graph
 function load_graph(is_numerical){
 var type = $('#graph_select').val();
      var courseid = $('#html_course_value').val();

      //Checking to see if pass/fail radio is selected
      if($('#pass_fail_radio').is(":checked")){
        var pass_fail = 1;
      }
      else {var pass_fail = 0;}

      //Grouping the data to be sent in the POST
      postData =  ([{name: "graph_type", value: type},
                    {name: "courseid", value: courseid},
                    {name: "is_numerical", value: is_numerical},
                    {name: "pass_fail", value: pass_fail}]);

          //Ajax Function
      $.ajax({
         type: "POST",
         url: '../change_graph.php',
         data: postData,
         success: function(data) {
          //Empty the Graph Div
          $("#myfirstchart").html("");
          //Parse the returned JSON array
          var json_array = JSON.parse(data);
          //Donut graph for pass/fail user graphs
            if((pass_fail == 1)&&(type=='user')){
               display_donut_graph(json_array); 
            }
            // Otherwise Load a bar graph
            else{
               display_bar_graph(json_array);    
            }
         }     
      });
}
 </script>
  <!--PROJECT SCRIPTS SECTION END-->
 <!--PROJECT SECTION END-->


<?php echo $OUTPUT->footer(); ?>


