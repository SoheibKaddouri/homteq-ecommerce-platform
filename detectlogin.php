<?php

if (isset($_SESSION['userid'])) {

echo "<br><br>";
echo "<p style='float: right;'>";
echo "<img src='loggedinuser.png' style='vertical-align: middle; width: 78px; height: 79px;'>";
echo "<b>&nbsp;" . $_SESSION['fname'] . " " . $_SESSION['sname'] . 
" - " . $_SESSION['usertype'] . "</b>";
echo "</p>";
echo "<br>";
}
?>