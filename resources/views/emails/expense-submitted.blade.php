<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>New Expense Submitted</title>
    </head>
    <body>
        <h1>New Expense Submitted</h1>
        <p>A new expense has been submitted for approval. Here are the details:</p>

        <table>
            <tr>
                <th>Description:</th>
                <td>{{ $expense->description }}</td>
            </tr>
            <tr>
                <th>Amount:</th>
                <td>{{ number_format($expense->amount / 100, 2) }}</td>
            </tr>
            <tr>
                <th>Category:</th>
                <td>{{ $expense->category }}</td>
            </tr>
            <tr>
                <th>Status:</th>
                <td>{{ $expense->status->name }}</td>
            </tr>
        </table>

        <p>Please review and approve or reject this expense in the admin panel.</p>
    </body>
</html>
