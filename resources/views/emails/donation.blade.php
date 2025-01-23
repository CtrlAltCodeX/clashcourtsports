<!DOCTYPE html>
<html>

<head>
    <title>Welcome to Clash Court Sports</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }

        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background-color: #3a7bd5;
            background-image: linear-gradient(45deg, #3a7bd5, #00d2ff);
            color: #ffffff;
            text-align: center;
            padding: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }

        .content {
            padding: 20px;
            color: #333333;
            line-height: 1.6;
        }

        .content p {
            margin: 10px 0;
        }

        .footer {
            text-align: center;
            padding: 10px;
            background-color: #f4f4f9;
            font-size: 14px;
            color: #888888;
        }

        .btn {
            display: inline-block;
            background-color: #3a7bd5;
            color: #ffffff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 10px;
        }

        .btn:hover {
            background-color: #2a5ea0;
        }

        @media (max-width: 600px) {
            .email-container {
                margin: 10px;
            }

            .header h1 {
                font-size: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="header">
            <h1>You have recieved Donation</h1>
        </div>
        <div class="content">
            <p><strong>Name:</strong> {{ $customerDetails->name }}</p>
            <p><strong>Email:</strong> {{ $customerDetails->email }}</p>
            <p><strong>Plan:</strong> {{ $plan }}</p>
            <p><strong>Amount:</strong> {{ $amount }}</p>
        </div>
        <div class="footer">
            <p>&copy; 2025 Clash Court Sports. All rights reserved.</p>
        </div>
    </div>
</body>

</html>