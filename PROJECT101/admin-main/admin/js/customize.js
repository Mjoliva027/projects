var totalPrice = 0;

function nextStep(stepId) {
    var currentStep = document.getElementById(stepId);
    currentStep.style.display = "none";

    var nextStep = document.getElementById(stepId.substr(0, 5) + (parseInt(stepId.charAt(5)) + 1));
    if (nextStep) {
        nextStep.style.display = "block";

        // Calculate price for the current step and update total price
        var selectedOption = currentStep.querySelector("select[name='" + stepId.substr(0, 5) + "']").value;
        var price = parseFloat(selectedOption); // Assuming price is a numeric value
        if (!isNaN(price)) {
            totalPrice += price;
        }

        // Display the updated total price
        document.getElementById("totalPrice").innerText = "Total Price: $" + totalPrice.toFixed(2);
    } else {
        document.getElementById("customizationForm").submit();
    }
}