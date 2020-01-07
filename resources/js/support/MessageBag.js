export default class MessageBag {
    /**
     * MessageBag constructor.
     *
     * @param  {Object}  messages
     */
    constructor(messages = {}) {
        this.messages = messages;
    }

    /**
     * Add a message to the bag.
     *
     * @param  {String}  field
     * @param  {Array|String}  message
     * @return {Object}
     */
    add(field, message) {
        message = typeof message === 'string' ? [message] : message;

        this.messages[field] = message;

        return this;
    }

    /**
     * Get the message for a given field (if any).
     *
     * @param  {String}  field
     * @return {String|Undefined}
     */
    get(field) {
        if (this.messages[field]) {
            return this.messages[field][0];
        }
    }

    /**
     * Alias of the get method.
     *
     * @param  {String}  field
     * @return {String|Undefined}
     */
    first(field) {
        return this.get(field);
    }

    /**
     * Determine if the message bag has a message for the given field.
     *
     * @param  {String}  field
     * @return {Boolean}
     */
    has(field) {
        return this.messages.hasOwnProperty(field);
    }

    /**
     * Clear the messages for a given field.
     *
     * @param  {String}  field
     * @return {Object}
     */
    pull(field) {
        delete this.messages[field];

        return this;
    }

    /**
     * Alias for the pull method.
     *
     * @param  {String}  field
     * @return {Object}
     */
    clear(field) {
        return this.pull(field);
    }

    /**
     * Determines if the message bag is empty.
     *
     * @return {Boolean}
     */
    isEmpty() {
        return Object.keys(this.messages).length === 0;
    }

    /**
     * Determine if the message bag has any messages.
     *
     * @uses isEmpty
     * @returns {Boolean}
     */
    isNotEmpty() {
        return !this.isEmpty();
    }

    /**
     * Get all of the messages for every key in the bag.
     *
     * @returns {Object}
     */
    all() {
        return this.messages;
    }
}
