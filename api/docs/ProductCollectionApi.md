# HouseHold.ProductCollectionApi

All URIs are relative to *http://localhost*

Method | HTTP request | Description
------------- | ------------- | -------------
[**deleteProductCollectionItem**](ProductCollectionApi.md#deleteProductCollectionItem) | **DELETE** /api/product/collections/{id} | Removes the ProductCollection resource.
[**getProductCollectionCollection**](ProductCollectionApi.md#getProductCollectionCollection) | **GET** /api/product/collections | Retrieves the collection of ProductCollection resources.
[**getProductCollectionItem**](ProductCollectionApi.md#getProductCollectionItem) | **GET** /api/product/collections/{id} | Retrieves a ProductCollection resource.
[**patchProductCollectionItem**](ProductCollectionApi.md#patchProductCollectionItem) | **PATCH** /api/product/collections/{id} | Updates the ProductCollection resource.
[**postProductCollectionCollection**](ProductCollectionApi.md#postProductCollectionCollection) | **POST** /api/product/collections | Creates a ProductCollection resource.
[**putProductCollectionItem**](ProductCollectionApi.md#putProductCollectionItem) | **PUT** /api/product/collections/{id} | Replaces the ProductCollection resource.



## deleteProductCollectionItem

> deleteProductCollectionItem(id)

Removes the ProductCollection resource.

### Example

```javascript
import HouseHold from 'house_hold';

let apiInstance = new HouseHold.ProductCollectionApi();
let id = "id_example"; // String | 
apiInstance.deleteProductCollectionItem(id).then(() => {
  console.log('API called successfully.');
}, (error) => {
  console.error(error);
});

```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **id** | **String**|  | 

### Return type

null (empty response body)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: Not defined


## getProductCollectionCollection

> InlineResponse2001 getProductCollectionCollection(opts)

Retrieves the collection of ProductCollection resources.

### Example

```javascript
import HouseHold from 'house_hold';

let apiInstance = new HouseHold.ProductCollectionApi();
let opts = {
  'page': 1 // Number | The collection page number
};
apiInstance.getProductCollectionCollection(opts).then((data) => {
  console.log('API called successfully. Returned data: ' + data);
}, (error) => {
  console.error(error);
});

```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **page** | **Number**| The collection page number | [optional] [default to 1]

### Return type

[**InlineResponse2001**](InlineResponse2001.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: application/ld+json


## getProductCollectionItem

> ProductCollectionjsonld getProductCollectionItem(id)

Retrieves a ProductCollection resource.

### Example

```javascript
import HouseHold from 'house_hold';

let apiInstance = new HouseHold.ProductCollectionApi();
let id = "id_example"; // String | 
apiInstance.getProductCollectionItem(id).then((data) => {
  console.log('API called successfully. Returned data: ' + data);
}, (error) => {
  console.error(error);
});

```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **id** | **String**|  | 

### Return type

[**ProductCollectionjsonld**](ProductCollectionjsonld.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: application/ld+json


## patchProductCollectionItem

> ProductCollectionjsonld patchProductCollectionItem(id, opts)

Updates the ProductCollection resource.

### Example

```javascript
import HouseHold from 'house_hold';

let apiInstance = new HouseHold.ProductCollectionApi();
let id = "id_example"; // String | 
let opts = {
  'productCollection': new HouseHold.ProductCollection() // ProductCollection | The updated ProductCollection resource
};
apiInstance.patchProductCollectionItem(id, opts).then((data) => {
  console.log('API called successfully. Returned data: ' + data);
}, (error) => {
  console.error(error);
});

```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **id** | **String**|  | 
 **productCollection** | [**ProductCollection**](ProductCollection.md)| The updated ProductCollection resource | [optional] 

### Return type

[**ProductCollectionjsonld**](ProductCollectionjsonld.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: application/merge-patch+json
- **Accept**: application/ld+json


## postProductCollectionCollection

> ProductCollectionjsonld postProductCollectionCollection(opts)

Creates a ProductCollection resource.

### Example

```javascript
import HouseHold from 'house_hold';

let apiInstance = new HouseHold.ProductCollectionApi();
let opts = {
  'productCollectionjsonld': new HouseHold.ProductCollectionjsonld() // ProductCollectionjsonld | The new ProductCollection resource
};
apiInstance.postProductCollectionCollection(opts).then((data) => {
  console.log('API called successfully. Returned data: ' + data);
}, (error) => {
  console.error(error);
});

```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **productCollectionjsonld** | [**ProductCollectionjsonld**](ProductCollectionjsonld.md)| The new ProductCollection resource | [optional] 

### Return type

[**ProductCollectionjsonld**](ProductCollectionjsonld.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: application/ld+json
- **Accept**: application/ld+json


## putProductCollectionItem

> ProductCollectionjsonld putProductCollectionItem(id, opts)

Replaces the ProductCollection resource.

### Example

```javascript
import HouseHold from 'house_hold';

let apiInstance = new HouseHold.ProductCollectionApi();
let id = "id_example"; // String | 
let opts = {
  'productCollectionjsonld': new HouseHold.ProductCollectionjsonld() // ProductCollectionjsonld | The updated ProductCollection resource
};
apiInstance.putProductCollectionItem(id, opts).then((data) => {
  console.log('API called successfully. Returned data: ' + data);
}, (error) => {
  console.error(error);
});

```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **id** | **String**|  | 
 **productCollectionjsonld** | [**ProductCollectionjsonld**](ProductCollectionjsonld.md)| The updated ProductCollection resource | [optional] 

### Return type

[**ProductCollectionjsonld**](ProductCollectionjsonld.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: application/ld+json
- **Accept**: application/ld+json

