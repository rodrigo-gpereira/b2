<?php

/* new and improved ! now with more querystring stuff ! */

if (!isset($querystring_start)) {
	$querystring_start = '?';
	$querystring_equal = '=';
	$querystring_separator = '&amp;';
}



/* template functions... */


// @@@ These are template tags, you can edit them if you know what you're doing...



/***** About-the-blog tags *****/
/* Note: these tags go anywhere in the template */

function bloginfo($show='') {
	$info = get_bloginfo($show);
	$info = convert_bbcode($info);
	$info = convert_gmcode($info);
	$info = convert_smilies($info);
	echo convert_chars($info, 'html');
}

function bloginfo_rss($show='') {
	$info = strip_tags(get_bloginfo($show));
	echo convert_chars($info, 'unicode');
}

function bloginfo_unicode($show='') {
	$info = get_bloginfo($show);
	echo convert_chars($info, 'unicode');
}

function get_bloginfo($show='') {
	global $siteurl,$blogfilename,$blogname,$blogdescription;
	switch($show) {
		case "url":
			$output = $siteurl."/".$blogfilename;
			break;
		case "name":
			$output = $blogname;
			break;
		case "description":
			$output = $blogdescription;
			break;
	}
	return($output);
}

function single_post_title($prefix = '', $display = 1) {
	global $p;
	if (intval($p)) {
		$post_data = get_postdata($p);
		if ($display) {
			echo $prefix.strip_tags(stripslashes($post_data['Title']));
		} else {
			return strip_tags(stripslashes($post_data['Title']));
		}
	}
}


/***** // About-the-blog tags *****/




/***** Date/Time tags *****/

function the_date($d='',$before='',$after='') {
	global $id, $postdata, $day, $previousday,$dateformat,$newday;
	if ($day != $previousday) {
		echo $before;
		if ($d=='') {
			echo mysql2date($dateformat, $postdata['Date']);
		} else {
			echo mysql2date($d, $postdata['Date']);
		}
		echo $after;
		$previousday = $day;
	}
}

function the_time($d='') {
	global $id,$postdata,$timeformat;
	if ($d=='') {
		echo mysql2date($timeformat, $postdata['Date']);
	} else {
		echo mysql2date($d, $postdata['Date']);
	}
}

function the_weekday() {
	global $weekday,$id,$postdata;	echo $weekday[mysql2date('w', $postdata['Date'])];
}

function the_weekday_date($before='',$after='') {
	global $weekday,$id,$postdata,$day,$previousweekday;
	if ($day != $previousweekday) {
		echo $before;
		echo $weekday[mysql2date('w', $postdata['Date'])];
		echo $after;
		$previousweekday = $day;
	}
}

/***** // Date/Time tags *****/




/***** Author tags *****/

function the_author() {
	global $id,$authordata;
	$i = $authordata['user_idmode'];
	if ($i == 'nickname')	echo $authordata['user_nickname'];
	if ($i == 'login')	echo $authordata['user_login'];
	if ($i == 'firstname')	echo $authordata['user_firstname'];
	if ($i == 'lastname')	echo $authordata['user_lastname'];
	if ($i == 'namefl')	echo $authordata['user_firstname'].' '.$authordata['user_lastname'];
	if ($i == 'namelf')	echo $authordata['user_lastname'].' '.$authordata['user_firstname'];
	if (!$i) echo $authordata['user_nickname'];
}

function the_author_login() {
	global $id,$authordata;	echo $authordata['user_login'];
}

function the_author_firstname() {
	global $id,$authordata;	echo $authordata['user_firstname'];
}

function the_author_lastname() {
	global $id,$authordata;	echo $authordata['user_lastname'];
}

function the_author_nickname() {
	global $id,$authordata;	echo $authordata['user_nickname'];
}

function the_author_ID() {
	global $id,$authordata;	echo $authordata['ID'];
}

function the_author_email() {
	global $id,$authordata;	echo antispambot($authordata['user_email']);
}

function the_author_url() {
	global $id,$authordata;	echo $authordata['user_url'];
}

function the_author_icq() {
	global $id,$authordata;	echo $authordata['user_icq'];
}

function the_author_aim() {
	global $id,$authordata;	echo $authordata['user_aim'];
}

function the_author_yim() {
	global $id,$authordata;	echo $authordata['user_yim'];
}

function the_author_msn() {
	global $id,$authordata;	echo $authordata['user_msn'];
}

