</div>
</section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> <?=$myConfig->app_version?>
    </div>
    <strong>Copyright &copy; <?=date("Y")?> <a href="<?=$myConfig->app_developer_link?>"><?=$myConfig->app_developer_name?></a>.</strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?=site_url("public/assets/plugins/jquery/jquery.min.js")?>"></script>
<!-- Bootstrap 4 -->
<script src="<?=site_url("public/assets/plugins/bootstrap/js/bootstrap.bundle.min.js")?>"></script>
<!-- AdminLTE App -->
<script src="<?=site_url("public/assets/js/adminlte.min.js")?>"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?=site_url("public/assets/js/demo.js")?>"></script>
  <?php
    if(isset($js_links)){
      foreach($js_links as $key => $js){
        ?>
          <script src="<?=$js?>" type="text/javascript"></script>
        <?php
      }
    }
  ?>
  <?php 
    if(isset($js_files)){
      foreach($js_files as $key => $js){
        ?>
          <script src="<?=site_url($js)?>" type="text/javascript"></script>
        <?php
      }
    }
  ?>
  <?php 
    foreach($gc_js_files as $file){
      ?>
        <script src="<?php echo str_replace(base_url("grocery-crud"),base_url("public/grocery-crud"),$file); ?>"></script>
      <?php
    }
  ?>
  <?php 
    if(isset($scripts_footer)){
      foreach($scripts_footer as $key => $js){
        echo $js;
      }
    }
  ?>
  
</body>
</html>
