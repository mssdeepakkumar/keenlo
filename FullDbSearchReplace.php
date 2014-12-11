<?php

/*

    DATABASE FIND AND REPLACE

    WARNING:    YOU CAN DO SERIOUS DAMAGE WITH THIS SCRIPT
    WARNING:    USE AT YOUR OWN RISK
    WARNING:    DON'T CRY WHEN YOU MESS UP YOUR DATABASE!
    WARNING:    MAKE A FULL BACKUP OF YOUR DB FIRST


    usage:  this script will try to perform a search and replace
            on all the tables and all the fields in a database
            if your db is huge, the script may time out, but
            i've never had that problem, so good luck.

            1 - upload this file and form.html to your webserver
            2 - go to yourdomain.com/path/to/file/full-db-search-and-replace/index.php
            3 - enter the necessary details
            4 - double check that you've entered everything correctly
            5 - triple check
            6 - say a prayer
            7 - hit submit
            8 - rinse and repeat


    author:     irms
    website:    http://irmsgeekwork.com



*/


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- TemplateBeginEditable name="doctitle" -->
<title>Full Database Search & Replace</title>
<!-- TemplateEndEditable -->
<!-- TemplateBeginEditable name="head" -->
<!-- TemplateEndEditable -->
<style type="text/css">
<!--
body {
	font: 100% Verdana, Arial, Helvetica, sans-serif;
	background: #666666;
	margin: 0; /* it's good practice to zero the margin and padding of the body element to account for differing browser defaults */
	padding: 0;
	text-align: center; /* this centers the container in IE 5* browsers. The text is then set to the left aligned default in the #container selector */
	color: #000000;
}
.oneColElsCtr #container {
	width: 46em;
	background: #FFFFFF;
	margin: 0 auto; /* the auto margins (in conjunction with a width) center the page */
	border: 1px solid #000000;
	text-align: left; /* this overrides the text-align: center on the body element. */
}
.oneColElsCtr #mainContent {
	padding: 0 20px; /* remember that padding is the space inside the div box and margin is the space outside the div box */
}

