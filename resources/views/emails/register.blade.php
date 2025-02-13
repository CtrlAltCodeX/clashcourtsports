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
            <h1>Welcome to Clash Court Sports, {{ $contact['first_name'] }}!</h1>
        </div>
        <div class="content">
            <p>We are thrilled to announce that you have successfully registered for the <strong>{{ $contact['season_name'] }}</strong> season. {{ \Illuminate\Support\Str::ucfirst($skill_level) }}, {{ \Illuminate\Support\Str::ucfirst($selected_game) }}</p>
            <p>Get ready for an unforgettable experience filled with excitement, competition, and camaraderie. Whether you're here to sharpen your skills, make new friends, or simply enjoy the game you love, you're now part of a vibrant community that lives and breathes sports.</p>
            <p>At Clash Court Sports, every match is a chance to bring your best and create lasting memories on and off the court.</p>
            <!-- <a href="#" class="btn">Visit Your Dashboard</a> -->
        </div>
        <div class="footer">
            <p>&copy; 2025 Clash Court Sports. All rights reserved.</p>
        </div>
    </div>
</body>

</html>