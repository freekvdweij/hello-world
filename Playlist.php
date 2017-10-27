<!DOCTYPE html>
<html>
<body>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript" src="https://kadevgraaf.github.io/SGvizler-example/sgvizler.js"></script>
    <script>
         sgvizler
             .prefix("ex", "http://example.org#")
             .defaultEndpointURL("https://dbpedia.org/sparql")
             .defaultQuery("SELECT * { ?a ?b ?c, ?d, ?e } LIMIT 7")
             .defaultChartFunction("sgvizler.visualization.Table")
             .defaultChartWidth(650)
             .defaultChartHeight(325);
    </script>
</head>

<div class = "whitebox">
	<span>
		<a class = 'big' style="text-decoration:none" href="http://lindebaaijens.nl/BKWMusicRecommendation/StartingPage.php"> BKW</a>
	</span>
	<span>
	 <a class = 'small' style="text-decoration:none" href="http://lindebaaijens.nl/BKWMusicRecommendation/StartingPage.php" >Music Recommendation</a>
	</span>
</div>

<form class = "box2" action="Playlist.php" method="get">
	<span style = "padding-left: 30px ; ">
	 <input class = "search2" name= search type="text" value="Search">
	</span>
	<span style = "padding-left: 50px ; "> 
		<select name = type class = "dropdown">
		  <option value="single">Single</option>
		  <option value="album">Album</option>
		  <option value="artist">Artist</option>
		</select></span>
	<span style = "padding-left: 50px ; "> 
		<input class = "button" type="submit" value="Create Playlist!">
	</span>
</form>

<div id="parent">
  <div class  = "playlist" id="wide">
  	<center style = 'color: white; font-size: 30px;'>Recommended Tracks</center>
  	<center style = 'color: white; font-size: 20px;'><?php
  	echo 'You have searched for songs related to the ' . $_GET["type"]. ' '.$_GET["search"]
  	?></center>
  	<div id="myElementID"></div>
  </div>
  <div class = "description" id="narrow" ><center style = 'color: white; font-size: 30px;'>Description</center><div id = "myElementID2"> </div> </div>
