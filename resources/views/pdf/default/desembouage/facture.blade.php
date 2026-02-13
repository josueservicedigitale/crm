<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Document par défaut</title>
  <style>
    body {
      font-family: Calibri, Arial, sans-serif;
      background-color: #f9f9f9;
      color: #333;
      margin: 40px;
      text-align: center;
    }

    .container {
      max-width: 700px;
      margin: auto;
      background: #fff;
      border: 2px solid #ccc;
      border-radius: 8px;
      padding: 40px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    h1 {
      font-size: 22pt;
      color: #C00000;
      margin-bottom: 20px;
      text-transform: uppercase;
    }

    p {
      font-size: 12pt;
      line-height: 1.6;
      margin: 15px 0;
    }

    .warning {
      margin-top: 30px;
      padding: 15px;
      border: 2px dashed #C00000;
      background-color: #fff8f8;
      font-size: 11pt;
      font-style: italic;
      color: #C00000;
    }

    .icon {
      font-size: 60px;
      color: #C00000;
      margin-bottom: 20px;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="icon">⚠️</div>
    <h1>Template par défaut</h1>
    <p>
      Ceci est un document générique utilisé par défaut.  
      Il apparaît parce qu’une nouvelle société vient d’être ajoutée mais n’a pas encore défini ses propres modèles PDF.
    </p>
    <div class="warning">
      Merci de définir le type de template que vous souhaitez incarner à votre PDF  
      ou contactez votre développeur.
    </div>
  </div>
</body>
</html>
