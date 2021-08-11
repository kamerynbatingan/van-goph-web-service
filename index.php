<html>
<head>
<title>Van Gogh Web Service Demo</title>
<style>
	body {font-family:georgia;}

	.film{
		border:1px solid #E77DC2;
		border-radius: 5px;
		padding: 5px;
		margin-bottom:5px;
		position:relative;	
	}
	.pic{
		position:absolute;
		right:10px;
		top:10px;
	}

</style>
<script src="https://code.jquery.com/jquery-latest.js" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function() {  

	$('.category').click(function(e){
        e.preventDefault(); //stop default action of the link
		cat = $(this).attr("href");  //get category from URL
		loadAJAX(cat);  //load AJAX and parse JSON file
	});
});	

function loadAJAX(cat)
{
   $.ajax({
       type: "GET",
       dataType: "json",
       url: "api.php?cat=" + cat,
       success: bondJSON,
       error: function(xhr, status, error){
        let errorMessage = xhr.status + ': ' + xhr.statusText
        alert('Error - ' + errorMessage);
    }
 
   });
}

    
function toConsole(data)
{//return data to console for JSON examination
	console.log(data); //to view,use Chrome console, ctrl + shift + j
}

function bondJSON(data){
//JSON processing data goes here

	//using this I can see the object in the console
	console.log(data);
	
	//this defines the type of info returned
	$('#filmtitle').html(data.title);
	
	$('#films').html('');

	
	$.each(data.paintings,function(i,item){
		let str = bondTemplate(item);

		$('<div></div>').html(str).appendTo('#films');

	});
	
	//in this way we can see all of the data on the page
	/*
	let myData = JSON.stringify(data,null,4);
	myData = '<pre>' + myData + '</pre>';
	$("#output").html(myData); 
	*/
	//this works, but the test is all bunched up
	//$("#output").text(JSON.stringify(data));
}

function bondTemplate(painting){
	return `
		<div class="film"> 
			<b>Title:</b> ${painting.Title} <br />
			<b>Date:</b> ${painting.Month} ${painting.Year} <br />
			<b>Location:</b> ${painting.Location}<br />
			<b>Material:</b> ${painting.Material}<br />
			<b>Size:</b> ${painting.Size}<br />
			<b>Credits:</b> ${painting.Credit}<br />				
			<div class="pic"><img src="thumbnails/${painting.Image}"></div>
		</div>
	`;
}

</script>
</head>
	<body>
	<h1>Van Gogh Web Service</h1>
		<a href="year" class="category">Van Gogh Paintings By Year</a><br />
		<a href="title" class="category">Van Gogh Paintings By Title</a>
		<h3 id="filmtitle">Title Will Go Here</h3>
		<div id="films">
			<!--
			<div class="film"> 
				<b>Film:</b> 1 <br />
				<b>Title:</b> Dr. No<br />
				<b>Year:</b> 1962<br />
				<b>Director:</b> Terence Young<br />
				<b>Producers:</b> Harry Saltzman and Albert R. Broccoli<br />
				<b>Writers:</b> Richard Maibaum, Johanna Harwood and Berkely Mather<br />
				<b>Composer:</b> Monty Norman<br />
				<b>Bond:</b> Sean Connery<br />
				<b>Budget:</b> $1,000,000.00<br />
				<b>Box Office:</b> $59,567,035.00<br />
				<div class="pic"><img src="thumbnails/dr-no.jpg"></div>
			</div>
			-->
		</div>
		<div id="output">Results go here</div>
	</body>
</html>
