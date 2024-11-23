function openModal(carData) {
    const modal = document.getElementById('carModal');
    
    // Update modal content
    document.getElementById('carImage').src = `../admin/asset/uploaded_img/${carData.image_path}`;
    document.getElementById('carMake').textContent = carData.make;
    document.getElementById('carModel').textContent = carData.model;
    document.getElementById('carYear').textContent = carData.year;
    document.getElementById('carPrice').textContent = `₱${parseFloat(carData.price).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
    document.getElementById('carCondition').textContent = carData.car_condition;
    document.getElementById('carDescription').textContent = carData.description;
    document.getElementById('carIdInput').value = carData.car_id;
    
    modal.style.display = 'block';
}
