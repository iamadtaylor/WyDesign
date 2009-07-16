<?php

class PerchForm
{
    var $html_encode    = true;
    
	var $required	= array();
	var $validate	= array();
	var $messages	= array();
	var $error		= false;
	
	var $display_only	= false;
	var $allow_edits	= true;
	var $name	 		= false;
	var $force_clear	= false;
	
	var $csrf_token     = false;
	
	var $fields		= array();


	function __construct($name=false, $display_only=false, $allow_edits=true)
	{
		$Perch  = PerchAdmin::fetch();
		
		$this->name			= $name;
		$this->display_only = $display_only;
		$this->allow_edits 	= $allow_edits;
		
		if (isset($_GET['editform']) && $_GET['editform']==$this->name) {
			$this->display_only = false;
		}
		
		if (strpos($Perch->get_page(true), 'editform='.$this->name)>0) {
			$this->display_only = false;
		}
			
		if (!$allow_edits) {
			$this->display_only	= true;
		}
		
		// check csrf token
		if (PerchSession::is_set('csrf_token') && PerchSession::get('csrf_token')!='') {
		    $this->csrf_token = PerchSession::get('csrf_token');
		}else{
		    $this->csrf_token = md5(uniqid('csrf', true));
		    PerchSession::set('csrf_token', $this->csrf_token);
		}
		
	}
	
	
	
	function posted()
	{
		if (isset($_POST) && isset($_POST['formaction']) && $_POST['formaction'] == $this->name) {
		    // check csrf token
		    if (isset($_POST['token']) && $_POST['token']!='' && $_POST['token']==$this->csrf_token) {
    		    // generate new token
    		    $this->csrf_token = md5(uniqid('csrf', true));
    		    PerchSession::set('csrf_token', $this->csrf_token);
    		
    			$this->display_only(false);
    			return true;
    		}
		}
		return false;
	}

	function required($id)
	{		
		$data	= $this->required;
				
		if (isset($data[$id])){
			return $data[$id];
		}
		
		return false;
	}
	
	function message($id, $value)
	{
		if ($this->error == true){
			if (trim($value) === ''){
				return ' <span class="error">' . $this->html(PerchLang::get($this->required($id))) . '</span> ';
			}
			if (isset($this->messages[$id])){
				return ' <span class="error">' . $this->html(PerchLang::get($this->messages[$id])) . '</span> ';
			}
		}
		
		return ' <span class="required">*</span> ';

		
	}
	
	function error($id, $class=true)
	{
	    if ($this->error == true){
	        if ($this->required($id) && (!isset($_POST[$id]) || trim($_POST[$id]) === '')) {
	            if ($class) return ' class="error"';
	            return ' error';
	        }
	    }
	    
	    return '';
	}
	
	function display_only($display_only=false) {
		$this->display_only = $display_only;
	}
	
	function clear()
	{
		$this->force_clear	= true;
	}
	
	function is_valid($id, $value)
	{
		$r= true;
		
		$args = array();
		if (isset($value[2])) $args = $value[2];
		
		switch ( $value[0] )
		{
			case 'email':
				$r	= $this->check_email($id, $args);
			break;
			
			case 'username':
				$r	= $this->check_username($id, $args);
			break;
			
			case 'password':
				$r	= $this->check_password($id, $args);
			break;
					
			default:
				# code...
			break;
		}
		
		if (!$r) $this->messages[$id]	= $value[1];
		return $r;
	}
	
	function validate()
	{
		$this->error	= true;
		$r				= true;
		
		//check required
		foreach($this->required as $key => $value) {
			if (!isset($_POST[$key]) || $_POST[$key]==''){
				$r	= false;
			}	
		}
		
		//run validations
		foreach($this->validate as $key => $value) {
			if (isset($_POST[$key]) && !$_POST[$key]==''){
				if (!$this->is_valid($key, $value)) {
				 	$r	= false;
				}
			}	
		}
		
	
		return $r;
	}

