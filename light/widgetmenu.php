<?php
$sql = " select * from {$g5['menu_table']} where me_use = '1' and length(me_code) = '2' order by me_order*1, me_id ";
$result = sql_query($sql, false); 
$count=sql_fetch($sql);
$menu_datas = array();
if($count['me_id']){ 
  
$sql = " select * from {$g5['menu_table']} where me_use = '1' and length(me_code) = '2' order by me_order*1, me_id ";
$result = sql_query($sql, false); 
$menu_datas = array();

for ($i=0; $row=sql_fetch_array($result); $i++) {
  $menu_datas[$i] = $row;
  $sql2 = " select * from {$g5['menu_table']} where me_use = '1' and length(me_code) = '4' and substring(me_code, 1, 2) = '{$row['me_code']}' order by me_order*1, me_id ";
  $result2 = sql_query($sql2);
  for ($k=0; $row2=sql_fetch_array($result2); $k++) {
    $menu_datas[$i]['sub'][$k] = $row2;
  }
}

  foreach( $menu_datas as $row ){
    if( $row['me_name'] == '메뉴설정'){
      $setting_text = $row['me_link'];
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
      if($row['me_order'] != 0 && $row['me_order']){
        $menu_width = $row['me_order'];
      }
      
      continue;
    } else continue;
  }

?>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link href="<?=G5_URL?>/widgetmenu.css.php" type="text/css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/galmuri@latest/dist/galmuri.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<div class="widget_header" id="widget_header">


<div class="mobilebtn" onclick="viewmenu()">
<i class="fa-solid fa-ellipsis-vertical" style="font-size: 18px;" ></i>
</div>

<div id="widgetmenu" class="widgetmenu <?=$menu_type?>" style="<?if($radius != '0')echo '--radius:'.$radius.'px;';?> --animation-length:<?=$animation_length/1000?>s; <?if($menu_width != 0) echo 'width:'.$menu_width.'px;';?>">
	<ul>
			<li class="activebtn" onclick="activemenu()">
        <i class="material-icons">open_with</i>
      </li>
      <?
      $i = 0;
      foreach( $menu_datas as $row ){
          
      if( empty($row) ) continue; 
      else if( $row['me_name'] == '메뉴설정' ) {
        $i++;
        continue;
      }
      
      $img_link='';
      
      if( $row['me_icon'] && strpos($row['me_icon'], '.') != '' ){
        // 이미지에 값이 존재하고 .이 존재하는 이미지 링크라면
      if($row['me_img2']){
      $img_link="<img class='widgetmenu_img' src=\"{$row['me_icon']}\" onmouseenter=\"this.src='{$row['me_img2']}'\" onmouseleave=\"this.src='{$row['me_icon']}'\" >";
      }else{
      $img_link='<img class="widgetmenu_img" src="'.$row['me_icon'].'">';
      }
      } else if ( $row['me_name'] && strpos($row['me_icon'], '.') == '' ) {
        // 이미지에 값이 존재하고 이미지 링크가 아니라면
        $icon_style = explode(' ', $row['me_icon']);
        if ($icon_style[0] == 'duotone' || $icon_style[0] == 'light' || $icon_style[0] == 'regular' || $icon_style[0] == 'solid' || $icon_style[0] == 'thin' || $icon_style[0] == 'brands'){
          $img_link='<i class="fa-'.$icon_style[0].' fa-'.$icon_style[1].'" style="font-size: 20px;"></i>';
        } else {
          $img_link='<i class="material-icons widgetmenu_icon">'.$row['me_icon'].'</i>';
        }
      }

      $me_name = '';
      if(strpos($row['me_name'], 'ㄴ') !== 0){
        // 메인 메뉴
        $me_name = $row['me_name'];

        // 다음 메뉴에 서브가 있는지
        if($menu_datas[$i+1]){
        if(strpos($menu_datas[$i+1]['me_name'], 'ㄴ') === 0){
          $menuitem_type = 'widgetmenu_main_havesub';
        } else {
          $menuitem_type = 'widgetmenu_main';
        }
        } else {
        $menuitem_type = 'widgetmenu_main';
        }
      }else if(strpos($row['me_name'], 'ㄴ') === 0){
        $me_name = substr($row['me_name'], 3);
        $menuitem_type = 'widgetmenu_sub';
      }

      if($member['mb_level']>=$row['me_level']){?>
          <li class="widgetmenu_list <?=$menuitem_type?>" >
              <div class="widgetmenu_item">
                <a <?php if($menuitem_type != 'widgetmenu_main_havesub') echo 'href="'.$row['me_link'].'"';?>  target="_<?=$row['me_target']?>" class="widget_a">
                <?php if($row['me_icon'] || $menu_type == 'iconic_circle'){
                  echo '<div class="widgetmenu_item_icon">';
                  echo $img_link;
                  echo '</div>';}
                  ?>
                <div class="widgetmenu_item_text">
                <?php if($row['me_name']) { echo $me_name; } else echo ''; ?>
                </div>
              </a>
              <div>
            
          </li>
      <?} else if($member['mb_level']<$row['me_level'] && $secret_type == 'false') {?>
        <li class="widgetmenu_list <?=$menuitem_type?>" style="opacity:0.5; pointer-events: none;">
  
              <div class="widgetmenu_item">
                <a href="#"  target="_<?=$row['me_target']?>" class="widget_a">
                <div class="widgetmenu_item_icon">
                <?php if($row['me_icon']) echo $img_link; else echo ''; ?>
                </div>
                <div class="widgetmenu_item_text">
                <?php if($row['me_name']) echo $me_name; else echo ''; ?>
                </div></a>
              <div>
            
          </li>
      <?} else if($secret_type == 'true'){ ?>
      <?}
      $i++;
   }
  }?> 
    
  </ul>

  <div class="widgetmenu_side">
    <ul>
    <? if(defined('_INDEX_')) { ?>
					<? if($config['cf_bgm']) { ?>
						<div id="site_bgm_box">
							<iframe src="./bgm.php" name="bgm_frame" id="bgm_frame" border="0" frameborder="0" marginheight="0" marginwidth="0" topmargin="0" scrolling="no" allowTransparency="true"></iframe>
						</div>
					<? } ?>
				<? } ?>
    <?if ($bgm_type == 'true'){?>
  <li class="widgetmenu_bgm_box">
    <div class="widgetmenu_bgm_text" id="widgetmenu_bgm_text">
      ♬
    </div>
    <div class="widgetmenu_bgm_control">
    <a href="<?=G5_URL?>/bgm.php?action=play" target="bgm_frame" id="playbtn" onclick="return fn_control_bgm('play')" style="display:none;">
    <i class="material-icons playbtn">play_arrow</i>
    </a>
    <a href="<?=G5_URL?>/bgm.php" target="bgm_frame" id="stopbtn" onclick="return fn_control_bgm('stop')">
      <i class="material-icons stopbtn">stop</i>
    </a>
    </div>
  </li>

  <?}?>
  <?if ($is_member){?>
  <li class="widgetmenu_side_text">
      <b><?echo $member['mb_name']?></b> 님
  </li>

  <li class="widgetmenu_side_menu_box">
  <?if($is_admin){?>
  <div class="widgetmenu_side_item" OnClick="window.open('<?=G5_ADMIN_URL?>')">
      <div class="widgetmenu_side_item_icon">
        <i class="material-icons" style="cursor: pointer;">settings</i>
      </div>
      <div class="widgetmenu_side_item_text">관리자</div>
  </div>
  <?}else if($is_member && !$is_admin){?>
  <div class="widgetmenu_side_item">
        <a href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=register_form.php" id="ol_after_info">
          <div class="widgetmenu_side_item_icon">
            <i class="material-icons" style="cursor: pointer;">tune</i>
          </div>
          <div class="widgetmenu_side_item_text">회원정보</div>
        </a>
  </div>
  <?}?>
  <div class="widgetmenu_side_item">
    <a href="<?php echo G5_BBS_URL ?>/logout.php" id="ol_after_logout">
    <div class="widgetmenu_side_item_icon">
      <i class="material-icons" style="cursor: pointer;">logout</i>
    </div>
    <div class="widgetmenu_side_item_text">로그아웃</div>
    </a>
  </div>
  </li>
  <?}else{?>
    <li class="widgetmenu_side_menu_box">

      <div class="widgetmenu_side_item"><a href="<?=G5_BBS_URL?>/login.php">
          <div class="widgetmenu_side_item_icon">
              <i class="material-icons" style="cursor: pointer;">password</i>
          </div>
          <div class="widgetmenu_side_item_text">로그인</div>
      </a>
    </div>
  
  <?if($config['cf_1']){?>
  <div class="widgetmenu_side_item" Onclick="location.href='<?php echo G5_BBS_URL ?>/register.php'">
      <div class="widgetmenu_side_item_icon">
          <i class="material-icons" style="cursor: pointer;">how_to_reg</i>
      </div>
      <div class="widgetmenu_side_item_text">회원가입</div>
  </div>
  <?}?>
  </li>
  <?}?>
  </ul>

