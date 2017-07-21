<div class="layout-content">
  <div class="layout-content-body">
    <div class="title-bar">
      <h1 class="title-bar-title">
        <span class="d-ib">Lihat Profile</span>
      </h1>
      <p class="title-bar-description">
         <a href="<?php echo base_url() ;?>admin/home">Sistem Peminjaman Ruang Meeting </a>
      </p>
    </div>
    <div class="layout-content-body">
      <div class="row gutter-xs">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">User Account
              </h4>
            </div>
              <div class="row">
                <div class="col-md-8">
                  <div class="demo-form-wrapper">
                    <?php echo form_open('admin/edit_profil');?>
                    <form class="form form-horizontal" id="demo-inputmask">
                    <?php foreach ($data as $row) : ?>
                      <div class="form-group">
                        <label class="col-sm-3 control-label">Nama</label>
                        <div class="col-sm-9">
                          <p class="form-control-static"><?php echo $this->session->userdata('nama'); ?></p>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-3 control-label">Departemen</label>
                        <div class="col-sm-9">
                          <p class="form-control-static"><?php echo $this->session->userdata('departemen'); ?></p>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-3 control-label">Email</label>
                        <div class="col-sm-9">
                          <p class="form-control-static"><?php echo $this->session->userdata('email'); ?></p>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-3 control-label">No.Telp</label>
                        <div class="col-sm-9">
                          <p class="form-control-static"><?php echo $this->session->userdata('no_telp'); ?></p>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-3 control-label">Username</label>
                        <div class="col-sm-9">
                          <p class="form-control-static"><?php echo $this->session->userdata('username'); ?></p>
                        </div>
                      </div>
                    <?php endforeach ;?>  
                    </form>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="layout-footer">
    <div class="layout-footer-body">
      <small class="copyright">2016 &copy; By 
        <a href="#">Rendy Prakosa
        </a>
      </small>
    </div>
  </div>
  <script src="<?php echo base_url() ?>asset/js/vendor.min.js"></script>
  <script src="<?php echo base_url() ?>asset/js/elephant.min.js"></script>
  <script src="<?php echo base_url() ?>asset/js/application.min.js"></script>
  <script src="<?php echo base_url() ?>asset/js/demo.min.js"></script>
  <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','../../../www.google-analytics.com/analytics.js','ga');
      ga('create', 'UA-83990101-1', 'auto');
      ga('send', 'pageview');
  </script>
  </body>
<!-- Mirrored from demo.naksoid.com/elephant/flatistic-green/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 13 Nov 2016 06:10:08 GMT -->
</html>
