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
			margin-top: 4cm;
			margin-left: 1cm;
			margin-right: 2cm;
			margin-bottom: 2cm;
		}

		.myDiv {
			margin-top: 0cm;
			margin-left: 0cm;
			margin-right: 0cm;
			margin-bottom: 1.5cm;
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
			right: 1cm;
			height: 2cm;

			font-size: 8.0pt;
			font-weight: 400;
			font-style: normal;
			text-decoration: none;
			font-family: Calibri Light;
		}
	</style>

	<style id="Patokan SPP PDF_20581_Styles">
		<!--table
			{mso-displayed-decimal-separator:"\.";
			mso-displayed-thousand-separator:"\,";}
		.xl6520581
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
		.xl6620581
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
		.xl6720581
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
		.xl6820581
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
		.xl6920581
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
			border-left:.5pt solid windowtext;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl7020581
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
		.xl7120581
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
		.xl7220581
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
		.xl7320581
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
		.xl7420581
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
		.xl7520581
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
		.xl7620581
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
			white-space:nowrap;}
		.xl7720581
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
			border-top:.5pt solid windowtext;
			border-right:none;
			border-bottom:.5pt solid windowtext;
			border-left:none;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl7820581
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
			border-bottom:.5pt solid windowtext;
			border-left:none;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl7920581
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
		.xl8020581
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
		.xl8120581
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
		.xl8220581
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
		.xl8320581
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
		.xl8420581
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
		.xl8520581
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
		.xl8620581
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
		.xl8720581
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
		.xl8820581
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
		.xl8920581
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
		.xl9020581
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
		.xl9120581
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
		.xl9220581
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
		.xl9320581
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
		.xl9420581
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
		.xl9520581
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
		.xl9620581
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

	<style id="Patokan SPP PDF_28346_Styles">
		<!--table
		{mso-displayed-decimal-separator:"\.";
		mso-displayed-thousand-separator:"\,";}
		.xl6528346
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
		.xl6628346
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
		.xl6728346
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
		.xl6828346
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
		.xl6928346
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
			border-top:.5pt solid windowtext;
			border-right:none;
			border-bottom:.5pt solid windowtext;
			border-left:.5pt solid windowtext;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl7028346
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
			text-align:left;
			vertical-align:middle;
			border-top:.5pt solid windowtext;
			border-right:.5pt solid windowtext;
			border-bottom:.5pt solid windowtext;
			border-left:none;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl7128346
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
		.xl7228346
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
		.xl7328346
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
		.xl7428346
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
		.xl7528346
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
			border-left:none;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl7628346
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
			text-align:right;
			vertical-align:middle;
			border-top:.5pt solid windowtext;
			border-right:none;
			border-bottom:.5pt solid windowtext;
			border-left:.5pt solid windowtext;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl7728346
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
			text-align:right;
			vertical-align:middle;
			border-top:.5pt solid windowtext;
			border-right:none;
			border-bottom:.5pt solid windowtext;
			border-left:none;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl7828346
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
			text-align:right;
			vertical-align:middle;
			border-top:.5pt solid windowtext;
			border-right:.5pt solid windowtext;
			border-bottom:.5pt solid windowtext;
			border-left:none;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl7928346
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
			border-top:.5pt solid windowtext;
			border-right:.5pt solid windowtext;
			border-bottom:.5pt solid windowtext;
			border-left:none;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl8028346
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
		.xl8128346
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
		.xl8228346
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
		.xl8328346
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
			mso-number-format:"\0022Rp\0022\#\,\#\#0\;\[Red\]\\-\0022Rp\0022\#\,\#\#0";
			text-align:right;
			vertical-align:middle;
			border-top:.5pt solid windowtext;
			border-right:none;
			border-bottom:.5pt solid windowtext;
			border-left:.5pt solid windowtext;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl8428346
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
			mso-number-format:"\0022Rp\0022\#\,\#\#0\;\[Red\]\\-\0022Rp\0022\#\,\#\#0";
			text-align:right;
			vertical-align:middle;
			border-top:.5pt solid windowtext;
			border-right:none;
			border-bottom:.5pt solid windowtext;
			border-left:none;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl8528346
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
			vertical-align:middle;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl8628346
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
		.xl8728346
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
			vertical-align:middle;
			border-top:.5pt solid windowtext;
			border-right:none;
			border-bottom:.5pt solid windowtext;
			border-left:.5pt solid windowtext;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl8828346
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
			vertical-align:middle;
			border-top:.5pt solid windowtext;
			border-right:none;
			border-bottom:.5pt solid windowtext;
			border-left:none;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl8928346
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

	<style id="Patokan SPP PDF_11648_Styles">
		<!--table
		{mso-displayed-decimal-separator:"\.";
		mso-displayed-thousand-separator:"\,";}
		.xl6511648
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
		.xl6611648
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
		.xl6711648
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
		.xl6811648
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
		.xl6911648
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
		.xl7011648
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
			vertical-align:bottom;
			border:.5pt solid windowtext;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl7111648
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
			white-space:nowrap;}
		-->
	</style>
			
	<style id="Patokan SPP PDF_22632_Styles">
		<!--table
			{mso-displayed-decimal-separator:"\.";
			mso-displayed-thousand-separator:"\,";}
		.xl6522632
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
		.xl6622632
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
		.xl6722632
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
			white-space:nowrap;}
		.xl6822632
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
			white-space:nowrap;}
		.xl6922632
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
		.xl7022632
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
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl7122632
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
			border-left:.5pt solid windowtext;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl7222632
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
			white-space:nowrap;}
		.xl7322632
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
			border-bottom:none;
			border-left:.5pt solid windowtext;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl7422632
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
			border-top:none;
			border-right:.5pt solid windowtext;
			border-bottom:none;
			border-left:none;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl7522632
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
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl7622632
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
		.xl7722632
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
		.xl7822632
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
			border-left:.5pt solid windowtext;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl7922632
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
			border-left:.5pt solid windowtext;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:normal;}
		.xl8022632
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
		.xl8122632
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
		.xl8222632
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
		.xl8322632
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
		.xl8422632
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
		.xl8522632
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
		.xl8622632
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
		.xl8722632
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
			border-left:none;
			mso-background-source:auto;
			mso-pattern:auto;
			white-space:nowrap;}
		.xl8822632
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
		-->
	</style>

	<style id="Patokan SPP PDF_23093_Styles">
		<!--table
			{mso-displayed-decimal-separator:"\.";
			mso-displayed-thousand-separator:"\,";}
		.xl6523093
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
		.xl6623093
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
		.xl6723093
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
			text-align:right;
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

	<div id="Patokan SPP PDF_20581" align=center x:publishsource="Excel">

		<table border=0 cellpadding=0 cellspacing=0 width=1039 class=xl6620581
			style='border-collapse:collapse;table-layout:fixed;width:779pt'>
			<col class=xl6620581 width=64 span=15 style='width:48pt'>
			<col class=xl6620581 width=79 style='mso-width-source:userset;mso-width-alt:
			2816;width:59pt'>
			<tr height=13 style='mso-height-source:userset;height:10.05pt'>
			<td rowspan=3 height=39 class=xl7920581 width=64 style='border-bottom:.5pt solid black;
			height:30.15pt;width:48pt'><img src="assets/logo_wasa.png" alt="" width=50 height=50></td>
			<td colspan=12 rowspan=2 class=xl8220581 width=768 style='border-bottom:.5pt solid black;
			width:576pt'>SURAT PERMINTAAN PEMBELIAN</td>
			<td class=xl6520581 width=64 style='width:48pt'><span
			style='mso-spacerun:yes'>&nbsp;</span>Form No.</td>
			<td colspan=2 class=xl8620581 width=143 style='border-right:.5pt solid black;
			width:107pt'>:<span style='mso-spacerun:yes'>&nbsp; </span>WME/FSPP/01</td>
			</tr>
			<tr height=13 style='mso-height-source:userset;height:10.05pt'>
			<td height=13 class=xl6720581 style='height:10.05pt'><span
			style='mso-spacerun:yes'>&nbsp;</span>SOP No.</td>
			<td colspan=2 class=xl8820581 style='border-right:.5pt solid black'>:
			WME/SOP/FHS-PL/01</td>
			</tr>
			<tr height=13 style='mso-height-source:userset;height:10.05pt'>
			<td height=13 class=xl6820581 style='height:10.05pt;border-top:none;
			border-left:none'><span style='mso-spacerun:yes'>&nbsp;</span>No. Urut SPP</td>
			<td colspan=3 class=xl9020581 width=192 style='border-right:.5pt solid black;
			width:144pt'>: <?php echo $NO_URUT_SPP; ?></td>
			<td class=xl6920581 style='border-top:none;border-left:none'><span
			style='mso-spacerun:yes'>&nbsp;</span>No Urut SPPB</td>
			<td colspan=4 class=xl9020581 width=256 style='border-right:.5pt solid black;
			width:192pt'>: <?php echo $NO_URUT_SPPB; ?></td>
			<td class=xl6820581 style='border-top:none;border-left:none'><span
			style='mso-spacerun:yes'>&nbsp;</span>Tanggal</td>
			<td colspan=2 class=xl9020581 width=128 style='width:96pt'>: <?php echo
			$TANGGAL_DOKUMEN_SPP_INDO; ?></td>
			<td class=xl7020581><span style='mso-spacerun:yes'>&nbsp;</span>Dept.</td>
			<td colspan=2 class=xl9220581 style='border-right:.5pt solid black'>:
			Procurement &amp; Logistic</td>
			</tr>
			<tr height=13 style='mso-height-source:userset;height:10.05pt'>
			<td height=13 class=xl7120581 style='height:10.05pt'>&nbsp;</td>
			<td class=xl7220581></td>
			<td class=xl7320581></td>
			<td class=xl7320581></td>
			<td class=xl7320581></td>
			<td class=xl7220581></td>
			<td class=xl7320581></td>
			<td class=xl7320581></td>
			<td class=xl7320581></td>
			<td class=xl7320581></td>
			<td class=xl7220581></td>
			<td class=xl7320581></td>
			<td class=xl7320581></td>
			<td class=xl7220581></td>
			<td class=xl7320581></td>
			<td class=xl7420581>&nbsp;</td>
			</tr>
			<tr height=13 style='mso-height-source:userset;height:10.05pt'>
			<td height=13 class=xl7520581 style='height:10.05pt'><span
			style='mso-spacerun:yes'>&nbsp;</span>Proyek</td>
			<td colspan=7 class=xl9420581 width=448 style='border-right:.5pt solid black;
			width:336pt'>: <?php echo $NAMA_PROYEK_PDF; ?></td>
			<td class=xl7620581 colspan=2><span style='mso-spacerun:yes'>&nbsp;</span>Kondisi
			pengadaan</td>
			<td class=xl7620581 colspan=3>: <?php echo $JENIS_PERMINTAAN; ?></td>
			<td class=xl7720581>&nbsp;</td>
			<td class=xl7620581>&nbsp;</td>
			<td class=xl7820581>&nbsp;</td>
			</tr>
			<tr height=13 style='mso-height-source:userset;height:10.05pt'>
			<td colspan=16 height=13 class=xl9620581 style='height:10.05pt'><span
			style='mso-spacerun:yes'>&nbsp;</span>Mohon dibelikan barang-barang sebagai
			berikut:</td>
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
			<td width=79 style='width:59pt'></td>
			</tr>
			<![endif]>
		</table>

	</div>
				
	</header>

	<footer>
		<div id="Patokan SPP PDF_23093" align=center x:publishsource="Excel">
			<table border=0 cellpadding=0 cellspacing=0 width=320 class=xl6523093
			style='border-collapse:collapse;table-layout:fixed;width:240pt'>
			<col class=xl6523093 width=64 span=5 style='width:48pt'>
			<tr height=13 style='mso-height-source:userset;height:10.05pt'>
			<td colspan=2 rowspan=8 height=104 class=xl6723093 width=128
			style='height:80.4pt;width:96pt'><img style="width: 80px;" src="<?php echo $GAMBAR_QR_2; ?>"></td>
			<td class=xl6623093 width=64 style='width:48pt'>&nbsp;&nbsp;&nbsp;Lembar 1</td>
			<td class=xl6623093 width=64 style='width:48pt'>: Arsip</td>
			<td class=xl6523093 width=64 style='width:48pt'></td>
			</tr>
			<tr height=13 style='mso-height-source:userset;height:10.05pt'>
			<td height=13 class=xl6623093 style='height:10.05pt'>&nbsp;&nbsp;&nbsp;Lembar 2</td>
			<td class=xl6623093 colspan=2>: Keuangan/Akunting</td>
			</tr>
			<tr height=13 style='mso-height-source:userset;height:10.05pt'>
			<td height=13 class=xl6523093 style='height:10.05pt'></td>
			<td class=xl6523093></td>
			<td class=xl6523093></td>
			</tr>
			<tr height=13 style='mso-height-source:userset;height:10.05pt'>
			<td height=13 class=xl6523093 style='height:10.05pt'></td>
			<td class=xl6523093></td>
			<td class=xl6523093></td>
			</tr>
			<tr height=13 style='mso-height-source:userset;height:10.05pt'>
			<td height=13 class=xl6523093 style='height:10.05pt'></td>
			<td class=xl6523093></td>
			<td class=xl6523093></td>
			</tr>
			<tr height=13 style='mso-height-source:userset;height:10.05pt'>
			<td height=13 class=xl6523093 style='height:10.05pt'></td>
			<td class=xl6523093></td>
			<td class=xl6523093></td>
			</tr>
			<tr height=13 style='mso-height-source:userset;height:10.05pt'>
			<td height=13 class=xl6523093 style='height:10.05pt'></td>
			<td class=xl6523093></td>
			<td class=xl6523093></td>
			</tr>
			<tr height=13 style='mso-height-source:userset;height:10.05pt'>
			<td height=13 class=xl6523093 style='height:10.05pt'></td>
			<td class=xl6523093></td>
			<td class=xl6523093></td>
			</tr>
			</table>

		</div>


	</footer>

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

	<!-- Wrap the content of your PDF inside a main tag -->
	<main>
		<div class="myDiv">

			<div id="Patokan SPP PDF_28346" align=center x:publishsource="Excel">

				<table border=0 cellpadding=0 cellspacing=0 width=1039 class=xl6528346
				style='border-collapse:collapse;table-layout:fixed;width:779pt'>
				<col class=xl6528346 width=64 span=15 style='width:48pt'>
				<col class=xl6528346 width=79 style='mso-width-source:userset;mso-width-alt:
				2816;width:59pt'>

				<tr height=13 style='mso-height-source:userset;height:10.05pt'>
					<td height=13 class=xl6628346 width=64 style='height:10.05pt;width:3%'>No.</td>
					<td colspan=2 class=xl7428346 width=128 style='border-left:none;width:20%'>Nama
					Barang</td>
					<td colspan=3 class=xl7428346 width=192 style='border-right:.5pt solid black;width:20%'>Spesifikasi</td>
					<td colspan=2 class=xl7428346 width=128 style='border-right:.5pt solid black;
					border-left:none;width:96pt'>Banyaknya</td>
					<td class=xl6628346 width=64 style='border-left:none;width:7%'>Tanggal
					Dibutuhkan</td>
					<td colspan=2 class=xl7428346 width=128 style='border-right:.5pt solid black;
					border-left:none;width:10%'>Suplier/Vendor</td>
					<td colspan=2 class=xl7428346 width=128 style='border-left:none;width:5%'>Harga
					Per Unit</td>
					<td colspan=2 class=xl7428346 width=128 style='border-right:.5pt solid black;
					width:5%'>Total</td>
					<td class=xl7228346 width=79 style='width:15%'>Keterangan</td>
				</tr>

				<?php
					$hitung = 1;
					
					if (!empty($this->data['konten_rab_spp_form'])) {
						$panjang = count($konten_rab_spp_form);
						for ($i = 0; $i < $panjang; $i++) {
							?>

				<tr height=13 style='mso-height-source:userset;height:10.05pt'>
					<td colspan=16 height=13 class=xl8728346 style='border-right:.5pt solid black;
				height:10.05pt'>&nbsp; <?php echo $konten_rab_spp_form[$i]["NAMA_KATEGORI"] ?></td>
				</tr>

							<?php
							$panjang_j = count($konten_rab_spp_form[$i]["konten_SPP_form"]);
							for ($j = 0; $j < $panjang_j; $j++) {
							?>

				<tr height=13 style='mso-height-source:userset;height:10.05pt'>
					<td height=13 class=xl6828346 width=64 style='height:10.05pt;border-top:.5pt;
					width:3%'><?php echo $hitung; ?></td>

					<td colspan=2 class=xl8028346 width=128 style='border-right:.5pt solid black;
					border-left:none;width:20%;border-top:.5pt;padding-left: 5px;'><span style='mso-spacerun:yes'> <?php echo $konten_rab_spp_form[$i]["konten_SPP_form"][$j]->NAMA_BARANG; ?></td>

					<td colspan=3 class=xl8128346 width=192 style='border-right:.5pt solid black;
					border-left:none;width:20%;border-top:.5pt'><span style='mso-spacerun:yes'> <?php echo $konten_rab_spp_form[$i]["konten_SPP_form"][$j]->SPESIFIKASI_SINGKAT; ?></td>

					<td class=xl6928346 width=64 style='border-top:.5pt;border-left:none;width:3%'> <?php echo $konten_rab_spp_form[$i]["konten_SPP_form"][$j]->JUMLAH_BARANG; ?><span style='mso-spacerun:yes'></span></td>

					<td class=xl7028346 width=64 style='border-top:.5pt;width:4%'> <?php echo $konten_rab_spp_form[$i]["konten_SPP_form"][$j]->SATUAN_BARANG; ?></td>

					<td class=xl7128346 width=64 style='border-top:.5pt;border-left:none;
					width:7%'><?php $TANGGAL_MULAI_PAKAI_HARI_INDO = tanggal_indo_singkat($konten_rab_spp_form[$i]["konten_SPP_form"][$j]->TANGGAL_MULAI_PAKAI_HARI_INDO, false); echo  $TANGGAL_MULAI_PAKAI_HARI_INDO;?>
		  
					s.d.

					<?php $TANGGAL_SELESAI_PAKAI_HARI_INDO = tanggal_indo_singkat($konten_rab_spp_form[$i]["konten_SPP_form"][$j]->TANGGAL_SELESAI_PAKAI_HARI_INDO, false); echo  $TANGGAL_SELESAI_PAKAI_HARI_INDO;?>
					</td>

					<td colspan=2 class=xl8128346 width=128 style='border-right:.5pt solid black;
					border-left:none;border-top:.5pt;width:10%'><?php echo $konten_rab_spp_form[$i]["konten_SPP_form"][$j]->NAMA_VENDOR; ?></td>

					<td colspan=2 class=xl8328346 width=128 style='border-left:none;border-top:.5pt'>Rp. 
					<?php echo number_format(
						$konten_rab_spp_form[$i]["konten_SPP_form"][$j]->HARGA_SATUAN_BARANG_FIX,
						0,
						",",
						"."
					) ?>&nbsp;
					</td>

					<td colspan=2 class=xl6928346 width=128 style='border-right:.5pt solid black;border-top:.5pt'>Rp. 
					<?php echo number_format(
						$konten_rab_spp_form[$i]["konten_SPP_form"][$j]->HARGA_TOTAL_FIX,
						0,
						",",
						"."
					) ?>&nbsp;
					</td>
					
					<td class=xl6728346 width=79 style='border-top:.5pt;'><?php echo $konten_rab_spp_form[$i]["konten_SPP_form"][$j]->KETERANGAN_UMUM; ?></td>
				</tr>

							<?php
							$hitung = $hitung + 1;
							} 
							?>

						<?php
						}
					} ?>
				
				<?php
					$batas = $BARIS_KOSONG;
					for ($x = 0; $x < $batas; $x++) {
				?>
				<tr height=13 style='mso-height-source:userset;height:10.05pt'>
					<td height=13 class=xl6828346 width=64 style='height:10.05pt;border-top:.5pt;
					width:3%'></td>
					<td colspan=2 class=xl8028346 width=128 style='border-right:.5pt solid black;
					border-left:none;width:20%;border-top:.5pt;padding-left: 5px;'><span style='mso-spacerun:yes'></td>
					<td colspan=3 class=xl8128346 width=192 style='border-right:.5pt solid black;
					border-left:none;width:20%;border-top:.5pt'><span style='mso-spacerun:yes'></td>
					<td class=xl6928346 width=64 style='border-top:.5pt;border-left:none;width:3%'></td>
					<td class=xl7028346 width=64 style='border-top:.5pt;width:4%'></td>
					<td class=xl7128346 width=64 style='border-top:.5pt;border-left:none;
					width:7%'></td>
					<td colspan=2 class=xl8128346 width=128 style='border-right:.5pt solid black;
					border-left:none;border-top:.5pt;width:10%'></td>
					<td colspan=2 class=xl8328346 width=128 style='border-left:none;border-top:.5pt'></td>
					<td colspan=2 class=xl6928346 width=128 style='border-right:.5pt solid black;border-top:.5pt'></td>
					<td class=xl6728346 width=79 style='border-top:.5pt;'></td>
				</tr>

				<?php
				} ?>

				<tr height=13 style='mso-height-source:userset;height:10.05pt'>
					<td colspan=13 height=13 class=xl7628346 width=832 style='border-right:.5pt solid black;
					height:10.05pt;width:624pt'>TOTAL</td>
					<td colspan=2 class=xl6928346 width=128style='border-right:.5pt solid black; border-left:none;width:96pt;border-top:.5pt;'>
					Rp. <?php echo number_format($TOTAL_HARGA_SPP_BARANG, 0, ",", "."); ?>&nbsp;</td>
					<td class=xl6728346 width=79 style='border-top:.5pt;width:59pt'>&nbsp;</td>
				</tr>

				<tr height=13 style='mso-height-source:userset;height:10.05pt'>
					<td colspan=2 height=13 class=xl8528346 width=128 style='height:10.05pt;
					width:96pt'>Catatan SPP</td>
					<td colspan=14 class=xl8628346 width=911 style='width:683pt'>: <?php echo $CTT_DEPT_PROC; ?></td>
				</tr>
				</table>

				</div>

			<?php
			if ($this->data['TAMPILKAN_KONTROL_ANGGARAN']=="TAMPIL")
			{
			?>
			<div id="Patokan SPP PDF_11648" align=center x:publishsource="Excel">

				<table border=0 cellpadding=0 cellspacing=0 width=1039 class=xl6511648
				style='border-collapse:collapse;table-layout:fixed;width:779pt'>
				<col class=xl6511648 width=64 span=15 style='width:48pt'>
				<col class=xl6511648 width=79 style='mso-width-source:userset;mso-width-alt:
				2816;width:59pt'>
				<tr height=13 style='height:10.05pt'>
					<td height=13 class=xl6511648 width=64 style='height:10.05pt;width:48pt'></td>
					<td class=xl6511648 width=64 style='width:48pt'></td>
					<td class=xl6511648 width=64 style='width:48pt'></td>
					<td class=xl6511648 width=64 style='width:48pt'></td>
					<td class=xl6511648 width=64 style='width:48pt'></td>
					<td class=xl6511648 width=64 style='width:48pt'></td>
					<td class=xl6511648 width=64 style='width:48pt'></td>
					<td class=xl6511648 width=64 style='width:48pt'></td>
					<td class=xl6511648 width=64 style='width:48pt'></td>
					<td class=xl6511648 width=64 style='width:48pt'></td>
					<td class=xl6511648 width=64 style='width:48pt'></td>
					<td class=xl6511648 width=64 style='width:48pt'></td>
					<td class=xl6511648 width=64 style='width:48pt'></td>
					<td class=xl6511648 width=64 style='width:48pt'></td>
					<td class=xl6511648 width=64 style='width:48pt'></td>
					<td class=xl6511648 width=79 style='width:59pt'></td>
				</tr>
				<tr height=13 style='mso-height-source:userset;height:10.05pt'>
					<td colspan=2 height=13 class=xl6811648 width=128 style='height:10.05pt;
					width:96pt'>Kategori RAB</td>
					<td colspan=2 class=xl6911648 width=128 style='border-left:none;width:96pt'>Rencana
					Anggaran</td>
					<td colspan=2 class=xl6911648 width=128 style='border-left:none;width:96pt'>Pengadaan
					Sebelumnya</td>
					<td colspan=2 class=xl6911648 width=128 style='border-left:none;width:96pt'>Pengadaan
					Saat Ini</td>
					<td colspan=2 class=xl6911648 width=128 style='border-left:none;width:96pt'>Total
					Pengadaan</td>
					<td colspan=2 class=xl6911648 width=128 style='border-left:none;width:96pt'>Sisa
					Anggaran</td>
					<td class=xl6711648 width=64 style='width:48pt'></td>
					<td class=xl6711648 width=64 style='width:48pt'></td>
					<td class=xl6711648 width=64 style='width:48pt'></td>
					<td class=xl6611648 width=79 style='width:59pt'></td>
				</tr>

				<?php
				$hitung = 1;
				if (!empty($this->data['konten_kontrol_anggaran'])) {
					foreach ($konten_kontrol_anggaran as $item) {
				?>
				<tr height=13 style='mso-height-source:userset;height:10.05pt'>
					<td colspan=2 height=13 class=xl7011648 style='border-right:.5pt solid black;height:10.05pt'><?php echo $item->NAMA_KATEGORI; ?></td>
					<td colspan=2 class=xl7111648 style='border-right:.5pt solid black;
					border-left:none;padding-right: 5px;'>Rp <?php echo number_format(
											$item->RENCANA_ANGGARAN,
											0,
											",",
											"."
										) ?></td>
					<td colspan=2 class=xl7111648 style='border-right:.5pt solid black;
					border-left:none;padding-right: 5px;'>Rp <?php echo number_format(
											$item->PENGADAAN_SEBELUMNYA,
											0,
											",",
											"."
										) ?></td>
					<td colspan=2 class=xl7111648 style='border-right:.5pt solid black;
					border-left:none;padding-right: 5px;'>Rp <?php echo number_format(
											$item->PENGADAAN_SAAT_INI,
											0,
											",",
											"."
										) ?> </td>
					<td colspan=2 class=xl7111648 style='border-right:.5pt solid black;
					border-left:none;padding-right: 5px;'>Rp <?php echo number_format(
											$item->TOTAL_PENGADAAN,
											0,
											",",
											"."
										) ?></td>
					<td colspan=2 class=xl7111648 style='border-right:.5pt solid black;
					border-left:none;padding-right: 5px;'>Rp <?php echo number_format(
											$item->SISA_ANGGARAN,
											0,
											",",
											"."
										) ?></td>
					<td class=xl6711648></td>
					<td class=xl6711648></td>
					<td class=xl6711648></td>
					<td class=xl6611648></td>
				</tr>
				<?php
						$hitung = $hitung + 1;
					}
				} ?>
				</table>

				</div>
			<?php
			} ?>

			<?php
			if ($this->data['TAMPILKAN_KONTROL_ANGGARAN']!="TAMPIL")
			{
			?>
			<div id="Patokan SPP PDF_11648" align=center x:publishsource="Excel">

				<table border=0 cellpadding=0 cellspacing=0 width=1039 class=xl6511648
				style='border-collapse:collapse;table-layout:fixed;width:779pt'>
				<col class=xl6511648 width=64 span=15 style='width:48pt'>
				<col class=xl6511648 width=79 style='mso-width-source:userset;mso-width-alt:
				2816;width:59pt'>
				<tr height=13 style='height:10.05pt'>
					<td height=13 class=xl6511648 width=64 style='height:10.05pt;width:48pt'></td>
					<td class=xl6511648 width=64 style='width:48pt'></td>
					<td class=xl6511648 width=64 style='width:48pt'></td>
					<td class=xl6511648 width=64 style='width:48pt'></td>
					<td class=xl6511648 width=64 style='width:48pt'></td>
					<td class=xl6511648 width=64 style='width:48pt'></td>
					<td class=xl6511648 width=64 style='width:48pt'></td>
					<td class=xl6511648 width=64 style='width:48pt'></td>
					<td class=xl6511648 width=64 style='width:48pt'></td>
					<td class=xl6511648 width=64 style='width:48pt'></td>
					<td class=xl6511648 width=64 style='width:48pt'></td>
					<td class=xl6511648 width=64 style='width:48pt'></td>
					<td class=xl6511648 width=64 style='width:48pt'></td>
					<td class=xl6511648 width=64 style='width:48pt'></td>
					<td class=xl6511648 width=64 style='width:48pt'></td>
					<td class=xl6511648 width=79 style='width:59pt'></td>
				</tr>
				<tr height=13 style='mso-height-source:userset;height:10.05pt'>
					<td colspan=2 height=13 class=xl6811648 style='height:10.05pt'>Kategori RAB</td>
					<td colspan=2 class=xl6911648 style='border-left:none'>Rencana Anggaran</td>
					<td colspan=2 class=xl6911648 style='border-left:none'>Pengadaan Sebelumnya</td>
					<td colspan=2 class=xl6911648 style='border-left:none'>Pengadaan Saat Ini</td>
					<td colspan=2 class=xl6911648 style='border-left:none'>Total Pengadaan</td>
					<td colspan=2 class=xl6911648 style='border-left:none'>Sisa Anggaran</td>
					<td class=xl6711648></td>
					<td class=xl6711648></td>
					<td class=xl6711648></td>
					<td class=xl6611648></td>
				</tr>
				<?php
				$hitung = 1;
				if (!empty($this->data['konten_kontrol_anggaran'])) {
					foreach ($konten_kontrol_anggaran as $item) {
				?>
				<tr height=13 style='mso-height-source:userset;height:10.05pt'>
					<td colspan=2 height=13 class=xl7011648 style='height:10.05pt'><?php echo $item->NAMA_KATEGORI; ?></td>
					<td colspan=2 class=xl7111648 style='border-left:none'></td>
					<td colspan=2 class=xl7111648 style='border-left:none'></td>
					<td colspan=2 class=xl7111648 style='border-left:none'></td>
					<td colspan=2 class=xl7111648 style='border-left:none'></td>
					<td colspan=2 class=xl7111648 style='border-left:none'></td>
					<td class=xl6711648></td>
					<td class=xl6711648></td>
					<td class=xl6711648></td>
					<td class=xl6611648></td>
				</tr>
				<?php
						$hitung = $hitung + 1;
					}
				} ?>
				</table>

				</div>
			<?php
			} ?>

			<div id="Patokan SPP PDF_22632" align=center x:publishsource="Excel">

				<table border=0 cellpadding=0 cellspacing=0 width=1039 class=xl6522632
				style='border-collapse:collapse;table-layout:fixed;width:779pt;page-break-inside: avoid; page-break-after: avoid;'>
				<col class=xl6522632 width=64 span=15 style='width:48pt'>
				<col class=xl6522632 width=79 style='mso-width-source:userset;mso-width-alt:
				2816;width:59pt'>
				<tr height=13 style='mso-height-source:userset;height:10.05pt'>
					<td height=13 class=xl6522632 width=64 style='height:10.05pt;width:48pt;'></td>
					<td class=xl7522632 width=64 style='width:48pt'></td>
					<td class=xl7622632 width=64 style='width:48pt'></td>
					<td class=xl7622632 width=64 style='width:48pt'></td>
					<td class=xl7622632 width=64 style='width:48pt'></td>
					<td class=xl7722632 width=64 style='width:48pt'></td>
					<td class=xl7722632 width=64 style='width:48pt'></td>
					<td class=xl7722632 width=64 style='width:48pt'></td>
					<td class=xl7722632 width=64 style='width:48pt'></td>
					<td class=xl7722632 width=64 style='width:48pt'></td>
					<td class=xl7722632 width=64 style='width:48pt'></td>
					<td class=xl7722632 width=64 style='width:48pt'></td>
					<td class=xl7722632 width=64 style='width:48pt'></td>
					<td class=xl7722632 width=64 style='width:48pt'></td>
					<td class=xl7722632 width=64 style='width:48pt'></td>
					<td class=xl6522632 width=79 style='width:59pt'></td>
				</tr>
				<tr height=13 style='mso-height-source:userset;height:10.05pt;page-break-inside: avoid; page-break-after: avoid;'>
					<td colspan=3 height=13 class=xl8622632 style='height:10.05pt'>Disetujui
					Oleh,</td>
					<td colspan=7 class=xl8622632 style='border-right:.5pt solid black'>Diketahui
					Oleh,</td>
					<td class=xl6822632></td>
					<td class=xl6622632></td>
					<td class=xl6622632></td>
					<td class=xl6622632></td>
					<td colspan=2 class=xl8622632 style='border-right:.5pt solid black'>Disiapkan
					Oleh,</td>
					</tr>
					<tr height=13 style='mso-height-source:userset;height:10.05pt'>
					<td colspan=3 height=13 class=xl8622632 style='height:10.05pt'>Direktorat</td>
					<td colspan=6 class=xl8622632 style='border-right:.5pt solid black'>Manajer
					Departemen</td>
					<td class=xl6922632>Mjr. Proyek</td>
					<td class=xl7022632></td>
					<td class=xl6622632></td>
					<td class=xl6622632></td>
					<td class=xl6622632></td>
					<td colspan=2 class=xl8622632 style='border-right:.5pt solid black'>Manajer
					Pengadaan</td>
				</tr>
				<tr height=13 style='mso-height-source:userset;height:10.05pt;page-break-inside: avoid; page-break-after: avoid;'>
					<td height=13 class=xl7122632 style='height:10.05pt'>Dir. Keu</td>
					<td class=xl7222632>Dir. E&amp;P</td>
					<td class=xl7222632>Dir. Kons</td>
					<td class=xl7122632 style='border-left:none'>Keu</td>
					<td class=xl7222632>Logistik</td>
					<td class=xl7222632>Konstruksi</td>
					<td class=xl7222632>E&amp;P</td>
					<td class=xl7222632>HSSE</td>
					<td class=xl7222632>QA/QC</td>
					<td class=xl7222632>SM</td>
					<td class=xl6722632></td>
					<td class=xl6622632></td>
					<td class=xl6622632></td>
					<td class=xl6622632></td>
					<td colspan=2 rowspan=4 class=xl8022632 width=143 style='border-right:.5pt solid black;
					border-bottom:.5pt solid black;width:107pt'><?php echo
					$SIGN_USER_M_PROC; ?></td>
				</tr>
				<tr height=13 style='mso-height-source:userset;height:10.05pt;page-break-inside: avoid; page-break-after: avoid;'>
					<td rowspan=3 height=39 class=xl7822632 width=64 style='border-bottom:.5pt solid black;
					height:30.15pt;border-top:none;width:48pt'><?php echo
					$SIGN_USER_D_KEU; ?></td>
					<td rowspan=3 class=xl7822632 width=64 style='border-bottom:.5pt solid black;
					border-top:none;width:48pt'><?php echo $SIGN_USER_D_EP_KONS;
					?></td>
					<td rowspan=3 class=xl7822632 width=64 style='border-bottom:.5pt solid black;
					border-top:none;width:48pt'><?php echo $SIGN_USER_D_EP_KONS;
					?></td>
					<td rowspan=3 class=xl7822632 width=64 style='border-bottom:.5pt solid black;
					border-top:none;width:48pt'><?php echo $SIGN_USER_M_KEU; ?></td>
					<td rowspan=3 class=xl7822632 width=64 style='border-bottom:.5pt solid black;
					border-top:none;width:48pt'><?php echo $SIGN_USER_M_LOG; ?></td>
					<td rowspan=3 class=xl7822632 width=64 style='border-bottom:.5pt solid black;
					border-top:none;width:48pt'><?php echo $SIGN_USER_M_KONS; ?></td>
					<td rowspan=3 class=xl7822632 width=64 style='border-bottom:.5pt solid black;
					border-top:none;width:48pt'><?php echo $SIGN_USER_M_EP; ?></td>
					<td rowspan=3 class=xl7822632 width=64 style='border-bottom:.5pt solid black;
					border-top:none;width:48pt'><?php echo $SIGN_USER_M_HSSE; ?></td>
					<td rowspan=3 class=xl7822632 width=64 style='border-bottom:.5pt solid black;
					border-top:none;width:48pt'><?php echo $SIGN_USER_M_QAQC; ?></td>
					<td rowspan=3 class=xl7822632 width=64 style='border-bottom:.5pt solid black;
					border-top:none;width:48pt'><?php echo $SIGN_USER_SM; ?></td>
					<td class=xl7322632 width=64 style='border-left:none;width:48pt'>&nbsp;</td>
					<td class=xl6622632></td>
					<td class=xl6622632></td>
					<td class=xl6622632></td>
				</tr>
					<tr height=13 style='mso-height-source:userset;height:10.05pt;page-break-inside: avoid; page-break-after: avoid;'>
					<td height=13 class=xl7322632 width=64 style='height:10.05pt;border-left:
					none;width:48pt'>&nbsp;</td>
					<td class=xl6622632></td>
					<td class=xl6622632></td>
					<td class=xl6622632></td>
				</tr>
				<tr height=13 style='mso-height-source:userset;height:10.05pt;page-break-inside: avoid; page-break-after: avoid;'>
					<td height=13 class=xl7322632 width=64 style='height:10.05pt;border-left:
					none;width:48pt'>&nbsp;</td>
					<td class=xl6622632></td>
					<td class=xl6622632></td>
					<td class=xl7422632>&nbsp;</td>
				</tr>
				</table>

			</div>





		</div>
	</main>
</body>

</html>