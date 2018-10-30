{dede:list  pagesize="500" col="1" titlelen="60" orderby="pubdate" orderway="desc" 	
 channel="1"  keyword="" }<url>	
   <loc>[field:arcurl function="Gmapurl(@me)"/]</loc> 	
   <title>[field:title function="HtmlReplace(@me)"/]</title>	
   <news:news>	
  <news:keywords>[field:keywords/]</news:keywords>	
 <news:publication_date>[field:senddate function="strftime("%Y-%m-%d",@me)"/]</news:publication_date>	
 </news:news>	
</url>{/dede:list}