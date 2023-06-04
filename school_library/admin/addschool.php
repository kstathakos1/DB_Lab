<?php
include ('../config/database.php');
if (!isset($_SESSION)){
    session_start();
}
$school_name=$_POST['school_name'];
$emai=$_POST['mail'];
$hdf=$_POST['headmasterfname'];
$hdl=$_POST['headmasterlname'];
$address= $_POST['address'];
$tel=$_POST['telephone'];


list($type1,$city)=explode(" of ",$school_name,2);
if (is_numeric($type1[0])){
    list($number,$type)=explode(" ",$type1,2);
    $type.=' of';
}
else{
    $number=0;
    $type=$type1;
}

echo $number,$type,$city;
$comn=getDb();
$school_insert=$comn->query("insert into school_unit ( school_number, school_type, city, school_mail, address, telephone, Headmaster_first_name, Headmaster_last_name) VALUES ($number,'$type','$city','$emai','$address','$tel','$hdf','$hdl');");
header('Location: admin_tools.php');