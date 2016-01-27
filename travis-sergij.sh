#!/bin/bash
# Local Travis :-)
find . \( -name '*.php' \) -exec php -lf {} \;
/Users/serhiiosadchyi/node_modules/jshint/bin/jshint .
/Users/serhiiosadchyi/node_modules/jscs/bin/jscs .
/Users/serhiiosadchyi/pear/bin/phpcs -p -s -v -n . --standard=./codesniffer.ruleset.xml --extensions=php