[![Build Status](https://travis-ci.org/hedii/zotero-api.svg?branch=master)](https://travis-ci.org/hedii/zotero-api)

# Zotero Api

A php wrapper for zotero web api.

## Table of contents

- [Table of contents](#table-of-contents)
- [Installation](#installation)
- [Usage](#usage)
  - [Instantiation](#instantiation)
  - [User and group libraries](#user-and-group-libraries)
  - [Items](#items)
    - [Multiple items](#multiple-items)
    - [Single item](#single-item)
    - [Top level items](#top-level-items)
    - [Items in the trash](#items-in-the-trash)
    - [Child items](#child-items)
    - [Item tags](#item-tags)
  - [Collections](#collections)
    - [Multiple collections](#multiple-collections)
    - [Single collection](#single-collection)
    - [Items in a collection](#items-in-a-collection)
    - [Top level items in a collection](#top-level-items-in-a-collection)
    - [Collection tags](#collection-tags)
    - [Sub collections](#sub-collections)
  - [Versions](#versions)
  - [Tags](#tags)
  - [Searches](#searches)
    - [Multiple searches](#multiple-searches)
    - [Single search](#single-search)
  - [Key](#key)
  - [Groups](#groups)
  - [Sorting and pagination](#sorting-and-pagination)
    - [Sorting](#sorting)
    - [Direction](#direction)
    - [Limit](#limit)
    - [Start](#start)
  - [Request timeout](#request-timeout)
  - [Connection timeout](#connection-timeout)
  - [**Sending a request and getting a response**](#sending-a-request-and-getting-a-response)
    - [Sending the request](#sending-the-request)
    - [Response body](#response-body)
    - [Response json](#response-json)
    - [Response headers](#response-headers)
    - [Response status code](#response-status-code)
    - [Response reason phrase](#response-reason-phrase)
  - [Raw query](#raw-query)
- [Examples](#examples)
- [Testing](#testing)
- [License](#license)

## Installation

Install via [composer](https://getcomposer.org/doc/00-intro.md)
```sh
composer require hedii/zotero-api
```

## Usage

### Instantiation

ZoteroApi has to be instantiated with an api key. You can generate a zotero api key [here](https://www.zotero.org/settings/keys) if you have an account on zotero.org.

```php
<?php
// require composer autoloader
require '/path/to/vendor/autoload.php';

// instantiate
$api = new Hedii\ZoteroApi\ZoteroApi('your_zotero_api_key_here');
```

### User and group libraries

Every call to zotero web api has to be made on a user or a group library (except for `key($apiKey)` method).

This is reflected on this package by the fact that you always have to call the method `user($userId)` or the method `group($groupId)` at the beginning of each call.

```php
$api->user($userId)
    // continue chaining methods...

$api->group($groupId)
    // continue chaining methods...
```

### Items

#### Multiple items

To access all items in a library, call the `items()` method.

```php
$api->user($userId)
    ->items()
    // continue chaining methods...
```

#### Single item

To access a specific item in a library, call `items($itemKey)` method with the item key as a parameter.

```php
$api->user($userId)
    ->items($itemKey)
    // continue chaining methods...
```

#### Top level items

To access only top level items in a library, call `top()` method just after the `items()` method.

```php
$api->user($userId)
    ->items()
    ->top()
    // continue chaining methods...
```

#### Items in the trash

To access items that have been put in the trash, call `trash()` method just after `items()` method.

```php
$api->user($userId)
    ->items()
    ->trash()
    // continue chaining methods...
```

#### Child items

To access an item's child items, call `children()` method just after `items($itemKey)` method.

```php
$api->user($userId)
    ->items($itemKey)
    ->children()
    // continue chaining methods...
```

#### Item tags

To access all tags associated with a specific item, call `tags()` method just after `items($itemKey)` method.

```php
$api->user($userId)
    ->items($itemKey)
    ->tags()
    // continue chaining methods...
```

### Collections

#### Multiple collections

To access all collections in a library, call the `collections()` method.

```php
$api->user($userId)
    ->collections()
    // continue chaining methods...
```

#### Single collection

To access a specific collection in a library, call `collections($collectionKey)` method with the collection key as a parameter.

```php
$api->user($userId)
    ->collections($collectionKey)
    // continue chaining methods...
```

#### Items in a collection

To access all items in a collection, call `items()` method after calling a specific collection.

```php
$api->user($userId)
    ->collections($collectionKey)
    ->items()
    // continue chaining methods...
```

#### Top level items in a collection

To access only top items in a collection, call `top()` method after calling items in a specific collection.

```php
$api->user($userId)
    ->collections($collectionKey)
    ->items()
    ->top()
    // continue chaining methods...
```

#### Collection tags

To access all tags associated with a specific collection, call `tags()` method just after `collections($collectionKey)` method.

```php
$api->user($userId)
    ->collections($collectionKey)
    ->tags()
    // continue chaining methods...
```

#### Sub collections

To access sub collections within a specific collection, call `subCollection()` method just after `collections($collectionKey)` method.

```php
$api->user($userId)
    ->collections($collectionKey)
    ->subCollections()
    // continue chaining methods...
```

### Versions

To get all resources (either collections or items) versions, call `versions()` method after `items()` or `collections()` method.

```php
$api->user($userId)
    ->items()
    ->versions()
    // continue chaining methods...
```

### Tags

#### All tags

To access all tags in a library, call `tags()` method.

```php
$api->user($userId)
    ->tags()
    // continue chaining methods...
```

#### Matching tags

To access tags matching a specific name in a library, call `tags($tagName)` method with `$tagName` a string as a parameter.

```php
$api->user($userId)
    ->tags($tagName)
    // continue chaining methods...
```

### Searches

#### Multiple searches

To access all saved searches in a library, call `searches()` method.

```php
$api->user($userId)
    ->searches()
    // continue chaining methods...
```

#### Single search

To access a specific saved search in a library, call `searches($searchKey)` method with the search key as a parameter.

```php
$api->user($userId)
    ->searches($searchKey)
    // continue chaining methods...
```

### Key

To access the privilege information of a given api key, call `key($apiKey)` method on the `ZoteroApi` instance.

```php
$response = $api->key($apiKey)
    ->send();
    
$keyPrivileges = $response->getBody();
```

### Groups

To access all groups the current API key has access to, call `groups()` method just after `user($userId)` method.

```php
$response = $api->user($userId)
    ->groups()
    ->send()
    
$groups = $response->getBody();
```

### Sorting and pagination

Sorting and pagination methods can be called after calling a resource method.

#### Sorting

The `sortBy($value)` method set by what type of value the response will by sorted.

The `$value` parameter has to be one of :
  - dateAdded
  - dateModified
  - title
  - creator
  - type
  - date
  - publisher
  - publicationTitle
  - journalAbbreviation
  - language
  - accessDate
  - libraryCatalog
  - callNumber
  - rights
  - addedBy
  - numItems

```php
$api->user($userId)
    ->items()
    ->sortBy('publicationTitle')
    // continue chaining methods...
```

#### Direction

The `direction($value)` method set the sorting direction of the field specified by the `sortBy($value)` method.

The `$value` parameter has to be one of :
  - asc
  - desc
  
```php
$api->user($userId)
    ->items()
    ->sortBy('language')
    ->direction('desc')
    // continue chaining methods...
```

#### Limit

The `limit($value)` method set the maximum number of results to return with a single request.

The `$value` parameter has to be an integer between 1 and 100. The default number of result provided by zotero web api is 50.

```php
$api->user($userId)
    ->items()
    ->limit(70)
    // continue chaining methods...
```

#### Start

The `start($value)` method determines the index of the first result.

The `$value` parameter has to be an integer. The default starting index is 0.

Combine with the limit parameter to select a slice of the available results.

```php
$api->user($userId)
    ->items()
    ->start(60)
    ->limit(70)
    // continue chaining methods...
```

### Request timeout

Request timeout can be set using the `setTimeout($timeout)` method, with `$timeout` an integer in milliseconds as a parameter.

Default request timeout is 0.

```php
$api->setTimeout(3000)
    // continue chaining methods...
```

You can get the current request timeout value using the `getTimeout()` method.

```php
$timeout = $api->getTimeout();
```

### Connection timeout

Connection timeout can be set using the `setConnectionTimeout($connectionTimeout)` method, with `$connectionTimeout` an integer in milliseconds as a parameter.

Default connection timeout is 0.

```php
$api->setConnectionTimeout(3000)
    // continue chaining methods...
```

You can get the current connection timeout value using the `getConnectionTimeout()` method.

```php
$connectionTimeout = $api->getConnectionTimeout();
```

### Sending a request and getting a response

#### Sending the request

To send a request after chaining available methods, call the `send()` method.

```php
$response = $api->user($userId)
    ->items()
    ->send();
```

#### Response body

To access the response body as an array, call the `getBody()` method on the response.

```php
$response = $api->user($userId)
    ->items()
    ->send();
    
$body = $response->getBody(); // array
```

#### Response json

To access the response body as a json string, call the `getJson()` method on the response.

```php
$response = $api->user($userId)
    ->items()
    ->send();
    
$json = $response->getJson(); // string
```

#### Response headers

To access the response headers as an array, call the `getHeaders()` method on the response.

```php
$response = $api->user($userId)
    ->items()
    ->send();
    
$headers = $response->getHeaders(); // array
```

#### Response status code

To access the response status code, call the `getStatusCode()` method on the response.

```php
$response = $api->user($userId)
    ->items()
    ->send();
    
$statusCode = $response->getStatusCode(); // int
```

#### Response reason phrase

To access the response reason phrase, call the `getReasonPhrase()` method on the response.

```php
$response = $api->user($userId)
    ->items()
    ->send();
    
$reasonPhrase = $response->getReasonPhrase(); // string
```

### Raw query

To build the request url yourself, call the `raw($url)` method, with `$url` a string as a parameter.

```php
$response = $api->raw('https://api.zotero.org/users/12345/items?limit=30&start=10')
    ->send();
    
$items = $response->getBody();
```

## Examples

```php
<?php

// require composer autoloader
require __DIR__ . '/vendor/autoload.php';

use Hedii\ZoteroApi\ZoteroApi;

// instantiate zotero api
$api = new ZoteroApi('xxxxxxxxxxxxxxxxxxx');


// get the item 'ABCDEF' in the user 12345 library
$response = $api->user(12345)
    ->items('ABCDEF')
    ->send();
    
$item = $response->getBody();


// get 12 first top items in the group 12345 library and
// sort them by descendant modification date.
$response = $api->group(12345)
    ->items()
    ->top()
    ->limit(12)
    ->sortBy('dateModified')
    ->direction('desc')
    ->send();

$items = $response->getBody();


// search for tags matching 'a name' in the user 12345 library
$response = $api->user(12345)
    ->tags('a name')
    ->send();
    
$tags = $response->getBody();
  
    
// get all user 12345 collections
$response = $api->user(12345)
    ->collections()
    ->send();

$collections = $response->getBody();
    
    
// get top items within the collection 'ABCDEF' in the group 98765 library
$response = $api->group(98765)
    ->collections('ABCDEF')
    ->items()
    ->top()
    ->send();
    
$topItems = $response->getBody();

// get an array of all items keys with their versions
$response = $api->user(12345)
    ->items()
    ->versions();
    
$itemKeysWithVersions = $response->getBody();
```

## Testing

```
composer test
```

## License

hedii/zotero-api is released under the MIT Licence. See the bundled [LICENSE](https://github.com/hedii/zotero-api/blob/master/LICENSE.md) file for details.
