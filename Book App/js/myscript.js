var CordX=null;

function hideSplash2(){
	$('.splash2').fadeOut();
	}
function MyDeviceReady(){
	setTimeout(hideSplash2, 8000);
	 loadDataBase();
	 
	 $.event.special.swipe.horizontalDistanceThreshold = 15;
	 
	 $( ".body-content" ).load( "pages/homepage.html", function() {
		 //alert( "Load was performed." );
		
	     
	});
		
$('[data-toggle="offcanvas"]').click(function () {
    $('.row-offcanvas').toggleClass('active')
  });
  
  
   // Bind the swipeHandler callback function to the swipe event on div.box
  //$( ".body-content" ).on( "swipeleft", swipeleftHandler );
  $( ".body-content" ).on( "swiperight", swiperightHandler );
 $('.body-content').click(swiperightHandler);
  // Callback function references the event target and adds the 'swipe' class to it
  function swipeleftHandler( event ){
	  $( '.row-offcanvas').addClass( "active" );
	 // console.log(event);
   
  }
  function swiperightHandler( event ){
     $( '.row-offcanvas').removeClass( "active" );
	//  console.log(event);
  }
  
  
 
 var font_sizeSlider = $("#font_size").slider({
	 ticks:[1,2,3,4],
	 value: 1
	 
	 
	 });

$("#font_size").on("slide click change", function(slideEvt) {
	
	 var fontx = slideEvt.value;
if (fontx instanceof Object  ) {
  // code for objects
  fontx = fontx.newValue;
}
	
	if(fontx==1)
	{
		$('body').removeClass("font-small font-md font-lg font-xlg");
		$('body').addClass("font-small");
	}
	
	if(fontx==2)
	{
		$('body').removeClass("font-small font-md font-lg font-xlg");
		$('body').addClass("font-md");
	}
	
	if(fontx==3)
	{
		$('body').removeClass("font-small font-md font-lg font-xlg");
		$('body').addClass("font-lg");
	}
	if(fontx==4)
	{
		$('body').removeClass("font-small font-md font-lg font-xlg");
		$('body').addClass("font-xlg");
	}
	
	
});	 
		
 		
	 
var mySlider = $("#brightness").slider({
	 ticks:[1,2],
	 value: 1
	 
	 });	
	 
	
$("#brightness").on("slide click change", function(slideEvt) {
 console.log( slideEvt.value);
 
 var bright = slideEvt.value;
if (bright instanceof Object  ) {
  // code for objects
  bright = bright.newValue;
}
	
	
	if(bright==1)
	{
		$('body').removeClass("bright0 bright1 bright2");
		$('body').addClass("bright0");
	}
	
	if(bright==2)
	{
		$('body').removeClass("bright0 bright1 bright2");
		$('body').addClass("bright1");
	}
	
	if(bright==3)
	{
		$('body').removeClass("bright0 bright1 bright2");
		$('body').addClass("bright2");
	}
});	 
	  
  
  
document.addEventListener('deviceready', function() {
    var exitApp = false, intval = setInterval(function (){exitApp = false;}, 1000);
    document.addEventListener("backbutton", function (e){
        e.preventDefault();
        if (exitApp) {
            clearInterval(intval) 
            (navigator.app && navigator.app.exitApp()) || (device && device.exitApp())
        }
        else {
            exitApp = true;
			if(currentPage=='bookmark')
				loadLastPage()
			else
            	loadPage('homepage');
        } 
    }, false);
}, false);
  
  
  ///update location page 
   $(window).bind('scroll', function() {
	 
	   if(!isNaN(currentPage))
	  {   
		lastlocation = $(window).scrollTop();
		//console.log(lastlocation);
		localStorage.setItem('lastlocation', lastlocation); 
	  }
   });
  //end update location page 
  
  
}//end mydevice ready

function showBookMarks(){
	$('.bookMarksAndSettings').fadeIn();
	}

function hideBookMarks(){
	$('.bookMarksAndSettings').fadeOut();
	}	

function loadLastPage(){
	 
	  name =  (localStorage.getItem('lastPageLocation'))? localStorage.getItem('lastPageLocation') : 1;
	  currentPage = name;
	   $( ".body-content" ).load( "pages/"+name+".html", function() {
	   lastlocation = localStorage.getItem('lastlocation');
	 
	   $(window).scrollTop(lastlocation); 
	   afterLoadDo();  
	});
	
	
}

function loadPage(name){
	
	 if(!isNaN(name))
	localStorage.setItem('lastPageLocation', name); 
	
	currentPage = name;
	
	   $( ".body-content" ).load( "pages/"+name+".html", function() {
 

  $(window).scrollTop(0);
  afterLoadDo();
  	   
	   
});

 
	}	
	