	function set_required($data)
	{
		$this->required	= $data;
	}
	
	function set_validation($data)
	{
		$this->validate = $data;
	}
	
	private function check_password($id, $args)
	{
	    
		$str 	= $_POST[$id];
		$str2	= $_POST[$id.'2'];
		
		if ($str != $str2){
			return false;
		}
		return true;
	}
	
	private function check_email($id, $args)
	{
		$email 	= $_POST[$id];
		
		$Users = new PerchUsers;
		
		// check for a passed in UserID
		// so that a user can be excluded from the check
		// (so we don't prevent editing of a record)
		if (isset($args['userID'])) {
		    $exclude_userID = $args['userID'];
		}else{
		    $exclude_userID = false;
		}
		
		if (!PerchUtil::is_valid_email($email) || PerchUtil::contains_bad_str($email) || !$Users->email_available($email, $exclude_userID)){
			return false;
		}
		return true;
	}
    
    private function check_username($id, $args)
	{
		$str 	= $_POST[$id];
		
		$Users = new PerchUsers;
		
		// check for a passed in UserID
		// so that a user can be excluded from the check
		// (so we don't prevent editing of a record)
		if (isset($args['userID'])) {
		    $exclude_userID = $args['userID'];
		}else{
		    $exclude_userID = false;
		}
		
		if (!$Users->username_available($str, $exclude_userID)){
			return false;
		}
	
		
		return true;
	}
    

	function get($array, $key, $default='', $POSTprefix=false)
	{
		if ($POSTprefix) {
			$postkey	= $POSTprefix.$key;
		}else{
			$postkey	= $key;
		}
		
		if (isset($_POST[$postkey])){
			return $_POST[$postkey];
		}else{
			if (isset($array) && isset($array[$key])){
				return $array[$key];
			}
		}
		
		return $default;
	}
	
	function find_items($prefix, $keys_only=false)
	{
		$out	= array();
		
		foreach($_POST as $key=>$val) {
			
			if (strpos($key, $prefix)===0) {
				$key	= str_replace($prefix, '', $key);
				if ($keys_only) {
				    $out[]  = $key;
				}else{
				    $out[$key]	= $val;  
				}
				
			}
			
		}
		
		return $out;
		
	}
	
	function hint($txt)
	{
		return '<span class="hint">'.$this->html($txt).'</span>';
	}

	function label($id, $txt, $class='', $colon=false, $translate=true)
	{
	    if ($translate) $txt = PerchLang::get($txt);
	    
		if ($this->display_only) return '<span class="label">'.$this->html($txt).($colon?':':'').'</span>';
		
		return '<label for="'.$this->html($id).'" class="'.$this->html($class).'">'.$this->html($txt).($colon?':':'') . '</label>';
	}
	
	function text($id, $value='', $class='', $limit=false)
	{
		$this->fields[] = $id;
		
		if ($this->display_only) return $this->html($this->value($value));
		
		if ($limit !== false) {
		    $limit = ' maxlength="'.intval($limit).'"';
		}else{
		    $limit = '';
		}
		
		$s	= '<input type="text" id="'.$this->html($id).'" name="'.$this->html($id).'" value="'.$this->html($this->value($value)).'" class="text '.$this->html($class).'"'.$limit.' />';
	
		if ($this->required($id)){
			$s	.= $this->message($id, $value);
		}
		
		return $s;
	}

	function password($id, $value='', $class='')
	{
		$this->fields[] = $id;
		
		if ($this->display_only) return $this->html($value);
		
		$s	= '<input type="password" id="'.$this->html($id).'" name="'.$this->html($id).'" value="'.$this->html($this->value($value)).'" class="text '.$this->html($class).'" />';
	
		if ($this->required($id) || isset($this->messages[$id])){
			$s	.= $this->message($id, $value);
		}
		
		return $s;
	}
	
	function hidden($id, $value='')
	{
		$this->fields[] = $id;
		
		if ($this->display_only) return '';
		
		$s	= '<input type="hidden" id="'.$this->html($id).'" name="'.$this->html($id).'" value="'.$this->html($value).'" />';		
		return $s;
	}


