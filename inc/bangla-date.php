<?php

function convert_bengali($str) {
    $engNumber = array(1,2,3,4,5,6,7,8,9,0);
    $bnNumber  = array('১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯', '০');
    $engWeek   = array('Sat', 'Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri');
    $bnWeek    = array('শনিবার', 'রবিবার', 'সোমবার', 'মঙ্গলবার', 'বুধবার', 'বৃহঃবার', 'শুক্রবার');
    $engMonth  = array("January","February","March","April","May","Jun","July","August","September","October","November","December");
    $bnMonth   = array("জানুয়ারি","ফেব্রুয়ারি","মার্চ","এপ্রিল","মে","জুন","জুলাই","আগস্ট","সেপ্টেম্বর","অক্টোবর","নভেম্বর","ডিসেম্বর");
    $converted = str_replace($engNumber, $bnNumber, $str);
    $converted = str_replace($engWeek, $bnWeek, $converted);
    $converted = str_replace($engMonth, $bnMonth, $converted);

    return $converted;
}
