<!DOCTYPE html>
<html lang="en">

<head>
  <style type="text/css">
    .tg_y {
      border-collapse: collapse;
      border-spacing: 0;
    }

    .tg_y td {
      border-color: black;
      border-style: solid;
      border-width: 1px;
      font-family: Arial, sans-serif;
      font-size: 12px;
      overflow: hidden;
      padding: 2px 2px 2px 2px;
      word-break: normal;
    }

    .tg_y th {
      border-color: black;
      border-style: solid;
      border-width: 1px;
      font-family: Arial, sans-serif;
      font-size: 12px;
      font-weight: normal;
      overflow: hidden;
      padding: 2px 2px 2px 2px;
      word-break: normal;
    }

    .tg_y .tg_y-0lax {
      text-align: left;
      vertical-align: top
    }
  </style>

  <style type="text/css">
    .tg {
      border-collapse: collapse;
      border-spacing: 0;
    }

    .tg td {
      border-color: black;
      border-style: solid;
      border-width: 0px;
      font-family: Arial, sans-serif;
      font-size: 12px;
      overflow: hidden;
      padding: 0px 5px;
      word-break: normal;
    }

    .tg th {
      border-color: black;
      border-style: solid;
      border-width: 0px;
      font-family: Arial, sans-serif;
      font-size: 12px;
      font-weight: normal;
      overflow: hidden;
      padding: 0px 5px;
      word-break: normal;
    }

    .tg .tg-zv4m {
      border-color: #ffffff;
      text-align: left;
      vertical-align: top
    }
  </style>


  <style type="text/css">
    .tg_ctt {
      border-collapse: collapse;
      border-spacing: 0;
    }

    .tg_ctt td {
      border-color: black;
      border-style: solid;
      border-width: 1px;
      font-family: Arial, sans-serif;
      font-size: 14px;
      overflow: hidden;
      padding: 10px 5px;
      word-break: normal;
    }

    .tg_ctt th {
      border-color: black;
      border-style: solid;
      border-width: 1px;
      font-family: Arial, sans-serif;
      font-size: 14px;
      font-weight: normal;
      overflow: hidden;
      padding: 10px 5px;
      word-break: normal;
    }

    .tg_ctt .tg_ctt-4zwk {
      border-color: #343434;
      font-size: 11px;
      text-align: left;
      vertical-align: top
    }
  </style>

  <style type="text/css">
    .tg_justifikasi {
      border-collapse: collapse;
      border-spacing: 0;
    }

    .tg_justifikasi td {
      border-color: black;
      border-style: solid;
      border-width: 1px;
      font-family: Arial, sans-serif;
      font-size: 14px;
      overflow: hidden;
      padding: 10px 5px;
      word-break: normal;
    }

    .tg_justifikasi th {
      border-color: black;
      border-style: solid;
      border-width: 1px;
      font-family: Arial, sans-serif;
      font-size: 14px;
      font-weight: normal;
      overflow: hidden;
      padding: 10px 5px;
      word-break: normal;
    }

    .tg_justifikasi .tg_justifikasi-ps66 {
      font-size: 11px;
      text-align: left;
      vertical-align: top
    }

    .tg_justifikasi .tg_justifikasi-4zwk {
      border-color: #343434;
      font-size: 11px;
      text-align: left;
      vertical-align: top
    }
  </style>

  <style type="text/css">
    .p1 {
      font-family: Arial, sans-serif;
      font-size: 12px;
    }

    .page_break {
      page-break-before: always;
    }

    #footer {
      position: fixed;
      right: 0px;
      bottom: 10px;
      text-align: right;
      border-top: 1px solid black;
      font-family: Arial, sans-serif;
      font-size: 14px;
    }

    #footer .page:after {
      content: counter(page, decimal);
    }

    @page {
      margin: 20px 30px 40px 50px;
    }
  </style>

  <style>
    @page {
      margin-top: 150px;
    }

    header {
      position: fixed;
      left: 0px;
      right: 0px;
      height: 200px;
      margin-top: -100px;
    }
  </style>
</head>


