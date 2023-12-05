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
			margin-top: 7.3cm;
			margin-left: 1cm;
			margin-right: 4cm;
			margin-bottom: 2cm;
		}

		.myDiv {
			margin-top: 0cm;
			margin-left: 0cm;
			margin-right: 0cm;
			margin-bottom: 0cm;
		}

		/** Define the header rules **/
		header {
			position: fixed;
			top: 1cm;
			left: 1cm;
			right: 1cm;
			height: 6cm;

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

			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: Calibri, sans-serif;
		}
	</style>
	<style id="patokan sppb_9072_Styles">
		<!--table
		{
			mso-displayed-decimal-separator: "\.";
			mso-displayed-thousand-separator: "\,";
		}

		.xl159072 {
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

		.xl639072 {
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
			white-space: normal;
		}

		.xl649072 {
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
			white-space: normal;
		}

		.xl659072 {
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

		.xl669072 {
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
			border-left: 1.0pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl679072 {
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
			border-right: 1.0pt solid windowtext;
			border-bottom: none;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl689072 {
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
			border-bottom: 1.0pt solid windowtext;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl699072 {
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
			border-top: 1.0pt solid windowtext;
			border-right: none;
			border-bottom: none;
			border-left: 1.0pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl709072 {
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
			white-space: normal;
		}

		.xl719072 {
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
			border-top: none;
			border-right: none;
			border-bottom: none;
			border-left: 1.0pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl729072 {
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
			white-space: normal;
		}

		.xl739072 {
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
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl749072 {
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
			text-align: left;
			vertical-align: middle;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl759072 {
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
			white-space: normal;
		}

		.xl769072 {
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
			white-space: normal;
		}

		.xl779072 {
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
			white-space: normal;
		}

		.xl789072 {
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
			white-space: normal;
		}

		.xl799072 {
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
			border-right: 1.0pt solid black;
			border-bottom: 1.0pt solid windowtext;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl809072 {
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
			border-bottom: none;
			border-left: 1.0pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl819072 {
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
			border-right: 1.0pt solid windowtext;
			border-bottom: none;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl829072 {
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
			border-bottom: 1.0pt solid windowtext;
			border-left: 1.0pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl839072 {
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
			border-bottom: 1.0pt solid windowtext;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl849072 {
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
			border-right: 1.0pt solid windowtext;
			border-bottom: 1.0pt solid windowtext;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl859072 {
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
			border-bottom: 1.0pt solid windowtext;
			border-left: 1.0pt solid black;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl869072 {
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
			text-align: left;
			vertical-align: middle;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl879072 {
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
			border-right: 1.0pt solid black;
			border-bottom: none;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl889072 {
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
			text-align: left;
			vertical-align: middle;
			border-top: .5pt solid windowtext;
			border-right: none;
			border-bottom: none;
			border-left: 1.0pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl899072 {
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

		.xl909072 {
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
			text-align: left;
			vertical-align: middle;
			border-top: none;
			border-right: none;
			border-bottom: none;
			border-left: 1.0pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl919072 {
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
			border-top: none;
			border-right: none;
			border-bottom: .5pt solid windowtext;
			border-left: 1.0pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl929072 {
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
			border-top: none;
			border-right: none;
			border-bottom: .5pt solid windowtext;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl939072 {
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
			border-top: 1.0pt solid windowtext;
			border-right: 1.0pt solid windowtext;
			border-bottom: none;
			border-left: 1.0pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl949072 {
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
			border-right: 1.0pt solid windowtext;
			border-bottom: none;
			border-left: 1.0pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl959072 {
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
			border-right: 1.0pt solid windowtext;
			border-bottom: 1.0pt solid windowtext;
			border-left: 1.0pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl969072 {
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
			border-top: 1.0pt solid windowtext;
			border-right: none;
			border-bottom: none;
			border-left: 1.0pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl979072 {
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
			border-top: 1.0pt solid windowtext;
			border-right: none;
			border-bottom: none;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl989072 {
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
			border-top: 1.0pt solid windowtext;
			border-right: 1.0pt solid windowtext;
			border-bottom: none;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl999072 {
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
			border-top: 1.0pt solid windowtext;
			border-right: none;
			border-bottom: none;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl1009072 {
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
			border-top: 1.0pt solid windowtext;
			border-right: 1.0pt solid black;
			border-bottom: none;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl1019072 {
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
			text-align: left;
			vertical-align: middle;
			border-top: none;
			border-right: 1.0pt solid windowtext;
			border-bottom: none;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl1029072 {
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
			text-align: left;
			vertical-align: middle;
			border-top: none;
			border-right: 1.0pt solid windowtext;
			border-bottom: none;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl1039072 {
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
			border-right: 1.0pt solid windowtext;
			border-bottom: none;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl1049072 {
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
			border-right: 1.0pt solid windowtext;
			border-bottom: 1.0pt solid windowtext;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl1059072 {
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
			border-top: 1.0pt solid windowtext;
			border-right: none;
			border-bottom: none;
			border-left: 1.0pt solid black;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl1069072 {
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
			border-top: 1.0pt solid windowtext;
			border-right: 1.0pt solid windowtext;
			border-bottom: none;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl1079072 {
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
			border-left: 1.0pt solid black;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl1089072 {
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
			border-right: 1.0pt solid windowtext;
			border-bottom: none;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}
		-->
	</style>

	<style id="patokan sppb_828_Styles">
		<!--table
		{
			mso-displayed-decimal-separator: "\.";
			mso-displayed-thousand-separator: "\,";
		}

		.font5828 {
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
			mso-font-charset: 0;
		}

		.font6828 {
			color: black;
			font-size: 7.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
			mso-font-charset: 0;
		}

		.font7828 {
			color: black;
			font-size: 7.0pt;
			font-weight: 700;
			font-style: normal;
			text-decoration: none;
			font-family: "Century Gothic", sans-serif;
			mso-font-charset: 0;
		}

		.xl15828 {
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

		.xl65828 {
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

		.xl66828 {
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

		.xl67828 {
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

		.xl68828 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 8.0pt;
			font-weight: 700;
			font-style: normal;
			text-decoration: none;
			font-family: Arial, sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: general;
			vertical-align: bottom;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl69828 {
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
			border-left: 1.0pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl70828 {
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
			border-right: 1.0pt solid windowtext;
			border-bottom: none;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl71828 {
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
			border-top: .5pt solid windowtext;
			border-right: .5pt solid windowtext;
			border-bottom: .5pt solid windowtext;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl72828 {
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

		.xl73828 {
			padding-top: 1px;
			padding-right: 1px;
			padding-left: 1px;
			mso-ignore: padding;
			color: black;
			font-size: 8.0pt;
			font-weight: 700;
			font-style: normal;
			text-decoration: none;
			font-family: Arial, sans-serif;
			mso-font-charset: 0;
			mso-number-format: General;
			text-align: center;
			vertical-align: middle;
			background: white;
			mso-pattern: black none;
			white-space: nowrap;
		}

		.xl74828 {
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
			border-top: .5pt solid windowtext;
			border-right: .5pt solid windowtext;
			border-bottom: .5pt solid windowtext;
			border-left: 1.0pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl75828 {
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
			border-left: 1.0pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl76828 {
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
			border-right: 1.0pt solid windowtext;
			border-bottom: none;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl77828 {
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
			text-align: right;
			vertical-align: middle;
			border: .5pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl78828 {
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

		.xl79828 {
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
			white-space: nowrap;
		}

		.xl80828 {
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

		.xl81828 {
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

		.xl82828 {
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

		.xl83828 {
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
			white-space: normal;
		}

		.xl84828 {
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

		.xl85828 {
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

		.xl86828 {
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

		.xl87828 {
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

		.xl88828 {
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
			border-top: .5pt solid windowtext;
			border-right: none;
			border-bottom: .5pt solid windowtext;
			border-left: .5pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl89828 {
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
			text-align: left;
			vertical-align: middle;
			border-top: .5pt solid windowtext;
			border-right: none;
			border-bottom: .5pt solid windowtext;
			border-left: 1.0pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl90828 {
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
			border-right: 1.0pt solid windowtext;
			border-bottom: .5pt solid windowtext;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl91828 {
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
			text-align: right;
			vertical-align: middle;
			border-top: .5pt solid windowtext;
			border-right: none;
			border-bottom: .5pt solid windowtext;
			border-left: 1.0pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl92828 {
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

		.xl93828 {
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
			text-align: right;
			vertical-align: middle;
			border-top: .5pt solid windowtext;
			border-right: 1.0pt solid windowtext;
			border-bottom: .5pt solid windowtext;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl94828 {
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
			border-right: 1.0pt solid windowtext;
			border-bottom: .5pt solid windowtext;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl95828 {
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
			border-right: none;
			border-bottom: none;
			border-left: 1.0pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl96828 {
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
			border-right: 1.0pt solid windowtext;
			border-bottom: none;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl97828 {
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
			text-align: left;
			vertical-align: middle;
			border-top: .5pt solid windowtext;
			border-right: 1.0pt solid windowtext;
			border-bottom: .5pt solid windowtext;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl98828 {
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
			vertical-align: bottom;
			border-top: none;
			border-right: none;
			border-bottom: none;
			border-left: 1.0pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl99828 {
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
			border-top: .5pt solid windowtext;
			border-right: 1.0pt solid windowtext;
			border-bottom: .5pt solid windowtext;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl100828 {
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
			vertical-align: bottom;
			border-top: none;
			border-right: none;
			border-bottom: none;
			border-left: 1.0pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl101828 {
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
			vertical-align: bottom;
			border-top: none;
			border-right: 1.0pt solid windowtext;
			border-bottom: none;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl102828 {
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

		.xl103828 {
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
			text-align: left;
			vertical-align: middle;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl104828 {
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
			vertical-align: bottom;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl105828 {
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
			vertical-align: bottom;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl106828 {
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
			white-space: normal;
		}

		.xl107828 {
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
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl108828 {
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

		.xl109828 {
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
			vertical-align: bottom;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl110828 {
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
			border-right: 1.0pt solid windowtext;
			border-bottom: .5pt solid windowtext;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl111828 {
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

		.xl112828 {
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
			text-align: left;
			vertical-align: middle;
			border-top: none;
			border-right: none;
			border-bottom: none;
			border-left: 1.0pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}
		-->
	</style>

	<style id="patokan sppb_10840_Styles">
		<!--table
		{
			mso-displayed-decimal-separator: "\.";
			mso-displayed-thousand-separator: "\,";
		}

		.xl1510840 {
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

		.xl6310840 {
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
			border-right: 1.0pt solid windowtext;
			border-bottom: 1.0pt solid windowtext;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl6410840 {
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
			border-bottom: 1.0pt solid windowtext;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl6510840 {
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
			border-bottom: 1.0pt solid windowtext;
			border-left: 1.0pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl6610840 {
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
			border-left: 1.0pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl6710840 {
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
			white-space: normal;
		}

		.xl6810840 {
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

		.xl6910840 {
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
			border-right: none;
			border-bottom: 1.0pt solid windowtext;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl7010840 {
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
			vertical-align: bottom;
			border-top: none;
			border-right: none;
			border-bottom: none;
			border-left: 1.0pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl7110840 {
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
			vertical-align: bottom;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl7210840 {
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
			vertical-align: bottom;
			border-top: none;
			border-right: 1.0pt solid windowtext;
			border-bottom: none;
			border-left: none;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: normal;
		}

		.xl7310840 {
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

		.xl7410840 {
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
			white-space: nowrap;
		}

		.xl7510840 {
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
			border-top: .5pt solid windowtext;
			border-right: 1.0pt solid windowtext;
			border-bottom: .5pt solid windowtext;
			border-left: .5pt solid windowtext;
			mso-background-source: auto;
			mso-pattern: auto;
			white-space: nowrap;
		}

		.xl7610840 {
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
			border-right: 1.0pt solid windowtext;
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
		<div id="patokan sppb_9072" align=center x:publishsource="Excel">

			<table border=0 cellpadding=0 cellspacing=0 width=682 style='border-collapse:
 collapse;table-layout:fixed;width:512pt'>
				<col width=42 style='mso-width-source:userset;mso-width-alt:1536;width:32pt'>
				<col width=64 span=10 style='width:48pt'>
				<tr height=20 style='mso-height-source:userset;height:15.0pt'>
					<td rowspan=3 height=62 class=xl939072 width=42 style='border-bottom:1.0pt solid black;
  height:46.5pt;width:32pt'>LOGO</td>
					<td colspan=5 rowspan=3 class=xl969072 width=320 style='border-right:1.0pt solid black;
  border-bottom:1.0pt solid black;width:240pt'>ORDER PEMBELIAN</td>
					<td class=xl699072 width=64 style='border-left:none;width:48pt'><span style='mso-spacerun:yes'>&nbsp;Form No.</td>
					<td colspan=2 class=xl999072 width=128 style='border-right:1.0pt solid black;
  width:96pt'>: WME/FOP/02</td>
					<td colspan=2 rowspan=2 class=xl1059072 width=128 style='border-right:1.0pt solid black;
  width:96pt'>Logo SGS ukas</td>
				</tr>
				<tr height=20 style='mso-height-source:userset;height:15.0pt'>
					<td height=20 class=xl639072 width=64 style='height:15.0pt;width:48pt'><span style='mso-spacerun:yes'>&nbsp;SOP No</td>
					<td colspan=2 class=xl639072 width=128 style='border-right:1.0pt solid black;
  width:96pt'>: WME/SOP/FHS-PL/01</td>
				</tr>
				<tr height=22 style='mso-height-source:userset;height:16.5pt'>
					<td height=22 class=xl689072 width=64 style='height:16.5pt;width:48pt'><span style='mso-spacerun:yes'>&nbsp;Dept.</td>
					<td colspan=2 class=xl689072 width=128 style='border-right:1.0pt solid black;
  width:96pt'>: Procurement &amp; Logistic</td>
					<td colspan=2 class=xl859072 width=128 style='border-right:1.0pt solid black;
  border-left:none;width:96pt'>Certificate ID07/0831</td>
				</tr>
				<tr height=22 style='height:16.5pt'>
					<td height=22 class=xl669072 style='height:16.5pt'>&nbsp;</td>
					<td class=xl659072></td>
					<td class=xl659072></td>
					<td class=xl659072></td>
					<td class=xl659072></td>
					<td class=xl659072></td>
					<td class=xl659072></td>
					<td class=xl659072></td>
					<td class=xl659072></td>
					<td class=xl659072></td>
					<td class=xl679072>&nbsp;</td>
				</tr>
				<tr height=19 style='mso-height-source:userset;height:14.45pt'>
					<td colspan=2 height=19 class=xl889072 width=106 style='height:14.45pt;
  width:80pt'><span style='mso-spacerun:yes'>&nbsp;No. Order Pembelian</td>
					<td colspan=4 class=xl729072 width=256 style='border-right:.5pt solid black;
  width:192pt'>: <?php echo $NO_URUT_PO; ?></td>
					<td class=xl159072></td>
					<td class=xl659072></td>
					<td colspan=3 class=xl869072 style='border-right:1.0pt solid black'>Kepada
						Yth.,</td>
				</tr>
				<tr height=19 style='mso-height-source:userset;height:14.45pt'>
					<td colspan=2 height=19 class=xl909072 width=106 style='height:14.45pt;
  width:80pt'><span style='mso-spacerun:yes'>&nbsp;Tanggal Order Pemb.</td>
					<td colspan=4 class=xl649072 width=256 style='border-right:.5pt solid black;
  width:192pt'>: <?php echo $TANGGAL_DOKUMEN_PO; ?></td>
					<td class=xl159072></td>
					<td class=xl659072></td>
					<td colspan=3 class=xl749072 width=192 style='border-right:1.0pt solid black;
  width:144pt'><?php echo $NAMA_VENDOR; ?></td>
				</tr>
				<tr height=19 style='mso-height-source:userset;height:14.45pt'>
					<td colspan=2 height=19 class=xl909072 width=106 style='height:14.45pt;
  width:80pt'><span style='mso-spacerun:yes'>&nbsp;No. SPP</td>
					<td colspan=4 class=xl649072 width=256 style='border-right:.5pt solid black;
  width:192pt'>: <?php echo $NO_URUT_SPP; ?></td>
					<td class=xl159072></td>
					<td class=xl659072></td>
					<td colspan=3 rowspan=4 class=xl649072 width=192 style='border-right:1.0pt solid black;
  width:144pt'><?php echo $ALAMAT_VENDOR; ?></td>
				</tr>
				<tr height=19 style='mso-height-source:userset;height:14.45pt'>
					<td colspan=2 height=19 class=xl919072 width=106 style='height:14.45pt;
  width:80pt'><span style='mso-spacerun:yes'>&nbsp;No. SPPB</td>
					<td colspan=4 class=xl779072 width=256 style='border-right:.5pt solid black;
  width:192pt'>: <?php echo $NO_URUT_PO; ?></td>
					<td class=xl159072></td>
					<td class=xl659072></td>
				</tr>
				<tr height=19 style='mso-height-source:userset;height:14.45pt'>
					<td height=19 class=xl719072 width=42 style='height:14.45pt;width:32pt'>&nbsp;</td>
					<td class=xl709072 width=64 style='width:48pt'></td>
					<td class=xl649072 width=64 style='width:48pt'></td>
					<td class=xl649072 width=64 style='width:48pt'></td>
					<td class=xl649072 width=64 style='width:48pt'></td>
					<td class=xl649072 width=64 style='width:48pt'></td>
					<td class=xl159072></td>
					<td class=xl659072></td>
				</tr>
				<tr height=19 style='mso-height-source:userset;height:14.45pt'>
					<td height=19 class=xl719072 width=42 style='height:14.45pt;width:32pt'>&nbsp;</td>
					<td class=xl709072 width=64 style='width:48pt'></td>
					<td class=xl649072 width=64 style='width:48pt'></td>
					<td class=xl649072 width=64 style='width:48pt'></td>
					<td class=xl649072 width=64 style='width:48pt'></td>
					<td class=xl649072 width=64 style='width:48pt'></td>
					<td class=xl159072></td>
					<td class=xl659072></td>
				</tr>
				<tr height=22 style='height:16.5pt'>
					<td height=22 class=xl669072 style='height:16.5pt'>&nbsp;</td>
					<td class=xl659072></td>
					<td class=xl659072></td>
					<td class=xl659072></td>
					<td class=xl659072></td>
					<td class=xl659072></td>
					<td class=xl659072></td>
					<td class=xl659072></td>
					<td class=xl659072></td>
					<td class=xl659072></td>
					<td class=xl679072>&nbsp;</td>
				</tr>
				<![if supportMisalignedColumns]>
				<tr height=0 style='display:none'>
					<td width=42 style='width:32pt'></td>
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
	</header>

	<footer>
		<img style="width: 80px;" src="<?php echo $GAMBAR_QR_2; ?>"> Validasi dokumen scan kode QR
	</footer>

	<!-- Wrap the content of your PDF inside a main tag -->
	<main>
		<div class="myDiv">
			<div id="patokan sppb_828" align=center x:publishsource="Excel">

				<table border=0 cellpadding=0 cellspacing=0 width=875 style='border-collapse:
 collapse;table-layout:fixed;width:656pt'>
					<col width=43 style='mso-width-source:userset;mso-width-alt:1536;width:32pt'>
					<col width=64 span=13 style='width:48pt'>
					<tr height=19 style='mso-height-source:userset;height:14.4pt'>
						<td colspan=6 height=19 class=xl89828 width=363 style='border-right:.5pt solid black;
  height:14.4pt;width:272pt'><span style='mso-spacerun:yes'>&nbsp;Syarat
							Pembayaran<font class="font5828"><span style='mso-spacerun:yes'> </span>:
								<?php echo $NAMA_TERM_OF_PAYMENT; ?></font>
						</td>
						<td colspan=5 class=xl81828 width=320 style='border-right:1.0pt solid black;
  border-left:none;width:240pt'>
							<font class="font7828"><span style='mso-spacerun:yes'>&nbsp;Lokasi Penyerahan</font>
							<font class="font6828"> : <?php echo $NAMA_LOKASI_PENYERAHAN; ?></font>
						</td>
						<td class=xl15828 width=64 style='width:48pt'></td>
						<td class=xl15828 width=64 style='width:48pt'></td>
						<td class=xl73828 width=64 style='width:48pt'>&nbsp;</td>
					</tr>
					<tr height=29 style='height:21.6pt'>
						<td height=29 class=xl74828 style='height:21.6pt;border-top:none'>No.</td>
						<td colspan=2 class=xl88828 width=128 style='border-right:.5pt solid black;
  border-left:none;width:96pt'>Nama Barang</td>
						<td colspan=2 class=xl72828 width=128 style='border-left:none;width:96pt'>Spesifikasi</td>
						<td class=xl71828 width=64 style='border-top:none;width:48pt'>Jenis Barang</td>
						<td class=xl72828 width=64 style='border-top:none;border-left:none;
  width:48pt'>Banyaknya</td>
						<td class=xl72828 width=64 style='border-top:none;border-left:none;
  width:48pt'>Satuan</td>
						<td class=xl72828 width=64 style='border-top:none;border-left:none;
  width:48pt'>Harga Satuan</td>
						<td colspan=2 class=xl88828 width=128 style='border-right:1.0pt solid black;
  border-left:none;width:96pt'>Total</td>
						<td class=xl15828></td>
						<td class=xl15828></td>
						<td class=xl15828></td>
					</tr>

					<?php
					$hitung = 1;
					if (!empty($this->data['konten_PO_form'])) {
						foreach ($konten_PO_form as $item) {
					?>
							<tr height=22 style='mso-height-source:userset;height:16.5pt'>
								<td height=22 class=xl75828 width=43 style='height:16.5pt;border-top:none;
  width:32pt'><?php echo $hitung; ?></td>
								<td colspan=2 class=xl80828 width=128 style='border-left:none;width:96pt'><?php
																											echo $item->NAMA_BARANG; ?></td>
								<td colspan=2 class=xl80828 width=128 style='border-left:none;width:96pt'><?php
																											echo $item->SPESIFIKASI_SINGKAT; ?></td>
								<td class=xl66828 width=64 style='border-top:none;width:48pt'><?php echo
																								$item->NAMA_JENIS_BARANG; ?></td>
								<td class=xl65828 width=64 style='border-top:none;border-left:none;
  width:48pt'><?php echo $item->JUMLAH_BARANG; ?></td>
								<td class=xl65828 width=64 style='border-top:none;border-left:none;
  width:48pt'><?php echo $item->NAMA_SATUAN_BARANG; ?></td>
								<td class=xl77828 width=64 style='border-top:none;border-left:none;
  width:48pt'>Rp. <?php echo
							number_format(
								$item->HARGA_SATUAN_BARANG_FIX,
								2,
								",",
								"."
							); ?></td>
								<td colspan=2 class=xl92828 width=128 style='border-right:1.0pt solid black;
  border-left:none;width:96pt'>Rp. <?php echo number_format($item->HARGA_TOTAL_FIX, 2, ",", "."); ?></td>
								<td class=xl67828></td>
								<td class=xl15828></td>
								<td class=xl15828></td>
							</tr>
					<?php
							$hitung = $hitung + 1;
						}
					} ?>
					<tr height=19 style='height:14.4pt'>
						<td colspan=9 height=19 class=xl91828 width=555 style='border-right:.5pt solid black;
  height:14.4pt;width:416pt'>SUB TOTAL</td>
						<td colspan=2 class=xl92828 width=128 style='border-right:1.0pt solid black;
  border-left:none;width:96pt'>Rp. <?php echo number_format($item->TOTAL_HARGA_PO_BARANG, 2, ",", "."); ?></td>
						<td class=xl15828></td>
						<td class=xl15828></td>
						<td class=xl15828></td>
					</tr>
					<tr height=19 style='height:14.4pt'>
						<td colspan=9 height=19 class=xl91828 width=555 style='border-right:.5pt solid black;
  height:14.4pt;width:416pt'>PAJAK <?php echo $KETERANGAN; ?></td>
						<td colspan=2 class=xl92828 width=128 style='border-right:1.0pt solid black;
  border-left:none;width:96pt'>Rp. <?php echo number_format($item->TOTAL_PAJAK_PO_BARANG, 2, ",", "."); ?></td>
						<td class=xl15828></td>
						<td class=xl15828></td>
						<td class=xl15828></td>
					</tr>
					<tr height=19 style='height:14.4pt'>
						<td colspan=9 height=19 class=xl91828 width=555 style='border-right:.5pt solid black;
  height:14.4pt;width:416pt'>TOTAL</td>
						<td colspan=2 class=xl92828 width=128 style='border-right:1.0pt solid black;
  border-left:none;width:96pt'>Rp. <?php echo number_format($item->TOTAL_ALL_PO_BARANG, 2, ",", "."); ?></td>
						<td class=xl15828></td>
						<td class=xl15828></td>
						<td class=xl15828></td>
					</tr>
					<tr height=19 style='height:14.4pt'>
						<td height=19 class=xl69828 style='height:14.4pt'>&nbsp;</td>
						<td class=xl104828></td>
						<td class=xl104828></td>
						<td class=xl104828></td>
						<td class=xl104828></td>
						<td class=xl104828></td>
						<td class=xl104828></td>
						<td class=xl104828></td>
						<td class=xl104828></td>
						<td class=xl104828></td>
						<td class=xl76828>&nbsp;</td>
						<td class=xl15828></td>
						<td class=xl15828></td>
						<td class=xl15828></td>
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
						<td colspan=2 height=19 class=xl112828 style='height:14.4pt'>Terbilang</td>
						<td colspan=9 class=xl83828 width=576 style='border-right:1.0pt solid black;
  width:432pt'>: <?php echo terbilang($TOTAL_ALL_PO_BARANG); ?> Rupiah</td>
						<td class=xl15828></td>
						<td class=xl15828></td>
						<td class=xl15828></td>
					</tr>
					<tr height=19 style='height:14.4pt'>
						<td colspan=2 height=19 class=xl112828 style='height:14.4pt'>Keperluan</td>
						<td colspan=8 class=xl79828>: <?php echo ($CTT_KEPERLUAN); ?></td>
						<td class=xl110828 style='border-top:none'>&nbsp;</td>
						<td class=xl15828></td>
						<td class=xl15828></td>
						<td class=xl15828></td>
					</tr>
					<tr height=19 style='height:14.4pt'>
						<td height=19 class=xl69828 style='height:14.4pt'>&nbsp;</td>
						<td class=xl111828></td>
						<td colspan=9 class=xl82828 style='border-right:1.0pt solid black'>&nbsp;</td>
						<td class=xl15828></td>
						<td class=xl15828></td>
						<td class=xl15828></td>
					</tr>
					<tr height=19 style='height:14.4pt'>
						<td height=19 class=xl69828 style='height:14.4pt'>&nbsp;</td>
						<td class=xl111828></td>
						<td colspan=9 class=xl82828 style='border-right:1.0pt solid black'>&nbsp;</td>
						<td class=xl15828></td>
						<td class=xl15828></td>
						<td class=xl15828></td>
					</tr>
					<tr height=19 style='height:14.4pt'>
						<td height=19 class=xl69828 style='height:14.4pt'>&nbsp;</td>
						<td class=xl102828></td>
						<td class=xl102828></td>
						<td class=xl102828></td>
						<td class=xl102828></td>
						<td class=xl102828></td>
						<td class=xl102828></td>
						<td class=xl102828></td>
						<td class=xl102828></td>
						<td class=xl102828></td>
						<td class=xl70828>&nbsp;</td>
						<td class=xl15828></td>
						<td class=xl68828></td>
						<td class=xl15828></td>
					</tr>
					<tr height=19 style='mso-height-source:userset;height:14.4pt'>
						<td colspan=2 height=19 class=xl98828 style='height:14.4pt'>KONDISI
							PENGADAAN:</td>
						<td class=xl106828 width=64 style='width:48pt'></td>
						<td class=xl106828 width=64 style='width:48pt'></td>
						<td class=xl107828></td>
						<td class=xl107828></td>
						<td class=xl107828></td>
						<td class=xl107828></td>
						<td class=xl107828></td>
						<td class=xl102828></td>
						<td class=xl70828>&nbsp;</td>
						<td class=xl15828></td>
						<td class=xl15828></td>
						<td class=xl15828></td>
					</tr>
					<tr height=19 style='height:14.4pt'>
						<td colspan=11 height=19 class=xl95828 width=683 style='border-right:1.0pt solid black;
  height:14.4pt;width:512pt'>isi teks</td>
						<td class=xl15828></td>
						<td class=xl15828></td>
						<td class=xl15828></td>
					</tr>
					<tr height=19 style='height:14.4pt'>
						<td colspan=11 height=19 class=xl95828 width=683 style='border-right:1.0pt solid black;
  height:14.4pt;width:512pt'>isi teks</td>
						<td class=xl15828></td>
						<td class=xl15828></td>
						<td class=xl15828></td>
					</tr>
					<tr height=19 style='height:14.4pt'>
						<td colspan=11 height=19 class=xl95828 width=683 style='border-right:1.0pt solid black;
  height:14.4pt;width:512pt'>isi teks</td>
						<td class=xl15828></td>
						<td class=xl15828></td>
						<td class=xl15828></td>
					</tr>
					<tr height=19 style='height:14.4pt'>
						<td colspan=11 height=19 class=xl95828 width=683 style='border-right:1.0pt solid black;
  height:14.4pt;width:512pt'>isi teks</td>
						<td class=xl15828></td>
						<td class=xl15828></td>
						<td class=xl15828></td>
					</tr>
					<tr height=19 style='height:14.4pt'>
						<td colspan=11 height=19 class=xl100828 width=683 style='border-right:1.0pt solid black;
  height:14.4pt;width:512pt'>isi teks</td>
						<td class=xl15828></td>
						<td class=xl15828></td>
						<td class=xl15828></td>
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

			<div id="patokan sppb_10840" align=center x:publishsource="Excel">

				<table border=0 cellpadding=0 cellspacing=0 width=683 style='border-collapse:
 collapse;table-layout:fixed;width:512pt'>
					<col width=43 style='mso-width-source:userset;mso-width-alt:1536;width:32pt'>
					<col width=64 span=10 style='width:48pt'>
					<tr height=19 style='height:14.4pt'>
						<td height=19 class=xl7010840 width=43 style='height:14.4pt;width:32pt'>&nbsp;</td>
						<td class=xl7110840 width=64 style='width:48pt'></td>
						<td class=xl7110840 width=64 style='width:48pt'></td>
						<td class=xl7110840 width=64 style='width:48pt'></td>
						<td class=xl7110840 width=64 style='width:48pt'></td>
						<td class=xl7110840 width=64 style='width:48pt'></td>
						<td class=xl7110840 width=64 style='width:48pt'></td>
						<td class=xl7110840 width=64 style='width:48pt'></td>
						<td class=xl7110840 width=64 style='width:48pt'></td>
						<td class=xl7110840 width=64 style='width:48pt'></td>
						<td class=xl7210840 width=64 style='width:48pt'>&nbsp;</td>
					</tr>
					<tr height=19 style='height:14.4pt'>
						<td height=19 class=xl6610840 style='height:14.4pt'>&nbsp;</td>
						<td class=xl6710840 width=64 style='width:48pt'></td>
						<td class=xl6710840 width=64 style='width:48pt'></td>
						<td class=xl6710840 width=64 style='width:48pt'></td>
						<td class=xl6710840 width=64 style='width:48pt'></td>
						<td class=xl6710840 width=64 style='width:48pt'></td>
						<td class=xl6810840>&nbsp;</td>
						<td colspan=2 class=xl7410840 style='border-left:none'>Disetujui Oleh,</td>
						<td colspan=2 class=xl7410840 style='border-right:1.0pt solid black;
  border-left:none'>Disiapkan Oleh,</td>
					</tr>
					<tr height=19 style='height:14.4pt'>
						<td height=19 class=xl6610840 style='height:14.4pt'>&nbsp;</td>
						<td class=xl6710840 width=64 style='width:48pt'></td>
						<td class=xl6710840 width=64 style='width:48pt'></td>
						<td class=xl6710840 width=64 style='width:48pt'></td>
						<td class=xl6710840 width=64 style='width:48pt'></td>
						<td class=xl6710840 width=64 style='width:48pt'></td>
						<td class=xl6810840>&nbsp;</td>
						<td colspan=2 rowspan=3 class=xl7310840 width=128 style='width:96pt'><?php
																								echo $SIGN_USER_M_PROC; ?></td>
						<td colspan=2 rowspan=3 class=xl7310840 width=128 style='border-right:1.0pt solid black;
  width:96pt'><?php echo $SIGN_USER_KASIE_PROC; ?></td>
					</tr>
					<tr height=19 style='height:14.4pt'>
						<td height=19 class=xl6610840 style='height:14.4pt'>&nbsp;</td>
						<td class=xl6710840 width=64 style='width:48pt'></td>
						<td class=xl6710840 width=64 style='width:48pt'></td>
						<td class=xl6710840 width=64 style='width:48pt'></td>
						<td class=xl6710840 width=64 style='width:48pt'></td>
						<td class=xl6710840 width=64 style='width:48pt'></td>
						<td class=xl6810840>&nbsp;</td>
					</tr>
					<tr height=19 style='height:14.4pt'>
						<td height=19 class=xl6610840 style='height:14.4pt'>&nbsp;</td>
						<td class=xl6710840 width=64 style='width:48pt'></td>
						<td class=xl6710840 width=64 style='width:48pt'></td>
						<td class=xl6710840 width=64 style='width:48pt'></td>
						<td class=xl6710840 width=64 style='width:48pt'></td>
						<td class=xl6710840 width=64 style='width:48pt'></td>
						<td class=xl6810840>&nbsp;</td>
					</tr>
					<tr height=19 style='height:14.4pt'>
						<td height=19 class=xl6610840 style='height:14.4pt'>&nbsp;</td>
						<td class=xl6710840 width=64 style='width:48pt'></td>
						<td class=xl6710840 width=64 style='width:48pt'></td>
						<td class=xl6710840 width=64 style='width:48pt'></td>
						<td class=xl6710840 width=64 style='width:48pt'></td>
						<td class=xl6710840 width=64 style='width:48pt'></td>
						<td class=xl6810840>&nbsp;</td>
						<td colspan=2 class=xl7410840 style='border-left:none'>Mjr. Pengadaan</td>
						<td colspan=2 class=xl7410840 style='border-right:1.0pt solid black;
  border-left:none'>Bag. Pembelian</td>
					</tr>
					<tr height=20 style='height:15.0pt'>
						<td height=20 class=xl6510840 style='height:15.0pt'>&nbsp;</td>
						<td class=xl6910840>&nbsp;</td>
						<td class=xl6910840>&nbsp;</td>
						<td class=xl6910840>&nbsp;</td>
						<td class=xl6910840>&nbsp;</td>
						<td class=xl6910840>&nbsp;</td>
						<td class=xl6410840>&nbsp;</td>
						<td class=xl6410840>&nbsp;</td>
						<td class=xl6410840>&nbsp;</td>
						<td class=xl6410840>&nbsp;</td>
						<td class=xl6310840>&nbsp;</td>
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
					</tr>
					<![endif]>
				</table>

			</div>

		</div>
	</main>
</body>

</html>