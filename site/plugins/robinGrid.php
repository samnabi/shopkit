<?php
/**
 * robinGrid
 * Calculates optimal width of items across a given number of columns
 * @param  integer        $items    The number of items to arrange.
 * @param  integer|array  $columns  The maximum number of items in a row. Use an array for multiple breakpoints. 
 * @param  string         $format   How the width of items is expressed. Acceptable values are 'fraction' or 'integer'.
 * @param  string         $order    How the rows are sorted. Acceptable values are 'asc' and 'desc'. ('asc' means that rows with fewer items are displayed first)
 * @return array                    One index per item. Each index will contain another array if multiple breakpoints were specified.
 * 
 * @author Sam Nabi http://github.com/samnabi
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
function robinGrid($items, $columns, $format = 'fraction', $order = 'asc') {

	// Validate input
	if (gettype($items) != 'integer') return false;
	if (!in_array(gettype($columns), ['integer','array'])) return false;
	if (!in_array($format, ['fraction','column'])) return false;
	if (!in_array($order, ['asc','desc'])) return false;

	// Prepare columns for looping
	if (gettype($columns) === 'integer') {
		// Set a flag so we can exit the function early
		$breakpoints = false;

		// Turn integer into an array
		$columns = [$columns];
	} else {
		// Initialize breakpoints array
		$breakpoints = [];
	}

	foreach ($columns as $key => $c) {
		// Split items into rows
		$rows = [];
		$i = 0;
		$num = $items;
		while ($num > 0) {
			if ($num > $c) {
				$rows[$i] = $c;
				$num = (int)$num - (int)$c;
			} else {
				$rows[$i] = $num;
				$num = 0;
			}
			// Increment counter
			$i++;
		}

		// Make sure the rows are as even as possible.
		// If there's too much inequality, steal from the rich and give to the poor.
		while (max($rows) - min($rows) > 1) {
			$rows[array_search(max($rows),$rows)]--;
			$rows[array_search(min($rows),$rows)]++;
		}

		// Sort rows
		if ($order === 'asc') sort($rows);
		if ($order === 'desc') rsort($rows);

		// Prepare the output for this breakpoint
		$output = [];
		foreach ($rows as $row) {
			$i = $row;
			while ($i > 0) {
				if ($format === 'fraction') {
					// Set output as fractions (e.g. "1-2" means half the width of the parent element)
					$output[] = '1-'.$row;
				} else if ($format === 'integer') {
					// Set output as integer number of columns (e.g. "3" means a width of 3 columns)
					$output[] = $c / $row;
				}
				$i--;
			}
		}

		if ($breakpoints === false) {
			// Finish here if $columns was an integer
			return $output;
		} else {
			// Build the breakpoints array
			$breakpoints[$key] = $output;
		}
	}

	// Combine all the breakpoints into a multidimensional array
	$output = [];
	foreach ($breakpoints[key($breakpoints)] as $i => $breakpoint) {
		// Initialize row
		$output[$i] = [];
	    foreach ($breakpoints as $b) {
	    	array_push($output[$i], $b[$i]);
	    }
	}

	// Finish here if $columns was an array
	return $output;

}