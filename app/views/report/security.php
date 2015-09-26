<?php $this->view('partials/head', array(
	"scripts" => array(
		"clients/client_list.js"
	)
)); ?>

<div class="container">

  <div class="row">

    <?php $this->view('malware_widget', array(), conf('module_path') . 'savingthrow/views/'); ?>


  </div> <!-- /row -->

</div>  <!-- /container -->

<?php $this->view('partials/foot'); ?>
