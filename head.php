<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo isset($page_title) ? $page_title : '猫の手CMS'; ?></title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Helvetica Neue', Arial, sans-serif;
      line-height: 1.6;
      color: #333;
    }

    header {
      background-color: #2c3e50;
      color: white;
      padding: 1rem 0;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .header-container {
      max-width: 1200px;
      margin: 0 auto;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0 20px;
    }

    .logo {
      font-size: 1.8rem;
      font-weight: bold;
      text-decoration: none;
      color: white;
    }

    nav ul {
      list-style: none;
      display: flex;
      gap: 30px;
    }

    nav a {
      color: white;
      text-decoration: none;
      font-weight: 500;
      transition: color 0.3s ease;
    }

    nav a:hover {
      color: #3498db;
    }

    main {
      min-height: calc(100vh - 140px);
      max-width: 1200px;
      margin: 0 auto;
      padding: 40px 20px;
    }
  </style>
</head>