/**
 * HouseHold
 * HouseHold API
 *
 * The version of the OpenAPI document: 1.0.0
 * 
 *
 * NOTE: This class is auto generated by OpenAPI Generator (https://openapi-generator.tech).
 * https://openapi-generator.tech
 * Do not edit the class manually.
 *
 */


import ApiClient from "../ApiClient";
import InlineResponse200 from '../model/InlineResponse200';
import ProductCategory from '../model/ProductCategory';
import ProductCategoryjsonld from '../model/ProductCategoryjsonld';

/**
* ProductCategory service.
* @module api/ProductCategoryApi
* @version 1.0.0
*/
export default class ProductCategoryApi {

    /**
    * Constructs a new ProductCategoryApi. 
    * @alias module:api/ProductCategoryApi
    * @class
    * @param {module:ApiClient} [apiClient] Optional API client implementation to use,
    * default to {@link module:ApiClient#instance} if unspecified.
    */
    constructor(apiClient) {
        this.apiClient = apiClient || ApiClient.instance;
    }



    /**
     * Removes the ProductCategory resource.
     * @param {String} id 
     * @return {Promise} a {@link https://www.promisejs.org/|Promise}, with an object containing HTTP response
     */
    deleteProductCategoryItemWithHttpInfo(id) {
      let postBody = null;
      // verify the required parameter 'id' is set
      if (id === undefined || id === null) {
        throw new Error("Missing the required parameter 'id' when calling deleteProductCategoryItem");
      }

      let pathParams = {
        'id': id
      };
      let queryParams = {
      };
      let headerParams = {
      };
      let formParams = {
      };

      let authNames = [];
      let contentTypes = [];
      let accepts = [];
      let returnType = null;
      return this.apiClient.callApi(
        '/api/product/categories/{id}', 'DELETE',
        pathParams, queryParams, headerParams, formParams, postBody,
        authNames, contentTypes, accepts, returnType, null
      );
    }

    /**
     * Removes the ProductCategory resource.
     * @param {String} id 
     * @return {Promise} a {@link https://www.promisejs.org/|Promise}
     */
    deleteProductCategoryItem(id) {
      return this.deleteProductCategoryItemWithHttpInfo(id)
        .then(function(response_and_data) {
          return response_and_data.data;
        });
    }


    /**
     * Retrieves the collection of ProductCategory resources.
     * @param {Object} opts Optional parameters
     * @param {Number} opts.page The collection page number (default to 1)
     * @return {Promise} a {@link https://www.promisejs.org/|Promise}, with an object containing data of type {@link module:model/InlineResponse200} and HTTP response
     */
    getProductCategoryCollectionWithHttpInfo(opts) {
      opts = opts || {};
      let postBody = null;

      let pathParams = {
      };
      let queryParams = {
        'page': opts['page']
      };
      let headerParams = {
      };
      let formParams = {
      };

      let authNames = [];
      let contentTypes = [];
      let accepts = ['application/ld+json', 'application/json', 'text/html'];
      let returnType = InlineResponse200;
      return this.apiClient.callApi(
        '/api/product/categories', 'GET',
        pathParams, queryParams, headerParams, formParams, postBody,
        authNames, contentTypes, accepts, returnType, null
      );
    }

    /**
     * Retrieves the collection of ProductCategory resources.
     * @param {Object} opts Optional parameters
     * @param {Number} opts.page The collection page number (default to 1)
     * @return {Promise} a {@link https://www.promisejs.org/|Promise}, with data of type {@link module:model/InlineResponse200}
     */
    getProductCategoryCollection(opts) {
      return this.getProductCategoryCollectionWithHttpInfo(opts)
        .then(function(response_and_data) {
          return response_and_data.data;
        });
    }


    /**
     * Retrieves a ProductCategory resource.
     * @param {String} id 
     * @return {Promise} a {@link https://www.promisejs.org/|Promise}, with an object containing data of type {@link module:model/ProductCategoryjsonld} and HTTP response
     */
    getProductCategoryItemWithHttpInfo(id) {
      let postBody = null;
      // verify the required parameter 'id' is set
      if (id === undefined || id === null) {
        throw new Error("Missing the required parameter 'id' when calling getProductCategoryItem");
      }

      let pathParams = {
        'id': id
      };
      let queryParams = {
      };
      let headerParams = {
      };
      let formParams = {
      };

      let authNames = [];
      let contentTypes = [];
      let accepts = ['application/ld+json', 'application/json', 'text/html'];
      let returnType = ProductCategoryjsonld;
      return this.apiClient.callApi(
        '/api/product/categories/{id}', 'GET',
        pathParams, queryParams, headerParams, formParams, postBody,
        authNames, contentTypes, accepts, returnType, null
      );
    }

    /**
     * Retrieves a ProductCategory resource.
     * @param {String} id 
     * @return {Promise} a {@link https://www.promisejs.org/|Promise}, with data of type {@link module:model/ProductCategoryjsonld}
     */
    getProductCategoryItem(id) {
      return this.getProductCategoryItemWithHttpInfo(id)
        .then(function(response_and_data) {
          return response_and_data.data;
        });
    }


