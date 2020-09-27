<?php
   include('config.php');
   session_start();
   
   $user_name = $_SESSION['user_name'];
   $prof_pic=$_SESSION['profile_pic'];
   $user_permission=$_SESSION['permission'];
   $user_permission_id=$_SESSION['permission_id'];
   $time=$_SESSION['login_time'];
   $language=$_SESSION['lang'];
   $day=date("l");
   
   if($user_permission_id==4 OR $user_permission_id==1){
	   $user_location=$_SESSION['location'];
	   $user_location_id=$_SESSION['location_id'];
	   $user_level=$_SESSION['level'];
	   $user_tourn=$_SESSION['tourn_id'];
   }
   else if($user_permission_id==5){
	   $user_location=$_SESSION['location'];
	   $user_location_id=$_SESSION['location_id'];
	   $user_level=$_SESSION['level'];
	   $user_tourn=$_SESSION['tourn_id'];
	   $user_category=$_SESSION['category'];
	   $user_category_id=$_SESSION['category_id'];
   }
   $akt_season='2020/2021';
   $akt_season_id='1';
   $national_head='zelles.tamas@gmail.com';
   
   
   if(!isset($_SESSION['user_name'])){
      header("location:index.php");
      die();
   }
?>