<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = 'ผู้พัฒนาระบบ';
?>
<!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="<?= Yii::getAlias('@web') ?>/web/image/maleuser.jpg" alt="User profile picture">

              <h3 class="profile-username text-center">วิษณุ กาศไธสง</h3>

              <p class="text-muted text-center">MGS IT Solution</p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                    <b>FB</b> <a class="pull-right" href="https://www.facebook.com/wissanu" target="_blank">https://www.facebook.com/wissanu</a>
                </li>
                <li class="list-group-item">
                  <b>Line</b> <a class="pull-right">085-0970766</a>
                </li>
                <li class="list-group-item">
                  <b>E-Mail</b> <a class="pull-right">mgsitsolution@gmail.com</a>
                </li>
              </ul>

              <a href="https://www.facebook.com/wissanu" target="_blank" class="btn btn-primary btn-block"><b>Follow</b></a>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- About Me Box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">About Me</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <strong><i class="fa fa-book margin-r-5"></i> Education</strong>

              <p class="text-muted">
                คณะสารสนเทศศาสตร์ สาขาเทคโนโลยีคอมพิวเตอร์ วิทยาลัยนครราชสีมา
              </p>

              <hr>

              <strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>

              <p class="text-muted">โนนสูง, นครราชสีมา</p>

              <hr>

              <strong><i class="fa fa-pencil margin-r-5"></i> Skills</strong>

              <p>
                <span class="label label-danger">Mikrotik</span>
                <span class="label label-success">Coding</span>
                <span class="label label-info">Javascript</span>
                <span class="label label-warning">PHP</span>
                <span class="label label-primary">C#</span>
                <span class="label label-success">Network</span>
                <span class="label label-danger">Fiber Optic Tools & Tester</span>
              </p>

              <hr>

              <strong><i class="fa fa-file-text-o margin-r-5"></i> Notes</strong>

              <p>-</p>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <?php /*
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#wifi" data-toggle="tab">ระบบ WIFI Hotspot</a></li>
              <li><a href="#cctv" data-toggle="tab">CCTV</a></li>
              <li><a href="#access" data-toggle="tab">Access Control</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="wifi">
                  <div>
                      WIFI Hotspot
                  </div>

              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="cctv">
                 <div>
                      CCTV
                  </div>                
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="access">
                 <div>
                      Access Control
                  </div>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
         * 
         */?>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->