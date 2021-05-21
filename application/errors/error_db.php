<!DOCTYPE html>
<html lang="en" id="kt_html">
<head>
<title>Database Error</title>
<style type="text/css">
::selection{ background-color: #E13300; color: white; }
::moz-selection{ background-color: #E13300; color: white; }
::webkit-selection{ background-color: #E13300; color: white; }

body {
	background-color: #fff;
	margin: 40px;
	font: 13px/20px normal Helvetica, Arial, Arial;
	color: #4F5155;
}

a {
	color: #003399;
	background-color: transparent;
	font-weight: normal;
}

h1 {
	color: #444;
	background-color: transparent;
	border-bottom: none;
	font-size: 19px;
	font-weight: normal;
	margin: 0 0 14px 0;
	padding: 14px 15px 10px 15px;
}

code {
	font-family: Poppins, Helvetica, "sans-serif";
	font-size: 12px;
	background-color: #f9f9f9;
	border: 1px solid #D0D0D0;
	color: #002166;
	display: block;
	margin: 14px 0 14px 0;
	padding: 12px 10px 12px 10px;
}

#container {
	margin: 10px;
	border: 1px solid #D0D0D0;
	-webkit-box-shadow: 0 0 8px #D0D0D0;
}

p {
	margin: 12px 15px 12px 15px;
}

html, body {
    height: 100%;
    margin: 0px;
    padding: 0px;
    font-size: 13px !important;
    font-weight: 400;
    font-family: Poppins, Helvetica, "sans-serif";
    -ms-text-size-adjust: 100%;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}
body#kt_body {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    color: #3F4254;
}
.flex-root {
    -webkit-box-flex: 1;
    flex: 1;
    -ms-flex: 1 0 0px;
}
.flex-column {
    -webkit-box-orient: vertical !important;
    -webkit-box-direction: normal !important;
    -ms-flex-direction: column !important;
    flex-direction: column !important;
}
.d-flex {
    display: -webkit-box !important;
    display: -ms-flexbox !important;
    display: flex !important;
}
.flex-row-fluid {
    -webkit-box-flex: 1;
    flex: 1 auto;
    -ms-flex: 1 0 0px;
    min-width: 0;
}
.bgi-position-center {
    background-position: center;
}
.bgi-no-repeat {
    background-repeat: no-repeat;
}
.bgi-size-cover {
    background-size: cover;
}
.p-sm-30 {
    padding: 120px !important;
}
.p-10 {
    padding: 80px !important;
}
.font-weight-boldest {
    font-weight: 700;
}
.text-dark-75 {
    color: #3F4254 !important;
}
.mt-15, .my-15 {
    margin-top: 30px !important;
}
.font-size-h3 {
    font-size: 20px !important;
}
.text-muted {
    color: #B5B5C3 !important;
}
.text-muted {
    color: #B5B5C3 !important;
}
.font-weight-normal {
    font-weight: 400 !important;
}
p {
    margin-top: 0;
    margin-bottom: 10px;
    font-size: 20px;
    font-weight: 500;
}
</style>
</head>
<body id="kt_body" style="background-image: url(/assets/admin/layout3/img/bg-404.jpg);">
		<div class="d-flex flex-column flex-root">
			<div class="d-flex flex-row-fluid flex-column bgi-size-cover bgi-position-center bgi-no-repeat p-10 p-sm-30">
				<!--begin::Content-->
				<h1 class="font-weight-boldest text-dark-75 mt-15" style="font-size: 80px;line-height: 80px;"><?php echo $heading; ?></h1>
				<p class="font-size-h3 text-muted font-weight-normal"><?php echo $message; ?></p>
				<!--end::Content-->
			</div>
		</div>
</body>
</html>