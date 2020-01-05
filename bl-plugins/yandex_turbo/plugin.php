<?php

//Based on original Bludit rss plugin 
//author: Mirivlad
//version: 0.0.1

class pluginYandexTurbo extends Plugin {

	public function init()
	{
		// Fields and default values for the database of this plugin
		$this->dbFields = array(
			'numberOfItems'=>5,
			'xmlname' => 'turbo.xml',
		);
	}

	// Method called on the settings of the plugin on the admin area
	public function form()
	{
		global $L;
		$nameXML = $this->getValue('xmlname');
		$html  = '<div class="alert alert-primary" role="alert">';
		$html .= $this->description();
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<label>'.$L->get('path-to-xml').'</label>';
		$html .= '<a href="'.DOMAIN_BASE.$nameXML.'">'.DOMAIN_BASE.$nameXML.'</a>';
		$html .= '</div>';
		
		$html .= '<div>';
		$html .= '<label>'.$L->get('xml-file-name').'</label>';
		$html .= '<input id="xmlname" name="xmlname" type="text" value="'.$this->getValue('xmlname').'">';
		$html .= '<span class="tip">'.$L->get('xml-file-name').'<br>'.$L->get('ya-tip').'</span>';
		$html .= '</div>';
		//https://webmaster.yandex.ru/site/https:mirv.top:443/turbo/sources/
		$html .= '<div>';
		$html .= '<label>'.$L->get('Amount of items').'</label>';
		$html .= '<input id="jsnumberOfItems" name="numberOfItems" type="text" value="'.$this->getValue('numberOfItems').'">';
		$html .= '<span class="tip">'.$L->get('Amount of items to show on the feed').'</span>';
		$html .= '</div>';

		return $html;
	}
	
        private function encodeURL($url)
        {
               return preg_replace_callback('/[^\x20-\x7f]/', function($match) { return urlencode($match[0]); }, $url);
        }

	private function createXML()
	{
		global $site;
		global $pages;
		global $url;

		// Amount of pages to show
		$numberOfItems = $this->getValue('numberOfItems');
		$nameXML = $this->getValue('xmlname');
		// Get the list of public pages (sticky and static included)
		$list = $pages->getList(
			$pageNumber=1,
			$numberOfItems,
			$published=true,
			$static=true,
			$sticky=true,
			$draft=false,
			$scheduled=false
		);

		$xml = '<?xml version="1.0" encoding="UTF-8" ?>';
		$xml .= '<rss 	xmlns:yandex="http://news.yandex.ru"
						xmlns:media="http://search.yahoo.com/mrss/"
						xmlns:turbo="http://turbo.yandex.ru"
						xmlns:atom="http://www.w3.org/2005/Atom"
						version="2.0">';
		$xml .= '<channel>';
		$xml .= '<atom:link href="'.DOMAIN_BASE.$nameXML.'" rel="self" type="application/rss+xml" />';
		$xml .= '<title>'.$site->title().'</title>';
		$xml .= '<link>'.$this->encodeURL($site->url()).'</link>';
		$xml .= '<description>'.$site->description().'</description>';
		$xml .= '<lastBuildDate>'.date(DATE_RSS).'</lastBuildDate>';

		// Get keys of pages
		foreach ($list as $pageKey) {
			try {
				// Create the page object from the page key
				$page = new Page($pageKey);
				$turbo = '';
				if (Text::isNotEmpty($page->contentBreak())){
							$turbo = ' turbo="true"';
				}
				$xml .= '<item'.$turbo.'>';
				$xml .= '<title>'.$page->title().'</title>';
				$xml .= '<link>'.$this->encodeURL($page->permalink()).'</link>';
				$xml .= '<description>'.Sanitize::html($page->contentBreak()).'</description>';

				if (Text::isNotEmpty($page->content())){
					$xml .= '<turbo:content>
								<![CDATA[
									'.$page->content().'
								]]>
							</turbo:content>';
							$xml .= '<turbo:source>'.$this->encodeURL($page->permalink()).'</turbo:source>';
							$xml .= '<turbo:topic>'.$page->title().'</turbo:topic>';
							$turbo = ' turbo="true"';
				}
				
				$xml .= '<pubDate>'.date(DATE_RSS,strtotime($page->getValue('dateRaw'))).'</pubDate>';
				$xml .= '<guid isPermaLink="false">'.$page->uuid().'</guid>';
				
				$xml .= '</item>';
			} catch (Exception $e) {
				// Continue
			}
		}

		$xml .= '</channel></rss>';

		// New DOM document
		$doc = new DOMDocument();
		$doc->formatOutput = true;
		$doc->loadXML($xml);
		return $doc->save($this->workspace().$this->getValue('xmlname'));
	}

	public function install($position=0)
	{
		parent::install($position);
		return $this->createXML();
	}

	public function post()
	{
		parent::post();
		return $this->createXML();
	}

	public function afterPageCreate()
	{
		$this->createXML();
	}

	public function afterPageModify()
	{
		$this->createXML();
	}

	public function afterPageDelete()
	{
		$this->createXML();
	}

	public function siteHead()
	{
		return '<link rel="alternate" type="application/rss+xml" href="'.DOMAIN_BASE.$this->getValue('xmlname').'" title="Yandex Turbo Feed">'.PHP_EOL;
	}

	public function beforeAll()
	{
		$webhook = $this->getValue('xmlname');
		if ($this->webhook($webhook)) {
			// Send XML header
			header('Content-type: text/xml');
			$doc = new DOMDocument();

			// Load XML
			libxml_disable_entity_loader(false);
			$doc->load($this->workspace().$this->getValue('xmlname'));
			libxml_disable_entity_loader(true);

			// Print the XML
			echo $doc->saveXML();

			// Stop Bludit execution
			exit(0);
		}
	}
}
