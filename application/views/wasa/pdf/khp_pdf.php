<!DOCTYPE html>
<html lang="en">

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
			margin-top: 4.09cm;
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
			bottom: 1cm;
			left: 1cm;
			right: 0cm;
			height: 2cm;

			font-size: 8.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: Calibri Light;
		}
	</style>

	<style id="patokan sppb_14722_Styles"><!--table
			{mso-displayed-decimal-separator:"\.";
			mso-displayed-thousand-separator:"\,";}
		.xl6514722
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
		.xl6614722
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
			vertical-align:middle;
			border-top:.5pt solid windowtext;
			border-right:none;
			border-bottom:none;
			border-left:.5pt solid windowtext;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl6714722
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
			vertical-align:middle;
			border-top:none;
			border-right:none;
			border-bottom:none;
			border-left:.5pt solid windowtext;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl6814722
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
			vertical-align:middle;
			border-top:.5pt solid windowtext;
			border-right:none;
			border-bottom:.5pt solid windowtext;
			border-left:.5pt solid windowtext;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl6914722
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
			vertical-align:middle;
			border-top:none;
			border-right:none;
			border-bottom:.5pt solid windowtext;
			border-left:.5pt solid windowtext;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl7014722
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
			text-align:center;
			vertical-align:middle;
			border-top:none;
			border-right:none;
			border-bottom:none;
			border-left:.5pt solid windowtext;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl7114722
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
			text-align:general;
			vertical-align:bottom;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl7214722
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
		.xl7314722
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
			border-top:none;
			border-right:.5pt solid windowtext;
			border-bottom:none;
			border-left:none;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl7414722
			{padding-top:1px;
			padding-right:1px;
			padding-left:1px;
			mso-ignore:padding;
			color:windowtext;
			font-size:7.0pt;
			font-weight:400;
			font-style:normal;
			text-decoration:none;
			font-family:"Calibri Light", sans-serif;
			mso-font-charset:0;
			mso-number-format:General;
			text-align:left;
			vertical-align:middle;
			border-top:.5pt solid windowtext;
			border-right:none;
			border-bottom:.5pt solid windowtext;
			border-left:.5pt solid windowtext;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl7514722
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
			text-align:general;
			vertical-align:middle;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl7614722
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
			text-align:general;
			vertical-align:middle;
			border-top:none;
			border-right:none;
			border-bottom:.5pt solid windowtext;
			border-left:none;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl7714722
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
			text-align:general;
			vertical-align:middle;
			border-top:.5pt solid windowtext;
			border-right:none;
			border-bottom:none;
			border-left:none;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl7814722
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
			text-align:general;
			vertical-align:middle;
			border-top:none;
			border-right:.5pt solid windowtext;
			border-bottom:.5pt solid windowtext;
			border-left:none;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl7914722
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
			text-align:general;
			vertical-align:middle;
			border-top:.5pt solid windowtext;
			border-right:none;
			border-bottom:none;
			border-left:none;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl8014722
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
			text-align:general;
			vertical-align:middle;
			border-top:.5pt solid windowtext;
			border-right:.5pt solid windowtext;
			border-bottom:none;
			border-left:none;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl8114722
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
			text-align:general;
			vertical-align:middle;
			border-top:none;
			border-right:.5pt solid windowtext;
			border-bottom:none;
			border-left:none;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl8214722
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
			text-align:center;
			vertical-align:middle;
			border-top:.5pt solid windowtext;
			border-right:.5pt solid windowtext;
			border-bottom:.5pt solid windowtext;
			border-left:none;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl8314722
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
			vertical-align:middle;
			border-top:.5pt solid windowtext;
			border-right:none;
			border-bottom:.5pt solid windowtext;
			border-left:none;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl8414722
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
			vertical-align:middle;
			border-top:.5pt solid windowtext;
			border-right:.5pt solid windowtext;
			border-bottom:.5pt solid windowtext;
			border-left:none;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl8514722
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
			vertical-align:middle;
			border-top:.5pt solid windowtext;
			border-right:none;
			border-bottom:.5pt solid windowtext;
			border-left:none;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl8614722
			{padding-top:1px;
			padding-right:1px;
			padding-left:1px;
			mso-ignore:padding;
			color:black;
			font-size:14.0pt;
			font-weight:700;
			font-style:normal;
			text-decoration:none;
			font-family:"Calibri Light", sans-serif;
			mso-font-charset:0;
			mso-number-format:General;
			text-align:center;
			vertical-align:middle;
			border:.5pt solid windowtext;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl8714722
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
			text-align:center;
			vertical-align:middle;
			border:.5pt solid windowtext;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl8814722
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
			text-align:center;
			vertical-align:middle;
			border-top:.5pt solid windowtext;
			border-right:none;
			border-bottom:.5pt solid windowtext;
			border-left:none;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl8914722
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
			text-align:general;
			vertical-align:middle;
			border-top:.5pt solid windowtext;
			border-right:none;
			border-bottom:.5pt solid windowtext;
			border-left:none;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
	--></style>

	<style id="patokan sppb_2921_Styles"><!--table
			{mso-displayed-decimal-separator:"\.";
			mso-displayed-thousand-separator:"\,";}
		.xl652921
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
		.xl662921
			{padding-top:1px;
			padding-right:1px;
			padding-left:1px;
			mso-ignore:padding;
			color:black;
			font-size:7.0pt;
			font-weight:700;
			font-style:normal;
			text-decoration:none;
			font-family:"Calibri Light", sans-serif;
			mso-font-charset:0;
			mso-number-format:General;
			text-align:center;
			vertical-align:middle;
			border:.5pt solid windowtext;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl672921
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
			text-align:center;
			vertical-align:middle;
			border:.5pt solid windowtext;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl682921
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
			vertical-align:middle;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl692921
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
			text-align:general;
			vertical-align:middle;
			border:.5pt solid windowtext;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl702921
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
			text-align:center;
			vertical-align:middle;
			border-top:none;
			border-right:none;
			border-bottom:.5pt solid windowtext;
			border-left:.5pt solid windowtext;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl712921
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
			text-align:center;
			vertical-align:middle;
			border-top:none;
			border-right:.5pt solid windowtext;
			border-bottom:.5pt solid windowtext;
			border-left:none;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl722921
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
			text-align:center;
			vertical-align:middle;
			border-top:.5pt solid windowtext;
			border-right:none;
			border-bottom:.5pt solid windowtext;
			border-left:.5pt solid windowtext;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl732921
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
			text-align:center;
			vertical-align:middle;
			border-top:.5pt solid windowtext;
			border-right:.5pt solid windowtext;
			border-bottom:.5pt solid windowtext;
			border-left:none;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl742921
			{padding-top:1px;
			padding-right:1px;
			padding-left:1px;
			mso-ignore:padding;
			color:black;
			font-size:7.0pt;
			font-weight:700;
			font-style:normal;
			text-decoration:none;
			font-family:"Calibri Light", sans-serif;
			mso-font-charset:0;
			mso-number-format:General;
			text-align:center;
			vertical-align:middle;
			border-top:.5pt solid windowtext;
			border-right:none;
			border-bottom:.5pt solid windowtext;
			border-left:.5pt solid windowtext;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl752921
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
			vertical-align:middle;
			border-top:.5pt solid windowtext;
			border-right:.5pt solid windowtext;
			border-bottom:.5pt solid windowtext;
			border-left:none;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl762921
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
			vertical-align:middle;
			border-top:.5pt solid windowtext;
			border-right:.5pt solid windowtext;
			border-bottom:.5pt solid windowtext;
			border-left:none;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl772921
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
			vertical-align:middle;
			border-top:.5pt solid windowtext;
			border-right:none;
			border-bottom:.5pt solid windowtext;
			border-left:.5pt solid windowtext;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl782921
			{padding-top:1px;
			padding-right:1px;
			padding-left:1px;
			mso-ignore:padding;
			color:black;
			font-size:7.0pt;
			font-weight:700;
			font-style:normal;
			text-decoration:none;
			font-family:"Calibri Light", sans-serif;
			mso-font-charset:0;
			mso-number-format:General;
			text-align:center;
			vertical-align:middle;
			border-top:.5pt solid windowtext;
			border-right:none;
			border-bottom:.5pt solid windowtext;
			border-left:.5pt solid windowtext;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl792921
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
			vertical-align:middle;
			border-top:.5pt solid windowtext;
			border-right:none;
			border-bottom:.5pt solid windowtext;
			border-left:.5pt solid windowtext;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl802921
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
			text-align:center;
			vertical-align:middle;
			border-top:.5pt solid windowtext;
			border-right:none;
			border-bottom:.5pt solid windowtext;
			border-left:.5pt solid windowtext;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl812921
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
			text-align:center;
			vertical-align:middle;
			border-top:.5pt solid windowtext;
			border-right:.5pt solid windowtext;
			border-bottom:.5pt solid windowtext;
			border-left:none;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl822921
			{padding-top:1px;
			padding-right:1px;
			padding-left:1px;
			mso-ignore:padding;
			color:black;
			font-size:7.0pt;
			font-weight:700;
			font-style:normal;
			text-decoration:none;
			font-family:"Calibri Light", sans-serif;
			mso-font-charset:0;
			mso-number-format:General;
			text-align:center;
			vertical-align:middle;
			border-top:.5pt solid windowtext;
			border-right:.5pt solid windowtext;
			border-bottom:.5pt solid windowtext;
			border-left:none;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl832921
			{padding-top:1px;
			padding-right:1px;
			padding-left:1px;
			mso-ignore:padding;
			color:black;
			font-size:7.0pt;
			font-weight:700;
			font-style:normal;
			text-decoration:none;
			font-family:"Calibri Light", sans-serif;
			mso-font-charset:0;
			mso-number-format:General;
			text-align:center;
			vertical-align:middle;
			border:.5pt solid windowtext;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl842921
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
			vertical-align:middle;
			border:.5pt solid windowtext;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl852921
			{padding-top:1px;
			padding-right:1px;
			padding-left:1px;
			mso-ignore:padding;
			color:black;
			font-size:7.0pt;
			font-weight:700;
			font-style:normal;
			text-decoration:none;
			font-family:"Calibri Light", sans-serif;
			mso-font-charset:0;
			mso-number-format:General;
			text-align:center;
			vertical-align:middle;
			border-top:.5pt solid windowtext;
			border-right:none;
			border-bottom:none;
			border-left:.5pt solid windowtext;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl862921
			{padding-top:1px;
			padding-right:1px;
			padding-left:1px;
			mso-ignore:padding;
			color:black;
			font-size:7.0pt;
			font-weight:700;
			font-style:normal;
			text-decoration:none;
			font-family:"Calibri Light", sans-serif;
			mso-font-charset:0;
			mso-number-format:General;
			text-align:center;
			vertical-align:middle;
			border-top:.5pt solid windowtext;
			border-right:.5pt solid windowtext;
			border-bottom:none;
			border-left:none;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl872921
			{padding-top:1px;
			padding-right:1px;
			padding-left:1px;
			mso-ignore:padding;
			color:black;
			font-size:7.0pt;
			font-weight:700;
			font-style:normal;
			text-decoration:none;
			font-family:"Calibri Light", sans-serif;
			mso-font-charset:0;
			mso-number-format:General;
			text-align:center;
			vertical-align:middle;
			border-top:none;
			border-right:none;
			border-bottom:.5pt solid windowtext;
			border-left:.5pt solid windowtext;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl882921
			{padding-top:1px;
			padding-right:1px;
			padding-left:1px;
			mso-ignore:padding;
			color:black;
			font-size:7.0pt;
			font-weight:700;
			font-style:normal;
			text-decoration:none;
			font-family:"Calibri Light", sans-serif;
			mso-font-charset:0;
			mso-number-format:General;
			text-align:center;
			vertical-align:middle;
			border-top:none;
			border-right:.5pt solid windowtext;
			border-bottom:.5pt solid windowtext;
			border-left:none;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl892921
			{padding-top:1px;
			padding-right:1px;
			padding-left:1px;
			mso-ignore:padding;
			color:black;
			font-size:7.0pt;
			font-weight:700;
			font-style:normal;
			text-decoration:none;
			font-family:"Calibri Light", sans-serif;
			mso-font-charset:0;
			mso-number-format:General;
			text-align:center;
			vertical-align:middle;
			border-top:.5pt solid windowtext;
			border-right:none;
			border-bottom:none;
			border-left:.5pt solid windowtext;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl902921
			{padding-top:1px;
			padding-right:1px;
			padding-left:1px;
			mso-ignore:padding;
			color:black;
			font-size:7.0pt;
			font-weight:700;
			font-style:normal;
			text-decoration:none;
			font-family:"Calibri Light", sans-serif;
			mso-font-charset:0;
			mso-number-format:General;
			text-align:center;
			vertical-align:middle;
			border-top:.5pt solid windowtext;
			border-right:.5pt solid windowtext;
			border-bottom:none;
			border-left:none;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl912921
			{padding-top:1px;
			padding-right:1px;
			padding-left:1px;
			mso-ignore:padding;
			color:black;
			font-size:7.0pt;
			font-weight:700;
			font-style:normal;
			text-decoration:none;
			font-family:"Calibri Light", sans-serif;
			mso-font-charset:0;
			mso-number-format:General;
			text-align:center;
			vertical-align:middle;
			border-top:none;
			border-right:none;
			border-bottom:.5pt solid windowtext;
			border-left:.5pt solid windowtext;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl922921
			{padding-top:1px;
			padding-right:1px;
			padding-left:1px;
			mso-ignore:padding;
			color:black;
			font-size:7.0pt;
			font-weight:700;
			font-style:normal;
			text-decoration:none;
			font-family:"Calibri Light", sans-serif;
			mso-font-charset:0;
			mso-number-format:General;
			text-align:center;
			vertical-align:middle;
			border-top:none;
			border-right:.5pt solid windowtext;
			border-bottom:.5pt solid windowtext;
			border-left:none;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl932921
			{padding-top:1px;
			padding-right:1px;
			padding-left:1px;
			mso-ignore:padding;
			color:black;
			font-size:7.0pt;
			font-weight:700;
			font-style:normal;
			text-decoration:none;
			font-family:"Calibri Light", sans-serif;
			mso-font-charset:0;
			mso-number-format:General;
			text-align:center;
			vertical-align:middle;
			border-top:.5pt solid windowtext;
			border-right:.5pt solid windowtext;
			border-bottom:none;
			border-left:.5pt solid windowtext;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl942921
			{padding-top:1px;
			padding-right:1px;
			padding-left:1px;
			mso-ignore:padding;
			color:black;
			font-size:7.0pt;
			font-weight:700;
			font-style:normal;
			text-decoration:none;
			font-family:"Calibri Light", sans-serif;
			mso-font-charset:0;
			mso-number-format:General;
			text-align:center;
			vertical-align:middle;
			border-top:none;
			border-right:.5pt solid windowtext;
			border-bottom:.5pt solid windowtext;
			border-left:.5pt solid windowtext;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl952921
			{padding-top:1px;
			padding-right:1px;
			padding-left:1px;
			mso-ignore:padding;
			color:black;
			font-size:7.0pt;
			font-weight:700;
			font-style:normal;
			text-decoration:none;
			font-family:"Calibri Light", sans-serif;
			mso-font-charset:0;
			mso-number-format:General;
			text-align:center;
			vertical-align:middle;
			border-top:.5pt solid windowtext;
			border-right:.5pt solid windowtext;
			border-bottom:.5pt solid windowtext;
			border-left:none;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl962921
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
			text-align:center;
			vertical-align:middle;
			border-top:.5pt solid windowtext;
			border-right:none;
			border-bottom:none;
			border-left:none;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl972921
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
			text-align:center;
			vertical-align:middle;
			border-top:.5pt solid windowtext;
			border-right:.5pt solid windowtext;
			border-bottom:none;
			border-left:none;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl982921
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
			text-align:center;
			vertical-align:middle;
			border-top:none;
			border-right:none;
			border-bottom:.5pt solid windowtext;
			border-left:none;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl992921
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
			vertical-align:middle;
			border-top:.5pt solid windowtext;
			border-right:none;
			border-bottom:none;
			border-left:none;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl1002921
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
			text-align:center;
			vertical-align:middle;
			border-top:.5pt solid windowtext;
			border-right:none;
			border-bottom:none;
			border-left:.5pt solid windowtext;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
	--></style>

	<style id="patokan sppb_18252_Styles"><!--table
			{mso-displayed-decimal-separator:"\.";
			mso-displayed-thousand-separator:"\,";}
		.xl1518252
			{padding-top:1px;
			padding-right:1px;
			padding-left:1px;
			mso-ignore:padding;
			color:black;
			font-size:11.0pt;
			font-weight:400;
			font-style:normal;
			text-decoration:none;
			font-family:Calibri, sans-serif;
			mso-font-charset:0;
			mso-number-format:General;
			text-align:general;
			vertical-align:bottom;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl6518252
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
		.xl6618252
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
			border-top:.5pt solid windowtext;
			border-right:none;
			border-bottom:none;
			border-left:none;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl6718252
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
		.xl6818252
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
			text-align:general;
			vertical-align:middle;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl6918252
			{padding-top:1px;
			padding-right:1px;
			padding-left:1px;
			mso-ignore:padding;
			color:black;
			font-size:7.0pt;
			font-weight:700;
			font-style:normal;
			text-decoration:none;
			font-family:"Calibri Light", sans-serif;
			mso-font-charset:0;
			mso-number-format:General;
			text-align:center;
			vertical-align:middle;
			border-top:.5pt solid windowtext;
			border-right:none;
			border-bottom:.5pt solid windowtext;
			border-left:.5pt solid windowtext;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl7018252
			{padding-top:1px;
			padding-right:1px;
			padding-left:1px;
			mso-ignore:padding;
			color:black;
			font-size:7.0pt;
			font-weight:700;
			font-style:normal;
			text-decoration:none;
			font-family:"Calibri Light", sans-serif;
			mso-font-charset:0;
			mso-number-format:General;
			text-align:center;
			vertical-align:middle;
			border-top:.5pt solid windowtext;
			border-right:.5pt solid windowtext;
			border-bottom:.5pt solid windowtext;
			border-left:none;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl7118252
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
			text-align:center;
			vertical-align:middle;
			border-top:.5pt solid windowtext;
			border-right:none;
			border-bottom:none;
			border-left:.5pt solid windowtext;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl7218252
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
			text-align:center;
			vertical-align:middle;
			border-top:.5pt solid windowtext;
			border-right:.5pt solid windowtext;
			border-bottom:none;
			border-left:none;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl7318252
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
			text-align:center;
			vertical-align:middle;
			border-top:none;
			border-right:none;
			border-bottom:none;
			border-left:.5pt solid windowtext;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl7418252
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
			text-align:center;
			vertical-align:middle;
			border-top:none;
			border-right:.5pt solid windowtext;
			border-bottom:none;
			border-left:none;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl7518252
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
			text-align:center;
			vertical-align:middle;
			border-top:none;
			border-right:none;
			border-bottom:.5pt solid windowtext;
			border-left:.5pt solid windowtext;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl7618252
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
			text-align:center;
			vertical-align:middle;
			border-top:none;
			border-right:.5pt solid windowtext;
			border-bottom:.5pt solid windowtext;
			border-left:none;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl7718252
			{padding-top:1px;
			padding-right:1px;
			padding-left:1px;
			mso-ignore:padding;
			color:black;
			font-size:7.0pt;
			font-weight:700;
			font-style:normal;
			text-decoration:none;
			font-family:"Calibri Light", sans-serif;
			mso-font-charset:0;
			mso-number-format:General;
			text-align:center;
			vertical-align:middle;
			border:.5pt solid windowtext;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl7818252
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
			text-align:center;
			vertical-align:middle;
			border:.5pt solid windowtext;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl7918252
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
			vertical-align:middle;
			border:.5pt solid windowtext;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl8018252
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
			text-align:center;
			vertical-align:middle;
			border-top:.5pt solid windowtext;
			border-right:none;
			border-bottom:none;
			border-left:none;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl8118252
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
			text-align:center;
			vertical-align:middle;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl8218252
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
			text-align:center;
			vertical-align:middle;
			border-top:none;
			border-right:none;
			border-bottom:.5pt solid windowtext;
			border-left:none;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl8318252
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
			white-space:normal;}
		.xl8418252
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
			border-top:.5pt solid windowtext;
			border-right:none;
			border-bottom:none;
			border-left:none;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl8518252
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
			vertical-align:middle;
			border-top:.5pt solid windowtext;
			border-right:none;
			border-bottom:none;
			border-left:none;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl8618252
			{padding-top:1px;
			padding-right:1px;
			padding-left:1px;
			mso-ignore:padding;
			color:black;
			font-size:7.0pt;
			font-weight:700;
			font-style:normal;
			text-decoration:none;
			font-family:"Calibri Light", sans-serif;
			mso-font-charset:0;
			mso-number-format:General;
			text-align:left;
			vertical-align:bottom;
			border:.5pt solid windowtext;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl8718252
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
			border-top:.5pt solid windowtext;
			border-right:none;
			border-bottom:.5pt solid windowtext;
			border-left:.5pt solid windowtext;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl8818252
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
			border-top:.5pt solid windowtext;
			border-right:none;
			border-bottom:.5pt solid windowtext;
			border-left:none;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl8918252
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
			border-top:.5pt solid windowtext;
			border-right:.5pt solid windowtext;
			border-bottom:.5pt solid windowtext;
			border-left:none;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
	--></style>


<body>
	<!-- Define header and footer blocks before your content -->
	<header>

		<div id="patokan sppb_14722" align=center x:publishsource="Excel">

			<table border=0 cellpadding=0 cellspacing=0 width=1024 class=xl6514722
			style='border-collapse:collapse;table-layout:fixed;width:768pt'>
			<col class=xl6514722 width=64 span=16 style='width:48pt'>
			<tr height=20 style='mso-height-source:userset;height:15.0pt'>
			<td rowspan=3 height=59 class=xl8714722 width=64 style='height:44.4pt;
			width:48pt'><img src="assets/logo_wasa.png" alt="" width=50 height=50></td>
			<td colspan=12 rowspan=2 class=xl8614722 width=768 style='width:576pt'>KOMPARASI
			HARGA PEMASOK</td>
			<td class=xl6614722 width=64 style='border-left:none;width:48pt'><span
			style='mso-spacerun:yes'>&nbsp;</span>Form No.</td>
			<td class=xl7914722 colspan=2 width=128 style='border-right:.5pt solid black;
			width:96pt'>: WME/FKPH/02</td>
			</tr>
			<tr height=20 style='mso-height-source:userset;height:15.0pt'>
			<td height=20 class=xl6714722 style='height:15.0pt;border-left:none'><span
			style='mso-spacerun:yes'>&nbsp;</span>SOP No.</td>
			<td class=xl7514722 colspan=2 style='border-right:.5pt solid black'>:
			WME/SOP/FHS-PL/01</td>
			</tr>
			<tr height=19 style='mso-height-source:userset;height:14.4pt'>
			<td height=19 class=xl6814722 style='height:14.4pt;border-top:none;
			border-left:none'><span style='mso-spacerun:yes'>&nbsp;</span>No. Urut KHP</td>
			<td colspan=8 class=xl8314722 width=512 style='width:384pt'>: <?php echo
						$NO_URUT_KHP; ?></td>
			<td class=xl8914722 width=64 style='border-top:none;width:48pt'>Tanggal:</td>
			<td colspan=2 class=xl8314722 width=128 style='border-right:.5pt solid black;
			width:96pt'>: <?php echo
						$TANGGAL_PEMBUATAN_KHP_HARI; ?></td>
			<td class=xl6914722 style='border-left:none'><span
			style='mso-spacerun:yes'>&nbsp;</span>Dept.</td>
			<td class=xl7614722 colspan=2 style='border-right:.5pt solid black'>:
			Procurement &amp; Logistic</td>
			</tr>
			<tr height=19 style='height:14.4pt'>
			<td height=19 class=xl7014722 style='height:14.4pt'>&nbsp;</td>
			<td class=xl7114722></td>
			<td class=xl7114722></td>
			<td class=xl7114722></td>
			<td class=xl7114722></td>
			<td class=xl7214722></td>
			<td class=xl7214722></td>
			<td class=xl7214722></td>
			<td class=xl7214722></td>
			<td class=xl7214722></td>
			<td class=xl7214722></td>
			<td class=xl7114722></td>
			<td class=xl7214722></td>
			<td class=xl7214722></td>
			<td class=xl7214722></td>
			<td class=xl7314722>&nbsp;</td>
			</tr>
			<tr height=19 style='mso-height-source:userset;height:14.4pt'>
			<td height=19 class=xl7414722 style='height:14.4pt'><span
			style='mso-spacerun:yes'>&nbsp;</span>Proyek</td>
			<td colspan=8 class=xl8514722 width=512 style='width:384pt'>: <?php echo $NAMA_PROYEK_PDF; ?> - </td>
			<td colspan=7 class=xl8814722 width=448 style='border-right:.5pt solid black;
			width:336pt'>&nbsp;</td>
			</tr>
			<tr height=19 style='height:14.4pt'>
			<td height=19 class=xl7714722 style='height:14.4pt;border-top:none'>&nbsp;</td>
			<td class=xl7714722 style='border-top:none'>&nbsp;</td>
			<td class=xl7714722 style='border-top:none'>&nbsp;</td>
			<td class=xl7714722 style='border-top:none'>&nbsp;</td>
			<td class=xl7714722 style='border-top:none'>&nbsp;</td>
			<td class=xl7714722 style='border-top:none'>&nbsp;</td>
			<td class=xl7714722 style='border-top:none'>&nbsp;</td>
			<td class=xl7714722 style='border-top:none'>&nbsp;</td>
			<td class=xl7714722 style='border-top:none'>&nbsp;</td>
			<td class=xl7714722 style='border-top:none'>&nbsp;</td>
			<td class=xl7714722 style='border-top:none'>&nbsp;</td>
			<td class=xl7714722 style='border-top:none'>&nbsp;</td>
			<td class=xl7714722 style='border-top:none'>&nbsp;</td>
			<td class=xl7714722 style='border-top:none'>&nbsp;</td>
			<td class=xl7714722 style='border-top:none'>&nbsp;</td>
			<td class=xl7714722 style='border-top:none'>&nbsp;</td>
			</tr>
			<![if supportMisalignedColumns]>
			<tr height=0 style='display:none'>
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
			<td width=64 style='width:48pt'></td>
			<td width=64 style='width:48pt'></td>
			</tr>
			<![endif]>
			</table>

			</div>


	</header>

	<footer>
		<img style="width: 80px;" src="<?php echo $GAMBAR_QR_2; ?>">
	</footer>

	<!-- Wrap the content of your PDF inside a main tag -->
	<main>
		<div class="myDiv">

				<div id="patokan sppb_2921" align=center x:publishsource="Excel">

					<table border=0 cellpadding=0 cellspacing=0 width=1024 class=xl652921
					style='border-collapse:collapse;table-layout:fixed;width:768pt'>
					<col class=xl652921 width=64 span=16 style='width:48pt'>
					<tr height=19 style='height:14.4pt'>
					<td height=19 class=xl652921 width=64 style='height:14.4pt;width:48pt'></td>
					<td class=xl652921 width=64 style='width:48pt'></td>
					<td class=xl652921 width=64 style='width:48pt'></td>
					<td class=xl652921 width=64 style='width:48pt'></td>
					<td class=xl652921 width=64 style='width:48pt'></td>
					<td class=xl652921 width=64 style='width:48pt'></td>
					<td class=xl652921 width=64 style='width:48pt'></td>
					<td class=xl652921 width=64 style='width:48pt'></td>
					<td class=xl652921 width=64 style='width:48pt'></td>
					<td class=xl652921 width=64 style='width:48pt'></td>
					<td class=xl652921 width=64 style='width:48pt'></td>
					<td class=xl652921 width=64 style='width:48pt'></td>
					<td class=xl652921 width=64 style='width:48pt'></td>
					<td class=xl652921 width=64 style='width:48pt'></td>
					<td class=xl652921 width=64 style='width:48pt'></td>
					<td class=xl652921 width=64 style='width:48pt'></td>
					</tr>
					<tr height=19 style='mso-height-source:userset;height:14.4pt'>
					<td rowspan=2 height=45 class=xl832921 style='height:33.6pt;width:3%'>No</td>
					<td colspan=2 rowspan=2 class=xl852921 width=128 style='border-right:.5pt solid black;
					border-bottom:.5pt solid black;width:96pt'>Nama Barang/Jasa</td>
					<td colspan=2 rowspan=2 class=xl852921 width=128 style='border-right:.5pt solid black;
					border-bottom:.5pt solid black;width:96pt'>Spesifikasi</td>
					<td rowspan=2 class=xl932921 width=64 style='border-bottom:.5pt solid black;
					width:48pt'>Jumlah Yang Dibeli</td>
					<td colspan=2 class=xl742921 style='border-right:.5pt solid black;border-left:
					none;'><?php echo $NAMA_VENDOR_PERTAMA; ?></td>
					<td colspan=2 class=xl742921 width=128 style='border-right:.5pt solid black;
					border-left:none;width:96pt'><?php echo $NAMA_VENDOR_KEDUA; ?></td>
					<td colspan=2 class=xl742921 width=128 style='border-right:.5pt solid black;
					border-left:none;width:96pt'><?php echo $NAMA_VENDOR_KETIGA; ?></td>
					<td colspan=2 class=xl892921 style='border-right:.5pt solid black;border-left:
					none'>Keputusan</td>
					<td colspan=2 rowspan=2 class=xl892921 style='border-right:.5pt solid black;
					border-bottom:.5pt solid black'>Keterangan</td>
					</tr>
					<tr height=26 style='height:19.2pt'>
					<td height=26 class=xl662921 width=64 style='height:19.2pt;border-top:none;
					border-left:none;width:48pt'>Harga Satuan</td>
					<td class=xl662921 width=64 style='border-top:none;border-left:none;
					width:48pt'>Total Harga</td>
					<td class=xl662921 width=64 style='border-top:none;border-left:none;
					width:48pt'>Harga Satuan</td>
					<td class=xl662921 width=64 style='border-top:none;border-left:none;
					width:48pt'>Total Harga</td>
					<td class=xl662921 width=64 style='border-top:none;border-left:none;
					width:48pt'>Harga Satuan</td>
					<td class=xl662921 width=64 style='border-top:none;border-left:none;
					width:48pt'>Total Harga</td>
					<td colspan=2 class=xl662921 width=128 style='border-left:none;width:96pt'>Vendor</td>
					</tr>
					<tr height=19 style='height:14.4pt'>
					<td height=19 class=xl692921 style='height:14.4pt;border-top:none'>&nbsp;</td>
					<td colspan=2 class=xl802921 style='border-right:.5pt solid black;border-left:
					none'>&nbsp;</td>
					<td colspan=2 class=xl802921 style='border-right:.5pt solid black;border-left:
					none'>&nbsp;</td>
					<td class=xl692921 style='border-top:none;border-left:none'>&nbsp;</td>
					<td class=xl692921 style='border-top:none;border-left:none'>&nbsp;</td>
					<td class=xl692921 style='border-top:none;border-left:none'>&nbsp;</td>
					<td class=xl692921 style='border-top:none;border-left:none'>&nbsp;</td>
					<td class=xl692921 style='border-top:none;border-left:none'>&nbsp;</td>
					<td class=xl692921 style='border-top:none;border-left:none'>&nbsp;</td>
					<td class=xl692921 style='border-top:none;border-left:none'>&nbsp;</td>
					<td colspan=2 class=xl802921 style='border-right:.5pt solid black;border-left:
					none'>&nbsp;</td>
					<td colspan=2 class=xl802921 style='border-right:.5pt solid black;border-left:
					none'>&nbsp;</td>
					</tr>

					<?php
					$hitung = 1;
					if (!empty($this->data['konten_KHP_form'])) {
						foreach ($konten_KHP_form as $item) {
							?>
					<tr class=xl682921 height=20 style='mso-height-source:userset;height:15.0pt'>
					<td height=20 class=xl672921 width=64 style='height:15.0pt;border-top:none;
					width:48pt'><?php echo $hitung; ?></td>
					<td colspan=2 class=xl792921 width=128 style='border-right:.5pt solid black;
					border-left:none;width:96pt;padding-left:5pt'><span style='mso-spacerun:yes'><?php echo $item->NAMA_BARANG; ?></td>
					<td colspan=2 class=xl792921 width=128 style='border-right:.5pt solid black;
					border-left:none;width:96pt;padding-left:5pt'><span style='mso-spacerun:yes'></span><?php echo $item->MEREK; ?> | <?php echo $item->SPESIFIKASI_SINGKAT; ?></td>
					<td class=xl672921 width=64 style='border-top:none;border-left:none;
					width:48pt;padding-left:5pt'><?php echo$item->JUMLAH_MINTA; ?> <?php echo$item->SATUAN_BARANG; ?></td>
					<td class=xl672921 width=64 style='border-top:none;border-left:none;
					width:48pt'>Rp. <?php echo
										number_format(
											$item->HARGA_SATUAN_BARANG_VENDOR_PERTAMA,
											0,
											",",
											"."
										); ?></td>
					<td class=xl672921 width=64 style='border-top:none;border-left:none;
					width:48pt'>Rp. <?php echo
										number_format(
											$item->HARGA_TOTAL_VENDOR_PERTAMA,
											0,
											",",
											"."
										); ?></td>
					<td class=xl672921 width=64 style='border-top:none;border-left:none;
					width:48pt'>Rp. <?php echo
										number_format(
											$item->HARGA_SATUAN_BARANG_VENDOR_KEDUA,
											0,
											",",
											"."
										); ?></td>
					<td class=xl672921 width=64 style='border-top:none;border-left:none;
					width:48pt'>Rp. <?php echo
										number_format(
											$item->HARGA_TOTAL_VENDOR_KEDUA,
											0,
											",",
											"."
										); ?></td>
					<td class=xl672921 width=64 style='border-top:none;border-left:none;
					width:48pt'>Rp. <?php echo
										number_format(
											$item->HARGA_SATUAN_BARANG_VENDOR_KETIGA,
											0,
											",",
											"."
										); ?></td>
					<td class=xl672921 width=64 style='border-top:none;border-left:none;
					width:48pt'>Rp. <?php echo
										number_format(
											$item->HARGA_TOTAL_VENDOR_KETIGA,
											0,
											",",
											"."
										); ?></td>
					<td colspan=2 class=xl722921 width=128 style='border-right:.5pt solid black;
					border-left:none;width:96pt'><?php echo $item->NAMA_VENDOR_FIX;
									?></td>
					<td colspan=2 class=xl772921 width=128 style='border-right:.5pt solid black;
					border-left:none;width:96pt'><?php echo $item->KETERANGAN;
									?></td>
					</tr>
					<?php
							$hitung = $hitung + 1;
						}
					} ?>

					<tr class=xl682921 height=20 style='mso-height-source:userset;height:15.0pt'>
					<td colspan=6 height=20 class=xl842921 width=384 style='height:25.0pt;
					width:288pt;padding-left:5pt'>Delivery Condition:<span style='mso-spacerun:yes'>&nbsp;</span></td>
					<td colspan=2 class=xl842921 width=128 style='border-left:none;width:96pt;padding-left:5pt'><?php echo $DELIVERY_VENDOR_PERTAMA;?></td>
					<td colspan=2 class=xl842921 width=128 style='border-left:none;width:96pt;padding-left:5pt'><?php echo $DELIVERY_VENDOR_KEDUA;?></td>
					<td colspan=2 class=xl842921 width=128 style='border-left:none;width:96pt;padding-left:5pt'><?php echo $DELIVERY_VENDOR_KETIGA;?></td>
					<td colspan=4 rowspan=2 class=xl1002921 width=256 style='border-right:.5pt solid black;
					border-bottom:.5pt solid black;width:192pt'>&nbsp;</td>
					</tr>
					<tr class=xl682921 height=20 style='mso-height-source:userset;height:15.0pt'>
					<td colspan=6 height=20 class=xl842921 width=384 style='height:25.0pt;
					width:288pt;padding-left:5pt'>Sistem Bayar :</td>
					<td colspan=2 class=xl842921 width=128 style='border-left:none;width:96pt;padding-left:5pt'><?php echo $SISTEM_BAYAR_VENDOR_PERTAMA;?></td>
					<td colspan=2 class=xl842921 width=128 style='border-left:none;width:96pt;padding-left:5pt'><?php echo $SISTEM_BAYAR_VENDOR_KEDUA;?></td>
					<td colspan=2 class=xl842921 width=128 style='border-left:none;width:96pt;padding-left:5pt'><?php echo $SISTEM_BAYAR_VENDOR_KETIGA;?></td>
					</tr>
					<tr class=xl682921 height=20 style='mso-height-source:userset;height:15.0pt'>
					<td height=20 class=xl992921 width=64 style='height:15.0pt;border-top:none;
					width:48pt'>&nbsp;</td>
					<td class=xl992921 width=64 style='border-top:none;width:48pt'>&nbsp;</td>
					<td class=xl992921 width=64 style='border-top:none;width:48pt'>&nbsp;</td>
					<td class=xl992921 width=64 style='border-top:none;width:48pt'>&nbsp;</td>
					<td class=xl992921 width=64 style='border-top:none;width:48pt'>&nbsp;</td>
					<td class=xl992921 width=64 style='border-top:none;width:48pt'>&nbsp;</td>
					<td class=xl992921 width=64 style='border-top:none;width:48pt'>&nbsp;</td>
					<td class=xl992921 width=64 style='border-top:none;width:48pt'>&nbsp;</td>
					<td class=xl992921 width=64 style='border-top:none;width:48pt'>&nbsp;</td>
					<td class=xl992921 width=64 style='border-top:none;width:48pt'>&nbsp;</td>
					<td class=xl992921 width=64 style='border-top:none;width:48pt'>&nbsp;</td>
					<td class=xl992921 width=64 style='border-top:none;width:48pt'>&nbsp;</td>
					<td class=xl962921 width=64 style='border-top:none;width:48pt'>&nbsp;</td>
					<td class=xl962921 width=64 style='border-top:none;width:48pt'>&nbsp;</td>
					<td class=xl962921 width=64 style='border-top:none;width:48pt'>&nbsp;</td>
					<td class=xl962921 width=64 style='border-top:none;width:48pt'>&nbsp;</td>
					</tr>
					<![if supportMisalignedColumns]>
					<tr height=0 style='display:none'>
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
					<td width=64 style='width:48pt'></td>
					<td width=64 style='width:48pt'></td>
					</tr>
					<![endif]>
					</table>

				</div>

			
				<div id="patokan sppb_18252" align=center x:publishsource="Excel">

					<table border=0 cellpadding=0 cellspacing=0 width=1024 style='border-collapse:
					collapse;table-layout:fixed;width:768pt'>
					<col width=64 span=16 style='width:48pt'>
					
					<tr height=19 style='height:14.4pt'>
					<td height=19 class=xl8418252 style='height:14.4pt;border-top:none'>&nbsp;</td>
					<td class=xl8418252 style='border-top:none'>&nbsp;</td>
					<td class=xl8418252 style='border-top:none'>&nbsp;</td>
					<td class=xl8518252 width=64 style='border-top:none;width:48pt'>&nbsp;</td>
					<td class=xl8518252 width=64 style='border-top:none;width:48pt'>&nbsp;</td>
					<td class=xl8518252 width=64 style='border-top:none;width:48pt'>&nbsp;</td>
					<td class=xl6618252 width=64 style='border-top:none;width:48pt'>&nbsp;</td>
					<td class=xl6618252 width=64 style='border-top:none;width:48pt'>&nbsp;</td>
					<td class=xl6618252 width=64 style='border-top:none;width:48pt'>&nbsp;</td>
					<td class=xl8318252 width=64 style='width:48pt'></td>
					<td class=xl8318252 width=64 style='width:48pt'></td>
					<td class=xl8318252 width=64 style='width:48pt'></td>
					<td class=xl8318252 width=64 style='width:48pt'></td>
					<td class=xl8318252 width=64 style='width:48pt'></td>
					<td class=xl8318252 width=64 style='width:48pt'></td>
					<td class=xl6518252></td>
					</tr>
					<tr height=19 style='height:14.4pt'>
					<td colspan=16 height=19 class=xl8618252 style='height:14.4pt;padding-left:5pt'>Catatan KHP</td>
					</tr>
					<tr height=19 style='height:14.4pt'>
					<td colspan=16 height=19 class=xl8718252 width=1024 style='border-right:.5pt solid black;
					height:14.4pt;width:768pt;padding-left:5pt'><?php echo $KETERANGAN_KHP;?></td>
					</tr>
					<tr height=19 style='height:14.4pt'>
					<td height=19 class=xl6718252 style='height:14.4pt'></td>
					<td class=xl6718252></td>
					<td class=xl6718252></td>
					<td class=xl6718252></td>
					<td class=xl6718252></td>
					<td class=xl6718252></td>
					<td class=xl6718252></td>
					<td class=xl6718252></td>
					<td class=xl6718252></td>
					<td class=xl6718252></td>
					<td class=xl6718252></td>
					<td class=xl6518252></td>
					<td class=xl6518252></td>
					<td class=xl6518252></td>
					<td class=xl6518252></td>
					<td class=xl6718252></td>
					</tr>
					<tr height=19 style='height:14.4pt'>
					<td colspan=6 height=19 class=xl7718252 style='height:14.4pt'>Disetujui Oleh,</td>
					<td class=xl6518252></td>
					<td class=xl6518252></td>
					<td class=xl6518252></td>
					<td class=xl6518252></td>
					<td class=xl6518252></td>
					<td class=xl6518252></td>
					<td class=xl6518252></td>
					<td class=xl6518252></td>
					<td colspan=2 class=xl6918252 style='border-right:.5pt solid black'>Disiapkan
					Oleh,</td>
					</tr>
					<tr height=19 style='height:14.4pt'>
					<td colspan=2 height=19 class=xl6918252 style='border-right:.5pt solid black;
					height:14.4pt'>Departemen Keuangan</td>
					<td colspan=2 class=xl7718252 style='border-left:none'>Departemen Terkait</td>
					<td colspan=2 class=xl7718252 style='border-left:none'>Site Manager</td>
					<td class=xl6518252></td>
					<td class=xl6518252></td>
					<td class=xl6518252></td>
					<td class=xl6518252></td>
					<td class=xl6518252></td>
					<td class=xl6518252></td>
					<td class=xl6518252></td>
					<td class=xl6518252></td>
					<td colspan=2 class=xl6918252 style='border-right:.5pt solid black'>Departemen
					Pengadaan</td>
					</tr>
					<tr height=19 style='height:14.4pt'>
					<td colspan=2 rowspan=3 height=57 class=xl7118252 width=128 style='border-right:
					.5pt solid black;border-bottom:.5pt solid black;height:43.2pt;width:96pt'>&nbsp; &nbsp; &nbsp;</td>
					<td colspan=2 rowspan=3 class=xl7118252 width=128 style='border-bottom:.5pt solid black;
					width:96pt'>&nbsp; &nbsp; &nbsp;</td>
					<td colspan=2 rowspan=3 class=xl7118252 width=128 style='border-right:.5pt solid black;
					border-bottom:.5pt solid black;width:96pt'>&nbsp; &nbsp; &nbsp;</td>
					<td class=xl6518252></td>
					<td class=xl6518252></td>
					<td class=xl6518252></td>
					<td class=xl6518252></td>
					<td class=xl6518252></td>
					<td class=xl6518252></td>
					<td class=xl6518252></td>
					<td class=xl6518252></td>
					<td colspan=2 rowspan=3 class=xl7818252 width=128 style='width:96pt'>&nbsp; &nbsp; &nbsp;</td>
					</tr>
					<tr height=19 style='height:14.4pt'>
					<td height=19 class=xl6518252 style='height:14.4pt'></td>
					<td class=xl6518252></td>
					<td class=xl6518252></td>
					<td class=xl6518252></td>
					<td class=xl6518252></td>
					<td class=xl6518252></td>
					<td class=xl6818252 width=64 style='width:48pt'></td>
					<td class=xl6818252 width=64 style='width:48pt'></td>
					</tr>
					<tr height=19 style='height:14.4pt'>
					<td height=19 class=xl6518252 style='height:14.4pt'></td>
					<td class=xl6518252></td>
					<td class=xl6518252></td>
					<td class=xl6518252></td>
					<td class=xl6518252></td>
					<td class=xl6518252></td>
					<td class=xl6518252></td>
					<td class=xl6518252></td>
					</tr>
					<![if supportMisalignedColumns]>
					<tr height=0 style='display:none'>
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
					<td width=64 style='width:48pt'></td>
					<td width=64 style='width:48pt'></td>
					</tr>
					<![endif]>
					</table>

				</div>
			
		</div>
	</main>
</body>