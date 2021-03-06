<?php

/**
 * The MIT License
 * 
 * Copyright (c) 2009 Ian Zepp
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 * 
 * @author Ian Zepp
 * @package 
 */

/** Process startup */
global $_ARGUMENTS, $_PARAMS, $argv;
$_ARGUMENTS = array ();
$_PARAMS = array ();

while ($argv) {
	$argument = array_shift ($argv);
	$matches = array ();
	
	if (preg_match ('/^--([^\s=]+)(=(.+))?$/', $argument, $matches)) {
		$_ARGUMENTS [$matches [1]] = $matches [3];
	} else {
		$_PARAMS [] = $argument;
	}
}

/** Validate the script arguments */
global $_ARGUMENTS;

if (!array_key_exists ("beanConfig", $_ARGUMENTS)) {
	exit ("Missing required argument: --beanConfig");
}

if (!array_key_exists ("bean", $_ARGUMENTS)) {
	exit ("Missing required argument: --bean");
}

/** Load the beans */
$beanContainer = new Appenda_Bundle_BeanContainer ();
$beanContainer->processConfig ($_ARGUMENTS ["beanConfig"]);

/** Start the message processing */
$bean = $beanContainer->findBean ($_ARGUMENTS ["bean"]);
$bean->getBeanInstance ()->processMessages ();

// Done!

