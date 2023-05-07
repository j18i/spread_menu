<?php
include_once('./_common.php');
header("Content-Type: text/css; charset=utf-8");

$sql = " select * from {$g5['menu_table']} where me_use = '1' and length(me_code) = '2' and me_name = '메뉴설정' order by me_order*1, me_id ";
$result = sql_fetch($sql); 

$setting_text = $result['me_link'];
$settings = explode('/', $setting_text);
$i = 0;
for ($i = 0; $i < count($settings); $i++) {
  $temp = explode(':', $settings[$i]);
  if($temp[0] == '메뉴타입'){
    $menu_type = $temp[1]; 
  }
  else if($temp[0] == '메뉴숨김'){
    $secret_type = $temp[1];
  }
  else if($temp[0] == '메뉴접힘'){
    $fold_type = $temp[1];
  }
  else if($temp[0] == 'BGM여부'){
    $bgm_type = $temp[1];
  }
  else if($temp[0] == '애니메이션길이'){
    $animation_length = $temp[1]*1000;
  }
  else if($temp[0] == '둥글게'){
    $radius = $temp[1];
  }
}
  
  
// CSS 설정 가져오기
$css_sql = sql_query("select * from {$g5['css_table']}");
$css = array();
for($i=0; $cs = sql_fetch_array($css_sql); $i++) {
	$css[$cs['cs_name']][0] = $cs['cs_value'];
	$css[$cs['cs_name']][1] = $cs['cs_etc_1'];
	$css[$cs['cs_name']][2] = $cs['cs_etc_2'];
	$css[$cs['cs_name']][3] = $cs['cs_etc_3'];
	$css[$cs['cs_name']][4] = $cs['cs_etc_4'];
	$css[$cs['cs_name']][5] = $cs['cs_etc_5'];
	$css[$cs['cs_name']][6] = $cs['cs_etc_6'];
	$css[$cs['cs_name']][7] = $cs['cs_etc_7'];
	$css[$cs['cs_name']][8] = $cs['cs_etc_8'];
	$css[$cs['cs_name']][9] = $cs['cs_etc_9'];
	$css[$cs['cs_name']][10] = $cs['cs_etc_10'];

  $css[$cs['cs_name']][11] = $cs['cs_etc_11'];
	$css[$cs['cs_name']][12] = $cs['cs_etc_12'];
	$css[$cs['cs_name']][13] = $cs['cs_etc_13'];
	$css[$cs['cs_name']][14] = $cs['cs_etc_14'];
	$css[$cs['cs_name']][15] = $cs['cs_etc_15'];
	$css[$cs['cs_name']][16] = $cs['cs_etc_16'];
	$css[$cs['cs_name']][17] = $cs['cs_etc_17'];
	$css[$cs['cs_name']][18] = $cs['cs_etc_18'];
	$css[$cs['cs_name']][19] = $cs['cs_etc_19'];
	$css[$cs['cs_name']][20] = $cs['cs_etc_20'];
}
?>

:root {
  --menu-base: <?=$css['menu_icon'][0]?>;
  --menu-point: <?=$css['menu_icon'][10]?>;
  --menu-text: <?=$css['menu_icon'][6]?>;
  --radius: <?=$css['menu_tooltip'][5].'px '.$css['menu_tooltip'][6].'px '.$css['menu_tooltip'][7].'px '.$css['menu_tooltip'][8].'px'?>;
  --position: <?if(strpos($css['menu_icon'][12], 'calc') === 0) echo $css['menu_icon'][12]; else echo $css['menu_icon'][12].'px';?>;
}

<?// 폰트 임포트?>
@font-face {
    font-family: 'Chosunilbo_myungjo';
    src: url('https://cdn.jsdelivr.net/gh/projectnoonnu/noonfonts_one@1.0/Chosunilbo_myungjo.woff') format('woff');
    font-weight: normal;
    font-style: normal;
}
@font-face {
    font-family: 'LOTTERIACHAB';
    src: url('https://cdn.jsdelivr.net/gh/projectnoonnu/noonfonts_2302@1.0/LOTTERIACHAB.woff2') format('woff2');
    font-weight: normal;
    font-style: normal;
}
@font-face {
    font-family: 'NanumSquareNeo-Variable';
    src: url('https://cdn.jsdelivr.net/gh/projectnoonnu/noonfonts_11-01@1.0/NanumSquareNeo-Variable.woff2') format('woff2');
    font-weight: normal;
    font-style: normal;
}


<?// 기본 디자인?>
.widget_header {
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    position: fixed;
    pointer-events: none;
    z-index: 99;
}
.mobilebtn {
  position: fixed;
  top: 20px;
  <?if($css['use_header'][0] == 'R') echo 'right'; else echo 'left';?>: 20px;
  width: 32px;
  height: 32px;
  background: var(--menu-point);
  color: var(--menu-base);
  border-radius: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  pointer-events: auto;
}

#widget_header {
  overflow: visible !important;
  top: 0;
  <?if($css['use_header'][0] == 'R') echo 'right'; else if($css['use_header'][0] == '') echo 'left'; else echo 'left'?>: 0;
  <?if($css['use_header'][0] == 'R') echo 'left'; else echo 'right';?>: unset;
}

.widgetmenu * {
  color: var(--menu-text);
}
.widgetmenu {
  width: 170px;
  height: fit-content;
  position: absolute;
  margin-top: 50vh;
  <?if($css['use_header'][0] == '') echo 'left'; else if($css['use_header'][0] == 'R') echo 'right'; else echo 'top'?>: var(--position);
  transform: translateY(-50%);
  transition-duration: var(--animation-length);
  opacity: 0;
  pointer-events: auto;
}
.widgetmenu.done_loading {
  animation-name: fadeIn;
  animation-duration: var(--animation-length);
  opacity: 1;
}
.widgetmenu.view {
  <?if($css['use_header'][0] == 'R') echo 'right'; else if($css['use_header'][0] == '') echo 'left'; else echo 'top';?>: var(--position) !important;
}
.widgetmenu ul {
  display: flex;
  flex-direction: column;
  <?if($css['use_header'][0] == 'R') echo 'align-items: flex-end;'?>
}
.widgetmenu_list {
  position: relative;
  display: block;
  width: 100%;
  margin: 3px 0px;
  cursor: pointer !important;
  border-radius: var(--radius);
}
.widget_a {
  display: flex;
  justify-content: space-evenly;
  align-items: center;
  <?if($css['use_header'][0] == 'R') echo 'flex-direction: row-reverse;';?>
  position: relative;
}
.widgetmenu_item {
}
.widgetmenu_item_icon {
  width: 24px;
  height: 24px;
  <?if($css['use_header'][0] == '' || $css['use_header'][0] == 'center') echo 'left'; else echo 'right';?>: 1px;
  position: relative;
  overflow: hidden;
  display: inline-flex;
  align-items: center;
  justify-content: center;
}
.widgetmenu_item_text {
  display: inline-block;
  width: calc(100% - 20px);
  text-align: center;
  padding: 0px 10px;
  position: relative;
}

.widgetmenu_main {
}
.widgetmenu_main_havesub {
}
.widgetmenu_sub {
}

