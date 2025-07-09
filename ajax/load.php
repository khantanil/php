<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Load Data</title>
</head>
<body>
    <h2>Example of load data</h2>

    <button id="button">Get Data</button>
    <p id="test"></p>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function(){
            $('#button').click(function(){
                $('#test').load('test.html', function(responseTxt,statusTxt,xhr){
                    alert('Data loading completed...');
                    alert(responseTxt);
                    alert(statusTxt);
                    alert(xhr);
                });
            });
        });
    </script>
</body>
</html>