    /**
     * Updates the ProductCategory resource.
     * @param {String} id 
     * @param {Object} opts Optional parameters
     * @param {module:model/ProductCategory} opts.productCategory The updated ProductCategory resource
     * @return {Promise} a {@link https://www.promisejs.org/|Promise}, with an object containing data of type {@link module:model/ProductCategoryjsonld} and HTTP response
     */
    patchProductCategoryItemWithHttpInfo(id, opts) {
      opts = opts || {};
      let postBody = opts['productCategory'];
      // verify the required parameter 'id' is set
      if (id === undefined || id === null) {
        throw new Error("Missing the required parameter 'id' when calling patchProductCategoryItem");
      }

      let pathParams = {
        'id': id
      };
      let queryParams = {
      };
      let headerParams = {
      };
      let formParams = {
      };

      let authNames = [];
      let contentTypes = ['application/merge-patch+json'];
      let accepts = ['application/ld+json', 'application/json', 'text/html'];
      let returnType = ProductCategoryjsonld;
      return this.apiClient.callApi(
        '/api/product/categories/{id}', 'PATCH',
        pathParams, queryParams, headerParams, formParams, postBody,
        authNames, contentTypes, accepts, returnType, null
      );
    }

    /**
     * Updates the ProductCategory resource.
     * @param {String} id 
     * @param {Object} opts Optional parameters
     * @param {module:model/ProductCategory} opts.productCategory The updated ProductCategory resource
     * @return {Promise} a {@link https://www.promisejs.org/|Promise}, with data of type {@link module:model/ProductCategoryjsonld}
     */
    patchProductCategoryItem(id, opts) {
      return this.patchProductCategoryItemWithHttpInfo(id, opts)
        .then(function(response_and_data) {
          return response_and_data.data;
        });
    }


    /**
     * Creates a ProductCategory resource.
     * @param {Object} opts Optional parameters
     * @param {module:model/ProductCategoryjsonld} opts.productCategoryjsonld The new ProductCategory resource
     * @return {Promise} a {@link https://www.promisejs.org/|Promise}, with an object containing data of type {@link module:model/ProductCategoryjsonld} and HTTP response
     */
    postProductCategoryCollectionWithHttpInfo(opts) {
      opts = opts || {};
      let postBody = opts['productCategoryjsonld'];

      let pathParams = {
      };
      let queryParams = {
      };
      let headerParams = {
      };
      let formParams = {
      };

      let authNames = [];
      let contentTypes = ['application/ld+json', 'application/json', 'text/html'];
      let accepts = ['application/ld+json', 'application/json', 'text/html'];
      let returnType = ProductCategoryjsonld;
      return this.apiClient.callApi(
        '/api/product/categories', 'POST',
        pathParams, queryParams, headerParams, formParams, postBody,
        authNames, contentTypes, accepts, returnType, null
      );
    }

    /**
     * Creates a ProductCategory resource.
     * @param {Object} opts Optional parameters
     * @param {module:model/ProductCategoryjsonld} opts.productCategoryjsonld The new ProductCategory resource
     * @return {Promise} a {@link https://www.promisejs.org/|Promise}, with data of type {@link module:model/ProductCategoryjsonld}
     */
    postProductCategoryCollection(opts) {
      return this.postProductCategoryCollectionWithHttpInfo(opts)
        .then(function(response_and_data) {
          return response_and_data.data;
        });
    }


    /**
     * Replaces the ProductCategory resource.
     * @param {String} id 
     * @param {Object} opts Optional parameters
     * @param {module:model/ProductCategoryjsonld} opts.productCategoryjsonld The updated ProductCategory resource
     * @return {Promise} a {@link https://www.promisejs.org/|Promise}, with an object containing data of type {@link module:model/ProductCategoryjsonld} and HTTP response
     */
    putProductCategoryItemWithHttpInfo(id, opts) {
      opts = opts || {};
      let postBody = opts['productCategoryjsonld'];
      // verify the required parameter 'id' is set
      if (id === undefined || id === null) {
        throw new Error("Missing the required parameter 'id' when calling putProductCategoryItem");
      }

      let pathParams = {
        'id': id
      };
      let queryParams = {
      };
      let headerParams = {
      };
      let formParams = {
      };

      let authNames = [];
      let contentTypes = ['application/ld+json', 'application/json', 'text/html'];
      let accepts = ['application/ld+json', 'application/json', 'text/html'];
      let returnType = ProductCategoryjsonld;
      return this.apiClient.callApi(
        '/api/product/categories/{id}', 'PUT',
        pathParams, queryParams, headerParams, formParams, postBody,
        authNames, contentTypes, accepts, returnType, null
      );
    }

    /**
     * Replaces the ProductCategory resource.
     * @param {String} id 
     * @param {Object} opts Optional parameters
     * @param {module:model/ProductCategoryjsonld} opts.productCategoryjsonld The updated ProductCategory resource
     * @return {Promise} a {@link https://www.promisejs.org/|Promise}, with data of type {@link module:model/ProductCategoryjsonld}
     */
    putProductCategoryItem(id, opts) {
      return this.putProductCategoryItemWithHttpInfo(id, opts)
        .then(function(response_and_data) {
          return response_and_data.data;
        });
    }


}