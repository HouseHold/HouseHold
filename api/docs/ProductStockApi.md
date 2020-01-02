# HouseHold.ProductStockApi

All URIs are relative to *http://localhost*

Method | HTTP request | Description
------------- | ------------- | -------------
[**deleteProductStockItem**](ProductStockApi.md#deleteProductStockItem) | **DELETE** /api/product/stocks/{id} | Removes the ProductStock resource.
[**getProductStockCollection**](ProductStockApi.md#getProductStockCollection) | **GET** /api/product/stocks | Retrieves the collection of ProductStock resources.
[**getProductStockItem**](ProductStockApi.md#getProductStockItem) | **GET** /api/product/stocks/{id} | Retrieves a ProductStock resource.
[**patchProductStockItem**](ProductStockApi.md#patchProductStockItem) | **PATCH** /api/product/stocks/{id} | Updates the ProductStock resource.
[**postProductStockCollection**](ProductStockApi.md#postProductStockCollection) | **POST** /api/product/stocks | Creates a ProductStock resource.
[**putProductStockItem**](ProductStockApi.md#putProductStockItem) | **PUT** /api/product/stocks/{id} | Replaces the ProductStock resource.



## deleteProductStockItem

> deleteProductStockItem(id)

Removes the ProductStock resource.

### Example

```javascript
import HouseHold from 'house_hold';

let apiInstance = new HouseHold.ProductStockApi();
let id = "id_example"; // String | 
apiInstance.deleteProductStockItem(id).then(() => {
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


## getProductStockCollection

> InlineResponse2003 getProductStockCollection(opts)

Retrieves the collection of ProductStock resources.

### Example

```javascript
import HouseHold from 'house_hold';

let apiInstance = new HouseHold.ProductStockApi();
let opts = {
  'page': 1 // Number | The collection page number
};
apiInstance.getProductStockCollection(opts).then((data) => {
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

[**InlineResponse2003**](InlineResponse2003.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: application/ld+json


## getProductStockItem

> ProductStockjsonld getProductStockItem(id)

Retrieves a ProductStock resource.

### Example

```javascript
import HouseHold from 'house_hold';

let apiInstance = new HouseHold.ProductStockApi();
let id = "id_example"; // String | 
apiInstance.getProductStockItem(id).then((data) => {
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

[**ProductStockjsonld**](ProductStockjsonld.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: application/ld+json


## patchProductStockItem

> ProductStockjsonld patchProductStockItem(id, opts)

Updates the ProductStock resource.

### Example

```javascript
import HouseHold from 'house_hold';

let apiInstance = new HouseHold.ProductStockApi();
let id = "id_example"; // String | 
let opts = {
  'productStock': new HouseHold.ProductStock() // ProductStock | The updated ProductStock resource
};
apiInstance.patchProductStockItem(id, opts).then((data) => {
  console.log('API called successfully. Returned data: ' + data);
}, (error) => {
  console.error(error);
});

```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **id** | **String**|  | 
 **productStock** | [**ProductStock**](ProductStock.md)| The updated ProductStock resource | [optional] 

### Return type

[**ProductStockjsonld**](ProductStockjsonld.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: application/merge-patch+json
- **Accept**: application/ld+json


## postProductStockCollection

> ProductStockjsonld postProductStockCollection(opts)

Creates a ProductStock resource.

### Example

```javascript
import HouseHold from 'house_hold';

let apiInstance = new HouseHold.ProductStockApi();
let opts = {
  'productStockjsonld': new HouseHold.ProductStockjsonld() // ProductStockjsonld | The new ProductStock resource
};
apiInstance.postProductStockCollection(opts).then((data) => {
  console.log('API called successfully. Returned data: ' + data);
}, (error) => {
  console.error(error);
});

```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **productStockjsonld** | [**ProductStockjsonld**](ProductStockjsonld.md)| The new ProductStock resource | [optional] 

### Return type

[**ProductStockjsonld**](ProductStockjsonld.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: application/ld+json
- **Accept**: application/ld+json


## putProductStockItem

> ProductStockjsonld putProductStockItem(id, opts)

Replaces the ProductStock resource.

### Example

```javascript
import HouseHold from 'house_hold';

let apiInstance = new HouseHold.ProductStockApi();
let id = "id_example"; // String | 
let opts = {
  'productStockjsonld': new HouseHold.ProductStockjsonld() // ProductStockjsonld | The updated ProductStock resource
};
apiInstance.putProductStockItem(id, opts).then((data) => {
  console.log('API called successfully. Returned data: ' + data);
}, (error) => {
  console.error(error);
});

```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **id** | **String**|  | 
 **productStockjsonld** | [**ProductStockjsonld**](ProductStockjsonld.md)| The updated ProductStock resource | [optional] 

### Return type

[**ProductStockjsonld**](ProductStockjsonld.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: application/ld+json
- **Accept**: application/ld+json