	function select($id, $array, $value, $class='')
	{
			
		$this->fields[] = $id;
		if ($this->display_only && trim($value)=='') return 'No selection';
		
		$s	= '<select id="'.$this->html($id).'" name="'.$this->html($id).'" class="'.$this->html($class).'">';
		
		for ($i=0; $i<PerchUtil::count($array); $i++){
			$s .= '<option value="'.$this->html($array[$i]['value']).'"';
			
			if ($array[$i]['value'] == $this->value($value)){
				$s .= ' selected="selected"';
			}
			
			$s .='>'.$this->html($array[$i]['label']).'</option>';
			
			if ($this->display_only && $array[$i]['value'] == $value) {
				return $this->html($array[$i]['label']);
			}
		}
		
		$s	.= '</select>';
		
		if ($this->required($id)){
			$s	.= $this->message($id, $value);
		}
		
		
		return $s;
	}
	
	function datepicker($id, $value=false)
	{
		$this->fields[] = $id;
		
		if ($this->display_only){
			if ($value) { 
				return date('d M Y', strtotime($value));
			}else{
				return '';
			}
		}
		
		$s	 = '';
				
		$value	= ($this->value($value) ? $this->value($value) : date('Y-m-d'));

		$d			= array();
		$d['day']	= date('d', strtotime($value));
		$d['month']	= date('m', strtotime($value));
		$d['year']	= date('Y', strtotime($value));

		// Day
		$days	= array();
		for ($i=1; $i<32; $i++) $days[]	= array('label'=>PerchUtil::pad($i), 'value'=>PerchUtil::pad($i));
		$s		.= $this->select($id.'_day', $days, $d['day']);
		
		// Month
		$months	= array();
		for ($i=1; $i<13; $i++) $months[]	= array('label'=>date('M', strtotime('2007-'.PerchUtil::pad($i).'-01')), 'value'=>PerchUtil::pad($i));
		$s		.= $this->select($id.'_month', $months, $d['month']);
		
		// Year
		$years	= array();
		for ($i=date('Y')-100; $i<date('Y')+11; $i++) $years[]	= array('label'=>$i, 'value'=>$i);
		$s		.= $this->select($id.'_year', $years, $d['year']);
		
		
		return $s;
		
		
	}
	
	function datetimepicker($id, $value=false)
	{
		$this->fields[] = $id;
		
		if ($this->display_only){
			if ($value) { 
				return date('d M Y h:m', strtotime($value));
			}else{
				return '';
			}
		}
		
		$s	 = '';
				
		$value	= ($this->value($value) ? $this->value($value) : date('Y-m-d'));

		$d			= array();
		$d['day']	= date('d', strtotime($value));
		$d['month']	= date('m', strtotime($value));
		$d['year']	= date('Y', strtotime($value));
		$d['hour']	= date('H', strtotime($value));
		$d['minute']= date('i', strtotime($value));
		
		// Day
		$days	= array();
		for ($i=1; $i<32; $i++) $days[]	= array('label'=>PerchUtil::pad($i), 'value'=>PerchUtil::pad($i));
		$s		.= $this->select($id.'_day', $days, $d['day']);
		
		// Month
		$months	= array();
		for ($i=1; $i<13; $i++) $months[]	= array('label'=>date('M', strtotime('2007-'.PerchUtil::pad($i).'-01')), 'value'=>PerchUtil::pad($i));
		$s		.= $this->select($id.'_month', $months, $d['month']);
		
		// Year
		$years	= array();
		for ($i=date('Y')-100; $i<date('Y')+11; $i++) $years[]	= array('label'=>$i, 'value'=>$i);
		$s		.= $this->select($id.'_year', $years, $d['year']);
		
		// Hours
		$hours	= array();
		for ($i=0; $i<24; $i++) $hours[]	= array('label'=>PerchUtil::pad($i), 'value'=>PerchUtil::pad($i));
		$s		.= $this->select($id.'_hour', $hours, $d['hour']);
		
		// Minutes
		$minutes	= array();
		for ($i=0; $i<60; $i++) $minutes[]	= array('label'=>PerchUtil::pad($i), 'value'=>PerchUtil::pad($i));
		$s		.= $this->select($id.'_minute', $minutes, $d['minute']);
		
		
		return $s;
		
		
	}
	
