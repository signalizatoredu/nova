#!/bin/sh

rm -rf classes/
rm -rf css/
rm -rf files/
rm -rf graphs/
rm -rf images/
rm -rf js/
rm -rf namespaces/
rm -rf output/
rm -rf reports/
rm -f index.html
rm -rf code/

git clone git@github.com:nohatssir/nova.git code

phpdoc -c phpdoc.dist.xml

