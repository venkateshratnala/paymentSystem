<!DOCTYPE html>

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Ensures optimal rendering on mobile devices. -->
</head>

<body>
    <script src="<?php echo $src; ?>"></script>
    <div class="row">
        <div id="paypal-button-container" style="max-width:100px;"></div>
        <script>
            var plan_id = "<?php echo $plan_id; ?>";
            var onAppproveurl = "<?php echo $apurl; ?>";

            paypal.Buttons({
              style: {
                    layout: 'vertical',
                    color: 'gold',
                    shape: 'pill',
                    label: 'checkout',
                    
                },
                createSubscription: function(data, actions) {
                    return actions.subscription.create({
                        'plan_id': plan_id // Creates the subscription
                    });
                },
                onApprove: function(data, actions) {
                    return fetch(onAppproveurl, {
                            method: "POST",
                            headers: {
                                "Content-type": "application/json", // We are sending JSON data
                            },
                            body: JSON.stringify({
                                data: data,
                                userId:{{auth()->user()->id}},
                                requestId:{{$requestId}}
                            })
                        })
                        .then((response) => response.json())
                        .then((details) => {
                            // This function shows a transaction success message to your buyer.
                            alert('Transaction completed by ' + details.payer.name.given_name);
                        });
                },
                onCancel: function(data) {
                    console.log(data);
    
                },
                onError(err) {
                    console.log(error)
                }
            }).render('#paypal-button-container'); // Renders the PayPal button
          
        </script>
    </div>
</body>

</html>
