<?php

class Helper {

	public static function sort($values, $field, $order = 'ASC') {
		// do not modify original array
		$copy = array_merge(array(), $values);
		if (!empty($copy) && !isset($copy[0][$field])) {
			throw new LogicException('Field ' . $field . ' does not exist');
		}
		$neg = -1 * ($order == 'ASC' ? -1 : 1);
		uasort($copy, function($a, $b) use ($field, $neg) { list($a_, $b_) = array($a[$field], $b[$field]);
			return $a_ > $b_ ? $neg : ($a_ < $b_ ? ($neg * -1) : 0);
		});
		return $copy;
	}

}