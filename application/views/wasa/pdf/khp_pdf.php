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
			margin-top: 3.09cm;
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

	<style id="Patokan KHP PDF_23685_Styles">
		<!--table
			{mso-displayed-decimal-separator:"\.";
			mso-displayed-thousand-separator:"\,";}
		.xl6323685
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
		.xl6423685
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
		.xl6523685
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
		.xl6623685
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
		.xl6723685
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
		.xl6823685
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
		.xl6923685
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
		.xl7023685
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
		.xl7123685
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
		.xl7223685
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
		.xl7323685
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
		.xl7423685
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
		.xl7523685
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
		.xl7623685
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
		.xl7723685
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
		.xl7823685
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
		.xl7923685
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
		.xl8023685
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
		.xl8123685
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
		.xl8223685
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
		-->
	</style>

	<style id="Patokan KHP PDF_17499_Styles">
		<!--table
			{mso-displayed-decimal-separator:"\.";
			mso-displayed-thousand-separator:"\,";}
		.xl6317499
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
		.xl6417499
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
		.xl6517499
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
		.xl6617499
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
		.xl6717499
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
			text-align:general;
			vertical-align:bottom;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl6817499
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
		.xl6917499
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
		.xl7017499
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
		.xl7117499
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
		.xl7217499
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
		.xl7317499
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
		.xl7417499
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
		.xl7517499
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
		.xl7617499
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
		.xl7717499
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
		.xl7817499
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
		.xl7917499
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
		.xl8017499
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
		.xl8117499
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
		.xl8217499
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
		.xl8317499
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
		.xl8417499
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
		.xl8517499
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
		.xl8617499
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
		.xl8717499
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
		.xl8817499
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
		.xl8917499
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
		.xl9017499
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
		.xl9117499
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
		.xl9217499
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
			text-align:right;
			vertical-align:middle;
			border:.5pt solid windowtext;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl9317499
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
			white-space:nowrap;}
		-->
	</style>

	<style id="Patokan KHP PDF_12960_Styles">
		<!--table
			{mso-displayed-decimal-separator:"\.";
			mso-displayed-thousand-separator:"\,";}
		.xl6312960
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
		.xl6412960
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
		.xl6512960
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
		.xl6612960
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
		.xl6712960
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
		.xl6812960
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
		.xl6912960
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
		.xl7012960
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
		.xl7112960
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
		.xl7212960
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
		.xl7312960
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
		.xl7412960
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
		.xl7512960
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
		.xl7612960
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
		.xl7712960
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
		.xl7812960
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
		-->
	</style>

