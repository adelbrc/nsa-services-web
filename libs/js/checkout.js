var PUBLISHABLE_KEY = "pk_test_ez95S8pacKWv7L234McLkmLE00qanCpC2B";

var DOMAIN = "http://nsaservices.local";

var stripe = Stripe(PUBLISHABLE_KEY);

// Handle any errors from Checkout
var handleResult = function(result) {
  if (result.error) {
    var displayError = document.getElementById("error-message");
    displayError.textContent = result.error.message;
  }
};

// cette fonction permet de rediriger vers le site de stripe avec l'id du plan
var redirectToCheckout = function(id_product) {
  stripe
    .redirectToCheckout({
      items: [{ product: id_product, quantity: 1 }],
      successUrl:
        // "https://" +
        DOMAIN +
        "/pages_stripe/success.html?session_id={CHECKOUT_SESSION_ID}",
      // cancelUrl: "https://" + DOMAIN + "/canceled.html"
      cancelUrl: DOMAIN + "/pages_stripe/canceled.html"
    })
    .then(handleResult);
};
