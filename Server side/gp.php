<?php require_once('Connections/conn.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "admin";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "login.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_conn, $conn);
$query_rs_subcatx = "SELECT * FROM subcat
left join category on id=category_id";
$rs_subcatx = mysql_query($query_rs_subcatx, $conn) or die(mysql_error());
 

$ALL_SUB_CAT = array();
while($row_rs_subcatx = mysql_fetch_assoc($rs_subcatx)){
	$ALL_SUB_CAT[$row_rs_subcatx['s_id']] = $row_rs_subcatx;
	}

mysql_select_db($database_conn, $conn);
$query_rs_subcat = "SELECT * FROM subcat";
$rs_subcat = mysql_query($query_rs_subcat, $conn) or die(mysql_error());
$row_rs_subcat = mysql_fetch_assoc($rs_subcat);
$totalRows_rs_subcat = mysql_num_rows($rs_subcat);


do {
	
	
	
mysql_select_db($database_conn, $conn);
$query_rs_page = sprintf("SELECT * FROM page WHERE sub_cat=".$row_rs_subcat['s_id']);
$rs_page = mysql_query($query_rs_page, $conn) or die(mysql_error());
$row_rs_page = mysql_fetch_assoc($rs_page);
$totalRows_rs_page = mysql_num_rows($rs_page);

$PATH_TO_IMAGES = 'img/pages/';
 $PAGE = "<div class='bookpage-container'>";
 
 
			  $S_ID = $row_rs_subcat['s_id'];
			  //Check if first page don't show the first button
			  if($S_ID!=1)
				$PAGE .='<nav> <ul class="pager"><li style="width: 70%;margin: 10px;" class="pager-prev pull-right"><a style="background-color: #d0ad78;color: white;dirction:rtl;" onclick="loadPage('.($S_ID-1).')" > <span style="direction: rtl;" >'.$ALL_SUB_CAT[$S_ID-1]['name'].' <br /> '.$ALL_SUB_CAT[$S_ID-1]['s_name'].'</span> <span style="    margin-left: 10px;" class="glyphicon glyphicon-arrow-right"></span> </a></li></ul></nav>';
				 
				 
$PAGE .='<h1 class="color-brown" align="center" style="background-color: white;padding: 20px;">'.$row_rs_subcat['s_name'].'</h1>';				 
				 
 
 $BG_COLOR = 0;
 
 do { 
 
 if($BG_COLOR==0)
 {
	 	$PAGE .='<div class="white-bg section page-section " style="background-color:'.$row_rs_page['color'].'" color="'.$row_rs_page['color'].'" id="page'.$row_rs_page['page_id'].'" page_id="'.$row_rs_page['page_id'].'"  subcat_id="'.$row_rs_subcat['s_id'].'" subcatTitle="'.strip_tags($row_rs_page['page_name']).'"  pagecontent="'.strip_tags($row_rs_page['page_note']).'" >';
		$BG_COLOR = 1;
 }
else	
	{
		$PAGE .='<div class="gray-bg section page-section " style="background-color:'.$row_rs_page['color'].'" color="'.$row_rs_page['color'].'" id="page'.$row_rs_page['page_id'].'" page_id="'.$row_rs_page['page_id'].'"  subcat_id="'.$row_rs_subcat['s_id'].'" subcatTitle="'.strip_tags($row_rs_page['page_name']).'"  pagecontent="'.strip_tags($row_rs_page['page_note']).')" >';
		$BG_COLOR = 0;
	}
	
  $PAGE .='<div style="text-align: center;height: 15px;"><span style="float: left;" class="  fa-stack margin-icons-home" onclick="bookrmarkTOPLET(this)">
                        <i class="fa fa-circle fa-stack-2x color_brown"></i>
                        <i class="fa  fa-bookmark-o fa-stack fa-inverse bookmark-icon"></i>
                    </span>
					</div>';
  
 $PAGE .='<h2>'.$row_rs_page['page_name'].'</h2>';
 
 if($row_rs_page['page_img1'])
{ $PAGE .='<div class="pinch-zoom"><img src="'.$PATH_TO_IMAGES.$row_rs_page['page_img1'].'" class="page-img-2" /></div>';
	$PAGE .='<p align="center">'.$row_rs_page['label_img1'].'"  </p>';
	}
 
$PAGE .='<p>'.$row_rs_page['page_note'].'</p>';

if($row_rs_page['page_img2'])
{
 $PAGE .='<div class="pinch-zoom"><img src="'.$PATH_TO_IMAGES.$row_rs_page['page_img2'].'"  class="page-img-2" /></div>';
 $PAGE .='<p align="center">'.$row_rs_page['label_img2'].'"  </p>';
	}
 $PAGE .='</div>';
 
 //////////////// AHDAS ///////////////////////
  
 mysql_select_db($database_conn, $conn);
$query_rs_ahdas = sprintf("SELECT * FROM pagexahdas
LEFT JOIN ahdas  on id = ahdas_id 
WHERE page_id = %s", GetSQLValueString($row_rs_page['page_id'], "int"));
$rs_ahdas = mysql_query($query_rs_ahdas, $conn) or die(mysql_error());
 
$totalRows_rs_ahdas = mysql_num_rows($rs_ahdas);

if($totalRows_rs_ahdas)
{
	
	$PAGE .='<div class="ahdas-section section  " >
			  <div class="ahdas-header ">احداث عالمية</div>
			  <div class="ahdas-container">
				<div class=" white-bg" style="    padding-bottom: 29px;">
				  <div id="ahdas'.$row_rs_page['page_id'].'" class="carousel slide carousel-ahdas " data-ride="carousel"> ';
				  
	 $PAGE .='<ol class="carousel-indicators">';
        $PAGE .=' <li data-target="#ahdas'.$row_rs_page['page_id'].'" data-slide-to="0" class="active"></li>';
	for($i=1; $i<$totalRows_rs_ahdas ; $i++)
		$PAGE .=' <li data-target="#ahdas'.$row_rs_page['page_id'].'" data-slide-to="'.$i.'" ></li>';
		
		$PAGE .='</ol>
		<!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">';
		
		
		$FIRST_AHDAS = true;
		
  while ($row_rs_ahdas = mysql_fetch_assoc($rs_ahdas)) { 
  if($FIRST_AHDAS)
 	{
		 $PAGE .=' <div class="item active">';
		 $FIRST_AHDAS = false;
	}
  else
 	 $PAGE .=' <div class="item">';
  
    $PAGE .='  
            <h4 class="ahdas-year">'. $row_rs_ahdas['year'].'</h4>
            <p class="ahdas-text">'. $row_rs_ahdas['text'].'</p>
          </div>';
      
    }  
	
	
	
	$PAGE .='  </div>
      </div>
       
    </div>
  </div>
</div>
    <script type="text/javascript">
        $(function () {
            $("div.pinch-zoom").each(function () {
                new RTP.PinchZoom($(this), {});
            });
        })
    </script>
';

 }
 ////////////////// End AHDAS ////////////////////////////////////////////////////////

		

 } while ($row_rs_page = mysql_fetch_assoc($rs_page));  

//navigation 
	$PAGE .='<nav>
			  <ul class="pager">';
			  
			  $S_ID = $row_rs_subcat['s_id'];
			 /* //Check if first page don't show the first button
			  if($S_ID!=1)
				$PAGE .='<li style="width: 70%;margin: 10px;" class="pager-prev pull-right"><a style="background-color: #d0ad78;color: white;" onclick="loadPage('.($S_ID-1).')" >'.$ALL_SUB_CAT[$S_ID-1]['name'].' - '.$ALL_SUB_CAT[$S_ID-1]['s_name'].' <span style="    margin-left: 10px;" class="glyphicon glyphicon-arrow-right"></span> </a></li>';*/
				
				
				if($S_ID==$totalRows_rs_subcat)
					  //$PAGE .='<li class="pager-next pull-left"><a style="background-color: #d0ad78;color: white;" onclick="loadPage(\'rating\')"><span style="margin-right: 10px;"  class="glyphicon glyphicon-arrow-left"></span> تقييم </a></li>';
					  $PAGE .='<div dir="rtl" style="clear: both;" class="white-bg section">
<div class="send_button btn"><h2 style="margin: 5px;">نهاية الكتاب</h2></div>
  <h3>تقييم الكتاب</h3>
  <form role="form" class="rat-form">
    <div class="form-group" >
      <label for="name">الإسم:</label>
      <input type="text"   id="name">
    </div>
    
    
    <div class="form-group">
    <label for="checklist">الدولة:</label>
	<select name="country" id="country">
	<option value="AW">آروبا</option>
	<option value="AZ">أذربيجان</option>
	<option value="AM">أرمينيا</option>
	<option value="ES">أسبانيا</option>
	<option value="AU">أستراليا</option>
	<option value="AF">أفغانستان</option>
	<option value="AL">ألبانيا</option>
	<option value="DE">ألمانيا</option>
	<option value="AG">أنتيجوا وبربودا</option>
	<option value="AO">أنجولا</option>
	<option value="AI">أنجويلا</option>
	<option value="AD">أندورا</option>
	<option value="UY">أورجواي</option>
	<option value="UZ">أوزبكستان</option>
	<option value="UG">أوغندا</option>
	<option value="UA">أوكرانيا</option>
	<option value="IE">أيرلندا</option>
	<option value="IS">أيسلندا</option>
	<option value="ET">اثيوبيا</option>
	<option value="ER">اريتريا</option>
	<option value="EE">استونيا</option>
	<option value="IL">اسرائيل</option>
	<option value="AR">الأرجنتين</option>
	<option value="JO">الأردن</option>
	<option value="EC">الاكوادور</option>
	<option value="AE">الامارات العربية المتحدة</option>
	<option value="BS">الباهاما</option>
	<option value="BH">البحرين</option>
	<option value="BR">البرازيل</option>
	<option value="PT">البرتغال</option>
	<option value="BA">البوسنة والهرسك</option>
	<option value="GA">الجابون</option>
	<option value="ME">الجبل الأسود</option>
	<option value="DZ">الجزائر</option>
	<option value="DK">الدانمرك</option>
	<option value="CV">الرأس الأخضر</option>
	<option value="SV">السلفادور</option>
	<option value="SN">السنغال</option>
	<option value="SD">السودان</option>
	<option value="SE">السويد</option>
	<option value="EH">الصحراء الغربية</option>
	<option value="SO">الصومال</option>
	<option value="CN">الصين</option>
	<option value="IQ">العراق</option>
	<option value="VA">الفاتيكان</option>
	<option value="PH">الفيلبين</option>
	<option value="AQ">القطب الجنوبي</option>
	<option value="CM">الكاميرون</option>
	<option value="CG">الكونغو - برازافيل</option>
	<option value="KW">الكويت</option>
	<option value="HU">المجر</option>
	<option value="IO">المحيط الهندي البريطاني</option>
	<option value="MA">المغرب</option>
	<option value="TF">المقاطعات الجنوبية الفرنسية</option>
	<option value="MX">المكسيك</option>
	<option value="SA">المملكة العربية السعودية</option>
	<option value="GB">المملكة المتحدة</option>
	<option value="NO">النرويج</option>
	<option value="AT">النمسا</option>
	<option value="NE">النيجر</option>
	<option value="IN">الهند</option>
	<option value="US">الولايات المتحدة الأمريكية</option>
	<option value="JP">اليابان</option>
	<option value="YE">اليمن</option>
	<option value="GR">اليونان</option>
	<option value="ID">اندونيسيا</option>
	<option value="IR">ايران</option>
	<option value="IT">ايطاليا</option>
	<option value="PG">بابوا غينيا الجديدة</option>
	<option value="PY">باراجواي</option>
	<option value="PK">باكستان</option>
	<option value="PW">بالاو</option>
	<option value="BW">بتسوانا</option>
	<option value="PN">بتكايرن</option>
	<option value="BB">بربادوس</option>
	<option value="BM">برمودا</option>
	<option value="BN">بروناي</option>
	<option value="BE">بلجيكا</option>
	<option value="BG">بلغاريا</option>
	<option value="BZ">بليز</option>
	<option value="BD">بنجلاديش</option>
	<option value="PA">بنما</option>
	<option value="BJ">بنين</option>
	<option value="BT">بوتان</option>
	<option value="PR">بورتوريكو</option>
	<option value="BF">بوركينا فاسو</option>
	<option value="BI">بوروندي</option>
	<option value="PL">بولندا</option>
	<option value="BO">بوليفيا</option>
	<option value="PF">بولينيزيا الفرنسية</option>
	<option value="PE">بيرو</option>
	<option value="TZ">تانزانيا</option>
	<option value="TH">تايلند</option>
	<option value="TW">تايوان</option>
	<option value="TM">تركمانستان</option>
	<option value="TR">تركيا</option>
	<option value="TT">ترينيداد وتوباغو</option>
	<option value="TD">تشاد</option>
	<option value="TG">توجو</option>
	<option value="TV">توفالو</option>
	<option value="TK">توكيلو</option>
	<option value="TO">تونجا</option>
	<option value="TN">تونس</option>
	<option value="TL">تيمور الشرقية</option>
	<option value="JM">جامايكا</option>
	<option value="GI">جبل طارق</option>
	<option value="GD">جرينادا</option>
	<option value="GL">جرينلاند</option>
	<option value="AX">جزر أولان</option>
	<option value="AN">جزر الأنتيل الهولندية</option>
	<option value="TC">جزر الترك وجايكوس</option>
	<option value="KM">جزر القمر</option>
	<option value="KY">جزر الكايمن</option>
	<option value="MH">جزر المارشال</option>
	<option value="MV">جزر الملديف</option>
	<option value="UM">جزر الولايات المتحدة البعيدة الصغيرة</option>
	<option value="SB">جزر سليمان</option>
	<option value="FO">جزر فارو</option>
	<option value="VI">جزر فرجين الأمريكية</option>
	<option value="VG">جزر فرجين البريطانية</option>
	<option value="FK">جزر فوكلاند</option>
	<option value="CK">جزر كوك</option>
	<option value="CC">جزر كوكوس</option>
	<option value="MP">جزر ماريانا الشمالية</option>
	<option value="WF">جزر والس وفوتونا</option>
	<option value="CX">جزيرة الكريسماس</option>
	<option value="BV">جزيرة بوفيه</option>
	<option value="IM">جزيرة مان</option>
	<option value="NF">جزيرة نورفوك</option>
	<option value="HM">جزيرة هيرد وماكدونالد</option>
	<option value="CF">جمهورية افريقيا الوسطى</option>
	<option value="CZ">جمهورية التشيك</option>
	<option value="DO">جمهورية الدومينيك</option>
	<option value="CD">جمهورية الكونغو الديمقراطية</option>
	<option value="ZA">جمهورية جنوب افريقيا</option>
	<option value="GT">جواتيمالا</option>
	<option value="GP">جوادلوب</option>
	<option value="GU">جوام</option>
	<option value="GE">جورجيا</option>
	<option value="GS">جورجيا الجنوبية وجزر ساندويتش الجنوبية</option>
	<option value="DJ">جيبوتي</option>
	<option value="JE">جيرسي</option>
	<option value="DM">دومينيكا</option>
	<option value="RW">رواندا</option>
	<option value="RU">روسيا</option>
	<option value="BY">روسيا البيضاء</option>
	<option value="RO">رومانيا</option>
	<option value="RE">روينيون</option>
	<option value="ZM">زامبيا</option>
	<option value="ZW">زيمبابوي</option>
	<option value="CI">ساحل العاج</option>
	<option value="WS">ساموا</option>
	<option value="AS">ساموا الأمريكية</option>
	<option value="SM">سان مارينو</option>
	<option value="PM">سانت بيير وميكولون</option>
	<option value="VC">سانت فنسنت وغرنادين</option>
	<option value="KN">سانت كيتس ونيفيس</option>
	<option value="LC">سانت لوسيا</option>
	<option value="MF">سانت مارتين</option>
	<option value="SH">سانت هيلنا</option>
	<option value="ST">ساو تومي وبرينسيبي</option>
	<option value="LK">سريلانكا</option>
	<option value="SJ">سفالبارد وجان مايان</option>
	<option value="SK">سلوفاكيا</option>
	<option value="SI">سلوفينيا</option>
	<option value="SG">سنغافورة</option>
	<option value="SZ">سوازيلاند</option>
	<option value="SY">سوريا</option>
	<option value="SR">سورينام</option>
	<option value="CH">سويسرا</option>
	<option value="SL">سيراليون</option>
	<option value="SC">سيشل</option>
	<option value="CL">شيلي</option>
	<option value="RS">صربيا</option>
	<option value="CS">صربيا والجبل الأسود</option>
	<option value="TJ">طاجكستان</option>
	<option value="OM">عمان</option>
	<option value="GM">غامبيا</option>
	<option value="GH">غانا</option>
	<option value="GF">غويانا</option>
	<option value="GY">غيانا</option>
	<option value="GN">غينيا</option>
	<option value="GQ">غينيا الاستوائية</option>
	<option value="GW">غينيا بيساو</option>
	<option value="VU">فانواتو</option>
	<option value="FR">فرنسا</option>
	<option value="PS">فلسطين</option>
	<option value="VE">فنزويلا</option>
	<option value="FI">فنلندا</option>
	<option value="VN">فيتنام</option>
	<option value="FJ">فيجي</option>
	<option value="CY">قبرص</option>
	<option value="KG">قرغيزستان</option>
	<option value="QA">قطر</option>
	<option value="KZ">كازاخستان</option>
	<option value="NC">كاليدونيا الجديدة</option>
	<option value="HR">كرواتيا</option>
	<option value="KH">كمبوديا</option>
	<option value="CA">كندا</option>
	<option value="CU">كوبا</option>
	<option value="KR">كوريا الجنوبية</option>
	<option value="KP">كوريا الشمالية</option>
	<option value="CR">كوستاريكا</option>
	<option value="CO">كولومبيا</option>
	<option value="KI">كيريباتي</option>
	<option value="KE">كينيا</option>
	<option value="LV">لاتفيا</option>
	<option value="LA">لاوس</option>
	<option value="LB">لبنان</option>
	<option value="LU">لوكسمبورج</option>
	<option value="LY">ليبيا</option>
	<option value="LR">ليبيريا</option>
	<option value="LT">ليتوانيا</option>
	<option value="LI">ليختنشتاين</option>
	<option value="LS">ليسوتو</option>
	<option value="MQ">مارتينيك</option>
	<option value="MO">ماكاو الصينية</option>
	<option value="MT">مالطا</option>
	<option value="ML">مالي</option>
	<option value="MY">ماليزيا</option>
	<option value="YT">مايوت</option>
	<option value="MG">مدغشقر</option>
	<option value="EG">مصر</option>
	<option value="MK">مقدونيا</option>
	<option value="MW">ملاوي</option>
	<option value="ZZ">منطقة غير معرفة</option>
	<option value="MN">منغوليا</option>
	<option value="MR">موريتانيا</option>
	<option value="MU">موريشيوس</option>
	<option value="MZ">موزمبيق</option>
	<option value="MD">مولدافيا</option>
	<option value="MC">موناكو</option>
	<option value="MS">مونتسرات</option>
	<option value="MM">ميانمار</option>
	<option value="FM">ميكرونيزيا</option>
	<option value="NA">ناميبيا</option>
	<option value="NR">نورو</option>
	<option value="NP">نيبال</option>
	<option value="NG">نيجيريا</option>
	<option value="NI">نيكاراجوا</option>
	<option value="NZ">نيوزيلاندا</option>
	<option value="NU">نيوي</option>
	<option value="HT">هايتي</option>
	<option value="HN">هندوراس</option>
	<option value="NL">هولندا</option>
	<option value="HK">هونج كونج الصينية</option>
    </select>  
    </div>
    <div class="radio form-group">
	  <label>الجنس</label>
      <label><input type="radio" name="gender" value="female"> انثى</label>
	  <label><input type="radio" name="gender" value="male"> ذكر</label>
    </div>
	<div class="radio form-group">
      <label>التقييم</label>
      <label><input type="radio" name="rate" value="1"> 1</label>
      <label><input type="radio" name="rate" value="2"> 2</label>
	  <label><input type="radio" name="rate" value="3"> 3</label>
      <label><input type="radio" name="rate" value="4"> 4</label>
      <label><input type="radio" name="rate" value="5"> 5</label>	  
    </div>
    <div class="form-group" style="height:150px;">
      <label for="notes">الملاحظات:</label>
      <textarea id="notes" ></textarea>
    </div>	

	
    <button type="button" class="btn btn-default send_button" onClick="sendRating()">إرسال</button>
  </form>
 </div>';
					  
				else
				$PAGE .='<li style="width: 70%;margin: 10px;" class="pager-next  pull-left"><a style="background-color: #d0ad78;color: white; " onclick="loadPage('.($S_ID+1).')"><span style="margin-right: 10px;"  class="glyphicon glyphicon-arrow-left"></span> <span style="direction: rtl;" >'.$ALL_SUB_CAT[$S_ID+1]['name'].' <br /> '.$ALL_SUB_CAT[$S_ID+1]['s_name'].' </span></a></li>';
				
				
	
	$PAGE .='  </ul>
			</nav>';
			
			
$PAGE .= "</div>";//end pagebook-container			
// END navigation 	

	
	$myfile = fopen("pages/".$row_rs_subcat['s_id'].".html", "w+") or die("Unable to open file!");
	
	fwrite($myfile,  $PAGE);
	 
	fclose($myfile);
	
	
    
} while ($row_rs_subcat = mysql_fetch_assoc($rs_subcat));  ?>