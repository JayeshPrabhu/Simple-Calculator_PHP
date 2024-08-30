<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Calculator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .calculator-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        h2 {
            text-align: center;
            color: #4CAF50;
        }

        label {
            font-weight: bold;
            color: #555;
        }

        input[type="number"],
        select {
            width: 100%;
            padding: 10px;
            margin: 5px 0 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        input[type="submit"] {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .result {
            text-align: center;
            margin-top: 20px;
        }

        .result p {
            font-size: 18px;
            color: #333;
        }

        .error {
            color: red;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <div class="calculator-container">
        <h2>Simple Calculator</h2>
        
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="num1">Number 1:</label><br>
            <input type="number" id="num1" name="num1" step="any" required><br><br>

            <label for="num2">Number 2:</label><br>
            <input type="number" id="num2" name="num2" step="any" required><br><br>

            <label for="operation">Operation:</label><br>
            <select id="operation" name="operation" required>
                <option value="add">Addition (+)</option>
                <option value="subtract">Subtraction (-)</option>
                <option value="multiply">Multiplication (*)</option>
                <option value="divide">Division (/)</option>
            </select><br><br>

            <input type="submit" value="Calculate">
        </form>

        <?php
        // Form submission and calculation handling
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Sanitize input values
            $num1 = filter_input(INPUT_POST, "num1", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $num2 = filter_input(INPUT_POST, "num2", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $operator = htmlspecialchars($_POST["operation"]);

            // Error handling
            $errors = false;
            if (empty($num1) || empty($num2) || empty($operator)) {
                echo "<div class='error'>Error: All fields are required.</div>";
                $errors = true;
            }

            // Perform calculation if no errors
            if (!$errors) {
                switch ($operator) {
                    case "add":
                        $result = $num1 + $num2;
                        $operationText = "Addition";
                        break;
                    case "subtract":
                        $result = $num1 - $num2;
                        $operationText = "Subtraction";
                        break;
                    case "multiply":
                        $result = $num1 * $num2;
                        $operationText = "Multiplication";
                        break;
                    case "divide":
                        if ($num2 != 0) {
                            $result = $num1 / $num2;
                            $operationText = "Division";
                        } else {
                            echo "<div class='error'>Error: Division by zero is not allowed.</div>";
                            $errors = true;
                        }
                        break;
                    default:
                        echo "<div class='error'>Error: Invalid operation selected.</div>";
                        $errors = true;
                }

                // Display result if no errors
                if (!$errors) {
                    echo "<div class='result'>";
                    echo "<p>$operationText of $num1 and $num2 is: <strong>$result</strong></p>";
                    echo "</div>";
                }
            }
        }
        ?>
    </div>

</body>
</html>
