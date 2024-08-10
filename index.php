<?php
require "data.php";
$update = json_decode(file_get_contents('php://input'));
if(isset($update->message) || isset($update->callback_query)):
$message = $update->message ;
$data=  $update->callback_query->data;
$id = $message->from->id ?? $update->callback_query->from->id;
$chat_id = $message->chat->id ?? $update->callback_query->message->chat->id;
$text = $message->text ;
$user_name = $message->from->username ?? $update->callback_query->from->username;
$name = $message->from->first_name ?? $update->callback_query->from->first_name;
$message_id = $message->message_id ?? $update->callback_query->message->message_id;
$type = $message->chat->type ?? $update->callback_query->message->chat->type;
$reply = $message->reply_to_message;
endif;
$link =  "https://".$_SERVER["SERVER_NAME"].$_SERVER["PHP_SELF"];
echo file_get_contents("https://api.telegram.org/bot$token/setWebHook?url=$link");
$ex = explode ("#",$data);
if($id == $admin ){
	
	if($text == "/start" or $data == "back") {
		$info["admin"] = "";
		save();
		if($data=="back")
		$bot->deletemessage ([
			"chat_id"=>$chat_id,
			"message_id"=>$message_id
		]);
		$bot->sendmessage ([
			"chat_id"=>$chat_id,
			"text"=>trim($txt["القائمة الرئيسية"]),
			"reply_markup"=>json_encode([
				"inline_keyboard"=>[
					[["text"=>"اضافة دولة ➕","callback_data"=>"add"],["text"=>"حذف دولة 🗑️","callback_data"=>"del"]],
					[["text"=>"الدول المضافة 📊","callback_data"=>"all"]],
					[["text"=>"اضف معلوماتك 🔥","callback_data"=>"addinformation"]],
					[["text"=>"فحص الصيد 🔏","callback_data"=>"to_examine"]],
					[["text"=>"حذف عدد ➕","callback_data"=>"delCustomer"],["text"=>"اضافة عدد ➕","callback_data"=>"addCustomer"]],
				]
			])
		]);
		
	} elseif($text == "/work") {
		$bot->sendmessage ([
			"chat_id"=>$chat_id,
			"text"=>trim($txt["تشغيل الصيد"])
		]);
		$info["status"]="work";
		save();
	} elseif ($text == "/stop") {
		$bot->sendmessage ([
			"chat_id"=>$chat_id,
			"text"=>trim($txt["ايقاف الصيد"])
		]);
		$info["status"]=null;
		save();
	} elseif ($data) {
		if($data == "all"){
			$all = join ("\n",$info["countries"]) ?? "لاتوجد دول مضافة";
			$bot->answercallbackquery([
				"callback_query_id" => $update->callback_query->id,
				"text"=>"$all",
				"show_alert"=>true,
			]);
		} elseif ($data == "to_examine") {
			$check = json_decode(file_get_contents("http://api.duraincloud.com/out/ext_api/getUserInfo?name=$user&pwd=$apss&ApiKey=$api_key"),1);
			$code=$check["code"];
			if($code==200){
				$examine="شغال طبيعي ✅";
			}else{
				$examine="اسم المستخدم او كلمة المرور غير صحيح ⚠️";
			}
			$bot->answercallbackquery([
				"callback_query_id" => $update->callback_query->id,
				"text"=>"$examine",
				"show_alert"=>true,
			]);
		} elseif ($data == "addinformation") {
			$bot->editmessagetext([
				"chat_id"=>$chat_id,
				"text"=>"قم برفع معلومات من الاسفل",
				"message_id"=>$message_id,
				"reply_markup"=>json_encode([
					"inline_keyboard"=>[
						[["text"=>"رفع ال api","callback_data"=>"add_api"]],
						[["text"=>"رفع اسم المستخدم","callback_data"=>"add_username"]],
						[["text"=>"رفع الباسورد","callback_data"=>"add_password"]],
						[["text"=>"رفع التطبيق","callback_data"=>"add_app"]],
						[["text"=>"رفع قناة الصيد","callback_data"=>"add_chaneel"]],
						[["text"=>"رفع الثباتات","callback_data"=>"add_done"]],
						[["text"=>"رجوع🔙","callback_data"=>"back"]],
					]
				])
			]);
		} elseif ($data == "add_api") {
			$bot->editmessagetext([
				"chat_id"=>$chat_id,
				"text"=>"قم بإرسال ال api الخاص بك",
				"message_id"=>$message_id,
				"reply_markup"=>json_encode([
					"inline_keyboard"=>[
						[["text"=>"رجوع🔙","callback_data"=>"back"]],
					]
				])
			]);
			$info["admin"] = "add_api";
			save();
		} elseif ($data == "add_username") {
			$bot->editmessagetext([
				"chat_id"=>$chat_id,
				"text"=>"قم بإرسال الإسم المستخدم الخاص بك",
				"message_id"=>$message_id,
				"reply_markup"=>json_encode([
					"inline_keyboard"=>[
						[["text"=>"رجوع🔙","callback_data"=>"back"]],
					]
				])
			]);
			$info["admin"] = "add_username";
			save();
		} elseif ($data == "add_password") {
			$bot->editmessagetext([
				"chat_id"=>$chat_id,
				"text"=>"قم بإرسال الباسورد الخاص بك",
				"message_id"=>$message_id,
				"reply_markup"=>json_encode([
					"inline_keyboard"=>[
						[["text"=>"رجوع🔙","callback_data"=>"back"]],
					]
				])
			]);
			$info["admin"] = "add_password";
			save();
		} elseif ($data == "add_app") {
			$bot->editmessagetext([
				"chat_id"=>$chat_id,
				"text"=>"قم بإرسال رمز  التطبيق للصيد",
				"message_id"=>$message_id,
				"reply_markup"=>json_encode([
					"inline_keyboard"=>[
						[["text"=>"رجوع🔙","callback_data"=>"back"]],
					]
				])
			]);
			$info["admin"] = "add_app";
			save();
		} elseif ($data == "add_chaneel") {
			$bot->editmessagetext([
				"chat_id"=>$chat_id,
				"text"=>"قم بإرسال ايدي قناة الصيد",
				"message_id"=>$message_id,
				"reply_markup"=>json_encode([
					"inline_keyboard"=>[
						[["text"=>"رجوع🔙","callback_data"=>"back"]],
					]
				])
			]);
			$info["admin"] = "add_chaneel";
			save();
		} elseif ($data == "add_done") {
			$bot->editmessagetext([
				"chat_id"=>$chat_id,
				"text"=>"قم بإرسال ايدي قناة الاثباتات",
				"message_id"=>$message_id,
				"reply_markup"=>json_encode([
					"inline_keyboard"=>[
						[["text"=>"رجوع🔙","callback_data"=>"back"]],
					]
				])
			]);
			$info["admin"] = "add_done";
			save();
		} elseif ($data == "addCustomer") {
			$bot->editmessagetext([
				"chat_id"=>$chat_id,
				"text"=>"قم بإرسال ايدي الزبون وتحتة العدد المسموح لة بالشراء",
				"message_id"=>$message_id,
				"reply_markup"=>json_encode([
					"inline_keyboard"=>[
						[["text"=>"رجوع🔙","callback_data"=>"back"]],
					]
				])
			]);
			$info["admin"] = "addCustomer";
			save();
		} elseif ($data == "delCustomer") {
			$bot->editmessagetext([
				"chat_id"=>$chat_id,
				"text"=>"قم بإرسال ايدي الزبون وتحتة العدد الذي تريد خصمة من سماحية الزبون",
				"message_id"=>$message_id,
				"reply_markup"=>json_encode([
					"inline_keyboard"=>[
						[["text"=>"رجوع🔙","callback_data"=>"back"]],
					]
				])
			]);
			$info["admin"] = "delCustomer";
			save();
		} elseif ($data == "add") {
			$bot->editmessagetext([
				"chat_id"=>$chat_id,
				"text"=>"قم بارسال رمز الدولة في موقع البوت",
				"message_id"=>$message_id,
				"reply_markup"=>json_encode([
					"inline_keyboard"=>[
						[["text"=>"رجوع🔙","callback_data"=>"back"]],
					]
				])
			]);
			$info["admin"] = "add";
			save();
		} elseif ($data == "del") {
			$bot->editmessagetext([
				"chat_id"=>$chat_id,
				"text"=>"قم بارسال كود الدولة",
				"message_id"=>$message_id,
				"reply_markup"=>json_encode([
					"inline_keyboard"=>[
						[["text"=>"رجوع🔙","callback_data"=>"back"]],
					]
				])
			]);
			$info["admin"] = "del";
			save();
		
		}
	} elseif ($text && $info["admin"] == "add_api") {
		$json["api_key"] = $text;
		server();
		$info["admin"] = "";
		save();
		$bot->sendmessage ([
			"chat_id"=>$chat_id,
			"text"=>"تم إضافة ال api بنجاح"
		]);
	} elseif ($text && $info["admin"] == "add_username") {
		$json["username"] = $text;
		server();
		$info["admin"] = "";
		save();
		$bot->sendmessage ([
			"chat_id"=>$chat_id,
			"text"=>"تم إضافة إسم المستخدم بنجاح"
		]);
	} elseif ($text && $info["admin"] == "add_password") {
		$json["password"] = $text;
		server();
		$info["admin"] = "";
		save();
		$bot->sendmessage ([
			"chat_id"=>$chat_id,
			"text"=>"تم إضافة ال باسورد بنجاح"
		]);
	} elseif ($text && $info["admin"] == "add_app") {
		$json["app"] = $text;
		server();
		$info["admin"] = "";
		save();
		$bot->sendmessage ([
			"chat_id"=>$chat_id,
			"text"=>"تم إضافة ال التطبيق $text بنجاح"
		]);
	} elseif ($text && $info["admin"] == "add_chaneel") {
		$chaneel = "-100$text";
		$json["chaneel"] = $chaneel;
		server();
		$info["admin"] = "";
		save();
		$bot->sendmessage ([
			"chat_id"=>$chat_id,
			"text"=>"تم إضافة ايدي قناة الصيد بنجاح"
		]);
	} elseif ($text && $info["admin"] == "add_done") {
		$chaneel = "-100$text";
		$json["done"] = $chaneel;
		server();
		$info["admin"] = "";
		save();
		$bot->sendmessage ([
			"chat_id"=>$chat_id,
			"text"=>"تم إضافة ايدي قناة الاثباتات بنجاح"
		]);
	} elseif ($text && $info["admin"] == "addCustomer") {
		$ex_text=explode("\n", $text);
		$id_Customer=$ex_text[0];
		$num_Customer=$ex_text[1];
		$all=$Customer[$id_Customer][add]+$num_Customer;
		$Customer[$id_Customer]["add"] += $num_Customer;
		$Customer[$id_Customer]["all"] += $num_Customer;
		servd();
		$info["admin"] = "";
		save();
		$bot->sendmessage ([
			"chat_id"=>$chat_id,
			"text"=>"✅ تم إضافة $num_Customer للزبون $id_Customer
			🧩 واصبح لدية العدد المسموح لة $all"
		]);
	} elseif ($text && $info["admin"] == "delCustomer") {
		$ex_text=explode("\n", $text);
		$id_Customer=$ex_text[0];
		$num_Customer=$ex_text[1];
		$all=$Customer[$id_Customer][add]-$num_Customer;
		$Customer[$id_Customer]["add"] -= $num_Customer;
		$Customer[$id_Customer]["all"] -= $num_Customer;
		servd();
		$info["admin"] = "";
		save();
		$bot->sendmessage ([
			"chat_id"=>$chat_id,
			"text"=>"✅ تم خصم $num_Customer للزبون $id_Customer
			🧩 واصبح لدية العدد المسموح لة $all"
		]);
	} elseif ($text && $info["admin"] == "add") {
		$code = uniqid (1);
		$info["countries"][$code] = $text;
		$info["admin"] = "";
		save();
		$bot->sendmessage ([
			"chat_id"=>$chat_id,
			"text"=>"تمت الاضافة بنجاح\nكود الدولة\n$code\nيستخدم هذا الكود عند الرغبة بحذف الدولة"
		]);
	} elseif ($text && $info["admin"] == "del") {
		if($info["countries"][$text] == null){
			$bot->sendmessage ([
				"chat_id"=>$chat_id,
				"text"=>"لاتوجد دولة مضافة بهذا الكود"
			]);
			$info["admin"] = "";
			save();
		} else {
			unset($info["countries"][$text]);
			$info["admin"] = "";
			save();
			$bot->sendmessage ([
				"chat_id"=>$chat_id,
				"text"=>"تم الحذف بنجاح"
			]);
		}
	}
} 

