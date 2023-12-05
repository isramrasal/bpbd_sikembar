<html>

<head>
	<style type="text/css">
		table {
			page-break-inside: auto;
		}

		tr {
			page-break-inside: avoid;
			page-break-after: auto
		}

		thead {
			display: table-header-group
		}

		tfoot {
			display: table-footer-group
		}
	</style>
	<style>
		/** 
                Set the margins of the page to 0, so the footer and the header
                can be of the full height and width !
             **/
		@page {
			margin: 0cm 0cm;
		}

		/** Define now the real margins of every page in the PDF **/
		body {
			margin-top: 7.1cm;
			margin-left: 1.5cm;
			margin-right: 0cm;
			margin-bottom: 2cm;
		}

		.myDiv {
			margin-top: 0cm;
			margin-left: 0cm;
			margin-right: 0cm;
			margin-bottom: 2cm;
		}

		.ttd {
			page-break-inside: avoid;
		}

		/** Define the header rules **/
		header {
			position: fixed;
			top: 1cm;
			left: 1.5cm;
			right: 1cm;
			height: 7cm;

			/** Extra personal styles **/
			/* background-color: #03a9f4;
			color: white;
			text-align: center;
			line-height: 1.5cm; */
		}

		/** Define the footer rules **/
		footer {
			position: fixed;
			bottom: 1cm;
			left: 1.5cm;
			right: 1cm;
			height: 2cm;

			font-size: 8.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: Calibri Light;
		}
	</style>

	<style id="patokan sppb_10196_Styles">
		<!--table
		{
			mso-displayed-decimal-separator: "\.";
			mso-displayed-thousand-separator: "\,";
		}

		.font510196 {
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Calibri Light", sans-serif;
			mso-font-charset: 0;
		}

		.font610196 {
			color: black;
			font-size: 7.0pt;
			font-weight: 700;
			font-style: normal;
			text-decoration: none;
			font-family: "Calibri Light", sans-serif;
			mso-font-charset: 0;
		}

		.font710196 {
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Calibri Light", sans-serif;
			mso-font-charset: 0;
		}

		.xl6510196 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 11.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Calibri Light", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: general;
			vertical-align: bottom;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl6610196 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Calibri Light", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: left;
			vertical-align: middle;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl6710196 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 700;
			font-style: normal;
			text-decoration: none;
			font-family: "Calibri Light", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: general;
			vertical-align: middle;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl6810196 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 8.0pt;
			font-weight: 700;
			font-style: normal;
			text-decoration: none;
			font-family: "Calibri Light", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: center;
			vertical-align: middle;
			background: white;
			mso-pattern: black none;
			white-space: nowrap;
		}

		.xl6910196 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 700;
			font-style: normal;
			text-decoration: none;
			font-family: "Calibri Light", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: center;
			vertical-align: middle;
			border: .5pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl7010196 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Calibri Light", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: center;
			vertical-align: middle;
			border: .5pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl7110196 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Calibri Light", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: general;
			vertical-align: bottom;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl7210196 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 8.0pt;
			font-weight: 700;
			font-style: normal;
			text-decoration: none;
			font-family: "Calibri Light", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: general;
			vertical-align: bottom;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl7310196 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Calibri Light", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: general;
			vertical-align: bottom;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl7410196 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 8.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Calibri Light", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: general;
			vertical-align: bottom;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl7510196 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 8.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Calibri Light", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: left;
			vertical-align: bottom;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl7610196 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 700;
			font-style: normal;
			text-decoration: none;
			font-family: "Calibri Light", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: center;
			vertical-align: middle;
			border: .5pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl7710196 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 700;
			font-style: normal;
			text-decoration: none;
			font-family: "Calibri Light", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: general;
			vertical-align: bottom;
			border-top: .5pt solid windowtext;
			border-right: none;
			border-bottom: none;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl7810196 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Calibri Light", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: center;
			vertical-align: middle;
			border-top: .5pt solid windowtext;
			border-right: none;
			border-bottom: none;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl7910196 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 700;
			font-style: normal;
			text-decoration: none;
			font-family: "Calibri Light", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: general;
			vertical-align: middle;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl8010196 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 11.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Calibri Light", sans-serif;
			mso-font-charset: 0;
			mso-number-format: "\0022Rp\0022\#\,\#\#0\.00";
			text-align: general;
			vertical-align: bottom;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl8110196 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 700;
			font-style: normal;
			text-decoration: none;
			font-family: "Calibri Light", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: left;
			vertical-align: middle;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl8210196 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Calibri Light", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: general;
			vertical-align: middle;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl8310196 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 700;
			font-style: normal;
			text-decoration: none;
			font-family: "Calibri Light", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: general;
			vertical-align: bottom;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl8410196 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 20.0pt;
			font-weight: 700;
			font-style: normal;
			text-decoration: none;
			font-family: "Calibri Light", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: general;
			vertical-align: middle;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl8510196 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Calibri Light", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: general;
			vertical-align: middle;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl8610196 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 11.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Calibri Light", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: general;
			vertical-align: middle;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl8710196 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 700;
			font-style: normal;
			text-decoration: none;
			font-family: "Calibri Light", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: left;
			vertical-align: middle;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl8810196 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Calibri Light", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: right;
			vertical-align: middle;
			border-top: .5pt solid windowtext;
			border-right: none;
			border-bottom: .5pt solid windowtext;
			border-left: .5pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl8910196 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Calibri Light", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: right;
			vertical-align: middle;
			border-top: .5pt solid windowtext;
			border-right: .5pt solid windowtext;
			border-bottom: .5pt solid windowtext;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl9010196 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Calibri Light", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: center;
			vertical-align: middle;
			border-top: .5pt solid windowtext;
			border-right: none;
			border-bottom: .5pt solid windowtext;
			border-left: .5pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl9110196 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Calibri Light", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: center;
			vertical-align: middle;
			border-top: .5pt solid windowtext;
			border-right: .5pt solid windowtext;
			border-bottom: .5pt solid windowtext;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl9210196 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 700;
			font-style: normal;
			text-decoration: none;
			font-family: "Calibri Light", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: center;
			vertical-align: middle;
			border-top: .5pt solid windowtext;
			border-right: none;
			border-bottom: .5pt solid windowtext;
			border-left: .5pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl9310196 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 700;
			font-style: normal;
			text-decoration: none;
			font-family: "Calibri Light", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: center;
			vertical-align: middle;
			border-top: .5pt solid windowtext;
			border-right: .5pt solid windowtext;
			border-bottom: .5pt solid windowtext;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl9410196 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 700;
			font-style: normal;
			text-decoration: none;
			font-family: "Calibri Light", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: center;
			vertical-align: middle;
			border-top: .5pt solid windowtext;
			border-right: none;
			border-bottom: .5pt solid windowtext;
			border-left: .5pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl9510196 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 700;
			font-style: normal;
			text-decoration: none;
			font-family: "Calibri Light", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: center;
			vertical-align: middle;
			border-top: .5pt solid windowtext;
			border-right: none;
			border-bottom: .5pt solid windowtext;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl9610196 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Calibri Light", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: left;
			vertical-align: middle;
			border-top: .5pt solid windowtext;
			border-right: none;
			border-bottom: .5pt solid windowtext;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl9710196 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Calibri Light", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: left;
			vertical-align: middle;
			border-top: .5pt solid windowtext;
			border-right: .5pt solid windowtext;
			border-bottom: .5pt solid windowtext;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl9810196 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Calibri Light", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: left;
			vertical-align: middle;
			border-top: .5pt solid windowtext;
			border-right: none;
			border-bottom: .5pt solid windowtext;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl9910196 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Calibri Light", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: left;
			vertical-align: middle;
			border-top: .5pt solid windowtext;
			border-right: .5pt solid windowtext;
			border-bottom: .5pt solid windowtext;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl10010196 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Calibri Light", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: left;
			vertical-align: middle;
			border-top: .5pt solid windowtext;
			border-right: none;
			border-bottom: .5pt solid windowtext;
			border-left: .5pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl10110196 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 11.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Calibri Light", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: center;
			vertical-align: top;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl10210196 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 24.0pt;
			font-weight: 700;
			font-style: normal;
			text-decoration: none;
			font-family: "Calibri Light", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: center;
			vertical-align: middle;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl10310196 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Calibri Light", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: left;
			vertical-align: bottom;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl10410196 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 700;
			font-style: normal;
			text-decoration: none;
			font-family: "Calibri Light", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: left;
			vertical-align: top;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl10510196 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Calibri Light", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: left;
			vertical-align: top;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl10610196 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 700;
			font-style: normal;
			text-decoration: none;
			font-family: "Calibri Light", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: right;
			vertical-align: middle;
			border: .5pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl10710196 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Calibri Light", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: left;
			vertical-align: bottom;
			border-top: none;
			border-right: none;
			border-bottom: .5pt solid windowtext;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl10810196 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 700;
			font-style: normal;
			text-decoration: none;
			font-family: "Calibri Light", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: center;
			vertical-align: middle;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl10910196 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 700;
			font-style: normal;
			text-decoration: none;
			font-family: "Calibri Light", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: center;
			vertical-align: bottom;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl11010196 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: #0070C0;
			font-size: 7.0pt;
			font-weight: 700;
			font-style: normal;
			text-decoration: none;
			font-family: "Calibri Light", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: general;
			vertical-align: middle;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl11110196 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Calibri Light", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: general;
			vertical-align: top;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}
		-->
	</style>



