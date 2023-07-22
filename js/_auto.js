var autoLogoutTimer;
resetTimer();
$(document).on('mouseover mousedown touchstart click keydown mousewheel DDMouseScroll wheel scroll',document,function(e){
     console.log(e.type); // Uncomment this line to check which event is occured
    resetTimer();
});
// resetTimer is used to reset logout (redirect to logout) time 
function resetTimer(){ 
    clearTimeout(autoLogoutTimer)
    autoLogoutTimer = setTimeout(idleLogout,3000) // 1000 = 1 second
} 
// idleLogout is used to Actual navigate to logout
function idleLogout(){
    window.location.href = '../logout/index.php'; // Here goes to your logout url 
}