<body>

  <header>
    <p align="center" class="p1"> FORM SURAT JALAN BARANG</p>


    <table class="tg">
      <?php
      if (isset($Surat_jalan)) {
        foreach ($Surat_jalan->result() as $Surat_jalan) :
      ?>
          <thead>
            <tr>
              <th class="tg-zv4m">Nomor Urut</th>
              <th class="tg-zv4m">:</th>
              <th class="tg-zv4m"><?php echo $Surat_jalan->NO_SURAT_JALAN; ?></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="tg-zv4m">Tanggal Pengajuan</td>
              <td class="tg-zv4m">:</td>
              <td class="tg-zv4m"><?php
                                  if ($STATUS_SURAT_JALAN == "Draft") {
                                    echo "<b>DRAFT</b> - ";
                                  }
                                  ?><?php echo $Surat_jalan->TANGGAL_PENGAJUAN_SURAT_JALAN; ?></td>
            </tr>
        <?php endforeach;
      } ?>
        
          </tbody>
    </table>
    <br>
  </header>


  <div id="footer">
  </div>

  <table class="tg_y">
    <thead>
      <tr>
        <th class="tg_y-0lax"><b>No.</b></th>
        <th class="tg_y-0lax"><b>Nama Barang</b></th>
        <th class="tg_y-0lax"><b>Spesifikasi Singkat</b></th>
        <th class="tg_y-0lax"><b>Jenis Barang</b></th>
        <th class="tg_y-0lax"><b>Satuan Barang</b></th>
        <th class="tg_y-0lax"><b>Jumlah</b></th>
        <th class="tg_y-0lax"><b>Keterangan</b></th>
        <th class="tg_y-0lax"><b>Nett Weight</b></th>
        <th class="tg_y-0lax"><b>Gross Weight</b></th>
        <th class="tg_y-0lax"><b>Packing Style</b></th>
        <th class="tg_y-0lax"><b>Dimensi Panjang</b></th>
        <th class="tg_y-0lax"><b>Dimensi Lebar</b></th>
        <th class="tg_y-0lax"><b>Dimensi Tinggi</b></th>
      </tr>
    </thead>
    <tbody>
      <?php
      $hitung = 1;
      if (isset($konten_Surat_Jalan_form)) {
        foreach ($konten_Surat_Jalan_form as $item) {
      ?>
          <tr>
            <td class="tg_y-0lax"><?php echo $hitung; ?></td>
            <td class="tg_y-0lax"><?php echo $item->NAMA_BARANG; ?></td>
            <td class="tg_y-0lax"><?php echo $item->SPESIFIKASI_SINGKAT; ?></td>
            <td class="tg_y-0lax"><?php echo $item->NAMA_JENIS_BARANG; ?></td>
            <td class="tg_y-0lax"><?php echo $item->NAMA_SATUAN_BARANG; ?></td>
            <td class="tg_y-0lax"><?php echo $item->JUMLAH; ?></td>
            <td class="tg_y-0lax"><?php echo $item->KETERANGAN; ?></td>
            <td class="tg_y-0lax"><?php echo $item->NETT_WEIGHT; ?></td>
            <td class="tg_y-0lax"><?php echo $item->GROSS_WEIGHT; ?></td>
            <td class="tg_y-0lax"><?php echo $item->PACKING_STYLE; ?></td>
            <td class="tg_y-0lax"><?php echo $item->DIMENSI_PANJANG; ?></td>
            <td class="tg_y-0lax"><?php echo $item->DIMENSI_LEBAR; ?></td>
            <td class="tg_y-0lax"><?php echo $item->DIMENSI_TINGGI; ?></td>
          </tr>
      <?php
          $hitung = $hitung + 1;
        }
      } ?>
    </tbody>
  </table>

  <br>
  <br>
  <div class="page_break"></div>
  <table class="tg_ctt">
    <thead>
      <tr>
        <th class="tg_ctt-4zwk" colspan="2"><b>Catatan SURAT JALAN:</b></th>
      </tr>
    </thead>
    <tbody>
      <?php
      if (isset($USER_PENGAJU)) {
        foreach ($USER_PENGAJU as $item) {
      ?>
          <tr>
            <td class="tg_ctt-4zwk"><?php echo $item->ID_JABATAN; ?>:</td>
            <td class="tg_ctt-4zwk"><?php echo $CATATAN_SURAT_JALAN['CTT_STAFF_LOG']; ?></td>
          </tr>
      <?php
        }
      } ?>
    </tbody>
  </table>
  <br>
  <br>
  
  <br>
  <br>

</body>