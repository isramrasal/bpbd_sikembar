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
			margin-top: 3.50cm;
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
	
	<style id="Patokan SPPB PDF_15004_Styles">
		<!--table
			{mso-displayed-decimal-separator:"\.";
			mso-displayed-thousand-separator:"\,";}
		.xl6315004
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
		.xl6415004
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
		.xl6515004
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
		.xl6615004
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
		.xl6715004
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
		.xl6815004
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
		.xl6915004
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
			border-top:.5pt solid windowtext;
			border-right:.5pt solid windowtext;
			border-bottom:none;
			border-left:.5pt solid windowtext;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl7015004
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
			border-right:.5pt solid windowtext;
			border-bottom:none;
			border-left:.5pt solid windowtext;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl7115004
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
			border-right:.5pt solid windowtext;
			border-bottom:.5pt solid windowtext;
			border-left:.5pt solid windowtext;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl7215004
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
			border-top:.5pt solid windowtext;
			border-right:none;
			border-bottom:none;
			border-left:.5pt solid windowtext;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl7315004
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
			border-top:.5pt solid windowtext;
			border-right:none;
			border-bottom:none;
			border-left:none;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl7415004
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
			border-top:none;
			border-right:none;
			border-bottom:.5pt solid windowtext;
			border-left:.5pt solid windowtext;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl7515004
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
			border-top:none;
			border-right:none;
			border-bottom:.5pt solid windowtext;
			border-left:none;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl7615004
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
			white-space:nowrap;}
		.xl7715004
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
			border-bottom:none;
			border-left:none;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl7815004
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
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl7915004
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
			border-right:.5pt solid windowtext;
			border-bottom:none;
			border-left:none;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl8015004
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
		.xl8115004
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
		.xl8215004
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
			border-left:none;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl8315004
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
			border-right:.5pt solid windowtext;
			border-bottom:.5pt solid windowtext;
			border-left:none;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl8415004
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
		.xl8515004
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
		.xl8615004
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
			border-top:.5pt solid windowtext;
			border-right:none;
			border-bottom:.5pt solid windowtext;
			border-left:.5pt solid windowtext;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl8715004
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
			border-top:.5pt solid windowtext;
			border-right:none;
			border-bottom:.5pt solid windowtext;
			border-left:none;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl8815004
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
			border-top:.5pt solid windowtext;
			border-right:.5pt solid windowtext;
			border-bottom:.5pt solid windowtext;
			border-left:none;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl8915004
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
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		-->
	</style>

	<style id="Patokan SPPB PDF_5417_Styles">
		<!--table
			{mso-displayed-decimal-separator:"\.";
			mso-displayed-thousand-separator:"\,";}
		.xl635417
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
		.xl645417
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
		.xl655417
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
			white-space:nowrap;}
		.xl665417
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
		.xl665417_L
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
		.xl675417
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
			mso-number-format:"Short Date";
			text-align:center;
			vertical-align:middle;
			border:.5pt solid windowtext;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl685417
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
			white-space:nowrap;}
		.xl695417
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
		.xl705417
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
			white-space:nowrap;}
		.xl715417
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
		-->
	</style>

	<style id="Patokan SPPB PDF_15936_Styles">
		<!--table
			{mso-displayed-decimal-separator:"\.";
			mso-displayed-thousand-separator:"\,";}
		.xl6315936
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
		.xl6415936
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
			vertical-align:middle;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl6515936
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
			border-left:none;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		-->
	</style>

	<style id="Patokan SPPB PDF_4987_Styles">
		<!--table
			{mso-displayed-decimal-separator:"\.";
			mso-displayed-thousand-separator:"\,";}
		.xl654987
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
		.xl664987
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
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl674987
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
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl684987
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
			vertical-align:top;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		-->
	</style>

	<style id="patokan sppb_31313_Styles">
		<!--table
			{mso-displayed-decimal-separator:"\.";
			mso-displayed-thousand-separator:"\,";}
		.xl6531313
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
		.xl6631313
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
		.xl6731313
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
			vertical-align:top;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		-->
	</style>


</head>

