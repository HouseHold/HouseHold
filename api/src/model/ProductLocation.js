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
 * The ProductLocation model module.
 * @module model/ProductLocation
 * @version 1.0.0
 */
class ProductLocation {
    /**
     * Constructs a new <code>ProductLocation</code>.
     * @alias module:model/ProductLocation
     */
    constructor() { 
        
        ProductLocation.initialize(this);
    }

    /**
     * Initializes the fields of this object.
     * This method is used by the constructors of any subclasses, in order to implement multiple inheritance (mix-ins).
     * Only for internal use.
     */
    static initialize(obj) { 
    }

    /**
     * Constructs a <code>ProductLocation</code> from a plain JavaScript object, optionally creating a new instance.
     * Copies all relevant properties from <code>data</code> to <code>obj</code> if supplied or a new instance if not.
     * @param {Object} data The plain JavaScript object bearing properties of interest.
     * @param {module:model/ProductLocation} obj Optional instance to populate.
     * @return {module:model/ProductLocation} The populated <code>ProductLocation</code> instance.
     */
    static constructFromObject(data, obj) {
        if (data) {
            obj = obj || new ProductLocation();

            if (data.hasOwnProperty('name')) {
                obj['name'] = ApiClient.convertToType(data['name'], 'String');
            }
            if (data.hasOwnProperty('products')) {
                obj['products'] = ApiClient.convertToType(data['products'], ['String']);
            }
            if (data.hasOwnProperty('id')) {
                obj['id'] = ApiClient.convertToType(data['id'], 'String');
            }
        }
        return obj;
    }


}

/**
 * @member {String} name
 */
ProductLocation.prototype['name'] = undefined;

/**
 * @member {Array.<String>} products
 */
ProductLocation.prototype['products'] = undefined;

/**
 * @member {String} id
 */
ProductLocation.prototype['id'] = undefined;






export default ProductLocation;
