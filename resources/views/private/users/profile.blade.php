<!-- resources/views/private/users/profile.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - Halcon</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <style>
        :root {
            --primary-color: #000000;
            --secondary-color: #86868b;
            --accent-color: #0066cc;
            --background-color: #ffffff;
            --border-color: #d2d2d7;
            --hover-color: #f5f5f7;
            --success-color: #34c759;
            --error-color: #ff3b30;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            line-height: 1.5;
            color: var(--primary-color);
            background-color: var(--background-color);
        }

        .nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            z-index: 1000;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border-color);
        }

        .nav-logo {
            font-size: 1.5rem;
            font-weight: 600;
            text-decoration: none;
            color: var(--primary-color);
        }

        .nav-links {
            display: flex;
            gap: 2rem;
        }

        .nav-link {
            text-decoration: none;
            color: var(--secondary-color);
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: var(--primary-color);
        }

        .container {
            max-width: 800px;
            margin: 80px auto 0;
            padding: 2rem;
        }

        .page-header {
            margin-bottom: 2rem;
        }

        .page-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            background: linear-gradient(45deg, #000000, #333333);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .page-subtitle {
            color: var(--secondary-color);
            font-size: 1.1rem;
        }

        .profile-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .profile-header {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 2rem;
            border-bottom: 1px solid var(--border-color);
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background-color: var(--accent-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2.5rem;
            font-weight: 600;
            margin-right: 2rem;
        }

        .profile-info {
            flex: 1;
        }

        .profile-name {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .profile-role {
            color: var(--secondary-color);
            font-size: 1.1rem;
        }

        .profile-section {
            margin-bottom: 2rem;
        }

        .profile-section:last-child {
            margin-bottom: 0;
        }

        .section-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--primary-color);
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .info-item {
            display: flex;
            flex-direction: column;
        }

        .info-label {
            font-size: 0.9rem;
            color: var(--secondary-color);
            margin-bottom: 0.5rem;
        }

        .info-value {
            font-size: 1.1rem;
            font-weight: 500;
            color: var(--primary-color);
        }

        .role-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .role-admin {
            background-color: #e8f5e9;
            color: #2e7d32;
        }

        .role-user {
            background-color: #e3f2fd;
            color: #1976d2;
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            background-color: #f8f9fa;
            color: #212529;
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 1rem;
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .back-button:hover {
            background-color: var(--hover-color);
            transform: translateY(-2px);
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .back-button::before {
            content: "←";
            margin-right: 0.5rem;
            font-size: 1.1rem;
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
                margin-top: 60px;
            }

            .page-title {
                font-size: 2rem;
            }

            .nav {
                padding: 1rem;
            }

            .nav-links {
                display: none;
            }

            .profile-card {
                padding: 1.5rem;
            }

            .profile-header {
                flex-direction: column;
                text-align: center;
            }

            .profile-avatar {
                margin-right: 0;
                margin-bottom: 1rem;
            }
        }
    </style>
</head>
<body>
    <nav class="nav">
        <a href="{{ route('private.dashboard') }}" class="nav-logo">Halcon</a>
        <div class="nav-links">
            <a href="{{ route('private.orders.index') }}" class="nav-link">Orders</a>
            <a href="{{ route('private.users.index') }}" class="nav-link">Users</a>
        </div>
    </nav>

    <div class="container">
        <div class="page-header">
            <a href="{{ route('private.users.index') }}" class="back-button">
                ← Back to Users
            </a>
            <h1 class="page-title">User Profile</h1>
            <p class="page-subtitle">View detailed information about this user</p>
        </div>

        <div class="profile-card">
            <div class="profile-header">
                <div class="profile-avatar">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div class="profile-info">
                    <h2 class="profile-name">{{ $user->name }}</h2>
                    <span class="profile-role">{{ $user->role->name }}</span>
                </div>
            </div>

            <div class="profile-section">
                <h2 class="section-title">Account Information</h2>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Email Address</span>
                        <span class="info-value">{{ $user->email }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Role</span>
                        <span class="role-badge role-{{ strtolower($user->role->name) }}">
                            {{ $user->role->name }}
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Member Since</span>
                        <span class="info-value">{{ $user->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>

            @if($user->email_verified_at)
            <div class="profile-section">
                <h2 class="section-title">Account Status</h2>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Email Verification</span>
                        <span class="info-value">Verified on {{ $user->email_verified_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</body>
</html>
