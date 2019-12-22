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

(function(root, factory) {
  if (typeof define === 'function' && define.amd) {
    // AMD.
    define(['expect.js', process.cwd()+'/src/index'], factory);
  } else if (typeof module === 'object' && module.exports) {
    // CommonJS-like environments that support module.exports, like Node.
    factory(require('expect.js'), require(process.cwd()+'/src/index'));
  } else {
    // Browser globals (root is window)
    factory(root.expect, root.HouseHold);
  }
}(this, function(expect, HouseHold) {
  'use strict';

  var instance;

  beforeEach(function() {
    instance = new HouseHold.ProductCollectionApi();
  });

  var getProperty = function(object, getter, property) {
    // Use getter method if present; otherwise, get the property directly.
    if (typeof object[getter] === 'function')
      return object[getter]();
    else
      return object[property];
  }

  var setProperty = function(object, setter, property, value) {
    // Use setter method if present; otherwise, set the property directly.
    if (typeof object[setter] === 'function')
      object[setter](value);
    else
      object[property] = value;
  }

  describe('ProductCollectionApi', function() {
    describe('deleteProductCollectionItem', function() {
      it('should call deleteProductCollectionItem successfully', function(done) {
        //uncomment below and update the code to test deleteProductCollectionItem
        //instance.deleteProductCollectionItem(function(error) {
        //  if (error) throw error;
        //expect().to.be();
        //});
        done();
      });
    });
    describe('getProductCollectionCollection', function() {
      it('should call getProductCollectionCollection successfully', function(done) {
        //uncomment below and update the code to test getProductCollectionCollection
        //instance.getProductCollectionCollection(function(error) {
        //  if (error) throw error;
        //expect().to.be();
        //});
        done();
      });
    });
    describe('getProductCollectionItem', function() {
      it('should call getProductCollectionItem successfully', function(done) {
        //uncomment below and update the code to test getProductCollectionItem
        //instance.getProductCollectionItem(function(error) {
        //  if (error) throw error;
        //expect().to.be();
        //});
        done();
      });
    });
    describe('patchProductCollectionItem', function() {
      it('should call patchProductCollectionItem successfully', function(done) {
        //uncomment below and update the code to test patchProductCollectionItem
        //instance.patchProductCollectionItem(function(error) {
        //  if (error) throw error;
        //expect().to.be();
        //});
        done();
      });
    });
    describe('postProductCollectionCollection', function() {
      it('should call postProductCollectionCollection successfully', function(done) {
        //uncomment below and update the code to test postProductCollectionCollection
        //instance.postProductCollectionCollection(function(error) {
        //  if (error) throw error;
        //expect().to.be();
        //});
        done();
      });
    });
    describe('putProductCollectionItem', function() {
      it('should call putProductCollectionItem successfully', function(done) {
        //uncomment below and update the code to test putProductCollectionItem
        //instance.putProductCollectionItem(function(error) {
        //  if (error) throw error;
        //expect().to.be();
        //});
        done();
      });
    });
  });

}));