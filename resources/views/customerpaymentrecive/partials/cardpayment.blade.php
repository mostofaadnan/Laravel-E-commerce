<style>
  #card-element{
    border:1px #001f3f solid;
  }
</style>
<div class="input-group">
  <div class="input-group-prepend">
    <span class="input-group-text">@lang('home.amount')</span>
  </div>
  <input type="text" class="form-control" id="cardamount" placeholder="@lang('home.amount')" readonly>
</div>

<div class="input-group">
  <div class="input-group-prepend">
    <span class="input-group-text">@lang('home.name') @lang('home.on') @lang('home.card')</span>
  </div>
  <input autocomplete='off' id="name_on_card" class='form-control card-number sumsection-input-text' size='20' type='text'>
</div>
<!-- <form action="/charge" method="post" id="payment-form"> -->


<div id="card-element">
  <!-- A Stripe Element will be inserted here. -->
</div>

<!-- Used to display form errors. -->
<div id="card-errors" role="alert"></div>



<!-- </form> -->


<script>
  var stripe = Stripe('pk_test_51HJiyRB7t32nrvfBTQUCwUWmFDeu07CklDnP41EahmYMDQYdMiYeYbEv3zFC1WtWQ3TbIw5XbFytlTq3wjjxKw9W004J5YdCJJ');
  var elements = stripe.elements();

  // Custom styling can be passed to options when creating an Element.
  // (Note that this demo uses a wider set of styles than the guide below.)
  var style = {
    base: {
      color: '#32325d',
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
    style: style,
    hidePostalCode: true
  });

  // Add an instance of the card Element into the `card-element` <div>.
  card.mount('#card-element');

  // Handle real-time validation errors from the card Element.
  card.on('change', function(event) {
    var displayError = document.getElementById('card-errors');
    if (event.error) {
      displayError.textContent = event.error.message;
    } else {
      displayError.textContent = '';
    }
  });

  // Handle form submission.
</script>