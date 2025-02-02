<!DOCTYPE html>
<html>
    <head>
        <title>Expense Status Updated</title>
    </head>
    <body>
    <h1>Expense Status Updated</h1>
        <p>Hello {{ $expense->user->name }},</p>
        <p>The status of your expense with ID {{ $expense->id }} has been updated to {{ $expense->status->name }}.</p>
        <p>Thank you!</p>
    </body>
</html>