	function checkbox($id, $value, $checked, $class='')
	{
		$this->fields[] = $id;
		
		if ($this->display_only){
			if ($value == $checked){
				return 'Yes';
			}else{
				return 'No';
			}
		}
		
		$s	= '<input type="checkbox" class="check '.$this->html($class).'" id="'.$this->html($id).'" name="'.$this->html($id).'" value="'.$this->html($this->value($value)).'"';

		if ($value == $checked){
			$s .= ' checked="checked"';
		}
		
		$s .= ' />';
		
		
		
		return $s;
	}
	
	function radio($id, $group, $value, $checked, $class='')
	{
		$this->fields[] = $id;
		
		if ($this->display_only){
			if ($value == $checked){
				return 'Yes';
			}else{
				return 'No';
			}
		}
		
		$s	= '<input type="radio" class="check '.$this->html($class).'" id="'.$this->html($id).'" name="'.$this->html($group).'" value="'.$this->html($this->value($value)).'"';

		if ($value == $checked){
			$s .= ' checked="checked"';
		}
		
		$s .= ' />';
		
		
		
		return $s;
	}
	
	function textarea($id, $value='', $class='')
	{
		$this->fields[] = $id;
		
		if ($this->display_only) return nl2br($this->html($value));
		
		$s	= '<textarea id="'.$this->html($id).'" name="'.$this->html($id).'"  class="text '.$this->html($class).'" rows="6" cols="40">'.$this->html($this->value($value)).'</textarea>';
	
		if ($this->required($id)){
			$s	.= $this->message($id, $value);
		}
		
		return $s;
	}
	
	function submit($id, $value, $class=false)
	{
		$Perch  = PerchAdmin::fetch();
		
		if ($this->display_only) {
			if ($this->allow_edits) {
				$segments	= str_replace('/editform='.$this->name, '', split('/', $Perch->get_page(true)));
				$segments[]	= 'editform='.$this->name;
				$url		= implode('/', $segments);
				$url		= str_replace('//', '/', $url);
			
				return '<a href="'.$url.'" class="button" id="'.$this->html($id).'">Edit</a>';
			}
			
			return '';
		
		}
		
		$s = '<input type="submit" name="'.$this->html($id).'" id="'.$this->html($id).'" value="'.$this->html(PerchLang::get($value)).'" class="'.$class.'" />';
		$s .= '<input type="hidden" name="formaction" value="'.$this->html($this->name).'" />';
		$s .= '<input type="hidden" name="token" value="'.$this->html(PerchSession::get('csrf_token')).'" />';
		
		return $s;
	}
	
	function image($id, $value='', $basePath='', $class='')
	{
		if ($this->display_only) {
			if ($value) return '<img src="'.$this->html($basePath . $value).'" />';
			return '';
		}
		
		$s	= '<input type="file" id="'.$this->html($id).'" name="'.$this->html($id).'" value="'.$this->html($this->value($value)).'" class="text '.$this->html($class).'" />';
	
		if ($this->required($id)){
			$s	.= $this->message($id, $value);
		}
		
		return $s;
	}
	