</div>
<div class="widgetmenu_sidewindow">
  <div class="sidewindow_close" onclick="sidewindow_close()">
    X
  </div>
</div>
</div>
</div>
<script>
parent.$('#header').hide();
parent.$('.control-mobile-menu').hide();
  function viewmenu() {
    var list = document.querySelector('#widgetmenu');
    if(list.classList.contains('view')){
      list.classList.remove('view');
    } else {
      list.classList.add('view');
    }
  }
  function activemenu() {
    var isContain = document.querySelector('#widgetmenu').classList.contains('active');
    if (isContain == true){
      document.querySelector('#widgetmenu').classList.add('off');
      setTimeout(() => {
        document.querySelector('#widgetmenu').classList.remove('off');
        document.querySelector('#widgetmenu').classList.remove('active');
      }, <?=$animation_length?>);
    } else {
      document.querySelector('#widgetmenu').classList.add('active');
      document.querySelector('#widgetmenu').classList.add('on');
      setTimeout(() => {
        document.querySelector('#widgetmenu').classList.remove('on');
      }, <?=$animation_length?>);
    }
  }
  function sidewindow(menu) {
    var sideWin = document.querySelector('.widgetmenu_sidewindow');
    sideWin.appendChild(menu);
  }
  function sidewindow_close() {
    var sideWin = document.querySelector('.widgetmenu_sidewindow');
    if(sideWin.classList.contains('active')){
      sideWin.classList.remove('active');
    } else {

    }
  }
	  
    function fn_control_bgm(state) {
    const musictxt = document.querySelector('.widgetmenu_bgm_text');
      if(state == 'stop'){
        $('#playbtn').show();
        $('#stopbtn').hide();
        menuPlaying = false;
        musictxt.innerText = '…';
      } else if(state == 'play'){
        $('#playbtn').hide();
        $('#stopbtn').show();
        menuPlaying = true;
        musictxt.innerText = '♬';
      }}

