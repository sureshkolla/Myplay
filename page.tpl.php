<?php 
$sidebar_right = render($page['sidebar_right']);
$sidebar_bottom = render($page['sidebar_bottom']);
if ((isset($_GET['mob']) and $_GET['mob']) or arg(0) == 'nodes_mobile') {
  if ($_GET['mob'] == 'pgv3') {
    print '<div class="body-mobile">'.$messages;
    //if (arg(0) == 'user' and (arg(1) == '' or arg(1) == 'register')) 
    if (arg(0) != 'node') print '<h3 class="title">'.$title.'</h3>';
    print str_replace(array('target="_blank"', 'target="_top"'), array('', ''), render($page['content'])).'</div>';  
  } else {
    print '<div id="toolbar" class="top-mobile toolbar overlay-displace-top clearfix"><div id="toolbar-menu-i" class="toolbar-menu clearfix">'.pinitall_helper_mobile_top_out().'</div></div>'; 
    //print '<div class="body-mobile">'.$messages.render($page['content']).'</div>';
    print '<div class="body-mobile">'.$messages;
    //if (arg(0) == 'user' and (arg(1) == '' or arg(1) == 'register')) print '<h1 class="title">'.$title.'</h1>';
    print render($page['content']).'</div>';  
  }
} elseif (isset($_GET['ovr']) and $_GET['ovr'] == 1) {
  print '<div class="ovr"><div class="node_pin_page"><div class="left pin-node">'.render($page['content']).'</div><div class="right"><div class="inn">'.($sidebar_right ? $sidebar_right : '').'</div></div><div class="center">'.($sidebar_bottom ? $sidebar_bottom : '').'</div></div></div>'.pinitall_out_pin_ovr() ;
} elseif (isset($_GET['ovr']) and $_GET['ovr'] == 2) {
  print '<div class="overlay-f"><div class="overlay-block-pos"><div class="overlay-f-block" data-start="1"><div class="tm"><i class="cl fa fa-times"></i></div><h3>'.$title.'</h3><div class="hr"></div><div class="overlay-msg-content">'.'<div class="messages-block">'.$messages.'</div>'.pinitall_del_ovr(pinitall_target_top(render($page['content']))).'</div></div></div></div>';
} else {
print render($page['header']); 
global $base_url, $user;
if (arg(1)) $arg1 = arg(1); else $arg1 = 0;
//if (!isset($page['content']['system_main']['nodes'][$arg1]['#node']->type)) $page['content']['system_main']['nodes'][$arg1]['#node']->type = '';
if (!(isset($page['content']['system_main']['nodes'][$arg1]) and isset($page['content']['system_main']['nodes'][$arg1]['#node']->type))) {
  $page['content']['system_main']['nodes'][$arg1]['#node'] = new stdClass;
  $page['content']['system_main']['nodes'][$arg1]['#node']->type = '';
}

?>
<header>
  <div class="Wrapper">
  <?php if (theme_get_setting('default_logo')) { ?>
        <a href="<?php print check_url($front_page); ?>" title="<?php print $site_name; ?>" rel="home" id="logo"><i class="fa fa-thumb-tack"></i></a>
      <?php } else { ?>
        <a href="<?php print check_url($front_page); ?>" title="<?php print $site_name; ?>" rel="home" id="logo" class="customlogo"><img src="<?php //print $logo; ?>" alt="CriketGems" /></a>
      <?php } ?>
  <div id="menu-wraper" >
    <div class="inn custommenu">  <?php echo render($page['content_bottom']); ?></div>
  </div>
  <?php if ($language->direction) { ?>
    <div id="mobmenu"><i class="fa fa-bars"></i></div>
     <div class="leftHeader">      
      <a href="#" title="" rel="nav" id="nav"><i class="fa fa-bars"></i></a>
      <div class="nav-drop"><?php echo render($page['sidebar_drop_menu']); ?></div>
      <div id="search"<?php if (!theme_get_setting('default_logo')) { print ' class="customlogo"'; } ?>>
        <div class="inn">
          <?php echo render($page['sidebar_search']); ?>
        </div>
      </div>
      <div id="selectmenu">
          <div class="inn custommenu">  <?php echo render($page['content_bottom']); ?></div>
      </div>  
    </div>
    <div class="rightHeader">
      <?php if ($user->uid) { ?>
        <a id="notifications"><i class="fa fa-bell"></i></a>
        <div class="notifications-drop"><div class="inn"><?php render($page['sidebar_drop_block']); echo pinitall_out_drop_block(FALSE, FALSE, FALSE, TRUE); ?></div></div>
        <a id="account" href="<?php echo url('user/'.$user->uid); ?>" class="useraccount"><?php echo $user->name; ?></a>
        <a id="myaccount" href="<?php echo url('user/'.$user->uid); ?>"><?php echo pinitall_helper_const('PINITALL_REPLACE_MY_ACCOUNT'); ?></a>
        <a id="myaccountlogout" href="<?php echo url('user/logout'); ?>"><?php echo pinitall_helper_const('PINITALL_REPLACE_LOG_OUT'); ?></a>
        <a id="userregisterm" class="inovr" href="<?php echo url('user/'.$user->uid); ?>"> </a>
        <?php echo theme('user_picture', array('account' => $user)); ?>
      <?php } else { ?>
        <a id="userlogin" class="inovr" href="<?php echo url('user'); ?>"><?php echo pinitall_helper_const('PINITALL_REPLACE_LOG_IN'); ?></a>
        <a id="userregister" class="inovr" href="<?php echo url('user/register'); ?>"><?php echo pinitall_helper_const('PINITALL_REPLACE_REGISTER'); ?></a>
        <a id="userloginm" class="inovr" href="<?php echo url('user'); ?>"><i class="fa fa-user"></i></a>
        <a id="userregisterm" class="inovr" href="<?php echo url('user/register'); ?>"><i class="fa fa-user-plus"></i></a>
      <?php } ?>
    </div>

   

    <?php } else { ?>
    <div id="mobmenu"><i class="fa fa-bars"></i></div> 

    <div class="leftHeader">   
      <a href="#" title="" rel="nav" id="nav"><i class="fa fa-bars"></i></a>
      <div class="nav-drop"><?php echo render($page['sidebar_drop_menu']); ?></div>
      <div id="search"<?php if (!theme_get_setting('default_logo')) { print ' class="customlogo"'; } ?>>
        <div class="inn">
          <?php echo render($page['sidebar_search']); ?>
        </div>
      </div>
      <div id="selectmenu">
        <div class="inn custommenu">  <?php echo render($page['content_bottom']); ?></div>
      </div>  
    </div>
    <?php } ?>   
    <div class="rightHeader">
      <?php if ($user->uid) { ?>
        <a id="notifications"><i class="fa fa-bell"></i></a>
        <div class="notifications-drop"><div class="inn"><?php render($page['sidebar_drop_block']); echo pinitall_out_drop_block(FALSE, FALSE, FALSE, TRUE); ?></div></div>
        <a id="account" href="<?php echo url('user/'.$user->uid); ?>" class="useraccount"><?php echo pinitall_out_user_name($user); ?></a>
        <a id="myaccount" href="<?php echo url('user/'.$user->uid); ?>"><?php echo pinitall_helper_const('PINITALL_REPLACE_MY_ACCOUNT'); ?></a>
        <a id="myaccountlogout" href="<?php echo url('user/logout'); ?>"><?php echo pinitall_helper_const('PINITALL_REPLACE_LOG_OUT'); ?></a>
        <a id="userregisterm" class="inovr" href="<?php echo url('user/'.$user->uid); ?>"> </a>
        <?php echo theme('user_picture', array('account' => $user)); ?>
      <?php } else { ?>
        <a id="userlogin" class="inovr" href="<?php echo url('user'); ?>"><?php echo pinitall_helper_const('PINITALL_REPLACE_LOG_IN'); ?></a>
        <a id="userregister" class="inovr" href="<?php echo url('user/register'); ?>"><?php echo pinitall_helper_const('PINITALL_REPLACE_REGISTER'); ?></a>
        <a id="userloginm" class="inovr" href="<?php echo url('user'); ?>"><i class="fa fa-user"></i></a>
        <a id="userregisterm" class="inovr" href="<?php echo url('user/register'); ?>"><i class="fa fa-user-plus"></i></a>
      <?php } ?>
    </div>
    <div class="clr"></div>
  </div>

</header>
<article>
    <div class="main">
      <?php if ((
        (arg(0) == 'node' and !arg(1)) or
        (arg(0) == 'taxonomy' and arg(1) == 'term') or
        (arg(0) == 'popular') or
        (arg(0) == 'video') or
        (arg(0) == 'music') or
        (arg(0) == 'gifts') or
        (arg(0) == 'source') or
        (arg(0) == 'search') or
        (arg(0) == 'homefeed')
        ) and !pinitall_is_access_denied()
      ) { ?>
        <?php print pinitall_helper_out_term_title($title, $page); ?>
        <?php print pinitall_helper_out_term_related($page); ?>
        <?php if (isset($messages) and $messages) { print '<div class="messages-block">'.$messages.'</div>'; } ?>

        <?php if (arg(1) == 'term') { print '<h3 class="cat_title">'.pinitall_helper_const('PINITALL_REPLACE_RECENT_PINS').'</h3>'; } ?>
        <div class="pin_page">
          <?php print render($page['content']); ?>
        </div>
      <?php } elseif ((
        (arg(0) == 'user' and is_numeric(arg(1)) and 
        (
          !arg(2) or 
          arg(2) == 'board' or 
          arg(2) == 'likes' or
          arg(2) == 'followers' or 
          arg(3) == 'category' or
          arg(3) == 'users' or
          arg(3) == 'boards'
        ))
        or (arg(0) == 'board' and arg(1) != 'edit' and arg(1) != 'add')
        ) and !pinitall_is_access_denied() 
      ) { ?>
        <?php if (pinitall_is_map()) { ?>
          <?php print pinitall_insert_message(pinitall_insert_menu(render($page['content']), pinitall_tab_menu($tabs)),  ((isset($messages) and $messages) ? '<div class="messages-block">'.$messages.'</div>' : '')) ; ?>
        <?php } else { ?>
          <?php if (isset($messages) and $messages) { print '<div class="messages-block">'.$messages.'</div>'; } ?>
          <?php print pinitall_insert_menu(render($page['content']), pinitall_tab_menu($tabs)) ; ?>
        <?php } ?>
      <?php } elseif ($page['content']['system_main']['nodes'][$arg1]['#node']->type == 'pin' and !pinitall_is_access_denied()) { ?>
        <?php if (isset($messages) and $messages) { print '<div class="messages-block">'.$messages.'</div>'; } ?>
        <div class="node_pin_page pinpager">
          <div class="left pin-node">
            <?php print pinitall_insert_menu(render($page['content']), pinitall_tab_menu($tabs)) ; ?>
          </div>        
          <div class="right">
            <div class="inn">
              <?php if ($sidebar_right) { echo $sidebar_right; } ?>
            </div>
          </div>
          <div class="center">
              <?php if ($sidebar_bottom) { echo $sidebar_bottom; } ?>
          </div>  
        </div>
      <?php } else { ?>
        <?php if (isset($messages) and $messages) { print '<div class="messages-block">'.$messages.'</div>'; } ?>
        <div class="node_pin_page<?php if (!$sidebar_right) { print ' one'; } ?>">
          <div class="pageblk left">
            <div class="inn">
							<div class="tm"><?php if ($action_links) {print '<ul class="action-page-links">'.render($action_links).'</ul>';} print pinitall_tab_menu($tabs); ?></div>
							<h1 class="title"><?php print $title; ?></h1>
							<div class="hr"></div>
							<div class="pageblk-content"><?php print render($page['content']); ?></div>    
							<div class="clr"></div>
            </div>
          </div>
          <?php if ($sidebar_right) {  ?>      
          <div class="pageblkr right">
            <div class="inn">
              <?php print $sidebar_right; ?>  
            </div>
          </div>
          <?php } ?>
        </div>
      <?php } ?>
      
    </div>
</article>
<?php if (!pinitall_is_map()) { ?>
	<footer>
			<div class="footer">
				<div class="inn">
					<hr />
					<div class="fapin"><i class="fa fa-thumb-tack"></i></div>
					<div class="faspin"><i class="fa fa-thumb-tack"></i></div>
					<div class="l">
						<?php print render($page['footer_copyright']); ?>
					</div>
					<div class="r">
						<a href="http://www.themesnap.com/">Drupal theme by ThemeSnap.com</a>
					</div>
					<div class="clr"></div>
				</div>
			</div>
	</footer>
	<?php print pinitall_out_pin_ovr() ?>
	<?php if (user_access('create pin content')) { ?>
		<div class="add_btn drop"><a href="<?php print url('addboardpin'); ?>"><i class="fa fa-plus"></i></a></div>
		<div class="add-drop"><div class="inn"><?php echo render($page['addpin_block']); ?></div></div>
	<?php } else {?>
		<div class="add_btn"><a href="<?php print url('user'); ?>" class="inovr"><i class="fa fa-plus"></i></a></div>
	<?php } ?>
	<div class="scroll_top"><a href="#"><i class="fa fa-arrow-up"></i></a></div>
<?php } ?>
<?php //print '<pre>'. check_plain(print_r($user, 1)) .'</pre>'; ?>
<?php //print '<pre>'. check_plain(print_r($page, 1)) .'</pre>'; 
}//['#views_contextual_links_info']['views_ui']['view']->query->pager->view->style_plugin->row_plugin->nodes[74]
?>