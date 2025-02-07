<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LibroNext - Modern Library Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Modern CSS Reset and Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #2563eb;
            --primary-hover: #1d4ed8;
            --dark: #0f172a;
            --light: #f8fafc;
            --gray: #64748b;
            --glass: rgba(255, 255, 255, 0.05);
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.5;
            background-color: var(--light);
            color: var(--dark);
            transition: background-color 0.3s;
        }

        /* Dark Mode */
        .dark-mode {
            --light: #0f172a;
            --dark: #f8fafc;
            --gray: #94a3b8;
            --glass: rgba(15, 23, 42, 0.1);
        }

        /* Header Styles */
        header {
            background: var(--glass);
            backdrop-filter: blur(10px);
            position: fixed;
            width: 100%;
            padding: 1rem 5%;
            z-index: 1000;
            box-shadow: var(--shadow);
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .nav-links a {
            color: var(--dark);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: var(--primary);
        }

        .theme-toggle {
            background: none;
            border: none;
            cursor: pointer;
            color: var(--dark);
            font-size: 1.2rem;
        }

        /* Hero Section */
        .hero {
            padding: 8rem 5% 4rem;
            min-height: 100vh;
            display: flex;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
        }

        .hero-content {
            flex: 1;
            padding-right: 2rem;
        }

        .hero-content h1 {
            font-size: 3.5rem;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .hero-content p {
            font-size: 1.25rem;
            color: var(--gray);
            margin-bottom: 2rem;
        }

        .cta-group {
            display: flex;
            gap: 1rem;
        }

        .cta-button {
            padding: 1rem 2rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: transform 0.3s, box-shadow 0.3s;
            border: 2px solid var(--primary);
        }

        .primary-cta {
            background: var(--primary);
            color: white;
        }

        .secondary-cta {
            background: transparent;
            color: var(--primary);
        }

        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }

        .hero-image {
            flex: 1;
            position: relative;
            border-radius: 1rem;
            overflow: hidden;
            height: 500px;
            background: #e2e8f0;
        }

        .hero-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Features Section */
        .features {
            padding: 4rem 5%;
            background: var(--light);
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .feature-card {
            padding: 2rem;
            border-radius: 1rem;
            background: var(--light);
            box-shadow: var(--shadow);
            transition: transform 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-5px);
        }

        .feature-icon {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 1rem;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .hero {
                flex-direction: column;
                text-align: center;
                padding-top: 6rem;
            }

            .hero-content {
                padding-right: 0;
                margin-bottom: 3rem;
            }

            .cta-group {
                justify-content: center;
            }

            .nav-links {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .hero-content h1 {
                font-size: 2.5rem;
            }

            .hero-image {
                height: 300px;
            }
        }
    </style>
</head>

<body>
    <header>
        <nav>
            <div class="logo">LibroNext</div>
            <div class="nav-links">
                <a href="#features">Features</a>
                <a href="#about">About</a>
                <a href="#contact">Contact</a>
                <button class="theme-toggle" onclick="toggleTheme()">
                    <i class="fas fa-moon"></i>
                </button>
            </div>
        </nav>
    </header>

    <section class="hero">
        <div class="hero-content">
            <h1>Next-Gen Library Management Made Simple</h1>
            <p>Transform your library operations with AI-powered management solutions and real-time analytics.</p>
            <div class="cta-group">
                <button class="cta-button primary-cta">Start Free Trial</button>
                <button class="cta-button secondary-cta">Watch Demo</button>
            </div>
        </div>
        <div class="hero-image">
            <!-- Add your image here -->
            <img src="library-hero.jpg" alt="Modern library interface">
        </div>
    </section>

    <section class="features" id="features">
        <div class="features-grid">
            <div class="feature-card">
                <i class="fas fa-brain feature-icon"></i>
                <h3>AI-Powered Insights</h3>
                <p>Get intelligent recommendations for collection development and user engagement</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-mobile-alt feature-icon"></i>
                <h3>Mobile First</h3>
                <p>Fully responsive interface with dedicated mobile apps for users and staff</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-chart-line feature-icon"></i>
                <h3>Real-Time Analytics</h3>
                <p>Comprehensive dashboard with usage statistics and predictive analytics</p>
            </div>
        </div>
    </section>

    <script>
        function toggleTheme() {
            document.body.classList.toggle('dark-mode');
            const themeToggle = document.querySelector('.theme-toggle');
            themeToggle.innerHTML = document.body.classList.contains('dark-mode') ?
                '<i class="fas fa-sun"></i>' : '<i class="fas fa-moon"></i>';
        }
    </script>
</body>

</html>