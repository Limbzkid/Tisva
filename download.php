<?php
header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=contact.csv");
readfile('file.csv');			
?>