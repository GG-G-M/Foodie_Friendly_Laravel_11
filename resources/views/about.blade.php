<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About | Foodie Frenzy</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(to bottom, #8B5A2B, #D2B48C, #8B5A2B);
            color: #3E2723;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 20px;
        }
        .content {
            max-width: 800px;
        }
        .section-title {
            font-size: 2.2rem;
            font-weight: bold;
            color: #5D4037;
            text-transform: uppercase;
            margin-bottom: 15px;
        }
        .highlight-text {
            font-size: 1.2rem;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            line-height: 1.6;
            background: rgba(210, 180, 140, 0.9);
            color: #3E2723;
        }
        .feature-list, .steps-list {
            padding: 0;
            list-style: none;
        }
        .feature-list li, .steps-list li {
            background: rgba(160, 82, 45, 0.8);
            padding: 15px;
            margin-bottom: 10px;
            font-size: 1.1rem;
            text-align: left;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(139, 69, 19, 0.3);
            transition: transform 0.2s ease-in-out, background 0.3s;
            color: white;
        }
        .feature-list li:hover, .steps-list li:hover {
            transform: scale(1.02);
            background: rgba(139, 69, 19, 1);
        }
        .steps-list li {
            background: rgba(101, 67, 33, 0.9);
        }
        .btn-custom {
            background: #8B4513;
            color: white;
            padding: 12px;
            font-size: 1.2rem;
            width: 100%;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            transition: background 0.3s, transform 0.2s;
        }
        .btn-custom:hover {
            background: #5D4037;
            transform: scale(1.05);
        }
    </style>
</head>
<body>

    <div class="content">
        <h1 class="section-title">About Our System</h1>

        <p class="highlight-text">
            Our <strong>Order Management System</strong> provides a **smooth, efficient, and hassle-free** ordering experience.  
            Whether it’s **dine-in, takeout, or delivery**, our system ensures **accuracy and fast transactions** for customers and businesses alike.
        </p>

        <hr class="text-dark">

        <h3 class="text-dark fw-bold">🚀 Key Features</h3>

        <p class="highlight-text">
            <strong>Easy Ordering:</strong> Quickly add, edit, or remove food items, ensuring a hassle-free experience.
        </p>

        <p class="highlight-text">
            <strong>Menu Categories:</strong> Enjoy a well-organized menu with dedicated sections for Grilled Items, Rice, and Drinks.
        </p>

        <p class="highlight-text">
            <strong>Transaction Management:</strong> Instantly calculate total prices before checkout, eliminating errors and confusion.
        </p>

        <p class="highlight-text">
            <strong>Receipt Generation:</strong> Receive a clear and detailed order summary after every transaction.
        </p>

        <p class="highlight-text">
            <strong>Admin Dashboard:</strong> Effortlessly manage orders, track sales, and have full control over the system.
        </p>

        <hr class="text-dark">

        <h3 class="text-dark fw-bold">🔍 How It Works</h3>

        <p class="highlight-text">
            <strong>1️⃣ Login:</strong> Sign in as an admin or customer to access the system.
        </p>

        <p class="highlight-text">
            <strong>2️⃣ Select Items:</strong> Browse through categories and choose your favorite Grilled Items, Rice, or Drinks.
        </p>

        <p class="highlight-text">
            <strong>3️⃣ Confirm Order:</strong> Review your selections and finalize the order with ease.
        </p>

        <p class="highlight-text">
            <strong>4️⃣ Generate Receipt:</strong> Instantly receive a detailed summary of your transaction.
        </p>

        <p class="highlight-text">
            <strong>5️⃣ Track Orders:</strong> Access your order history anytime for reference.
        </p>

        <div class="mt-3">
            <a href="{{ route('login') }}" class="btn btn-custom">
                Go to Login 
            </a>
        </div>

    </div>

</body>
</html>
