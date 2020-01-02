# HouseHold.StockApi

All URIs are relative to *http://localhost*

Method | HTTP request | Description
------------- | ------------- | -------------
[**deleteStockItem**](StockApi.md#deleteStockItem) | **DELETE** /api/stocks/{id} | Removes the Stock resource.
[**getStockCollection**](StockApi.md#getStockCollection) | **GET** /api/stocks | Retrieves the collection of Stock resources.
[**getStockItem**](StockApi.md#getStockItem) | **GET** /api/stocks/{id} | Retrieves a Stock resource.
[**patchStockItem**](StockApi.md#patchStockItem) | **PATCH** /api/stocks/{id} | Updates the Stock resource.
[**postStockCollection**](StockApi.md#postStockCollection) | **POST** /api/stocks | Creates a Stock resource.
[**putStockItem**](StockApi.md#putStockItem) | **PUT** /api/stocks/{id} | Replaces the Stock resource.



## deleteStockItem

> deleteStockItem(id)

Removes the Stock resource.

### Example

```javascript
import HouseHold from 'house_hold';

let apiInstance = new HouseHold.StockApi();
let id = "id_example"; // String | 
apiInstance.deleteStockItem(id).then(() => {
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


## getStockCollection

> InlineResponse2004 getStockCollection(opts)

Retrieves the collection of Stock resources.

### Example

```javascript
import HouseHold from 'house_hold';

let apiInstance = new HouseHold.StockApi();
let opts = {
  'page': 1 // Number | The collection page number
};
apiInstance.getStockCollection(opts).then((data) => {
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

[**InlineResponse2004**](InlineResponse2004.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: application/ld+json


## getStockItem

> Stockjsonld getStockItem(id)

Retrieves a Stock resource.

### Example

```javascript
import HouseHold from 'house_hold';

let apiInstance = new HouseHold.StockApi();
let id = "id_example"; // String | 
apiInstance.getStockItem(id).then((data) => {
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

[**Stockjsonld**](Stockjsonld.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: application/ld+json


## patchStockItem

> Stockjsonld patchStockItem(id, opts)

Updates the Stock resource.

### Example

```javascript
import HouseHold from 'house_hold';

let apiInstance = new HouseHold.StockApi();
let id = "id_example"; // String | 
let opts = {
  'stock': new HouseHold.Stock() // Stock | The updated Stock resource
};
apiInstance.patchStockItem(id, opts).then((data) => {
  console.log('API called successfully. Returned data: ' + data);
}, (error) => {
  console.error(error);
});

```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **id** | **String**|  | 
 **stock** | [**Stock**](Stock.md)| The updated Stock resource | [optional] 

### Return type

[**Stockjsonld**](Stockjsonld.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: application/merge-patch+json
- **Accept**: application/ld+json


## postStockCollection

> Stockjsonld postStockCollection(opts)

Creates a Stock resource.

### Example

```javascript
import HouseHold from 'house_hold';

let apiInstance = new HouseHold.StockApi();
let opts = {
  'stockjsonld': new HouseHold.Stockjsonld() // Stockjsonld | The new Stock resource
};
apiInstance.postStockCollection(opts).then((data) => {
  console.log('API called successfully. Returned data: ' + data);
}, (error) => {
  console.error(error);
});

```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **stockjsonld** | [**Stockjsonld**](Stockjsonld.md)| The new Stock resource | [optional] 

### Return type

[**Stockjsonld**](Stockjsonld.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: application/ld+json
- **Accept**: application/ld+json


## putStockItem

> Stockjsonld putStockItem(id, opts)

Replaces the Stock resource.

### Example

```javascript
import HouseHold from 'house_hold';

let apiInstance = new HouseHold.StockApi();
let id = "id_example"; // String | 
let opts = {
  'stockjsonld': new HouseHold.Stockjsonld() // Stockjsonld | The updated Stock resource
};
apiInstance.putStockItem(id, opts).then((data) => {
  console.log('API called successfully. Returned data: ' + data);
}, (error) => {
  console.error(error);
});

```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **id** | **String**|  | 
 **stockjsonld** | [**Stockjsonld**](Stockjsonld.md)| The updated Stock resource | [optional] 

### Return type

[**Stockjsonld**](Stockjsonld.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: application/ld+json
- **Accept**: application/ld+json

