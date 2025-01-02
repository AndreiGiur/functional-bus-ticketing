import { validateInput } from './validators.js'; // Import validation function

// Mock Authenticated User (Replace this with actual DB authentication later)
const getAuthenticatedUser = async () => ({
    id: 1,
    balance: 100,
    updateBalance: async (newBalance) => {
        console.log(`Updating user balance to ${newBalance}`);
        return true;
    },
});

// Mock Models
const Ticket = {
    async getAll() {
        return [
            { id: 1, name: '90-min Ticket', price: 3 },
            { id: 2, name: '1-Day Ticket', price: 15 },
            { id: 3, name: 'Monthly Subscription', price: 80 },
        ];
    },
};

const Transaction = {
    async create(transactionData) {
        console.log('Transaction created:', transactionData);
        return transactionData;
    },
};

// Lambda handler function
export async function handler(event) {
    try {
        const { httpMethod, path, body } = event;
        const parsedBody = body ? JSON.parse(body) : {};

        switch (`${httpMethod} ${path}`) {
            case 'GET /tickets':
                return await listTickets();
            case 'POST /tickets/buy':
                return await buyTicket(parsedBody);
            case 'POST /tickets/subscribe':
                return await subscribe(parsedBody);
            case 'POST /tickets/add-funds':
                return await addFunds(parsedBody);
            default:
                return { statusCode: 404, body: JSON.stringify({ message: 'Route not found' }) };
        }
    } catch (err) {
        console.error('Error:', err);
        return { statusCode: 500, body: JSON.stringify({ message: 'Internal server error', error: err.message }) };
    }
}

// List Tickets
async function listTickets() {
    const availableTickets = await Ticket.getAll();
    const purchasedTickets = [
        { id: 1, name: '90-min Ticket', created_at: '2023-10-01' },
    ];

    return {
        statusCode: 200,
        body: JSON.stringify({ availableTickets, purchasedTickets }),
    };
}

// Buy Ticket
async function buyTicket(requestBody) {
    const ticketPrices = { 1: 3, 2: 15, 3: 80 };
    const ticketType = requestBody.ticketType;

    if (!validateInput(ticketType, ['1', '2', '3'])) {
        return { statusCode: 400, body: JSON.stringify({ message: 'Invalid ticket type' }) };
    }

    const user = await getAuthenticatedUser();
    const price = ticketPrices[ticketType];

    if (user.balance < price) {
        return { statusCode: 400, body: JSON.stringify({ message: 'Insufficient funds' }) };
    }

    await user.updateBalance(user.balance - price);
    await Transaction.create({ user_id: user.id, amount: price, type: 'ticket_purchase', status: 'completed' });

    return { statusCode: 200, body: JSON.stringify({ message: 'Ticket purchased successfully!' }) };
}

// Subscribe to Ticket
async function subscribe(requestBody) {
    const ticketPrices = { 2: 15, 3: 80 };
    const ticketType = requestBody.ticketType;

    if (!validateInput(ticketType, ['2', '3'])) {
        return { statusCode: 400, body: JSON.stringify({ message: 'Invalid subscription type' }) };
    }

    const user = await getAuthenticatedUser();
    const price = ticketPrices[ticketType];

    if (user.balance < price) {
        return { statusCode: 400, body: JSON.stringify({ message: 'Insufficient funds' }) };
    }

    await user.updateBalance(user.balance - price);
    await Transaction.create({ user_id: user.id, amount: price, type: 'subscription_purchase', status: 'completed' });

    return { statusCode: 200, body: JSON.stringify({ message: 'Subscription purchased successfully!' }) };
}

// Add Funds
async function addFunds(requestBody) {
    const { amount } = requestBody;

    if (!amount || amount < 1) {
        return { statusCode: 400, body: JSON.stringify({ message: 'Invalid amount. Minimum is 1.' }) };
    }

    const user = await getAuthenticatedUser();
    await user.updateBalance(user.balance + amount);
    await Transaction.create({ user_id: user.id, amount, type: 'fund_addition', status: 'completed' });

    return { statusCode: 200, body: JSON.stringify({ message: 'Funds added successfully!' }) };
}
