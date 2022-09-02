<div class="form-group">
  <label for="formGroupExampleInput">@lang('home.amount')</label>
  <input type="text" class="form-control sum-section" id="cardamount" placeholder="@lang('home.amount')" readonly>
</div>
<div class="form-group">
  <label class='control-label'>@lang('home.name') @lang('home.on') @lang('home.card')</label>
  <input autocomplete='off' id="name_on_card" class='form-control card-number sumsection-input-text' size='20' type='text'>
</div>
<!-- <form action="/charge" method="post" id="payment-form"> -->


<div id="card-element">
  <!-- A Stripe Element will be inserted here. -->
</div>

<!-- Used to display form errors. -->
<div id="card-errors" role="alert"></div>



<!-- </form> -->

<button style="width:100%;" type="button" id="cardsubmitData" class="btn btn-danger btn-lg mt-5" name="button"> @lang('home.submit')<small><i>(cntl+s)</i></small></button>

<script>


  var stripe = Stripe('pk_test_51HJiyRB7t32nrvfBTQUCwUWmFDeu07CklDnP41EahmYMDQYdMiYeYbEv3zFC1WtWQ3TbIw5XbFytlTq3wjjxKw9W004J5YdCJJ');
  var elements = stripe.elements();

  // Custom styling can be passed to options when creating an Element.
  // (Note that this demo uses a wider set of styles than the guide below.)
  var style = {
    base: {
      color: '#fff',
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