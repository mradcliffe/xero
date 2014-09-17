# Xero Module

This module provides classes to help interface with the Xero Account SaaS product. You will need to be familiar with the [Xero API](http://developer.xero.com).

The module provides a factory class which instantiates XeroClient, an extension of Guzzle Client. This allows you to make requests to the Xero API via Guzzle. As well, all of Xero types are mapped out as a TypedData replacing the old `xero_make` system, and the raw JSON or XML can be fed into Serializer to normalize and denormalize data.

## XeroBundle

Xero module now requires [BlackOptic\XeroBundle](https://github.com/mradcliffe/XeroBundle) instead of PHP-Xero, and this requires the [Composer Manager](http://drupal.org/project/composer_manager) module. You must run the following drush command before installing Xero: `drush composer-json-rebuild --include=xero`. This is not ideal. Drupal 8 does not have a good way of including dependencies because it does not implement Composer properly. You may also hack Drupal 8's composer.json file if you prefer to install libraries in core/vendor.

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
    $request = $this->client->get('Contacts', array(), $options);
    $response = $request->send();

    // Do Serializer things. The context array must have a key plugin_id with
    // the plugin id of the data type because Drupal.
    $context = array('plugin_id' => 'xero_contact');
    $contacts = $this->serializer->deserialize($response->getBody(TRUE), 'Drupal\xero\Plugin\DataType\Contact', 'xml', $context);

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

- Not implemented yet.

```
    The Xero API for Drupal will keep a cache of objects if you use
    the xero_get_cache method. This is a simple way of grabbing all
    Contacts, Accounts, etc... that may be frequently used in forms.

    <?php
      $contacts = xero_get_cache('Contacts');
    ?>

    Note: at this time it is not possible to send in filtering.
```

## Form Helper

- Not implemented yet. Should be supported by a module that implements TypedData API (?)

```
  The xero_form_helper method constructs Drupal Form API elements for
  various often-used items such as Contacts, Invoices, Accounts, and
  other goodies. These will use the xero_get_cache method described
  above.

  <?php
    // An autocomplete textfield for contacts.
    $form['ContactID'] = xero_form_helper('Contacts', $default_value);
  ?>

  The autocomplete matches have changed and the xero data type's label
  will be returned as part of the value of the field!

  Note that at this time it is not possible to pass in filters for
  xero_form_helper as it uses xero_get_cache.
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

## Xero Typed Data

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
