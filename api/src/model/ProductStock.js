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

import ApiClient from '../ApiClient';

/**
 * The ProductStock model module.
 * @module model/ProductStock
 * @version 1.0.0
 */
class ProductStock {
    /**
     * Constructs a new <code>ProductStock</code>.
     * @alias module:model/ProductStock
     */
    constructor() { 
        
        ProductStock.initialize(this);
    }

    /**
     * Initializes the fields of this object.
     * This method is used by the constructors of any subclasses, in order to implement multiple inheritance (mix-ins).
     * Only for internal use.
     */
    static initialize(obj) { 
    }

    /**
     * Constructs a <code>ProductStock</code> from a plain JavaScript object, optionally creating a new instance.
     * Copies all relevant properties from <code>data</code> to <code>obj</code> if supplied or a new instance if not.
     * @param {Object} data The plain JavaScript object bearing properties of interest.
     * @param {module:model/ProductStock} obj Optional instance to populate.
     * @return {module:model/ProductStock} The populated <code>ProductStock</code> instance.
     */
    static constructFromObject(data, obj) {
        if (data) {
            obj = obj || new ProductStock();

            if (data.hasOwnProperty('product')) {
                obj['product'] = ApiClient.convertToType(data['product'], 'String');
            }
            if (data.hasOwnProperty('location')) {
                obj['location'] = ApiClient.convertToType(data['location'], 'String');
            }
            if (data.hasOwnProperty('quantity')) {
                obj['quantity'] = ApiClient.convertToType(data['quantity'], 'Number');
            }
            if (data.hasOwnProperty('id')) {
                obj['id'] = ApiClient.convertToType(data['id'], 'String');
            }
        }
        return obj;
    }


}

/**
 * @member {String} product
 */
ProductStock.prototype['product'] = undefined;

/**
 * @member {String} location
 */
ProductStock.prototype['location'] = undefined;

/**
 * @member {Number} quantity
 */
ProductStock.prototype['quantity'] = undefined;

/**
 * @member {String} id
 */
ProductStock.prototype['id'] = undefined;






export default ProductStock;
