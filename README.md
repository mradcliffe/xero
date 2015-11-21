# Xero Module

[![Build Status](https://travis-ci.org/mradcliffe/xero.svg?branch=8.x-1.x)](https://travis-ci.org/mradcliffe/xero)

This module provides classes to help interface with the Xero Account SaaS product. You will need to be familiar with the [Xero API](http://developer.xero.com).

The module provides a factory class which instantiates XeroClient, an extension of Guzzle Client. This allows you to make requests to the Xero API via Guzzle. As well, all of Xero types are mapped out as a TypedData replacing the old `xero_make` system, and the raw JSON or XML can be fed into Serializer to normalize and denormalize data.

## XeroBundle

Xero module now requires [BlackOptic\XeroBundle](https://github.com/james75/XeroBundle) instead of PHP-Xero. This requires dowmnloading the dependency with Composer either with [Composer Manager](http://drupal.org/project/composer_manager) module or by [managing Drupal with Composer](https://www.drupal.org/node/2404989) itself. Do not attempt to enable the module without installing the dependencies first or the Symfony container will crash.

With Composer Manager:
   - `drush composer-manager-init` or `./modules/composer_manager/scripts/init.sh`
   - `cd core`
   - `composer drupal-update`

## Using XeroQuery to fetch into TypedData

The `xero.query` service is a HTTP query builder built for Xero that is similar to the Database API.

```
  $query = \Drupal::get('xero.query');

  $contacts = $query
    ->setType('xero_contact')
    ->addCondition('Contact.FirstName', 'John')
    ->execute();

  foreach ($contacts as $contact) {
    $mail = $contact->get('Email')->getValue();
  }
```

## Using XeroClient to fetch into TypedData manually

It is advised to use dependency injection to retrieve the `xero.client` and `serializer` services. This example assumes that this is stored in an object variable called `client` and serializer is `serializer`.

```
  try {
    // Do Guzzle things.
    $options = array('query' => array('where' => 'Contact.FirstName = John'));
    $response = $this->client->get('Contacts', array(), $options);

    // Do Serializer things. The context array must have a key plugin_id with
    // the plugin id of the data type because Drupal.
    $context = array('plugin_id' => 'xero_contact');
    $contacts = $this->serializer->deserialize($response->getBody()->getContent(), 'Drupal\xero\Plugin\DataType\Contact', 'xml', $context);

    // Contacts is a list item and can be iterated through like an entity or
    // other typed data.
    foreach ($contacts as $contact) {
      $mail = $contact->get('Email')->getValue();
    }
  }
  catch (RequestException $e) {
    // Do Logger things.
  }
```

## Using TypedData to post to Xero

Previously the Xero Make system allowed to create associative arrays. This has been modified to use the TypedData API. Each Xero Type is implemented as a data type.

```
  $typedDataManager = \Drupal::typedDataManager();

  // Xero likes lists, so it's a good idea to create a the list item for an
  // equivalent xero data type using typed data manager.
  $definition = $typedDataManager->createListDataDefinition('xero_invoice');
  $invoices = $typedDataManager->create($definition, 'xero_invoice');

  foreach ($invoices as $invoice) {
    $invoice->setValue('ACCREC');
    // etc...
  }

  $query = \Drupal::service('xero.query');

  $response_data = $query
    ->setType('xero_invoice')
    ->setMethod('post')
    ->setData($invoices)
    ->execute();
```

## Caching Data

The Xero API for Drupal will keep a cache of objects if you use the `XeroQuery::getCache()` method. This is a simple way to grab all accounts, contacts, etc... frequently used in forms.

The cache will be invalidated immediately, which means that it will be cleared at the next Drupal cache clear.

```
  $query = \Drupal::service('xero.query');
  $contacts = $query->getCache('Contacts');
```

Note: at this time it is not possible to filter these queries.


## Form Helper

Xero API Module provides a form element helper service that will return form elements for a given Xero data type. This also works with any data type.

Currently the form helper does not support populating data from Xero into a select list.

```
  $formBuilder = \Drupal::service('xero.form_builder');
  
  // Build an entire nested array for valid elements for an account type.
  $form['Account'] = $formBuilder->getElementFor('xero_account');
  
  // Build an autocomplete textfield for contacts.
  $definition = \Drupal::service('typed_data_manager')->createDataDefinition('xero_contact');
  $form['ContactID'] = $formBuilder->getElementForDefinition($definition, 'ContactID');
```

## Theming Typed Data

- Not implemented yet.

```
  Although you're probably using Xero you may want to display data
  such as contacts, invoices, and credit notes. These php templates
  also use theme functions for line items and addresses respectively.

  <?php
    $output = theme('xero_contact', $contact);
  ?>
```

## Xero Data Types

- Todo: more documentation like in Drupal 6 and 7.

```
  A xero type is a data type as defined by the Xero Developer API. Xero API now
  supports xero types in the following manner:

  %xero_type menu wildcard will load an associative array of information about
  a given type. Please consult xero_get_data_types() for more information as
  this does not contain all data types.

  The autocomplete path has been reduced to one path using the above wildcard
  argument. The autocomplete key is the Xero data type name and not the plural
  key. See below.

  Type information refers to either the key returned by Xero's Restful API, or
  the Drupal Xero API title/key for Form API.

    - name: The key to use for Form API.
    - title: The title to use for Form API.
    - guid: The GUID key for a Xero type.
    - label: The human-readable key for a Xero type. If empty, guid will be used.
    - plural: The plural key for a Xero type.

    Example (Contacts):

      'name' => 'Contact',
      'title' => 'Contact',
      'guid' => 'ContactID',
      'label' => 'Name',
      'plural' => 'Contacts',
```
