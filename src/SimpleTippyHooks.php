<?php

namespace MediaWiki\Extension\SimpleTippy;

use Html;
use MediaWiki\Hook\ParserFirstCallInitHook;
use MediaWiki\MediaWikiServices;
use Parser;
use Sanitizer;
use Wikimedia\IDLeDOM\HTMLElement;

class SimpleTippyHooks implements ParserFirstCallInitHook
{
	/** @inheritDoc */
	public function onParserFirstCallInit($parser)
	{
		$parser->setFunctionHook('tooltip', [__CLASS__, 'displayTooltip']);
	}

	/**
	 * Parser function handler
	 *
	 * @param Parser $parser
	 * @param string $text
	 * @param string $content
	 * @return array
	 */
	public static function displayTooltip(Parser $parser, string $text, string $content)
	{
		$parser = MediaWikiServices::getInstance()->getParser();

		$content = Sanitizer::removeSomeTags($content);
		$content = $parser->recursiveTagParseFully($content);
		$content = str_replace('"', "'", $content);
		$content = trim($content);
		$content = htmlspecialchars($content);

		$text = $parser->recursiveTagParse($text);

		// we can't use Html::element due to attributes escaping
		$html = '<span class="simple-tippy-tooltip" ' .
			'data-tippy-content="' . $content . '"' .
			'>' . $text . '</span>';

		$parser->getOutput()->addModules(['ext.simpletippy.core']);

		return [
			$html,
			'noparse' => true,
			'isHTML' => true,
			'markerType' => 'nowiki'
		];
	}

}
