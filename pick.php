<html>
<head>
<title>tttitle</title>
<script>
function pickdata(src)
{
    window.open("pick-new.php?src=ttt","_blank",
        "height=60,width=250,left=150,top=150,location=no,"+
        "menubar=no,titlebar=no,toolbar=no,resizable=no,scrollbars=yes"
    );
}
</script>
</head>
<body>
弹出式数据选择器&nbsp;
<p>
<input name="txtdata" id="txtdata" value="">
<a href="javascript:pickdata('txtdata');">
Selecter</a>
</body>
</html>