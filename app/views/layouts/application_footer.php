<!-- page end -->
<?php if (isset($_SESSION['user_id']) && $has_secondary_menu) { // Secondary menu END ?>
  </div>
</div>
<?php } ?>
    <hr/>
    <footer>
      <div class="contacts align-center">
        <span class="contact">Phone: (123) 456-7890</span>
        <span class="contact"><a href="mailto:info@ktv.by">E-mail: info@ktv.by</a></span>
      </div>
      <div class="align-center">&copy; <a href="http://www.ktv.by/">TeleSputnik Ltd.</a>, 2011-<?php echo date('Y'); ?></div>
    </footer>
  </div>
  <!-- Yandex.Metrika counter --><script type="text/javascript">(function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter22989304 = new Ya.Metrika({id:22989304, webvisor:true, clickmap:true, trackLinks:true, accurateTrackBounce:true}); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks");</script><noscript><div><img src="//mc.yandex.ru/watch/22989304" style="position:absolute; left:-9999px;" alt="" /></div></noscript><!-- /Yandex.Metrika counter -->
  
<form action="<?php echo '/feedback?back_url='.base64_encode($_SERVER['REQUEST_URI']) ?>" method="post">
<div id="feedback-popup" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Message Us</h3>
  </div>
  <div class="modal-body">

  <div class="form-horizontal">
<?php 
  $read_only = false;
  if (!isset($message)) $message = null;
  echo text_field($message, "phone", "Phone", array('required' => true), array('class' => 'phone-number input-medium'));
  echo text_area_field($message, "comment", "Message", array('required' => true), array('class' => 'input-xlarge','rows' => 5));
?>
  </div>
  
  </div>
  <div class="modal-footer">
    <button data-dismiss="modal" aria-hidden="true" class="btn">Close</button>
    <input type="submit" value="Send" class="btn btn-primary">
  </div>
</div>
</form>

<form action="<?php echo '/subscribe?back_url='.base64_encode($_SERVER['REQUEST_URI']) ?>" method="post">
<div id="subscribe-popup" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Try 30 days for free</h3>
  </div>
  <div class="modal-body">

  <div class="form-horizontal">
<?php 
  $read_only = false;
  if (!isset($message)) $message = null;
  echo text_field($message, "phone", "Phone", array('required' => true), array('class' => 'phone-number input-medium'));
  echo text_field($message, "address", "Address", array('required' => true), array('class' => 'input-xlarge'));
  echo text_area_field($message, "comment", "Message", null, array('class' => 'input-xlarge','rows' => 5));
?>
  </div>
  
  </div>
  <div class="modal-footer">
    <button data-dismiss="modal" aria-hidden="true" class="btn">Close</button>
    <input type="submit" value="Send" class="btn btn-primary">
  </div>
</div>
</form>

<div id="feedback" class="hidden-phone">
  <a href="#feedback-popup" class="btn btn-danger" role="button" data-toggle="modal">Message Us</a>
</div>

</body>