.widgetmenu_sub.on {
  animation: active var(--animation-length);
  animation-fill-mode: forwards;
}
.widgetmenu_sub.off {
  animation: active var(--animation-length);
  animation-direction: reverse;
}

@keyframes active {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

.widgetmenu_side {
  margin-top: 10px;
  text-align: center;
  border-radius: var(--radius);
}
.widgetmenu_side ul {
  display: flex;
  flex-direction: column;
  align-items: center;
}
.widgetmenu_side_text {
}
.widgetmenu_side_menu_box {
  display: flex;
  justify-content: space-evenly;
  align-items: center;
  text-align: -webkit-center;
}
.widgetmenu_side_item {
  width: 40px;
  height: 40px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0px 2px;
  <?if($css['use_header'][0] == 'R') echo 'flex-direction: row-reverse;';?>
}
.widgetmenu_side_item a {
  <?if($css['use_header'][0] == 'R') echo 'flex-direction: row-reverse;';?>
}
.widgetmenu_side_item_icon {
  width: 24px;
  height: 24px;
  position: relative;
  
}
.widgetmenu_side_item_text {
  display:none;
}

.widgetmenu_bgm_box {
  margin-bottom: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
}
.widgetmenu_bgm_text {
  width: 24px;
  font-size: 13px;
}
.widgetmenu_bgm_control {
  display: flex;
  flex-direction: row;
  align-items: center;
}
#playbtn {}
#stopbtn {}

.sidewindow_close {
  display: none;
}

.activebtn {
  width: 40px;
  height: 40px;
  display: none;
  align-items: center;
  justify-content: center;
}


<?// 모바일 대응?>

<?// PC 버전?>
@media all and (min-width: 1001px) { 
  .mobilebtn {
    display:none;
  }
  .iconic_h {
    left: 0;
  }
 }
 
 <?// 모바일 버전?>
 @media all and (max-width: 1000px) {
  .mobilebtn {
    display:flex;
  }
  .widgetmenu {
    <?if($css['use_header'][0] == 'R') echo 'right'; else echo 'left';?>: -200%;
  }
  .widgetmenu.view {
    <?if($css['use_header'][0] == 'R') echo 'right'; else echo 'left';?>: 20px !important;
  }
 }

 <?// simple 간단 스킨?>

.simple {
  font-family: 'Chosunilbo_myungjo';
  font-weight: bold;
  font-size: 13px;
  letter-spacing: 0;
}
.simple.widgetmenu ul {}
.simple .widgetmenu_list {
  transition-duration: 0.5s;
}
.simple .widget_a {
  height: 30px;
}
.simple .widgetmenu_item {}
.simple .widgetmenu_item_icon {
  left: 3px;
  border-radius: 6px;
}
.simple .widgetmenu_item_text {
  text-align: <?if($css['use_header'][0] == 'center' || $css['use_header'][0] == '') echo 'right'; else echo 'left';?>;
  box-sizing: border-box;
  padding: 0px 10px;
  width: calc(100% - 40px);
}

.simple .widgetmenu_main {
  background: var(--menu-base);
}
.simple .widgetmenu_main_havesub {
  background: var(--menu-base);
}
.simple .widgetmenu_main_havesub::after {
  content: '+';
  font-size: 16px;
  font-family: impact;
  position: absolute;
  <?if($css['use_header'][0] == 'R') echo 'left'; else echo 'right';?>: -6px;
  top: calc(50% - 9px);
  z-index: 2;
  background: var(--menu-point);
  color: var(--menu-base);
  width: 18px;
  height: 18px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 100%;
}

.simple .widgetmenu_sub {
  background: var(--menu-point);
  <?if($css['use_header'][0] == 'R') echo 'right'; else if($css['use_header'][0] == '') echo 'left'; else echo 'left';?>: 20px;
  width: calc(100% - 20px);
  display:none;
}

.simple .widgetmenu_sub.active {
  display: block;
}

.simple .widgetmenu_sub.on {
  animation: defaultactive var(--animation-length);
  animation-fill-mode: forwards;
}
.simple .widgetmenu_sub.off {
  animation: defaultactive var(--animation-length);
  animation-direction: reverse;
}

@keyframes defaultactive {
  from {
    height: 0px;
    opacity: 0;
  }
  to {
    height: 30px;
    opacity: 1;
  }
}

.simple .widgetmenu_sub .widgetmenu_item_icon,
.simple .widgetmenu_sub .widgetmenu_item_text {
  opacity: 0;
}
.simple .widgetmenu_sub.off .widgetmenu_item_icon,
.simple .widgetmenu_sub.on .widgetmenu_item_icon,
.simple .widgetmenu_sub.off .widgetmenu_item_text,
.simple .widgetmenu_sub.on .widgetmenu_item_text {
  opacity: 0 !important;
}
.simple .widgetmenu_sub.active .widgetmenu_item_icon,
.simple .widgetmenu_sub.active .widgetmenu_item_text {
  opacity: 1;
}
.simple .widgetmenu_sub::before {
  content: 'x';
  font-family: 'LOTTERIACHAB';
  font-weight: bold;
  font-size: 20px;
  <?if($css['use_header'][0] == 'R') echo 'right'; else if($css['use_header'][0] == '') echo 'left'; else echo 'left';?>: -20px;
  position: absolute;
  display: flex;
  align-items: center;
  height: calc(100% - 4px);
  color: var(--menu-point);
}

.simple .widgetmenu_main:hover {
  background: var(--menu-point);
}
.simple .widgetmenu_main_havesub:hover {
  background: var(--menu-point);
}
.simple .widgetmenu_sub:hover {
  background: var(--menu-text);
}
.simple .widgetmenu_sub:hover * {
  color: var(--menu-base) !important;
}

.simple .widgetmenu_side {}
.simple .widgetmenu_side ul {}
.simple .widgetmenu_side_text {}

.simple .widgetmenu_side_menu_box {}
.simple .widgetmenu_side_item {
  background: var(--menu-point);
  border-radius: 100%;
  width: 28px;
  height: 28px;
}
.simple .widgetmenu_side_item_icon {
  width: 20px;
  height: 20px;
}
.simple .widgetmenu_side_item_icon .material-icons {
  font-size: 20px;
}
.simple .widgetmenu_side_item_text {}

.simple .widgetmenu_bgm_box {
  background: var(--menu-base);
  border-radius: 20px;
  width: 75px;
  padding: 6px 0px;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 20px;
}
.simple .widgetmenu_bgm_text {
  font-size: 15px;
}
.simple .widgetmenu_bgm_control {}


<?// digital 디지털 스킨 ?>

.digital {
  width: 110px;
  background: var(--menu-base);
  border: 2px inset var(--menu-base);
  box-sizing: border-box;
  font-family: galmuri7;
  border-radius: var(--radius);
}
.digital::before {
  content: '☎ Menu.exe';
  width: calc(100% + 6px);
  left: -2px;
  height: 22px;
  position: absolute;
  top: -24px;
  background: var(--menu-point);
  border: 2px outset var(--menu-point);
  box-sizing: border-box;
  display: flex;
  align-items: center;
  padding: 0px 10px;
  font-size: 12px;
  font-family: galmuri11;
  color: var(--menu-text);
  pointer-events: none;
  white-space: nowrap;
  overflow: hidden;
  border-radius: <?if($radius != 0) echo 'var(--radius) var(--radius) 0 0;'; else echo ' var(--radius);';?>
}
.digital::after {
  content: '';
  width: calc(100% + 10px);
  height: calc(100% + 30px);
  position: absolute;
  top: -26px;
  left: -4px;
  border: 2px ridge var(--menu-base);
  box-sizing: border-box;
  pointer-events: none;
  border-radius: var(--radius);
  background: var(--menu-base);
  z-index: -1;
  filter: drop-shadow(1px 1px 0px var(--menu-text)) drop-shadow(-1px -1px 0px var(--menu-text)) drop-shadow(4px 5px 0px rgba(0,0,0,0.2));
}

.digital.widgetmenu ul {
  flex-direction: row;
  flex-wrap: wrap;
  align-items: center;
  justify-content: space-evenly;
}
.digital .widgetmenu_list {
  width: 50px;
  display: inline-block;
}
.digital .widget_a {
  flex-direction: column;
}

.digital .widgetmenu_item {
  filter: drop-shadow(2px 2px 0px rgba(0,0,0,0.2));
  margin: 10px 5px;
  transition-duration: var(--animation-length);
}

.digital .widgetmenu_item:hover {
  filter: drop-shadow(0px 0px 0px rgba(0,0,0,0.2));
}
.digital .widgetmenu_item_icon {
  filter: drop-shadow(1px 1px 0px white) drop-shadow(-1px -1px 0px white) drop-shadow(-1px 1px 0px white) drop-shadow(1px -1px 0px white) drop-shadow(1px 1px 0px black);
  image-rendering: pixelated;
  transform: translate(-1px, -1px);
}
.digital .widgetmenu_item:hover .widgetmenu_item_icon {
  filter: drop-shadow(1px 1px 0px white) drop-shadow(-1px -1px 0px white) drop-shadow(-1px 1px 0px white) drop-shadow(1px -1px 0px white);
}
.digital .widgetmenu_img {
  image-rendering: pixelated;
}
.digital .widgetmenu_item_text {
  margin-top: 5px;
  white-space: nowrap;
  text-overflow: ellipsis;
  overflow: hidden;
  padding: 0px;
  width: 100%;
  white-space: unset;
  word-break: break-all;
}

.digital .widgetmenu_main {}
.digital .widgetmenu_main_havesub {}
.digital .widgetmenu_main_havesub .widget_a::before {
content:'+';
position:absolute;
top: -6px;
right: -1px;
filter: drop-shadow(1px 1px 0px white) drop-shadow(-1px -1px 0px white) drop-shadow(-1px 1px 0px white) drop-shadow(1px -1px 0px white) drop-shadow(1px 1px 0px black);
color: var(--menu-text);
}
.digital .widgetmenu_main_havesub.active .widget_a::before {
  content:'-';
}
.digital .widgetmenu_sub {
  display:none;
}
.digital .widgetmenu_sub.active {
  display: inline-block;
}

.digital .widgetmenu_sidewindow {
  width: inherit;
  height: fit-content;
  position: absolute;
  background: var(--menu-base);
  border: 2px inset var(--menu-base);
  <?if($css['use_header'][0] == '') echo 'right'; else if($css['use_header'][0] == 'R') echo 'left'; else echo 'bottom'?>: -100%;;
  top: 144px;
  min-height: 90px;
  padding-top: 30px;
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;
  justify-content: space-evenly;
  opacity: 0;
  pointer-events: none;
  z-index: 2;
  border-radius: var(--radius);
  box-sizing: border-box;
}
.digital .widgetmenu_sidewindow.active {
  opacity: 1;
  pointer-events: auto;
}
.digital .sidewindow_close {
  position: absolute;
  width: 13px;
  height: 13px;
  top: 5px;
  right: 5px;
  display: flex;
  background: var(--menu-point);
  border: 3px outset var(--menu-point);
  align-items: center;
  justify-content: center;
}

.digital .widgetmenu_sidewindow::after {
  content: '';
  width: calc(100% + 8px);
  height: calc(100% + 8px);
  position: absolute;
  top: -4px;
  left: -4px;
  border: 2px ridge var(--menu-base);
  box-sizing: border-box;
  pointer-events: none;
  border-radius: var(--radius);
  z-index: -1;
  filter: drop-shadow(1px 1px 0px var(--menu-text)) drop-shadow(-1px -1px 0px var(--menu-text)) drop-shadow(4px 5px 0px rgba(0,0,0,0.2));
  background:var(--menu-base);
}

.digital .widgetmenu_side {}
.digital .widgetmenu_side ul {}
.digital .widgetmenu_side_text {
  width: 100%;
}

.digital .widgetmenu_side_menu_box {}
.digital .widgetmenu_side_item {
  flex-direction: column;
  margin: 15px 0px;
}
.digital .widgetmenu_side_item_icon {
  filter: drop-shadow(1px 1px 0px white) drop-shadow(-1px -1px 0px white) drop-shadow(-1px 1px 0px white) drop-shadow(1px -1px 0px white) drop-shadow(1px 1px 0px black);
  image-rendering: pixelated;
  transform: translate(-1px, -1px);
}
.digital .widgetmenu_side_item_text {
  margin-top: 5px;
  display: block;
  white-space: nowrap;
  text-overflow: ellipsis;
}

.digital .widgetmenu_bgm_box {
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
}
.digital .widgetmenu_bgm_text {}
.digital .widgetmenu_bgm_control {}

<?// glass 유리 재질 스킨?>

.glass {}
.glass.widgetmenu ul {}
.glass .widgetmenu_list {
  height: 45px;
  background: rgba(255,255,255,0.3);
  backdrop-filter: blur(7px);
  border-bottom: 1px solid rgba(0,0,0,0.1);
  border-top: 1px solid rgba(255,255,255,0.1);
  padding: 7px;
  box-sizing: border-box;
  transition-duration:var(--animation-length);
  display: flex;
  align-items: center;
  justify-content: space-evenly;
}
.glass .widgetmenu_list:hover {
  backdrop-filter: blur(0px);
  box-shadow: 0px 0px 13px rgba(0,0,0,0.5);
}
.glass .widget_a {
  justify-content: center;
}
.glass .widgetmenu_item {
  width: 100%;
}
.glass .widgetmenu_item_icon {}
.glass .widgetmenu_item_text {
  width: calc(100% - 50px);
  font-family: chosunilbo_myungjo;
  font-size: 14px;
  font-weight: bold;
}

.glass .widgetmenu_main {}
.glass .widgetmenu_main_havesub {}
.glass .widgetmenu_main_havesub .widgetmenu_item_text::after {
    content: '-';
    position: absolute;
    color: var(--menu-text);
    right: 10px;
    font-size: 16px;
    display: inline-block;
}
.glass .widgetmenu_sub {
  display: none;
  height: 35px;
  padding: 4px 7px;
}
.glass .on {
  animation: glassactive var(--animation-length);
  animation-fill-mode: forwards;
}
.glass .off {
  animation: glassactive var(--animation-length);
  animation-direction: reverse;
}

@keyframes glassactive {
  from{
    opacity: 0;
  }
  to{
    opacity: 1;
  }
}

.glass .widgetmenu_sub.active {
  display: flex;
}
.glass .widgetmenu_side {
  background: rgba(255,255,255,0.3);
    backdrop-filter: blur(7px);
    border-bottom: 1px solid rgba(0,0,0,0.1);
    border-top: 1px solid rgba(255,255,255,0.1);
    padding: 7px;
    box-sizing: border-box;
    transition-duration: var(--animation-length);
    display: flex;
    align-items: center;
    justify-content: space-evenly;
    margin-top: 4px;
}
.glass .widgetmenu_side ul {}
.glass .widgetmenu_side_text {}

.glass .widgetmenu_side_menu_box {}
.glass .widgetmenu_side_item {}
.glass .widgetmenu_side_item_icon {}
.glass .widgetmenu_side_item_text {}

.glass .widgetmenu_bgm_box {}
.glass .widgetmenu_bgm_text {}
.glass .widgetmenu_bgm_control {}

<?// retro 레트로 스킨?>

.retro {
  width: 140px;
  font-family: galmuri11;
}
.retro.widgetmenu ul {}
.retro .widgetmenu_list {}
.retro .widget_a {}
.retro .widgetmenu_item {
  transition-duration: var(--animation-length);
  filter: drop-shadow(0px 0px 0px var(--menu-text));
}
.retro .widgetmenu_item:hover {
  filter: drop-shadow(3px 3px 0px rgba(0,0,0,0.2));
}
.retro .widgetmenu_item_icon {
  display: none;
}
.retro .widgetmenu_item_text {
  font-size: 25px;
  line-height: 25px;
  font-weight: bold;
  filter: drop-shadow(1px 1px 0px var(--menu-base)) drop-shadow(-1px -1px 0px var(--menu-base)) drop-shadow(-1px 1px 0px var(--menu-base)) drop-shadow(1px -1px 0px var(--menu-base)) drop-shadow(1px 1px 0px var(--menu-text));
  background-image: linear-gradient(139deg, var(--menu-text), var(--menu-point));
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  text-align: <?if($css['use_header'][0] == 'R') echo 'right'; else if($css['use_header'][0] == '') echo 'left'; else echo 'left';?>;
  position: relative;
  <?if($css['use_header'][0] == 'R') echo 'right'; else if($css['use_header'][0] == '') echo 'left'; else echo 'left';?>: 20px;
}
.retro .widgetmenu_item:hover .widgetmenu_item_text {
  filter: drop-shadow(1px 1px 0px var(--menu-point)) drop-shadow(-1px -1px 0px var(--menu-point)) drop-shadow(-1px 1px 0px var(--menu-point)) drop-shadow(1px -1px 0px var(--menu-point));
  background-image: linear-gradient(139deg, var(--menu-base), var(--menu-base));
}
.retro .widgetmenu_item_text::before {
  content: '<?if($css['use_header'][0] == 'R'){
    echo '«';
  } else echo '»';?>';
  position: absolute;
  color: var(--menu-point);
  -webkit-text-fill-color: var(--menu-point);
  <?if($css['use_header'][0] == 'R') echo 'right'; else if($css['use_header'][0] == '') echo 'left'; else echo 'left';?>: -12px;
}
.retro .widgetmenu_item:hover .widgetmenu_item_text::before {
  color: var(--menu-base);
  -webkit-text-fill-color: var(--menu-base);
}
.retro .widgetmenu_main {}
.retro .widgetmenu_main_havesub {}
.retro .widgetmenu_main_havesub .widgetmenu_item_text::before {
  content: '+';
}
.retro .widgetmenu_sub {
  display:none;
  <?if($css['use_header'][0] == 'R') echo 'right'; else if($css['use_header'][0] == '') echo 'left'; else echo 'left';?>: 20px;
}
.retro .widgetmenu_sub.active {
  display:block;
}
.retro .widgetmenu_sub .widgetmenu_item_text::before {
  content: '-';
}
.retro .widgetmenu_side {
  filter: drop-shadow(1px 1px 0px var(--menu-base)) drop-shadow(-1px -1px 0px var(--menu-base)) drop-shadow(-1px 1px 0px var(--menu-base)) drop-shadow(1px -1px 0px var(--menu-base)) drop-shadow(1px 1px 0px var(--menu-text));
}
.retro .widgetmenu_side ul {}
.retro .widgetmenu_side_text {
  filter: drop-shadow(0px 0px 0px var(--menu-text));
}