</head>

<body>
	<!-- Define header and footer blocks before your content -->
	<header>

		<div id="patokan sppb_10196" align=center x:publishsource="Excel">

			<table border=0 cellpadding=0 cellspacing=0 width=875 class=xl6510196 style='border-collapse:collapse;table-layout:fixed;width:728pt'>
				<col class=xl6510196 width=43 style='mso-width-source:userset;mso-width-alt:
 1536;width:32pt'>
				<col class=xl6510196 width=64 span=14 style='width:48pt'>
				<col class=xl6510196 width=166 style='mso-width-source:userset;mso-width-alt:
 5888;width:124pt'>
				<tr height=20 style='mso-height-source:userset;height:15.0pt'>
					<td rowspan=4 height=81 class=xl10110196 width=43 style='height:60.9pt;
  width:32pt'><img src="assets/logo_wasa.png" alt="" width=30 height=30></td>
					<td class=xl11010196 colspan=3 width=192 style='width:144pt'>PT. WASA MITRA
						ENGINEERING</td>
					<td class=xl8410196 width=64 style='width:48pt'></td>
					<td class=xl8410196 width=64 style='width:48pt'></td>
					<td class=xl8510196 width=64 style='width:48pt'></td>
					<td class=xl8210196 width=64 style='width:48pt'></td>
					<td class=xl8210196 width=64 style='width:48pt'></td>
					<td class=xl8610196 width=64 style='width:48pt'></td>
					<td class=xl8610196 width=64 style='width:48pt'></td>
					<td class=xl6510196 width=64 style='width:48pt'></td>
					<td class=xl6510196 width=64 style='width:48pt'></td>
					<td class=xl6510196 width=64 style='width:48pt'></td>
					<td class=xl6510196 width=64 style='width:48pt'></td>
					<td class=xl6510196 width=166 style='width:124pt'></td>
				</tr>
				<tr height=20 style='mso-height-source:userset;height:15.0pt'>
					<td colspan=10 rowspan=3 height=61 class=xl10210196 style='height:45.9pt'>REQUEST
						FOR QUOTATION</td>
					<td class=xl6510196></td>
					<td class=xl6510196></td>
					<td class=xl6510196></td>
					<td class=xl6510196></td>
					<td class=xl6510196></td>
				</tr>
				<tr height=22 style='mso-height-source:userset;height:16.5pt'>
					<td height=22 class=xl6510196 style='height:16.5pt'></td>
					<td class=xl6510196></td>
					<td class=xl6510196></td>
					<td class=xl6510196></td>
					<td class=xl6510196></td>
				</tr>
				<tr height=19 style='mso-height-source:userset;height:14.4pt'>
					<td height=19 class=xl6510196 style='height:14.4pt'></td>
					<td class=xl6510196></td>
					<td class=xl6510196></td>
					<td class=xl6510196></td>
					<td class=xl6510196></td>
				</tr>
				<tr height=19 style='mso-height-source:userset;height:14.4pt'>
					<td height=19 class=xl6710196 width=43 style='height:14.4pt;width:32pt'>No.</td>
					<td colspan=5 class=xl6610196 width=320 style='width:240pt'>: <?php echo $NO_URUT_RFQ; ?></td>
					<td class=xl6510196></td>
					<td class=xl6510196></td>
					<td colspan=3 class=xl8710196>Kepada Yth.,</td>
					<td class=xl6510196></td>
					<td class=xl6510196></td>
					<td class=xl6510196></td>
					<td class=xl6510196></td>
					<td class=xl6510196></td>
				</tr>
				<tr height=19 style='mso-height-source:userset;height:14.4pt'>
					<td height=19 class=xl8110196 width=43 style='height:14.4pt;width:32pt'>Tanggal</td>
					<td colspan=5 class=xl6610196 width=320 style='width:240pt'>: <?php echo $TANGGAL_DOKUMEN_RFQ_INDO; ?></td>
					<td class=xl6510196></td>
					<td class=xl6510196></td>
					<td colspan=3 class=xl8110196 width=192 style='width:144pt'><?php echo $NAMA_VENDOR; ?></td>
					<td class=xl6510196></td>
					<td class=xl6510196></td>
					<td class=xl6510196></td>
					<td class=xl6510196></td>
					<td class=xl6510196></td>
				</tr>
				<tr height=19 style='mso-height-source:userset;height:14.4pt'>
					<td height=19 class=xl6710196 width=43 style='height:14.4pt;width:32pt'></td>
					<td class=xl6710196 width=64 style='width:48pt'></td>
					<td class=xl8210196 width=64 style='width:48pt'></td>
					<td class=xl8210196 width=64 style='width:48pt'></td>
					<td class=xl8210196 width=64 style='width:48pt'></td>
					<td class=xl8210196 width=64 style='width:48pt'></td>
					<td class=xl6510196></td>
					<td class=xl6510196></td>
					<td colspan=3 rowspan=4 class=xl6610196 width=192 style='width:144pt'><?php
																							echo $ALAMAT_VENDOR; ?> </br><br>
						<?php echo $NO_TELP_VENDOR; ?> </br><br>
						<?php echo $NAMA_PIC_VENDOR; ?> </br><br>
						<?php echo $NO_HP_PIC_VENDOR; ?> </br></td>
					<td class=xl6510196></td>
					<td class=xl6510196></td>
					<td class=xl6510196></td>
					<td class=xl6510196></td>
					<td class=xl6510196></td>
				</tr>
				<tr height=19 style='mso-height-source:userset;height:14.4pt'>
					<td height=19 class=xl6710196 width=43 style='height:14.4pt;width:32pt'></td>
					<td class=xl6710196 width=64 style='width:48pt'></td>
					<td class=xl8210196 width=64 style='width:48pt'></td>
					<td class=xl8210196 width=64 style='width:48pt'></td>
					<td class=xl8210196 width=64 style='width:48pt'></td>
					<td class=xl8210196 width=64 style='width:48pt'></td>
					<td class=xl6510196></td>
					<td class=xl6510196></td>
					<td class=xl6510196></td>
					<td class=xl6510196></td>
					<td class=xl6510196></td>
					<td class=xl6510196></td>
					<td class=xl6510196></td>
				</tr>
				<tr height=19 style='mso-height-source:userset;height:14.4pt'>
					<td height=19 class=xl6710196 width=43 style='height:14.4pt;width:32pt'></td>
					<td class=xl6710196 width=64 style='width:48pt'></td>
					<td class=xl6610196 width=64 style='width:48pt'></td>
					<td class=xl6610196 width=64 style='width:48pt'></td>
					<td class=xl6610196 width=64 style='width:48pt'></td>
					<td class=xl6610196 width=64 style='width:48pt'></td>
					<td class=xl6510196></td>
					<td class=xl6510196></td>
					<td class=xl6510196></td>
					<td class=xl6510196></td>
					<td class=xl6510196></td>
					<td class=xl6510196></td>
					<td class=xl6510196></td>
				</tr>
				<tr height=19 style='mso-height-source:userset;height:14.4pt'>
					<td height=19 class=xl6710196 width=43 style='height:14.4pt;width:32pt'></td>
					<td class=xl6710196 width=64 style='width:48pt'></td>
					<td class=xl6610196 width=64 style='width:48pt'></td>
					<td class=xl6610196 width=64 style='width:48pt'></td>
					<td class=xl6610196 width=64 style='width:48pt'></td>
					<td class=xl6610196 width=64 style='width:48pt'></td>
					<td class=xl6510196></td>
					<td class=xl6510196></td>
					<td class=xl6510196></td>
					<td class=xl6510196></td>
					<td class=xl6510196></td>
					<td class=xl6510196></td>
					<td class=xl6510196></td>
				</tr>

			</table>

		</div>



	</header>

	<footer>
		<img style="width: 80px;" src="<?php echo $GAMBAR_QR_2; ?>">
	</footer>

	<!-- Wrap the content of your PDF inside a main tag -->
	<main>
		<div class="myDiv">

			<div id="patokan sppb_10196" align=center x:publishsource="Excel">

				<table border=0 cellpadding=0 cellspacing=0 width=875 class=xl6510196 style='border-collapse:collapse;table-layout:fixed;width:728pt'>

					<tr height=19 style='height:14.4pt'>
						<td colspan=11 height=19 class=xl10710196 style='height:14.4pt'>Bersama surat
							ini, mohon dikirimkan penawaran harga dengan list sebagai berikut</td>
						<td class=xl6510196></td>
						<td class=xl6510196></td>
						<td class=xl6510196></td>
						<td class=xl6510196></td>
						<td class=xl6510196></td>
					</tr>
					<tr height=19 style='mso-height-source:userset;height:14.4pt'>
						<td colspan=2 height=19 class=xl9410196 width=107 style='height:14.4pt;
  width:80pt'><span style='mso-spacerun:yes'>&nbsp;Syarat Pembayaran :<font class="font710196"><span style='mso-spacerun:yes'>&nbsp;</font>
						</td>
						<td colspan=4 class=xl9610196 width=256 style='border-right:.5pt solid black;
  width:192pt'><?php echo $TERM_OF_PAYMENT; ?></td>
						<td colspan=2 class=xl10010196 width=128 style='border-left:none;width:96pt'>
							<font class="font610196"><span style='mso-spacerun:yes'>&nbsp;Lokasi Penyerahan :</font>
							<font class="font510196"><span style='mso-spacerun:yes'>&nbsp;</font>
						</td>
						<td colspan=3 class=xl9810196 width=192 style='border-right:.5pt solid black;
  width:144pt'><?php echo $NAMA_LOKASI_PENYERAHAN; ?></td>
						<td class=xl6510196></td>
						<td class=xl6510196></td>
						<td class=xl6810196>&nbsp;</td>
						<td class=xl6510196></td>
						<td class=xl6510196></td>
					</tr>
					<tr height=26 style='mso-height-source:userset;height:19.2pt'>
						<td height=26 class=xl7610196 style='height:19.2pt;border-top:none'>No.</td>
						<td colspan=2 class=xl9210196 width=128 style='border-right:.5pt solid black;
  border-left:none;width:96pt'>Nama Barang</td>
						<td colspan=2 class=xl9210196 width=128 style='border-right:.5pt solid black;
  border-left:none;width:96pt'>Spesifikasi</td>
						<td class=xl6910196 width=64 style='border-top:none;border-left:none;
  width:48pt'>Banyaknya</td>
						<td class=xl6910196 width=64 style='border-top:none;border-left:none;
  width:48pt'>Satuan</td>
						<td colspan=2 class=xl9210196 width=128 style='border-right:.5pt solid black;
  border-left:none;width:96pt'>Harga Satuan</td>
						<td colspan=2 class=xl9210196 width=128 style='border-right:.5pt solid black;
  border-left:none;width:96pt'>Harga Total</td>
						<td class=xl6510196></td>
						<td class=xl6510196></td>
						<td class=xl6510196></td>
						<td class=xl6510196></td>
						<td class=xl6510196></td>
					</tr>

					<?php
					$hitung = 1;
					if (isset($konten_RFQ_form)) {
						foreach ($konten_RFQ_form as $item) {
					?>

							<tr height=22 style='mso-height-source:userset;height:16.5pt'>
								<td height=22 class=xl7010196 width=43 style='height:16.5pt;border-top:0.5pt;
  width:32pt'><?php echo $hitung; ?></td>
								<td colspan=2 class=xl10010196 width=128 style='border-right:.5pt solid black;
  border-left:none;border-top:0.5pt;width:96pt;padding-left:5pt'><?php echo $item->NAMA_BARANG; ?></td>
								<td colspan=2 class=xl9010196 width=128 style='border-right:.5pt solid black;
  border-left:none;border-top:0.5pt;width:96pt'><?php echo $item->SPESIFIKASI_SINGKAT;
								?></td>
								<td class=xl7010196 width=64 style='border-top:0.5pt;border-left:none;
  width:48pt'><?php echo $item->JUMLAH_BARANG; ?></td>
								<td class=xl7010196 width=64 style='border-top:0.5pt;border-left:none;
  width:48pt'><?php echo $item->SATUAN_BARANG; ?></td>
								<td colspan=2 class=xl8810196 width=128 style='border-right:.5pt solid black;
  border-left:none;border-top:0.5pt;width:96pt'>&nbsp; </td>
								<td colspan=2 class=xl8810196 width=128 style='border-right:.5pt solid black;
  border-left:none;border-top:0.5pt;width:96pt'>&nbsp; </td>
								<td class=xl7110196></td>
								<td class=xl6510196></td>
								<td class=xl6510196></td>
								<td class=xl6510196></td>
								<td class=xl8010196></td>
							</tr>



					<?php
							$hitung = $hitung + 1;
						}
					} ?>

					<tr height=19 style='height:14.4pt'>
						<td colspan=9 height=19 class=xl10610196 width=555 style='height:14.4pt;
  width:416pt'>TOTAL</td>
						<td colspan=2 class=xl8810196 width=128 style='border-right:.5pt solid black;
  border-left:none;width:96pt'></td>
						<td class=xl6510196></td>
						<td class=xl6510196></td>
						<td class=xl6510196></td>
						<td class=xl6510196></td>
						<td class=xl6510196></td>
					</tr>
					<tr height=19 style='height:14.4pt'>
						<td height=19 class=xl6510196 style='height:14.4pt'></td>
						<td class=xl8310196></td>
						<td class=xl8310196></td>
						<td class=xl8310196></td>
						<td class=xl8310196></td>
						<td class=xl8310196></td>
						<td class=xl8310196></td>
						<td class=xl8310196></td>
						<td class=xl8310196></td>
						<td class=xl7710196 style='border-top:none'>&nbsp;</td>
						<td class=xl7810196 style='border-top:none'>&nbsp;</td>
						<td class=xl6510196></td>
						<td class=xl6510196></td>
						<td class=xl6510196></td>
						<td class=xl6510196></td>
						<td class=xl6510196></td>
					</tr>
					<tr height=19 style='mso-height-source:userset;height:14.4pt'>
						<td colspan=2 height=19 class=xl10410196 style='height:14.4pt'>Keperluan</td>
						<td colspan=9 class=xl10510196 width=576 style='width:432pt'>: <?php echo $KETERANGAN_RFQ; ?></td>
						<td class=xl6510196></td>
						<td class=xl6510196></td>
						<td class=xl6510196></td>
						<td class=xl6510196></td>
						<td class=xl6510196></td>
					</tr>
					<tr height=19 style='height:14.4pt'>
						<td height=19 class=xl6510196 style='height:14.4pt'></td>
						<td class=xl7910196></td>
						<td class=xl11110196 width=64 style='width:48pt'></td>
						<td class=xl11110196 width=64 style='width:48pt'></td>
						<td class=xl11110196 width=64 style='width:48pt'></td>
						<td class=xl11110196 width=64 style='width:48pt'></td>
						<td class=xl11110196 width=64 style='width:48pt'></td>
						<td class=xl11110196 width=64 style='width:48pt'></td>
						<td class=xl11110196 width=64 style='width:48pt'></td>
						<td class=xl11110196 width=64 style='width:48pt'></td>
						<td class=xl11110196 width=64 style='width:48pt'></td>
						<td class=xl6510196></td>
						<td class=xl6510196></td>
						<td class=xl6510196></td>
						<td class=xl6510196></td>
						<td class=xl6510196></td>
					</tr>
					<tr height=19 style='height:14.4pt'>
						<td colspan=11 height=19 class=xl10310196 style='height:14.4pt'>Demikian
							surat ini kami sampaikan, mohon penawaran harga dapat dikirimkan sebelum tanggal <?php echo $BATAS_AKHIR_INDO; ?></td>
						<td class=xl6510196></td>
						<td class=xl7210196></td>
						<td class=xl6510196></td>
						<td class=xl6510196></td>
						<td class=xl6510196></td>
					</tr>
					<tr height=19 style='height:14.4pt'>
						<td height=19 class=xl7510196 width=43 style='height:14.4pt;width:32pt'></td>
						<td class=xl7510196 width=64 style='width:48pt'></td>
						<td class=xl7510196 width=64 style='width:48pt'></td>
						<td class=xl7510196 width=64 style='width:48pt'></td>
						<td class=xl7510196 width=64 style='width:48pt'></td>
						<td class=xl7510196 width=64 style='width:48pt'></td>
						<td class=xl7510196 width=64 style='width:48pt'></td>
						<td class=xl7510196 width=64 style='width:48pt'></td>
						<td class=xl7510196 width=64 style='width:48pt'></td>
						<td class=xl7510196 width=64 style='width:48pt'></td>
						<td class=xl7510196 width=64 style='width:48pt'></td>
						<td class=xl6510196></td>
						<td class=xl6510196></td>
						<td class=xl6510196></td>
						<td class=xl6510196></td>
						<td class=xl6510196></td>
					</tr>
					<tr height=19 style='height:14.4pt'>
						<td height=19 class=xl6510196 style='height:14.4pt'></td>
						<td class=xl7310196 width=64 style='width:48pt'></td>
						<td class=xl7310196 width=64 style='width:48pt'></td>
						<td class=xl7310196 width=64 style='width:48pt'></td>
						<td class=xl7310196 width=64 style='width:48pt'></td>
						<td class=xl7310196 width=64 style='width:48pt'></td>
						<td class=xl7410196></td>
						<td class=xl6510196></td>
						<td colspan=3 class=xl10910196>Hormat Kami,</td>
						<td class=xl6510196></td>
						<td class=xl6510196></td>
						<td class=xl6510196></td>
						<td class=xl6510196></td>
						<td class=xl6510196></td>
					</tr>
					<tr height=19 style='height:14.4pt'>
						<td height=19 class=xl6510196 style='height:14.4pt'></td>
						<td class=xl7310196 width=64 style='width:48pt'></td>
						<td class=xl7310196 width=64 style='width:48pt'></td>
						<td class=xl7310196 width=64 style='width:48pt'></td>
						<td class=xl7310196 width=64 style='width:48pt'></td>
						<td class=xl7310196 width=64 style='width:48pt'></td>
						<td class=xl7410196></td>
						<td class=xl6510196></td>
						<td colspan=3 class=xl10810196>PT. Wasa Mitra Engineering</td>
						<td class=xl6510196></td>
						<td class=xl6510196></td>
						<td class=xl6510196></td>
						<td class=xl6510196></td>
						<td class=xl6510196></td>
					</tr>
					<tr height=19 style='height:14.4pt'>
						<td height=19 class=xl6510196 style='height:14.4pt'></td>
						<td class=xl7410196></td>
						<td class=xl7410196></td>
						<td class=xl7410196></td>
						<td class=xl7410196></td>
						<td class=xl7410196></td>
						<td class=xl6510196></td>
						<td class=xl6510196></td>
						<td class=xl6510196></td>
						<td class=xl6510196></td>
						<td class=xl6510196></td>
						<td class=xl6510196></td>
						<td class=xl6510196></td>
						<td class=xl6510196></td>
						<td class=xl6510196></td>
						<td class=xl6510196></td>
					</tr>
					<![if supportMisalignedColumns]>
					<tr height=0 style='display:none'>
						<td width=43 style='width:32pt'></td>
						<td width=64 style='width:48pt'></td>
						<td width=64 style='width:48pt'></td>
						<td width=64 style='width:48pt'></td>
						<td width=64 style='width:48pt'></td>
						<td width=64 style='width:48pt'></td>
						<td width=64 style='width:48pt'></td>
						<td width=64 style='width:48pt'></td>
						<td width=64 style='width:48pt'></td>
						<td width=64 style='width:48pt'></td>
						<td width=64 style='width:48pt'></td>
						<td width=64 style='width:48pt'></td>
						<td width=64 style='width:48pt'></td>
						<td width=64 style='width:48pt'></td>
						<td width=64 style='width:48pt'></td>
						<td width=166 style='width:124pt'></td>
					</tr>
					<![endif]>
				</table>

			</div>



		</div>
	</main>
</body>

</html>