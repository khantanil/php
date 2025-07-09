<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Load Users with AJAX</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        table {
            width: 80%;
            margin: 30px auto;
            border-collapse: collapse;
            font-family: Arial;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
        }

        h2 {
            text-align: center;
            font-family: Arial;
        }

        .delete-btn {
            display: block;
            margin: 0 auto 20px;
            background: red;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <h2>Delete Multiple Data with PHP & Ajax</h2>
    <button class="delete-btn" id="deleteSelected">Delete Selected</button>

    <div id="messageBox" style="text-align:center; margin-top:15px; font-weight:bold;"></div>
    <div id="userTable"></div>


    <script>
        $(document).ready(function() {
            // Load users
            function loadData() {
                $.ajax({
                    url: 'fetch_user.php',
                    method: 'GET',
                    success: function(data) {
                        $('#userTable').html(data);
                    }
                });
            }
            loadData();


            // Delete Functionality
            $('#deleteSelected').click(function() {
                let ids = [];
                $('.userCheckbox:checked').each(function(keys) {
                    ids[keys] = $(this).val();
                });

                if (ids.length === 0) {
                    $('#messageBox').html('<span style="color:red;">Please select at least one record to delete.</span>');
                } else {
                    if (confirm("Are you sure you want to delete selected users?")) {
                        $.ajax({
                            url: 'delete_user.php',
                            method: 'POST',
                            data: {
                                ids: ids
                            },
                            success: function(response) {
                                $('#messageBox').html('<div style="background-color: #28a745; color: white; padding: 10px; border-radius: 5px; width: 290px; margin: 0 auto; text-align: center; opacity:0.8;">' + response + '</div>');
                                loadData();
                                setTimeout(function() {
                                    $('#messageBox div').fadeOut('slow');
                                }, 3000);
                            },
                            error: function() {
                                $('#messageBox').html('<div style="background-color: #dc3545; color: white; padding: 10px; border-radius: 5px; width: 290px; margin: 0 auto; text-align: center;">An error occurred while deleting.</div>');
                                setTimeout(function() {
                                    $('#messageBox div').fadeOut('slow');
                                }, 3000);
                            }

                        });
                    }
                }
            });

        });
    </script>

</body>

</html>