</div>
<script>   
 //    var url = "http://localhost:5820/final_project/query?reasoning=true"; 
 //    var query = "select * where {?sub ?pred ?obj} limit 10";

 // $.ajax({
 //        headers : {
 //            Accept: 'application/sparql-results+json'
 //        }, 
 //        url: url,
 //        data: {
 //            query: query
 //        },
 //        success: function(data) {
 //            var results = data.results.bindings;
 //            document.write(results);
 //        }
 //    });

    var Q = new sgvizler.Query();                  // Create a Query instance.
    var search1 = "dbpedia:" + <?php echo str_replace(' ', '_', json_encode($_GET['search'])) ?>; 
    
    var searchtype = <?php echo json_encode($_GET["type"])?>;
    if (searchtype == "single") {
          var query = "PREFIX dbo: <http://dbpedia.org/ontology/>\
              PREFIX dbpedia: <http://dbpedia.org/resource/>\
              SELECT ?song ?artist WHERE{{ " + search1 + " dbo:genre ?q.\
              ?a dbo:genre ?q. \
              ?a rdf:type dbo:Single.\
              ?a dbo:musicalArtist ?p.\
              ?a rdfs:label ?song.\
              ?p rdfs:label ?artist.}\
              UNION {\ " 
              + search1 + " dbo:musicalArtist ?a .\
              ?b dbo:musicalArtist ?a.\
              ?b rdf:type dbo:Single.\
              ?b rdfs:label ?song.\
              ?a rdfs:label ?artist.\
              } }";
    } else if (searchtype == 'album') {
          var query = "PREFIX dbo: <http://dbpedia.org/ontology/>\
              PREFIX dbpedia: <http://dbpedia.org/resource/>\
              SELECT ?song ?artist WHERE{{?s dbo:album " + search1 +".\
                        ?s dbo:musicalArtist ?q.\
                        ?q dbo:genre ?o .\
                        ?t dbo:genre ?o . \
                        ?t dbo:musicalArtist ?p .\
                        ?t rdf:type dbo:Single.\
                        ?t rdfs:label ?song .\
                        ?p rdfs:label ?artist.} \
                        UNION {\
                        ?s dbo:album " + search1 + ".\
                        ?s dbo:musicalArtist ?g.\
                        ?b dbo:musicalArtist ?g.\
                        ?b rdf:type dbo:Single.\
                        ?b rdfs:label ?a.\
                        ?g rdfs:label ?f.\
                        } } " ;
     } else if (searchtype == 'artist') {
          var query = "PREFIX dbo: <http://dbpedia.org/ontology/>\
              PREFIX dbpedia: <http://dbpedia.org/resource/>\
              SELECT ?song ?artist WHERE{{?p dbo:musicalArtist " + search1 +".\
                        ?p dbo:musicalArtist ?r.\
                        ?p rdfs:label ?song .\
                        ?r rdfs:label ?artist}\
                      UNION {\ "
                      + search1+ " dbo:genre ?x .\
                      ?q rdf:type dbo:Single . \
                      ?q dbo:genre ?x.\
                      ?q dbo:musicalArtist ?r.\
                      ?q rdfs:label ?song.\
                      ?r rdfs:label ?artist\
                      } }";


        }



    
    // Values may also be set in the sgvizler object---but will be
    // overwritten here.
    Q.query(query)
        .endpointURL("http://localhost:5820/final_project/query?reasoning=true")
        .endpointOutputFormat("json")                      // Possible values 'xml', 'json', 'jsonp'.
        .chartFunction("google.visualization.Table")       // The name of the function to draw the chart.
        .draw("myElementID");                              // Draw the chart in the designated HTML element.


    var Q2 = new sgvizler.Query();                  // Create a Query instance.
    var search1 = "dbpedia:" + <?php echo str_replace(' ', '_', json_encode($_GET['search'])) ?>; 
    
    var searchtype = <?php echo json_encode($_GET["type"])?>;
    if (searchtype == "single") {
          var query2 = "PREFIX dbo: <http://dbpedia.org/ontology/>\
              PREFIX dbpedia: <http://dbpedia.org/resource/>\
              SELECT ?Genres_ReleaseDate_Artist  WHERE{{ " + search1 + " dbo:genre ?q.\
              ?q rdfs:label ?Genres_ReleaseDate_Artist.\
              } UNION {\ "
               + search1 + "  dbo:releaseDate ?Genres_ReleaseDate_Artist.\
               } UNION {\ "
               + search1 + "  dbo:musicalArtist ?q.\
               ?q rdfs:label ?Genres_ReleaseDate_Artist .\
           } }  ";
    } else if (searchtype == 'album') {
          var query2 = "PREFIX dbo: <http://dbpedia.org/ontology/>\
              PREFIX dbpedia: <http://dbpedia.org/resource/>\
              SELECT ?Genres_ReleaseDate_Artist  WHERE{{ ?s dbo:album " + search1 + ".\
              ?s dbo:musicalArtist ?q .\
              ?q rdfs:label ?Genres_ReleaseDate_Artist.\
              } UNION { ?s dbo:album " + search1 + ".\
              ?s dbo:genre ?x.\
              ?x rdfs:label ?Genres_ReleaseDate_Artist.\
           } }  ";
    } else if (searchtype == 'artist') {
          var query2 = "PREFIX dbo: <http://dbpedia.org/ontology/>\
              PREFIX dbpedia: <http://dbpedia.org/resource/>\
              SELECT ?Genres_ReleaseDate_Artist  WHERE{{ " + search1+ " dbo:genre ?a.\
              ?a rdfs:label ?Genres_ReleaseDate_Artist.\
              } UNION { ?s dbo:musicalArtist " + search1 + ".\
              ?s dbo:album ?x.\
              ?x rdfs:label ?Genres_ReleaseDate_Artist.\
              } UNION { " + search1 + " dbo:concertDate ?Genres_ReleaseDate_Artist.\
              } UNION { " + search1 + " dbo:concertLocation ?Genres_ReleaseDate_Artist.\
           } }  ";
    }
        // Values may also be set in the sgvizler object---but will be
    // overwritten here.
    Q2.query(query2)
        .endpointURL("http://localhost:5820/final_project/query?reasoning=true")
        .endpointOutputFormat("json")                      // Possible values 'xml', 'json', 'jsonp'.
        .chartFunction("google.visualization.Table")       // The name of the function to draw the chart.
        .draw("myElementID2");                              // Draw the chart in the designated HTML element.


   </script>
     






</body>
</html>