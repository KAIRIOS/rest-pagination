#!/bin/bash
GREEN='\033[0;32m'
RED='\033[0;31m'
WHITE='\033[0;37m'
RESET='\033[0m'
echo -e "${WHITE}>> LANCEMENT DES TESTS UNITAIRES${RESET}"

php vendor/bin/atoum -d tests/units
if [ 0 -lt $? ]; then
echo -e "${RED}Echec des tests unitaires ${RESET}"
exit 1;
fi
echo -e "${GREEN}>> Tests unitaires OK${RESET}"
