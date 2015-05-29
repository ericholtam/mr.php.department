<?php $this->view('partials/head', array(
	"scripts" => array(
		"clients/client_list.js"
	)
)); ?>

<div class="container">

  <div class="row">

    <?php $this->view('widgets/department_widget'); ?>
  </div> <!-- /row -->

  <div class="row">

    

  </div> <!-- /row -->


</div>  <!-- /container -->

<?php $this->view('partials/foot'); ?>