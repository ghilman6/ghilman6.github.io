    <header class="main-header">
      <a href="<?= base_url()?>" class="logo">
        <span class="logo-mini"><b><img width="25" height="" src="<?= base_url()?>assets/img/survei.png"  alt="Enterprise"/></b></span>
        <span class="logo-lg"><img width="30" height="" src="<?= base_url()?>assets/img/survei.png"  alt="Enterprise"/> <strong>E-Task</strong></span>
      </a>
      <nav class="navbar navbar-static-top" role="navigation">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </a>
        <?php
        $session = $this->session->userdata('login');

        $perusahaan = $this->model_menu->selectperusahaan($session['id_perusahaan']); ?>
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">

<?php  /*
if(isset($keterangan)){
	$ket =  "( ".$keterangan." )"; 
}else{
	$ket = ''; 
}
*/
?>
           <li class="dropdown">
            <a class="dropdown-toggle" href="#" data-toggle="dropdown">
              <span class="fa fa-key"></span><span class="hidden-xs"> <?= $nm_user ?> <?= @$ket ?></span></a>
              <div class="dropdown-menu" style="padding: 15px; padding-bottom: 10px;">
                <form class="form-horizontal"  method="post" action="<?= base_url()?>index.php/home/update" accept-charset="UTF-8">
                  <input class="form-control login" type="password" name="password_lama" placeholder="Old Password" />
                  <div class="divider"></div>
                  <input class="form-control login" type="password" name="password_baru" placeholder="New Password"/>
                  <div class="divider"></div>
                  <input class="btn btn-warning" type="submit" name="submit" value="Save" />
                </form>
              </div>
            </li>
              <!--<li>
                <a href="<?=base_url()?>md.ttf" > <i class="fa fa-book"></i> <span class="hidden-xs">Font</span></a>
              </li>-->
              <li>
                <a href="<?=base_url()?>welcome/logout" > <i class="fa fa-power-off"></i> <span class="hidden-xs">Logout</span></a>
              </li>
<!--
              <li>
                <a href="#" data-toggle="control-sidebar" > <i class="fa fa-power-off"></i> <span class="hidden-xs">Logout</span></a>
              </li>
            -->

          </ul>
        </div>
      </nav>
    </header>

    
    <div class="loader"></div>
