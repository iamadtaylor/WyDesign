<?php
/*
	Archive Extractor - A Perch Hack
	By Ad Taylor - http://www.iamadtaylor.com
	For useage see :
	Creative Commons Attribution-Share Alike 2.0 UK: England & Wales Licence
*/


function archiveExtractor($contentKey,$contentPage, $limit = NULL)
{	
	$query = queryDB($contentKey,$contentPage);
	if ($query) {
		foreach ($query as $key => $value) {
			$json = $value;
		}

		return json_decode($json);
	} else {
		return NULL;
	}

}


function queryDB($contentKey,$contentPage) {
	
	require_once 'edit/config/config.php';
	
	$link = @mysql_connect(PERCH_DB_SERVER, PERCH_DB_USERNAME, PERCH_DB_PASSWORD);
	
	if (!$link) {
	    // die('Could not connect: ' . mysql_error());
		return NULL;
	}
	else {
		mysql_select_db(PERCH_DB_DATABASE,$link);
		$sql = "SELECT `contentJSON` FROM `perch_contentItems` WHERE `contentKey` LIKE '".$contentKey."' AND `contentPage` LIKE CONVERT(_utf8 '".$contentPage."' USING latin1) COLLATE latin1_swedish_ci";
		// echo $sql;
		$result = mysql_query($sql, $link);
		return mysql_fetch_assoc($result);
		mysql_close($link);
	}
}

?>