# HouseHold.ProductApi

All URIs are relative to *http://localhost*

Method | HTTP request | Description
------------- | ------------- | -------------
[**deleteProductItem**](ProductApi.md#deleteProductItem) | **DELETE** /api/products/{id} | Removes the Product resource.
[**getProductCollection**](ProductApi.md#getProductCollection) | **GET** /api/products | Retrieves the collection of Product resources.
[**getProductItem**](ProductApi.md#getProductItem) | **GET** /api/products/{id} | Retrieves a Product resource.
[**patchProductItem**](ProductApi.md#patchProductItem) | **PATCH** /api/products/{id} | Updates the Product resource.
[**postProductCollection**](ProductApi.md#postProductCollection) | **POST** /api/products | Creates a Product resource.
[**putProductItem**](ProductApi.md#putProductItem) | **PUT** /api/products/{id} | Replaces the Product resource.



## deleteProductItem

> deleteProductItem(id)

Removes the Product resource.

### Example

```javascript
import HouseHold from 'house_hold';

let apiInstance = new HouseHold.ProductApi();
let id = "id_example"; // String | 
apiInstance.deleteProductItem(id).then(() => {
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


## getProductCollection

> InlineResponse2003 getProductCollection(opts)

Retrieves the collection of Product resources.

### Example

```javascript
import HouseHold from 'house_hold';

let apiInstance = new HouseHold.ProductApi();
let opts = {
  'page': 1 // Number | The collection page number
};
apiInstance.getProductCollection(opts).then((data) => {
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
- **Accept**: application/ld+json, application/json, text/html


## getProductItem

> Productjsonld getProductItem(id)

Retrieves a Product resource.

### Example

```javascript
import HouseHold from 'house_hold';

let apiInstance = new HouseHold.ProductApi();
let id = "id_example"; // String | 
apiInstance.getProductItem(id).then((data) => {
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

[**Productjsonld**](Productjsonld.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: application/ld+json, application/json, text/html


## patchProductItem

> Productjsonld patchProductItem(id, opts)

Updates the Product resource.

### Example

```javascript
import HouseHold from 'house_hold';

let apiInstance = new HouseHold.ProductApi();
let id = "id_example"; // String | 
let opts = {
  'product': new HouseHold.Product() // Product | The updated Product resource
};
apiInstance.patchProductItem(id, opts).then((data) => {
  console.log('API called successfully. Returned data: ' + data);
}, (error) => {
  console.error(error);
});

```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **id** | **String**|  | 
 **product** | [**Product**](Product.md)| The updated Product resource | [optional] 

### Return type

[**Productjsonld**](Productjsonld.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: application/merge-patch+json
- **Accept**: application/ld+json, application/json, text/html


## postProductCollection

> Productjsonld postProductCollection(opts)

Creates a Product resource.

### Example

```javascript
import HouseHold from 'house_hold';

let apiInstance = new HouseHold.ProductApi();
let opts = {
  'productjsonld': new HouseHold.Productjsonld() // Productjsonld | The new Product resource
};
apiInstance.postProductCollection(opts).then((data) => {
  console.log('API called successfully. Returned data: ' + data);
}, (error) => {
  console.error(error);
});

```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **productjsonld** | [**Productjsonld**](Productjsonld.md)| The new Product resource | [optional] 

### Return type

[**Productjsonld**](Productjsonld.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: application/ld+json, application/json, text/html
- **Accept**: application/ld+json, application/json, text/html


## putProductItem

> Productjsonld putProductItem(id, opts)

Replaces the Product resource.

### Example

```javascript
import HouseHold from 'house_hold';

let apiInstance = new HouseHold.ProductApi();
let id = "id_example"; // String | 
let opts = {
  'productjsonld': new HouseHold.Productjsonld() // Productjsonld | The updated Product resource
};
apiInstance.putProductItem(id, opts).then((data) => {
  console.log('API called successfully. Returned data: ' + data);
}, (error) => {
  console.error(error);
});

```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **id** | **String**|  | 
 **productjsonld** | [**Productjsonld**](Productjsonld.md)| The updated Product resource | [optional] 

### Return type

[**Productjsonld**](Productjsonld.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: application/ld+json, application/json, text/html
- **Accept**: application/ld+json, application/json, text/html