.retro .widgetmenu_side_menu_box {}
.retro .widgetmenu_side_item {
  transition-duration: var(--animation-length);
  filter: drop-shadow(0px 0px 0px var(--menu-text));
}
.retro .widgetmenu_side_item:hover {
  filter: drop-shadow(3px 3px 0px rgba(0,0,0,0.2));
}
.retro .widgetmenu_side_item_icon {}
.retro .widgetmenu_side_item_text {}

.retro .widgetmenu_bgm_box {}
.retro .widgetmenu_bgm_text {
  filter: drop-shadow(0px 0px 0px var(--menu-text));
}
.retro .widgetmenu_bgm_control {
  transition-duration: var(--animation-length);
  filter: drop-shadow(0px 0px 0px var(--menu-text));
}
.retro .widgetmenu_bgm_control:hover {
  filter: drop-shadow(3px 3px 0px rgba(0,0,0,0.2));
}

<?//iconic 아이콘 스킨?>

.iconic {
  width: 40px;
  background: var(--menu-base);
  border-radius: var(--radius);
  padding: 15px 0px;
  transition-duration: var(--animation-length);
}
.iconic.active {
  width: 120px;
}
.iconic.active .widgetmenu_item{
  margin:3px 8px;
}
.iconic.widgetmenu ul {
  overflow: hidden;
}
.iconic .widgetmenu_list {}
.iconic .widget_a {}
.iconic .widgetmenu_item {
  margin: 3px 8px;
  display: flex;
  flex-direction: row;
  align-items: center;
  height: 24px;
  <?if($css['use_header'][0] == 'R') echo 'justify-content: flex-end;'; else echo 'justify-content: flex-start;'?>
}

