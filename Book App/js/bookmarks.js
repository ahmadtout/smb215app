var thisSection = null;
var mydb = openDatabase("sira_db", "0.1", "A Database of Products And Deals I Like", 2*1024 * 1024);

var TABLES = {
		 bookmarks: {
						createSql: 'CREATE TABLE IF NOT EXISTS bookmarks(page_id PRIMARY KEY, subcat_id, subcatTitle, pagecontent, color);',
						primaryKey: 'page_id',
						selectSql: 'SELECT * FROM bookmarks;',
						name: 'bookmarks'
  		 				 },
		search_data: {
						createSql: 'CREATE TABLE IF NOT EXISTS search_data(page_id PRIMARY KEY, subcat_id, subcatTitle, pagecontent, color);',
						primaryKey: 'page_id',
						selectSql: 'SELECT * FROM search_data;',
						name: 'search_data'
  		 				 }				 
	
	}
	 

function loadDataBase(){
	if (window.openDatabase) {
	  //create the cars table using SQL for the database using a transaction
	  
		mydb.transaction(function(t) {
		 for (var i = 0; i < Object.keys(TABLES).length; i++) {
			 
				  (function (Table, i) {
					 
					 t.executeSql(Table.createSql);
					 
				})(TABLES[Object.keys(TABLES)[i]], i);
		 
			}//end For
		 });//End mydb.transaction
			  
	} else {
			alert("WebSQL is not supported by your browser!");
			}

}


function InsertBookmarkToDB(page_id, subcat_id,  subcatTitle, pagecontent, color){
mydb.transaction(
		function (tx) {	
	//cacheImage(SERVER_DIR+Deal.deal_img);	
	tx.executeSql("INSERT OR REPLACE INTO  bookmarks VALUES (?, ?, ?, ?, ?)",
									[ page_id,
									  subcat_id,
									  subcatTitle,
									  pagecontent,
									  color
									  ],
								function (tx, result) {  console.log("Query Success"); },
								function (tx, error) { console.log("Query Error: " + error.message); }
							 );
				hideBookMarks();			 
				});//End mydb.transaction			 
	}
	
function GetBookmarks(){
	
	currentPage = 'bookmark';
	
	$('.body-content').html('');	
	mydb.transaction(function(t) {
			var data=[];
			
			//get Categories
				query="SELECT * FROM bookmarks  ";
				t.executeSql(query, [], ResultsCategories, function (tx, error) { console.log("Query Error: " + error.message); });	

			function  ResultsCategories(transaction, results) {
								   
								  var HTML="";
								  for (i = 0; i < results.rows.length; i++)  
									{ 
									   var row = results.rows.item(i);
									   HTML = HTML+ GenerateBookmarksHTML(row.page_id, row.subcat_id,  row.subcatTitle, row.pagecontent, row.color);
									   
									}
							 $('.body-content').html(HTML);	  
									 
							}	 	
        });	//End mydb.transaction
		
	}
	
function GenerateBookmarksHTML(page_id, subcat_id, subcatTitle, pagecontent, color){
	var _template='<div class="gray-bg section page-section" style="background-color:'+color+'" onclick="goToPageBook('+page_id+','+subcat_id+')" >'+
				'	<h2 class="cat-item-title">'+subcatTitle+'</h2>'+
				'	<p>'+pagecontent+'</p>'+
				' </div>';
							
			return 	_template;		
}
	
function bookrmarkthis(){
	InsertBookmarkToDB(thisSection.attr('page_id'),thisSection.attr('subcat_id') ,   thisSection.attr('subcatTitle') , thisSection.attr('pagecontent') , thisSection.attr('color')  );
	$('.bookMarks-message').text(saved_bookmarks_msg).fadeIn().delay(2000).fadeOut();
	}	
	
function bookrmarkTOPLET(thisOBJ){
	thisSection = $(thisOBJ).closest('.page-section');
	InsertBookmarkToDB(thisSection.attr('page_id'),thisSection.attr('subcat_id') ,   thisSection.attr('subcatTitle') , thisSection.attr('pagecontent') , thisSection.attr('color')  );
	$('.bookMarks-message').text(saved_bookmarks_msg).fadeIn().delay(2000).fadeOut();
	console.log(thisSection);
	$('#page'+thisSection.attr('page_id')).find('.bookmark-icon').removeClass('fa-bookmark-o').addClass('fa-bookmark');
	}			
	
	
