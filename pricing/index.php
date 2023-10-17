<?php 

  session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <link href="https://fonts.googleapis.com/css?family=Karla:400,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.8.95/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/pricing-plan.css">
</head>
<body>
  <main>
    <div class="container">
      <h1 class="text-center pricing-table-title">Pricing Plans</h1>

      <div class="tab-content pricing-tab-content" id="pricing-tab-content">
        <div class="tab-pane active" id="monthly" role="tabpanel" aria-labelledby="monthly-tab">
          <div class="row">

            <div class="col-md-12">
              <div class="card pricing-card">
                <div class="card-body">
                  <h3 class="pricing-plan-title d-flex align-items-center">Enterprise <span
                      class="badge badge-pill offer-badge ml-auto">20% off</span></h3>
                  <p class="h1 pricing-plan-original-cost"><del>$23.00</del></p>
                  <p class="h1 pricing-plan-cost">10.99 <span class="currency">USD</span></p>
                  <ul class="pricing-plan-features">
                    <li>5GB file storage</li>
                    <li>File manager</li>
                    <li>Upgrade any time</li>
                    <li>5GB file storage</li>
                    <li>File manager</li>
                    <li>Upgrade any time</li>
                    <li>5GB file storage</li>                  
                  </ul>
                  <a href="payment.php" class="btn pricing-plan-purchase-btn">Get started</a>
                  <div class="text-center">
                    <a href="#!" class="pricing-plan-link">Learn more</a>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>

    </div>
  </main>
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>