.iconic .widgetmenu_item_icon {
  <?if($css['use_header'][0] == '' || $css['use_header'][0] == 'center') echo 'left'; else echo 'right';?>: 0px;
  margin-<?if($css['use_header'][0] == '' || $css['use_header'][0] == 'center') echo 'right'; else echo 'left';?>: 10px;
}
.iconic .widgetmenu_item:hover {
  filter: drop-shadow(0px 0px 3px var(--menu-point));
}
.iconic .widgetmenu_item:hover * {
  color: var(--menu-point);
}

.iconic .widgetmenu_item_text {
  white-space: nowrap;
  width: fit-content;
  padding: 0px 0px;
  text-overflow: ellipsis;
  overflow: hidden;
}

.iconic .widgetmenu_main {}
.iconic .widgetmenu_main_havesub {}
.iconic .widgetmenu_main_havesub::after {
  content: '';
  <?if($css['use_header'][0] == 'R') echo 'left'; else echo 'right';?>: -5px;
  top: calc(50% - 6px);
  position: absolute;
  width: 0px;
  height: 0px;
  border-<?if($css['use_header'][0] == 'R') echo 'right'; else echo 'left';?>: 6px solid var(--menu-point);
  border-<?if($css['use_header'][0] == 'R') echo 'left'; else echo 'right';?>: 5px solid transparent;
  border-bottom: 5px solid transparent;
  border-top: 5px solid transparent;
}
.iconic .widgetmenu_sub {
  display:none;
}
.iconic .widgetmenu_sub.active {
  display: block;
}