<body>
	<!-- Define header and footer blocks before your content -->
	<header>

		<div id="Patokan KHP PDF_23685" align=center x:publishsource="Excel">

			<table border=0 cellpadding=0 cellspacing=0 width=1039 class=xl6623685
			style='border-collapse:collapse;table-layout:fixed;width:779pt'>
			<col class=xl6623685 width=64 span=15 style='width:48pt'>
			<col class=xl6623685 width=79 style='mso-width-source:userset;mso-width-alt:
			2816;width:59pt'>
			<tr height=13 style='mso-height-source:userset;height:10.05pt'>
			<td rowspan=3 height=39 class=xl7823685 width=64 style='height:30.15pt;
			width:48pt'><img src="assets/logo_wasa.png" alt="" width=50 height=50></td>
			<td colspan=12 rowspan=2 class=xl7923685 width=768 style='width:576pt'>KOMPARASI
			HARGA PEMASOK</td>
			<td class=xl6323685 width=64 style='border-left:none;width:48pt'><span
			style='mso-spacerun:yes'>&nbsp;</span>Form No.</td>
			<td class=xl6423685 colspan=2 width=143 style='border-right:.5pt solid black;
			width:107pt'>: WME/FKPH/02</td>
			</tr>
			<tr height=13 style='mso-height-source:userset;height:10.05pt'>
			<td height=13 class=xl6723685 style='height:10.05pt;border-left:none'><span
			style='mso-spacerun:yes'>&nbsp;</span>SOP No.</td>
			<td class=xl6823685 colspan=2 style='border-right:.5pt solid black'>:
			WME/SOP/FHS-PL/01</td>
			</tr>
			<tr height=13 style='mso-height-source:userset;height:10.05pt'>
			<td height=13 class=xl7023685 style='height:10.05pt;border-top:none;
			border-left:none'><span style='mso-spacerun:yes'>&nbsp;</span>No. Urut KHP</td>
			<td colspan=8 class=xl8023685 width=512 style='width:384pt'>: <?php  echo
			$NO_URUT_KHP; ?></td>
			<td class=xl7123685 width=64 style='border-top:none;width:48pt'>Tanggal:</td>
			<td colspan=2 class=xl8023685 width=128 style='border-right:.5pt solid black;
			width:96pt'>: <?php  echo $TANGGAL_PEMBUATAN_KHP_HARI; ?></td>
			<td class=xl7223685 style='border-left:none'><span
			style='mso-spacerun:yes'>&nbsp;</span>Dept.</td>
			<td class=xl7323685 colspan=2 style='border-right:.5pt solid black'>:
			Procurement &amp; Logistic</td>
			</tr>
			<tr height=13 style='mso-height-source:userset;height:10.05pt'>
			<td height=13 class=xl7523685 style='height:10.05pt;border-top:none'><span
			style='mso-spacerun:yes'>&nbsp;</span>Proyek</td>
			<td colspan=8 class=xl8123685 width=512 style='width:384pt'>: <?php  echo
			$NAMA_PROYEK_PDF; ?> - <?php  echo $SUB_PROYEK_PDF; ?></td>
			<td colspan=7 class=xl8223685 width=463 style='border-right:.5pt solid black;
			width:347pt'>&nbsp;</td>
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

				<div id="Patokan KHP PDF_17499" align=center x:publishsource="Excel">

					<table border=0 cellpadding=0 cellspacing=0 width=1039 class=xl6317499
					style='border-collapse:collapse;table-layout:fixed;width:779pt'>
					<col class=xl6317499 width=64 span=15 style='width:48pt'>
					<col class=xl6317499 width=79 style='mso-width-source:userset;mso-width-alt:
					2816;width:59pt'>
					<tr height=13 style='mso-height-source:userset;height:10.05pt'>
						<td rowspan=2 height=26 class=xl6817499 width=64 style='height:20.1pt;
						width:3%'>No</td>
						<td colspan=2 rowspan=2 class=xl8617499 width=128 style='border-right:.5pt solid black;
						border-bottom:.5pt solid black;width:96pt'>Nama Barang/Jasa</td>
						<td colspan=2 rowspan=2 class=xl8617499 width=128 style='border-right:.5pt solid black;
						border-bottom:.5pt solid black;width:96pt'>Spesifikasi</td>
						<td rowspan=2 class=xl9017499 width=64 style='border-bottom:.5pt solid black;
						width:48pt'>Jumlah Yang Dibeli</td>
						<td colspan=2 class=xl8017499 width=128 style='border-right:.5pt solid black;
						border-left:none;width:96pt'><?php echo $NAMA_VENDOR_PERTAMA; ?></td>
						<td colspan=2 class=xl8017499 width=128 style='border-right:.5pt solid black;
						border-left:none;width:96pt'><?php echo $NAMA_VENDOR_KEDUA; ?></td>
						<td colspan=2 class=xl8017499 width=128 style='border-right:.5pt solid black;
						border-left:none;width:96pt'><?php echo $NAMA_VENDOR_KETIGA; ?></td>
						<td colspan=2 class=xl8217499 width=128 style='border-right:.5pt solid black;
						border-left:none;width:96pt'>Keputusan</td>
						<td colspan=2 rowspan=2 class=xl8217499 width=143 style='border-right:.5pt solid black;
						border-bottom:.5pt solid black;width:107pt'>Keterangan</td>
					</tr>
					<tr height=13 style='mso-height-source:userset;height:10.05pt'>
					<td height=13 class=xl6417499 width=64 style='height:10.05pt;border-top:none;
					border-left:none;width:48pt'>Harga Satuan</td>
					<td class=xl6417499 width=64 style='border-top:none;border-left:none;
					width:48pt'>Total Harga</td>
					<td class=xl6417499 width=64 style='border-top:none;border-left:none;
					width:48pt'>Harga Satuan</td>
					<td class=xl6417499 width=64 style='border-top:none;border-left:none;
					width:48pt'>Total Harga</td>
					<td class=xl6417499 width=64 style='border-top:none;border-left:none;
					width:48pt'>Harga Satuan</td>
					<td class=xl6417499 width=64 style='border-top:none;border-left:none;
					width:48pt'>Total Harga</td>
					<td colspan=2 class=xl6417499 width=128 style='border-left:none;width:96pt'>Vendor</td>
					</tr>

					<?php
					$hitung = 1;
					if (!empty($this->data['konten_KHP_form'])) {
					foreach ($konten_KHP_form as $item) {
					?>

					<tr class=xl6617499 height=13 style='mso-height-source:userset;height:10.05pt'>
						<td height=13 class=xl6517499 width=64 style='height:10.05pt;border-top:.5pt solid black;
						width:48pt'><?php echo $hitung; ?></td>
						<td colspan=2 class=xl7017499 width=128 style='border-right:.5pt solid black;
						border-left:none;width:96pt;padding-left:5pt;border-top:.5pt solid black'><?php echo $item->NAMA_BARANG; ?></td>
						<td colspan=2 class=xl7017499 width=128 style='border-right:.5pt solid black;
						border-left:none;width:96pt;padding-left:5pt;border-top:.5pt solid black'><?php echo $item->MEREK; ?> | <?php echo
						$item->SPESIFIKASI_SINGKAT; ?></td>
						<td class=xl6517499 width=64 style='border-top:.5pt solid black;border-left:none;
						width:48pt'><?php echo$item->JUMLAH_MINTA; ?> <?php
						echo$item->SATUAN_BARANG; ?></td>
						<td class=xl9217499 width=64 style='border-top:.5pt solid black;border-left:none;
						width:48pt;padding-right:2pt'>Rp. <?php
						echo number_format($item->HARGA_SATUAN_BARANG_VENDOR_PERTAMA,0,",",".");
						?></td>
						<td class=xl9217499 width=64 style='border-top:.5pt solid black;border-left:none;
						width:48pt;padding-right:2pt'>Rp. <?php echo number_format(
						$item->HARGA_TOTAL_VENDOR_PERTAMA,0,",","."); ?></td>
						<td class=xl9217499 width=64 style='border-top:.5pt solid black;border-left:none;
						width:48pt;padding-right:2pt'>Rp. <?php
						echo number_format($item->HARGA_SATUAN_BARANG_VENDOR_KEDUA,0,",",".");
						?></td>
						<td class=xl9217499 width=64 style='border-top:.5pt solid black;border-left:none;
						width:48pt;padding-right:2pt'>Rp. <?php echo number_format(
						$item->HARGA_TOTAL_VENDOR_KEDUA,0,",","."); ?></td>
						<td class=xl9217499 width=64 style='border-top:.5pt solid black;border-left:none;
						width:48pt;padding-right:2pt'>Rp. <?php
						echo number_format($item->HARGA_SATUAN_BARANG_VENDOR_KETIGA,0,",",".");
						?></td>
						<td class=xl9217499 width=64 style='border-top:.5pt solid black;border-left:none;
						width:48pt;padding-right:2pt'>Rp. <?php echo number_format(
						$item->HARGA_TOTAL_VENDOR_KETIGA,0,",","."); ?></td>
						<td colspan=2 class=xl7217499 width=128 style='border-right:.5pt solid black;
						border-left:none;width:96pt';border-top:.5pt solid black><?php echo $item->NAMA_VENDOR_FIX;?></td>
						<td colspan=2 class=xl7217499 width=143 style='border-right:.5pt solid black;
						border-left:none;width:107pt';border-top:.5pt solid black><?php echo $item->KETERANGAN;?></td>
					</tr>

					<?php
					$hitung = $hitung + 1;
					}
					} ?>

					<tr class=xl6617499 height=13 style='mso-height-source:userset;height:10.05pt'>
						<td colspan=6 height=13 class=xl6917499 width=384 style='height:10.05pt;
						width:288pt;padding-left:5pt'>Delivery Condition:<span style='mso-spacerun:yes'>�</span></td>
						<td colspan=2 class=xl6917499 width=128 style='border-left:none;width:96pt;padding-left:5pt'><?php
						echo $DELIVERY_VENDOR_PERTAMA;?></td>
						<td colspan=2 class=xl6917499 width=128 style='border-left:none;width:96pt;padding-left:5pt'><?php
						echo $DELIVERY_VENDOR_KEDUA;?></td>
						<td colspan=2 class=xl6917499 width=128 style='border-left:none;width:96pt;padding-left:5pt'><?php
						echo $DELIVERY_VENDOR_KETIGA;?></td>
						<td colspan=4 rowspan=2 class=xl7417499 width=271 style='border-right:.5pt solid black;
						border-bottom:.5pt solid black;width:203pt'>&nbsp;</td>
					</tr>
					<tr class=xl6617499 height=13 style='mso-height-source:userset;height:10.05pt'>
						<td colspan=6 height=13 class=xl6917499 width=384 style='height:10.05pt;
						width:288pt;padding-left:5pt'>Sistem Bayar:</td>
						<td colspan=2 class=xl6917499 width=128 style='border-left:none;width:96pt;padding-left:5pt'><?php
						echo $SISTEM_BAYAR_VENDOR_PERTAMA;?></td>
						<td colspan=2 class=xl6917499 width=128 style='border-left:none;width:96pt;padding-left:5pt'><?php
						echo $SISTEM_BAYAR_VENDOR_KEDUA;?></td>
						<td colspan=2 class=xl6917499 width=128 style='border-left:none;width:96pt;padding-left:5pt'><?php
						echo $SISTEM_BAYAR_VENDOR_KETIGA;?></td>
					</tr>
					<tr height=13 style='mso-height-source:userset;height:10.05pt'>
						<td height=13 class=xl6717499 style='height:10.05pt'></td>
						<td colspan=15 class=xl9317499><b>Catatan KHP</b>: <?php echo $KETERANGAN_KHP;?></td>
					</tr>
					</table>
				</div>

			
				<div id="Patokan KHP PDF_12960" align=center x:publishsource="Excel">
					<table border=0 cellpadding=0 cellspacing=0 width=1039 class=xl6312960
					style='border-collapse:collapse;table-layout:fixed;width:779pt;page-break-inside: avoid'>
					<col class=xl6312960 width=64 span=15 style='width:48pt'>
					<col class=xl6312960 width=79 style='mso-width-source:userset;mso-width-alt:
					2816;width:59pt'>
					<tr height=13 style='mso-height-source:userset;height:10.05pt'>
					<td height=13 class=xl6412960 width=64 style='height:10.05pt;width:48pt'></td>
					<td class=xl6412960 width=64 style='width:48pt'></td>
					<td class=xl6412960 width=64 style='width:48pt'></td>
					<td class=xl6412960 width=64 style='width:48pt'></td>
					<td class=xl6412960 width=64 style='width:48pt'></td>
					<td class=xl6412960 width=64 style='width:48pt'></td>
					<td class=xl6412960 width=64 style='width:48pt'></td>
					<td class=xl6412960 width=64 style='width:48pt'></td>
					<td class=xl6412960 width=64 style='width:48pt'></td>
					<td class=xl6412960 width=64 style='width:48pt'></td>
					<td class=xl6412960 width=64 style='width:48pt'></td>
					<td class=xl6412960 width=64 style='width:48pt'></td>
					<td class=xl6412960 width=64 style='width:48pt'></td>
					<td class=xl6412960 width=64 style='width:48pt'></td>
					<td class=xl6412960 width=64 style='width:48pt'></td>
					<td class=xl6412960 width=79 style='width:59pt'></td>
					</tr>
					<tr height=13 style='mso-height-source:userset;height:10.05pt'>
					<td colspan=6 height=13 class=xl6812960 style='height:10.05pt'>Disetujui
					Oleh,</td>
					<td class=xl6312960></td>
					<td class=xl6312960></td>
					<td class=xl6312960></td>
					<td class=xl6312960></td>
					<td class=xl6312960></td>
					<td class=xl6312960></td>
					<td class=xl6312960></td>
					<td class=xl6312960></td>
					<td colspan=2 class=xl6612960 style='border-right:.5pt solid black'>Disiapkan
					Oleh,</td>
					</tr>
					<tr height=13 style='mso-height-source:userset;height:10.05pt'>
					<td colspan=2 height=13 class=xl6612960 style='border-right:.5pt solid black;
					height:10.05pt'>Departemen Keuangan</td>
					<td colspan=2 class=xl6812960 style='border-left:none'>Departemen Terkait</td>
					<td colspan=2 class=xl6812960 style='border-left:none'>Site Manager</td>
					<td class=xl6312960></td>
					<td class=xl6312960></td>
					<td class=xl6312960></td>
					<td class=xl6312960></td>
					<td class=xl6312960></td>
					<td class=xl6312960></td>
					<td class=xl6312960></td>
					<td class=xl6312960></td>
					<td colspan=2 class=xl6612960 style='border-right:.5pt solid black'>Departemen
					Pengadaan</td>
					</tr>
					<tr height=13 style='mso-height-source:userset;height:10.05pt'>
					<td colspan=2 rowspan=6 height=78 class=xl6912960 width=128 style='border-right:
					.5pt solid black;border-bottom:.5pt solid black;height:60.3pt;width:96pt'>&nbsp;</td>
					<td colspan=2 rowspan=6 class=xl6912960 width=128 style='border-bottom:.5pt solid black;
					width:96pt'>&nbsp;</td>
					<td colspan=2 rowspan=6 class=xl6912960 width=128 style='border-right:.5pt solid black;
					border-bottom:.5pt solid black;width:96pt'>&nbsp;</td>
					<td class=xl6312960></td>
					<td class=xl6312960></td>
					<td class=xl6312960></td>
					<td class=xl6312960></td>
					<td class=xl6312960></td>
					<td class=xl6312960></td>
					<td class=xl6312960></td>
					<td class=xl6312960></td>
					<td colspan=2 rowspan=6 class=xl7812960 width=143 style='width:107pt'>&nbsp;</td>
					</tr>
					<tr height=13 style='mso-height-source:userset;height:10.05pt'>
					<td height=13 class=xl6312960 style='height:10.05pt'></td>
					<td class=xl6312960></td>
					<td class=xl6312960></td>
					<td class=xl6312960></td>
					<td class=xl6312960></td>
					<td class=xl6312960></td>
					<td class=xl6312960></td>
					<td class=xl6312960></td>
					</tr>
					<tr height=13 style='mso-height-source:userset;height:10.05pt'>
					<td height=13 class=xl6312960 style='height:10.05pt'></td>
					<td class=xl6312960></td>
					<td class=xl6312960></td>
					<td class=xl6312960></td>
					<td class=xl6312960></td>
					<td class=xl6312960></td>
					<td class=xl6312960></td>
					<td class=xl6312960></td>
					</tr>
					<tr height=13 style='mso-height-source:userset;height:10.05pt'>
					<td height=13 class=xl6312960 style='height:10.05pt'></td>
					<td class=xl6312960></td>
					<td class=xl6312960></td>
					<td class=xl6312960></td>
					<td class=xl6312960></td>
					<td class=xl6312960></td>
					<td class=xl6312960></td>
					<td class=xl6312960></td>
					</tr>
					<tr height=13 style='mso-height-source:userset;height:10.05pt'>
					<td height=13 class=xl6312960 style='height:10.05pt'></td>
					<td class=xl6312960></td>
					<td class=xl6312960></td>
					<td class=xl6312960></td>
					<td class=xl6312960></td>
					<td class=xl6312960></td>
					<td class=xl6512960 width=64 style='width:48pt'></td>
					<td class=xl6512960 width=64 style='width:48pt'></td>
					</tr>
					<tr height=13 style='mso-height-source:userset;height:10.05pt'>
					<td height=13 class=xl6312960 style='height:10.05pt'></td>
					<td class=xl6312960></td>
					<td class=xl6312960></td>
					<td class=xl6312960></td>
					<td class=xl6312960></td>
					<td class=xl6312960></td>
					<td class=xl6312960></td>
					<td class=xl6312960></td>
					</tr>
					</table>
				</div>
			
		</div>
	</main>
</body>