/* form styles */
form { font-size:160%; }
label {display:block; float:left; clear:both; width:300px; font-weight:bold; }
input { float:left; margin-left:20px; margin-top:10px; padding: 10px; color:#aaa; }
form p {line-height:200%; overflow:auto; }
#submit { margin-left:320px; color:#550000; font-weight: bold;}

.checkbox { width: 3em; height:3em; border:2px dotted #00f; padding:1em; }


-->
</style></head>

<body class="oneColElsCtr">

<div id="container">
  <div id="mainContent">




<?php

if(@$_POST['submitted']) {



    $dbname = trim($_POST['dbname']);
    $dbhost = trim($_POST['dbhost']);
    $dbpass = trim($_POST['dbpass']);
    $dbuser = trim($_POST['dbuser']);

    $old_str = $_POST['old_str'];
    $new_str = $_POST['new_str'];



    $run_forever = @$_POST['dont_timeout'];
    $case_sensitive = @$_POST['case_sensitive'];

    if($run_forever) {

        // no timeout
        set_time_limit(0);

    }


    // connect to mysql
    $con = mysql_connect($dbhost, $dbuser, $dbpass) or die('no connection:'  . mysql_error());
    $db = mysql_select_db($dbname) or die ('cant select db: ' . mysql_error());


    $num_changed = $num_changed_ci = $total_changed = 0;

    // retreive each table
    $sql = "SHOW TABLES FROM `$dbname`";
    $result = mysql_query($sql) or  die ('could not get tables: ' . mysql_error());

    // reteive each column in each table.
    while ($tbl= mysql_fetch_row($result)) {

        echo "\nTable: {$tbl[0]} <br />";

        $sql = "SHOW COLUMNS FROM `{$tbl[0]}`";
        $res = mysql_query($sql) or  die ('could not get columns: ' . mysql_error());

        while ($col = mysql_fetch_array($res)) {


            // determine the correct update statement based on the user's preference
            if( !($case_sensitive) ) {

                $sql = "UPDATE `{$tbl[0]}` SET `{$col[0]}` = REPLACE(`{$col[0]}`, '{$old_str}' , '{$new_str}')";

            }  else {

                $sql = "UPDATE `{$tbl[0]}` SET `{$col[0]}` = REPLACE(LOWER(`{$col[0]}`), '{$old_str}' , '{$new_str}')";

            }
            $r = mysql_query($sql) or  die ('could not update the field: ' . mysql_error());
            if($r) {
                echo "\n\t&nbsp;&nbsp;&nbsp;<b>{$col[0]}</b>:";
                $num_changed = mysql_affected_rows() + $num_changed_ci;
                if($num_changed) {
                    echo "<font color='blue'> " . $num_changed . " values affected</font>";
                    $total_changed += $num_changed;
                } else {
                    echo " no change";
                }
                echo "<br />";

            } else {
                echo "\n\t&nbsp;&nbsp;&nbsp;<b>{$col[0]}</b>: <font color='red'>FAILED</font><br />";
            }

        }

    }

    @mysql_close($con);

    echo "<h3>$total_changed fields were affected.</h3>";

} else {
    //display the form
?>


    <h1>Have You Created A Backup?</h1>
	<h2>There Is No Undo Button!</h2>
    <form id="form1" name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <p>
            <label for="dont_timeout" title="Check this box if your database is large and you want to prevent the script from timing out!">Never Timeout</label>
            <input type="checkbox" class="checkbox" name="dont_timeout" id="dont_timeout" value="true" <?php if(isset($_POST['dont_timeout']) && ($_POST['dont_timeout'] == true) ) { echo ' checked'; } ?> />
        </p>

        <p>
            <label for="case_sensitive" title="Uncheck this box if you want to find DOG, Dog, and dog in the search.">Case-sensitive?</label>
            <input type="checkbox" class="checkbox" name="case_sensitive" id="case_sensitive" value="true"  <?php if(isset($_POST['case_sensitive']) && ($_POST['case_sensitive'] == true) ) { echo ' checked'; } ?> />
        </p>
    	<p>
    		<label for="dbhost">Database Host</label>
    		<input type="text" name="dbhost" id="dbhost" tabindex="1" value="<?php if(isset($_POST['dbhost'])) { echo $_POST['dbhost']; } else { echo 'localhost'; } ?>" />
    		</p>
    	<p>
    		<label for="dbname">Database Name</label>
    		<input type="text" name="dbname" id="dbname" tabindex="2" value="<?php if(isset($_POST['dbname'])) { echo $_POST['dbname']; } else { echo 'your db name'; } ?>" />
    	</p>
    	<p>
    		<label for="dbuser">Database User</label>
    		<input type="text" name="dbuser" id="dbuser" tabindex="3" value="<?php if(isset($_POST['dbuser'])) { echo $_POST['dbuser']; } else { echo 'root'; } ?>" />
    	</p>
    	<p>
    		<label for="dbpass">Database Pass</label>
    		<input type="text" name="dbpass" id="dbpass" tabindex="4" value="<?php if(isset($_POST['dbpass'])) { echo $_POST['dbpass']; } else { echo 'your fancy password'; } ?>" />
    	</p>
    	<p>
    		<label for="oldstr">Find This</label>
    		<input type="text" name="old_str" id="old_str" tabindex="5" value="<?php if(isset($_POST['old_str'])) { echo $_POST['old_str']; } else { echo 'needle in haystack'; } ?>" />
    	</p>
    	<p>
    		<label for="newstr">Replace w/ This</label>
    		<input type="text" name="new_str" id="new_str" tabindex="6" value="<?php if(isset($_POST['new_str'])) { echo $_POST['new_str']; } else { echo 'desired new text'; } ?>" />
    	</p>
    	<p>
    		<input type="submit" name="submitted" id="submit" value="Submit" />
    	</p>
	</form>


<?php } ?>

    <p>&nbsp;</p>
	<!-- end #mainContent --></div>
<!-- end #container --></div>
</body>
</html>