.iconic .widgetmenu_sidewindow {
  width: inherit;
  height: fit-content;
  background: linear-gradient(151deg, var(--menu-base), var(--menu-base));
  border-radius: var(--radius);
  overflow: hidden;
  padding: 15px 0px;
  transition-duration: var(--animation-length);
  position: absolute;
  <?if($css['use_header'][0] == 'R') echo 'right'; else if($css['use_header'][0] == '') echo 'left'; else echo 'left';?>: calc(100% + -5px);
  top: -30px;
  box-shadow: 0px 0px 3px rgba(0,0,0,0.1);
  display: none;
  flex-direction: column;
}

.iconic .widgetmenu_sidewindow.active {
  display: flex;
}

.iconic .widgetmenu_side {
  display: flex;
  justify-content: center;
  <?if($css['use_header'][0] == 'R') echo 'align-items: flex-end;'; else echo 'align-items: flex-start;'?>
  flex-direction: column;
  overflow: hidden;
  border-radius: 0px;
}
.iconic .widgetmenu_side ul {
  <?if($css['use_header'][0] == 'R') echo 'align-items: flex-end;'; else echo 'align-items: flex-start;'?>
}
.iconic .widgetmenu_side_text {
  display: none;
}

.iconic .widgetmenu_side_menu_box {
  flex-direction: column;
  align-items: flex-start;
}
.iconic .widgetmenu_side_menu_box::before {
  content: '';
  width: 400px;
  height: 0px;
  border-top: 1px dashed var(--menu-point);
}
.iconic .widgetmenu_side_item {
  width: 100%;
  justify-content: flex-start;
  flex-wrap: nowrap;
  margin: 0px;
}
.iconic .widgetmenu_side_item:hover {
  filter: drop-shadow(0px 0px 3px var(--menu-point));
}
.iconic .widgetmenu_side_item:hover * {
  color: var(--menu-point);
}
.iconic .widgetmenu_side_item a {
display: flex;
    align-items: center;
    justify-content: center;
}
.iconic .widgetmenu_side_item_icon {
  display: inline-block;
  margin: 3px 8px;
}
.iconic .widgetmenu_side_item_text {
  display: inline-block;
  white-space: nowrap;
}


.iconic .widgetmenu_bgm_box {
  width: 40px;
  flex-direction: column;
}
.iconic .widgetmenu_bgm_box::before {
  content: '';
  width: 400px;
  height: 4px;
  border-top: 1px dashed var(--menu-point);
  margin-bottom: 7px;
}
.iconic .widgetmenu_bgm_box a:hover {
  filter: drop-shadow(0px 0px 3px var(--menu-point));
}
.iconic .widgetmenu_bgm_box a:hover * {
  color: var(--menu-point);
}
.iconic.active .widgetmenu_bgm_box {
}
.iconic .widgetmenu_bgm_text {}
.iconic .widgetmenu_bgm_control {}
.iconic #playbtn {}
.iconic 
.iconic #stopbtn {}

.iconic .activebtn {
  display: flex;
}
.iconic .activebtn:hover {
  filter: drop-shadow(0px 0px 3px var(--menu-point));
}
.iconic .activebtn:hover * {
  color: var(--menu-point);
}



<?// iconic_circle 아이콘(동글동글) 스킨?>

.iconic_circle {
  width: 40px;
  padding: 15px 0px;
  transition-duration: var(--animation-length);
  font-family: 'Pretendard-Thin';
  font-weight: bold;
}
.iconic_circle.active .widgetmenu_item_text{
  display: inline-block;
}
.iconic_circle.widgetmenu ul {
}
.iconic_circle .widgetmenu_list {}
.iconic_circle .widget_a {
  <?if($css['use_header'][0] == 'R') echo 'flex-direction: row-reverse;';?>
}
.iconic_circle .widgetmenu_item {
  display: flex;
  flex-direction: row;
  align-items: center;
  justify-content: flex-start;
  border-radius: 100%;
  <?if($css['use_header'][0] == 'R') echo 'flex-direction: row-reverse;';?>
}

.iconic_circle .widgetmenu_item_icon {
  <?if($css['use_header'][0] == '' || $css['use_header'][0] == 'center') echo 'left'; else echo 'right';?>: 0px;
  background: var(--menu-base);
  padding: 8px;
  border-radius: 100%;
  margin-bottom: -12px;
  margin-<?if($css['use_header'][0] == 'R') echo 'left'; else echo 'right';?>: -38px;
}
.iconic_circle .widgetmenu_item:hover * {
  color: var(--menu-point);
}
.iconic_circle .widgetmenu_sub .widgetmenu_item:hover .widgetmenu_item_icon * {
    color: var(--menu-base);
}
.iconic_circle .widgetmenu_item_text {
  white-space: nowrap;
  width: fit-content;
  padding: 0px 0px;
  text-overflow: ellipsis;
  overflow: hidden;
  display: none;
  position: relative;
  <?if($css['use_header'][0] == 'R') echo 'right'; else echo 'left';?>: 50px;
  top: 7px;
}
.iconic_circle.on .widgetmenu_item_text {
  animation: active var(--animation-length);
  animation-fill-mode: forwards;
}
.iconic_circle.off .widgetmenu_item_text {
  animation: active var(--animation-length);
  animation-direction: reverse;
}

@keyframes iconic_circleactive {
  from {
    height: 0;
    opacity: 0;
  }
  to {
    height: 24px;
    opacity: 1;
  }
}

.iconic_circle .widgetmenu_main {}
.iconic_circle .widgetmenu_main_havesub {}
.iconic_circle .widgetmenu_main_havesub::before {
  content: '+';
  position: absolute;
  top: 12px;
  <?if($css['use_header'][0] == 'R') echo 'right'; else if($css['use_header'][0] == '') echo 'left'; else echo 'left';?>: 32px;
  width: 16px;
  font-size: 12px;
  height: 16px;
  border-radius: 100%;
  z-index: 2;
  background: var(--menu-point);
  display: flex;
  justify-content: center;
  align-items: center;
  color: var(--menu-base);
  font-family: LOTTERIACHAB;
  font-weight: normal;
  padding: 0px 1px 1px 0px;
}
.iconic_circle .widgetmenu_main_havesub.active::before {
  content: '-';
}
.iconic_circle .widgetmenu_sub {
  display:none;}
.iconic_circle .widgetmenu_sub.on {
  animation: iconic_circleactive var(--animation-length);
  animation-fill-mode: forwards;
}
.iconic_circle .widgetmenu_sub.off {
  animation: iconic_circleactive var(--animation-length);
  animation-direction: reverse;
}
.iconic_circle .widgetmenu_sub .widgetmenu_item_icon {
  background: var(--menu-point);
}
.iconic_circle .widgetmenu_sub.active {
  display: block;
}

