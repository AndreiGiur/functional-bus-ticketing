export function validateInput(value, allowedValues) {
    return allowedValues.includes(value.toString());
}

// Validation function to check if the amount is valid
export function validateAmount(amount) {
    return typeof amount === 'number' && amount > 0;
}

// Validation function to check if an object has required properties
export function validateRequestBody(body, requiredFields) {
    return requiredFields.every(field => body.hasOwnProperty(field));
}
