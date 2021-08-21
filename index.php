<?php
/*
  Produced 2021
  By https://amattu.com/links/github
  Copy Alec M.
  License GNU Affero General Public License v3.0
*/

// Files
require("classes/UMDIO.class.php");

// Setup Wrapper
$wrapper = new amattu\UMDIO(/* See PHPDoc for Opts */);

// Set Props using Chaining
$wrapper->set_dept_id("INST")->set_per_page(10)->set_semester("202108");
// Eg. $wrapper->set_per_page(100)->courses()

// Get Classes
echo "<pre>";
//print_r($wrapper->courses());

// Get Minified Course Listing
//print_r($wrapper->course_list());

// Get ALL course sections
//print_r($wrapper->sections());

// Get a specific course section's detail
//print_r($wrapper->section("AASP100-0101"));

// Get a specific course info
//print_r($wrapper->course("INST414"));

// Get the list of supported semester
//print_r($wrapper->semesters());

// Get list of UMD departments
//print_r($wrapper->departments());

// Get list of UMD majors
//print_r($wrapper->majors());

// Find professors by name
//echo "<h1>Professor by name</h1>";
//print_r($wrapper->professors("LaRia Rogers"));
//echo "<h1>Professor by courses</h1>";
//print_r($wrapper->professors("", "CMSC216"));
