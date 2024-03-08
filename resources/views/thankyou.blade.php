<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Thank You</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <div class="bg-light d-flex align-items-center justify-content-center" style="height: 100vh;">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="card shadow p-4">
            <h1 class="text-info text-center mt-3 mb-4">Thank you for choosing us!</h1>
            <p class="text-center">Congratulations on your purchase!</p>
            <p class="text-center">Your transaction is complete.</p>
            <div class="text-center mt-4">
              <a href="{{route('student.courses')}}" class="btn btn-secondary">Back to Home</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>