function the_author_posts() {
	global $id,$postdata;	$posts=get_usernumposts($postdata['ID']);	echo $posts;
}

/***** // Author tags *****/




/***** Post tags *****/

function the_ID() {
	global $id;
	echo $id;
}

function the_title($before='',$after='') {
	$title = get_the_title();
	$title = convert_bbcode($title);
	$title = convert_gmcode($title);
	$title = convert_smilies($title);
	if ($title) {
		echo convert_chars($before.$title.$after, 'html');
	}
}
function the_title_rss() {
	$title = get_the_title();
	$title = convert_bbcode($title);
	$title = convert_gmcode($title);
	$title = strip_tags($title);
	if (trim($title)) {
		echo convert_chars($title, 'unicode');
	}
}
function the_title_unicode($before='',$after='') {
	$title = get_the_title();
	$title = convert_bbcode($title);
	$title = convert_gmcode($title);
	if (trim($title)) {
		echo convert_chars($before.$title.$after, 'unicode');
	}
}
function get_the_title() {
	global $id,$postdata;
	$output = stripslashes($postdata['Title']);
	return($output);
}

function the_content($more_link_text='(more...)', $stripteaser=0, $more_file='') {
	$content = get_the_content($more_link_text,$stripteaser,$more_file);
	$content = convert_bbcode($content);
	$content = convert_gmcode($content);
	$content = convert_smilies($content);
	$content = convert_chars($content, 'html');
	echo $content;
}
function the_content_rss($more_link_text='(more...)', $stripteaser=0, $more_file='') {
	$content = get_the_content($more_link_text,$stripteaser,$more_file);
	$content = convert_bbcode($content);
	$content = convert_gmcode($content);
	$content = convert_chars($content, 'unicode');
	$content = make_url_footnote($content);
	echo $content;
}
function the_content_unicode($more_link_text='(more...)', $stripteaser=0, $more_file='') {
	$content = get_the_content($more_link_text,$stripteaser,$more_file);
	$content = convert_bbcode($content);
	$content = convert_gmcode($content);
	$content = convert_chars($content, 'unicode');
	echo $content;
}
function get_the_content($more_link_text='(more...)', $stripteaser=0, $more_file='') {
	global $id,$postdata,$more,$c,$withcomments,$page,$pages,$multipage,$numpages;
	global $HTTP_SERVER_VARS, $preview;
	global $querystring_start, $querystring_equal, $querystring_separator;
	$output = '';
	if (($c) || ($withcomments))
		$more="1";
	if ($more_file != '') {
		$file=$more_file;
	} else {
		$file=$HTTP_SERVER_VARS['PHP_SELF'];
	}
	$content=$pages[$page-1];
	$content=explode('<!--more-->', $content);
	if ((preg_match('/<!--noteaser-->/', $postdata['Content']) && ((!$multipage) || ($page==1))))
		$stripteaser=1;
	$teaser=$content[0];
	if (($more) && ($stripteaser))
		$teaser='';
	$output .= $teaser;
	if (count($content)>1) {
		if ($more) {
			$output .= $content[1];
		} else {
			$output .= ' <a href="'.$file.$querystring_start.'p'.$querystring_equal.$id.$querystring_separator.'more'.$querystring_equal.'1">'.$more_link_text.'</a>';
		}
	}
	if ($preview) { // preview fix for javascript bug with foreign languages
		$output =  preg_replace('/\%u([0-9A-F]{4,4})/e',  "'&#'.base_convert('\\1',16,10).';'", $output);
	}
	return($output);
}

function link_pages($before='<br />', $after='<br />', $next_or_number='number', $nextpagelink='next page', $previouspagelink='previous page', $pagelink='%', $more_file='') {
	global $id,$page,$numpages,$multipage,$more;
	global $HTTP_SERVER_VARS;
	global $querystring_start, $querystring_equal, $querystring_separator;
	if ($more_file != '') {
		$file=$more_file;
	} else {
		$file=$HTTP_SERVER_VARS['SCRIPT_NAME'];
	}
	if (($multipage)) { // && ($more)) {
		echo $before;
		if ($next_or_number=='number') {
			for ($i = 1; $i < ($numpages+1); $i = $i + 1) {
				$j=str_replace('%',"$i",$pagelink);
				echo " ";
				if (($i != $page) || ((!$more) && ($page==1)))
					echo '<a href="'.$file.$querystring_start.'p'.$querystring_equal.$id.$querystring_separator.'more'.$querystring_equal.'1'.$querystring_separator.'page'.$querystring_equal.$i.'">';
				echo $j;
				if (($i != $page) || ((!$more) && ($page==1)))
					echo '</a>';
			}
		} else {
			$i=$page-1;
			if ($i)
				echo ' <a href="'.$file.$querystring_start.'p'.$querystring_equal.$id.$querystring_separator.'page'.$querystring_equal.$i.'">'.$previouspagelink.'</a>';
			$i=$page+1;
			if ($i<=$numpages)
				echo ' <a href="'.$file.$querystring_start.'p'.$querystring_equal.$id.$querystring_separator.'page'.$querystring_equal.$i.'">'.$nextpagelink.'</a>';
		}
		echo $after;
	}
}


