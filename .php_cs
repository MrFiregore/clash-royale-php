<?php
	
	$finder = PhpCsFixer\Finder::create()
	                           ->in(__DIR__)
	;
	
	return PhpCsFixer\Config::create()
	                        ->setRules([
		                                   '@PSR2' => true,
		                                   '@PhpCsFixer' => true,
		                                   'indentation_type' => true,
		                                   'braces' => ['position_after_functions_and_oop_constructs' => 'same'],
	                                   ])
		->setIndent("    ")
	                        ->setFinder($finder)
		;