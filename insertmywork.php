<?php
include_once 'dbconfig.php';
if(filter_input(INPUT_POST, 'year')){
    $year =$_POST['year'];
    $teacherId = $_POST['teacherId'];
    $typeName=$_POST['typeName'];
    $rankName= $_POST['rankName'];
    $content = $_POST['content'];
    $amount =  $_POST['amount'];
    $classHour =  $_POST['classHour'];
    $money=  $_POST['money'];
   session_start();
   $authority =$_SESSION["authority"];
   $recorder = $authority["userName"];
   if ($authority['role']=="教师"){
   	$status="保存";  	
   }else {
   	$status="确认";   	
   } 
    $data = array(
    		"year" =>$year,
    		"teacherId" => $teacherId,
    		"typeName"=>$typeName,
    		"rankName"=>$rankName,
    		"content" =>$content,
    		"amount" =>$amount,
    		"classHour" => $classHour,
    		"money"=>$money,
    		"recorder"=>$recorder,
    		"status"=>$status
    );    
    $statement = "INSERT INTO work(id, year, teacherId, typeName, rankName, content, amount, classHour,money,recorder,status)".
        " VALUES (null, :year, :teacherId, :typeName, :rankName,:content, :amount, :classHour,:money,:recorder,:status)";
    $statementObject =  $pdo->prepare($statement);
    $result = $statementObject->execute($data);
    if($result){
        header("location:jump.php?error=数据保存成功&url=work.php&wait=3");
    }else{
        header("location:jump.php?error=数据保存失败&url=work.php&wait=3");
    }
    exit();
}
include_once 'base.php';
//查询变量初始化
$type ="";
$year =$toyear = date("Y");
$name = "";
//查询🌩大类
$queryType = "select distinct bigType from worktype order by bigType";
$queryTypeObject = $pdo->prepare($queryType);
$queryTypeObject->execute();
$bigType = $queryTypeObject->fetchAll()
?>
<script>
function pickName()
{
    window.open("pickname.php","_blank",
        "height=100,width=400,left=300,top=500,location=no,"+
        "menubar=no,titlebar=no,toolbar=no,resizable=no,scrollbars=no"
    );
}
//查询类别 ajax  异步刷新
function selectBigType(){
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null){
	  alert ("Browser does not support HTTP Request");
	  return;
	} 
	var bigtype = document.getElementById("bigType");
	xmlHttp.open("GET","http://localhost/workload/gettype.php?bigtype="+bigtype.value,true);
    xmlHttp.send(null);
  //  alert("dddd");
    xmlHttp.onreadystatechange=function(){
    	if (xmlHttp.readyState == 4 && xmlHttp.status == 200)
       	 { 
         	//清空级别和范围限制
    		var rankNameElement = document.getElementById("rankNameOption");
    		rankNameElement.innerHTML= "";
    		rankNameElement.disabled= true;
    		var classHourElement = document.getElementById("classHour");
    		classHourElement.placeholder= "";
    		classHourElement.value= "";
    		classHourElement.disabled= true;
    		var moneyElement = document.getElementById("money");
    		moneyElement.placeholder= "";
    		moneyElement.value= "";
    		moneyElement.disabled= true;
         	//解析返回值
         	var typeName = JSON.parse(xmlHttp.responseText);
         	var innertext = "";
         	if(typeName.length>1){
         		innertext += "<option value=''>--请选择类别--</option>";
         	}
         	for(j = 0; j < typeName.length; j++) {
         		innertext += '<option value="'+typeName[j].typeName+'"';
         		if(typeName.length==1){
         			innertext += " selected ";
         		}
         		innertext += '>'+typeName[j].typeName+'</option>';
         	} 
         	var typeNameElement = document.getElementById("typeNameOption");
         	typeNameElement.disabled = false;
         	typeNameElement.innerHTML= innertext;
         	//当类别唯一时，自动填充类别
         	if(typeName.length==1){
         		typeNameElement.disabled = true;
         		selectRank();
         	}
       	 } 
    };
}
//查询级别
function selectRank(){
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null){
	  alert ("Browser does not support HTTP Request");
	  return;
	} 
	var typeName = document.getElementById("typeNameOption").value;
	xmlHttp.open("GET","http://localhost/workload/getrank.php?typeName="+typeName,true);
    xmlHttp.send(null);
    xmlHttp.onreadystatechange=function(){
    	if (xmlHttp.readyState == 4 && xmlHttp.status == 200)
       	 { 
         	var rankName = JSON.parse(xmlHttp.responseText);
         	var innertext = "";
         	if(rankName.length>1){
         		innertext += "<option value=''>--请选择级别--</option>";
         	}
         	for(j = 0; j < rankName.length; j++) {
         		innertext += '<option value="'+rankName[j].rank+'" ';
         		if(rankName.length==1){
         			innertext += " selected ";
         		}
         		innertext += '>'+rankName[j].rank+'</option>';
         	}
         	var rankNameElement = document.getElementById("rankNameOption");
         	rankNameElement.disabled = false;
         	rankNameElement.innerHTML= innertext;
         	//级别选项唯一时自动触发范围限制
         	if(rankNameElement.length==1){
         		rankNameElement.disabled = true;
         		getLmitRange();
         	}
       	 } 
    };
}
//查询课时约束和奖励约束
function getLmitRange(){
	var typeNameObject = document.getElementById("typeNameOption");
	var typeName = typeNameObject.value;
	var rank = document.getElementById("rankNameOption").value;
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null){
	  alert ("Browser does not support HTTP Request");
	  return;
	} 
	xmlHttp.open("GET","http://localhost/workload/getlimitrange.php?typeName="+typeName+"&rank="+rank,true);
    xmlHttp.send(null);
    xmlHttp.onreadystatechange=function(){
    	if (xmlHttp.readyState == 4 && xmlHttp.status == 200)
       	 { 
         	var limitRange = JSON.parse(xmlHttp.responseText);
         	var classHour = JSON.parse(limitRange.classHour);
         	var price = JSON.parse(limitRange.price);
         	var classHourElement = document.getElementById("classHour");
         	classHourElement.disabled= false;
         	if(classHour.C!==""){
         		classHourElement.value = classHour.C;
				classHourElement.alt = classHour.C;
         		classHourElement.disabled = true;
         	}else{
         		//清空并允许输入
         		classHourElement.value = "";
				classHourElement.alt = "";
         		//加入提示信息
             	var hintStr = "";
             	if(classHour.L!==""){
             		hintStr += "最小值："+classHour.L;
             	}
         		if(classHour.H!==""){
         			hintStr += "  最大值："+classHour.H;
             	}
         		classHourElement.placeholder = hintStr;
				classHourElement.max = classHour.H;
				classHourElement.min = classHour.L;
         	}
         	var moneyElement = document.getElementById("money");
         	moneyElement.disabled = false;
         	if(price.C!==""){
         		moneyElement.value = price.C;
				moneyElement.alt = price.C;
         		moneyElement.disabled = true;
         	}else{
             	//清空并允许输入
         		moneyElement.value = "";
				moneyElement.alt = "";
         		//加入提示信息
         		var moneyStr = "";
             	if(price.L!==""){
             		moneyStr += "最小值："+price.L;
             	}
         		if(price.H!==""){
         			moneyStr += "  最大值："+price.H;
             	}
         		moneyElement.placeholder = moneyStr;
				moneyElement.max = price.H;
				moneyElement.min = price.L;
         	}
       	 } 
    };
}
//前端做数据完整性校验
function mysubmit(submitType) {
	//保存状态值 
	var moneyStatus = $("input[name=money]").attr("disabled");
	var classHourStatus = $("input[name=classHour]").attr("disabled");
	var rankNameStatus = $("select[name=rankName]").attr("disabled");
	var typeNameStatus = $("select[name=typeName]").attr("disabled");
	//置为可读状态
	$("input[name=money]").attr("disabled",false); 
	$("input[name=classHour]").attr("disabled",false); 
	$("select[name=rankName]").attr("disabled",false); 
	$("select[name=typeName]").attr("disabled",false);
	//读取数据
	var typeNameOption = document.getElementById("typeNameOption").value;
	var rankNameOption = document.getElementById("rankNameOption").value;
	var content = document.getElementById("content").value;
	var classHour = document.getElementById("classHour").value;
	var money = document.getElementById("money").value;
	var teacherId = document.getElementById("teacherId").value;
	if(teacherId==""|| typeNameOption==""|| rankNameOption=="" ||content=="" ||classHour=="" ||money==""){
		//还原状态
		if(moneyStatus=="disabled") $("input[name=money]").attr("disabled",true);
		if(classHourStatus=="disabled") $("input[name=classHour]").attr("disabled",true);
		if(rankNameStatus=="disabled")  $("select[name=rankName]").attr("disabled",true);
		if(typeNameStatus=="disabled") $("select[name=typeName]").attr("disabled",true);
		alert("数据不完整，请数据补充完整！");
	}else{
		//数据范围校验
		var isok = true;
		var textobj =  document.getElementById("classHour");
		textobj.value=textobj.value.replace(/([\d-]+)[\D]|[^-^\d]/g,"$1");
		if(textobj.alt!=""){
			if(textobj.value-textobj.alt!=0){
				 isok = false;
				textobj.value = textobj.alt;
				alert("折算课时不正确");
			}
		}else{
			if(textobj.max!=""){
				if(textobj.value-textobj.max>0){
				   isok = false;
				  textobj.value = textobj.max;
				  alert("折算课时超过上限");
				}
			}
			if(textobj.min!=""){
				if(textobj.value-textobj.min<0){
				  isok = false;
				  textobj.value = textobj.min;
				  alert("折算课时超过下限");
				}
			}
		}
		var moneyobj =  document.getElementById("money");
		moneyobj.value=moneyobj.value.replace(/([\d-]+)[\D]|[^-^\d]/g,"$1");
		if(moneyobj.alt!=""){
			if(moneyobj.value-moneyobj.alt!=0){
				isok = false;
				moneyobj.value = moneyobj.alt;
				alert("奖励金额不正确");
			}
		}else{
			if(moneyobj.max!=""){
				if(moneyobj.value-moneyobj.max>0){
				  isok = false;
				  moneyobj.value = moneyobj.max;
				  alert("奖励金额超过上限");
				}
			}
			if(moneyobj.min!=""){
				if(moneyobj.value-moneyobj.min<0){
				  isok = false;
				  moneyobj.value = moneyobj.min;
				  alert("奖励金额超过下限");
				}
			}
		}
		if(isok){
			var workform = document.getElementById("workform");
			var status = document.getElementById("status");
			if(submitType.name=="save"){
				status.value="保存";
			}else if(submitType.name=="submitCheck"){
				status.value="待审";
			}else if(submitType.name=="ok"){
				status.value="确认";
			}
			workform.submit();
		}else{
			//还原状态
			if(moneyStatus=="disabled") $("input[name=money]").attr("disabled",true);
			if(classHourStatus=="disabled") $("input[name=classHour]").attr("disabled",true);
			if(rankNameStatus=="disabled")  $("select[name=rankName]").attr("disabled",true);
			if(typeNameStatus=="disabled") $("select[name=typeName]").attr("disabled",true);
		}
	}
}

