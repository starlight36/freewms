<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/

/**
 * 后台页尾
 */
?>
<div class="footerdiv">
  <p class="text"><span>Powered By FreeWMS, Release under BSD Licenses</span></p>
  <p><span class="space">Query DB: <?php echo DB::$querynum; ?>, Run:
  <?php echo get_running_time(); ?>ms
  <?php echo SITE_GZIP ? 'Page Gziped.':''; ?></span></p>
</div>
<script type="text/javascript">setTimeout("HiddenLoadMsg()",1500);</script>
</div>
</body>
</html>