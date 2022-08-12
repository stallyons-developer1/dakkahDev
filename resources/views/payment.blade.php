<!DOCTYPE html>
<html>
<head>
    <title>Laravel 8 - Stripe Payment Gateway Integration Example - ItSolutionStuff.com</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bluebird/3.3.4/bluebird.min.js"></script>
    <script src="https://secure.gosell.io/js/sdk/tap.min.js"></script>
    <style type="text/css">
        .panel-title {
            display: inline;
            font-weight: bold;
        }
        .display-table {
            display: table;
        }
        .display-tr {
            display: table-row;
        }
        .display-td {
            display: table-cell;
            vertical-align: middle;
            width: 61%;
        }
    </style>
</head>
<body>

<div class="container">

    <h1>Payment Dakkah</h1>

    <form id="form-container" method="post">
        <!-- Tap element will be here -->
        <div id="element-container"></div>
        <div id="error-handler" role="alert"></div>
        <div id="success" style=" display: none;;position: relative;float: left;">
            Success! Your token is <span id="token"></span>
        </div>
        <!-- Tap pay button -->
        <button id="tap-btn">Submit</button>
    </form>
</div>

</body>

{{--<script type="text/javascript" src="https://js.stripe.com/v2/"></script>--}}

<script type="text/javascript">
    //pass your public key from tap's dashboard
    var tap = Tapjsli('pk_test_fZl13RTsNOLw6V7opUIbKAzS');

    var elements = tap.elements({});

    var style = {
        base: {
            color: '#535353',
            lineHeight: '18px',
            fontFamily: 'sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
                color: 'rgba(0, 0, 0, 0.26)',
                fontSize:'15px'
            }
        },
        invalid: {
            color: 'red'
        }
    };
    // input labels/placeholders
    var labels = {
        cardNumber:"Card Number",
        expirationDate:"MM/YY",
        cvv:"CVV",
        cardHolder:"Card Holder Name"
    };
    //payment options
    var paymentOptions = {
        currencyCode:["KWD","USD","SAR"],
        labels : labels,
        TextDirection:'ltr'
    }
    //create element, pass style and payment options
    var card = elements.create('card', {style: style},paymentOptions);
    //mount element
    card.mount('#element-container');
    //card change event listener
    card.addEventListener('change', function(event) {
        if(event.loaded){
            console.log("UI loaded :"+event.loaded);
            console.log("current currency is :"+card.getCurrency())
        }
        var displayError = document.getElementById('error-handler');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });
    // Handle form submission
    var form = document.getElementById('form-container');
    form.addEventListener('submit', function(event) {
        event.preventDefault();

        tap.createToken(card).then(function(result) {
            console.log(result);
            if (result.error) {
                // Inform the user if there was an error
                var errorElement = document.getElementById('error-handler');
                errorElement.textContent = result.error.message;
            } else {
                // Send the token to your server
                var errorElement = document.getElementById('success');
                errorElement.style.display = "block";
                var tokenElement = document.getElementById('token');
                tokenElement.textContent = result.id;
                tapTokenHandler(token)

            }
        });
    });

    function tapTokenHandler(token) {
        // Insert the token ID into the form so it gets submitted to the server
        // var form = document.getElementById('payment-form');
        var hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'tapToken');
        hiddenInput.setAttribute('value', token.id);
        form.appendChild(hiddenInput);
        console.log(form)
        // Submit the form
        // form.submit();
    }
</script>
</html>
