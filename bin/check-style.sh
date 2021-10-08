#!/usr/bin/env bash

PHPCSFIXER='bin/php-cs-fixer' 
echo "Correction styles des fichiers ajoutés et modifiés"
echo $'\e[1;32m'"# php-cs-fixer"$'\e[0m'
REPOSITORY_GIT=`git remote -v | grep -i KAIRIOS/rest-pagination | awk '{print $1}' | tail -n1`
FICHIERS=`git diff --diff-filter=AMRC --name-only $(git merge-base $REPOSITORY_GIT/main HEAD) | grep -e '^src' -e '^tests' | grep -e '.php$' | tr '\n' ' '`
if [ '' == "$FICHIERS" ]; then
FICHIERS=`git status --porcelain | grep -E src | grep -e '.php$' | grep -E '^(M|A)' | cut -c 3- | tr '\n' ' '`
fi

echo "Fichiers vérifiés : "$'\e[1;33m'"$FICHIERS"$'\e[0m'

if [ '' == "$FICHIERS" ]; then
echo $'\e[1;33m'Aucun fichier à modifier$'\e[0m'
exit 0;
fi

if [ "$1" != "force" ]; then
echo $'\e[1;33m'!! Mode dry run$'\e[0m'
"$PHPCSFIXER" fix --dry-run -vv --config=.php-cs-fixer.dist.php $FICHIERS
if [ "0" != "$?" ]; then
echo $'\e[1;31m'Merci de corriger le style de ces fichiers$'\e[0m'
exit 1;
fi
echo $'\e[1;32m'PHP-CS-FIXER : Tout est ok ! ^^$'\e[0m'
exit 0
fi

"$PHPCSFIXER" fix --config=.php-cs-fixer.dist.php $FICHIERS
exit $?