function previous_post($format='%', $previous='previous post: ', $title='yes', $in_same_cat='no', $limitprev=1, $excluded_categories='') {
	global $tableposts, $id, $postdata, $siteurl, $blogfilename, $querycount;
	global $p, $posts, $posts_per_page, $s;
	global $querystring_start, $querystring_equal, $querystring_separator;

	if(($p) || ($posts_per_page==1)) {
		
		$current_post_date = $postdata['Date'];
		$current_category = $postdata['Category'];

		$sqlcat = '';
		if ($in_same_cat != 'no') {
			$sqlcat = " AND post_category='$current_category' ";
		}

		$sql_exclude_cats = '';
		if (!empty($excluded_categories)) {
			$blah = explode('and', $excluded_categories);
			foreach($blah as $category) {
				$category = intval($category);
				$sql_exclude_cats .= " AND post_category != $category";
			}
		}

		$limitprev--;
		$sql = "SELECT ID,post_title FROM $tableposts WHERE post_date < '$current_post_date' AND post_category > 0 $sqlcat $sql_exclude_cats ORDER BY post_date DESC LIMIT $limitprev,1";

		$query = @mysql_query($sql);
		$querycount++;
		if (($query) && (mysql_num_rows($query))) {
			$p_info = mysql_fetch_object($query);
			$p_title = $p_info->post_title;
			$p_id = $p_info->ID;
			$string = '<a href="'.$pagenow.$querystring_start.'p'.$querystring_equal.$p_id.$querystring_separator.'more'.$querystring_equal.'1'.$querystring_separator.'c'.$querystring_equal.'1">'.$previous;
			if (!($title!='yes')) {
				$string .= stripslashes($p_title);
			}
			$string .= '</a>';
			$format = str_replace('%',$string,$format);
			echo $format;
		}
	}
}

function next_post($format='%', $next='next post: ', $title='yes', $in_same_cat='no', $limitnext=1, $excluded_categories='') {
	global $tableposts, $p, $posts, $id, $postdata, $siteurl, $blogfilename, $querycount;
	global $time_difference;
	global $querystring_start, $querystring_equal, $querystring_separator;
	if(($p) || ($posts==1)) {
		
		$current_post_date = $postdata['Date'];
		$current_category = $postdata['Category'];

		$sqlcat = '';
		if ($in_same_cat != 'no') {
			$sqlcat = " AND post_category='$current_category' ";
		}

		$sql_exclude_cats = '';
		if (!empty($excluded_categories)) {
			$blah = explode('and', $excluded_categories);
			foreach($blah as $category) {
				$category = intval($category);
				$sql_exclude_cats .= " AND post_category != $category";
			}
		}

		$now = date('Y-m-d H:i:s',(time() + ($time_difference * 3600)));

		$limitnext--;
		$sql = "SELECT ID,post_title FROM $tableposts WHERE post_date > '$current_post_date' AND post_date < '$now' AND post_category > 0 $sqlcat $sql_exclude_cats ORDER BY post_date ASC LIMIT $limitnext,1";

		$query = @mysql_query($sql);
		$querycount++;
		if (($query) && (mysql_num_rows($query))) {
			$p_info = mysql_fetch_object($query);
			$p_title = $p_info->post_title;
			$p_id = $p_info->ID;
			$string = '<a href="'.$pagenow.$querystring_start.'p'.$querystring_equal.$p_id.$querystring_separator.'more'.$querystring_equal.'1'.$querystring_separator.'c'.$querystring_equal.'1">'.$next;
			if ($title=='yes') {
				$string .= stripslashes($p_title);
			}
			$string .= '</a>';
			$format = str_replace('%',$string,$format);
			echo $format;
		}
	}
}





