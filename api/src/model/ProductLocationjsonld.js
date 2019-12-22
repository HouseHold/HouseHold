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
 * The ProductLocationjsonld model module.
 * @module model/ProductLocationjsonld
 * @version 1.0.0
 */
class ProductLocationjsonld {
    /**
     * Constructs a new <code>ProductLocationjsonld</code>.
     * @alias module:model/ProductLocationjsonld
     */
    constructor() { 
        
        ProductLocationjsonld.initialize(this);
    }

    /**
     * Initializes the fields of this object.
     * This method is used by the constructors of any subclasses, in order to implement multiple inheritance (mix-ins).
     * Only for internal use.
     */
    static initialize(obj) { 
    }

    /**
     * Constructs a <code>ProductLocationjsonld</code> from a plain JavaScript object, optionally creating a new instance.
     * Copies all relevant properties from <code>data</code> to <code>obj</code> if supplied or a new instance if not.
     * @param {Object} data The plain JavaScript object bearing properties of interest.
     * @param {module:model/ProductLocationjsonld} obj Optional instance to populate.
     * @return {module:model/ProductLocationjsonld} The populated <code>ProductLocationjsonld</code> instance.
     */
    static constructFromObject(data, obj) {
        if (data) {
            obj = obj || new ProductLocationjsonld();

            if (data.hasOwnProperty('@context')) {
                obj['@context'] = ApiClient.convertToType(data['@context'], 'String');
            }
            if (data.hasOwnProperty('@id')) {
                obj['@id'] = ApiClient.convertToType(data['@id'], 'String');
            }
            if (data.hasOwnProperty('@type')) {
                obj['@type'] = ApiClient.convertToType(data['@type'], 'String');
            }
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
 * @member {String} @context
 */
ProductLocationjsonld.prototype['@context'] = undefined;

/**
 * @member {String} @id
 */
ProductLocationjsonld.prototype['@id'] = undefined;

/**
 * @member {String} @type
 */
ProductLocationjsonld.prototype['@type'] = undefined;

/**
 * @member {String} name
 */
ProductLocationjsonld.prototype['name'] = undefined;

/**
 * @member {Array.<String>} products
 */
ProductLocationjsonld.prototype['products'] = undefined;

/**
 * @member {String} id
 */
ProductLocationjsonld.prototype['id'] = undefined;






export default ProductLocationjsonld;

