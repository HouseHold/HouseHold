# HouseHold.ProductCategoryApi

All URIs are relative to *http://localhost*

Method | HTTP request | Description
------------- | ------------- | -------------
[**deleteProductCategoryItem**](ProductCategoryApi.md#deleteProductCategoryItem) | **DELETE** /api/product/categories/{id} | Removes the ProductCategory resource.
[**getProductCategoryCollection**](ProductCategoryApi.md#getProductCategoryCollection) | **GET** /api/product/categories | Retrieves the collection of ProductCategory resources.
[**getProductCategoryItem**](ProductCategoryApi.md#getProductCategoryItem) | **GET** /api/product/categories/{id} | Retrieves a ProductCategory resource.
[**patchProductCategoryItem**](ProductCategoryApi.md#patchProductCategoryItem) | **PATCH** /api/product/categories/{id} | Updates the ProductCategory resource.
[**postProductCategoryCollection**](ProductCategoryApi.md#postProductCategoryCollection) | **POST** /api/product/categories | Creates a ProductCategory resource.
[**putProductCategoryItem**](ProductCategoryApi.md#putProductCategoryItem) | **PUT** /api/product/categories/{id} | Replaces the ProductCategory resource.



## deleteProductCategoryItem

> deleteProductCategoryItem(id)

Removes the ProductCategory resource.

### Example

```javascript
import HouseHold from 'house_hold';

let apiInstance = new HouseHold.ProductCategoryApi();
let id = "id_example"; // String | 
apiInstance.deleteProductCategoryItem(id).then(() => {
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


## getProductCategoryCollection

> InlineResponse200 getProductCategoryCollection(opts)

Retrieves the collection of ProductCategory resources.

### Example

```javascript
import HouseHold from 'house_hold';

let apiInstance = new HouseHold.ProductCategoryApi();
let opts = {
  'page': 1 // Number | The collection page number
};
apiInstance.getProductCategoryCollection(opts).then((data) => {
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

[**InlineResponse200**](InlineResponse200.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: application/ld+json


## getProductCategoryItem

> ProductCategoryjsonld getProductCategoryItem(id)

Retrieves a ProductCategory resource.

### Example

```javascript
import HouseHold from 'house_hold';

let apiInstance = new HouseHold.ProductCategoryApi();
let id = "id_example"; // String | 
apiInstance.getProductCategoryItem(id).then((data) => {
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

[**ProductCategoryjsonld**](ProductCategoryjsonld.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: application/ld+json


## patchProductCategoryItem

> ProductCategoryjsonld patchProductCategoryItem(id, opts)

Updates the ProductCategory resource.

### Example

```javascript
import HouseHold from 'house_hold';

let apiInstance = new HouseHold.ProductCategoryApi();
let id = "id_example"; // String | 
let opts = {
  'productCategory': new HouseHold.ProductCategory() // ProductCategory | The updated ProductCategory resource
};
apiInstance.patchProductCategoryItem(id, opts).then((data) => {
  console.log('API called successfully. Returned data: ' + data);
}, (error) => {
  console.error(error);
});

```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **id** | **String**|  | 
 **productCategory** | [**ProductCategory**](ProductCategory.md)| The updated ProductCategory resource | [optional] 

### Return type

[**ProductCategoryjsonld**](ProductCategoryjsonld.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: application/merge-patch+json
- **Accept**: application/ld+json


## postProductCategoryCollection

> ProductCategoryjsonld postProductCategoryCollection(opts)

Creates a ProductCategory resource.

### Example

```javascript
import HouseHold from 'house_hold';

let apiInstance = new HouseHold.ProductCategoryApi();
let opts = {
  'productCategoryjsonld': new HouseHold.ProductCategoryjsonld() // ProductCategoryjsonld | The new ProductCategory resource
};
apiInstance.postProductCategoryCollection(opts).then((data) => {
  console.log('API called successfully. Returned data: ' + data);
}, (error) => {
  console.error(error);
});

```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **productCategoryjsonld** | [**ProductCategoryjsonld**](ProductCategoryjsonld.md)| The new ProductCategory resource | [optional] 

### Return type

[**ProductCategoryjsonld**](ProductCategoryjsonld.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: application/ld+json
- **Accept**: application/ld+json


## putProductCategoryItem

> ProductCategoryjsonld putProductCategoryItem(id, opts)

Replaces the ProductCategory resource.

### Example

```javascript
import HouseHold from 'house_hold';

let apiInstance = new HouseHold.ProductCategoryApi();
let id = "id_example"; // String | 
let opts = {
  'productCategoryjsonld': new HouseHold.ProductCategoryjsonld() // ProductCategoryjsonld | The updated ProductCategory resource
};
apiInstance.putProductCategoryItem(id, opts).then((data) => {
  console.log('API called successfully. Returned data: ' + data);
}, (error) => {
  console.error(error);
});

```

### Parameters


Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **id** | **String**|  | 
 **productCategoryjsonld** | [**ProductCategoryjsonld**](ProductCategoryjsonld.md)| The updated ProductCategory resource | [optional] 

### Return type

[**ProductCategoryjsonld**](ProductCategoryjsonld.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: application/ld+json
- **Accept**: application/ld+json

