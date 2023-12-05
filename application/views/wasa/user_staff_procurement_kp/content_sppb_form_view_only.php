<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
		<h2>Form SPPB</h2>
		<ol class="breadcrumb">
			<li>
				<a href="<?php echo base_url('index.php') ?>">Home</a>
			</li>
			<li >
					<a href="<?php echo base_url('index.php/SPPB/') ?>">SPPB</a>	
			</li>
			<li class="active">
				<strong>
					<a>Form SPPB</a>
				</strong>
			</li>
		</ol>
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">

    <div class="alert alert-danger alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        Halaman ini hanya menampilkan isi form SPPB.
    </div>

    <!-- Identitas Form SPPB -->
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Formulir Pengisian Item Barang/Jasa SPPB</h5>
        </div>
        <div class="ibox-content">
            <form method="get" class="form-horizontal">
                <?php
                if (isset($SPPB)) {
                    foreach ($SPPB->result() as $SPPB) :
                ?>
                        <hr>
                        <input style="display:none" type="text" class="form-control" name="ID_RASD" id="ID_RASD" value="<?php echo $SPPB->ID_RASD; ?>">
                        <div class="form-group"><label class="col-sm-2 control-label">Lokasi:</label>
                            <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $SPPB->NAMA_PROYEK; ?>" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label">Jenis Pekerjaan:</label>
                            <div class="col-sm-10">
                                <?php if ($SPPB->JENIS_PEKERJAAN == "mainwork") {
                                ?>
                                    <div class="col-xs-2">
                                        <label><input type="radio" checked value="mainwork" id="mainwork" name="KERJA" disabled>&nbsp; Main Work</label>
                                    </div>
                                    <div class="col-xs-2">
                                        <label> <input type="radio" value="additional" id="additional" name="KERJA" disabled>
                                            &nbsp; Addtional</label>
                                    </div>
                                <?php
                                } else { ?>
                                    <div class="col-xs-2">
                                        <label><input type="radio" value="mainwork" id="mainwork" name="KERJA" disabled>&nbsp; Main Work</label>
                                    </div>
                                    <div class="col-xs-2">
                                        <label> <input type="radio" checked value="additional" id="additional" name="KERJA" disabled>
                                            &nbsp; Addtional</label>
                                    </div>
                                <?php } ?>
                                <input type="text" id="PEKERJAAN" name="PEKERJAAN" style="display: none;">
                            </div>
                        </div>
                        <div class="form-group"><label class="col-sm-2 control-label">No Urut:</label>
                            <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $SPPB->NO_URUT_SPPB; ?>" disabled>
                            </div>
                        </div>
                        <div class="form-group"><label class="col-sm-2 control-label">Tanggal Pembuatan :</label>
                            <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $SPPB->TANGGAL_PEMBUATAN_SPPB_HARI; ?>" disabled>
                            </div>
                        </div>
                        <div class="form-group"><label class="col-sm-2 control-label">Catatan SPPB:</label>
                        </div>
                        
                <?php endforeach;
                } ?>
            </form>
        </div>
    </div>
    <!-- End Identitas Form SPPB -->

    <!-- Form SPPB -->
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>SPPB Item Barang/Jasa</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="fullscreen-link">
                            <i class="fa fa-expand"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="mydata">
                            <thead>
                                <tr>
                                    <!-- <th>Status Barang</th> -->
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Merek Barang</th>
                                    <th>Jenis Barang</th>
                                    <th>Spesifikasi Singkat</th>
                                    <th>Satuan Barang</th>
                                    <th>RASD</th>
                                    <th>Stok Gudang Pusat</th>
                                    <th>Stok Gudang Proyek</th>
                                    <th>Total Pengadaan s/d Saat Ini</th>
                                    <th>Jumlah Yang Diminta</th>
                                    <th>Jumlah Yang Disetujui</th>
                                    <th>Justifikasi</th>
                                </tr>
                            </thead>
                            <tbody id="show_data">

                            </tbody>

                        </table>
                    </div>
                    </br>
                </div>

            </div>
        </div>
    </div>
    <!-- End Form SPPB -->
</div>



<!-- Mainly scripts -->
<script src="<?php echo base_url(); ?>assets/wasa/js/jquery-3.1.1.min.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/dataTables/datatables.min.js"></script>

<!-- TouchSpin -->
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/touchspin/jquery.bootstrap-touchspin.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="<?php echo base_url(); ?>assets/wasa/js/inspinia.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/pace/pace.min.js"></script>

<!-- Page-Level Scripts -->
<script>

    $(document).ready(function() {
        let ID_SPPB = <?php echo $ID_SPPB  ?>;
        tampil_data_sppb_form(); //pemanggilan fungsi tampil data.

        $('#mydata').dataTable({
            pageLength: 10,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [{
                    extend: 'copy'
                },
                {
                    extend: 'csv'
                },
                {
                    extend: 'excel',
                    title: 'Sppb Barang'
                },
                {
                    extend: 'pdf',
                    title: 'Sppb Barang'
                },

                {
                    extend: 'print',
                    customize: function(win) {
                        $(win.document.body).addClass('white-bg');
                        $(win.document.body).css('font-size', '10px');

                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    }
                }
            ]

        });

        $('#modalmaster').dataTable();
        $('#modalrasd').dataTable();

        //fungsi tampil data
        function tampil_data_sppb_form() {
            $.ajax({
                type: 'GET',
                url: '<?php echo base_url() ?>SPPB_form/data_sppb_form',
                async: false,
                dataType: 'json',
                data: {
                    id: ID_SPPB
                },
                success: function(data) {
                    var html = '';
                    var i;
                    for (i = 0; i < data.length; i++) {
                        let jumlah_barang = data[i].JUMLAH_MINTA;
                        let jumlah_rasd = data[i].JUMLAH_RASD;
                        let kode_barang = data[i].KODE_BARANG;

                        if (kode_barang != null) {
                            kode_barang_cetak = '<a href="<?php echo base_url() ?>barang_master/profil_barang_master/'+data[i].HASH_MD5_BARANG_MASTER +'" class="btn btn-warning btn-xs btn-outline block" target="_blank"><i class="fa fa-eye"></i> '+ kode_barang +' </a>';
                        }
                        if (kode_barang == null) {
                            kode_barang_cetak = '<span class="label label-info block"><i class="fa fa-warning"></i> Data Baru</span>';
                        }

                        if (jumlah_barang == null) {
                            jumlah_barang = 0;
                        }
                        if (kode_barang == null) {
                            kode_barang = `<span class="label label-warning"><i class="fa fa-warning"></i> Data Baru</span>`;
                        }
                        if (jumlah_rasd == null) {
                            jumlah_rasd = 0;
                        }
                        html += '<tr>' +
                            '<td>' + kode_barang_cetak + '</td>' +
                            '<td>' + data[i].NAMA_BARANG + '</td>' +
                            '<td>' + data[i].MEREK + '</td>' +
                            '<td>' + data[i].NAMA_JENIS_BARANG + '</td>' +
                            '<td>' + data[i].SPESIFIKASI_SINGKAT + '</td>' +
                            '<td>' + data[i].NAMA_SATUAN_BARANG + '</td>' +
                            '<td>' + jumlah_rasd + '</td>' +
                            '<td> 0 </td>' +
                            '<td> 0 </td>' +
                            '<td><span class="label label-warning"><i class="fa fa-warning"></i> Belum ada </span></td>' +
                            '<td>' + jumlah_barang + '</td>' +
                            '<td> 0 </td>' +
                            '</tr>';
                    }
                    $('#show_data').html(html);
                }
            });
        }


    });
</script>

</body>

</html>