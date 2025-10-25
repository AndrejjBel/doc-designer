<?php

namespace App\Content;
use Hleb\Static\Request;

class Breadcrumb
{
	private static $_items = array();

	public static function add($url, $name, $last_element=1)
	{
		self::$_items[] = array($url, $name, $last_element);
	}

	public static function out()
	{
		// $separator = '<span class="breadcrumbs-separator">
		// 	<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
		// 	<path d="M8.99854 11.8577C8.99854 11.0248 9.26181 10.3403 9.78835 9.80418C10.3245 9.26806 11.0329 9 11.9137 9C12.7849 9 13.4933 9.26327 14.039 9.78982C14.5847 10.3068 14.8575 11.0104 14.8575 11.9008V12.4321C14.8575 13.265 14.5943 13.9447 14.0677 14.4713C13.5412 14.9978 12.8279 15.2611 11.928 15.2611C11.0377 15.2611 10.3245 14.9978 9.78835 14.4713C9.26181 13.9352 8.99854 13.2459 8.99854 12.4034V11.8577Z" fill="#d7d7d7"/>
		// 	</svg>
		// 	</span>';
		$separator = '<span class="breadcrumbs-separator">
		<svg width="6" height="6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
		<path d="M64 320C64 178.6 178.6 64 320 64C461.4 64 576 178.6 576 320C576 461.4 461.4 576 320 576C178.6 576 64 461.4 64 320z" fill="#d7d7d7"/>
		</svg></span>';
		$res = '<div class="breadcrumb" itemscope="" itemtype="http://schema.org/BreadcrumbList" id="breadcrumbs">
			<span class="breadcrumb-item" itemscope="" itemprop="itemListElement" itemtype="http://schema.org/ListItem">
				<a href="/" itemprop="item">
					Главная
					<meta itemprop="name" content="Главная">
				</a>
				<meta itemprop="position" content="1">
			</span>';

		$i = 1;
		foreach (self::$_items as $row) {
			$res .= $separator;
            if ($row[2]) {
                $res .= '<span class="breadcrumb-item" itemscope="" itemprop="itemListElement" itemtype="http://schema.org/ListItem">
    				<a href="' . $row[0] . '" itemprop="item">
    					' . $row[1] . '
    					<meta itemprop="name" content="' . $row[1] . '">
    				</a>
    				<meta itemprop="position" content="' . ++$i . '">
    			</span>';
            } else {
                $res .= '<span class="breadcrumb-item active" itemscope="" itemprop="itemListElement" itemtype="http://schema.org/ListItem">
                    <span>' . $row[1] . '</span>
    				<meta itemprop="position" content="' . ++$i . '">
					<meta itemprop="item" content="' . home_url() . $row[0] . '">
    			</span>';
            }
		}
		$res .= '</div>';
		return $res;
	}
}