if($ex[0] == "getCode" or $ex[0] == "ban"){
$idd = $update->callback_query->from->id;
if($Customer[$idd][add] < 1){
$bot->answercallbackquery([
'callback_query_id' => $update->callback_query->id,
'text'=>"☑️ ليس لديك سماح بطلب الكود 🙄",
'show_alert'=>true,
]);
exit;
}
}
if ($ex[0] == "getCode"  ) {
	$res = $api->getCode($ex[2],$ex[1]);
	if(empty ($res["Error"]) and $res["code"] != 0  ) {
		$code = $res["code"];
		$idd = $update->callback_query->from->id;
		$bot->editmessagetext([
			"chat_id"=>$chat_id,
			"text"=>trim(str_replace([
			"__code__","__number__"
			],
			[
			$code,$ex[2]
			],$txt["الكود"]
			)),
		"parse_mode"=>"markdown",
			"message_id"=>$message_id
		]);
		date_default_timezone_set('Asia/Baghdad');
		$tim = date('h:i:s');
		$aa = date('a');
		$a=str_replace(["am","pm"],["AM","PM"],$aa);
		$D = date('j'); // الايام
		$Y = date('Y'); // السنة
		$M = date('n'); // الشهر
		$time = "$tim $a";
		$bot->sendmessage ([
		'chat_id'=>$done,
		'text'=>"
✅ *تم شراء رقم جديد من الصيد بنجاح*

👤 المشتري : [$name](tg://user?id=$idd)
🆔 الايدي : *$idd*
⚜️ اليوزر : *@$user_name*
📆 التاريخ : *$D-$M-$Y*
⏰ الوقت : *$time*
📱 الرقم : *$ex[2]*
💬 الكود : *$code*
🔗 الموقع : *mm.duraincloud.com*
",
		"parse_mode"=>"markdown",
		"reply_markup"=>json_encode([
		"inline_keyboard"=>[
		[['text'=>"👤 ⁞ الملف الشخصي",'url'=>"tg://user?id=$idd"]]
		]
	])
]);
		$Customer[$idd][add] -= 1;
		servd();
		if($Customer[$idd][add] <= 1){
			sleep(15);
			$add=$Customer[$idd][all];
			$bot->KickChatMember ([
			"chat_id"=>$chat_id,
			"user_id"=>$idd
		]);
		$bot->sendmessage ([
		'chat_id'=>$admin,
		'text'=>"
🤖 *⁞ قام البوت بطرد عميل استوفى الحد المسموح له*
 
 🧑🏻‍💼 ⁞ العميل : [$name](tg://user?id=$idd)
 ♻️ ⁞ الحد المسموح له : *$add*
",
		"parse_mode"=>"markdown",
		'disable_web_page_preview'=>true,
		]);
		unset($Customer[$idd]);
		servd();
	}
	} else {
		$bot->answercallbackquery([
			"callback_query_id" => $update->callback_query->id,
			"text"=>"🚫 لم يصل الكود",
			"show_alert"=>true,
		]);
	}
} elseif ($ex[0] == "ban" ) {
	$res = $api->banNum($ex[2],$ex[1]);
	$bot->editmessagetext([
		"chat_id"=>$chat_id,
		"text"=>"تم حظر الرقم بنجاح",
		"message_id"=>$message_id
	]);
}






