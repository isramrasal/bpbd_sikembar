<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $title; ?></title>

    <link rel="icon" href="<?php echo base_url(); ?>assets/logo_bpbd.png">

    <link href="<?php echo base_url(); ?>assets/wasa/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/wasa/css/plugins/summernote/summernote.min.css" rel="stylesheet">

    <link href="<?php echo base_url(); ?>assets/wasa/css/animate.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/wasa/css/style.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/wasa/css/skins.less" rel="styles.less">

    <!-- dataTables style -->
    <link href="<?php echo base_url(); ?>assets/wasa/css/plugins/dataTables/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css"
        href="<?php echo base_url(); ?>assets/wasa/dataTableBaru/dataTables.checkboxes.css">

    <!-- date picker -->
    <link href="<?php echo base_url(); ?>assets/wasa/css/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/wasa/css/plugins/daterangepicker/daterangepicker-bs3.css"
        rel="stylesheet">

    <!-- informasi barang gambar slide -->
    <link href="<?php echo base_url(); ?>assets/wasa/css/plugins/slick/slick.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/wasa/css/plugins/slick/slick-theme.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/wasa/css/plugins/jasny/jasny-bootstrap.min.css" rel="stylesheet">

    <!-- touchspin -->
    <link href="<?php echo base_url(); ?>assets/wasa/css/plugins/touchspin/jquery.bootstrap-touchspin.min.css"
        rel="stylesheet">

    <!-- Switcher -->
    <link href="<?php echo base_url(); ?>assets/wasa/css/plugins/switchery/switchery.css" rel="stylesheet">

    <link href="<?php echo base_url(); ?>assets/wasa/css/plugins/chosen/bootstrap-chosen.css" rel="stylesheet">


    <style>
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .unstyled::-webkit-inner-spin-button,
    .unstyled::-webkit-calendar-picker-indicator {
        display: none;
        -webkit-appearance: none;
    }

    < !-- Custom Styles --><style> :root {
        --primary-color: #3498db;
        --secondary-color: #2c3e50;
        --accent-color: #e74c3c;
        --light-bg: #f8f9fa;
    }

    body {
        font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        background-color: #f5f7fa;
    }

    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .unstyled::-webkit-inner-spin-button,
    .unstyled::-webkit-calendar-picker-indicator {
        display: none;
        -webkit-appearance: none;
    }

    /* Modern form controls */
    .form-control,
    .form-select {
        border-radius: 0.375rem;
        padding: 0.5rem 0.75rem;
        border: 1px solid #ced4da;
        transition: all 0.2s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.25rem rgba(52, 152, 219, 0.25);
    }

    /* Modern buttons */
    .btn {
        border-radius: 0.375rem;
        padding: 0.5rem 1rem;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    /* Card styling */
    .card {
        border-radius: 0.5rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border: none;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
    }

    /* Table styling */
    .table {
        --bs-table-bg: transparent;
        --bs-table-striped-bg: rgba(0, 0, 0, 0.02);
    }

    /* Responsive tweaks */
    @media (max-width: 768px) {
        .container-fluid {
            padding-left: 1rem;
            padding-right: 1rem;
        }
    }
    </style>
    </style>





</head>