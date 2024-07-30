<?php require_once "controllerUserData.php"; ?>
<?php 
$email = $_SESSION['email'];
if($email == false){
  header('Location: login-user.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Code Verification</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="otp.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 50px;
        }
        .form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .form h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .otp-input-container {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        .otp-input-container input {
            width: 40px;
            height: 40px;
            margin: 0 5px;
            text-align: center;
            font-size: 18px;
            border: 1px solid #ccc;
            border-radius: 4px;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
        .otp-input-container input:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        .button {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }
        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3 form">
                <form action="user-otp.php" method="POST" autocomplete="off">
                    <h2 class="text-center">Code Verification</h2>
                    <?php if(isset($_SESSION['info'])) { ?>
                        <div class="alert alert-success text-center">
                            <?php echo $_SESSION['info']; ?>
                        </div>
                    <?php } ?>
                    <?php if(count($errors) > 0) { ?>
                        <div class="alert alert-danger text-center">
                            <?php foreach($errors as $showerror) { echo $showerror; } ?>
                        </div>
                    <?php } ?>
                    <div class="otp-input-container">
                        <input class="form-control" type="text" name="digit1" maxlength="1" pattern="\d{1}" oninput="moveToNext(this, 'digit2')" required>
                        <input class="form-control" type="text" name="digit2" maxlength="1" pattern="\d{1}" oninput="moveToNext(this, 'digit3')" required>
                        <input class="form-control" type="text" name="digit3" maxlength="1" pattern="\d{1}" oninput="moveToNext(this, 'digit4')" required>
                        <input class="form-control" type="text" name="digit4" maxlength="1" pattern="\d{1}" oninput="moveToNext(this, 'digit5')" required>
                        <input class="form-control" type="text" name="digit5" maxlength="1" pattern="\d{1}" oninput="moveToNext(this, 'digit6')" required>
                        <input class="form-control" type="text" name="digit6" maxlength="1" pattern="\d{1}" oninput="moveToNext(this, null)" required>
                    </div>
                    <div class="form-group text-center">
                        <input class="form-control button" type="submit" name="check" value="Submit">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function moveToNext(currentInput, nextInputName) {
            if (currentInput.value.length >= 1 && nextInputName) {
                document.getElementsByName(nextInputName)[0].focus();
            }
        }
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Backspace') {
                const inputs = document.querySelectorAll('.otp-input-container input');
                for (let i = inputs.length - 1; i >= 0; i--) {
                    if (inputs[i] === document.activeElement && i > 0) {
                        inputs[i - 1].focus();
                        break;
                    }
                }
            }
        });
    </script>
</body>
</html>