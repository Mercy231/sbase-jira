<style>
    * {
        margin: 0;
        padding: 0;
    }
</style>
<!doctype html>
<html lang="en" style="height: 100vh;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body style="height: 100vh;">
<div class="pdf" style="display: flex;flex-direction: column;width: 100%;height: 100%;">
    <header class="pdfHeader" style="display:flex;justify-content:center;align-items:center;padding:20px;
            height:30px;background-color: gray;color: white;top: 0;">
        <h1 style="margin:0;padding:0">SBASE</h1>
    </header>
    <div class="content">
        <h5>{{ $item["File"] }}</h5>
        <ul>
            <li>Candidate Name: {{ $item["Candidate Name"] }}</li>
            <li>Test Date: {{ $item["Test Date"] }}</li>
            <li>Overall Score: {{ $item["Overall Score"] }}</li>
            <li>Terminology Score: {{ $item["Terminology Score"] }}</li>
            <li>Accuracy Score: {{ $item["Accuracy Score"] }}</li>
            <li>Grade: {{ $item["Grade"] }}</li>
            <li>Source: {{ $item["Source"] }}</li>
            <li>Accent/Pron: {{ $item["Accent/Pron"] }}</li>
            <li>Grammar and Syntax: {{ $item["Grammar and Syntax"] }}</li>
            <li>Target: {{ $item["Target"] }}</li>
            <li>Accent/Pron: {{ $item["Accent/Pron(2)"] }}</li>
            <li>Grammar and Syntax: {{ $item["Grammar and Syntax(2)"] }}</li>
        </ul>
    </div>
    <footer class="pdfFooter" style="position:absolute;padding:20px;height:30px;background-color:lightcoral;color:white;bottom:0;width:100%">
        <p>All rights reserved © 2022</p>
    </footer>
</div>
</body>
</html>