.iconic_circle .widgetmenu_sidewindow {
  width: inherit;
  height: fit-content;
  background: linear-gradient(151deg, var(--menu-base), var(--menu-base));
  border-radius: var(--radius);
  overflow: hidden;
  padding: 15px 0px;
  transition-duration: var(--animation-length);
  position: absolute;
  <?if($css['use_header'][0] == 'R') echo 'right'; else if($css['use_header'][0] == '') echo 'left'; else echo 'left';?>: calc(100% + -5px);
  top: -30px;
  box-shadow: 0px 0px 3px rgba(0,0,0,0.1);
  display: none;
  flex-direction: column;
}

.iconic_circle .widgetmenu_sidewindow.active {
  display: flex;
}

.iconic_circle .widgetmenu_side {
  display: flex;
  justify-content: center;
  align-items: flex-start;
  flex-direction: column;
  border-radius: 0px;
  margin-top: 0px;
}

.iconic_circle .widgetmenu_side ul {
  align-items: flex-start;
}
.iconic_circle .widgetmenu_side_text {
  display: none;
}

.iconic_circle .widgetmenu_side_menu_box {
  flex-direction: column;
  align-items: flex-start;
}
.iconic_circle .widgetmenu_side_item {
  width: 100%;
  justify-content: flex-start;
  flex-wrap: nowrap;
  margin-left: 0px;
  margin-right: 0px;
  margin-bottom: -6px;
}
.iconic_circle .widgetmenu_side_item:hover * {
  color: var(--menu-point);
}
.iconic_circle .widgetmenu_side_item a {
display: flex;
  align-items: center;
  justify-content: center;
  <?if($css['use_header'][0] == 'R') echo 'flex-direction: row-reverse;'?>
}
.iconic_circle .widgetmenu_side_item_icon {
  display: inline-block;
  margin: 3px 0px;
  background: var(--menu-base);
  border-radius: 100%;
  padding: 8px;
}
.iconic_circle .widgetmenu_side_item_text {
  display: inline-block;
  position: relative;
  white-space: nowrap;
  <?if($css['use_header'][0] == 'R') echo 'right'; else echo 'left';?>: 50px;
  <?if($css['use_header'][0] == 'R') echo 'margin-right: -34px;'; else echo 'margin-left: -38px;'?>
  display: none;
}

.iconic_circle.active .widgetmenu_side_item_text {
  display: inline-block;
}
.iconic_circle.on .widgetmenu_side_item_text {
  animation: active var(--animation-length);
  animation-fill-mode: forwards;
}
.iconic_circle.off .widgetmenu_side_item_text {
  animation: active var(--animation-length);
  animation-direction: reverse;
}

.iconic_circle .widgetmenu_bgm_box {
  width: 40px;
  flex-direction: column;
  margin-bottom: -6px;
}
.iconic_circle .widgetmenu_bgm_box a:hover * {
  color: var(--menu-point);
}
.iconic_circle.active .widgetmenu_bgm_box {
}
.iconic_circle .widgetmenu_bgm_text {
  display:none;
}
.iconic_circle .widgetmenu_bgm_control {
  width: 24px;
  height: 24px;
  background: var(--menu-base);
  padding: 8px;
  border-radius: 100%;
}
.iconic_circle #playbtn {
  width: 24px;
  height: 24px;
}
.iconic_circle #stopbtn {
  width: 24px;
  height: 24px;
}

.iconic_circle .activebtn {
  display: flex;
  background: var(--menu-base);
  border-radius: 100%;
  margin-bottom: -9px;
}
.iconic_circle .activebtn:hover * {
  color: var(--menu-point);
}

<?// kitsch 키치 스킨?>

.kitsch {
  font-family: galmuri11;
  font-weight: bold;
}
.kitsch.widgetmenu ul {}
.kitsch .widgetmenu_list {
  border-left: 6px double var(--menu-point);
  box-sizing: border-box;
}
.kitsch .widget_a {
  height: 30px;
  background: var(--menu-base);
  border-radius: var(--radius);
}
.kitsch .widget_a:hover {
  background: var(--menu-point);
}
.kitsch .widget_a:hover widgetmenu_item_text {
  color: var(--menu-base);
}
.kitsch .widget_a:hover .widgetmenu_item_icon {
  animation-name: wobble;
  animation-duration: var(--animation-length);
}
.kitsch .widget_a:hover .widgetmenu_item_icon * {
  color: var(--menu-point);
}
.kitsch .widgetmenu_item {}
.kitsch .widgetmenu_item_icon {
  filter: drop-shadow(1px 1px 0px var(--menu-base)) drop-shadow(-1px -1px 0px var(--menu-base)) drop-shadow(-1px 1px 0px var(--menu-base)) drop-shadow(1px -1px 0px var(--menu-base)) drop-shadow(1px 1px 0px var(--menu-text));
  width: 50px;
  height: 50px;
  position: absolute;
  z-index: 3;
  overflow: visible;
  pointer-events: none;
}

.kitsch .widgetmenu_item_icon .fa-regular,
.kitsch .widgetmenu_item_icon .fa-solid,
.kitsch .widgetmenu_item_icon .fa-brands {
  font-size:37px !important;
}
.kitsch .widgetmenu_item_icon .material-icons {
  font-size:50px;
}

.kitsch .widgetmenu_main {}
.kitsch .widgetmenu_main_havesub {
  
}
.kitsch .widgetmenu_main_havesub::after {
  content: '+';
  width: 12px;
  height: 12px;
  background: var(--menu-point);
  color: var(--menu-base);
  display: flex;
  position: absolute;
  <?if($css['use_header'][0] == 'R') echo 'left'; else echo 'right';?>: -5px;
  z-index: 2;
  border-radius: 100%;
  align-items: center;
  justify-content: center;
  top: -3px;
}
.kitsch .widgetmenu_main_havesub.active::after {
  content: '-';
}
.kitsch .widgetmenu_sub {
  display:none;
}
.kitsch .widgetmenu_sub.on {
  animation: kitschactive var(--animation-length);
  animation-fill-mode: forwards;
}
.kitsch .widgetmenu_sub.off {
  animation: kitschactive var(--animation-length);
  animation-direction: reverse;
}

@keyframes kitschactive {
  from{
    opacity: 0;
    height: 0px;
  }
  to{
    opacity: 1;
    height: 30px;
  }
}

.kitsch .widgetmenu_sub .widget_a {
  background: var(--menu-point);
  color: var(--menu-base);
}
.kitsch .widgetmenu_sub .widget_a:hover {
  background: var(--menu-base);
}
.kitsch .widgetmenu_sub .widget_a:hover widgetmenu_item_text {
  color: var(--menu-text);
}
.kitsch .widgetmenu_sub .widget_a:hover .widgetmenu_item_icon {
  animation-name: wobble;
  animation-duration: var(--animation-length);
}
.kitsch .widgetmenu_sub .widget_a:hover .widgetmenu_item_icon * {
  color: var(--menu-point);
}
.kitsch .widgetmenu_sub.active {
  display:block;
}

.kitsch .widgetmenu_side {}
.kitsch .widgetmenu_side ul {}
.kitsch .widgetmenu_side_text {}

