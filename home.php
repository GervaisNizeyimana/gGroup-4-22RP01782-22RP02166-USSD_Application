<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AI-Powered Recruiter</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      background-color: #121212;
      margin: 0;
      font-family: 'Poppins', sans-serif;
      color: #4CAF50;
      animation: fadeIn 2s;
      overflow-y: auto; /* Allow vertical scrolling */
    }

    main {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      background-image: url('https://www.example.com/ai-background.jpg'); /* Replace with a relevant AI-related background image */
      background-size: cover;
      background-position: center;
      min-height: 100vh; /* Allow content to exceed the height if necessary */
      position: relative;
      padding: 20px;
    }

    .animated-text {
      font-size: 32px;
      font-weight: 600;
      margin-bottom: 40px;
      animation: float 3s ease-in-out infinite, glow 2s ease-in-out infinite alternate;
      padding: 0 20px;
      text-shadow: 0 0 8px #4CAF50, 0 0 16px #4CAF50, 0 0 24px #4CAF50;
      color: white;
      z-index: 10;
    }

    .btn-custom {
      background-color: rgba(59, 89, 152, 0.8); /* Semi-transparent background */
      color: white;
      padding: 12px 40px;
      font-size: 20px;
      margin: 10px;
      border: none;
      border-radius: 8px;
      transition: background-color 0.3s, transform 0.3s;
      text-decoration: none;
      z-index: 10;
    }

    .btn-custom:hover {
      background-color: rgba(45, 67, 115, 0.8);
      transform: scale(1.05);
    }

    footer {
      text-align: center;
      padding: 15px 0;
      font-size: 14px;
      color: #888;
      background-color: #1a1a1a;
    }

    .features {
      background-color: #333;
      padding: 50px 20px;
      color: #fff;
    }

    .features h2 {
      font-size: 36px;
      margin-bottom: 30px;
    }

    .feature-item {
      display: flex;
      align-items: center;
      margin-bottom: 30px;
    }

    .feature-item i {
      font-size: 30px;
      margin-right: 15px;
      color: #4CAF50;
    }

    .feature-item p {
      font-size: 18px;
    }

    @keyframes float {
      0% {
        transform: translateY(0px);
      }
      50% {
        transform: translateY(-20px);
      }
      100% {
        transform: translateY(0px);
      }
    }

    @keyframes glow {
      from {
        text-shadow: 0 0 8px #4CAF50, 0 0 16px #4CAF50, 0 0 24px #4CAF50;
      }
      to {
        text-shadow: 0 0 12px #4CAF50, 0 0 20px #4CAF50, 0 0 30px #4CAF50;
      }
    }

    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }
  </style>
</head>

<body>

<main>
  <div class="animated-text">
    Do you want highly qualified employees without your intervention? <br> <strong>This system is here.</strong>
  </div>

  <div class="d-flex flex-wrap justify-content-center">
    <a href="login.php" class="btn btn-custom mx-2">Login</a>
    <a href="register.php" class="btn btn-custom mx-2">Register</a>
    <a href="#features" class="btn btn-custom mx-2">Learn More</a>
  </div>
</main>

<section id="features" class="features">
  <div class="container">
    <h2>Key Features</h2>
    <div class="row">
      <div class="col-md-4 feature-item">
        <i class="bi bi-pencil-square"></i>
        <p>AI-generated challenging exams tailored to job roles</p>
      </div>
      <div class="col-md-4 feature-item">
        <i class="bi bi-camera"></i>
        <p>Monitor candidates' cameras for anti-cheating measures</p>
      </div>
      <div class="col-md-4 feature-item">
        <i class="bi bi-person-check"></i>
        <p>Automated interview scheduling and candidate shortlisting</p>
      </div>
      <div class="col-md-4 feature-item">
        <i class="bi bi-shield-lock"></i>
        <p>Secure data handling and privacy protection</p>
      </div>
      <div class="col-md-4 feature-item">
        <i class="bi bi-file-earmark-earphones"></i>
        <p>Real-time exam result analysis and feedback</p>
      </div>
      <div class="col-md-4 feature-item">
        <i class="bi bi-person-badge"></i>
        <p>Personalized candidate profiles and performance tracking</p>
      </div>
    </div>
  </div>
</section>

<footer>
  &copy; 2025 AI-Powered Recruiter. All rights reserved.
</footer>

</body>
</html>