function next_posts() { // original by cfactor at cooltux.org
	global $poststart, $postend, $blogfilename, $posts, $m;
	global $posts_per_page;
	global $querystring_start, $querystring_equal, $querystring_separator;
	if (!$m) {
		$poststart_t = $postend;
		if (empty($postend)) $poststart_t = $posts_per_page;
		$postend_t = $poststart_t + $posts_per_page;
		return $blogfilename.$querystring_start.'poststart'.$querystring_equal.$poststart_t.$querystring_separator.'postend'.$querystring_equal.$postend_t;
	} elseif (($m % 100) > 11) {
		$m_t = $m + 89;
		return $blogfilename.$querystring_start.'m'.$querystring_equal.$m_t;
	} else {
		$m_t = $m + 1;
		return $blogfilename.$querystring_start.'m'.$querystring_equal.$m_t;
	}
}

function next_posts_link($label='Next &gt;&gt;') { 
	echo '<a href="' . next_posts() . '">'. $label.'</a>';
}


function previous_posts() { // original by cfactor at cooltux.org
	global $poststart, $postend, $blogfilename, $posts, $m;
	global $posts_per_page;
	global $querystring_start, $querystring_equal, $querystring_separator;
	if (!$m) {
		$poststart_t = $poststart - $posts_per_page;
		if ($poststart_t < 0) $poststart_t = 0;
		$postend_t = $poststart_t + $posts_per_page;
		return $blogfilename.$querystring_start.'poststart'.$querystring_equal.$poststart_t.$querystring_separator.'postend'.$querystring_equal.$postend_t;
	} elseif (($m % 100) < 2) {
		$m_t = $m - 89;
		return $blogfilename.$querystring_start.'m'.$querystring_equal.$m_t;
	} else {
		$m_t = $m - 1;
		return $blogfilename.$querystring_start.'m'.$querystring_equal.$m_t;
	}
} 

function previous_posts_link($label='&lt;&lt; Previous') {
	global $poststart;
	if ($poststart > 0) {
		echo '<a href="' . previous_posts() . '">'. $label.'</a>';
	}
}

/***** // Post tags *****/




/***** Category tags *****/

function the_category() {
	echo convert_chars(get_the_category(), 'html');
}
function the_category_rss() {
	echo convert_chars(strip_tags(get_the_category(), 'xml'));
}
function the_category_unicode() {
	echo convert_chars(get_the_category(), 'unicode');
}
function get_the_category() {
	global $id,$postdata,$tablecategories,$querycount,$cache_categories,$use_cache;
	$cat_ID = $postdata['Category'];
	if ((empty($cache_categories[$cat_ID])) OR (!$use_cache)) {
		$query="SELECT cat_name FROM $tablecategories WHERE cat_ID = '$cat_ID'";
		$result=mysql_query($query);
		$querycount++;
		$myrow = mysql_fetch_array($result);
		$cat_name = $myrow[0];
		$cache_categories[$cat_ID] = $cat_name;
	} else {
		$cat_name = $cache_categories[$cat_ID];
	}
	return(stripslashes($cat_name));
}

function get_the_category_by_ID($cat_ID) {
	global $id,$tablecategories,$querycount,$cache_categories,$use_cache;
	if ((!$cache_categories[$cat_ID]) OR (!$use_cache)) {
		$query="SELECT cat_name FROM $tablecategories WHERE cat_ID = '$cat_ID'";
		$result=mysql_query($query);
		$querycount++;
		$myrow = mysql_fetch_array($result);
		$cat_name = $myrow[0];
		$cache_categories[$cat_ID] = $cat_name;
	} else {
		$cat_name = $cache_categories[$cat_ID];
	}
	return(stripslashes($cat_name));
}

function the_category_ID() {
	global $id,$postdata;	echo $postdata['Category'];
}

function the_category_head($before='',$after='') {
	global $id, $postdata, $currentcat, $previouscat,$dateformat,$newday;
	$currentcat = $postdata['Category'];
	if ($currentcat != $previouscat) {
		echo $before;
		echo get_the_category_by_ID($currentcat);
		echo $after;
		$previouscat = $currentcat;
	}
}

// out of the b2 loop
function dropdown_cats($optionall = 1, $all = 'All') {
	global $cat, $tablecategories, $querycount;
	$query="SELECT * FROM $tablecategories";
	$result=mysql_query($query);
	$querycount++;
	echo "<select name=\"cat\" class=\"postform\">\n";
	if (intval($optionall) == 1) {
		echo "\t<option value=\"all\">$all</option>\n";
	}
	while($row = mysql_fetch_object($result)) {
		echo "\t<option value=\"".$row->cat_ID."\"";
		if ($row->cat_ID == $cat)
			echo ' selected="selected"';
		echo '>'.stripslashes($row->cat_name)."</option>\n";
	}
	echo "</select>\n";
}

