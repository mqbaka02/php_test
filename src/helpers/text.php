<?php
namespace App\Helpers;

class Text {

	public static function excerpt(string $content, int $limit= 60){
		// if(mb_strlen()) for unicode characters strlen() for simple characters
		if(mb_strlen($content)< $limit){
			return $content;
		}
		return mb_substr($content, 0, $limit) . "...";
	}

	public static function excerpt_no_word_cut(string $content, int $limit= 60){
		// if(mb_strlen()) for unicode characters strlen() for simple characters
		if(mb_strlen($content)< $limit){
			return $content;
		}
		$lastSpace= mb_strpos($content, ' ', $limit);
		return mb_substr($content, 0, $lastSpace) . "...";
	}
}