	</div>
	<div class="footer bg-lgh xt pd20">
		<?php if(defined('DEBUG_TIME')): ?>
			Generated the page in <?= round((microtime(true) - DEBUG_TIME) * 1000) ?>ms.
		<?php endif ?>
	</div>
</body>
</html>