// out of the b2 loop
function list_cats($optionall = 1, $all = 'All', $sort_column = 'ID', $sort_order = 'asc', $file = 'blah') {
	global $tablecategories,$querycount;
	global $pagenow;
	global $querystring_start, $querystring_equal, $querystring_separator;
	$file = ($file == 'blah') ? $pagenow : $file;
	$sort_column = 'cat_'.$sort_column;
	$query="SELECT * FROM $tablecategories WHERE cat_ID > 0 ORDER BY $sort_column $sort_order";
	$result=mysql_query($query);
	$querycount++;
	if (intval($optionall) == 1) {
		echo "\t<a href=\"".$file.$querystring_start.'cat'.$querystring_equal.'all">'.$all."</a><br />\n";
	}
	while($row = mysql_fetch_object($result)) {
		echo "\t<a href=\"".$file.$querystring_start.'cat'.$querystring_equal.$row->cat_ID.'">';
		echo stripslashes($row->cat_name)."</a><br />\n";
	}
}

/***** // Category tags *****/




/***** <Link> tags *****/



/***** // <Link> tags *****/




/***** Comment tags *****/

function comments_number($zero='no comment', $one='1 comment', $more='% comments') {
	// original hack by dodo@regretless.com
	global $id,$postdata,$tablecomments,$c,$querycount,$cache_commentsnumber,$use_cache;
	if (empty($cache_commentsnumber[$id]) OR (!$use_cache)) {
		$query="SELECT * FROM $tablecomments WHERE comment_post_ID = $id AND comment_content NOT LIKE '%<trackback />%' AND comment_content NOT LIKE '%<pingback />%'";
		$result=mysql_query($query);
		$number=mysql_num_rows($result);
		$querycount++;
		$cache_commentsnumber[$id] = $number;
	} else {
		$number = $cache_commentsnumber[$id];
	}
	if ($number == 0) {
		$blah = $zero;
	} elseif ($number == 1) {
		$blah = $one;
	} elseif ($number  > 1) {
		$n = $number;
		$more=str_replace('%', $n, $more);
		$blah = $more;
	}
	echo $blah;
}

function comments_link($file='') {
	global $id,$pagenow;
	global $querystring_start, $querystring_equal, $querystring_separator;
	if ($file == '')	$file = $pagenow;
	if ($file == '/')	$file = '';
	echo $file.$querystring_start.'p'.$querystring_equal.$id.$querystring_separator.'c'.$querystring_equal.'1#comments';
}

function comments_popup_script($width=400, $height=400, $file='b2commentspopup.php', $trackbackfile='b2trackbackpopup.php', $pingbackfile='b2pingbackspopup.php') {
	global $b2commentspopupfile, $b2trackbackpopupfile, $b2pingbackpopupfile, $b2commentsjavascript;
	$b2commentspopupfile = $file;
	$b2trackbackpopupfile = $trackbackfile;
	$b2pingbackpopupfile = $pingbackfile;
	$b2commentsjavascript = 1;
	$javascript = "<script language=\"javascript\" type=\"text/javascript\">\n<!--\nfunction b2open (macagna) {\n    window.open(macagna, '_blank', 'width=$width,height=$height,scrollbars=yes,status=yes');\n}\n//-->\n</script>\n";
	echo $javascript;
}

function comments_popup_link($zero='no comment', $one='1 comment', $more='% comments', $CSSclass='') {
	global $id, $b2commentspopupfile, $b2commentsjavascript;
	global $querystring_start, $querystring_equal, $querystring_separator;
	echo '<a href="';
	if ($b2commentsjavascript) {
		echo $b2commentspopupfile.'?p='.$id.'&c=1';
		echo '" onclick="b2open(this.href); return false"';
	} else {
		// if comments_popup_script() is not in the template, display simple comment link
		comments_link();
		echo '"';
	}
	if (!empty($CSSclass)) {
		echo ' class="'.$CSSclass.'"';
	}
	echo '>';
	comments_number($zero, $one, $more);
	echo '</a>';
}

function comment_ID() {
	global $commentdata;	echo $commentdata['comment_ID'];
}

