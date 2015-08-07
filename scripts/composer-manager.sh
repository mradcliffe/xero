#!/bin/bash

set -e $DRUPAL_TI_DEBUG

cd "$DRUPAL_TI_DRUPAL_DIR"
git clone --depth 1 --branch 8.x-1.x https://git.drupal.org/project/composer_manager.git modules/composer_manager
chmod +x modules/composer_manager/scripts/init.sh
./modules/composer_manager/scripts/init.sh
cd "$DRUPAL_TI_DRUPAL_DIR/core"
rm -rf vendor
composer drupal-rebuild
composer update --prefer-source -n --verbose
