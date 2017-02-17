#!/bin/bash
#
CURCWD=$(pwd)
(
  cd functional/
  echo ' '
  echo -e "\\033[38;5;93m === Terminal Test \\033[38;5;123m Funtional PHP 5 \\033[38;5;93m === \\033[38;0m ";
  echo ' '
  php index.php
  echo " "
  echo ' '
  echo -e "\\033[38;5;93m === Terminal Test \\033[38;5;123m Funtional PHP 7 \\033[38;5;93m === \\033[38;0m ";
  echo ' '
  php index.php7
  echo " "
  echo -e "\\033[38;5;93m === Server Test \\033[38;5;123m Funtional PHP 5 Serve \\033[38;5;93m === \\033[38;0m ";
  echo " "
  echo "http://localhost:9000/extra"
  echo "http://localhost:9000/template"
  echo " "
  echo " Control C to do next test"
  echo " "
  php -S localhost:9000 -f index.php
  wait
  echo " "
  echo -e "\\033[38;5;93m === Server Test \\033[38;5;123m Funtional PHP 7 Serve \\033[38;5;93m === \\033[38;0m ";
  echo " "
  echo "http://localhost:9090/extra"
  echo "http://localhost:9090/template"
  echo " "
  php -S localhost:9090 -f index.php7
  wait
  echo " "
  echo " "
)
##cd $CURCWD;
(
  cd oop/classes5
  echo ' '
  echo -e "\\033[38;5;99m === Terminal Test \\033[38;5;125m OOP PHP 5 \\033[38;5;99m === \\033[38;0m ";
  echo ' '
  php index.php
  echo " "
  echo " "
  echo -e "\\033[38;5;99m === Server Test \\033[38;5;125m OOP PHP 5 Serve \\033[38;5;99m === \\033[38;0m ";
  echo " "
  echo "http://localhost:9000/extra"
  echo "http://localhost:9000/template"
  echo " "
  echo " Control C to do next test"
  echo " "
  php -S localhost:9000 -f index.php
  wait

)
#cd $CURCWD;
(
  cd oop/classes7
  echo ' '
  echo -e "\\033[38;5;99m === Terminal Test \\033[38;5;125m OOP PHP 7 \\033[38;5;99m === \\033[38;0m ";
  echo ' '
  php index.php7
  echo " "
  echo -e "\\033[38;5;99m === Server Test \\033[38;5;125m OOP PHP 7 Serve \\033[38;5;99m === \\033[38;0m ";
  echo " "
  echo "http://localhost:9090/extra"
  echo "http://localhost:9090/template"
  echo " "
  php -S localhost:9090 -f index.php7
  wait
  echo " "
  echo " "
)
