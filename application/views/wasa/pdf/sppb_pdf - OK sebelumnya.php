<html>

<head>
	<style type="text/css">
		table {
			page-break-inside: auto
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
			margin-top: 5cm;
			margin-left: 1cm;
			margin-right: 2cm;
			margin-bottom: 2cm;
		}

		.myDiv {
			margin-top: 0cm;
			margin-left: 0cm;
			margin-right: 0cm;
			margin-bottom: 1cm;
		}

		/** Define the header rules **/
		header {
			position: fixed;
			top: 1cm;
			left: 1cm;
			right: 1cm;
			height: 5cm;

			/** Extra personal styles **/
			/* background-color: #03a9f4;
			color: white;
			text-align: center;
			line-height: 1.5cm; */
		}

		/** Define the footer rules **/
		footer {
			position: fixed;
			bottom: 0.5cm;
			left: 1cm;
			right: 0cm;
			height: 2cm;

			font-size: 9.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: Calibri, sans-serif;
		}
	</style>
	<style id="patokan sppb_32621_Styles">
		<!--table
		{
			mso-displayed-decimal-separator: "\.";
			mso-displayed-thousand-separator: "\,";
		}

		.xl1532621 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 11.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: Calibri, sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: general;
			vertical-align: bottom;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl6332621 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: left;
			vertical-align: bottom;
			border-top: none;
			border-right: .5pt solid windowtext;
			border-bottom: none;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl6432621 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: general;
			vertical-align: middle;
			border-top: none;
			border-right: none;
			border-bottom: none;
			border-left: .5pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl6532621 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: general;
			vertical-align: middle;
			border-top: .5pt solid windowtext;
			border-right: none;
			border-bottom: .5pt solid windowtext;
			border-left: .5pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl6632621 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: general;
			vertical-align: middle;
			border-top: none;
			border-right: none;
			border-bottom: .5pt solid windowtext;
			border-left: .5pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl6732621 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 11.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: Calibri, sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: general;
			vertical-align: bottom;
			border-top: none;
			border-right: none;
			border-bottom: none;
			border-left: .5pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl6832621 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 11.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: center;
			vertical-align: middle;
			border-top: none;
			border-right: none;
			border-bottom: none;
			border-left: .5pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl6932621 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 8.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: general;
			vertical-align: bottom;
			border-top: none;
			border-right: .5pt solid windowtext;
			border-bottom: none;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl7032621 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: general;
			vertical-align: middle;
			border-top: .5pt solid windowtext;
			border-right: none;
			border-bottom: none;
			border-left: .5pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl7132621 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: windowtext;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: general;
			vertical-align: middle;
			border-top: .5pt solid windowtext;
			border-right: none;
			border-bottom: .5pt solid windowtext;
			border-left: .5pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl7232621 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: general;
			vertical-align: middle;
			border-top: none;
			border-right: none;
			border-bottom: none;
			border-left: .5pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl7332621 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
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

		.xl7432621 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: left;
			vertical-align: middle;
			border-top: .5pt solid windowtext;
			border-right: none;
			border-bottom: none;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl7532621 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: left;
			vertical-align: middle;
			border-top: .5pt solid windowtext;
			border-right: .5pt solid windowtext;
			border-bottom: none;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl7632621 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: left;
			vertical-align: middle;
			border-top: none;
			border-right: .5pt solid windowtext;
			border-bottom: none;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl7732621 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: left;
			vertical-align: middle;
			border-top: none;
			border-right: none;
			border-bottom: .5pt solid windowtext;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl7832621 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: left;
			vertical-align: middle;
			border-top: none;
			border-right: .5pt solid windowtext;
			border-bottom: .5pt solid windowtext;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl7932621 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 14.0pt;
			font-weight: 700;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: center;
			vertical-align: middle;
			border-top: .5pt solid windowtext;
			border-right: none;
			border-bottom: none;
			border-left: .5pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl8032621 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 14.0pt;
			font-weight: 700;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
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

		.xl8132621 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 14.0pt;
			font-weight: 700;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: center;
			vertical-align: middle;
			border-top: none;
			border-right: none;
			border-bottom: .5pt solid windowtext;
			border-left: .5pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl8232621 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 14.0pt;
			font-weight: 700;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: center;
			vertical-align: middle;
			border-top: none;
			border-right: none;
			border-bottom: .5pt solid windowtext;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl8332621 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
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

		.xl8432621 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
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

		.xl8532621 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
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

		.xl8632621 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 8.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: left;
			vertical-align: middle;
			border-top: none;
			border-right: .5pt solid windowtext;
			border-bottom: none;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl8732621 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 11.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: center;
			vertical-align: middle;
			border-top: .5pt solid windowtext;
			border-right: none;
			border-bottom: none;
			border-left: .5pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl8832621 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 11.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: center;
			vertical-align: middle;
			border-top: .5pt solid windowtext;
			border-right: .5pt solid windowtext;
			border-bottom: none;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl8932621 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 11.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: center;
			vertical-align: middle;
			border-top: none;
			border-right: .5pt solid windowtext;
			border-bottom: none;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl9032621 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 11.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: center;
			vertical-align: middle;
			border-top: none;
			border-right: none;
			border-bottom: .5pt solid windowtext;
			border-left: .5pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl9132621 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 11.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: center;
			vertical-align: middle;
			border-top: none;
			border-right: .5pt solid windowtext;
			border-bottom: .5pt solid windowtext;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl9232621 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: left;
			vertical-align: middle;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl9332621 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 11.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: center;
			vertical-align: middle;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl9432621 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: general;
			vertical-align: bottom;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl9532621 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: left;
			vertical-align: bottom;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl9632621 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 8.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: left;
			vertical-align: middle;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}
		-->
	</style>

	<style id="patokan sppb isi_6361_Styles">
		<!--table
		{
			mso-displayed-decimal-separator: "\.";
			mso-displayed-thousand-separator: "\,";
		}

		.xl156361 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 11.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: Calibri, sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: general;
			vertical-align: bottom;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl656361 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: Calibri, sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: center;
			vertical-align: middle;
			border: .5pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl666361 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 11.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: general;
			vertical-align: bottom;
			border-top: none;
			border-right: none;
			border-bottom: none;
			border-left: .5pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl676361 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 11.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: general;
			vertical-align: bottom;
			border-top: none;
			border-right: .5pt solid windowtext;
			border-bottom: none;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl686361 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: center;
			vertical-align: middle;
			border: .5pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl696361 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: center;
			vertical-align: middle;
			border: .5pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl706361 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: general;
			vertical-align: middle;
			border: .5pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl716361 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: center;
			vertical-align: middle;
			border: .5pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl726361 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 700;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: center;
			vertical-align: middle;
			border: .5pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl736361 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: left;
			vertical-align: middle;
			border: .5pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl746361 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
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

		.xl756361 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
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

		.xl766361 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
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

		.xl776361 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: windowtext;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: center;
			vertical-align: middle;
			border: .5pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl786361 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
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

		.xl796361 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
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

		.xl806361 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: center;
			vertical-align: middle;
			border-top: .5pt solid windowtext;
			border-right: none;
			border-bottom: none;
			border-left: .5pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl816361 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: center;
			vertical-align: middle;
			border-top: .5pt solid windowtext;
			border-right: .5pt solid windowtext;
			border-bottom: none;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl826361 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: center;
			vertical-align: middle;
			border-top: none;
			border-right: none;
			border-bottom: .5pt solid windowtext;
			border-left: .5pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl836361 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: center;
			vertical-align: middle;
			border-top: none;
			border-right: .5pt solid windowtext;
			border-bottom: .5pt solid windowtext;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl846361 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: general;
			vertical-align: middle;
			border-top: .5pt solid windowtext;
			border-right: none;
			border-bottom: .5pt solid windowtext;
			border-left: .5pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl856361 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: general;
			vertical-align: middle;
			border-top: .5pt solid windowtext;
			border-right: none;
			border-bottom: .5pt solid windowtext;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl866361 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: general;
			vertical-align: middle;
			border-top: .5pt solid windowtext;
			border-right: .5pt solid windowtext;
			border-bottom: .5pt solid windowtext;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl876361 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
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

		.xl886361 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
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

		.xl896361 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
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
			white-space: nowrap;
		}

		.xl906361 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
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
			white-space: nowrap;
		}

		.xl916361 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
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

		.xl926361 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
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
			white-space: normal;
		}

		.xl936361 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: center;
			vertical-align: middle;
			border-top: none;
			border-right: none;
			border-bottom: .5pt solid windowtext;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl946361 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: Calibri, sans-serif;
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

		.xl956361 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: Calibri, sans-serif;
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

		.xl966361 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: Calibri, sans-serif;
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

		.xl976361 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 11.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
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

		.xl986361 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 11.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
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

		.xl996361 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 11.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
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

		.xl1006361 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
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
			white-space: nowrap;
		}

		.xl1016361 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 11.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
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
			white-space: nowrap;
		}

		.xl1026361 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 11.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
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
			white-space: nowrap;
		}

		.xl1036361 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 11.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
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
			white-space: nowrap;
		}

		.xl1046361 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 11.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: left;
			vertical-align: middle;
			border: .5pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl1056361 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 11.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: general;
			vertical-align: bottom;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl1066361 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: general;
			vertical-align: middle;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl1076361 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 7.0pt;
			font-weight: 700;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: general;
			vertical-align: middle;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}
		-->
	</style>

