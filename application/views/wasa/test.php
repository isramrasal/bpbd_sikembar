<!-- Bootstrap CSS-->
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/back-end/plugins/bootstrap/dist/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/back-end/build/css/custom.css">
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/back-end/plugins/dropify/dist/css/dropify.min.css">
<!-- Toastr-->
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/back-end/plugins/toastr/toastr.min.css">
<!-- Fonts-->
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/back-end/plugins/themify-icons/themify-icons.css">
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/back-end/plugins/font-awesome/css/font-awesome.min.css">
 
<!-- jQuery-->
<script type="text/javascript" src="<?=base_url();?>assets/back-end/plugins/jquery/dist/jquery.min.js"></script>
<!-- jquery form -->
<script type="text/javascript" src="<?=base_url('assets/back-end/');?>/plugins/jquery/dist/jquery.form.js"></script>
<!-- Bootstrap JavaScript-->
<script type="text/javascript" src="<?=base_url();?>assets/back-end/plugins/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- toastr-->
<script type="text/javascript" src="<?=base_url();?>assets/back-end/plugins/toastr/toastr.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/back-end/plugins/dropify/dist/js/dropify.min.js"></script>
 
 
<!-- Custom JS-->
<script type="text/javascript">
    var base_url = "<?=base_url('firstpage/');?>";
    var url = "<?=base_url('firstpage/');?>";
    var asset_url = "<?=base_url('assets/back-end/');?>";
    var uri = "<?=$this->uri->segment(2); ?>";
    var image_url = "<?=base_url();?>";
    var default_url = "<?=base_url();?>";
</script>
 
<script src="<?=base_url();?>assets/back-end/build/js/custom.js"></script>
<!-- END STYLE & JAVASCRIPT -->
<div class="page-content container-fluid">
  <div class="widget">
    <div class="widget-body">
      <div class="row mb-15">
        <div class="col-md-6">
          <p class="form-control-static"><i>manajemen konten sistem</i> alumni</p>
        </div>
        <div class="col-md-6">
          <button id="btn-add" onclick="bttn_adding_c_angkatan()" class="btn btn-outline btn-primary"><i class="ti-plus"></i> tambah</button>
        </div>
      </div>
    <div class="row">
    <div class="col-lg-12">
    <div class="row">
        <?php if (empty($angkatan_data)){ ?>
        <div class="col-lg-12" id="error_not_found">
            maaf, tidak ada data {elapsed_time}
        </div>
        <?php } ?>
        <?php for ($i = 0; $i < count($angkatan_data); ++$i) { ?>
        <figure <?php if($angkatan_data[$i]->angkatan=="angkatan_1"){?> class="snip0057 blue" <?php } else { ?> class="snip0057 red" <?php } ?>>
          <figcaption>
            <h2><?php if($angkatan_data[$i]->firstname!=""){ ?><?=$angkatan_data[$i]->firstname;?> <?php } else { ?>firstname zero records {elapsed_time}<?php } ?> <span><?php if($angkatan_data[$i]->lastname!=""){ ?><?=$angkatan_data[$i]->lastname;?> <?php } else { ?>lastname zero records {elapsed_time}<?php } ?> </span></h2>
            <p><?php if($angkatan_data[$i]->biography!=""){ ?><?=$angkatan_data[$i]->biography;?> <?php } else { ?>biography zero records {elapsed_time}<?php } ?></p>
            <div class="icons"><a href="<?php if($angkatan_data[$i]->website!=""){ ?><?=$angkatan_data[$i]->website;?><?php } else { ?>#<?php } ?>"><i class="ion-ios-home"></i></a><a href="<?php if($angkatan_data[$i]->email!=""){ ?><?=$angkatan_data[$i]->email;?><?php } else { ?>#<?php } ?>"><i class="ion-ios-email"></i></a><a href="<?php if($angkatan_data[$i]->phone!=""){ ?><?=$angkatan_data[$i]->phone;?><?php } else { ?>#<?php } ?>"><i class="ion-ios-telephone"></i></a></div>
          </figcaption>
          <div class="image"><img src="<?=base_url(); ?>image/alumni/<?php if($angkatan_data[$i]->img!=""){ ?><?=$angkatan_data[$i]->img;?><?php } else { ?>image404.png<?php } ?>" alt="<?=$angkatan_data[$i]->firstname;?>"/></div>
          <div class="position"><?=$angkatan_data[$i]->angkatan;?></div>
        </figure>
        <?php } ?>
    </div>
  </div>
  </div>
      <nav>
        <?php echo $pagination; ?>
      </nav>
    </div>
  </div>