$(document).ready(function() {
  var widgetMenu = document.querySelector('.widgetmenu');
  var horizonswitch = false;

  if (widgetMenu.classList.contains('iconic_h') || horizonswitch == true){
    if (window.innerWidth <= 1000){
      widgetMenu.classList.remove('iconic_h');
      widgetMenu.classList.add('iconic');
        }

    horizonswitch = true;
    var resizeTimer;
    
    window.addEventListener('resize', () => {
      if (resizeTimer != null ) {
          clearTimeout(resizeTimer);
        }
        resizeTimer = setTimeout(() => {
          onResize();
        }, 1000);
      });

    function onResize() {
      if (window.innerWidth <= 1000){
        widgetMenu.classList.remove('iconic_h');
        widgetMenu.classList.add('iconic');
      } else {
        widgetMenu.classList.remove('iconic');
        widgetMenu.classList.add('iconic_h');
        }
      }
  }
  
    const fold = <?=$fold_type?>;
    const mainmenus = document.querySelectorAll('.widgetmenu_main_havesub');
    mainmenus.forEach(function(x, i){
    var submenus = [];
    var j = 0;
    submenus[0] = mainmenus[i].nextElementSibling;
    j++;
    
    while(submenus[j-1].nextElementSibling) {
      if(submenus[j-1].nextElementSibling.className == 'widgetmenu_list widgetmenu_sub'){
        submenus[j] = submenus[j-1].nextElementSibling;
        j++;
        } else break;
    }

    x.addEventListener('click',function(){ 
      var widgetMenu = document.querySelector('.widgetmenu');
      var sideWin = document.querySelector('.widgetmenu_sidewindow');
      var subAll = document.querySelectorAll('.widgetmenu_sub');
      var onMenus = document.querySelectorAll('.widgetmenu_sub.active');
      var menuOnOff = '';
      var onMainMenus =document.querySelectorAll('.widgetmenu_main_havesub.active');

      if(submenus[0].classList.contains('active')){
        menuOnOff = 'on';
      } else {
        menuOnOff = 'off';
      }

      if(widgetMenu.classList.contains('digital') || widgetMenu.classList.contains('iconic') || widgetMenu.classList.contains('iconic_h')){
        if(fold == true){
          // 디지털이라면 이전에 보였던 메뉴를 숨긴다

        subAll.forEach(function(e){
        e.classList.remove('active');
        });
        onMainMenus.forEach(function(e){
          e.classList.remove('active');
        });
        }
      }

        submenus.forEach(function(a){

        if(menuOnOff == 'on'){
        a.classList.add('off');
        if(widgetMenu.classList.contains('digital') || widgetMenu.classList.contains('iconic') || widgetMenu.classList.contains('iconic_h')){
          if(fold == true){
          a.classList.remove('active');
          x.classList.remove('active');
          } else if(fold == false){
            setTimeout(() => {
          a.classList.remove('active');
          x.classList.remove('active');
        }, <?=$animation_length?>);
          }
        } else {
        setTimeout(() => {
          a.classList.remove('active');
          x.classList.remove('active');
        }, <?=$animation_length?>);
        }
        
        setTimeout(() => {
          a.classList.remove('off');
        }, <?=$animation_length?>);
        } else {
        a.classList.add('on');
        a.classList.add('active');
        x.classList.add('active');
        setTimeout(() => {
          a.classList.remove('on');
        }, <?=$animation_length?>);
        }

        // 사이드 윈도우 조절
      if(widgetMenu.classList.contains('digital') || widgetMenu.classList.contains('iconic') || widgetMenu.classList.contains('iconic_h')){
        if(fold == true){
        var onMenus = document.querySelectorAll('.widgetmenu_sub.active');
        if (onMenus.length == 0){
          sideWin.classList.add('off');
          
          setTimeout(() => {
            sideWin.classList.remove('off');
            sideWin.classList.remove('active');
          }, <?=$animation_length?>);

        } else {
          sideWin.classList.add('active');
          sideWin.classList.add('on');
          
          setTimeout(() => {
            sideWin.classList.remove('on');
          }, <?=$animation_length?>);
          
          
        }}}

      });

  
      });

    var widgetMenu = document.querySelector('.widgetmenu');
    if(widgetMenu.classList.contains('digital') || widgetMenu.classList.contains('iconic') ||  widgetMenu.classList.contains('iconic_h')){
      if(fold == true){
        submenus.forEach(function(a){
      sidewindow(a);
      });
      }
      }
      
      if(fold == false){
        submenus.forEach(function(a){
        a.classList.add('active');
        x.classList.add('active');
        });
      }

    });
    var widgetMenu = document.querySelector('.widgetmenu');
    if(widgetMenu.classList.contains('kitsch')) {
      const lists = document.querySelectorAll('.widgetmenu_list .widgetmenu_item_icon');
      lists.forEach(function(list, i){
        var randomdeg = 30 - Math.floor(Math.random() * 60);
        var randomposx = Math.floor(Math.random() * 20);
        var randomposy = Math.floor(Math.random() * 10) - 10;
        list.style.rotate = randomdeg + 'deg';
        if (i % 2 == 0){
          randomposx = randomposx * -1;
          list.style.right = 'unset';
          list.style.left = randomposx + 'px';
          list.style.top = randomposy + 'px';
        } else {
          randomposx = randomposx;
          list.style.left = 'unset';
          list.style.right = randomposx + 'px';
          list.style.top = randomposy + 'px';
        }

      });
    }

    var widgetMenu = document.querySelector('.widgetmenu');

    if (widgetMenu.classList.contains('message') == true){
      var now = new Date();
      var year = now.getFullYear();
      var month = (now.getMonth() + 1);
      var day = now.getDate();

      var dateString = year + '년 ' + month  + '월 ' + day + '일';

      alertboard = document.createElement('div');
      alertboard.setAttribute("class", "alertboard");
      alertboard.innerHTML = "◀ " + dateString;

      widgetMenu.appendChild(alertboard);
    }
    widgetMenu.classList.add('done_loading');
  });



  </script>