<!DOCTYPE html>
<html>
  <head>
    <?= $this->load->view('head'); ?>

  </head>


  <body class="sidebar-mini wysihtml5-supported <?= $this->config->item('color')?>">

    <div class="wrapper">

      <?= $this->load->view('nav'); ?>
      <?= $this->load->view('menu_groups'); ?>
      
      <div class="content-wrapper">

        <section class="content-header">
          <h1>
            Menu Groups
          </h1>
        </section>

        <section class="invoice">
        
            
        <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        
                        <div class="panel-heading">
                            Form Update Menu Groups
                        </div>
                        
                        <div class="panel-body">
                                            <?php                                                        
                                            foreach ($listmenu_groupsselect->result() as $rows); {
                                            ?>
                                            <?php echo validation_errors(); ?>

                                            <?php echo form_open('menu_groups/Update'); ?>
                                            
                                            <div class="form-group">
                                            <label>ID Menu Groups</label>
                                            <input type="text" name="id_menu_groups" class="form-control" placeholder="ID Menu Groups" value="<?= $rows->id_menu_groups?>" readonly>
                                            </div>

                                            <div class="form-group">
                                            <label>Menu Groups</label>
                                            <input type="text" name="nm_menu_groups" class="form-control" placeholder="Name Menu Groups" value="<?= $rows->nm_menu_groups?>">
                                            </div>

                                            <div class="form-group">
                                            <label>Icon</label>
                                            <input type="text" name="icon" class="form-control" placeholder="Icon" value="<?= $rows->icon?>">
                                            </div>   

                                            <div class="form-group">
                                            <label>Position</label>
                                            <input type="text" name="position" class="form-control" placeholder="Position" value="<?= $rows->position?>">
                                            </div>                                            

                                            <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control" name="active">
                                            <option value="1" <?php if ($rows->active == 1){echo set_select('myselect', '1',TRUE);} ?> >Active</option>
                                            <option value="0" <?php if ($rows->active == 0){echo set_select('myselect', '0',TRUE);} ?> >Deactive</option>                                            
                                            </select> 
                                            </div>
                      
                                            <div class="form-group">
                                            <input type="submit" value="Save" class="btn btn-primary">
                                            <a href="<?=base_url();?>menu_groups"><input type="button" value="Cancel" class="btn btn-default"></a>
                                            </div> 
                                            <?php echo form_close(); ?>
                                            <?php } ?>  
                        </div>
                        
                    </div>
                    
                </div>
                
                </div>
                
        </section>
        
      </div>
      
    </div>

    <?= $this->load->view('basic_js'); ?>
    
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
                "scrollX": true
        });
    });
    </script>
  </body>
</html>
