<?php

namespace RentASwag\SilverStripeModules;

class DataObjectShortcuts {

	/**
	 * @param $class string Type of DataObject to get
	 * @param $filters int|array ID or array of filters
	 * @return \DataObject
	 * @throws \SS_HTTPResponse_Exception
	 */
	public static function get_object_or_404($class, $filters) {
		return self::get_list_or_404($class, $filters)->first();
	}

	/**
	 * @param $class string Type of DataObject to get
	 * @param $filters int|array ID or array of filters
	 * @return \DataObject
	 * @throws \SS_HTTPResponse_Exception
	 */
	public static function get_list_or_404($class, $filters) {
		if (class_exists($class)) {
			if(!is_array($filters)) $filters = ['ID' => (int)$filters];
			$list = \DataObject::get($class)->filter($filters);
			if($list->exists()) return $list;
		}

		// Doesn't exist, throw appropriate error
		if (class_exists('ErrorPage')) {
			return \ErrorPage::response_for(404)->output();
		} elseif ($controller = \Controller::curr()) {
			$controller->httpError(404);
		} else {
			throw new \SS_HTTPResponse_Exception('Not Found', 404);
		}
	}

}