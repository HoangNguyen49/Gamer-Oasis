// JavaScript to handle the modal population
// Get the modal
var modal = document.getElementById("myModal");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// Function to show customer details and open modal
function showCustomerDetails(userId, name, email, phone, address, createdAt) {
    document.getElementById('customerID').innerText = userId;
    document.getElementById('customerName').innerText = name;
    document.getElementById('customerEmail').innerText = email;
    document.getElementById('customerPhone').innerText = phone;
    document.getElementById('customerAddress').innerText = address;
    document.getElementById('registerDate').innerText = createdAt;

    // Show the modal
    modal.style.display = "block"; // Open the modal
}

// Close the modal when the user clicks on <span> (x)
span.onclick = function () {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
