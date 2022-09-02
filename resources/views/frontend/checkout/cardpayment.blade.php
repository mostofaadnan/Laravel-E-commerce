<div class="card-body1">


    <div class="mb-2">
        <label>Name On Card <span>*</span></label>
        <input type="text" id="name_on_card" placeholder="Name On Card">
    </div>
  
        <div id="card-element">
            <!-- A Stripe Element will be inserted here. -->
        </div>
   

    <!-- Used to display form errors. -->
    <div id="card-errors" role="alert"></div>

</div>
<script src="https://js.stripe.com/v3/"></script>
<script>
    var stripe = Stripe('pk_test_51HJiyRB7t32nrvfBTQUCwUWmFDeu07CklDnP41EahmYMDQYdMiYeYbEv3zFC1WtWQ3TbIw5XbFytlTq3wjjxKw9W004J5YdCJJ');
    var elements = stripe.elements();

    // Custom styling can be passed to options when creating an Element.
    // (Note that this demo uses a wider set of styles than the guide below.)
    var style = {
        base: {
            color: '#32325d',
            lineHeight: '18px',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
                color: '#aab7c4'
            }
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
        }
    };

    // Create an instance of the card Element.
    var card = elements.create('card', {
        style: style
    });

    // Add an instance of the card Element into the `card-element` <div>.
    card.mount('#card-element');

    // Handle real-time validation errors from the card Element.
    card.addEventListener('change', function(event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });
</script>