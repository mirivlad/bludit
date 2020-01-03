<?php

//Based on original Bludit tags plugin 
//author: Mirivlad
//version: 0.0.1

class pluginTagsPlus extends Plugin {

	public function init()
	{
		$this->dbFields = array(
			'label'=>'Tags'
		);
	}

	public function form()
	{
		global $L;

		$html  = '<div class="alert alert-primary" role="alert">';
		$html .= $this->description();
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<label>'.$L->get('Label').'</label>';
		$html .= '<input id="jslabel" name="label" type="text" value="'.$this->getValue('label').'">';
		$html .= '<span class="tip">'.$L->get('This title is almost always used in the sidebar of the site').'</span>';
		$html .= '</div>';

		return $html;
	}

	public function siteSidebar()
	{
		global $L;
		global $tags;
		global $url;

		$filter = $url->filters('tag');

		$html  = '<div class="plugin plugin-tags">';
		$html .= '<h2 class="plugin-label">'.$this->getValue('label').'</h2>';
		$html .= '<div class="plugin-content">';
		$html .= '<div style="width: 90%; word-wrap: normal;">';
		$size = "1em";
		// By default the database of tags are alphanumeric sorted
		foreach( $tags->db as $key=>$fields ) {
			if (count($fields['list'])<= 5){
				$size = "0.6em";
			}elseif(count($fields['list'])>5 && count($fields['list'])<= 10){
				$size = "0.7em";
			}elseif(count($fields['list'])>10 && count($fields['list'])<= 20){
				$size = "0.9em";
			}elseif(count($fields['list'])>20 && count($fields['list'])<= 30){
				$size = "1em";
			}else{
                $size = "1.2em";
			}
			$html .= '';
			$html .= '<a href="'.DOMAIN_TAGS.$key.'" title="'.count($fields['list']).'" style="font-size:'.$size.';">';
			$html .= $fields['name'];
			$html .= '</a>';
			$html .= ' ';
		}

		$html .= '</div>';
 		$html .= '</div>';
 		$html .= '</div>';

		return $html;
	}
}
