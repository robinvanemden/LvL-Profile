$(document).ready(function(){

	//Featured  Sliding
	$('#ddblock-1 .ddblock-content').hover(function(){
		$(".view-front-featured .views-field-field-teaser-title-value", this).stop().animate({bottom:'55px'},{queue:false,duration:300});},
	function() {
	$(".view-front-featured .views-field-field-teaser-title-value", this).stop().animate({bottom:'-46px'},{queue:false,duration:300});
		});

	$('#ddblock-1 .ddblock-content').hover(function(){
		$(".view-front-featured .views-field-field-teaser-description-value", this).stop().animate({bottom:'0'},{queue:false,duration:300});},
	function() {
	$(".view-front-featured .views-field-field-teaser-description-value", this).stop().animate({bottom:'-103px'},{queue:false,duration:300});
		});

});