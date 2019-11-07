<?php

$SPLIT_PATTERN_SHORTHANDSYNTAX_ARRAY_PARTS = '/
		(?P<ArrayPart>                                                      # Start sub-match of one key and value pair
			(?P<Key>                                                        # The arry key
				 [a-zA-Z0-9_-]+                                             # Unquoted
				|"(?:\\\\"|[^"])+"                                          # Double quoted
				|\'(?:\\\\\'|[^\'])+\'                                      # Single quoted
			)
			\\s*[:=]\\s*                                                    # Key|Value delimiter : or =
			(?:                                                             # BEGIN Possible value options
				(?P<QuotedString>                                           # Quoted string
					 "(?:\\\\"|[^"])*"
					|\'(?:\\\\\'|[^\'])*\'
				)
				|(?P<VariableIdentifier>
					(?:(?=[^,{}\.]*[a-zA-Z])[a-zA-Z0-9_-]*)                 # variable identifiers must contain letters (otherwise they are hardcoded numbers)
					(?:\\.[a-zA-Z0-9_-]+)*                                  # but in sub key access only numbers are fine (foo.55)
				)
				|(?P<Number>[0-9]+(?:\\.[0-9]+)?)                           # A hardcoded Number (also possibly with decimals)
				|\\{\\s*(?P<Subarray>(?:(?P>ArrayPart)\\s*,?\\s*)+)\\s*\\}  # Another sub-array
			)                                                               # END possible value options
		)\\s*(?=\\z|,|\\})                                                  # An array part sub-match ends with either a comma, a closing curly bracket or end of string
	/x';

$arrayText = 'endpoint: \'/newsContent/{item.uid}\', parameters: {L: item.langUid} ';
$matches = [];

preg_match_all($SPLIT_PATTERN_SHORTHANDSYNTAX_ARRAY_PARTS, $arrayText, $matches, PREG_SET_ORDER);

var_dump($matches);