.kitsch .widgetmenu_side_menu_box {}
.kitsch .widgetmenu_side_item {}
.kitsch .widgetmenu_side_item_icon {}
.kitsch .widgetmenu_side_item_text {}

.kitsch .widgetmenu_bgm_box {}
.kitsch .widgetmenu_bgm_text {}
.kitsch .widgetmenu_bgm_control {}

<?// gothic 고딕풍 스킨?>

.gothic {
  font-family: 'NanumSquareNeo';
}
.gothic.widgetmenu ul {
  position:relative;
}
.gothic.widgetmenu > ul::before {
    content: '';
    background: url(https://imgur.com/prUY23j.png);
    width: 100%;
    height: 32px;
    position: absolute;
    display: block;
    top: -35px;
    background-size: contain;
    background-position: top center;
    background-repeat: no-repeat;
    image-rendering: -webkit-optimize-contrast;
}
.gothic.widgetmenu > ul::after {
    content: '';
    background: url(https://imgur.com/prUY23j.png);
    rotate: 180deg;
    width: 100%;
    height: 32px;
    position: absolute;
    display: block;
    bottom: -35px;
    background-size: contain;
    background-position: top center;
    background-repeat: no-repeat;
    image-rendering: -webkit-optimize-contrast;
}
.gothic .widgetmenu_list {}
.gothic .widget_a {
  border-image: url(https://imgur.com/VymWv2H.png);
  height: 40px;
  background: var(--menu-base);
  border-image-width: 100% 40%;
  border-image-slice: 80;
  border-image-repeat: stretch;
}
.gothic .widget_a:hover {
  background: var(--menu-point);
}
.gothic .widgetmenu_item {
  border-radius: var(--radius);
  overflow: hidden;
}
.gothic .widgetmenu_item_icon {
  position: absolute;
  <?if($css['use_header'][0] == 'R') echo 'right'; else echo 'left';?>: 20px;
}
.gothic .widgetmenu_item_text {}

.gothic .widgetmenu_main {}
.gothic .widgetmenu_main_havesub {}
.gothic .widgetmenu_main_havesub .widget_a::after {
  content: '+';
  <?if($css['use_header'][0] == 'R') echo 'left'; else echo 'right';?>: 30px;
  position: absolute;
}
.gothic .widgetmenu_sub.on {
  animation: flipInX var(--animation-length);
}
.gothic .widgetmenu_sub.off {
  animation: flipOutX var(--animation-length);
}
.gothic .widgetmenu_main_havesub.active .widget_a::after {
  content: '-';
}
.gothic .widgetmenu_sub {
  display: none;
}
.gothic .widgetmenu_sub.active {
  display: block;
}
.gothic .widgetmenu_side {
  margin-top: 50px;
}
.gothic .widgetmenu_side ul {}
.gothic .widgetmenu_side_text {}

.gothic .widgetmenu_side_menu_box {}
.gothic .widgetmenu_side_item {}
.gothic .widgetmenu_side_item_icon {}
.gothic .widgetmenu_side_item_text {}

.gothic .widgetmenu_bgm_box {}
.gothic .widgetmenu_bgm_text {}
.gothic .widgetmenu_bgm_control {}


<?// message 메세지 스킨?>

.message {}
.message.widgetmenu ul {
  left: -10px;
  position: relative;
}
.message .widgetmenu_list {
  box-shadow: 0px 0px 3px rgba(0,0,0,0.1);
  filter: drop-shadow(2px 5px 0px rgba(0,0,0,0.1));
}
.message .widget_a {
  background: var(--menu-base);
  height: 30px;
  justify-content: flex-end;
  flex-direction: row-reverse;
}
.message .widgetmenu_item {}
.message .widgetmenu_item_icon {
  scale: 0.8;
}
.message .widgetmenu_item_text {
  padding: 0px 0px 0px 10px;
  width: fit-content;
}

.message .widgetmenu_main .widget_a {
  border-radius: <?if($radius != 0) echo ' var(--radius) var(--radius) var(--radius) 0;'; else echo ' var(--radius);';?>
  border: 1px solid var(--menu-text);
}
.message .widgetmenu_main_havesub .widget_a {
  border-radius: <?if($radius != 0) echo 'var(--radius) var(--radius) var(--radius) 0;'; else echo 'var(--radius);';?>
  border: 1px solid var(--menu-text);
}
.message .widgetmenu_main_havesub .widget_a::after {
  content: '';
  width: 10px;
  height: 10px;
  border-radius: 100%;
  position: absolute;
  top: -1px;
  right: -5px;
  background: var(--menu-point);
  
}
.message .widgetmenu_sub {
  display:none;
  left: 20px;
}
.message .widgetmenu_sub.active {
  display:block;
}
.message .widgetmenu_sub.on {
  animation: fadeInUp var(--animation-length);
}
.message .widgetmenu_sub.off {
  animation: fadeOutDown var(--animation-length);
}
.message .widgetmenu_sub .widget_a {
  border-radius: <?if($radius != 0) echo 'var(--radius) var(--radius) 0 var(--radius);'; else echo 'var(--radius);';?>
  background: var(--menu-point);
  color: var(--menu-base);
  border: 1px solid var(--menu-base);
}

.message .widgetmenu_side {}
.message .widgetmenu_side ul {}
.message .widgetmenu_side_text {
  width: 60%;
  background: var(--menu-point);
  border-radius: var(--radius);
  backdrop-filter: blur(3px);
  border: 1px solid var(--menu-base);
}

.message .widgetmenu_side_menu_box {}
.message .widgetmenu_side_item {}
.message .widgetmenu_side_item_icon {}
.message .widgetmenu_side_item_text {}

.message .widgetmenu_bgm_box {}
.message .widgetmenu_bgm_text {}
.message .widgetmenu_bgm_control {}

.alertboard {
  position: absolute;
  top: -27px;
  height: 20px;
  background: var(--menu-point);
  color: var(--menu-text);
  display: flex;
  align-items: center;
  border-radius: var(--radius);
  width: fit-content;
  padding: 0 20px;
  white-space: nowrap;
  text-overflow: ellipsis;
  overflow: hidden;
  backdrop-filter: blur(4px);
  border: 1px solid var(--menu-base);
  left: -10px;
}


<?//iconic 아이콘 스킨 수평 버전(h)?>

.iconic_h {
  width: fit-content !important;
  height: 40px;
  background: var(--menu-base);
  border-radius: var(--radius);
  transition-duration: var(--animation-length);
  flex-direction: row;
  display: flex;
  align-items: flex-start;
  justify-content: space-evenly;
  margin-top: 0;
  margin-left: 50vw;
  <?if($css['use_header'][0] == 'R') echo 'bottom'; else echo 'top'?>: var(--position);
  transform: translateX(-50%);
  padding: 10px 16px;
}
.iconic_h.active {
  height: 60px;
}
.iconic_h.active .widgetmenu_item{
}
.iconic_h.widgetmenu ul {
  flex-direction: row;
  overflow: hidden;
  height: 40px;
  transition-duration: var(--animation-length);
  margin-right: 10px;
}
.iconic_h.active.widgetmenu ul {
  height: 60px;
}
.iconic_h .widgetmenu_list {
  margin: 0px 5px;
  width: fit-content;
  max-width: 60px;
  min-width: 40px;
}
.iconic_h .widget_a {
  <?if($css['use_header'][0] == 'R' ) echo 'flex-direction: column-reverse;'; else echo 'flex-direction: column;';?>
}
.iconic_h .widgetmenu_item {
}

.iconic_h .widgetmenu_item_icon {
  <?if($css['use_header'][0] == 'R') echo 'right'; else echo 'left';?>: 0px;
  margin: 8px 0px;
}
.iconic_h .widgetmenu_item:hover {
  filter: drop-shadow(0px 0px 3px var(--menu-point));
}
.iconic_h .widgetmenu_item:hover * {
  color: var(--menu-point);
}

.iconic_h .widgetmenu_item_text {
  white-space: nowrap;
  width: fit-content;
  padding: 2px 0px;
  white-space: normal;
  word-break: break-all;
}

.iconic_h .widgetmenu_main {}
.iconic_h .widgetmenu_main_havesub {}
.iconic_h .widgetmenu_main_havesub::after {
  content: '';
  right: 0px;
  <?if($css['use_header'][0] == 'R') echo 'bottom: 30px;'; else echo 'top: 3px;';?>
  position: absolute;
  width: 0px;
  height: 0px;
  border-<?if($css['use_header'][0] == 'R') echo 'bottom'; else echo 'top';?>: 6px solid var(--menu-point);
  border-<?if($css['use_header'][0] == 'R') echo 'top'; else echo 'bottom';?>: 5px solid transparent;
  border-left: 5px solid transparent;
  border-right: 5px solid transparent;
}

.iconic_h .widgetmenu_sub {
  display:none;
}
.iconic_h .widgetmenu_sub.active {
  display: block;
}

.iconic_h .widgetmenu_sidewindow {
  width: fit-content;
  height: 40px;
  background: var(--menu-base);
  border-radius: var(--radius);
  padding: 3px 5px;
  transition-duration: var(--animation-length);
  flex-direction: row;
  display: none;
  justify-content: space-evenly;
  margin-top: 0;
  margin-left: 50%;
  <?if($css['use_header'][0] == 'R') echo 'bottom'; else echo 'top';?>: calc(100% + 7px);
  translate: -50% 0;
  position: absolute;
  left: 0;
  overflow: hidden;
  <?if($css['use_header'][0] == 'R') echo 'align-items: flex-end;'; else echo 'align-items: flex-start;'?>
}

.iconic_h.active .widgetmenu_sidewindow {
  height: 60px;
}

.iconic_h .widgetmenu_sidewindow.active {
  display: flex;
}
.iconic_h .widgetmenu_sidewindow.on {
  animation: <?if($css['use_header'][0] == 'R') echo 'fadeInUp'; else echo 'fadeInDown';?> var(--animation-length);
}
.iconic_h .widgetmenu_sidewindow.off {
  animation: <?if($css['use_header'][0] == 'R') echo 'fadeOutDown'; else echo 'fadeOutUp';?> var(--animation-length);
  padding: 0;
  width:0 !important;
}

.iconic_h .widgetmenu_side {
  display: flex;
  justify-content: center;
  <?if($css['use_header'][0] == 'R') echo 'align-items: flex-end;'; else echo 'align-items: flex-start;'?>
  overflow: hidden;
  border-radius: 0px;
  flex-direction: row;
  margin-top: 0px;
}
.iconic_h .widgetmenu_side ul {
  flex-direction: row;
  <?if($css['use_header'][0] == 'R' ) echo 'align-items: flex-end;'; else echo 'align-items: flex-start;';?>
}
.iconic_h .widgetmenu_side_text {
  display: none;
}

.iconic_h .widgetmenu_side_menu_box {
  justify-content: flex-start;
  top: -5px;
  position: relative;
  <?if($css['use_header'][0] == 'R' ) echo 'align-items: flex-end;'; else echo 'align-items: flex-start;';?>
}
.iconic_h .widgetmenu_side_menu_box::before {
  content: '';
  width: 0px;
  height: 100px;
  border-left: 1px dashed var(--menu-point);
  top: -20px;
  position: absolute;
}
.iconic_h .widgetmenu_side_item {
  width: 100%;
  justify-content: flex-start;
  flex-wrap: nowrap;
  margin: 0px 5px;
  top: 4px;
  position: relative;
  width: 40px;
  <?if($css['use_header'][0] == 'R' ) echo 'flex-direction: column-reverse;'; else echo 'flex-direction: column;';?>
}
.iconic_h .widgetmenu_side_item:hover {
  filter: drop-shadow(0px 0px 3px var(--menu-point));
}
.iconic_h .widgetmenu_side_item:hover * {
  color: var(--menu-point);
}
.iconic_h .widgetmenu_side_item a {
display: flex;
  align-items: center;
  justify-content: center;
  <?if($css['use_header'][0] == 'R' ) echo 'flex-direction: column-reverse;'; else echo 'flex-direction: column;';?>
}
.iconic_h .widgetmenu_side_item_icon {
  margin: 8px 0px;
  display: inline-block;
}
.iconic_h .widgetmenu_side_item_text {
  display: inline-block;
  white-space: nowrap;
  padding: 2px 0px;
}


.iconic_h .widgetmenu_bgm_box {
  padding-right: 8px;
  margin-bottom: 0px;
  position: relative;
  height: 40px;
  transition-duration: var(--animation-length);
}

.iconic_h .widgetmenu_bgm_box::before {
  content: '';
  width: 8px;
  height: 100px;
  border-left: 1px dashed var(--menu-point);
}
.iconic_h .widgetmenu_bgm_box a:hover {
  filter: drop-shadow(0px 0px 3px var(--menu-point));
}
.iconic_h .widgetmenu_bgm_box a:hover * {
  color: var(--menu-point);
}
.iconic_h.active .widgetmenu_bgm_box {
}
.iconic_h .widgetmenu_bgm_text {}
.iconic_h .widgetmenu_bgm_control {}
.iconic_h #playbtn {}
.iconic_h 
.iconic_h #stopbtn {}

.iconic_h .activebtn {
  display: flex;
}
.iconic_h .activebtn:hover {
  filter: drop-shadow(0px 0px 3px var(--menu-point));
}
.iconic_h .activebtn:hover * {
  color: var(--menu-point);
}




<?// 스킨 템플릿 sample 부분을 스킨명으로 변경해서 사용?>

.sample {}
.sample.widgetmenu ul {}
.sample .widgetmenu_list {}
.sample .widget_a {}
.sample .widgetmenu_item {}
.sample .widgetmenu_item_icon {}
.sample .widgetmenu_item_text {}

.sample .widgetmenu_main {}
.sample .widgetmenu_main_havesub {}
.sample .widgetmenu_sub {}

.sample .widgetmenu_side {}
.sample .widgetmenu_side ul {}
.sample .widgetmenu_side_text {}

.sample .widgetmenu_side_menu_box {}
.sample .widgetmenu_side_item {}
.sample .widgetmenu_side_item_icon {}
.sample .widgetmenu_side_item_text {}

.sample .widgetmenu_bgm_box {}
.sample .widgetmenu_bgm_text {}
.sample .widgetmenu_bgm_control {}