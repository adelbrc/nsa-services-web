var PUBLISHABLE_KEY = "pk_test_ez95S8pacKWv7L234McLkmLE00qanCpC2B";

// var DOMAIN = "http://nsaservices.local";
var DOMAIN = "http://localhost/ESGI/PA2020/nsa-services-web";

var stripe = Stripe(PUBLISHABLE_KEY);

// Handle any errors from Checkout
var handleResult = function(result) {
	if (result.error) {
		var displayError = document.getElementById("error-message");
		displayError.textContent = result.error.message;
	}
};

// cette fonction permet de rediriger vers le site de stripe avec l'id du plan
var redirectToCheckout = function(plan_id, service_id, uemail) {
	stripe.redirectToCheckout({
			items: [{ plan: plan_id, quantity: 1 }],
			successUrl:
				// "https://" +
				DOMAIN +
				"/mes_services.php?session_id={CHECKOUT_SESSION_ID}&type=service&sid=" + service_id,
				// "/success.php?session_id={CHECKOUT_SESSION_ID}&type=service&sid=" + service_id,
			// cancelUrl: "https://" + DOMAIN + "/canceled.html"
			cancelUrl: DOMAIN + "/services.php",
			customerEmail: uemail

		})
		.then(handleResult);
};
