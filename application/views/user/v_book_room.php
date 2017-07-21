<div class="layout-content">
  <div class="layout-content-body">
    <div class="title-bar">
      <h1 class="title-bar-title">
        <span class="d-ib">Booking Ruang</span>
      </h1>
      <p class="title-bar-description">
        <small>Selamat Datang di 
          <a href="<?php echo base_url() ;?>user/home">Sistem Peminjaman Ruang Meeting</a>
        </small>
      </p>
    </div>
    <div class="layout-content-body">
      <div class="row gutter-xs">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Form Booking Ruang
              </h4>
            </div>
              <div class="row">
                <div class="col-md-8">
                  <div class="demo-form-wrapper">
                  <?php if (!empty($alert)) { ?>
                  <div class="alert alert-info">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                    <span class="icon icon-info-circle icon-lg"></span>
                    <small><?php echo $alert ?></small>
                  </div>
                  <?php
                  } 
                  $atributes = array('class' => 'form form-horizontal', 'id' => 'demo-inputmask');
                  echo form_open('user/book_room/search_room/',$atributes);
                  ?>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="form-control-1">Tanggal</label>
                          <div class="col-sm-6">
                            <div class="input-with-icon">
                              <input class="form-control" placeholder="Book Date" type="text" name="tanggal" data-provide="datepicker" data-date-autoclose="true" data-date-format="yyyy-mm-dd" required>
                                <span class="icon icon-calendar input-icon"></span>
                            </div>
                          </div>
                      </div>
                       <div class="form-group">
                        <label class="col-sm-3 control-label" for="form-control-3">Jumlah Peserta</label>
                          <div class="col-sm-6">
                            <input id="form-control-3" class="form-control" type="number" name="jml_psrta" placeholder="Jumlah Peserta" required>
                          <span class="help-block">Input Jumlah Peserta.</span>
                          </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-3 control-label" for="form-control-1">Jam</label>
                          <div class="col-sm-3">
                            <div class="input-with-icon">
                              <input id="form-control-2" class="form-control" name="start_time" type="text" data-inputmask="'alias': 'hh:mm'" required>
                              <span class="help-block">Input start time (hh:mm).</span>
                            </div>
                          </div>
                         <div class="col-sm-3">
                            <div class="input-with-icon">
                              <input id="form-control-2" class="form-control" name="end_time" type="text" data-inputmask="'alias': 'hh:mm'" required>
                              <span class="help-block">Input end time (hh:mm).</span>
                            </div>
                          </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-3">
                          <button type="submit" class="btn btn-primary btn-block">Search Room</button>
                        </div>
                      </div>
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
      <small class="copyright">2017&copy;
        <a href="<?php echo base_url() ;?>user/home">UAS-Pemrograman Web</a>
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