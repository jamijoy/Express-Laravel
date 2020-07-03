function myFunc()
{
	window.location.replace(document.getElementById('profileBtn').value);
}

function Activation(linkToGo,status)
{
	// alert('Heloo');
	var linkToGo = linkToGo;
	var status = status;
	if(confirm('Sure want to '+status+' this account ?' ))
	{
		window.location.replace(linkToGo);
	}
}

function Activator(status,AccName,linkToGo)
{
	var status = status;
	var AccName = AccName;
	var linkToGo = linkToGo;
	if(confirm('Sure want to '+status+' account of "'+AccName+'" ?' ))
	{
		window.location.replace(linkToGo);
	}
}

function Blocker(id)
{
	var id = id;
	if(confirm('Sure want to Block this account ?' ))
	{
		window.location.replace('/Block/'+id);
	}
}
function Unblocker(id)
{
	var id = id;
	if(confirm('Sure want to Unblock this account ?'))
	{
		window.location.replace('/Unblock/'+id);
	}
}

function Notify(Message)
{
	alert(Message);
}

function ErrFunc()
{
	var msg = document.getElementById('errData').value;
	alert(msg);
}

var i = 0;
function statFunc(totals) {
	
	var totals = totals;
	var data = document.getElementById("selectedStat").value;
	var dataArray = data.split("-");
	var typeAcc = ((100*dataArray[0])/totals).toFixed();
	var deacts = ((100*dataArray[1])/totals).toFixed();
	var blcks = ((100*dataArray[2])/totals).toFixed();
	document.getElementById("totAcc").innerHTML=totals;
	document.getElementById("typeAcc").innerHTML="Total Accounts: "+dataArray[0]+" ("+typeAcc+"%)";
	document.getElementById("deacts").innerHTML=dataArray[1]+" ("+deacts+"%)";
	document.getElementById("blcks").innerHTML=dataArray[2]+" ("+blcks+"%)";
	
  if (i == 0) {
    i = 1;
    var TotalAccountsBar = document.getElementById("TotalAccountsBar");
    var AccountTypeBar = document.getElementById("AccountTypeBar");
    var DeactivatedAccountBar = document.getElementById("DeactivatedAccountBar");
    var BlockedAccountBar = document.getElementById("BlockedAccountBar");
    var countStat = document.getElementById("countStat");
    var width = 1;
    var id = setInterval(frame, 50);
    function frame() {
	  width++;
      if (width < 101) {
        TotalAccountsBar.style.width = width + "%";
      }
	  if (width < typeAcc) {
        AccountTypeBar.style.width = width + "%";
      }if (width < deacts) {
        DeactivatedAccountBar.style.width = width + "%";
      }
	  if (width < blcks) {
        BlockedAccountBar.style.width = width + "%";
      } 
	  if(width==100) {
		width--;
        clearInterval(id);
        i = 0;
      }
    }
  }
}

function AdvSearch(pass)
{
	var keys = document.getElementById("searchTxt").value;
	var pass = pass;
	$.ajax({
	   type:'POST',
	   url:'/searchTxt',
	   data:{
		   _token : pass,
		   keyword : keys
	   },
	   success:function(data) {
		  $("#containerDiv").html(data.msg);
		  // $("#searchList").html(data.msg);
	   }
	});
}