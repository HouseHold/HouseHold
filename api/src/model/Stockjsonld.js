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
 * The Stockjsonld model module.
 * @module model/Stockjsonld
 * @version 1.0.0
 */
class Stockjsonld {
    /**
     * Constructs a new <code>Stockjsonld</code>.
     * @alias module:model/Stockjsonld
     */
    constructor() { 
        
        Stockjsonld.initialize(this);
    }

    /**
     * Initializes the fields of this object.
     * This method is used by the constructors of any subclasses, in order to implement multiple inheritance (mix-ins).
     * Only for internal use.
     */
    static initialize(obj) { 
    }

    /**
     * Constructs a <code>Stockjsonld</code> from a plain JavaScript object, optionally creating a new instance.
     * Copies all relevant properties from <code>data</code> to <code>obj</code> if supplied or a new instance if not.
     * @param {Object} data The plain JavaScript object bearing properties of interest.
     * @param {module:model/Stockjsonld} obj Optional instance to populate.
     * @return {module:model/Stockjsonld} The populated <code>Stockjsonld</code> instance.
     */
    static constructFromObject(data, obj) {
        if (data) {
            obj = obj || new Stockjsonld();

            if (data.hasOwnProperty('@context')) {
                obj['@context'] = ApiClient.convertToType(data['@context'], 'String');
            }
            if (data.hasOwnProperty('@id')) {
                obj['@id'] = ApiClient.convertToType(data['@id'], 'String');
            }
            if (data.hasOwnProperty('@type')) {
                obj['@type'] = ApiClient.convertToType(data['@type'], 'String');
            }
            if (data.hasOwnProperty('product')) {
                obj['product'] = ApiClient.convertToType(data['product'], 'String');
            }
            if (data.hasOwnProperty('location')) {
                obj['location'] = ApiClient.convertToType(data['location'], 'String');
            }
            if (data.hasOwnProperty('quantity')) {
                obj['quantity'] = ApiClient.convertToType(data['quantity'], 'Number');
            }
        }
        return obj;
    }


}

/**
 * @member {String} @context
 */
Stockjsonld.prototype['@context'] = undefined;

/**
 * @member {String} @id
 */
Stockjsonld.prototype['@id'] = undefined;

/**
 * @member {String} @type
 */
Stockjsonld.prototype['@type'] = undefined;

/**
 * @member {String} product
 */
Stockjsonld.prototype['product'] = undefined;

/**
 * @member {String} location
 */
Stockjsonld.prototype['location'] = undefined;

/**
 * @member {Number} quantity
 */
Stockjsonld.prototype['quantity'] = undefined;






export default Stockjsonld;
