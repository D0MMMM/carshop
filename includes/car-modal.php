<div id="carModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Car Details</h2>
            <button class="close" id="closeModal" style="height: 15px; width: 15px"><i class="fa-solid fa-x"></i></button>
        </div>
        <div class="modal-body">
            <p id="modalDetails">
                <img id="carImage" style="margin-left: 4.5em; width: 30rem; height: 20rem" alt="Car Image"><br>
                <strong style="margin-left: 2em; margin-right: 1em; text-transform: uppercase">BRAND:</strong> <span id="carMake"></span><br>
                <strong style="margin-left: 2em; margin-right: 1em; text-transform: uppercase">Model:</strong> <span id="carModel"></span><br>
                <strong style="margin-left: 2em; margin-right: 2em; text-transform: uppercase">Year:</strong> <span id="carYear"></span><br>
                <strong style="margin-left: 2em; margin-right: 1em; text-transform: uppercase">Amount:</strong> <span id="carPrice"></span> PHP<br>
                <strong style="margin-left: 2em; margin-right: 1em; text-transform: uppercase">Condition:</strong> <span id="carCondition"></span><br>
                <strong style="margin-left: 2em; margin-right: 1em; text-transform: uppercase">About car:</strong> <span id="carDescription"></span>
            </p>
        </div>
        <div class="add-to-cart-btn">
            <form action="../backend/add_to_cart.php" method="POST">
                <input type="hidden" name="car_id" id="carIdInput">
                <button type="submit" class="add-to-cart-btn">
                    Add to Cart <i class="fa-solid fa-cart-shopping"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function openModal(carData) {
    const modal = document.getElementById('carModal');
    const carIdInput = document.getElementById('carIdInput');
    
    // Debug
    console.log('Car Data:', carData);
    
    // Populate modal fields
    document.getElementById('carImage').src = `../admin/asset/uploaded_img/${carData.image_path}`;
    document.getElementById('carMake').textContent = carData.make;
    document.getElementById('carModel').textContent = carData.model;
    document.getElementById('carYear').textContent = carData.year;
    document.getElementById('carPrice').textContent = `₱${parseFloat(carData.price).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
    document.getElementById('carCondition').textContent = carData.car_condition;
    document.getElementById('carDescription').textContent = carData.description;
    
    // Set the car_id
    carIdInput.value = carData.car_id;
    console.log('Setting car ID:', carData.car_id);
    
    modal.style.display = 'block';
}

// Close modal functionality
document.getElementById('closeModal').addEventListener('click', function() {
    document.getElementById('carModal').style.display = 'none';
});
</script>