function GetXmlHttpObject()
{
    var xmlHttp=null;
    try{
     	//Firefox, Opera 8.0+, Safari
     	xmlHttp=new XMLHttpRequest();
    }catch (e){
        // Internet Explorer
        try{
          xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
        }catch (e){
          xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
    }
    return xmlHttp;
}

function checkRange(textobj){
	textobj.value=textobj.value.replace(/([\d-]+)[\D]|[^-^\d]/g,"$1");
	if(textobj.max!=""){
		if(textobj.value-textobj.max>0){
		  textobj.value = textobj.max;
		}
	}
}

</script>					
<div id="page-wrapper">
	<div id="page-inner">
		<div class="row">
			<div class="col-md-12">
				<h2>录入非授课工作信息</h2>
			</div>
		</div>
		<!-- /. ROW  -->
		<hr />
		<div class="row">
			<div class="col-md-7 col-md-offset-0">
				<!-- class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1"> -->
				<div class="panel panel-default">
					<div class="panel-heading">
						<strong>录入非授课工作信息</strong>
					</div>
					<div class="panel-body">
						<form role="form" id="workform" action="insertwork.php" method='post'>
							<br />
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-tag"> 年度</i></span>

								<select class="form-control" name="year">
								<option value="0" <?=empty($year)?"selected":''?>>全部</option>
							    <option value="<?=$toyear-2?>" <?=$year==$toyear-2?"selected":''?>><?=$toyear-2?>年</option>
							    <option value="<?=$toyear-1?>" <?=$year==$toyear-1?"selected":''?>><?=$toyear-1?>年</option>
							    <option value="<?=$toyear?>" <?=$year==$toyear?"selected":''?>><?=$toyear?>年</option>
							    <option value="<?=$toyear+1?>" <?=$year==$toyear+1?"selected":''?>><?=$toyear+1?>年</option>
							    <option value="<?=$toyear+2?>" <?=$year==$toyear+2?"selected":''?>><?=$toyear+2?>年</option>
								</select>							
						         <span class="input-group-addon"><i class="fa fa-flag">&nbsp;教工号</i></span>
								<input type="text" class="form-control" placeholder="教工号" name='teacherId' maxlength="15" id='teacherId' onclick="pickName()" />
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-flag">&nbsp;大类</i></span>
								<select class="form-control" id="bigType" name="bigType" onchange="selectBigType()">
									<?php 
									echo"<option value =''>--请选择大类--</option>";
									foreach ($bigType as $row){
										echo "<option value ='".$row['bigType']."'".(empty($year)?"selected":'').">".$row['bigType']."</option>";
									}
									?>
									</select>
								<span class="input-group-addon"><i class="fa fa-flag">&nbsp;类别</i></span>
								<select class="form-control" name="typeName" id="typeNameOption" onchange="selectRank()" disabled="disabled">
								</select>
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-level-up">
										&nbsp;级别</i></span> 
								<select class="form-control" name="rankName" id="rankNameOption" disabled="disabled" onchange="getLmitRange()">
								</select>
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-navicon">&nbsp;内容</i></span>
								<textarea class="form-control" rows="5" placeholder="工作内容" id='content'  maxlength="499" 
									name='content'></textarea>
							</div>
							<input type="hidden" name='amount' value = "1" />
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-clock-o">&nbsp; 折算课时</i></span>
								<input type="text" class="form-control" id="classHour" disabled="disabled"  maxlength="10" 
									name='classHour'  onkeyup="checkRange(this)"/>
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-yen"> &nbsp;奖励金额</i></span>
								<input type="text" class="form-control" id="money" 	name='money' maxlength="10"  
								disabled="disabled"  onkeyup="checkRange(this)"/>
							</div>
							<input type="hidden" id="status" name="status" value="保存"/>
 							<input type='reset' class="btn btn-primary" value=' 重 置 ' />&nbsp;&nbsp;
							<input type='button' name="save" onclick="javascript:mysubmit(this);" class="btn btn-primary" value=' 保 存 ' />&nbsp;&nbsp;
							<a class="btn btn-primary" href="work.php">放弃</a>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
!function(){
	laydate.skin('molv');//切换皮肤，请查看skins下面皮肤库
	laydate({elem: '#birthday'});//绑定元素
}();
</script>
</body>
</html>