</div>
<!-- END CONTAINER -->
<!-- modal for adding angkatan -->
<div id="modalform" tabindex="-1" role="dialog" aria-labelledby="myAnimationModalLabel" class="modal animated fadeInLeft bs-example-modal-animation">
<div role="document" class="modal-dialog modal-lg">
    <form method="POST" id="c_angkatan_form" class="form-horizontal" enctype="multipart/form-data">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            <h4 id="myAnimationModalLabel" class="modal-title"></h4>
        </div>
        <div class="modal-body">
          <!-- field by id -->
          <!-- <input type="hidden" value="" name="id" /> -->
          <!-- field form each -->
          <div class="form-body">
            <div class="form-group">
                <label class="control-label col-md-3">nama depan alumni *</label>
                <div class="col-md-9">
                  <input class="form-control" placeholder="nama depan alumni" name="firstname[0]" value=""/>
                  <span id="firstname_0" class="help-block"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">nama belakang alumni *</label>
                <div class="col-md-9">
                  <input class="form-control" placeholder="nama belakang alumni" name="lastname[0]" value=""/>
                  <span id="lastname_0" class="help-block"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">email **</label>
                <div class="col-md-9">
                    <input placeholder="contoh : mnwnbk@gmail.com" name="email[0]" class="form-control"/>
                    <span id="email_0" class="help-block"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">website **</label>
                <div class="col-md-9">
                    <input placeholder="contoh : https://www.instgram.com/nama alumni" name="website[0]" class="form-control"/>
                    <span id="website_0" class="help-block"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">no telp/handphone **</label>
                <div class="col-md-9">
                    <input placeholder="contoh : +6287778784550" name="phone[0]" class="form-control"/>
                    <span id="phone_0" class="help-block"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">angkatan ke **</label>
                <div class="col-md-9">
                    <select name="angkatan[0]" class="form-control">
                        <option value="angkatan_1">Angkatan ke 1</option>
                        <option value="angkatan_2">Angkatan ke 2</option>
                    </select>
                    <span id="angkatan_0" class="help-block"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">biography **</label>
                <div class="col-md-9">
                    <textarea placeholder="deskripsi alumni" name="biography[0]" class="form-control"></textarea>
                    <span id="biography_0" class="help-block"></span>
                </div>
            </div>
            <div class="form-group">
              <label for="fileInputHor" class="col-sm-3 control-label">berkas gambar</label>
              <div class="col-sm-9">
                <input id="fileInputHor" name="file_image[0]" type="file" class="dropify">
                <span id="file_image_0" class="help-block"></span>
              </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"></label>
                <div class="col-sm-9">
                    <p>* <i style="color:red;">harus diisi</i> / ** <i style="color:red;">sangat di anjurkan diisi</i></p>
                <button type="button" onclick="bttn_adding_angkatan_field()" class="btn btn-outline btn-primary"><i class="ti-plus"></i> tambah field</button>
                </div>
            </div>
            <div id="angkatan-form"></div>
        </div>
        <!-- end field form -->
        </div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-raised btn-default"><i class="ti-close"></i> tutup</button>
            <button type="submit" onclick="bttn_save_c_angkatan()" id="btnSave" class="btn btn-raised btn-black"><i class="ti-save"></i> simpan perubahan</button>
        </div>
    </div>
    </form>
</div>
</div>
<!-- end modal -->