	function get_date($id, $postitems=false)
	{
		$out	= '';
		
		if ($postitems === false) $postitems = $_POST;
		
		$day	= (isset($postitems[$id . '_day'])    ? $postitems[$id . '_day']    : false);
		$month	= (isset($postitems[$id . '_month'])  ? $postitems[$id . '_month']  : false);
		$year	= (isset($postitems[$id . '_year'])   ? $postitems[$id . '_year']   : false);
		$hour	= (isset($postitems[$id . '_hour'])   ? $postitems[$id . '_hour']   : false);
		$minute	= (isset($postitems[$id . '_minute']) ? $postitems[$id . '_minute'] : false);
		
		if ($day!==false && $month!==false && $year!==false) {
			$out = "$year-$month-$day";
			
			if ($hour!==false && $minute!==false) {
				$out .= ' ' . PerchUtil::pad($hour) . ':' . PerchUtil::pad($minute) . ':00';
			}

			return $out;
		}
	
		return false;
	}
	


		
	function check_alpha($id)
	{
		$str 	= $_POST[$id];
		if (preg_match('/^[A-Za-z0-9_]*$/', $str)==0){
			return false;
		}
		return true;
	}


		
	function show_fields()
	{
		$s 	= '<textarea rows="16" cols="80">';
		
		$s 	.= '$req = array();' . "\n";
		
		if (is_array($this->fields)) {
			foreach ($this->fields as $field){
				$a[] = "'" . $field . "'";
			
				$s	.= '$req[\''.$field.'\'] = "Required";' . "\n";
			}
		}
		$s	.= '$Form->set_required($req);' . "\n";
		
		$s  .= 'if ($Form->posted() && $Form->validate()) {' . "\n";
		
		$s	.=  "\t" . '$postvars = array('.implode(', ', $a) . ');' . "\n";
		$s  .= "\t" .  '$data = $Form->receive($postvars);' . "\n";

		$s  .= '}' . "\n";
		
		$s  .= '</textarea>';
		return $s;
	}
	
	function action()
	{
		$Perch  = PerchAdmin::fetch();
		
		return str_replace('/editform='.$this->name, '', $Perch->get_page(true));

	}
	
	private function value($value)
	{
		if ($this->force_clear) return '';
		return stripslashes($value);
	}
	
	public function scaffold($DB, $table, $prefix)
	{
		$cols	= $DB->get_table_meta($table);
		
		$s = '';
		
		if (is_array($cols)) {
			foreach($cols as $col) {
				
				if ($col->name != $prefix.'ID') {
				
					$s	.= '<div>' . "\n";
				
					$s	.= "\t" . '<' . '?php echo $Form->label(\'' . $col->name . '\', \'' . str_replace($prefix, '', $col->name) . '\'); ?' . '>' . "\n";
					
					switch ($col->type) {
						case 'blob':
							$s	.= "\t" . '<' . '?php echo $Form->textarea(\'' . $col->name . '\', $Form->get(@$details, \'' . $col->name . '\'), \'large\'); ?' . '>' . "\n";
							break;
						
						default:
							$s	.= "\t" . '<' . '?php echo $Form->text(\'' . $col->name . '\', $Form->get(@$details, \'' . $col->name . '\')); ?' . '>' . "\n";
							break;
					}				
					
				
					$s	.= '</div>' . "\n\n";
				}
				
			}
		}
	
	
		return '<textarea rows="16" cols="80">' . $s . '</textarea>';
		
	}
	
	public function receive($postvars)
	{
	    $data = array();
	    foreach($postvars as $val) if (isset($_POST[$val])) $data[$val]	= trim($_POST[$val]);
	    
	    return $data;
	}
	
	public function field_completed($field)
	{
	    if (isset($_POST[$field]) && $_POST[$field] != '') {
	        return true;
	    }
	    
	    return false;
	}
	
	private function html($str)
	{
	    if ($this->html_encode) {
	        return PerchUtil::html($str);
	    }else{
	        return $str;
	    }   
	}
	
	public function disable_html_encoding()
	{
	    $this->html_encode  = false;
	}
	
	public function enable_html_encoding()
	{
	    $this->html_encode  = true;
	}
	
	public function enctype()
	{
	    return 'enctype="multipart/form-data"';
	}
	
	public function reset()
	{
    	$this->messages	= array();
    	$this->error	= false;
	}
	
}


?>