function goToPageBook(page_id, subcat_id){
	
$( ".body-content" ).load( "pages/"+subcat_id+".html", function() {
 
	$("html, body").animate({ scrollTop: $('#page'+page_id).offset().top -50}, 1000);
	
	  afterLoadDo();  
   
});
	}
	
/** Drop Tables from Database -  **/
function dropAllTables(TABLES){
	 mydb.transaction(function(t) {
	for (var i = 0; i < Object.keys(TABLES).length; i++) {
		 
		  (function (Table, i) {
    
       		 t.executeSql("DROP TABLE "+ Table.name);
   			 
        })(TABLES[Object.keys(TABLES)[i]], i);
		 
	  }//end For
	 });//End mydb.transaction
	}
	
function markexistBookmarks(){	
	mydb.transaction(function(t) {
			var data=[];
			
			//get Categories
				query="SELECT * FROM bookmarks  where subcat_id = '"+currentPage+"'";
				console.log(query);
				t.executeSql(query, [], ResultsCategories, function (tx, error) { console.log("Query Error: " + error.message); });	

			function  ResultsCategories(transaction, results) {
				for (i = 0; i < results.rows.length; i++)  
				{ 	
					var row = results.rows.item(i);
					console.log(row);
					$('#page'+row.page_id).find('.bookmark-icon').removeClass('fa-bookmark-o').addClass('fa-bookmark'); 
				}
			}	 	
        });	//End mydb.transaction
	
	}	
	
function sharex(type){
	if(type=="fb")
	{
	 
	window.open(' http://www.facebook.com/dialog/feed?app_id=911435602296559'+ '&link='+encodeURIComponent('http://andalusimedia.com/')+'&name=' + encodeURIComponent(thisSection.attr('subcatTitle')) +
				'&description=' + encodeURIComponent( thisSection.attr('pagecontent')) , '_system');
	}
	else{
		window.open('http://twitter.com/intent/tweet?text='+ encodeURIComponent( thisSection.attr('pagecontent')) , '_system');
		}
	}	
	
function copysection(){
	thisSection.attr('pagecontent');
	try {
    var successful = document.execCommand('copy');
    var msg = successful ? 'successful' : 'unsuccessful';
    console.log('Copying text command was ' + msg);
  } catch (err) {
    console.log('Oops, unable to copy');
  }
	}
	
	
 
		
		
		function CopyToClipboard() {
			var text = thisSection.attr('pagecontent');
  var textArea = document.createElement("textarea");

  //
  // *** This styling is an extra step which is likely not required. ***
  //
  // Why is it here? To ensure:
  // 1. the element is able to have focus and selection.
  // 2. if element was to flash render it has minimal visual impact.
  // 3. less flakyness with selection and copying which **might** occur if
  //    the textarea element is not visible.
  //
  // The likelihood is the element won't even render, not even a flash,
  // so some of these are just precautions. However in IE the element
  // is visible whilst the popup box asking the user for permission for
  // the web page to copy to the clipboard.
  //

  // Place in top-left corner of screen regardless of scroll position.
  textArea.style.position = 'fixed';
  textArea.style.top = 0;
  textArea.style.left = 0;

  // Ensure it has a small width and height. Setting to 1px / 1em
  // doesn't work as this gives a negative w/h on some browsers.
  textArea.style.width = '2em';
  textArea.style.height = '2em';

  // We don't need padding, reducing the size if it does flash render.
  textArea.style.padding = 0;

  // Clean up any borders.
  textArea.style.border = 'none';
  textArea.style.outline = 'none';
  textArea.style.boxShadow = 'none';

  // Avoid flash of white box if rendered for any reason.
  textArea.style.background = 'transparent';


  textArea.value = text;

  document.body.appendChild(textArea);

  textArea.select();

  try {
    var successful = document.execCommand('copy');
    var msg = successful ? 'successful' : 'unsuccessful';
    console.log('Copying text command was ' + msg);
  } catch (err) {
    console.log('Oops, unable to copy');
  }

  document.body.removeChild(textArea);
  $('.bookMarks-message').text(saved_copy_msg).fadeIn().delay(2000).fadeOut();
  hideBookMarks();
}

 