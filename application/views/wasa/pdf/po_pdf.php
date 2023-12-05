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
			margin-top: 6.1cm;
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
			height: 2.5cm;

			font-size: 8.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: Calibri Light;
		}
	</style>

	<style id="patokan sppb_21533_Styles">
		<!--table
		{
			mso-displayed-decimal-separator: "\.";
			mso-displayed-thousand-separator: "\,";
		}

		.font521533 {
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Calibri Light", sans-serif;
			mso-font-charset: 0;
		}

		.font621533 {
			color: black;
			font-size: 7.0pt;
			font-weight: 700;
			font-style: normal;
			text-decoration: none;
			font-family: "Calibri Light", sans-serif;
			mso-font-charset: 0;
		}

		.font721533 {
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Calibri Light", sans-serif;
			mso-font-charset: 0;
		}

		.xl6321533 {
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

		.xl6421533 {
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

		.xl6421533left {
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
			vertical-align: left;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl6521533 {
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

		.xl6621533 {
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

		.xl6721533 {
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

		.xl6821533 {
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

		.xl6921533 {
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

		.xl7021533 {
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
			border: .5pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl7121533 {
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

		.xl7221533 {
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

		.xl7321533 {
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

		.xl7421533 {
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

		.xl7521533 {
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

		.xl7621533 {
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

		.xl7721533 {
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

		.xl7821533 {
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

		.xl7921533 {
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
			border-top: none;
			border-right: none;
			border-bottom: .5pt solid windowtext;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl8021533 {
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
			border-top: .5pt solid windowtext;
			border-right: none;
			border-bottom: none;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl8121533 {
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

		.xl8221533 {
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

		.xl8321533 {
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

		.xl8421533 {
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
			border-top: .5pt solid windowtext;
			border-right: none;
			border-bottom: none;
			border-left: .5pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl8521533 {
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
			border-top: none;
			border-right: none;
			border-bottom: none;
			border-left: .5pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl8621533 {
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
			border-top: none;
			border-right: none;
			border-bottom: .5pt solid windowtext;
			border-left: .5pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl8721533 {
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
			white-space: nowrap;
		}

		.xl8821533 {
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

		.xl8821533kiri {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 5px;
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
			border-top: .5pt solid windowtext;
			border-right: none;
			border-bottom: .5pt solid windowtext;
			border-left: .5pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl8921533 {
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

		.xl9021533 {
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

		.xl9121533 {
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

		.xl9221533 {
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

		.xl9321533 {
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

		.xl9421533 {
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

		.xl9521533 {
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
			border-top: none;
			border-right: none;
			border-bottom: .5pt solid windowtext;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl9621533 {
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

		.xl9721533 {
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
			border-top: .5pt solid windowtext;
			border-right: none;
			border-bottom: none;
			border-left: .5pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl9821533 {
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
			border-top: .5pt solid windowtext;
			border-right: none;
			border-bottom: .5pt solid windowtext;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl9921533 {
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
			border-top: .5pt solid windowtext;
			border-right: .5pt solid windowtext;
			border-bottom: .5pt solid windowtext;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl10021533 {
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

		.xl10121533 {
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

		.xl10221533 {
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

		.xl10321533 {
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
			border-top: .5pt solid windowtext;
			border-right: none;
			border-bottom: .5pt solid windowtext;
			border-left: .5pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl10421533 {
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

		.xl10521533 {
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
			border-top: none;
			border-right: none;
			border-bottom: .5pt solid windowtext;
			border-left: .5pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl10621533 {
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
			border-top: none;
			border-right: .5pt solid windowtext;
			border-bottom: .5pt solid windowtext;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl10721533 {
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
			vertical-align: middle;
			border-top: .5pt solid windowtext;
			border-right: none;
			border-bottom: none;
			border-left: .5pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl10821533 {
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
			vertical-align: middle;
			border-top: .5pt solid windowtext;
			border-right: .5pt solid windowtext;
			border-bottom: none;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl10921533 {
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
			vertical-align: middle;
			border-top: none;
			border-right: none;
			border-bottom: none;
			border-left: .5pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl11021533 {
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
			vertical-align: middle;
			border-top: none;
			border-right: .5pt solid windowtext;
			border-bottom: none;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl11121533 {
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
			vertical-align: middle;
			border: .5pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl11221533 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 22.0pt;
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

		.xl11321533 {
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
			border-top: .5pt solid windowtext;
			border-right: none;
			border-bottom: none;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl11421533 {
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
			border-top: .5pt solid windowtext;
			border-right: .5pt solid windowtext;
			border-bottom: none;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl11521533 {
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

		.xl11621533 {
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
			border-top: none;
			border-right: .5pt solid windowtext;
			border-bottom: none;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl11721533 {
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
			border-top: none;
			border-right: none;
			border-bottom: .5pt solid windowtext;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl11821533 {
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
			border-top: none;
			border-right: .5pt solid windowtext;
			border-bottom: .5pt solid windowtext;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl11921533 {
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
			vertical-align: middle;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl12021533 {
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

		.xl12121533 {
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
			border-top: .5pt solid windowtext;
			border-right: none;
			border-bottom: none;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl12221533 {
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
			border-top: none;
			border-right: none;
			border-bottom: .5pt solid windowtext;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl12321533 {
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
			border-bottom: none;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl12421533 {
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
			border-bottom: none;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl12521533 {
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
			border-top: none;
			border-right: .5pt solid windowtext;
			border-bottom: none;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl12621533 {
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
			border-top: none;
			border-right: .5pt solid windowtext;
			border-bottom: .5pt solid windowtext;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl12721533 {
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
			border-top: .5pt solid windowtext;
			border-right: none;
			border-bottom: none;
			border-left: .5pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl12821533 {
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
			border-top: none;
			border-right: none;
			border-bottom: none;
			border-left: .5pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl12921533 {
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
			border-top: none;
			border-right: none;
			border-bottom: .5pt solid windowtext;
			border-left: .5pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}
		-->
	</style>

	<style id="patokan sppb_26359_Styles">
		<!--table
		{
			mso-displayed-decimal-separator: "\.";
			mso-displayed-thousand-separator: "\,";
		}

		.xl6526359 {
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

		.xl6626359 {
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

		.xl6726359 {
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

		.xl6826359 {
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

		.xl6926359 {
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

		.xl7026359 {
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

		.xl7126359 {
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
			vertical-align: middle;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl7326359 {
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
			text-align: left;
			vertical-align: middle;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl7226359 {
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
			border-top: none;
			border-right: none;
			border-bottom: .5pt solid windowtext;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl7426359 {
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

		.xl7526359 {
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
			white-space: nowrap;
		}

		.xl7626359 {
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

		.xl7726359 {
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
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}
		-->
	</style>

	<style id="patokan sppb_26341_Styles"><!--table
			{mso-displayed-decimal-separator:"\.";
			mso-displayed-thousand-separator:"\,";}
		.xl6526341
			{padding-top:1px;
			padding-right:1px;
			padding-left:1px;
			mso-ignore:padding;
			color:black;
			font-size:11.0pt;
			font-weight:400;
			font-style:normal;
			text-decoration:none;
			font-family:"Calibri Light", sans-serif;
			mso-font-charset:0;
			mso-number-format:General;
			text-align:general;
			vertical-align:bottom;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl6626341
			{padding-top:1px;
			padding-right:1px;
			padding-left:1px;
			mso-ignore:padding;
			color:black;
			font-size:7.0pt;
			font-weight:400;
			font-style:normal;
			text-decoration:none;
			font-family:"Calibri Light", sans-serif;
			mso-font-charset:0;
			mso-number-format:General;
			text-align:left;
			vertical-align:bottom;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl6726341
			{padding-top:1px;
			padding-right:1px;
			padding-left:1px;
			mso-ignore:padding;
			color:black;
			font-size:11.0pt;
			font-weight:400;
			font-style:normal;
			text-decoration:none;
			font-family:"Calibri Light", sans-serif;
			mso-font-charset:0;
			mso-number-format:General;
			text-align:left;
			vertical-align:middle;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
--></style>

</head>

<body>
	<!-- Define header and footer blocks before your content -->
	<header>

		<div id="patokan sppb_21533" align=center x:publishsource="Excel">

			<table border=0 cellpadding=0 cellspacing=0 width=875 class=xl6321533 style='border-collapse:collapse;table-layout:fixed;width:656pt'>
				<col class=xl6321533 width=43 style='mso-width-source:userset;mso-width-alt: 1536;width:32pt'>
				<col class=xl6321533 width=64 span=13 style='width:48pt'>
				<tr height=20 style='mso-height-source:userset;height:10.05pt'>
					<td rowspan=3 height=62 class=xl11121533 width=43 style='height:46.5pt;width:32pt'><img src="assets/logo_wasa.png" alt="" width=50 height=50></td>
					<td colspan=5 rowspan=3 class=xl11221533 width=320 style='width:240pt'>ORDER
						PEMBELIAN</td>
					<td class=xl8421533 width=64 style='border-left:none;width:48pt'><span style='mso-spacerun:yes'>&nbsp;Form No.</td>
					<td colspan=2 class=xl11321533 width=128 style='border-right:.5pt solid black;width:96pt'>: WME/FOP/02</td>
					<td colspan=2 rowspan=2 class=xl10721533 width=128 style='border-right:.5pt solid black;width:96pt'><img src="assets/logo_sgs_ukas.png" alt="" width=100 height=50></td>
					<td class=xl6321533 width=64 style='width:48pt'></td>
					<td class=xl6321533 width=64 style='width:48pt'></td>
					<td class=xl6321533 width=64 style='width:48pt'></td>
				</tr>
				<tr height=20 style='mso-height-source:userset;height:10.05pt'>
					<td height=20 class=xl8521533 width=64 style='height:10.05pt;border-left:none;width:48pt'><span style='mso-spacerun:yes'>&nbsp;SOP No</td>
					<td colspan=2 class=xl11521533 width=128 style='border-right:.5pt solid black;width:96pt'>: WME/SOP/FHS-PL/01</td>
					<td class=xl6321533></td>
					<td class=xl6321533></td>
					<td class=xl6321533></td>
				</tr>
				<tr height=22 style='mso-height-source:userset;height:10.05pt'>
					<td height=22 class=xl8621533 width=64 style='height:10.05pt;border-left:none;width:48pt'><span style='mso-spacerun:yes'>&nbsp;Dept.</td>
					<td colspan=2 class=xl11721533 width=128 style='border-right:.5pt solid black;width:96pt'>: Procurement &amp; Logistic</td>
					<td colspan=2 class=xl10521533 width=128 style='border-right:.5pt solid black;border-left:none;width:96pt'>Certificate ID07/0831</td>
					<td class=xl6321533></td>
					<td class=xl6321533></td>
					<td class=xl6321533></td>
				</tr>
				<tr height=19 style='height:10.05pt'>
					<td height=19 class=xl7921533 style='height:10.05pt'>&nbsp;</td>
					<td class=xl6321533></td>
					<td class=xl6321533></td>
					<td class=xl6321533></td>
					<td class=xl6321533></td>
					<td class=xl6321533></td>
					<td class=xl6321533></td>
					<td class=xl6321533></td>
					<td class=xl6321533></td>
					<td class=xl6321533></td>
					<td class=xl6321533></td>
					<td class=xl6321533></td>
					<td class=xl6321533></td>
					<td class=xl6321533></td>
				</tr>
				<tr height=19 style='mso-height-source:userset;height:10.05pt'>
					<td colspan=2 height=19 class=xl12721533 width=107 style='height:10.05pt;width:80pt'><span style='mso-spacerun:yes'>&nbsp;No. Order Pembelian</td>
					<td colspan=4 class=xl12321533 width=256 style='border-right:.5pt solid black;width:192pt'>: <?php echo $NO_URUT_PO; ?></td>
					<td class=xl6321533></td>
					<td class=xl6321533></td>
					<td colspan=3 class=xl9621533>Kepada Yth.,</td>
					<td class=xl6321533></td>
					<td class=xl6321533></td>
					<td class=xl6321533></td>
				</tr>
				<tr height=19 style='mso-height-source:userset;height:10.05pt'>
					<td colspan=2 height=19 class=xl12821533 width=107 style='height:10.05pt;width:80pt'><span style='mso-spacerun:yes'>&nbsp;Tanggal Order Pemb.</td>
					<td colspan=4 class=xl6421533 width=256 style='border-right:.5pt solid black;width:192pt'>: <?php echo $TANGGAL_DOKUMEN_PO; ?></td>
					<td class=xl6321533></td>
					<td class=xl6321533></td>
					<td colspan=3 class=xl6421533left width=192 style='width:144pt'><?php echo $NAMA_VENDOR; ?></td>
					<td class=xl6321533></td>
					<td class=xl6321533></td>
					<td class=xl6321533></td>
				</tr>
				<tr height=19 style='mso-height-source:userset;height:10.05pt'>
					<td colspan=2 height=19 class=xl12821533 width=107 style='height:10.05pt;width:80pt'><span style='mso-spacerun:yes'>&nbsp;No. SPP</td>
					<td colspan=4 class=xl6421533 width=256 style='border-right:.5pt solid black;width:192pt'>: <?php echo $NO_URUT_SPP; ?></td>
					<td class=xl6321533></td>
					<td class=xl6321533></td>
					<td colspan=3 rowspan=4 class=xl6421533left width=192 style='width:144pt'><?php echo $ALAMAT_VENDOR; ?><br>Up. Bpk/Ibu <?php echo $NAMA_PIC_VENDOR; ?><br> <?php echo $NO_HP_PIC_VENDOR; ?></td>
					<td class=xl6321533></td>
					<td class=xl6321533></td>
					<td class=xl6321533></td>
				</tr>
				<tr height=19 style='mso-height-source:userset;height:10.05pt'>
					<td colspan=2 height=19 class=xl12921533 width=107 style='height:10.05pt;width:80pt'><span style='mso-spacerun:yes'>&nbsp;No. SPPB</td>
					<td colspan=4 class=xl9521533 width=256 style='border-right:.5pt solid black;width:192pt'>: <?php echo $NO_URUT_SPPB; ?></td>
					<td class=xl6321533></td>
					<td class=xl6321533></td>
					<td class=xl6321533></td>
					<td class=xl6321533></td>
					<td class=xl6321533></td>
				</tr>
			</table>
		</div>

	</header>

	<footer>
		<div id="patokan sppb_26341" align=center x:publishsource="Excel">

			<table border=0 cellpadding=0 cellspacing=0 width=683 class=xl6526341
			style='border-collapse:collapse;table-layout:fixed;width:512pt'>
			<col class=xl6526341 width=43 style='mso-width-source:userset;mso-width-alt:
			1536;width:32pt'>
			<col class=xl6526341 width=64 span=10 style='width:48pt'>
			<tr height=12 style='mso-height-source:userset;height:9.0pt'>
			<td colspan=2 rowspan=5 height=60 class=xl6726341 width=107 style='height:
			45.0pt;width:80pt'><img style="width: 80px;" src="<?php echo $GAMBAR_QR_2; ?>"></td>
			<td colspan=9 class=xl6626341 width=576 style='width:432pt'>Lembar 1 :
			Supplier/Vendor &amp; Keuangan (pada tagihan)</td>
			</tr>
			<tr height=12 style='mso-height-source:userset;height:9.0pt'>
			<td colspan=9 height=12 class=xl6626341 style='height:9.0pt'>Lembar 2 :
			Supplier</td>
			</tr>
			<tr height=12 style='mso-height-source:userset;height:9.0pt'>
			<td colspan=9 height=12 class=xl6626341 style='height:9.0pt'>Lembar 3 : Bag.
			Akunting</td>
			</tr>
			<tr height=12 style='mso-height-source:userset;height:9.0pt'>
			<td colspan=9 height=12 class=xl6626341 style='height:9.0pt'>Lembar 4 :
			Logistik</td>
			</tr>
			<tr height=12 style='mso-height-source:userset;height:9.0pt'>
			<td colspan=9 height=12 class=xl6626341 style='height:9.0pt'>Lembar 5 : Arsip</td>
			</tr>

			</table>

		</div>
	</footer>

	

	<!-- Wrap the content of your PDF inside a main tag -->
	<main>
		<div class="myDiv">
		
			<?php if($NOMINAL_DISKON > 0) {?>
			<div id="patokan sppb_21533" align=center x:publishsource="Excel">

				<table border=0 cellpadding=0 cellspacing=0 width=875 class=xl6321533 style='border-collapse:collapse;table-layout:fixed;width:656pt'>

					<tr height=19 style='mso-height-source:userset;height:10.05pt'>
						<td colspan=2 height=19 class=xl8821533kiri width=107 style='height:10.05pt; width:80pt'><span style='mso-spacerun:yes'>Syarat Pembayaran          :<font class="font721533"><span style='mso-spacerun:yes'>&nbsp;</font>
						</td>
						<td colspan=4 class=xl9021533 width=256 style='border-right:.5pt solid black;width:192pt'><?php echo $TERM_OF_PAYMENT; ?></td>
						<td colspan=2 class=xl9421533 width=128 style='border-left:none;width:96pt'>
							<font class="font621533"><span style='mso-spacerun:yes'>&nbsp;Lokasi
							<?php if ($JENIS_PENGADAAN == "Pembelian") {?>
								Penyerahan 
							<?php }?>
							<?php if ($JENIS_PENGADAAN == "Rental") {?>
								Penyerahan 
							<?php }?>
							<?php if ($JENIS_PENGADAAN == "Jasa") {?>
								Pekerjaan 
							<?php }?>
							&nbsp;&nbsp;&nbsp;:</font>
							<font class="font521533"><span style='mso-spacerun:yes'>&nbsp;</font>
						</td>
						<td colspan=3 class=xl9221533 width=192 style='border-right:.5pt solid black;width:144pt;padding-top: 8px;padding-bottom: 8px;'><?php echo $LOKASI_PENYERAHAN; ?></td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
						<td class=xl6621533></td>
					</tr>
					<thead style="display: table-header-group">
						<tr height=26 style='height:19.2pt'>
							<td height=26 class=xl7821533 style='height:19.2pt;border-top:0.5pt;width: 3%;border-collapse:collapse'>No.</td>
							<td class=xl6721533 width=64 style='border-top:0.5pt;border-left:none;width:14.2%;border-collapse:collapse'>Nama Barang</td>
							<td colspan=2 class=xl6821533 width=128 style='width:13%;border-collapse:collapse;border-top:0.5pt'>Spesifikasi</td>
							<td class=xl6921533 width=64 style='border-top:0.5pt;width:5%;border-collapse:collapse'>Jenis Barang</td>
							<td class=xl6821533 width=64 style='border-top:0.5pt;border-left:none;width:6%;border-collapse:collapse'>Kuantiti</td>
							<td class=xl6821533 width=64 style='border-top:0.5pt;border-left:none;width:6%;border-collapse:collapse'>Satuan</td>
							<td colspan=2 class=xl6721533 width=128 style='border-right:.5pt solid black;border-left:none;width:10%;border-collapse:collapse;border-top:0.5pt'>Harga Satuan</td>
							<td colspan=2 class=xl6721533 width=128 style='border-right:.5pt solid black;border-left:none;width:10%;border-collapse:collapse;border-top:0.5pt'>Total</td>
							<td class=xl6321533></td>
							<td class=xl6321533></td>
							<td class=xl6321533></td>
						</tr>
					</thead>
					<?php
					$hitung = 1;
					if (!empty($this->data['konten_PO_form'])) {
						foreach ($konten_PO_form as $item) {
					?>
							<tr height=22 style='mso-height-source:userset;height:10.05pt;border-collapse:collapse'>
								<td height=22 class=xl7221533 width=43 style='height:10.05pt;border-top:.5pt;width:32pt;border-collapse:collapse'><?php echo $hitung; ?></td>
								<td class=xl7021533 width=64 style='border-top:.5pt;border-left:none;width:48pt;border-collapse:collapse;padding-left: 5px;'><?php echo $item->NAMA_BARANG; ?></td>
								<td colspan=2 class=xl10421533 width=128 style='border-top:.5pt;border-right:.5pt solid black;border-left:none;width:96pt'><?php echo $item->SPESIFIKASI_SINGKAT;
								?> </td>
								<td class=xl7121533 width=64 style='border-top:.5pt;width:48pt;border-collapse:collapse'><?php echo $item->KODE_KLASIFIKASI_BARANG; ?></td>
								<td class=xl7221533 width=64 style='border-top:.5pt;border-left:none;width:48pt;border-collapse:collapse'><?php echo $item->JUMLAH_BARANG; ?></td>
								<td class=xl7221533 width=64 style='border-top:.5pt;border-left:none;width:48pt;border-collapse:collapse'><?php echo $item->SATUAN_BARANG; ?></td>
								<td colspan=2 class=xl10021533 width=128 style='border-top:.5pt;border-right:.5pt solid black;border-left:none;width:96pt;border-collapse:collapse'>
									Rp. <?php echo
										number_format(
											$item->HARGA_SATUAN_BARANG_FIX,
											0,
											",",
											"."
										); ?> &nbsp;
								</td>
								<td colspan=2 class=xl10021533 width=128 style='border-top:.5pt;border-right:.5pt solid black;border-left:none;width:96pt;border-collapse:collapse'>

									Rp. <?php echo number_format($item->HARGA_TOTAL_FIX, 0, ",", "."); ?>&nbsp;
								</td>
								<td class=xl7321533></td>
								<td class=xl6321533></td>
								<td class=xl6321533></td>
							</tr>
					<?php
							$hitung = $hitung + 1;
						}
					} ?>

					<?php
					$batas = $BARIS_KOSONG;
						for ($x = 0; $x <= $batas; $x++) {
					?>
							<tr height=22 style='mso-height-source:userset;height:10.05pt;border-collapse:collapse'>
								<td height=22 class=xl7221533 width=43 style='height:10.05pt;border-top:.5pt;width:32pt;border-collapse:collapse'></td>
								<td class=xl7021533 width=64 style='border-top:.5pt;border-left:none;width:48pt;border-collapse:collapse;padding-left: 5px;'></td>
								<td colspan=2 class=xl10421533 width=128 style='border-top:.5pt;border-right:.5pt solid black;border-left:none;width:96pt'></td>
								<td class=xl7121533 width=64 style='border-top:.5pt;width:48pt;border-collapse:collapse'></td>
								<td class=xl7221533 width=64 style='border-top:.5pt;border-left:none;width:48pt;border-collapse:collapse'></td>
								<td class=xl7221533 width=64 style='border-top:.5pt;border-left:none;width:48pt;border-collapse:collapse'></td>
								<td colspan=2 class=xl10021533 width=128 style='border-top:.5pt;border-right:.5pt solid black;border-left:none;width:96pt;border-collapse:collapse'></td>
								<td colspan=2 class=xl10021533 width=128 style='border-top:.5pt;border-right:.5pt solid black;border-left:none;width:96pt;border-collapse:collapse'>
								</td>
								<td class=xl7321533></td>
								<td class=xl6321533></td>
								<td class=xl6321533></td>
							</tr>
					<?php
						} ?>
					<tr height=19 style='height:10.05pt'>
						<td colspan=9 height=19 class=xl10321533 width=555 style='border-right:.5pt solid black;height:10.05pt;width:416pt'>SUB TOTAL &nbsp;</td>
						<td colspan=2 class=xl10021533 width=128 style='border-right:.5pt solid black;border-left:none;width:96pt'>
							Rp. <?php echo number_format($TOTAL_HARGA_PO_BARANG, 0, ",", "."); ?>&nbsp;
						</td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
					</tr>
					<tr height=19 style='height:10.05pt'>
						<td colspan=9 height=19 class=xl10321533 width=555 style='border-right:.5pt solid black;height:10.05pt;width:416pt'>DISKON &nbsp;</td>
						<td colspan=2 class=xl10021533 width=128 style='border-right:.5pt solid black;border-left:none;width:96pt'>
  							Rp. <?php echo number_format($NOMINAL_DISKON, 0, ",", "."); ?>&nbsp;
						</td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
					</tr>
					<tr height=19 style='height:10.05pt'>
						<td colspan=9 height=19 class=xl10321533 width=555 style='border-right:.5pt solid black;height:10.05pt;width:416pt'>SUB TOTAL SETELAH DISKON &nbsp;</td>
						<td colspan=2 class=xl10021533 width=128 style='border-right:.5pt solid black;border-left:none;width:96pt'>
  							Rp. <?php echo number_format($SUB_TOTAL_SETELAH_DISKON, 0, ",", "."); ?>&nbsp;
						</td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
					</tr>
					<tr height=19 style='height:10.05pt'>
						<td colspan=9 height=19 class=xl10321533 width=555 style='border-right:.5pt solid black;height:10.05pt;width:416pt'><?php echo $LABEL; ?>&nbsp;</td>
						<td colspan=2 class=xl10021533 width=128 style='border-right:.5pt solid black;border-left:none;width:96pt'>
							Rp. <?php echo number_format($TOTAL_PAJAK_PO_BARANG, 0, ",", "."); ?>&nbsp;
						</td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
					</tr>
					<tr height=19 style='height:10.05pt'>
						<td colspan=9 height=19 class=xl9721533 width=555 style='border-right:.5pt solid black;border-bottom:.5pt solid black;height:10.05pt;width:416pt'>TOTAL&nbsp;</td>
						<td colspan=2 class=xl10021533 width=128 style='border-right:.5pt solid black;border-left:none;width:96pt'>Rp. 
							<?php echo number_format($TOTAL_ALL_PO_BARANG, 0, ",", "."); ?>&nbsp;
						</td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
					</tr>

				</table>
			</div>
			<?php } else { ?>
			<div id="patokan sppb_21533" align=center x:publishsource="Excel">

				<table border=0 cellpadding=0 cellspacing=0 width=875 class=xl6321533 style='border-collapse:collapse;table-layout:fixed;width:656pt'>

					<tr height=19 style='mso-height-source:userset;height:10.05pt'>
						<td colspan=2 height=19 class=xl8821533kiri width=107 style='height:10.05pt; width:80pt'><span style='mso-spacerun:yes'>Syarat Pembayaran&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<font class="font721533"><span style='mso-spacerun:yes'>&nbsp;</font>
						</td>
						<td colspan=4 class=xl9021533 width=256 style='border-right:.5pt solid black;width:192pt'><?php echo $TERM_OF_PAYMENT; ?></td>
						<td colspan=2 class=xl9421533 width=128 style='border-left:none;width:96pt'>
							<font class="font621533"><span style='mso-spacerun:yes'>&nbsp;Lokasi
							<?php if ($JENIS_PENGADAAN == "Pembelian") {?>
								Penyerahan 
							<?php }?>
							<?php if ($JENIS_PENGADAAN == "Rental") {?>
								Penyerahan 
							<?php }?>
							<?php if ($JENIS_PENGADAAN == "Jasa") {?>
								Pekerjaan 
							<?php }?>
							&nbsp;&nbsp;&nbsp;:</font>
							<font class="font521533"><span style='mso-spacerun:yes'>&nbsp;</font>
						</td>
						<td colspan=3 class=xl9221533 width=192 style='border-right:.5pt solid black;width:144pt;padding-top: 8px;padding-bottom: 8px;'><?php echo $LOKASI_PENYERAHAN; ?></td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
						<td class=xl6621533></td>
					</tr>
					<thead style="display: table-header-group">
						<tr height=26 style='height:19.2pt'>
							<td height=26 class=xl7821533 style='height:19.2pt;border-top:0.5pt;width: 3%;border-collapse:collapse'>No.</td>
							<td class=xl6721533 width=64 style='border-top:0.5pt;border-left:none;width:14.2%;border-collapse:collapse'>Nama Barang</td>
							<td colspan=2 class=xl6821533 width=128 style='width:13%;border-collapse:collapse;border-top:0.5pt'>Spesifikasi</td>
							<td class=xl6921533 width=64 style='border-top:0.5pt;width:5%;border-collapse:collapse'>Jenis Barang</td>
							<td class=xl6821533 width=64 style='border-top:0.5pt;border-left:none;width:6%;border-collapse:collapse'>Kuantiti</td>
							<td class=xl6821533 width=64 style='border-top:0.5pt;border-left:none;width:6%;border-collapse:collapse'>Satuan</td>
							<td colspan=2 class=xl6721533 width=128 style='border-right:.5pt solid black;border-left:none;width:10%;border-collapse:collapse;border-top:0.5pt'>Harga Satuan</td>
							<td colspan=2 class=xl6721533 width=128 style='border-right:.5pt solid black;border-left:none;width:10%;border-collapse:collapse;border-top:0.5pt'>Total</td>
							<td class=xl6321533></td>
							<td class=xl6321533></td>
							<td class=xl6321533></td>
						</tr>
					</thead>
					<?php
					$hitung = 1;
					if (!empty($this->data['konten_PO_form'])) {
						foreach ($konten_PO_form as $item) {
					?>
							<tr height=22 style='mso-height-source:userset;height:10.05pt;border-collapse:collapse'>
								<td height=22 class=xl7221533 width=43 style='height:10.05pt;border-top:.5pt;width:32pt;border-collapse:collapse'><?php echo $hitung; ?></td>
								<td class=xl7021533 width=64 style='border-top:.5pt;border-left:none;width:48pt;border-collapse:collapse;padding-left: 5px;'><?php echo $item->NAMA_BARANG; ?></td>
								<td colspan=2 class=xl10421533 width=128 style='border-top:.5pt;border-right:.5pt solid black;border-left:none;width:96pt'><?php echo $item->SPESIFIKASI_SINGKAT;
								?> </td>
								<td class=xl7121533 width=64 style='border-top:.5pt;width:48pt;border-collapse:collapse'><?php echo
																															$item->KODE_KLASIFIKASI_BARANG; ?></td>
								<td class=xl7221533 width=64 style='border-top:.5pt;border-left:none;width:48pt;border-collapse:collapse'><?php echo $item->JUMLAH_BARANG; ?></td>
								<td class=xl7221533 width=64 style='border-top:.5pt;border-left:none;width:48pt;border-collapse:collapse'><?php echo $item->SATUAN_BARANG; ?></td>
								<td colspan=2 class=xl10021533 width=128 style='border-top:.5pt;border-right:.5pt solid black;border-left:none;width:96pt;border-collapse:collapse'>
									Rp. <?php echo
										number_format(
											$item->HARGA_SATUAN_BARANG_FIX,
											0,
											",",
											"."
										); ?> &nbsp;
								</td>
								<td colspan=2 class=xl10021533 width=128 style='border-top:.5pt;border-right:.5pt solid black;border-left:none;width:96pt;border-collapse:collapse'>

									Rp. <?php echo number_format($item->HARGA_TOTAL_FIX, 0, ",", "."); ?>&nbsp;
								</td>
								<td class=xl7321533></td>
								<td class=xl6321533></td>
								<td class=xl6321533></td>
							</tr>
					<?php
							$hitung = $hitung + 1;
						}
					} ?>

					<?php
					$batas = $BARIS_KOSONG;
						for ($x = 0; $x < $batas; $x++) {
					?>
							<tr height=22 style='mso-height-source:userset;height:10.05pt;border-collapse:collapse'>
								<td height=22 class=xl7221533 width=43 style='height:10.05pt;border-top:.5pt;width:32pt;border-collapse:collapse'></td>
								<td class=xl7021533 width=64 style='border-top:.5pt;border-left:none;width:48pt;border-collapse:collapse;padding-left: 5px;'></td>
								<td colspan=2 class=xl10421533 width=128 style='border-top:.5pt;border-right:.5pt solid black;border-left:none;width:96pt'></td>
								<td class=xl7121533 width=64 style='border-top:.5pt;width:48pt;border-collapse:collapse'></td>
								<td class=xl7221533 width=64 style='border-top:.5pt;border-left:none;width:48pt;border-collapse:collapse'></td>
								<td class=xl7221533 width=64 style='border-top:.5pt;border-left:none;width:48pt;border-collapse:collapse'></td>
								<td colspan=2 class=xl10021533 width=128 style='border-top:.5pt;border-right:.5pt solid black;border-left:none;width:96pt;border-collapse:collapse'></td>
								<td colspan=2 class=xl10021533 width=128 style='border-top:.5pt;border-right:.5pt solid black;border-left:none;width:96pt;border-collapse:collapse'>
								</td>
								<td class=xl7321533></td>
								<td class=xl6321533></td>
								<td class=xl6321533></td>
							</tr>
					<?php
						} ?>

					<tr height=19 style='height:10.05pt'>
						<td colspan=9 height=19 class=xl10321533 width=555 style='border-right:.5pt solid black;height:10.05pt;width:416pt'>SUB TOTAL &nbsp;</td>
						<td colspan=2 class=xl10021533 width=128 style='border-right:.5pt solid black;border-left:none;width:96pt'>
							Rp. <?php echo number_format($TOTAL_HARGA_PO_BARANG, 0, ",", "."); ?>&nbsp;
						</td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
					</tr>
					<tr height=19 style='height:10.05pt'>
						<td colspan=9 height=19 class=xl10321533 width=555 style='border-right:.5pt solid black;height:10.05pt;width:416pt'><?php echo $LABEL; ?>&nbsp;</td>
						<td colspan=2 class=xl10021533 width=128 style='border-right:.5pt solid black;border-left:none;width:96pt'>
							Rp. <?php echo number_format($TOTAL_PAJAK_PO_BARANG, 0, ",", "."); ?>&nbsp;
						</td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
					</tr>
					<tr height=19 style='height:10.05pt'>
						<td colspan=9 height=19 class=xl9721533 width=555 style='border-right:.5pt solid black;border-bottom:.5pt solid black;height:10.05pt;width:416pt'>TOTAL&nbsp;</td>
						<td colspan=2 class=xl10021533 width=128 style='border-right:.5pt solid black;border-left:none;width:96pt'>Rp. 
							<?php echo number_format($TOTAL_ALL_PO_BARANG, 0, ",", "."); ?>&nbsp;
						</td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
					</tr>
					
				</table>
			</div>
			<?php } ?>

			<?php
			function penyebut($nilai)
			{
				$nilai = abs($nilai);
				$huruf = array(" ", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
				$temp = "";
				if ($nilai < 12) {
					$temp = " " . $huruf[$nilai];
				} else if ($nilai < 20) {
					$temp = penyebut($nilai - 10) . " Belas";
				} else if ($nilai < 100) {
					$temp = penyebut($nilai / 10) . " Puluh" . penyebut($nilai % 10);
				} else if ($nilai < 200) {
					$temp = " Seratus" . penyebut($nilai - 100);
				} else if ($nilai < 1000) {
					$temp = penyebut($nilai / 100) . " Ratus" . penyebut($nilai % 100);
				} else if ($nilai < 2000) {
					$temp = " Seribu" . penyebut($nilai - 1000);
				} else if ($nilai < 1000000) {
					$temp = penyebut($nilai / 1000) . " Ribu" . penyebut($nilai % 1000);
				} else if ($nilai < 1000000000) {
					$temp = penyebut($nilai / 1000000) . " Juta" . penyebut($nilai % 1000000);
				} else if ($nilai < 1000000000000) {
					$temp = penyebut($nilai / 1000000000) . " Milyar" . penyebut(fmod($nilai, 1000000000));
				} else if ($nilai < 1000000000000000) {
					$temp = penyebut($nilai / 1000000000000) . " Trilyun" . penyebut(fmod($nilai, 1000000000000));
				}
				return $temp;
			}

			function terbilang($nilai)
			{
				if ($nilai < 0) {
					$hasil = "Minus " . trim(penyebut($nilai));
				} else {
					$hasil = trim(penyebut($nilai));
				}
				return $hasil;
			}
			?>

			<div id="patokan sppb_26359" align=center x:publishsource="Excel">
				<table border=0 cellpadding=0 cellspacing=0 width=811 class=xl6526359 style='border-collapse:collapse;table-layout:fixed;width:608pt'>
					<tr height=19 style='mso-height-source:userset;height:10.05pt'>
						<td colspan=2 height=19 class=xl7426359 style='height:10.05pt'>Terbilang</td>
						<td colspan=9 class=xl7226359 width=576 style='width:432pt'>: <?php echo
							terbilang($TOTAL_ALL_PO_BARANG); ?> Rupiah</td>
						<td class=xl6526359></td>
						<td class=xl6526359></td>
					</tr>
					<tr height=19 style='height:10.05pt'>
						<td colspan=2 height=19 class=xl7426359 style='height:10.05pt'>Keperluan</td>
						<td colspan=9 class=xl7526359>: <?php echo ($CTT_KEPERLUAN); ?></td>
						<td class=xl6526359></td>
						<td class=xl6526359></td>
					</tr>
					<?php
					$hitung = 1;

					?>
					<tr height=19 style='height:10.05pt'>
						<td height=19 class=xl6526359 style='height:10.05pt'></td>
						<td class=xl7026359></td>
						<td colspan=9 class=xl7526359 style='padding-left:4pt'>untuk proyek <?php echo $NAMA_PROYEK_PDF; ?> - <?php echo $NAMA_SUB_PEKERJAAN; ?></td>
						<td class=xl6526359></td>
						<td class=xl6526359></td>
					</tr>

					<tr height=19 style='mso-height-source:userset;height:10.05pt'>
						<td colspan=2 height=19 class=xl7326359 style='height:10.05pt'>KONDISI
							PENGADAAN :</td>
						<td class=xl6726359 width=64 style='width:48pt'></td>
						<td class=xl6726359 width=64 style='width:48pt'></td>
						<td class=xl6826359></td>
						<td class=xl6826359></td>
						<td class=xl6826359></td>
						<td class=xl6826359></td>
						<td class=xl6826359></td>
						<td class=xl6526359></td>
						<td class=xl6526359></td>
						<td class=xl6526359></td>
						<td class=xl6526359></td>
					</tr>
					<?php $NOMOR = 0;?>
					<?php if (!empty($KONDISI_PENGADAAN_BARIS_1)) {?>
					<tr height=19 style='height:10.05pt'>
						<?php $NOMOR = $NOMOR + 1 ;?>
						<td colspan=11 height=19 class=xl7126359 width=683 style='height:10.05pt; width:512pt'>
						<?php echo ($NOMOR); ?>. <?php echo ($KONDISI_PENGADAAN_BARIS_1); ?>

						<?php if ($JENIS_PENGADAAN == "Pembelian") {?>
							<?php echo ($TANGGAL_KIRIM_BARANG_HARI); ?> 
						<?php }?>

						<?php if ($JENIS_PENGADAAN == "Rental") {?>
							<?php echo ($TANGGAL_MULAI_PAKAI_HARI); ?> s.d. <?php echo ($TANGGAL_SELESAI_PAKAI_HARI); ?> 
						<?php }?>

						<?php if ($JENIS_PENGADAAN == "Jasa") {?>
							<?php echo ($TANGGAL_MULAI_PAKAI_HARI); ?> s.d. <?php echo ($TANGGAL_SELESAI_PAKAI_HARI); ?> 
						<?php }?>

						</td>
						<td class=xl6526359></td>
						<td class=xl6526359></td>
					</tr>
					<?php } else {?>
					
					<?php }?>
					
					<?php if (!empty($KONDISI_PENGADAAN_BARIS_2))  {?>
					<tr height=19 style='height:10.05pt'>
						<?php $NOMOR = $NOMOR + 1 ;?>
						<td colspan=11 height=19 class=xl7126359 width=683 style='height:10.05pt; width:512pt'>
						<?php echo ($NOMOR); ?>. <?php echo ($KONDISI_PENGADAAN_BARIS_2); ?> <?php echo ($REFERENSI_DOKUMEN_SPH); ?>
						<td class=xl6526359></td>
						<td class=xl6526359></td>
					</tr>
					<?php } else {?>
					
					<?php }?>

					<?php if (!empty($KONDISI_PENGADAAN_BARIS_3)) {?>
					<tr height=19 style='height:10.05pt'>
						<?php $NOMOR = $NOMOR + 1 ;?>
						<td colspan=11 height=19 class=xl7126359 width=683 style='height:10.05pt; width:512pt'>
						<?php echo ($NOMOR); ?>. <?php echo ($KONDISI_PENGADAAN_BARIS_3); ?> <?php echo ($REFERENSI_DOKUMEN_KONTRAK); ?>
						</td>
						<td class=xl6526359></td>
						<td class=xl6526359></td>
					</tr>
					<?php } else {?>
					
					<?php }?>

					<?php if (!empty($KONDISI_PENGADAAN_BARIS_4)) {?>
					<tr height=19 style='height:10.05pt'>
						<?php $NOMOR = $NOMOR + 1 ;?>
						<td colspan=11 height=19 class=xl7126359 width=683 style='height:10.05pt; width:512pt'>
						<?php echo ($NOMOR); ?>. <?php echo ($KONDISI_PENGADAAN_BARIS_4); ?>
						<td class=xl6526359></td>
						<td class=xl6526359></td>
					</tr>
					<?php } else {?>
					
					<?php }?>

					<?php if (!empty($KONDISI_PENGADAAN_BARIS_5)) {?>
					<tr height=19 style='height:10.05pt'>
						<?php $NOMOR = $NOMOR + 1 ;?>
						<td colspan=11 height=19 class=xl7126359 width=683 style='height:10.05pt; width:512pt'>
						<?php echo ($NOMOR); ?>. <?php echo ($KONDISI_PENGADAAN_BARIS_5); ?>
						</td>
						<td class=xl6526359></td>
						<td class=xl6526359></td>
					</tr>
					<?php } else {?>
					
					<?php }?>

					<?php if (!empty($KONDISI_PENGADAAN_BARIS_6))  {?>
					<tr height=19 style='height:10.05pt'>
						<?php $NOMOR = $NOMOR + 1 ;?>
						<td colspan=11 height=19 class=xl7126359 width=683 style='height:10.05pt; width:512pt'>
						<?php echo ($NOMOR); ?>. <?php echo ($KONDISI_PENGADAAN_BARIS_6); ?>
						</td>
						<td class=xl6526359></td>
						<td class=xl6526359></td>
					</tr>
					<?php } else {?>
					
					<?php }?>

					<?php if (!empty($KONDISI_PENGADAAN_BARIS_7))   {?>
					<tr height=19 style='height:10.05pt'>
						<?php $NOMOR = $NOMOR + 1 ;?>
						<td colspan=11 height=19 class=xl7126359 width=683 style='height:10.05pt; width:512pt'>
						<?php echo ($NOMOR); ?>. <?php echo ($KONDISI_PENGADAAN_BARIS_7); ?>
						<td class=xl6526359></td>
						<td class=xl6526359></td>
					</tr>
					<?php } else {?>
					
					<?php }?>

					<?php if (!empty($KONDISI_PENGADAAN_BARIS_8))  {?>
					<tr height=19 style='height:10.05pt'>
						<?php $NOMOR = $NOMOR + 1 ;?>
						<td colspan=11 height=19 class=xl7126359 width=683 style='height:10.05pt; width:512pt'>
						<?php echo ($NOMOR); ?>. <?php echo ($KONDISI_PENGADAAN_BARIS_8); ?>
						<td class=xl6526359></td>
						<td class=xl6526359></td>
					</tr>
					<?php } else {?>
					
					<?php }?>

					<tr height=19 style='height:10.05pt'>
						<td colspan=11 height=19 class=xl6926359 width=683 style='height:10.05pt;
  width:512pt'>&nbsp;</td>
						<td class=xl6526359></td>
						<td class=xl6526359></td>
					</tr>
				</table>

			</div>

			<div id="patokan sppb_21533" align=center x:publishsource="Excel" style="page-break-inside: avoid; page-break-after: avoid;">

				<table border=0 cellpadding=0 cellspacing=0 width=875 class=xl6321533 style='border-collapse:collapse;table-layout:fixed;width:656pt'>

					<tr height=19 style='height:10.05pt' style="page-break-inside: avoid; page-break-after: avoid;">
						<td height=19 class=xl7721533 width=43 style='height:10.05pt;width:32pt'></td>
						<td class=xl7721533 width=64 style='width:48pt'></td>
						<td class=xl7721533 width=64 style='width:48pt'></td>
						<td class=xl7721533 width=64 style='width:48pt'></td>
						<td class=xl7721533 width=64 style='width:48pt'></td>
						<td class=xl7721533 width=64 style='width:48pt'></td>
						<td class=xl7721533 width=64 style='width:48pt'></td>
						<td class=xl7721533 width=64 style='width:48pt'></td>
						<td class=xl7721533 width=64 style='width:48pt'></td>
						<td class=xl7721533 width=64 style='width:48pt'></td>
						<td class=xl7721533 width=64 style='width:48pt'></td>
						<td class=xl6321533></td>
					</tr>
					<tr height=19 style='height:10.05pt' style="page-break-inside: avoid; page-break-after: avoid;">
						<td height=19 class=xl6321533 style='height:10.05pt'></td>
						<td class=xl7521533 width=64 style='width:48pt'></td>
						<td class=xl7521533 width=64 style='width:48pt'></td>
						<td class=xl7521533 width=64 style='width:48pt'></td>
						<td class=xl7521533 width=64 style='width:48pt'></td>
						<td class=xl7521533 width=64 style='width:48pt'></td>
						<td class=xl7621533></td>
						<td colspan=2 class=xl7821533 style="page-break-inside: avoid; page-break-after: avoid;">Disetujui Oleh,</td>
						<td colspan=2 class=xl7821533 style='border-left:none' style="page-break-inside: avoid; page-break-after: avoid;">Disiapkan Oleh,</td>
						<td class=xl6321533></td>
					</tr>
					<tr height=19 style='height:10.05pt' style="page-break-inside: avoid; page-break-after: avoid;">
						<td height=19 class=xl6321533 style='height:10.05pt'></td>
						<td class=xl7521533 width=64 style='width:48pt'></td>
						<td class=xl7521533 width=64 style='width:48pt'></td>
						<td class=xl7521533 width=64 style='width:48pt'></td>
						<td class=xl7521533 width=64 style='width:48pt'></td>
						<td class=xl7521533 width=64 style='width:48pt'></td>
						<td class=xl7621533></td>
						<td colspan=2 rowspan=4 class=xl7221533 width=128 style='width:96pt'><?php
																								echo $SIGN_USER_M_PROC; ?></td>
						<td colspan=2 rowspan=4 class=xl7221533 width=128 style='width:96pt'><?php
																								echo $SIGN_USER_KASIE_PROC; ?></td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
					</tr>
					<tr height=19 style='height:14.5pt' style="page-break-inside: avoid; page-break-after: avoid;">
						<td height=19 class=xl6321533 style='height:14.5pt'></td>
						<td class=xl7521533 width=64 style='width:48pt'></td>
						<td class=xl7521533 width=64 style='width:48pt'></td>
						<td class=xl7521533 width=64 style='width:48pt'></td>
						<td class=xl7521533 width=64 style='width:48pt'></td>
						<td class=xl7521533 width=64 style='width:48pt'></td>
						<td class=xl7521533 width=64 style='width:48pt'></td>
						<td class=xl7621533></td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
					</tr>
					<tr height=19 style='height:14.5pt' style="page-break-inside: avoid; page-break-after: avoid;">
						<td height=19 class=xl6321533 style='height:14.5pt'></td>
						<td class=xl7521533 width=64 style='width:48pt'></td>
						<td class=xl7521533 width=64 style='width:48pt'></td>
						<td class=xl7521533 width=64 style='width:48pt'></td>
						<td class=xl7521533 width=64 style='width:48pt'></td>
						<td class=xl7521533 width=64 style='width:48pt'></td>
						<td class=xl7521533 width=64 style='width:48pt'></td>
						<td class=xl7621533></td>
						<td class=xl6321533></td>
	
						<td class=xl6321533></td>
					</tr>
					<tr height=19 style='height:14.5pt' style="page-break-inside: avoid; page-break-after: avoid;">
						<td height=19 class=xl6321533 style='height:14.5pt'></td>
						<td class=xl7521533 width=64 style='width:48pt'></td>
						<td class=xl7521533 width=64 style='width:48pt'></td>
						<td class=xl7521533 width=64 style='width:48pt'></td>
						<td class=xl7521533 width=64 style='width:48pt'></td>
						<td class=xl7521533 width=64 style='width:48pt'></td>
						<td class=xl7621533></td>
						<td class=xl6321533></td>

						<td class=xl6321533></td>
					</tr>
					
					<tr height=19 style='height:14.5pt' style="page-break-inside: avoid; page-break-after: avoid;">
						<td height=19 class=xl6321533 style='height:14.5pt'></td>
						<td class=xl7521533 width=64 style='width:48pt'></td>
						<td class=xl7521533 width=64 style='width:48pt'></td>
						<td class=xl7521533 width=64 style='width:48pt'></td>
						<td class=xl7521533 width=64 style='width:48pt'></td>
						<td class=xl7521533 width=64 style='width:48pt'></td>
						<td class=xl7621533></td>
						<td colspan=2 class=xl7821533><?php echo $TANDA_TANGAN_1; ?></td>
						<td colspan=2 class=xl7821533 style='border-left:none'><?php echo $TANDA_TANGAN_2; ?></td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
					</tr>
					<tr height=19 style='height:14.5pt' style="page-break-inside: avoid; page-break-after: avoid;">
						<td height=19 class=xl6321533 style='height:14.5pt'></td>
						<td class=xl7621533></td>
						<td class=xl7621533></td>
						<td class=xl7621533></td>
						<td class=xl7621533></td>
						<td class=xl7621533></td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
					</tr>

				</table>

			</div>

		</div>
	</main>
</body>

</html>