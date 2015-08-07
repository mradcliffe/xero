#!/bin/bash

set -e $DRUPAL_TI_DEBUG

# Download Drupal because drupal-ti won't do this for us without installing
# Drupal too.
git clone --depth 1 --branch 8.0.x http://git.drupal.org/project/drupal.git "$DRUPAL_TI_DRUPAL_DIR"
cd "$DRUPAL_TI_DRUPAL_DIR"
drush use $(pwd)#default

# Download Composer Manager.
drush dl composer_manager --yes
chmod +x modules/composer_manager/scripts/init.sh
./modules/composer_manager/scripts/init.sh

# Update composer dependencies. The vendor directory has to be completely
# removed because Composer is shit.
cd "$DRUPAL_TI_DRUPAL_DIR/core"
rm -rf vendor
composer drupal-rebuild
composer update --prefer-source -n --verbose