function comment_author() {
	global $commentdata;	echo stripslashes($commentdata['comment_author']);
}

function comment_author_email() {
	global $commentdata;	echo antispambot(stripslashes($commentdata['comment_author_email']));
}

function comment_author_url() {
	global $commentdata;
	$url = trim(stripslashes($commentdata['comment_author_url']));
	$url = (!stristr($url, '://')) ? 'http://'.$url : $url;
	// convert & into &amp;
	$url = preg_replace('#&([^amp\;])#is', '&amp;$1', $url);
	echo $url;
}

function comment_author_email_link($linktext='', $before='', $after='') {
	global $commentdata;
	$email=$commentdata['comment_author_email'];
	if ((!empty($email)) && ($email != '@')) {
		$display = ($linktext != '') ? $linktext : antispambot(stripslashes($email));
		echo $before;
		echo '<a href="mailto:'.antispambot(stripslashes($email)).'">'.$display.'</a>';
		echo $after;
	}
}

function comment_author_url_link($linktext='', $before='', $after='') {
	global $commentdata;
	$url = trim(stripslashes($commentdata['comment_author_url']));
	$url = (!stristr($url, '://')) ? 'http://'.$url : $url;
	if ((!empty($url)) && ($url != 'http://')) {
		$display = ($linktext != '') ? $linktext : stripslashes($url);
		echo $before;
		echo '<a href="'.stripslashes($url).'" target="_blank">'.$display.'</a>';
		echo $after;
	}
}

function comment_author_IP() {
	global $commentdata;	echo stripslashes($commentdata['comment_author_IP']);
}

function comment_text() {
	global $commentdata;
	$comment = stripslashes($commentdata['comment_content']);
	$comment = str_replace('<trackback />', '', $comment);
	$comment = str_replace('<pingback />', '', $comment);
	$comment = convert_chars($comment);
	$comment = convert_bbcode($comment);
	$comment = convert_gmcode($comment);
	$comment = convert_smilies($comment);
	$comment = make_clickable($comment);
	$comment = balanceTags($comment);
	echo $comment;
}

function comment_date($d='') {
	global $commentdata,$dateformat;
	if ($d == '') {
		echo mysql2date($dateformat, $commentdata['comment_date']);
	} else {
		echo mysql2date($d, $commentdata['comment_date']);
	}
}

function comment_time($d='') {
	global $commentdata,$timeformat;
	if ($d == '') {
		echo mysql2date($timeformat, $commentdata['comment_date']);
	} else {
		echo mysql2date($d, $commentdata['comment_date']);
	}
}

/***** // Comment tags *****/



/***** TrackBack tags *****/

function trackback_url($display = 1) {
	global $pathserver, $id;
	$tb_url = $pathserver.'/b2trackback.php?tb_id='.$id;
	if ($display) {
		echo $tb_url;
	} else {
		return $tb_url;
	}
}

function trackback_number($zero='no trackback', $one='1 trackback', $more='% trackbacks') {
	global $id, $tablecomments, $tb, $querycount, $cache_trackbacknumber, $use_cache;
	if (empty($cache_trackbacknumber[$id]) OR (!$use_cache)) {
		$query="SELECT * FROM $tablecomments WHERE comment_post_ID = $id AND comment_content LIKE '%<trackback />%'";
		$result=mysql_query($query);
		$number=mysql_num_rows($result);
		$querycount++;
		$cache_trackbacknumber[$id] = $number;
	} else {
		$number = $cache_trackbacknumber[$id];
	}
	if ($number == 0) {
		$blah = $zero;
	} elseif ($number == 1) {
		$blah = $one;
	} elseif ($number  > 1) {
		$n = $number;
		$more=str_replace('%', $n, $more);
		$blah = $more;
	}
	echo $blah;
}

function trackback_link($file='') {
	global $id,$pagenow;
	global $querystring_start, $querystring_equal, $querystring_separator;
	if ($file == '')	$file = $pagenow;
	if ($file == '/')	$file = '';
	echo $file.$querystring_start.'p'.$querystring_equal.$id.$querystring_separator.'tb'.$querystring_equal.'1#trackback';
}

