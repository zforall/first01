<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script type="text/javascript" src="/script/sidebar-menu.js"></script>
	<link rel="stylesheet" href="/template/style.css" type="text/css" />

	<script type="text/javascript" src="/template/jquery.js"></script>
	<script type="text/javascript" src="/template/jquery.tablesorter.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#myTable").tablesorter( {sortList: [[0,0]]} );

            $("#sideLeft li").click(function(){
                window.location=$(this).find("a").attr("href");return false;
            });

/*
            $("#sideLeft h1").click(function(){
                $(".logo").animate({height: "hide"}, 1000);
                $(".logo").animate({height: "show"}, 1000);
            });
*/

            }
		);

/*
        $(document).ready(function(){

            $("#sideLeft li").click(function(){
                window.location=$(this).find("a").attr("href");return false;
            });

        }); //close doc ready
*/
    </script>
	
</head>

<body>
	
	<div id="wrapper">
		<div id="header">
			<div class="logo">
				<a href="/"><img src="/images/logo.png"/></a>
			</div>	
			<div class="menu">
				<?=$menu?>
			</div>	
		</div>
		
		<div id="content">
		
		