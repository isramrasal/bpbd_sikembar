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
</head>

<body>
	<!-- Define header and footer blocks before your content -->
	<header>

		<div id="patokan sppb_21533" align=center x:publishsource="Excel">

			<table border=0 cellpadding=0 cellspacing=0 width=875 class=xl6321533 style='border-collapse:collapse;table-layout:fixed;width:656pt'>
				<col class=xl6321533 width=43 style='mso-width-source:userset;mso-width-alt:
 1536;width:32pt'>
				<col class=xl6321533 width=64 span=13 style='width:48pt'>
				<tr height=20 style='mso-height-source:userset;height:15.0pt'>
					<td rowspan=3 height=62 class=xl11121533 width=43 style='height:46.5pt;
  width:32pt'><img src="assets/logo_wasa.png" alt="" width=50 height=50></td>
					<td colspan=5 rowspan=3 class=xl11221533 width=320 style='width:240pt'>ORDER
						PEMBELIAN</td>
					<td class=xl8421533 width=64 style='border-left:none;width:48pt'><span style='mso-spacerun:yes'>&nbsp;Form No.</td>
					<td colspan=2 class=xl11321533 width=128 style='border-right:.5pt solid black;
  width:96pt'>: WME/FOP/02</td>
					<td colspan=2 rowspan=2 class=xl10721533 width=128 style='border-right:.5pt solid black;
  width:96pt'><img src="assets/logo_sgs_ukas.png" alt="" width=100 height=50></td>
					<td class=xl6321533 width=64 style='width:48pt'></td>
					<td class=xl6321533 width=64 style='width:48pt'></td>
					<td class=xl6321533 width=64 style='width:48pt'></td>
				</tr>
				<tr height=20 style='mso-height-source:userset;height:15.0pt'>
					<td height=20 class=xl8521533 width=64 style='height:15.0pt;border-left:none;
  width:48pt'><span style='mso-spacerun:yes'>&nbsp;SOP No</td>
					<td colspan=2 class=xl11521533 width=128 style='border-right:.5pt solid black;
  width:96pt'>: WME/SOP/FHS-PL/01</td>
					<td class=xl6321533></td>
					<td class=xl6321533></td>
					<td class=xl6321533></td>
				</tr>
				<tr height=22 style='mso-height-source:userset;height:16.5pt'>
					<td height=22 class=xl8621533 width=64 style='height:16.5pt;border-left:none;
  width:48pt'><span style='mso-spacerun:yes'>&nbsp;Dept.</td>
					<td colspan=2 class=xl11721533 width=128 style='border-right:.5pt solid black;
  width:96pt'>: Procurement &amp; Logistic</td>
					<td colspan=2 class=xl10521533 width=128 style='border-right:.5pt solid black;
  border-left:none;width:96pt'>Certificate ID07/0831</td>
					<td class=xl6321533></td>
					<td class=xl6321533></td>
					<td class=xl6321533></td>
				</tr>
				<tr height=19 style='height:14.4pt'>
					<td height=19 class=xl7921533 style='height:14.4pt'>&nbsp;</td>
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
				<tr height=19 style='mso-height-source:userset;height:14.4pt'>
					<td colspan=2 height=19 class=xl12721533 width=107 style='height:14.4pt;
  width:80pt'><span style='mso-spacerun:yes'>&nbsp;No. Order Pembelian</td>
					<td colspan=4 class=xl12321533 width=256 style='border-right:.5pt solid black;
  width:192pt'>: <?php echo $NO_URUT_PO; ?></td>
					<td class=xl6321533></td>
					<td class=xl6321533></td>
					<td colspan=3 class=xl9621533>Kepada Yth.,</td>
					<td class=xl6321533></td>
					<td class=xl6321533></td>
					<td class=xl6321533></td>
				</tr>
				<tr height=19 style='mso-height-source:userset;height:14.4pt'>
					<td colspan=2 height=19 class=xl12821533 width=107 style='height:14.4pt;
  width:80pt'><span style='mso-spacerun:yes'>&nbsp;Tanggal Order Pemb.</td>
					<td colspan=4 class=xl6421533 width=256 style='border-right:.5pt solid black;
  width:192pt'>: <?php echo $TANGGAL_DOKUMEN_PO; ?></td>
					<td class=xl6321533></td>
					<td class=xl6321533></td>
					<td colspan=3 class=xl10221533 width=192 style='width:144pt'><?php echo
																					$NAMA_VENDOR; ?></td>
					<td class=xl6321533></td>
					<td class=xl6321533></td>
					<td class=xl6321533></td>
				</tr>
				<tr height=19 style='mso-height-source:userset;height:14.4pt'>
					<td colspan=2 height=19 class=xl12821533 width=107 style='height:14.4pt;
  width:80pt'><span style='mso-spacerun:yes'>&nbsp;No. SPP</td>
					<td colspan=4 class=xl6421533 width=256 style='border-right:.5pt solid black;
  width:192pt'>: <?php echo $NO_URUT_SPP; ?></td>
					<td class=xl6321533></td>
					<td class=xl6321533></td>
					<td colspan=3 rowspan=4 class=xl6421533 width=192 style='width:144pt'><?php
																							echo $ALAMAT_VENDOR; ?></td>
					<td class=xl6321533></td>
					<td class=xl6321533></td>
					<td class=xl6321533></td>
				</tr>
				<tr height=19 style='mso-height-source:userset;height:14.4pt'>
					<td colspan=2 height=19 class=xl12921533 width=107 style='height:14.4pt;
  width:80pt'><span style='mso-spacerun:yes'>&nbsp;No. SPPB</td>
					<td colspan=4 class=xl9521533 width=256 style='border-right:.5pt solid black;
  width:192pt'>: 001/SPPB/WME/CC-CRB2/2022 </td>
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
		<img style="width: 80px;" src="<?php echo $GAMBAR_QR_2; ?>">
	</footer>

	<!-- Wrap the content of your PDF inside a main tag -->
	<main>
		<div class="myDiv">
			<div id="patokan sppb_21533" align=center x:publishsource="Excel">

				<table border=0 cellpadding=0 cellspacing=0 width=875 class=xl6321533 style='border-collapse:collapse;table-layout:fixed;width:656pt'>

					<tr height=19 style='mso-height-source:userset;height:14.4pt'>
						<td colspan=2 height=19 class=xl8821533 width=107 style='height:14.4pt;
  width:80pt'><span style='mso-spacerun:yes'>&nbsp;Syarat Pembayaran:<font class="font721533"><span style='mso-spacerun:yes'>&nbsp;</font>
						</td>
						<td colspan=4 class=xl9021533 width=256 style='border-right:.5pt solid black;
  width:192pt'><?php echo $NAMA_TERM_OF_PAYMENT; ?></td>
						<td colspan=2 class=xl9421533 width=128 style='border-left:none;width:96pt'>
							<font class="font621533"><span style='mso-spacerun:yes'>&nbsp;Lokasi Penyerahan:</font>
							<font class="font521533"><span style='mso-spacerun:yes'>&nbsp;</font>
						</td>
						<td colspan=3 class=xl9221533 width=192 style='border-right:.5pt solid black;
  width:144pt'><?php echo $NAMA_LOKASI_PENYERAHAN; ?></td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
						<td class=xl6621533></td>
					</tr>
					<thead style="display: table-header-group">
					<tr height=26 style='height:19.2pt'>
						<td height=26 class=xl7821533 style='height:19.2pt;border-top:none;width: 3%';border-collapse:collapse>No.</td>
						<td class=xl6721533 width=64 style='border-top:none;border-left:none;
  width:13%;border-collapse:collapse'>Nama Barang</td>
						<td colspan=2 class=xl6821533 width=128 style='width:13%;border-collapse:collapse'>Spesifikasi</td>
						<td class=xl6921533 width=64 style='border-top:none;width:5%;border-collapse:collapse'>Jenis Barang</td>
						<td class=xl6821533 width=64 style='border-top:none;border-left:none;
  width:6%;border-collapse:collapse'>Banyaknya</td>
						<td class=xl6821533 width=64 style='border-top:none;border-left:none;
  width:6%;border-collapse:collapse'>Satuan</td>
						<td colspan=2 class=xl6721533 width=128 style='border-right:.5pt solid black;
  border-left:none;width:10%;border-collapse:collapse'>Harga Satuan</td>
						<td colspan=2 class=xl6721533 width=128 style='border-right:.5pt solid black;
  border-left:none;width:10%;border-collapse:collapse'>Total</td>
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
							<tr height=22 style='mso-height-source:userset;height:16.5pt;border-collapse:collapse'>
								<td height=22 class=xl7221533 width=43 style='height:16.5pt;border-top:.5pt;
  width:32pt;border-collapse:collapse'><?php echo $hitung; ?></td>
								<td class=xl7021533 width=64 style='border-top:.5pt;border-left:none;
  width:48pt;border-collapse:collapse'><?php echo $item->NAMA_BARANG; ?></td>
								<td colspan=2 class=xl10421533 width=128 style='border-top:.5pt;border-right:.5pt solid black;
  border-left:none;width:96pt'><?php echo $item->SPESIFIKASI_SINGKAT;
								?> </td>
								<td class=xl7121533 width=64 style='border-top:.5pt;width:48pt;border-collapse:collapse'><?php echo
																								$item->NAMA_JENIS_BARANG; ?></td>
								<td class=xl7221533 width=64 style='border-top:.5pt;border-left:none;
  width:48pt;border-collapse:collapse'><?php echo $item->JUMLAH_BARANG; ?></td>
								<td class=xl7221533 width=64 style='border-top:.5pt;border-left:none;
  width:48pt;border-collapse:collapse'><?php echo $item->NAMA_SATUAN_BARANG; ?></td>
								<td colspan=2 class=xl10021533 width=128 style='border-top:.5pt;border-right:.5pt solid black;
  border-left:none;width:96pt;border-collapse:collapse'>
									Rp. <?php echo
										number_format(
											$item->HARGA_SATUAN_BARANG_FIX,
											2,
											",",
											"."
										); ?> &nbsp;
								</td>
								<td colspan=2 class=xl10021533 width=128 style='border-top:.5pt;border-right:.5pt solid black;
  border-left:none;width:96pt;border-collapse:collapse'>

									Rp. <?php echo number_format($item->HARGA_TOTAL_FIX, 2, ",", "."); ?>&nbsp;
								</td>
								<td class=xl7321533></td>
								<td class=xl6321533></td>
								<td class=xl6321533></td>
							</tr>
					<?php
							$hitung = $hitung + 1;
						}
					} ?>
					<tr height=19 style='height:14.4pt'>
						<td colspan=9 height=19 class=xl10321533 width=555 style='border-right:.5pt solid black;
  height:14.4pt;width:416pt'>SUB TOTAL &nbsp;</td>
						<td colspan=2 class=xl10021533 width=128 style='border-right:.5pt solid black;
  border-left:none;width:96pt'>
							Rp. <?php echo number_format($item->TOTAL_HARGA_PO_BARANG, 2, ",", "."); ?>&nbsp;
						</td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
					</tr>
					<tr height=19 style='height:14.4pt'>
						<td colspan=9 height=19 class=xl10321533 width=555 style='border-right:.5pt solid black;
  height:14.4pt;width:416pt'><?php echo $KETERANGAN; ?>&nbsp;</td>
						<td colspan=2 class=xl10021533 width=128 style='border-right:.5pt solid black;
  border-left:none;width:96pt'>
							Rp. <?php echo number_format($item->TOTAL_PAJAK_PO_BARANG, 2, ",", "."); ?>&nbsp;
						</td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
					</tr>
					<tr height=19 style='height:14.4pt'>
						<td colspan=9 height=19 class=xl9721533 width=555 style='border-right:.5pt solid black;
  border-bottom:.5pt solid black;height:14.4pt;width:416pt'>TOTAL&nbsp;</td>
						<td colspan=2 class=xl10021533 width=128 style='border-right:.5pt solid black;
  border-left:none;width:96pt'>
							<?php echo number_format($item->TOTAL_ALL_PO_BARANG, 2, ",", "."); ?>&nbsp;
						</td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
					</tr>
					<tr height=19 style='height:14.4pt'>
						<td height=19 class=xl6321533 style='height:14.4pt'></td>
						<td class=xl8121533 style='border-top:none'>&nbsp;</td>
						<td class=xl8121533 style='border-top:none'>&nbsp;</td>
						<td class=xl8121533 style='border-top:none'>&nbsp;</td>
						<td class=xl8121533 style='border-top:none'>&nbsp;</td>
						<td class=xl8121533 style='border-top:none'>&nbsp;</td>
						<td class=xl8121533 style='border-top:none'>&nbsp;</td>
						<td class=xl8121533 style='border-top:none'>&nbsp;</td>
						<td class=xl8121533 style='border-top:none'>&nbsp;</td>
						<td class=xl8121533 style='border-top:none'>&nbsp;</td>
						<td class=xl8221533 style='border-top:none'>&nbsp;</td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
					</tr>
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
					<tr height=19 style='mso-height-source:userset;height:14.4pt'>
						<td colspan=2 height=19 class=xl9621533 style='height:14.4pt'>Terbilang:</td>
						<td colspan=9 class=xl9521533 width=576 style='width:432pt'><?php echo
																					terbilang($TOTAL_ALL_PO_BARANG); ?> Rupiah</td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
					</tr>
					<tr height=19 style='height:14.4pt'>
						<td colspan=2 height=19 class=xl9621533 style='height:14.4pt'>Keperluan:</td>
						<td colspan=9 class=xl8721533><?php echo ($CTT_KEPERLUAN); ?></td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
					</tr>
					<tr height=19 style='height:14.4pt'>
						<td height=19 class=xl6321533 style='height:14.4pt'></td>
						<td class=xl8321533></td>
						<td colspan=9 class=xl8721533>&nbsp;</td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
					</tr>
					<tr height=19 style='height:14.4pt'>
						<td height=19 class=xl6321533 style='height:14.4pt'></td>
						<td class=xl8321533></td>
						<td colspan=9 class=xl8721533>&nbsp;</td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
					</tr>
					<tr height=19 style='height:14.4pt'>
						<td height=19 class=xl6321533 style='height:14.4pt'></td>
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
						<td class=xl7421533></td>
						<td class=xl6321533></td>
					</tr>
					<tr height=19 style='mso-height-source:userset;height:14.4pt'>
						<td colspan=2 height=19 class=xl12021533 style='height:14.4pt;width:48pt'>KONDISI
							PENGADAAN:</td>
						<td class=xl7521533 width=64 style='width:48pt'></td>
						<td class=xl7521533 width=64 style='width:48pt'></td>
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
					</tr>
					<tr height=19 style='height:14.4pt'>
						<td colspan=11 height=19 class=xl11921533 width=683 style='height:14.4pt;
  width:512pt'>1. </td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
					</tr>
					<tr height=19 style='height:14.4pt'>
						<td colspan=11 height=19 class=xl11921533 width=683 style='height:14.4pt;
  width:512pt'>2. </td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
					</tr>
					<tr height=19 style='height:14.4pt'>
						<td colspan=11 height=19 class=xl11921533 width=683 style='height:14.4pt;
  width:512pt'>3. </td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
					</tr>
					<tr height=19 style='height:14.4pt'>
						<td colspan=11 height=19 class=xl11921533 width=683 style='height:14.4pt;
  width:512pt'>4. </td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
					</tr>
					<tr height=19 style='height:14.4pt'>
						<td colspan=11 height=19 class=xl7721533 width=683 style='height:14.4pt;
  width:512pt'>5. </td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
					</tr>

				</table>
			</div>

			<div id="patokan sppb_21533" align=center x:publishsource="Excel">

				<table border=0 cellpadding=0 cellspacing=0 width=875 class=xl6321533 style='border-collapse:collapse;table-layout:fixed;width:656pt'>

					<tr height=19 style='height:14.4pt' style="page-break-inside: avoid; page-break-after: avoid;">
						<td height=19 class=xl7721533 width=43 style='height:14.4pt;width:32pt'></td>
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
						<td class=xl6321533></td>
						<td class=xl6321533></td>
					</tr>
					<tr height=19 style='height:14.4pt' style="page-break-inside: avoid; page-break-after: avoid;">
						<td height=19 class=xl6321533 style='height:14.4pt'></td>
						<td class=xl7521533 width=64 style='width:48pt'></td>
						<td class=xl7521533 width=64 style='width:48pt'></td>
						<td class=xl7521533 width=64 style='width:48pt'></td>
						<td class=xl7521533 width=64 style='width:48pt'></td>
						<td class=xl7521533 width=64 style='width:48pt'></td>
						<td class=xl7621533></td>
						<td colspan=2 class=xl7821533 style="page-break-inside: avoid; page-break-after: avoid;">Disetujui Oleh,</td>
						<td colspan=2 class=xl7821533 style='border-left:none' style="page-break-inside: avoid; page-break-after: avoid;">Disiapkan Oleh,</td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
					</tr>
					<tr height=19 style='height:14.4pt' style="page-break-inside: avoid; page-break-after: avoid;">
						<td height=19 class=xl6321533 style='height:14.4pt'></td>
						<td class=xl7521533 width=64 style='width:48pt'></td>
						<td class=xl7521533 width=64 style='width:48pt'></td>
						<td class=xl7521533 width=64 style='width:48pt'></td>
						<td class=xl7521533 width=64 style='width:48pt'></td>
						<td class=xl7521533 width=64 style='width:48pt'></td>
						<td class=xl7621533></td>
						<td colspan=2 rowspan=3 class=xl7221533 width=128 style='width:96pt'><?php
																								echo $SIGN_USER_M_PROC; ?></td>
						<td colspan=2 rowspan=3 class=xl7221533 width=128 style='width:96pt'><?php
																								echo $SIGN_USER_KASIE_PROC; ?></td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
					</tr>
					<tr height=19 style='height:14.4pt' style="page-break-inside: avoid; page-break-after: avoid;">
						<td height=19 class=xl6321533 style='height:14.4pt'></td>
						<td class=xl7521533 width=64 style='width:48pt'></td>
						<td class=xl7521533 width=64 style='width:48pt'></td>
						<td class=xl7521533 width=64 style='width:48pt'></td>
						<td class=xl7521533 width=64 style='width:48pt'></td>
						<td class=xl7521533 width=64 style='width:48pt'></td>
						<td class=xl7621533></td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
					</tr>
					<tr height=19 style='height:14.4pt' style="page-break-inside: avoid; page-break-after: avoid;">
						<td height=19 class=xl6321533 style='height:14.4pt'></td>
						<td class=xl7521533 width=64 style='width:48pt'></td>
						<td class=xl7521533 width=64 style='width:48pt'></td>
						<td class=xl7521533 width=64 style='width:48pt'></td>
						<td class=xl7521533 width=64 style='width:48pt'></td>
						<td class=xl7521533 width=64 style='width:48pt'></td>
						<td class=xl7621533></td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
					</tr>
					<tr height=19 style='height:14.4pt' style="page-break-inside: avoid; page-break-after: avoid;">
						<td height=19 class=xl6321533 style='height:14.4pt'></td>
						<td class=xl7521533 width=64 style='width:48pt'></td>
						<td class=xl7521533 width=64 style='width:48pt'></td>
						<td class=xl7521533 width=64 style='width:48pt'></td>
						<td class=xl7521533 width=64 style='width:48pt'></td>
						<td class=xl7521533 width=64 style='width:48pt'></td>
						<td class=xl7621533></td>
						<td colspan=2 class=xl7821533>Mjr. Pengadaan</td>
						<td colspan=2 class=xl7821533 style='border-left:none'>Bag. Pembelian</td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
						<td class=xl6321533></td>
					</tr>
					<tr height=19 style='height:14.4pt' style="page-break-inside: avoid; page-break-after: avoid;">
						<td height=19 class=xl6321533 style='height:14.4pt'></td>
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
						<td class=xl6321533></td>
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
					</tr>
					<![endif]>
				</table>

			</div>

		</div>
	</main>
</body>

</html>