function trackback_popup_link($zero='no trackback', $one='1 trackback', $more='% trackbacks', $CSSclass='') {
	global $id, $b2trackbackpopupfile, $b2commentsjavascript;
	global $querystring_start, $querystring_equal, $querystring_separator;
	echo '<a href="';
	if ($b2commentsjavascript) {
		echo $b2trackbackpopupfile.'?p='.$id.'&tb=1';
		echo '" onclick="b2open(this.href); return false"';
	} else {
		// if comments_popup_script() is not in the template, display simple comment link
		trackback_link();
		echo '"';
	}
	if (!empty($CSSclass)) {
		echo ' class="'.$CSSclass.'"';
	}
	echo '>';
	trackback_number($zero, $one, $more);
	echo '</a>';
}

function trackback_rdf($timezone=0) {
	global $pathserver, $id, $HTTP_SERVER_VARS;
	if (!stristr($HTTP_SERVER_VARS['HTTP_USER_AGENT'], 'W3C_Validator')) {
		echo '<rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" '."\n";
		echo '    xmlns:dc="http://purl.org/dc/elements/1.1/">'."\n";
		echo '<rdf:Description'."\n";
		echo '    about="'.$pathserver.'/b2trackback.php?tb_id='.$id.'"'."\n";
		echo '    dc:title="'.addslashes(get_the_title()).'"'."\n";
		echo '    dc:identifier="';
		permalink_single();
		echo '"'."\n";
		echo '    dc:subject="'.addslashes(get_the_category()).'"'."\n";
		echo '    dc:description="';
		$blahblah = strip_tags(get_the_content());
		$blahblah = (strlen($blahblah) > 255) ? substr(addslashes($blahblah), 0, 252).'...' : $blahblah;
		echo $blahblah.'"'."\n";
		echo '    dc:creator="';
		the_author();
		echo '"'."\n";
		echo '    dc:date="';
		the_time('Y-m-dH:i:s');
		$sign = ($timezone >= 0) ? '+' : '-';
		echo $sign.zeroise(intval($timezone),2).':00" />'."\n";
		echo '</rdf:RDF>';
	}
}

/***** // TrackBack tags *****/



/***** PingBack tags *****/

function pingback_number($zero='no pingback', $one='1 pingback', $more='% pingbacks') {
	global $id, $tablecomments, $tb, $querycount, $cache_pingbacknumber, $use_cache;
	if (empty($cache_pingbacknumber[$id]) OR (!$use_cache)) {
		$query="SELECT * FROM $tablecomments WHERE comment_post_ID = $id AND comment_content LIKE '%<pingback />%'";
		$result=mysql_query($query);
		$number=mysql_num_rows($result);
		$querycount++;
		$cache_pingbacknumber[$id] = $number;
	} else {
		$number = $cache_pingbacknumber[$id];
	}
	if ($number == 0) {
		$blah = $zero;
	} elseif ($number == 1) {
		$blah = $one;
	} elseif ($number  > 1) {
		$n = $number;
		$more=str_replace('%', $n, $more);
		$blah = $more;
	}
	echo $blah;
}

function pingback_link($file='') {
	global $id,$pagenow;
	global $querystring_start, $querystring_equal, $querystring_separator;
	if ($file == '')	$file = $pagenow;
	if ($file == '/')	$file = '';
	echo $file.$querystring_start.'p'.$querystring_equal.$id.$querystring_separator.'pb'.$querystring_equal.'1#pingbacks';
}

function pingback_popup_link($zero='no pingback', $one='1 pingback', $more='% pingbacks', $CSSclass='') {
	global $id, $b2pingbackpopupfile, $b2commentsjavascript;
	global $querystring_start, $querystring_equal, $querystring_separator;
	echo '<a href="';
	if ($b2commentsjavascript) {
		echo $b2pingbackpopupfile.'?p='.$id.'&tb=1';
		echo '" onclick="b2open(this.href); return false"';
	} else {
		// if comments_popup_script() is not in the template, display simple comment link
		pingback_link();
		echo '"';
	}
	if (!empty($CSSclass)) {
		echo ' class="'.$CSSclass.'"';
	}
	echo '>';
	pingback_number($zero, $one, $more);
	echo '</a>';
}



/***** // PingBack tags *****/



/***** Permalink tags *****/

function permalink_anchor($mode = 'id') {
	global $id, $postdata;
	switch(strtolower($mode)) {
		case 'title':
			$title = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $postdata['Title']);
			echo '<a name="'.$title.'"></a>';
			break;
		case 'id':
		default:
			echo '<a name="'.$id.'"></a>';
			break;
	}
}