<body>
	<!-- Define header and footer blocks before your content -->
	<header>
		<div id="Patokan SPPB PDF_15004" align=center x:publishsource="Excel">
			<table border=0 cellpadding=0 cellspacing=0 width=1039 class=xl6415004 style='border-collapse:collapse;table-layout:fixed;width:779pt'>
				<col class=xl6415004 width=64 span=15 style='width:48pt'>
				<col class=xl6415004 width=79 style='mso-width-source:userset;mso-width-alt:
				2816;width:59pt'>
				<tr height=13 style='mso-height-source:userset;height:10.05pt'>
					<td rowspan=3 height=39 class=xl6915004 width=64 style='border-bottom:.5pt solid black; height:30.15pt;width:48pt'><img src="assets/logo_wasa.png" alt="" width=40 height=40></td>
					<td colspan=12 rowspan=2 class=xl7215004 width=768 style='border-bottom:.5pt solid black; width:576pt'>SURAT PERMOHONAN PENGADAAN BARANG (PEMBELIAN)</td>
					<td class=xl6315004 width=64 style='width:48pt'><span style='mso-spacerun:yes'></span>&nbsp;Form No.</td>
					<td colspan=2 class=xl7615004 width=143 style='border-right:.5pt solid black; width:107pt'>: WME/FSPPB/01</td>
				</tr>
				<tr height=13 style='mso-height-source:userset;height:10.05pt'>
				<td height=13 class=xl6515004 style='height:10.05pt'><span
				style='mso-spacerun:yes'></span>&nbsp;SOP No.</td>
				<td colspan=2 class=xl7815004 style='border-right:.5pt solid black'>:
				WME/SOP/FHS-PL/01</td>
				</tr>
				<tr height=13 style='mso-height-source:userset;height:10.05pt'>
				<td height=13 class=xl6615004 style='height:10.05pt;border-top:none;
				border-left:none'><span style='mso-spacerun:yes'></span>&nbsp;No. Urut SPPB</td>
				<td colspan=8 class=xl8015004 width=512 style='border-right:.5pt solid black;
				width:384pt'>: <?php echo $NO_URUT_SPPB; ?></td>
				<td class=xl6615004 style='border-top:none;border-left:none'><span
				style='mso-spacerun:yes'></span>&nbsp;Tanggal</td>
				<td colspan=2 class=xl8015004 width=128 style='width:96pt'>: <?php echo $TANGGAL_DOKUMEN_SPPB_INDO; ?></td>
				<td class=xl6715004><span style='mso-spacerun:yes'></span>&nbsp;Dept.</td>
				<td colspan=2 class=xl8215004 style='border-right:.5pt solid black'>:
				Procurement &amp; Logistic</td>
				</tr>
				<tr height=13 style='mso-height-source:userset;height:10.05pt'>
				<td colspan=16 height=13 class=xl8615004 style='border-right:.5pt solid black;
				height:10.05pt'>&nbsp;</td>
				</tr>
				<tr height=13 style='mso-height-source:userset;height:10.05pt'>
				<td height=13 class=xl6815004 style='height:10.05pt;border-top:none'><span
				style='mso-spacerun:yes'></span>&nbsp;Proyek</td>
				<td colspan=15 class=xl8415004 width=975 style='border-right:.5pt solid black;
				width:731pt'>: <?php echo $NAMA_PROYEK_PDF; ?> - <?php echo $SUB_PROYEK; ?></td>
				</tr>
				<tr class=xl6415004 height=13 style='mso-height-source:userset;height:10.05pt'>
				<td colspan=16 height=13 class=xl8915004 style='height:10.05pt'>Bersama ini
				kami mengajukan permintaan barang seperti tersebut di bawah ini:</td>
				</tr>

			</table>

		</div>
	</header>

	<footer>
		<div id="Patokan SPPB PDF_4987" align=center x:publishsource="Excel">

			<table border=0 cellpadding=0 cellspacing=0 width=1039 class=xl654987
			style='border-collapse:collapse;table-layout:fixed;width:779pt'>
				<col class=xl654987 width=64 span=15 style='width:48pt'>
				<col class=xl654987 width=79 style='mso-width-source:userset;mso-width-alt:
				2816;width:59pt'>
				<tr height=13 style='mso-height-source:userset;height:10.05pt'>
				<td rowspan=5 height=65 class=xl684987 width=64 style='height:50.25pt;
				width:48pt'><img style="width: 80px;" src="<?php echo $GAMBAR_QR_2; ?>"></td>
				<td class=xl664987 width=64 style='width:48pt'>&nbsp;&nbsp;&nbsp;Lembar 1</td>
				<td colspan=14 class=xl674987 width=911 style='width:683pt'>: Departemen
				Terkait</td>
				</tr>
				<tr height=13 style='mso-height-source:userset;height:10.05pt'>
				<td height=13 class=xl664987 style='height:10.05pt'>&nbsp;&nbsp;&nbsp;Lembar 2</td>
				<td colspan=14 class=xl674987 width=911 style='width:683pt'>: Arsip</td>
				</tr>
				<tr height=13 style='mso-height-source:userset;height:10.05pt'>
				<td height=13 class=xl664987 style='height:10.05pt'></td>
				<td colspan=14 class=xl674987 width=911 style='width:683pt'></td>
				</tr>
				<tr height=13 style='mso-height-source:userset;height:10.05pt'>
				<td height=13 class=xl664987 style='height:10.05pt'></td>
				<td colspan=14 class=xl674987 width=911 style='width:683pt'></td>
				</tr>
				<tr height=13 style='mso-height-source:userset;height:10.05pt'>
				<td height=13 class=xl664987 style='height:10.05pt'></td>
				<td colspan=14 class=xl674987 width=911 style='width:683pt'></td>
				</tr>
			
			</table>

			</div>

	</footer>

	<!-- Wrap the content of your PDF inside a main tag -->
	<main>
		<div class="myDiv">

			<div id="Patokan SPPB PDF_5417" align=center x:publishsource="Excel">
				<table border=0 cellpadding=0 cellspacing=0 width=1039 class=xl635417 style='border-collapse:collapse;table-layout:fixed;width:779pt'>
				<col class=xl635417 width=64 span=15 style='width:48pt'>
				<col class=xl635417 width=79 style='mso-width-source:userset;mso-width-alt:2816;width:59pt'>
				<tr height=13 style='mso-height-source:userset;height:10.05pt'>
					<td rowspan=2 height=26 class=xl645417 width=64 style='height:20.1pt;width:3%'>No</td>
					<td colspan=4 rowspan=2 class=xl645417 width=256 style='width:192pt'>Nama Barang/Jasa</td>
					<td colspan=4 rowspan=2 class=xl645417 width=256 style='width:192pt'>Spesifikasi</td>
					<td colspan=2 rowspan=2 class=xl645417 width=128 style='width:96pt'>Qty Diajukan SPP</td>
					<td colspan=2 class=xl645417 width=128 style='border-left:none;width:96pt'>Periode Pemakaian</td>
					<td colspan=3 rowspan=2 class=xl645417 width=207 style='width:155pt'>Keterangan</td>
				</tr>
				<tr height=13 style='mso-height-source:userset;height:10.05pt'>
				<td height=13 class=xl645417 style='height:10.05pt;border-top:none;
				border-left:none'>Mulai</td>
				<td class=xl645417 style='border-top:none;border-left:none'>Sampai</td>
				</tr>

				<?php
				$hitung = 1;
				
				if (!empty($this->data['konten_rab_sppb_form'])) {
						$panjang = count($konten_rab_sppb_form);
						for ($i = 0; $i < $panjang; $i++) {
					?>

					/* ROW KATEGORI */
					<tr height=13 style='mso-height-source:userset;height:10.05pt'>
						<td colspan=16 height=13 class=xl655417 style='height:10.05pt;border-top:.5pt solid black;'><b>&nbsp; <?php echo $konten_rab_sppb_form[$i]["NAMA_KATEGORI"] ?></b></td>
					</tr>

					<?php
					$panjang_j = count($konten_rab_sppb_form[$i]["konten_SPPB_form"]);
					for ($j = 0; $j < $panjang_j; $j++) {
						if ($konten_rab_sppb_form[$i]["konten_SPPB_form"][$j]->COMPLETE == "TERPENUHI")
						{
							$tanda_coret_buka = "<s>";
							$tanda_coret_tutup = "</s>";
						}
						else
						{
							$tanda_coret_buka = "";
							$tanda_coret_tutup = "";
						}
					?>
					
					/* ROW ITEM BARANG */
					<tr height=13 style='mso-height-source:userset;height:10.05pt'>
						
						<td height=13 class=xl665417 width=64 style='height:10.05pt;border-top:.5pt;width:48pt'><?php echo $tanda_coret_buka; ?> <?php echo $hitung; ?> <?php echo $tanda_coret_tutup; ?> </td>

						<td colspan=4 class=xl665417_L width=256 style='border-left:.5pt;width:192pt;border-top:.5pt;padding-left: 5px;'><span style='mso-spacerun:yes'><?php echo $tanda_coret_buka; ?>
							<?php echo $konten_rab_sppb_form[$i]["konten_SPPB_form"][$j]->NAMA_BARANG; ?> <?php echo $tanda_coret_tutup; ?></td>

						<td colspan=4 class=xl665417 width=256 style='border-left:.5pt;width:192pt;border-top:.5pt;padding-left: 5px'><span style='mso-spacerun:yes'>&nbsp;<?php echo $tanda_coret_buka; ?>
							<?php echo $konten_rab_sppb_form[$i]["konten_SPPB_form"][$j]->SPESIFIKASI_SINGKAT; ?> <?php echo $tanda_coret_tutup; ?></td>
						
						<td class=xl665417 width=64 style='border-top:.5pt;border-left:.5pt;width:48pt'>
							<?php echo $tanda_coret_buka; ?> <?php echo $konten_rab_sppb_form[$i]["konten_SPPB_form"][$j]->JUMLAH_QTY_SPP; ?> <?php echo $tanda_coret_tutup; ?></td>
						
						<td class=xl675417 width=64 style='border-top:.5pt;border-left:.5pt;width:48pt'>
							<?php echo $tanda_coret_buka; ?> <?php echo $konten_rab_sppb_form[$i]["konten_SPPB_form"][$j]->SATUAN_BARANG; ?> <?php echo $tanda_coret_tutup; ?></td>
			
						<td class=xl665417 width=64 style='border-top:.5pt;border-left:.5pt;width:48pt'>
						<?php echo $tanda_coret_buka; ?> <?php $TANGGAL_MULAI_PAKAI_HARI_INDO = tanggal_indo_singkat($konten_rab_sppb_form[$i]["konten_SPPB_form"][$j]->TANGGAL_MULAI_PAKAI_HARI_INDO, false); echo $TANGGAL_MULAI_PAKAI_HARI_INDO;?> <?php echo $tanda_coret_tutup; ?></td>

						<td class=xl665417 width=64 style='border-top:.5pt;border-left:.5pt;width:48pt'>
						<?php echo $tanda_coret_buka; ?> <?php $TANGGAL_SELESAI_PAKAI_HARI_INDO = tanggal_indo_singkat($konten_rab_sppb_form[$i]["konten_SPPB_form"][$j]->TANGGAL_SELESAI_PAKAI_HARI_INDO, false); echo  $TANGGAL_SELESAI_PAKAI_HARI_INDO;?> <?php echo $tanda_coret_tutup; ?></td>

						<td colspan=3 class=xl685417 style='border-left:.5pt'><?php echo $tanda_coret_buka; ?> <?php echo $konten_rab_sppb_form[$i]["konten_SPPB_form"][$j]->KETERANGAN_UMUM; ?> <?php echo $tanda_coret_tutup; ?></td>

					</tr>

				<?php
						$hitung = $hitung + 1;
						} 
					}
				} 
				?>

				</table>
			</div>

			<div id="Patokan SPPB PDF_15936" align=center x:publishsource="Excel">

				<table border=0 cellpadding=0 cellspacing=0 width=1039 class=xl6315936
				style='border-collapse:collapse;table-layout:fixed;width:779pt'>
					<col class=xl6315936 width=64 span=15 style='width:48pt'>
					<col class=xl6315936 width=79 style='mso-width-source:userset;mso-width-alt:
					2816;width:59pt'>
					<tr height=13 style='mso-height-source:userset;height:10.05pt'>
					<td height=13 class=xl6415936 width=64 style='height:10.05pt;width:48pt'>Catatan
					SPPB</td>
					<td colspan=15 class=xl6515936 width=975 style='width:731pt'>: <?php echo $CTT_DEPT_PROC; ?></td>
					</tr>
				</table>

			</div>
		</div>
	</main>

	<?php
	function tanggal_indo_singkat($tanggal, $cetak_hari = false)
	{
		if($tanggal == '0000-00-00')
		{
			$tgl_indo = "-";
			return $tgl_indo;
		}

		else
		{
			$hari = array ( 1 =>    'Senin',
						'Selasa',
						'Rabu',
						'Kamis',
						'Jumat',
						'Sabtu',
						'Minggu'
					);
					
			$bulan = array (1 =>   'Jan',
						'Feb',
						'Mar',
						'Apr',
						'Mei',
						'Jun',
						'Jul',
						'Agt',
						'Sep',
						'Okt',
						'Nov',
						'Des'
					);
			$split 	  = explode('-', $tanggal);
			$tgl_indo = $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
			
			if ($cetak_hari) {
				$num = date('N', strtotime($tanggal));
				return $hari[$num] . ', ' . $tgl_indo;
			}
			return $tgl_indo;
		}
	}
	?>

</body>



</html>