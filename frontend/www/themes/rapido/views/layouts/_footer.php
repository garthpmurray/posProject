<!-- start: FOOTER -->
<footer class="inner">
	<div class="footer-inner">
		<div class="pull-left">
			<?= date('Y') ?> &copy; Signage 360 by Sourcetoad.
		</div>
		<div class="pull-right">
			<span class="go-top"><i class="fa fa-chevron-up"></i></span>
		</div>
	</div>
</footer>
<!-- end: FOOTER -->


<script>
	jQuery(document).ready(function() {
		Main.init();
		<?php
    		if(isset($this->formElements) && $this->formElements){
    		    echo 'FormElements.init();';
		    }
		    if(isset($this->pagesProfile) && $this->pagesProfile){
    		    echo 'PagesUserProfile.init();';
		    }
		?>
		
/* 		Index.init(); */
	});
</script>
