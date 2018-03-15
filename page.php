<?php 
	require ('connect.php');
	$id = $_POST['lastId'];
	if($id > 0){
		$sql = "SELECT * FROM news WHERE id < $id 
		ORDER BY id DESC LIMIT 10";
		$result = ($conn->query($sql))->fetchAll();
		$last_id = end($result)['id'];

		foreach($result as $news){
			$string = $news['title'];
	        if(strlen($string) > 140){
	          $stringCut = substr($string, 0, 140);
	          $string = $stringCut.'...';
	        }
	        $timestamp = strtotime($news['date']);
                  $catdate = "&nbsp;&nbsp;&nbsp;&nbsp;".date('d', $timestamp)."-".date('m',$timestamp)."-".(int)(date('Y', $timestamp) + 543);
                  $string .= $catdate;
	        $string = iconv("UTF-8", "UTF-8//IGNORE", $string);
	        echo "<tr><td><a id=\"".$news['id']."\"href=\"news_form.php?id=".$news['id']."\" target=\"_blank\" class=\"font-color4\">". $string."</a></td></tr>";
	     }
	    if($last_id > 1){
	    	echo "<tr>".$last_id;
	   	}
	}
?>