<?php /* Don't remove this line, it calls the b2 function files ! */
$blog=1; include ("blog.header.php"); while($row = mysql_fetch_object($result)) { start_b2();
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $blogname ?> - trackbacks on '<?php the_title() ?>'</title>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="reply-to" content="you@yourdomain.com" />
<meta http-equiv="imagetoolbar" content="no" />
<meta content="TRUE" name="MSSmartTagsPreventParsing" />

<style type="text/css" media="screen">
@import url( layout2b.css );
</style>
<link rel="stylesheet" type="text/css" media="print" href="print.css" />
<link rel="alternate" type="application/rdf+xml" title="RDF" href="<?php bloginfo('rdf_url'); ?>" />
<link rel="alternate" type="application/rss+xml" title="RSS" href="<?php bloginfo('rss2_url'); ?>" />
</head>
<body>
<div id="header"><a title="<?php echo $blogname ?>"><?php echo $blogname ?></a></div>

<div id="contentcomments">

<div class="storyContent">

<p>
The URL to TrackBack this entry is:<br />
&nbsp;&nbsp;<em><?php trackback_url() ?></em>
</p>

	<?php /* do not delete this line */ $queryc = "SELECT * FROM $tablecomments WHERE comment_post_ID = $id AND comment_content LIKE '%<trackback />%' ORDER BY comment_date"; $resultc = mysql_query($queryc); if ($resultc) { ?>

<a name="trackbacks"></a>
<p>&nbsp;</p>
<div><strong><span style="color: #0099CC">::</span> trackbacks</strong></div>
<p>&nbsp;</p>

	<?php /* this line is b2's motor, do not delete it */ $wxcvbn_tb=0; while($rowc = mysql_fetch_object($resultc)) { $commentdata = get_commentdata($rowc->comment_ID); $wxcvbn_tb++; ?>
	
<a name="tb<?php comment_ID() ?>"></a>
	
<!-- trackback -->
<p>
<?php comment_text() ?>
<br />
<strong><span style="color: #0099CC">&middot;</span></strong>
<em>Tracked on <a href="<?php comment_author_url(); ?>" title="<?php comment_author() ?>"><?php comment_author() ?></a> on <?php comment_date() ?> @ <?php comment_time() ?></em>
</p>
<p>&nbsp;</p>
<!-- /trackback -->


	<?php /* end of the loop, don't delete */ }
	if (!$wxcvbn_tb) { ?>

<!-- this is displayed if there are no trackbacks so far -->
<p>No Trackback on this post so far.</p>

	<?php /* if you delete this the sky will fall on your head */ } ?>

<p>&nbsp;</p>
<div><b><span style="color: #0099CC">::</span> <a href="javascript:window.close()">close this window</a></b></div>

	<?php /* if you delete this the sky will fall on your head */ } ?>

</div>

	<?php /* this is just the end of the motor - don't touch that line either :) */ } ?> 

</div>

<p class="centerP">
[powered by <a href="http://cafelog.com" target="_blank"><b>b2</b></a>.]
</p>


</body>
</html>