function adoptPet(petId, buttonElement) {
  const userId = localStorage.getItem('userId');
  const token = localStorage.getItem('token');

  if (!userId || !token) {
    alert("Please log in or sign up to adopt a pet.");
    return;
  }

  console.log('Adoption request initiated for pet ID:', petId);

  fetch('http://localhost:80/pet-adoption-app/backend/adoptions/adopt', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Authorization': `Bearer ${token}`
    },
    body: JSON.stringify({
      user_id: userId,
      pet_id: petId
    })
  })
    .then(response => response.json())
    .then(data => {

      buttonElement.innerText = "Adoption Request Sent";
      buttonElement.disabled = true;
      buttonElement.classList.remove("btn-primary");
      buttonElement.classList.add("btn-success");

    })
    .catch(error => {
      console.error('Error during adoption:', error);
      alert('Failed to adopt pet. Please try again.');
    });
}

function loadAdoptionRequests() {
  console.log('Fetching pending adoption requests...');
  const token = localStorage.getItem('token');
  const tbody = document.getElementById('adoptionRequestsTableBody');

  if (!token) {
    console.warn('No token found in localStorage.');
    return;
  }

  if (!tbody) {
    console.warn('🟡 Skipping loadAdoptionRequests: #adoptionRequestsTableBody not found on this page.');
    return;
  }

  fetch('http://localhost:80/pet-adoption-app/backend/adoptions/pending', {
    headers: {
      'Authorization': `Bearer ${token}`
    }
  })
    .then(response => response.json())
    .then(data => {
      console.log('Data received:', data);
      tbody.innerHTML = '';

      if (data.length === 0) {
        const row = document.createElement('tr');
        row.innerHTML = `<td colspan="5" class="text-center text-muted">No pending requests found.</td>`;
        tbody.appendChild(row);
        return;
      }

      data.forEach(request => {
        const row = document.createElement('tr');
        row.innerHTML = `
          <td>${request.adoption_id}</td>
          <td>${request.user_name}</td>
          <td>${request.user_email}</td>
          <td>${request.pet_name}</td>
          <td>
            <button class="btn btn-success" onclick="approveAdoption(${request.adoption_id})">Approve</button>
          </td>
          <td>
            <button class="btn btn-secondary" onclick="rejectAdoption(${request.adoption_id})">Reject</button>
          </td>
        `;
        tbody.appendChild(row);
      });
    })
    .catch(err => {
      console.error('Error loading adoption requests:', err);
    });
}

loadAdoptionRequests();


function approveAdoption(adoptionId) {
  const token = localStorage.getItem('token');

  fetch(`http://localhost:80/pet-adoption-app/backend/adoptions/${adoptionId}/approve`, {
    method: 'PATCH',
    headers: {
      'Authorization': `Bearer ${token}`
    }
  })
    .then(response => {
      if (!response.ok) {
        return response.json().then(err => { throw new Error(err.message || 'Error approving adoption.'); });
      }
      return response.json();
    })
    .then(data => {
      alert(data.message || 'Adoption approved.');
      loadAdoptionRequests();
      if (typeof loadAdoptedPets === 'function') loadAdoptedPets();
    })
    .catch(error => {
      console.error('Error approving adoption:', error);
      alert("Failed to approve adoption. " + error.message);
    });
}


function loadAdoptedPets() {
  fetch('http://localhost:80/pet-adoption-app/backend/adoptions/approved')
    .then(res => res.json())
    .then(data => {
      const container = document.getElementById('adoptedPetsContainer');
      if (!container) return;

      if (!Array.isArray(data) || data.length === 0) {
        container.innerHTML = '<p class="text-muted text-center w-100">No adopted pets yet.</p>';
        return;
      }

      const html = data.map(pet => {
        const name  = pet.pet_name  || pet.name       || 'Unknown';
        const breed = pet.breed     || 'Unknown breed';
        const desc  = pet.description || 'Adopted into a loving home.';
        const img   = pet.image_url  || 'default.jpg';
        return `
          <div class="col-md-6 col-lg-3 ftco-animate">
            <div class="staff">
              <div class="img-wrap d-flex align-items-stretch">
                <div class="img align-self-stretch" 
                     style="background-image: url('../frontend/assets/images/${img}'); 
                            background-size: cover; background-position: center; height: 250px;">
                </div>
              </div>
              <div class="text pt-3 px-3 pb-4 text-center">
                <h3>${name}</h3>
                <span class="position mb-2">${breed}</span>
                <div class="faded"><p>${desc}</p></div>
              </div>
            </div>
          </div>`;
      }).join('');

      container.innerHTML = html;
    })
    .catch(err => console.error('Failed to load adopted pets:', err));
}



loadAdoptedPets();
