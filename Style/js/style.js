$(document).ready(function (){
  $('#AreYouSure,.AreYouSure').click(function(){
    var applyAreYouSure = window.confirm('آیا مطمئن هستید ؟');
    if(applyAreYouSure == true)
      return true;
    else
      return false;
  });
});
function startTime(){
  var today = new Date();
  var h = today.getHours();
  var m = today.getMinutes();
  var s = today.getSeconds();
  m = checkTime(m);
  s = checkTime(s);
  document.getElementById('now-time').innerHTML = h + ":" + m + ":" + s;
  var t = setTimeout(startTime,500);
}
function checkTime(i){
  if (i < 10) {i = "0" + i};
  return i;
}