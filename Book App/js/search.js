// JavaScript Document
function searchtext(){
	var word = $('#search').val();
	
	$('.search-error').hide();
 	//check condition
	if(word.length<3)
	{
		$('.search-error').show();
		return;
	}
 
 
 	$('.search_form').hide();
	$('.search_loading').show();
	
 
	var final_res = [];
	var res=[];	
	for (var i=1; i<=19; i++)
	{
		
		$.ajax({
		  url: "pages/"+i+".html",
		  async:false,
		  dataType:"html",
		  success: function( data ) {
			 res.push(data);
		  }
		});
	}
	
	
	//console.log(res);
	 //clear all data before inserting again 
	 mydb.transaction(
		function (tx) {	
	//cacheImage(SERVER_DIR+Deal.deal_img);	
	tx.executeSql("DELETE FROM  search_data",[],								 
								function (tx, result) {  console.log("Clear search Success"); },
								function (tx, error) { console.log("Clear search Error: " + error.message); }
							 );
			 	 
				});//End mydb.transaction	
	 //end clear data
	 //console.log(res[0]);
	 res.forEach(function(entry) {
		     var queue = $.parseHTML(entry);
			// console.log(queue);
			 var curr;
			 
			 while (curr = queue.pop()) {
			if (!curr.textContent.match(word)) continue;
			for (var i = 0; i < curr.childNodes.length; ++i) {
				switch (curr.childNodes[i].nodeType) {
					case Node.TEXT_NODE : // 3
						if (curr.childNodes[i].textContent.match(word)) {
							//console.log("Found!");
							//console.log(curr);
							//console.log(curr.closest('.page-section'));
							var res_item = curr.closest('.page-section');
							if(res_item)
								final_res.push(res_item);	//saveSearch($(res_item));//
							// you might want to end your search here.
						}
						break;
					case Node.ELEMENT_NODE : // 1
						queue.push(curr.childNodes[i]);
						break;
				}
			}
		}

		 
	});//end foreach res
	 

//console.log(final_res);
final_res.forEach(function(entry) {
	// console.log(entry);
	saveSearch($(entry));
	 }); 
	 
GoSearchedPage();	 
}

function saveSearch(thisSection){
	InsertSearchToDB(thisSection.attr('page_id'),thisSection.attr('subcat_id') ,   thisSection.attr('subcatTitle') , thisSection.attr('pagecontent') , thisSection.attr('color')  );
	
	}	
	
function InsertSearchToDB(page_id, subcat_id,  subcatTitle, pagecontent, color){
mydb.transaction(
		function (tx) {	
	//cacheImage(SERVER_DIR+Deal.deal_img);	
	tx.executeSql("INSERT OR REPLACE INTO  search_data VALUES (?, ?, ?, ?, ?)",
									[ page_id,
									  subcat_id,
									  subcatTitle,
									  pagecontent,
									  color
									  ],
								function (tx, result) {  console.log("Query Success"); },
								function (tx, error) { console.log("Query Error: " + error.message); }
							 );
							 
				});//End mydb.transaction			 
	}	
	
	
function GoSearchedPage(){
	
	currentPage = 'searchpage';
	
	$('.body-content').html('');	
	mydb.transaction(function(t) {
			var data=[];
			
			//get Categories
				query="SELECT * FROM search_data  ";
				t.executeSql(query, [], ResultsCategories, function (tx, error) { console.log("Query Error: " + error.message); });	

			function  ResultsCategories(transaction, results) {
								   
								  var HTML="";
								  for (i = 0; i < results.rows.length; i++)  
									{ 
									   var row = results.rows.item(i);
									   HTML = HTML+ GenerateSearchHTML(row.page_id, row.subcat_id,  row.subcatTitle, row.pagecontent, row.color);
									   
									}
								if(HTML=="")
								 $('.body-content').html("<h1 align='center' dir='rtl' >لا توجد نتائج ...</h1>");
								 else
								 {		
								 var word=$('#search').val();
								   HTML = HTML.replace(new RegExp(word, 'g'), "<span class='highlighted'>" + word + "</span>");
								  $('.body-content').html(HTML);	
								  $('.row-offcanvas').removeClass('active');
								 }
							 $('.search_form').show();
							 $('.search_loading').hide(); 
							 $("#display_search").modal('hide');
									 
							}	 	
        });	//End mydb.transaction
		
	}	
	
function GenerateSearchHTML(page_id, subcat_id, subcatTitle, pagecontent, color){
	var _template='<div class="gray-bg section page-section" style="background-color:'+color+'" onclick="goToPageBook('+page_id+','+subcat_id+')" >'+
				'	<h2 class="cat-item-title">'+subcatTitle+'</h2>'+
				'	<p>'+pagecontent+'</p>'+
				' </div>';
							
			return 	_template;		
}
		