function permalink_link($file='', $mode = 'id') {
	global $id, $postdata, $pagenow, $cacheweekly;
	global $querystring_start, $querystring_equal, $querystring_separator;
	$file = ($file=='') ? $pagenow : $file;
	switch(strtolower($mode)) {
		case 'title':
			$title = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $postdata['Title']);
			$anchor = $title;
			break;
		case 'id':
		default:
			$anchor = $id;
			break;
	}
	$archive_mode = get_settings('archive_mode');
	switch($archive_mode) {
		case 'daily':
			echo $file.$querystring_start.'m'.$querystring_equal.substr($postdata['Date'],0,4).substr($postdata['Date'],5,2).substr($postdata['Date'],8,2).'#'.$anchor;
			break;
		case 'monthly':
			echo $file.$querystring_start.'m'.$querystring_equal.substr($postdata['Date'],0,4).substr($postdata['Date'],5,2).'#'.$anchor;
			break;
		case 'weekly':
			if((!isset($cacheweekly)) || (empty($cacheweekly[$postdata['Date']]))) {
				$sql = "SELECT WEEK('".$postdata['Date']."')";
				$result = mysql_query($sql);
				$row = mysql_fetch_row($result);
				$cacheweekly[$postdata['Date']] = $row[0];
			}
			echo $file.$querystring_start.'m'.$querystring_equal.substr($postdata['Date'],0,4).$querystring_separator.'w'.$querystring_equal.$cacheweekly[$postdata['Date']].'#'.$anchor;
			break;
		case 'postbypost':
			echo $file.$querystring_start.'p'.$querystring_equal.$id;
			break;
	}
}

function permalink_single($file='') {
	global $id,$postdata,$pagenow;
	global $querystring_start, $querystring_equal, $querystring_separator;
	if ($file=='')
		$file=$pagenow;
	echo $file.$querystring_start.'p'.$querystring_equal.$id.$querystring_separator.'more'.$querystring_equal."1";
}

function permalink_single_rss($file='b2rss.xml') {
	global $id,$postdata,$pagenow,$siteurl,$blogfilename;
	global $querystring_start, $querystring_equal, $querystring_separator;
		echo $siteurl.'/'.$blogfilename.$querystring_start.'p'.$querystring_equal.$id.$querystring_separator.'c'.$querystring_equal.'1';
}

/***** // Permalink tags *****/




// @@@ These aren't template tags, do not edit them

function start_b2() {
	global $row, $id, $postdata, $authordata, $day, $preview, $page, $pages, $multipage, $more, $numpages;
	global $preview_userid,$preview_date,$preview_content,$preview_title,$preview_category,$preview_notify,$preview_make_clickable,$preview_autobr;
	global $pagenow;
	global $HTTP_GET_VARS;
	if (!$preview) {
		$id = $row->ID;
		$postdata=get_postdata2($id);
	} else {
		$id = 0;
		$postdata = array (
			'ID' => 0, 
			'Author_ID' => $HTTP_GET_VARS['preview_userid'],
			'Date' => $HTTP_GET_VARS['preview_date'],
			'Content' => $HTTP_GET_VARS['preview_content'],
			'Title' => $HTTP_GET_VARS['preview_title'],
			'Category' => $HTTP_GET_VARS['preview_category'],
			'Notify' => 1,
			'Clickable' => 1,
			'Karma' => 0 // this isn't used yet
			);
		if (!empty($HTTP_GET_VARS['preview_autobr'])) {
			$postdata['Content'] = autobrize($postdata['Content']);
		}
	}
	$authordata = get_userdata($postdata['Author_ID']);
	$day = mysql2date('d.m.y',$postdata['Date']);
	$currentmonth = mysql2date('m',$postdata['Date']);
	$numpages=1;
	if (!$page)
		$page=1;
	if (isset($p))
		$more=1;
	$content = $postdata['Content'];
	if (preg_match('/<!--nextpage-->/', $postdata['Content'])) {
		if ($page > 1)
			$more=1;
		$multipage=1;
		$content=stripslashes($postdata['Content']);
		$content = str_replace("\n<!--nextpage-->\n", '<!--nextpage-->', $content);
		$content = str_replace("\n<!--nextpage-->", '<!--nextpage-->', $content);
		$content = str_replace("<!--nextpage-->\n", '<!--nextpage-->', $content);
		$pages=explode('<!--nextpage-->', $content);
		$numpages=count($pages);
	} else {
		$pages[0]=stripslashes($postdata['Content']);
		$multipage=0;
	}
	return true;
}

function is_new_day() {
	global $day, $previousday;
	if ($day != $previousday) {
		return(1);
	} else {
		return(0);
	}
}

?>