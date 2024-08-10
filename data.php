<?php
$info = json_decode(file_get_contents("info.json"),1);
function save(){
	global $info;
	if(! empty ($info)) 
	file_put_contents("info.json",json_encode($info,448));
}
$json = json_decode(file_get_contents("json.json"),1);
function server(){
	global $json;
	if(! empty ($json)) 
	file_put_contents("json.json",json_encode($json,448));
}
$Customer = json_decode(file_get_contents("Customer.json"),1);
function servd(){
	global $Customer;
	if(! empty ($Customer)) 
	file_put_contents("Customer.json",json_encode($Customer,448));
}
$token = "5849091925:AAGBOKsOf3oatQ_9P6tdWzOHWL244xnQFk4" ; 
$ch = $json["chaneel"]; //ايدي قناة الصيد
$done = $json["done"]; //ايدي قناة الاثباتات
$admin = 5207032121; //الادمن حق البوت
$api_key =$json["api_key"]; //api key حق حسابك
$user = $json["username"]; //اسم المستخدم حق حسابك
$pass = $json["password"]; // كلمة السر حق حسابك
$app = $json["app"]; // التطبيق
require "class.php";
require "Telegram.php";
$bot = new Telegram ($token);
$api = new MainClass($user,$pass,$app,$api_key);
/*
النصوص التالية بامكانك التعديل عليها
لكن انتبه من حذف اي كلمة موجوده داخل 
__الكلمة__
مثل 
__number__
لان هذه الكلمة سيتم استبدالها بقيمة معينة
*/
//ملف الصيد
$txt["رسالة الصيد"] =
"
تم شراء رقم جديد
الرقم : __number__
رابط الرقم للتحقق منه
wa.me/__number__
t.me/__number__
";
$txt["حظر الرقم"] = "
حظر الرقم
"
;
$txt["طلب الكود"]="
طلب الكود
";
#--------------------------------
//ملف التحكم
$txt["القائمة الرئيسية"]="
/work لجعل البوت يبدا الصيد
/stop لجعل البوت يتوقف عن الصيد

عند ايقاف الصيد لا يتوقف مباشرة وانما يتوقف بعد مرور دقيقة
";

$txt["تشغيل الصيد"] ="
تم تشغيل الصيد
";
$txt["ايقاف الصيد"] ="
تم ايقاف الصيد
";


$txt["الكود"]="
تم وصول الكود بنجاح
الرقم : __number__
الكود : `__code__`
";






