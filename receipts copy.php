<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .receipt {
            background-color: #fff;
            padding: 20px;
            width: 300px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        header {
            text-align: center;
            margin-bottom: 20px;
        }

        header h1 {
            margin: 0;
            font-size: 24px;
        }

        .transaction-details,
        .items,
        .totals {
            margin-bottom: 20px;
        }

        .items table {
            width: 100%;
            border-collapse: collapse;
        }

        .items th,
        .items td {
            text-align: left;
            padding: 8px;
            border: 1px solid #ddd;
        }

        .items th {
            background-color: #f2f2f2;
        }

        .items td {
            text-align: right;
        }

        .items td:first-child {
            text-align: left;
        }

        footer {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>


<body>

    <div class="receipt" id="receipt">
        <header>
            <h1>Mrs. G</h1>
            <p>Calamagui 2nd, City of Ilagan, Isabela</p>
            <p>Call no. <span>+63-9567543456</span></p>
        </header>

        <section class="transaction-details">
            <p>Date: 2024-06-20</p>
            <p>Receipt #: 000123</p>
        </section>

        <section class="items" style="margin-top: 40px">
            <table>
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Item 1</td>
                        <td>2</td>
                        <td>10.00</td>
                    </tr>
                    <tr>
                        <td>Item 2</td>
                        <td>1</td>
                        <td>$5.00</td>
                    </tr>
                    <tr>
                        <td>Item 3</td>
                        <td>3</td>
                        <td>7.00</td>
                    </tr>
                </tbody>
            </table>
        </section>

        <section class="totals">

            <div class="total">
                <span>Total:</span>
                <span>50.60</span>
            </div>
        </section>

        <footer>
            <p>Thank you for your purchase!</p>
        </footer>

        <a href="index.php">OK</a>


    </div>




</body>

</html>