</head>

<body>
	<!-- Define header and footer blocks before your content -->
	<header>
		<div id="patokan sppb_32621" align=center x:publishsource="Excel">
			<table border=0 cellpadding=0 cellspacing=0 width=1022 style='border-collapse:
		collapse;table-layout:fixed;width:767pt'>
				<col width=22 style='mso-width-source:userset;mso-width-alt:796;width:17pt'>
				<col width=38 style='mso-width-source:userset;mso-width-alt:1365;width:29pt'>
				<col width=64 span=14 style='width:48pt'>
				<col width=66 style='mso-width-source:userset;mso-width-alt:2332;width:49pt'>
				<tr height=20 style='mso-height-source:userset;height:15.0pt'>
					<td colspan=2 rowspan=3 height=59 class=xl8732621 width=60 style='border-right:
		.5pt solid black;border-bottom:.5pt solid black;height:44.4pt;width:46pt'><img src="assets/logo_wasa.png" alt="" width=50 height=50></td>
					<td colspan=12 rowspan=2 class=xl7932621 width=768 style='border-bottom:.5pt solid black;
		width:576pt'>SURAT PERMOHONAN PENGADAAN BARANG (PEMBELIAN)</td>
					<td class=xl7032621 width=64 style='width:48pt'>&nbsp;Form No.</td>
					<td colspan=2 class=xl7432621 width=130 style='border-right:.5pt solid black;
		width:97pt'>: WME/FSPBB/01</td>
				</tr>
				<tr height=20 style='mso-height-source:userset;height:15.0pt'>
					<td height=20 class=xl6432621 style='height:15.0pt'>&nbsp;SOP No.</td>
					<td colspan=2 class=xl9232621 style='border-right:.5pt solid black'>:
						WME/SOP/FHS-PL/01</td>
				</tr>
				<tr height=19 style='height:14.4pt'>
					<td height=19 class=xl6532621 style='height:14.4pt;border-top:none;
		border-left:none'>&nbsp;No. Urut</td>
					<td colspan=8 class=xl8332621 width=512 style='border-right:.5pt solid black;
		width:384pt'>: <?php echo $NO_URUT_SPPB; ?></td>
					<td class=xl6532621 style='border-top:none;border-left:none'>&nbsp;Tanggal</td>
					<td colspan=2 class=xl8332621 width=128 style='width:96pt'>: <?php echo
																					$TANGGAL_PEMBUATAN_SPPB_HARI; ?></td>
					<td class=xl6632621>&nbsp;Dept.</td>
					<td colspan=2 class=xl7732621 style='border-right:.5pt solid black'>:
						Procurement &amp; Logistic</td>
				</tr>
				<tr height=19 style='height:14.4pt'>
					<td height=19 class=xl6832621 style='height:14.4pt'>&nbsp;</td>
					<td class=xl9332621></td>
					<td class=xl9432621></td>
					<td class=xl9532621></td>
					<td class=xl9532621></td>
					<td class=xl9532621></td>
					<td class=xl9432621></td>
					<td class=xl9532621></td>
					<td class=xl9532621></td>
					<td class=xl9532621></td>
					<td class=xl9532621></td>
					<td class=xl9432621></td>
					<td class=xl9532621></td>
					<td class=xl9532621></td>
					<td class=xl9432621></td>
					<td class=xl9532621></td>
					<td class=xl6332621>&nbsp;</td>
				</tr>
				<tr height=19 style='mso-height-source:userset;height:14.4pt'>
					<td height=19 class=xl6732621 style='height:14.4pt'>&nbsp;</td>
					<td class=xl7132621>Proyek</td>
					<td colspan=14 class=xl8432621 width=896 style='border-right:.5pt solid black;
		width:672pt'>: <?php echo $NAMA_PROYEK; ?></td>
					<td class=xl6932621>&nbsp;</td>
				</tr>
				<tr height=22 style='mso-height-source:userset;height:16.5pt'>
					<td height=22 class=xl6732621 style='height:16.5pt'>&nbsp;</td>
					<td colspan=16 rowspan=2 class=xl9632621 width=1000 style='border-right:.5pt solid black;
		width:750pt'>Bersama ini kami mengajukan permintaan barang seperti tersebut
						di bawah ini:</td>
				</tr>
				<tr height=22 style='mso-height-source:userset;height:16.5pt'>
					<td height=22 class=xl7232621 width=22 style='height:16.5pt;width:17pt'>&nbsp;</td>
				</tr>
				<![if supportMisalignedColumns]>
				<tr height=0 style='display:none'>
					<td width=22 style='width:17pt'></td>
					<td width=38 style='width:29pt'></td>
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
					<td width=66 style='width:49pt'></td>
				</tr>
				<![endif]>
			</table>

		</div>
	</header>

	<footer>
		<img style="width: 80px;" src="<?php echo $GAMBAR_QR_2; ?>">  Validasi dokumen scan kode QR 
	</footer>

	<!-- Wrap the content of your PDF inside a main tag -->
	<main>

		<div class="myDiv">
			<div id="patokan sppb isi_6361" align=center x:publishsource="Excel">

				<table border=0 cellpadding=0 cellspacing=0 width=1022 style='border-collapse:
		collapse;table-layout:fixed;width:767pt'>
					<col width=22 style='mso-width-source:userset;mso-width-alt:796;width:17pt'>
					<col width=38 style='mso-width-source:userset;mso-width-alt:1365;width:29pt'>
					<col width=64 span=14 style='width:48pt'>
					<col width=66 style='mso-width-source:userset;mso-width-alt:2332;width:49pt'>
					<tr height=22 style='mso-height-source:userset;height:16.5pt'>
						<td rowspan=2 height=41 class=xl806361 width=22 style='border-bottom:.5pt solid black;
			height:30.9pt;width:17pt'>No</td>
						<td colspan=8 rowspan=2 class=xl806361 width=486 style='border-right:.5pt solid black;
			border-bottom:.5pt solid black;width:365pt'>Nama Barang/Jasa</td>
						<td colspan=4 rowspan=2 class=xl806361 width=256 style='border-right:.5pt solid black;
			border-bottom:.5pt solid black;width:192pt'>Spesifikasi</td>
						<td rowspan=2 class=xl776361 width=64 style='width:48pt'>Qty Diajukan SPP</td>
						<td rowspan=2 class=xl776361 width=64 style='width:48pt'>Satuan Barang</td>
						<td colspan=2 class=xl786361 width=130 style='border-right:.5pt solid black;
			border-left:none;width:97pt'>Periode Pemakaian</td>
					</tr>
					<tr height=19 style='height:14.4pt'>
						<td height=19 class=xl696361 width=64 style='height:14.4pt;border-top:none;
			border-left:none;width:48pt'>Mulai</td>
						<td class=xl696361 width=66 style='border-top:none;border-left:none;
			width:49pt'>Sampai</td>
					</tr>
					<tr height=20 style='mso-height-source:userset;height:15.0pt'>
						<td height=20 class=xl656361 width=22 style='height:15.0pt;border-top:none;
			width:17pt'>&nbsp;</td>
						<td colspan=8 class=xl946361 width=486 style='border-right:.5pt solid black;
			border-left:none;width:365pt'>&nbsp;</td>
						<td colspan=4 class=xl876361 width=256 style='border-right:.5pt solid black;
			border-left:none;width:192pt'>&nbsp;</td>
						<td class=xl686361 width=64 style='border-top:none;border-left:none;
			width:48pt'>&nbsp;</td>
						<td class=xl706361 width=64 style='border-top:none;border-left:none;
			width:48pt'>&nbsp;</td>
						<td class=xl696361 width=64 style='border-top:none;border-left:none;
			width:48pt'>&nbsp;</td>
						<td class=xl726361 width=66 style='border-top:none;border-left:none;
			width:49pt'>&nbsp;</td>
					</tr>

					<?php
					$hitung = 1;
					if (!empty($this->data['konten_SPPB_form'])) {
						foreach ($konten_SPPB_form as $item) {
					?>

							<tr height=20 style='mso-height-source:userset;height:15.0pt'>
								<td height=20 class=xl736361 width=22 style='height:15.0pt;border-top:none;
		width:17pt'>&nbsp;&nbsp;<?php echo $hitung; ?></td>
								<td colspan=8 class=xl746361 width=486 style='border-right:.5pt solid black;
		border-left:none;width:365pt'><span style='mso-spacerun:yes'>
									</span> &nbsp;&nbsp;<?php echo $item->NAMA_BARANG; ?></td>
								<td colspan=4 class=xl746361 width=256 style='border-right:.5pt solid black;
		border-left:none;width:192pt'><span style='mso-spacerun:yes'>
									</span>&nbsp;&nbsp;<?php echo $item->SPESIFIKASI_SINGKAT; ?></td>
								<td class=xl686361 width=64 style='border-top:none;border-left:none;
		width:48pt'><?php echo $item->JUMLAH_QTY_SPP; ?></td>
								<td class=xl696361 width=64 style='border-top:none;border-left:none;
		width:48pt'><?php echo $item->NAMA_SATUAN_BARANG; ?></td>
								<td class=xl736361 width=64 style='border-top:none;border-left:none;
		width:48pt'><?php echo $item->TANGGAL_MULAI_PAKAI_HARI; ?></td>
								<td class=xl736361 width=66 style='border-top:none;border-left:none;
		width:49pt'><?php echo $item->TANGGAL_SELESAI_PAKAI_HARI; ?></td>
							</tr>

					<?php
							$hitung = $hitung + 1;
						}
					} ?>

					<tr height=19 style='height:14.4pt'>
						<td height=19 class=xl696361 width=22 style='height:14.4pt;border-top:none;
		width:17pt'>&nbsp;</td>
						<td colspan=8 class=xl876361 width=486 style='border-right:.5pt solid black;
		border-left:none;width:365pt'>&nbsp;</td>
						<td colspan=4 class=xl976361 width=256 style='border-right:.5pt solid black;
		border-left:none;width:192pt'>&nbsp;</td>
						<td class=xl686361 width=64 style='border-top:none;border-left:none;
		width:48pt'>&nbsp;</td>
						<td class=xl696361 width=64 style='border-top:none;border-left:none;
		width:48pt'>&nbsp;</td>
						<td class=xl696361 width=64 style='border-top:none;border-left:none;
		width:48pt'>&nbsp;</td>
						<td class=xl726361 width=66 style='border-top:none;border-left:none;
		width:49pt'>&nbsp;</td>
					</tr>


					<tr height=19 style='height:14.4pt'>
						<td height=19 class=xl666361 style='height:14.4pt'>&nbsp;</td>
						<td class=xl1056361></td>
						<td class=xl1066361></td>
						<td class=xl1066361></td>
						<td class=xl1066361></td>
						<td class=xl1066361></td>
						<td class=xl1066361></td>
						<td class=xl1066361></td>
						<td class=xl1066361></td>
						<td class=xl1056361></td>
						<td class=xl1056361></td>
						<td class=xl1066361></td>
						<td class=xl1066361></td>
						<td class=xl1066361></td>
						<td class=xl1076361></td>
						<td class=xl1056361></td>
						<td class=xl676361>&nbsp;</td>
					</tr>
					<tr height=19 style='height:14.4pt'>
						<td height=19 class=xl666361 style='height:14.4pt'>&nbsp;</td>
						<td class=xl1056361></td>
						<td class=xl1066361></td>
						<td class=xl1066361></td>
						<td class=xl1066361></td>
						<td class=xl1066361></td>
						<td class=xl1066361></td>
						<td class=xl1066361></td>
						<td class=xl1066361></td>
						<td class=xl1056361></td>
						<td class=xl1056361></td>
						<td class=xl1066361></td>
						<td class=xl1066361></td>
						<td class=xl1066361></td>
						<td class=xl1076361></td>
						<td class=xl1056361></td>
						<td class=xl676361>&nbsp;</td>
					</tr>
					<tr height=19 style='height:14.4pt'>
						<td height=19 class=xl716361 style='height:14.4pt'>No</td>
						<td colspan=7 class=xl896361 style='border-right:.5pt solid black;border-left:
			none'>Nama Barang/Jasa<span style='mso-spacerun:yes'>�</span></td>
						<td colspan=9 class=xl896361 style='border-right:.5pt solid black;border-left:
			none'>Catatan SPPB</td>
					</tr>
					<tr height=30 style='mso-height-source:userset;height:14.4pt'>
						<td height=30 class=xl736361 width=22 style='height:14.4pt;border-top:none;
			width:17pt'><?php echo $hitung; ?></td>
						<td colspan=7 class=xl746361 width=422 style='border-right:.5pt solid black;
			border-left:none;width:317pt'>Dummy Barang</td>
						<td colspan=9 class=xl846361 width=578 style='border-right:.5pt solid black;
			border-left:none;width:433pt'>Dummy Catatan</td>
					</tr>
					<tr height=19 style='height:14.4pt'>
						<td height=19 class=xl1046361 style='height:14.4pt;border-top:none'>&nbsp;</td>
						<td colspan=7 class=xl1016361 style='border-right:.5pt solid black;
			border-left:none'>&nbsp;</td>
						<td colspan=9 class=xl746361 width=578 style='border-right:.5pt solid black;
			border-left:none;width:433pt'>&nbsp;</td>
					</tr>
					<![if supportMisalignedColumns]>
					<tr height=0 style='display:none'>
						<td width=22 style='width:17pt'></td>
						<td width=38 style='width:29pt'></td>
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
						<td width=66 style='width:49pt'></td>
					</tr>
					<![endif]>
				</table>

			</div>

		</div>

	</main>
</body>

</html>