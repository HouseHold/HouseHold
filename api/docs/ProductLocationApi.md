# HouseHold.ProductLocationApi

All URIs are relative to *http://localhost*

Method | HTTP request | Description
------------- | ------------- | -------------
[**deleteProductLocationItem**](ProductLocationApi.md#deleteProductLocationItem) | **DELETE** /api/product/locations/{id} | Removes the ProductLocation resource.
[**getProductLocationCollection**](ProductLocationApi.md#getProductLocationCollection) | **GET** /api/product/locations | Retrieves the collection of ProductLocation resources.
[**getProductLocationItem**](ProductLocationApi.md#getProductLocationItem) | **GET** /api/product/locations/{id} | Retrieves a ProductLocation resource.
[**patchProductLocationItem**](ProductLocationApi.md#patchProductLocationItem) | **PATCH** /api/product/locations/{id} | Updates the ProductLocation resource.
[**postProductLocationCollection**](ProductLocationApi.md#postProductLocationCollection) | **POST** /api/product/locations | Creates a ProductLocation resource.
[**putProductLocationItem**](ProductLocationApi.md#putProductLocationItem) | **PUT** /api/product/locations/{id} | Replaces the ProductLocation resource.



## deleteProductLocationItem

> deleteProductLocationItem(id)

Removes the ProductLocation resource.

### Example

```javascript
import HouseHold from 'house_hold';

let apiInstance = new HouseHold.ProductLocationApi();
let id = "id_example"; // String | 
apiInstance.deleteProductLocationItem(id).then(() => {
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


## getProductLocationCollection

> InlineResponse2002 getProductLocationCollection(opts)

Retrieves the collection of ProductLocation resources.

### Example

```javascript
import HouseHold from 'house_hold';

let apiInstance = new HouseHold.ProductLocationApi();
let opts = {
  'page': 1 // Number | The collection page number
};
apiInstance.getProductLocationCollection(opts).then((data) => {
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

[**InlineResponse2002**](InlineResponse2002.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: application/ld+json, application/json, text/html


## getProductLocationItem

> ProductLocationjsonld getProductLocationItem(id)

Retrieves a ProductLocation resource.

### Example

```javascript
import HouseHold from 'house_hold';

let apiInstance = new HouseHold.ProductLocationApi();
let id = "id_example"; // String | 
apiInstance.getProductLocationItem(id).then((data) => {
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

[**ProductLocationjsonld**](ProductLocationjsonld.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: application/ld+json, application/json, text/html


## patchProductLocationItem

> ProductLocationjsonld patchProductLocationItem(id, opts)

Updates the ProductLocation resource.

### Example

```javascript
import HouseHold from 'house_hold';

let apiInstance = new HouseHold.ProductLocationApi();
let id = "id_example"; // String | 
let opts = {
  'productLocation': new HouseHold.ProductLocation() // ProductLocation | The updated ProductLocation resource
};
apiInstance.patchProductLocationItem(id, opts).then((data) => {
  console.log('API called successfully. Returned data: ' + data);
}, (error) => {
  console.error(error);
});

```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **id** | **String**|  | 
 **productLocation** | [**ProductLocation**](ProductLocation.md)| The updated ProductLocation resource | [optional] 

### Return type

[**ProductLocationjsonld**](ProductLocationjsonld.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: application/merge-patch+json
- **Accept**: application/ld+json, application/json, text/html


## postProductLocationCollection

> ProductLocationjsonld postProductLocationCollection(opts)

Creates a ProductLocation resource.

### Example

```javascript
import HouseHold from 'house_hold';

let apiInstance = new HouseHold.ProductLocationApi();
let opts = {
  'productLocationjsonld': new HouseHold.ProductLocationjsonld() // ProductLocationjsonld | The new ProductLocation resource
};
apiInstance.postProductLocationCollection(opts).then((data) => {
  console.log('API called successfully. Returned data: ' + data);
}, (error) => {
  console.error(error);
});

```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **productLocationjsonld** | [**ProductLocationjsonld**](ProductLocationjsonld.md)| The new ProductLocation resource | [optional] 

### Return type

[**ProductLocationjsonld**](ProductLocationjsonld.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: application/ld+json, application/json, text/html
- **Accept**: application/ld+json, application/json, text/html


## putProductLocationItem

> ProductLocationjsonld putProductLocationItem(id, opts)

Replaces the ProductLocation resource.

### Example

```javascript
import HouseHold from 'house_hold';

let apiInstance = new HouseHold.ProductLocationApi();
let id = "id_example"; // String | 
let opts = {
  'productLocationjsonld': new HouseHold.ProductLocationjsonld() // ProductLocationjsonld | The updated ProductLocation resource
};
apiInstance.putProductLocationItem(id, opts).then((data) => {
  console.log('API called successfully. Returned data: ' + data);
}, (error) => {
  console.error(error);
});

```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **id** | **String**|  | 
 **productLocationjsonld** | [**ProductLocationjsonld**](ProductLocationjsonld.md)| The updated ProductLocation resource | [optional] 

### Return type

[**ProductLocationjsonld**](ProductLocationjsonld.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: application/ld+json, application/json, text/html
- **Accept**: application/ld+json, application/json, text/html

