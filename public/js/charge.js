var stripe = Stripe('pk_test_G5G9sEyqMgDgPD5OYpiwKpC1');

// Create an instance of Elements.
var elements = stripe.elements();

// Custom styling can be passed to options when creating an Element.
// (Note that this demo uses a wider set of styles than the guide below.)
var style = {
    base: {
        // Add your base input styles here. For example:
        fontSize: '16px',
        color: "#32325d",
    }
};

var options = {
    style: style,
    supportedCountries: ['SEPA'],
    // If you know the country of the customer, you can optionally pass it to
    // the Element as placeholderCountry. The example IBAN that is being used
    // as placeholder reflects the IBAN format of that country.
    placeholderCountry: 'NL',
}

// Create an instance of the card Element.
var iban = elements.create('iban', options);

// Add an instance of the card Element into the `card-element` <div>.
iban.mount('#iban-element');

// Handle real-time validation errors from the card Element.
iban.on('change', function(event) {
    var displayError = document.getElementById('error-message');
    if (event.error) {
        displayError.textContent = event.error.message;
    } else {
        displayError.textContent = '';
    }
});


// Handle form submission.


// Create a source or display an error when the form is submitted.
var form = document.getElementById('payment-form');

form.addEventListener('submit', function(event) {
    event.preventDefault();

    var sourceData = {
        type: 'sepa_debit',
        currency: 'eur',
        owner: {
            name: document.querySelector('input[name="name"]').value,
            email: document.querySelector('input[name="email"]').value,
        },
        mandate: {
            // Automatically send a mandate notification email to your customer
            // once the source is charged.
            notification_method: 'email',
        },
    };

    // Call `stripe.createSource` with the IBAN Element and additional options.
    stripe.createSource(iban, sourceData).then(function(result) {
        if (result.error) {
            // Inform the customer that there was an error.
            var errorElement = document.getElementById('error-message');
            errorElement.textContent = result.error.message;
        } else {
            // Send the Source to your server.
            stripeSourceHandler(result.source);
        }
    });
});

function stripeSourceHandler(source) {
    console.log(source);
    // Insert the Source ID into the form so it gets submitted to the server.
    var form = document.getElementById('payment-form');
    var hiddenInput = document.createElement('input');
    hiddenInput.setAttribute('type', 'hidden');
    hiddenInput.setAttribute('name', 'stripeSource');
    hiddenInput.setAttribute('value', source.id);
    form.appendChild(hiddenInput);

    // Submit the form.
    // form.submit();
}