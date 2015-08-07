#!/bin/bash

set -e $DRUPAL_TI_DEBUG

drupal_ti_ensure_drupal

cd "$DRUPAL_TI_DRUPAL_DIR"
drush dl composer_manager --yes
chmod +x modules/composer_manager/scripts/init.sh
./modules/composer_manager/scripts/init.sh
cd "$DRUPAL_TI_DRUPAL_DIR/core"
# rm -rf vendor
# composer drupal-rebuild
# composer update --prefer-source -n --verbose
