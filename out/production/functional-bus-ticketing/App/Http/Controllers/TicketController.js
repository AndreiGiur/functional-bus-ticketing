const AWS = require('aws-sdk');
const { validateInput } = require('./validators'); // Add validation helper

// Mock Authenticated User (replace with actual token-based user retrieval if applicable)
const getAuthenticatedUser = async () => ({
id: 1,
balance: 100,
updateBalance: async (newBalance) => {
// Simulate updating user balance in the database
console.log(`Updating user balance to ${newBalance}`);
return true;
},
});

// Mock Models (replace with actual database interaction code)
const Ticket = {
async getAll() {
// Mock fetching tickets from a database
return [{ id: 1, name: '90-min Ticket' }, { id: 2, name: '1-Day Ticket' }];
},
};

const Transaction = {
async create(transactionData) {
// Mock transaction creation
console.log('Transaction created:', transactionData);
return transactionData;
},
};

// Lambda handler function
exports.handler = async (event) => {
try {
const { httpMethod, path, body } = event;

// Parse the body for POST/PUT requests
const parsedBody = body ? JSON.parse(body) : {};

// Route the request based on HTTP method and path (basic router emulation)
if (httpMethod === 'GET' && path === '/tickets') {
return listTickets();
} else if (httpMethod === 'POST' && path === '/tickets/buy') {
return buyTicket(parsedBody);
} else if (httpMethod === 'POST' && path === '/tickets/subscribe') {
return subscribe(parsedBody);
} else if (httpMethod === 'POST' && path === '/tickets/add-funds') {
return addFunds(parsedBody);
}

// Fallback for undefined routes
return {
statusCode: 404,
body: JSON.stringify({ message: 'Route not found' }),
};
} catch (err) {
console.error('Error:', err);
return {
statusCode: 500,
body: JSON.stringify({ message: 'Internal server error', error: err.message }),
};
}
};

// List tickets and purchase history
async function listTickets() {
const availableTickets = await Ticket.getAll();

// Mock fetching user's purchase history
const purchasedTickets = [
{ id: 1, name: '90-min Ticket', created_at: '2023-10-01' },
];

return {
statusCode: 200,
body: JSON.stringify({
availableTickets,
purchasedTickets,
}),
};
}

// Buy a ticket
async function buyTicket(requestBody) {
const ticketPrices = {
1: 3, // 90-min Ticket
2: 15, // 1-Day Subscription
3: 80, // Monthly Subscription
};

const ticketType = requestBody.ticketType;
if (!validateInput(ticketType, ['1', '2', '3'])) {
return {
statusCode: 400,
body: JSON.stringify({ message: 'Invalid ticket type selected' }),
};
}

const user = await getAuthenticatedUser();
const ticketPrice = ticketPrices[ticketType];

// Check user balance
if (user.balance < ticketPrice) {
return {
statusCode: 400,
body: JSON.stringify({ message: 'Insufficient funds' }),
};
}

// Deduct balance and save
await user.updateBalance(user.balance - ticketPrice);

// Record the purchase
await Transaction.create({
user_id: user.id,
amount: ticketPrice,
type: 'ticket_purchase',
status: 'completed',
});

return {
statusCode: 200,
body: JSON.stringify({ message: 'Ticket purchased successfully!' }),
};
}

// Subscribe to a ticket plan
async function subscribe(requestBody) {
const ticketPrices = {
2: 15, // 1-Day Subscription
3: 80, // Monthly Subscription
};

const ticketType = requestBody.ticketType;
if (!validateInput(ticketType, ['2', '3'])) {
return {
statusCode: 400,
body: JSON.stringify({ message: 'Invalid subscription type selected' }),
};
}

const user = await getAuthenticatedUser();
const ticketPrice = ticketPrices[ticketType];

// Check user balance
if (user.balance < ticketPrice) {
return {
statusCode: 400,
body: JSON.stringify({ message: 'Insufficient funds' }),
};
}

// Deduct balance and save
await user.updateBalance(user.balance - ticketPrice);

// Record the subscription
await Transaction.create({
user_id: user.id,
amount: ticketPrice,
type: 'subscription_purchase',
status: 'completed',
});

return {
statusCode: 200,
body: JSON.stringify({ message: 'Subscription purchased successfully!' }),
};
}

// Add funds to user balance
async function addFunds(requestBody) {
const { amount } = requestBody;
if (!amount || amount < 1) {
return {
statusCode: 400,
body: JSON.stringify({ message: 'Invalid amount. Minimum is 1.' }),
};
}

const user = await getAuthenticatedUser();
await user.updateBalance(user.balance + amount);

// Record the fund addition
await Transaction.create({
user_id: user.id,
amount,
type: 'fund_addition',
status: 'completed',
});

return {
statusCode: 200,
body: JSON.stringify({ message: 'Funds added successfully!' }),
};
}