function afterLoadDo(){
	
	markexistBookmarks();
	 $('.row-offcanvas').removeClass('active');
	 
	 $(".carousel-ahdas").swiperight(function() {  
    		  $(this).carousel('prev');  
	    		});  
		   $(".carousel-ahdas").swipeleft(function() {  
		      $(this).carousel('next');  
	   });
 
 $(document).on('mousedown', function(event){
    CordX = event.originalEvent.pageY;
});

	$('.page-section').bind('taphold', function(e) {
		thisSection = $(this);
		$('.bookMarksAndSettings').css("top",CordX).fadeIn();
	} );
	 
}	

function loadPageWithAfterFunction(name, afterFunction){

$( ".body-content" ).load( "pages/"+name+".html", function() {
	
	$('.row-offcanvas').removeClass('active');
	$(window).scrollTop(0);
	$(".carousel-ahdas").swiperight(function() {  
    		  $(this).carousel('prev');  
	    		});  
		   $(".carousel-ahdas").swipeleft(function() {  
		      $(this).carousel('next');  
	   });
	 window[afterFunction]();
});
	}
	
function SelectTabsHomePage()
{
	$("#commentsTab").trigger('click')
	
	}	

function sendRating(){
	var name=$('#name').val();
	var country=$('#country').val();
	var gender= $("input:radio[name=gender]:checked" ).val();
	var rate= $("input:radio[name=rate]:checked" ).val();
	var notes=$('#notes').val();
	
	$.ajax({
		type: "GET",
	  url: SERVER_URL+"getrating.php",
	  data: {
		name: name,
		country:country,
		gender: gender,
		rate: rate,
		notes:notes
		
	  },
	  success: function( res ) {
		//console.log(res);
		loadPage('thankyou');
	  }
	});
	}
	

function getRating(){
	$.ajax({
		type: "GET",
	  url: SERVER_URL+"rating.php",
	  data: {
		
	  },
	  success: function( res ) {
		//console.log(res);
		$('.rating-body').html(res);
		$('.row-offcanvas').removeClass('active');
	  },
	   error: function (xhr, ajaxOptions, thrownError) {
        $('.rating-body').html('<h3 align="center">تحقق من الإتصال بالإنترنت</h3>');
		$('.row-offcanvas').removeClass('active');
      }
	});
	}	

function getOtherbooks(){
	$.ajax({
		type: "GET",
	  url: SERVER_URL+"otherbooks.php",
	  data: {
		
	  },
	  success: function( res ) {
		//console.log(res);
		$('.body-content').html(res);
		$('.row-offcanvas').removeClass('active');
	  },
	   error: function (xhr, ajaxOptions, thrownError) {
        $('.body-content').html('<h3 align="center">تحقق من الإتصال بالإنترنت</h3>');
		$('.row-offcanvas').removeClass('active');
      }
	});
	}		
	
function loadPageaudio(){
	if(navigator.onLine)
		loadPage('audios');
	else
	{
		loadPageWithAfterFunction('audios', 'hideNotExistAudio');
		
		//$('.row-offcanvas').removeClass('active');
	 	//$('.body-content').html('<h3 align="center">تحقق من الإتصال بالإنترنت</h3>');
	}
}

function hideNotExistAudio(){
	$('.audio-item').hide();
	$('.audio-item a').hide();
	$('.audio-item').each(function(index, element) {
        var filename = $(element).find('.track').attr('filename');
		getMP3(filename, function(entry){
		 
			if(entry != "http://andalusimedia.com/sound/"+filename)
			{
				$(element).show();
				 
			}
			})
		
		
    });
	}

function downloadmp3(name){
$('.download-message').text(download_msg).fadeIn().delay(2000).fadeOut();
var fileTransfer = new FileTransfer();
var uri = encodeURI("http://andalusimedia.com/sound/"+name);
var fileURL = "cdvfile://localhost/persistent/sira/"+name;
fileTransfer.download(
    uri,
    fileURL,
    function(entry) {
        console.log("download complete: " + entry.toURL());
    },
    function(error) {
        console.log("download error source " + error.source);
        console.log("download error target " + error.target);
        console.log("download error code" + error.code);
    },
    false,
    {
        headers: {
            "Authorization": "Basic dGVzdHVzZXJuYW1lOnRlc3RwYXNzd29yZA=="
        }
    }
);
}

function getMP3(name, callback)
{

	resolveLocalFileSystemURL("cdvfile://localhost/persistent/sira/"+name, 
		function(entry) {
				var nativePath = entry.toURL();
				callback(nativePath);
			}, 
		function(error) {
			callback("http://andalusimedia.com/sound/"+name);
		});
 
}
 

 

 